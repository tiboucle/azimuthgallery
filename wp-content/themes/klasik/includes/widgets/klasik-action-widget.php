<?php
// =============================== Klasik Call To Action widget ======================================
class Klasik_CallToActionWidget extends WP_Widget {
    /** constructor */

	function Klasik_CallToActionWidget() {
		$widget_ops = array('classname' => 'widget_klasik_action', 'description' => __('KlasikThemes CallToAction','klasik') );
		$this->WP_Widget('klasik-action-widget', __('KlasikThemes CallToAction','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $mtitle = apply_filters('widget_mtitle', empty($instance['mtitle']) ? '' : $instance['mtitle']);
		$subtitle = apply_filters('widget_subtitle', empty($instance['subtitle']) ? '' : $instance['subtitle']);
		$buttext1 = apply_filters('widget_buttext1', empty($instance['buttext1']) ? '' : $instance['buttext1']);
		$buturl1 = apply_filters('widget_buturl1', empty($instance['buturl1']) ? '' : $instance['buturl1']);
		$text = apply_filters('widget_text', empty($instance['text']) ? '' : $instance['text']);
		$buttext2 = apply_filters('widget_buttext2', empty($instance['buttext2']) ? '' : $instance['buttext2']);
		$buturl2 = apply_filters('widget_buturl2', empty($instance['buturl2']) ? '' : $instance['buturl2']);
		$customclass = apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		$linkbut = apply_filters('widget_linkbut', isset($instance['linkbut']));
		
		$disabletext = false;

        			 echo $before_widget; 
						
					$output = "";

					$output .='<div class="klasik-action-widget '.$customclass.'">';

						
							$tpl = '<div class="item-container">';
								$tpl .= '%%TITLE%% %%SUBTITLE%% %%TEXT%%';
								$tpl .= '<div class="action-button">%%BUTTON1%% %%BUTTON2%%</div>';
								$tpl .= '<div class="clear"></div>';
							$tpl .= '</div>';
							
							
							$tpl = apply_filters( 'klasik_actions_item_template', $tpl );
							

								
								$template = $tpl;
								
								
								//TITLE
								$maintitle  = '';
								if($mtitle){
								$maintitle .= '<h1>'.$mtitle.'</h1>';
								}
								$template = str_replace( '%%TITLE%%', $maintitle, $template );

								//SUBTITLE
								$maintitle  = '';
								if($subtitle){
								$maintitle .= '<h2>'.$subtitle.'</h2>';
								}
								$template = str_replace( '%%SUBTITLE%%', $maintitle, $template );
								
								// MAINTEXT
								$maintext = '';
								if($text){
								$maintext .= '<div>'.$text.'</div>';
								}
								$template = str_replace( '%%TEXT%%', $maintext, $template );
								
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
									
								
								// BUTTON1
								$mainbuttext1 = '';
								if($linkbut){
									$external = 'target="_blank"';
								}else{
									$external = '';
								}
								if($buttext1){
									$mainbuttext1 .= '<a href="' . $buturl1 . '" title="' . $buttext1 . '" ' . $external . ' class="button left">' . $buttext1 . '</a>';
								}
								$template = str_replace( '%%BUTTON1%%', $mainbuttext1, $template );
								

								// BUTTON2 
								$mainbuttext2 = '';
								if($linkbut){
									$external = 'target="_blank"';
								}else{
									$external = '';
								}
								if($buttext2){
									$mainbuttext2 .= '<a href="' . $buturl2 . '" title="' . $buttext2 . '" ' . $external . ' class="button right">' . $buttext2 . '</a>';	
								}
								$template = str_replace( '%%BUTTON2%%', $mainbuttext2, $template );
								

								$output .= $template;
								

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
        $mtitle = isset($instance['mtitle']) ? esc_attr($instance['mtitle']) : "";
		$subtitle = isset($instance['subtitle']) ? esc_attr($instance['subtitle']) : "";
		$buttext1 = isset($instance['buttext1']) ? esc_attr($instance['buttext1']) : "";
		$buturl1 = isset($instance['buturl1']) ? esc_attr($instance['buturl1']) : "";
		$buttext2 = isset($instance['buttext2']) ? esc_attr($instance['buttext2']) : "";
		$buturl2 = isset($instance['buturl2']) ? esc_attr($instance['buturl2']) : "";
		$customclass = isset($instance['customclass']) ? esc_attr($instance['customclass']) : "";
		
		$instance['linkbut'] = (isset($instance['linkbut']))? $instance['linkbut'] : "";
		
		$text = isset($instance['text']) ? esc_attr($instance['text']) : "";
		$linkbut = isset($instance['linkbut']) ? esc_attr($instance['linkbut']) : "";
		
        ?>
            <p><label for="<?php echo $this->get_field_id('mtitle'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('mtitle'); ?>" name="<?php echo $this->get_field_name('mtitle'); ?>" type="text" value="<?php echo $mtitle; ?>" /></label></p>
			
            <p><label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo $subtitle; ?>" /></label></p>
                        
            <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'klasik'); ?> <textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="10"><?php echo $text; ?></textarea>	</label></p>
            
            <p><label for="<?php echo $this->get_field_id('buttext1'); ?>"><?php _e('Button1 Text:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buttext1'); ?>" name="<?php echo $this->get_field_name('buttext1'); ?>" type="text" value="<?php echo $buttext1; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('buturl1'); ?>"><?php _e('Button1 URL:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buturl1'); ?>" name="<?php echo $this->get_field_name('buturl1'); ?>" type="text" value="<?php echo $buturl1; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('buttext2'); ?>"><?php _e('Button2 Text:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buttext2'); ?>" name="<?php echo $this->get_field_name('buttext2'); ?>" type="text" value="<?php echo $buttext2; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('buturl2'); ?>"><?php _e('Button2 URL:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('buturl2'); ?>" name="<?php echo $this->get_field_name('buturl2'); ?>" type="text" value="<?php echo $buturl2; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
            <p>
				<?php if($instance['linkbut']){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('linkbut'); ?>" id="<?php echo $this->get_field_id('linkbut'); ?>" value="true" <?php echo $checked; ?> />						<label for="<?php echo $this->get_field_id('linkbut'); ?>"><?php _e('Open URL to new window', 'klasik'); ?> </label></p>

        <?php
    }
		
} // class  Widget