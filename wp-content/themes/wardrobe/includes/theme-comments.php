<?php
/*-----------------------------------------------------------------------------------*/
/* CoLabs - List Comment */
/*-----------------------------------------------------------------------------------*/
function colabs_list_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
?>

	<li <?php comment_class(); ?>>
		<div id="comment-<?php comment_ID(); ?>" class="comment-entry">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'colabsthemes' ); ?></em>
			<?php endif; ?>

			<div class="comment-author">
				<?php 
					$avatar_email = get_comment_author_email();
	 				$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 70 ) );
	 				echo $avatar;
 				?>
			</div>

			<div class="comment-content">
				<p>
					<span class="commenter-name"><?php echo get_comment_author_link(); ?></span> | 
					<span class="comment-date"><?php printf( __( '%1$s', 'colabsthemes' ), get_comment_date() ); ?></span> 
					<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => __( 'Reply Comment', 'colabsthemes' ),
						'depth' => $depth,
						'max_depth' => $args['max_depth']
					) ) ); ?>
				</p>
				<?php comment_text() ?>
			</div>
			
		</div>
  
<?php }


// Produces an avatar image with the hCard-compliant photo class
function commenter_link() {
 $commenter = get_comment_author_link();
 if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
  $commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
 } else {
  $commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
 }
 $avatar_email = get_comment_author_email();
 $avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 45 ) );
 echo $avatar;
} // end commenter_link

// Custom callback to list pings
function custom_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
      <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
       <div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'your-theme'),
         get_comment_author_link(),
         get_comment_date(),
         get_comment_time() );
         edit_comment_link(__('Edit', 'your-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'your-theme') ?>
            <div class="comment-content">
       <?php comment_text() ?>
   </div>
<?php } // end custom_pings
?>