<div id="comments">

	<?php if ( have_comments() ) : ?>
		<div class="comment-header">
			<h4>
				<?php
				printf( _n( 'Comment %1$s', 'Comments %1$s', get_comments_number(), 'colabsthemes' ),
					'<span class="comment-count">( ' . number_format_i18n( get_comments_number() ) . ' )</span>' );
				?>
			</h4>
			<h4><?php _e( 'Have Something To Say ?', 'colabsthemes'); ?></h4>
			
		</div>

		<ol class="commentlist">
			<?php wp_list_comments( array(
				'type'			=> 'comment',
				'callback' 	=> 'colabs_list_comments',
				'max_depth'	=> 4
			) ); ?>
		</ol>
		
	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'colabsthemes' ); ?></p>
	<?php endif; ?>

	<?php //comment_form(); ?>

	<?php
	// Custom comment form
	$fields = array(
		'author'	=> '<p >
									<input id="author" name="author" type="text" placeholder="'.__('Name','colabsthemes').'" value="' . esc_attr( $commenter['comment_author'] ) . '" size=""' . $aria_req . ' />' . ( $req ? '' : '' ),
		'email'		=> '
									<input id="email" name="email" type="text" placeholder="'.__('Email','colabsthemes').'" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size=""' . $aria_req . ' />' . ( $req ? '' : '' ),
		'url'			=> '
									<input id="url" name="url" type="text" placeholder="'.__('Website','colabsthemes').'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="" />
									</p>'
	);

	comment_form(array(
		'comment_field'        => '<p class="comment-form-comment"><textarea placeholder="'.__('Type your comment here','colabsthemes').'" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply'          => __( 'Leave your comment here','colabsthemes' ),
		'title_reply_to'       => __( '' ),
		'label_submit'         => __( 'Post Comment' ,'colabsthemes'),
		'cancel_reply_link'    => __( 'Cancel' ,'colabsthemes'),
	));
	?>
	
</div><!-- #comments -->
