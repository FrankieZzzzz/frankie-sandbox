<?php

class WPML_Cornerstone_Tabs extends WPML_Cornerstone_Module_With_Items {

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'tab_label_content', 'tab_content' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		if ( 'tab_label_content' === $field ) {
			return esc_html__( 'Tabs: Tab Label', 'sitepress' );
		}

		if ( 'tab_content' === $field ) {
			return esc_html__( 'Tabs: Tab Content', 'sitepress' );
		}

		return '';
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		if ( 'tab_label_content' === $field ) {
			return 'LINE';
		} else {
			return 'VISUAL';
		}
	}
}