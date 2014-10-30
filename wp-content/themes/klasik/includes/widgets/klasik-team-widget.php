<?php
// =============================== Klasik Team widget ======================================
class Klasik_TeamWidget extends WP_Widget {
    /** constructor */

	function Klasik_TeamWidget() {
		$widget_ops = array('classname' => 'widget_klasik_team', 'description' => __('KlasikThemes Our Team','klasik') );
		$this->WP_Widget('klasik-team-widget', __('KlasikThemes Our Team','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$category = apply_filters('widget_category', $instance['category']);
		$cols = apply_filters('widget_cols', empty($instance['cols']) ? '' : $instance['cols']);
		$showposts = apply_filters('widget_showpost', empty($instance['showpost']) ? '' : $instance['showpost']);
		$longdesc = apply_filters('widget_longdesc', empty($instance['longdesc']) ? '' : $instance['longdesc']);
		$customclass = apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		$linktitle = apply_filters('widget_linktitle', isset($instance['linktitle']));
		$disabletext = false;
		
		$instance['category'] = esc_attr(isset($instance['category'])? $instance['category'] : "");
		global $wp_query;
		
		$longdesc = (!is_numeric($longdesc) || empty($longdesc))? 0 : $longdesc;
		$showposts = (!is_numeric($showposts))? get_option('posts_per_page') : $showposts;
		
		$cols = intval($cols);
		
		if(!is_numeric($cols) || $cols < 1 || $cols > 6){
			$cols = 4;
		}
		
        			 echo $before_widget; 
			  		if ( $title!='' )
                        echo $before_title . esc_html($title) . $after_title;
						
					$output = "";

					$output .='<div class="klasik-team-widget '.$customclass.'">';
						$output .='<div class="row">';

							if($cols==1){
								$colclass = "twelve";
							}elseif($cols==2){
								$colclass = "one_half";
							}elseif($cols==3){
								$colclass = "one_third";
							}elseif($cols==4){	
								$colclass = "one_fourth";
							}elseif($cols==5){
								$colclass = "one_fifth";
							}elseif($cols==6){
								$colclass = "one_sixth";
							}
							
							$temp = $wp_query;
							$wp_query= null;
							$wp_query = new WP_Query();
							$args = array(
								"post_type" => "post",
								"showposts" => $showposts
							);
							
							if( $category!="" ){
								$args['tax_query'] = array(
									array(
										'taxonomy' => 'category',
										'field' => 'id',
										'terms' => $category
									)
								);
							}
							
							$wp_query->query($args);
							global $post;
							
							
							$tpl = '<div id="team-%%ID%%" class="%%CLASS%%">';
								$tpl .= '<div class="item-container">';
									$tpl .= '<div class="team-image">%%THUMB%%</div>';
									$tpl .= '<div class="team-title-container">';
										$tpl .= '<h3 class="team-title">%%TITLE%%</h3>';
										$tpl .= '<div class="team-tag">%%TAG%%</div>';
									$tpl .= '</div>';
									
									$tpl .= '<div class="team-text">%%TEXT%%</div>';

									$tpl .= '<div class="clear"></div>';
								$tpl .= '</div>';
							$tpl .= '</div>';
							
							$tpl = apply_filters( 'klasik_teams_item_template', $tpl );
							
							if ($wp_query->have_posts()) : 
								$x = 0;
								while ($wp_query->have_posts()) : $wp_query->the_post(); 
								
								$template = $tpl;
								
								$custom = get_post_custom($post->ID);
								$cf_thumb = get_the_post_thumbnail($post->ID, 'widget-team', array('class' => ' team-img'));
								
								
								//TEAMID
								$template = str_replace( '%%ID%%', $post->ID, $template );
								
								//CLASS
								$x++;
								if($x%$cols==0){
									$omega = "omega";
								}elseif($x%$cols==1){
									$omega = "alpha";
								}else{
									$omega = "";
								}
								$teamclass = 'titem ';
								$teamclass .= $colclass.' columns ';
								$teamclass .= 'team'.$x.' ';
								$teamclass .= $omega;
								$template = str_replace( '%%CLASS%%', $teamclass, $template );
					
								//MAINIMAGE
								$mainimg = '';
								if($cf_thumb){
									$mainimg .= $cf_thumb;
								}
								$template = str_replace( '%%THUMB%%', $mainimg, $template );
								
								//TITLE
								$maintitle  = '';
								if($linktitle){
								$maintitle .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '" >' . get_the_title() . '</a>';
								}else{
								$maintitle .= get_the_title();
								}
								$template = str_replace( '%%TITLE%%', $maintitle, $template );
								
								//LINK
								$mainlink = get_permalink();
								$template = str_replace( '%%LINK%%', $mainlink, $template );
								
								//TAGS
								$maintags = "";
								$posttags = get_the_tags();
								$count=0;
								if ($posttags) {
								  foreach($posttags as $tag) {
									$count++;
									if (1 == $count) {
									  $maintags .= $tag->name . ' ';
									}
								  }
								}
								$template = str_replace( '%%TAG%%', $maintags, $template );
								
								//POST-DAY
								$postday  = '';
								$postday .= get_the_time( 'd' );
								$template   = str_replace( '%%DAY%%', $postday, $template );
								
								//POST-MONTH
								$postmonth  = '';
								$postmonth .= get_the_time('M');
								$template   = str_replace( '%%MONTH%', $postmonth, $template );
								
								//POST-YEAR
								$postyear  = '';
								$postyear .= get_the_time('Y');
								$template   = str_replace( '%%YEAR%', $postyear, $template );
								
								
								// MAINTEXT
								$maintext = '';
								if(!$disabletext){
									if($longdesc>0){
										$excerpt = klasik_string_limit_char(get_the_excerpt(), $longdesc);
									}else{
										$excerpt = get_the_excerpt();
									}
									$maintext .= $excerpt;
								}
								$template = str_replace( '%%TEXT%%', $maintext, $template );
								
								$output .= $template;
								endwhile;
						
							endif;
							$wp_query = null; $wp_query = $temp; wp_reset_query();
						$output .='</div>';
						$output.='<div class="clear"></div>';
					$output .='</div>';
						 
					echo do_shortcode($output);
					echo $after_widget; 

    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				

        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
		$instance['category'] = (isset($instance['category']))? $instance['category'] : "";
		$instance['cols'] = (isset($instance['cols']))? $instance['cols'] : "";
		$instance['showpost'] = (isset($instance['showpost']))? $instance['showpost'] : "";
		$instance['longdesc'] = (isset($instance['longdesc']))? $instance['longdesc'] : "";
		$instance['customclass'] = (isset($instance['customclass']))? $instance['customclass'] : "";
		$instance['linktitle'] = (isset($instance['linktitle']))? $instance['linktitle'] : "";
					
        $title = esc_attr($instance['title']);
		$category = esc_attr($instance['category']);
		$cols = esc_attr($instance['cols']);
		$longdesc = esc_attr($instance['longdesc']);
		$customclass = esc_attr($instance['customclass']);
		$showpost = esc_attr($instance['showpost']);
		$linktitle = esc_attr($instance['linktitle']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			
            <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'klasik'); ?><br />
			<?php 
			$args = array(
			'selected'         => $category,
			'echo'             => 1,
			'name'             =>$this->get_field_name('category')
			);
			wp_dropdown_categories( $args );
			?>
			</label></p>
            
            <p><label for="<?php echo $this->get_field_id('cols'); ?>"><?php _e('Number of Columns:', 'klasik'); ?></label><br />
            <select id="<?php echo $this->get_field_id('cols'); ?>" name="<?php echo $this->get_field_name('cols'); ?>" class="widefat" style="width:50%;">
				<?php foreach($this->get_number_options() as $k => $v ) { ?>
                    <option <?php selected( $instance['cols'], $k); ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php } ?>      
            </select></p>
            
            <p><label for="<?php echo $this->get_field_id('showpost'); ?>"><?php _e('Number of Post:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('showpost'); ?>" name="<?php echo $this->get_field_name('showpost'); ?>" type="text" value="<?php echo $showpost; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('longdesc'); ?>"><?php _e('Length of Description Text:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('longdesc'); ?>" name="<?php echo $this->get_field_name('longdesc'); ?>" type="text" value="<?php echo $longdesc; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
            <p>
				<?php if($instance['linktitle']){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('linktitle'); ?>" id="<?php echo $this->get_field_id('linktitle'); ?>" value="true" <?php echo $checked; ?> />						<label for="<?php echo $this->get_field_id('linktitle'); ?>"><?php _e(' Link Titles', 'klasik'); ?> </label></p>

        <?php
    }

	protected function get_number_options () {
		return array(
					'1' 			=> __( '1 Column', 'klasik' ),		
					'2' 			=> __( '2 Column', 'klasik' ),
					'3' 			=> __( '3 Column', 'klasik' ),
					'4' 			=> __( '4 Column', 'klasik' ),
					'5' 			=> __( '5 Column', 'klasik' ),
					'6' 			=> __( '6 Column', 'klasik' )
					);
	} // End get_number_options()

} // class  Widget