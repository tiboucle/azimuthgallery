<?php
// =============================== Klasik Page in Widget ======================================
class Klasik_PageinWidget extends WP_Widget {
    /** constructor */

	function Klasik_PageinWidget() {
		$widget_ops = array('classname' => 'widget_klasik_page', 'description' => __('KlasikThemes Page in Widget','klasik') );
		$this->WP_Widget('klasik-page-widget', __('KlasikThemes Page in Widget','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) 
    {	
        extract( $args );
        $title 		= isset($instance['title']) ? $instance['title'] : false;
        $id 		= (int) $instance['page_id'];
        $block 		= get_post( $id );
        $wpautop	= isset($instance['wpautop']) ? $instance['wpautop'] : false;
        
        $block_content = $block->post_content;
        if($wpautop == "on") { $block_content = wpautop($block_content); }
       
        ?>
          <?php echo $before_widget; ?>
              <?php if ( $title ) echo $before_title . $title . $after_title; ?>
				<div class="text-block <?php echo $block->post_name ?>"><?php echo apply_filters( 'text_blocks_widget_html', $block_content); ?></div>
          <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				

        return $new_instance;
    }
	
	

    /** @see WP_Widget::form */
    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : "";
		$wpautop = isset($instance['wpautop']) ? esc_attr($instance['wpautop']) : 0;
		$page_id = isset($instance['page_id']) ? esc_attr($instance['page_id']) : "";
		$customclass = isset($instance['customclass']) ? esc_attr($instance['customclass']) : "";
		
		
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			
                       
            <p><label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page:', 'klasik'); ?><br />
			<?php 
			$pageIdArgs = array(
				'selected' => $page_id,
				'name' => $this->get_field_name('page_id'),
			);
			wp_dropdown_pages( $pageIdArgs );
			?>
			</label></p>
            

            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
		<p>
			<input id="<?php echo $this->get_field_id('wpautop'); ?>" name="<?php echo $this->get_field_name('wpautop'); ?>" type="checkbox"<?php if($wpautop == "on") echo " checked='checked'"; ?>>&nbsp;
			<label for="<?php echo $this->get_field_id('wpautop'); ?>">Automatically add paragraphs</label>
		</p>

        <?php
    }

} // class  Widget