<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">
            <div class="entry-audio">
				<?php
                $custom = get_post_custom($post->ID);
				$cf_thumb = (isset($custom["klasik_thumb"][0]))? $custom["klasik_thumb"][0] : "";
                $pregaud = preg_match_all('/(\<audio.*\<\/audio\>)/is', get_the_content(), $audios);
				$pregash = preg_match_all('/(\[audio.*\[\/audio\])/is', get_the_content(), $ashorts);
                $audio = isset($audios[1][0])? $audios[1][0] : "";
				$ashort = isset($ashorts[1][0])? $ashorts[1][0] : "";
                $media = "";
                
                if(!empty($ashort)){
                    $media = $ashort;
                }elseif(!empty($audio)){
                    $media = $audio;
                }
                
                $mediahtml = '';
                if(!empty($media)){
                    $mediahtml = '<div class="mediacontainer">'.do_shortcode($media).'</div>';
                }
                ?>


				<?php
				
                //get post-thumbnail attachment
                $attachments = get_children( array(
                'post_parent' => $post->ID,
                'post_type' => 'attachment',
                'orderby' => 'menu_order',
                'post_mime_type' => 'image')
                );
				
				$cf_thumb2 ='';
                foreach ( $attachments as $att_id => $attachment ) {
                    $getimage = wp_get_attachment_image_src($att_id, 'entry-image', true);
                    $theimage = $getimage[0];
                    $cf_thumb2 ='<img src="'.$theimage.'" alt="" />';
                }
                 
                
                //thumb image
                if($cf_thumb!=""){
                    $cf_thumb = "<img src='" . $cf_thumb . "' alt='". get_the_title() ."'  />";
                }elseif(has_post_thumbnail($post->ID)){
                    $cf_thumb = get_the_post_thumbnail($post->ID, 'entry-image');
                }else{
                    $cf_thumb = $cf_thumb2;
                }
				
                $thumbhtml = '';
                if($cf_thumb!=""){
                    $thumbhtml .= '<div class="postimg">';
                        $thumbhtml .= '<div class="thumbcontainer">';
                            $thumbhtml .= '<a href="'.get_permalink($post->ID).'">'.$cf_thumb.'</a>';
                            $thumbhtml .= '<div class="clear"></div>';
                        $thumbhtml .= '</div>';
                    $thumbhtml .= '</div>';
                }
				?>    
                <?php echo $thumbhtml; ?>            
                <?php echo $mediahtml; ?>
                
                <h2 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'klasik' ), the_title_attribute( 'echo=0' ) ); ?>" data-rel="bookmark"><?php the_title(); ?></a></h2>
                
                <div class="entry-utility">
                    <div class="date"> <?php the_time(get_option('date_format')); ?></div>  <span class="text-sep text-sep-date">/</span>
                    <div class="user"><?php _e('by','klasik'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php the_author();?></a></div> <span class="text-sep text-sep-user">/</span>
                    <div class="category"><?php _e('in','klasik'); ?> <?php the_category(', '); ?></div>  
						<?php 
                            $css_class = 'zero-comments';
                            $number    = (int) get_comments_number( get_the_ID() );
                            
                            if ( 1 === $number )
                                $css_class = 'one-comment';
                            elseif ( 1 < $number )
                                $css_class = 'multiple-comments';
                        ?>
                         <span class="text-sep <?php echo $css_class; ?> text-sep-category">/</span>
                         <div class="comment <?php echo $css_class; ?>">
                             <?php 
							
								comments_popup_link( 
									__( 'No Comments', 'klasik' ), 
									__( '1 Comment', 'klasik' ), 
									__( '% Comments', 'klasik' ),
									$css_class,
									__( 'Comments Closed', 'klasik' )
								);
							 ?>
                        </div>
                    <div class="clear"></div>  
                </div>  
            
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" class="more"><?php _e('Read More','klasik'); ?></a>
                </div>
                
 
                
            </div>
        	<div class="clear"></div>
        </div>
		<div class="clear"></div>
	</article><!-- end post -->
    
    
