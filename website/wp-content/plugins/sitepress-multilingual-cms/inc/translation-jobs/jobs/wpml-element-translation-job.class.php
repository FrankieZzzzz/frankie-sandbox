<?php

require_once WPML_TM_PATH . '/inc/translation-jobs/jobs/wpml-translation-job.class.php';

use WPML\FP\Obj;

abstract class WPML_Element_Translation_Job extends WPML_Translation_Job {

	protected $original_del_text;

	/** @var  WPML_Translation_Job_Factory $job_factory */
	protected $job_factory;

	private $original_doc_id = false;
	private $translation_id  = false;

	/**
	 * @param int                               $job_id
	 * @param null|int                          $batch_id
	 * @param null|TranslationManagement        $tm_instance
	 * @param null|WPML_Translation_Job_Factory $job_factory
	 */
	function __construct( $job_id, $batch_id = null, &$tm_instance = null, $job_factory = null ) {
		parent::__construct( $job_id, $batch_id, $tm_instance );
		$this->original_del_text = __( 'The original has been deleted!', 'sitepress' );
		$this->job_factory = $job_factory ?: wpml_tm_load_job_factory();
	}

	function get_type() {
		return 'Post';
	}

	function to_array() {
		$this->maybe_load_basic_data();
		$data_array                         = $this->basic_data_to_array( $this->basic_data );
		$data_array['id']                   = Obj::prop('job_id', $this->basic_data);
		$data_array['translation_id']       = Obj::prop('translation_id', $this->basic_data);
		$data_array['status']               = $this->get_status();
		$data_array['translation_edit_url'] = $this->get_url();
		$data_array['original_url']         = $this->get_url( true );
		$data_array['post_title']           = esc_html( $this->get_title() );

		return $data_array;
	}

	function to_xliff_file() {
		$xliff = new WPML_TM_Xliff_Writer( $this->job_factory );

		return $xliff->get_job_xliff_file( $this->get_id() );
	}

	function get_original_element_id() {
		if ( ! $this->original_doc_id ) {
			$this->original_doc_id = $this->get_iclt_field( 'element_id', false );
		}

		return $this->original_doc_id;
	}

	function get_translation_id() {
		if ( ! $this->translation_id ) {
			$translation_id       = $this->get_iclt_field( 'translation_id', true );
			$this->translation_id = $translation_id;
		} else {
			$translation_id = $this->translation_id;
		}

		return $translation_id;
	}

	/**
	 * Saves the job data in this object to the database (e.g. to a post)
	 *
	 * @param bool $complete whether or not to set the status
	 *                       of the target element to complete
	 */
	public function save_to_element( $complete = false ) {
		global $wpdb, $wpml_term_translations, $wpml_post_translations;

		$wpml_tm_records  = new WPML_TM_Records( $wpdb, $wpml_post_translations, $wpml_term_translations );
		$save_data_action = new WPML_Save_Translation_Data_Action(
			array(
				'job_id'   => $this->get_id(),
				'complete' => $complete,
				'fields'   => array(),
			),
			$wpml_tm_records
		);
		$save_data_action->save_translation();
	}

	/**
	 * @return int
	 */
	function estimate_word_count() {
		$fields          = $this->get_original_fields();
		$combined_string = join( ' ', $fields );
		$calculator      = new WPML_TM_Word_Calculator( new WPML_PHP_Functions() );
		return $calculator->count_words( $combined_string, $this->get_source_language_code() );
	}

	function get_original_fields() {
		global $wpdb;

		$fields = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT field_type, field_data, field_format
							 FROM {$wpdb->prefix}icl_translate
							 WHERE job_id = %d
							 	AND field_translate = 1",
				$this->get_id()
			)
		);

		$res = array();
		foreach ( $fields as $field ) {
			$res[ $field->field_type ] = base64_decode( $field->field_data );
		}

		return $res;
	}

	public function cancel() {
		global $wpdb;

		$deleted                = false;
		$rid_query              = "SELECT rid FROM {$wpdb->prefix}icl_translate_job WHERE job_id=%d";
		$rid_prepare            = $wpdb->prepare( $rid_query, array( $this->job_id ) );
		$rid                    = $wpdb->get_var( $rid_prepare );
		$translation_id_query   = "SELECT translation_id FROM {$wpdb->prefix}icl_translation_status WHERE rid=%d";
		$translation_id_prepare = $wpdb->prepare( $translation_id_query, array( $rid ) );
		$translation_id         = $wpdb->get_var( $translation_id_prepare );
		if ( $rid ) {
			$wpdb->delete( $wpdb->prefix . 'icl_translate_job', array( 'job_id' => $this->job_id ) );
			$wpdb->delete( $wpdb->prefix . 'icl_translate', array( 'job_id' => $this->job_id ) );
			$deleted = true;
		}

		if ( $translation_id ) {
			$wpdb->delete( $wpdb->prefix . 'icl_translations', array( 'translation_id' => $translation_id ) );
			if ( $rid ) {
				$wpdb->delete(
					$wpdb->prefix . 'icl_translation_status',
					array(
						'translation_id' => $translation_id,
						'rid'            => $rid,
					)
				);
			}
		}

		return $deleted;
	}

	/**
	 * @param TranslationProxy_Project $project
	 * @param int                      $translator_id
	 * @param WPML_TM_CMS_ID           $cms_id_helper
	 * @param TranslationManagement    $tm_instance
	 * @param null|string              $note
	 * @param array<string,string> | null $tp_batch_info
	 *
	 * @return array
	 */
	function send_to_tp( $project, $translator_id, &$cms_id_helper, &$tm_instance, $note = null, $tp_batch_info = null ) {
		global $wpdb;

		$this->maybe_load_basic_data();

		$file            = $this->to_xliff_file();
		$title           = $this->get_title();
		$cms_id          = $cms_id_helper->cms_id_from_job_id( $this->get_id() );
		$url             = $this->get_url( true );
		$word_count      = $this->estimate_word_count();
		$note            = isset( $note ) ? $note : '';
		$source_language = $this->get_source_language_code();
		$target_language = $this->get_language_code();
		$uuid            = $this->get_uuid();

		try {
			$tp_job_id = $project->send_to_translation_batch_mode( $file, $title, $cms_id, $url, $source_language, $target_language, $word_count, $translator_id, $note, $uuid, $tp_batch_info );
		} catch ( Exception $err ) {
			// The translation entry will be removed
			$project->errors[] = $err;
			$tp_job_id         = 0;
		}

		$translation_id = $this->get_translation_id();

		if ( $tp_job_id ) {
			$tm_instance->update_translation_status(
				array(
					'translation_id' => $translation_id,
					'translator_id'  => $translator_id,
					'status'         => ICL_TM_IN_PROGRESS,
					'needs_update'   => 0,
				)
			);
		} else {
			$previous_state = $wpdb->get_var(
				$wpdb->prepare(
					"	SELECT _prevstate
									FROM {$wpdb->prefix}icl_translation_status
									WHERE translation_id=%d
									LIMIT 1",
					$translation_id
				)
			);
			if ( ! empty( $previous_state ) ) {
				$previous_state = unserialize( $previous_state );
				$data           = array(
					'status'              => $previous_state['status'],
					'translator_id'       => $previous_state['translator_id'],
					'needs_update'        => $previous_state['needs_update'],
					'md5'                 => $previous_state['md5'],
					'translation_service' => $previous_state['translation_service'],
					'translation_package' => $previous_state['translation_package'],
					'timestamp'           => $previous_state['timestamp'],
					'links_fixed'         => $previous_state['links_fixed'],
				);
				$data_where     = array( 'translation_id' => $translation_id );
				$wpdb->update( $wpdb->prefix . 'icl_translation_status', $data, $data_where );
			} else {
				$data       = array(
					'status'       => ICL_TM_NOT_TRANSLATED,
					'needs_update' => 0,
				);
				$data_where = array( 'translation_id' => $translation_id );
				$wpdb->update( $wpdb->prefix . 'icl_translation_status', $data, $data_where );
			}
			$err = true;
		}

		return array( isset( $err ) ? $err : false, $project, $tp_job_id );
	}

	/**
	 * @param bool|false $original
	 *
	 * @return string
	 */
	abstract function get_url( $original = false );

	/**
	 * @return WP_Post|WPML_Package|mixed
	 */
	abstract function get_original_document();

	protected function load_status() {
		$this->maybe_load_basic_data();

		$status = ! empty( $this->basic_data->translated ) ? ICL_TM_COMPLETE : Obj::prop('status', $this->basic_data);

		return TranslationManagement::get_job_status_string( $status, Obj::prop( 'needs_update', $this->basic_data ) );
	}

	/**
	 * @param int $job_id
	 *
	 * @return bool|stdClass|WPML_Element_Translation_Job
	 */
	protected function load_job_data( $job_id ) {
		if ( $this->job_factory ) {
			return $this->job_factory->get_translation_job( $job_id, false, 1 );
		}

		return false;
	}

	protected function save_updated_assignment() {
		global $wpdb;

		$job_id                           = $this->get_id();
		$service                          = $this->get_translation_service();
		list( $prev_translator_id, $rid ) = $wpdb->get_row( $wpdb->prepare( "SELECT translator_id, rid FROM {$wpdb->prefix}icl_translate_job WHERE job_id=%d", $job_id ), ARRAY_N );

		$translator_id      = $this->get_translator_id();
		$assigned_correctly = $translator_id == $prev_translator_id;
		$assigned_correctly = apply_filters( 'wpml_job_assigned_to_after_assignment', $assigned_correctly, $job_id, $translator_id, $service );

		if ( $assigned_correctly ) {
			return true;
		}

		$data       = array(
			'translator_id'       => $translator_id,
			'status'              => ICL_TM_WAITING_FOR_TRANSLATOR,
			'translation_service' => $service,
		);
		$data_where = array( 'rid' => $rid );
		$wpdb->update( $wpdb->prefix . 'icl_translation_status', $data, $data_where );
		$wpdb->update( $wpdb->prefix . 'icl_translate_job', array( 'translator_id' => $translator_id ), array( 'job_id' => $job_id ) );

		return true;
	}

	/**
	 * Retrieves the batch ID for job elements using the
	 * `icl_translation_status` and `icl_translate_job` tables
	 */
	protected function load_batch_id() {
		global $wpdb;

		$this->batch_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT batch_id
				FROM {$wpdb->prefix}icl_translation_status as ts
				LEFT JOIN {$wpdb->prefix}icl_translate_job as tj ON tj.rid = ts.rid
				WHERE tj.job_id = %d AND tj.revision IS NULL
				LIMIT 1",
				$this->job_id
			)
		);
	}

	private function get_iclt_field( $field_name, $translation ) {
		global $wpdb;

		$column_name = ( $translation === true ? 'i' : 'o' ) . '.' . $field_name;

		$query          = "	SELECT {$column_name}
							FROM {$wpdb->prefix}icl_translations o
							JOIN {$wpdb->prefix}icl_translations i
								ON i.trid = o.trid
									AND i.source_language_code = o.language_code
							JOIN {$wpdb->prefix}icl_translation_status s
								ON s.translation_id = i.translation_id
							JOIN {$wpdb->prefix}icl_translate_job j
								ON j.rid = s.rid
							WHERE j.job_id = %d
							LIMIT 1";
		$args           = array( $this->get_id() );
		$prepared_query = $wpdb->prepare( $query, $args );
		return $wpdb->get_var( $prepared_query );
	}

	/**
	 * If the job does not have deadline date,
	 * we consider that the job was completed on time.
	 *
	 * @return bool
	 */
	public function is_completed_on_time() {
		return $this->get_number_of_days_overdue() <= 0;
	}

	/**
	 * @return false|int Negative integer if the job was completed before the deadline, or positive either.
	 *                   False is the job has no deadline date
	 */
	public function get_number_of_days_overdue() {
		$deadline  = $this->get_deadline_date();
		$completed = $this->get_completed_date();

		if ( ! $deadline ) {
			return false;
		}

		if ( ! $completed ) {
			$completed = strtotime( 'now' );
		} else {
			$completed = strtotime( $completed );
		}

		$deadline = strtotime( $deadline );

		return (int) floor( ( $completed - $deadline ) / DAY_IN_SECONDS );
	}

	/** @return string|null */
	public function get_deadline_date() {
		return $this->get_basic_data_property( 'deadline_date' );
	}

	/** @return string|null */
	public function get_completed_date() {
		return $this->get_basic_data_property( 'completed_date' );
	}

	/** @return string|null */
	public function get_manager_id() {
		return $this->get_basic_data_property( 'manager_id' );
	}

	/** @return string|null */
	protected function get_title_from_db() {
		return $this->get_basic_data_property( 'title' );
	}

	/** @return string|null */
	protected function get_uuid() {
		return $this->get_basic_data_property( 'uuid' );
	}
}
