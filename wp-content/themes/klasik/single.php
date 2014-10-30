<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */

get_header(); ?>
            
    <div id="singlepost">
    
         <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
			$custom = get_post_custom($post->ID);
			$cf_disablemeta = (isset($custom["klasik_disable_meta"][0]))? $custom["klasik_disable_meta"][0] : "";

			if($cf_disablemeta==""){
				$hasmetaclass = 'hasmeta';
			}else{
				$hasmetaclass = 'nometa';
			}
			?>
            
            <?php
			$format = get_post_format($post->ID);
			
			if(false === $format){
				$format = "standard";
			}
			
			$showtheimg = true;
			$showcontent = true;
			$showtitle = true;
			
            if(!is_search() && $showtheimg){

				$cf_thumb = (isset($custom["klasik_thumb"][0]))? $custom["klasik_thumb"][0] : "";
	
				$pregvid = preg_match_all('/(\<video.*\<\/video\>)/is', get_the_content(), $videos);
				$pregobj = preg_match_all('/(\<object.*\<\/object\>)/is', get_the_content(), $objects);
				$pregemb = preg_match_all('/(\<embed.*\<\/embed\>)/is', get_the_content(), $embeds);
				$pregaud = preg_match_all('/(\<audio.*\<\/audio\>)/is', get_the_content(), $audios);
				$pregifr = preg_match_all('/(\<iframe.*\<\/iframe\>)/is', get_the_content(), $iframes);
				$pregvsh = preg_match_all('/(\[video.*\[\/video\])/is', get_the_content(), $vshorts);
				$pregash = preg_match_all('/(\[audio.*\[\/audio\])/is', get_the_content(), $ashorts);
				$video = (isset($videos[1][0]))?$videos[1][0] : "";
				$object = (isset($objects[1][0]))?$objects[1][0] : "";
				$embed = (isset($embeds[1][0]))?$embeds[1][0] : "";
				$iframe = (isset($iframes[1][0]))?$iframes[1][0] : "";
				$vshort = isset($vshorts[1][0])? $vshorts[1][0]: "";
				$audio = (isset($audios[1][0]))?$audios[1][0] : "";
				$ashort = isset($ashorts[1][0])? $ashorts[1][0] : "";
				$media = "";
				$mediaaud = "";
				
				if(!empty($vshort)){
					$media = $vshort;
				}elseif(!empty($video)){
					$media = $video;
				}elseif(!empty($object)){
					$media = $object;
				}elseif(!empty($embed)){
					$media = $embed;
				}elseif(!empty($iframe)){
					$media = $iframe;
				}
				
				if(!empty($ashort)){
                    $mediaaud = $ashort;
                }elseif(!empty($audio)){
					$mediaaud = $audio;
				}
				
				//get post-thumbnail attachment
				$attachments = get_children( array(
				'post_parent' => $post->ID,
				'post_type' => 'attachment',
				'orderby' => 'menu_order',
				'post_mime_type' => 'image')
				);
				
				$cf_thumb2 = "";
				$lislides = "";
				$x = 0;
				$cols = 3;
				$colclass = 'four columns';
				foreach ( $attachments as $att_id => $attachment ) {
					$x++;
					
					if($x%$cols==0){
						$omega = "omega";
					}elseif($x%$cols==1){
						$omega = "alpha";
					}else{
						$omega = "";
					}
					
					$getimage = wp_get_attachment_image_src($att_id, 'thumb-blog', true);
					$theimage = $getimage[0];
					$cf_thumb2 = '<img src="'.$theimage.'" alt="'. get_the_title() .'" />';
					$lislides  .= '<div class="'.$colclass.' '.$omega.'">'.$cf_thumb2.'</div>';
				}
				
				$displayheader = "";
				
				if($format == "video"){
					$showcontent = false;
					if(!empty($media)){
						//$displayheader = '<div class="mediacontainer">'.do_shortcode($media).'</div>';
					}
				}elseif($format == "gallery"){
					$showcontent = false; 
					
					 $thethumblb = '';
					 foreach ( $attachments as $att_id => $attachment ) {
						$getimage = wp_get_attachment_image_src($att_id, 'large', true);
						$thumbimage  = $getimage[0];
						$thumbwidth  = $getimage[1];
						$thumbheight = $getimage[2];
						$cf_thumb2 ='<img src="'.$thumbimage.'" width="'. $thumbwidth .'" height="'. $thumbheight .'" alt="" />';
						$thethumblb .= '<li>'.$cf_thumb2.'</li>';
					 }
					 
					 if($thethumblb!=''){
						$thethumblb = '<div id="postgallery" class="flexslider"><ul class="slides">'. $thethumblb .'</ul><div class="clear"></div>  </div>';
					 }
					$displayheader .= $thethumblb;
				}elseif($format == "audio"){
					if($cf_thumb!=""){
						$cf_thumb = "<img src='" . $cf_thumb . "' alt='". get_the_title() ."' class='frame'  />";
					}elseif(has_post_thumbnail($post->ID)){
						$cf_thumb = get_the_post_thumbnail($post->ID, 'thumb-blog', array('class' => 'frame'));
					}else{
						$cf_thumb = $cf_thumb2;
					}
					$displayheader .= $cf_thumb;
				}elseif($format == "image"){
					if($cf_thumb!=""){
						$cf_thumb = "<img src='" . $cf_thumb . "' alt='". get_the_title() ."' class='frame'  />";
					}elseif(has_post_thumbnail($post->ID)){
						$cf_thumb = get_the_post_thumbnail($post->ID, 'thumb-blog', array('class' => 'frame'));
					}else{
						$cf_thumb = $cf_thumb2;
					}
					$displayheader .= $cf_thumb;
				}
				
				if($displayheader!=""){
					echo '<div class="postimg '.$hasmetaclass.'">';
						echo '<div class="thumbcontainer">';
							echo $displayheader;
							echo '<div class="clear"></div>';
						echo '</div>';
					echo '</div>';
				}
				echo '<div class="clear"></div>';
				
			}// end if(!is_search())
            
			?>
            
             
            <?php
			 	if($cf_disablemeta==""){
			?>
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
			<?php
			}
			?>
            
            <div class="entry-content <?php echo $hasmetaclass; ?>">
                <?php
                $custom = get_post_custom($post->ID);
                $showcontent = true;
				if(!$showcontent){
					the_excerpt();
				}else{
                	the_content();
					wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) );
				}
                ?>
             </div> 

            <div class="clear"></div><!-- clear float --> 
         </article>
         
             <?php if($cf_disablemeta==""){?>
             
                 <div class="entry-tag">
                    <?php
                    $posttags = get_the_tags();
                    if($posttags){
                    ?>
                    <span class="tag-text"><?php _e('Tags :','klasik'); ?></span>
                    <?php 
                    the_tags('<div class="tag-items"><span>','</span><span>','</span></div>'); 
                    } 
                    ?>
                 </div>
                 
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'klasik' ), TRUE ); ?></div>
                    <div class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'klasik' ), TRUE ); ?></div>
                    <div class="clear"></div><!-- clear float --> 
                </div><!-- #nav-below -->
                
             <?php } ?>
         
        <?php

        // If a user has filled out their description, show a bio on their entries.
        if ( get_the_author_meta( 'description' ) && $cf_disablemeta=="" ) : ?>
        <div id="entry-author-info">
        	<h2 class="author-title"><?php _e('About Author','klasik'); ?></h2>
            <div class="clear"></div>
            <div id="author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'klasik_author_bio_avatar_size', 80 ) ); ?>
            </div><!-- author-avatar -->
            
            <div id="author-description">
                <h2><span class="author"><?php printf( __( 'About %s', 'klasik' ), get_the_author() ); ?></span></h2>
                <?php the_author_meta( 'description' ); ?>
            </div><!-- author-description	-->
            <div class="clear"></div><!-- clear float --> 
        </div><!-- entry-author-info -->
        <?php endif; ?>

        <?php comments_template( '', true ); ?>
        
        <?php endwhile; ?>
    
    </div><!-- singlepost --> 
    <div class="clear"></div><!-- clear float --> 

<?php get_footer(); ?>