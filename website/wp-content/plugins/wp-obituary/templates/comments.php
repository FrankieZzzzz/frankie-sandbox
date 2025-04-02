<?php
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$fields =  array(
	'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'wp-obituary' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
	'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'wp-obituary' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
);
 
$comments_args = array(
	'fields' 				=> $fields,
	'title_reply'			=> __('Leave Your Condolenc', 'wp-obituary'),
	'label_submit' 			=> __('Submit Condolence', 'wp-obituary'),
	'comment_field' 		=> '<p class="comment-form-comment"><label for="comment">' . _x( 'Condolence', 'noun' ) .
'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
'</textarea></p>',
	'comment_notes_before' => '<p class="comment-notes">' .
__( 'Please share your message of condolence with the family, It will be visible to the public but your email address will not be published. Required fields (*)', 'wp-obituary' ).'</p>',
);
?>
<div id="comments" class="comments-area obituary-comments">
	<div class="comment list">
		<h3><?php _e('Condolence Messages', 'wp-obituary'); ?></h3>
		<ol class="comment-list">
			
			<?php
			//global $wp_query;
			//var_dump($wp_query->query_vars['post_type']);

				//Gather comments for a specific page/post 
				$comments = get_comments( array(
					'post_id' => get_the_ID(),
					'status' => 'approve' //Change this to the type of comments to be displayed
				));
		
				//Display the list of comments
				wp_list_comments(array(
					'per_page' => 500, //Allow comment pagination
					'reverse_top_level' => false //Show the latest comments at the top of the list
				), $comments);
			?>
		</ol>
	</div><!-- comment list -->
	<div id="condolence-form">
		<?php comment_form( $comments_args ); ?>
	</div><!-- condolence-form -->
</div><!-- condolence-container -->