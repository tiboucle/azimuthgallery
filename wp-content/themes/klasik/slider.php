<!-- SLIDER -->

                    
						<?php
					
						$output="";
						
						$defaultbg = get_stylesheet_directory_uri().'/images/bgslider.jpg';
						
                        //global $wp_query, $post;
						$args = array(
							'post_type' => 'post',
							'post_status' => 'publish',
							'showposts' => 5,
							'orderby' => 'date',
							'ignore_sticky_posts' => 1
						);
						
						$args["meta_query"] = array(
							array(
								'key' => 'klasik_slider_post',
								'value' => 'on',
								'compare' => '='
							)
						);
				
				
				
						global $wp_query;
						$temp = $wp_query;
						$wp_query= null;
						$wp_query = new WP_Query();
						$wp_query->query($args);
						global $post;
						
						$cf_bgslider="";
						
						if ($wp_query->have_posts()){
						
							$slidercount = $wp_query->post_count;
							
							if($slidercount > 1){
								echo '<div id="slideritems"> ';
							}
						
							while ($wp_query->have_posts()) : $wp_query->the_post(); 
							
							$custom = get_post_custom($post->ID);
							$cf_slideurl = (isset($custom["slider-link"][0]))?$custom["slider-link"][0] : "";
							$cf_disablelink = (isset($custom["disable-slider-link"][0]))? $custom["disable-slider-link"][0] : "";
							//$cf_bgslider = (isset($custom["slider-background"][0]))? $custom["slider-background"][0] : $defaultbg;
							$cf_subtitle = (isset($custom["slider-subtitle"][0]))? $custom["slider-subtitle"][0] : "";
							$cf_video = (isset($custom["slider-video"][0]))?$custom["slider-video"][0] : "";
							$cf_thumb = (isset($custom["slider-image"][0]))?$custom["slider-image"][0] : "";
							
							
							$output="";
							
							//slider images
							if(has_post_thumbnail( get_the_ID()) || $cf_thumb!=""){
								if($cf_thumb!=""){
									$cf_bgslider = $cf_thumb;
								}else{
									$postthumbnailid = get_post_thumbnail_id($post->ID);
									$sliderimgsrc = wp_get_attachment_image_src($postthumbnailid,'image-slider');
									$cf_bgslider = $sliderimgsrc[0];
								}
							}elseif($cf_video!=''){
								$cf_bgslider = get_template_directory_uri().'/images/trans.gif';
							}else{
								$cf_bgslider = $defaultbg;
							}
							
							if($slidercount > 1){
							
								$output .='<div class="slider-img" data-src="'.$cf_bgslider.'">';
									
								if($cf_video!=""){
									$output .= '<iframe id="slider-'.$post->ID.'" width="100%" height="100%" src="'.$cf_video.'" frameborder="0" allowfullscreen></iframe>';
								}else{
								
									if($cf_slideurl==""){
										$cf_slideurl = get_permalink();
									}
																	
									//slider text
									$output .='<div class="camera_caption '. KLASIK_SLIDERTEXTEFFECT .'">';
										$output  .='<div class="slider-title-wrap">';
											$output  .='<div class="postcategory">'. get_the_category_list(' ') .'</div><div class="clear"></div>';
											
											if($cf_slideurl!="" && !$cf_disablelink){
												$output .='<div class="slider-title"><span><a href="'.$cf_slideurl.'">' . get_the_title() . '</a></span></div>';
											}else{
												$output .='<div class="slider-title"><span>' . get_the_title() . '</span></div>';
											}
											
											if($cf_subtitle!=""){
												$output .='<div class="slider-subtitle "><span>' . $cf_subtitle . '</span></div>';
											}
										$output  .='</div>';
										if(get_the_content()!=""){
											$output .='<div class="slider-desc"><span>';
											$output .= get_the_excerpt();
											$output .='</span></div>';
										}
										$output .= '<a href="'.$cf_slideurl.'" class="slider-button "><span>'.__( 'Read More', 'klasik' ).'</span></a>';
										
									$output .='</div>';
								}
								
								$output .= '</div>';
							}else{
								if($cf_video!=""){
									$output .= '<iframe id="slider-'.$post->ID.'" class="video-static" width="100%" height="100%" src="'.$cf_video.'" frameborder="0" allowfullscreen></iframe>';
								}else{
									$output .= '<div class="slider-img"><img alt="image-slider" src="' . $cf_bgslider  . '"></div>';
								}
							
							}	
							

							echo $output;
							
							endwhile;

							if($slidercount > 1){	
								echo '</div>';
							}

						}else{
						
						 	echo '<div class="slider-img"><img alt="image-slider" src="' . $defaultbg  . '"></div>';
						
						}//endif
                        wp_reset_query();
                        ?>

<!-- END SLIDER -->