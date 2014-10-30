<?php
/*---------------------------------------------------------------------------------*/
/* Follow widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_Follow extends WP_Widget {

   function CoLabs_Follow() {
	   $widget_ops = array('description' => 'Follow widget.' );
       parent::WP_Widget(false, __('ColorLabs - Follow', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = apply_filters('widget_title', $instance['title'] );
	$twitter = $instance['twitter'];
	$facebook = $instance['facebook'];
	$gplus = $instance['gplus'];
	
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) { echo $before_title . $title . $after_title; }else {echo $before_title .__('Follow Us','colabsthemes'). $after_title;} ?>
		<?php if ($twitter!=''){?>	
			<a href="<?php echo $twitter;?>"><img src="<?php bloginfo("template_url")?>/images/icon/twitter.png"></a>
		<?php } ?>	
		<?php if ($facebook!=''){?>
			<a href="<?php echo $facebook;?>"><img src="<?php bloginfo("template_url")?>/images/icon/facebook.png"></a>
		<?php } ?>	
		<?php if ($gplus!=''){?>
			<a href="<?php echo $gplus;?>"><img src="<?php bloginfo("template_url")?>/images/icon/gplus.png"></a>
		<?php } ?>	
       
		<?php echo $after_widget; ?>
   <?php
   }

   function update($new_instance, $old_instance) {
       return $new_instance;
   }

   function form($instance) {
   
        $title = esc_attr($instance['title']);
		$twitter = esc_attr($instance['twitter']);
		$facebook = esc_attr($instance['facebook']);
		$gplus = esc_attr($instance['gplus']);
		
       ?>
        <p><?php _e( 'You can set your social id\'s in theme panel.','colabsthemes' );?></p>
		<p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','colabsthemes'); ?></label>
           <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
       </p>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
       </p>
	   <p>
	   	   <label for="<?php echo $this->get_field_id('gplus'); ?>"><?php _e('Google Plus:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('gplus'); ?>"  value="<?php echo $gplus; ?>" class="widefat" id="<?php echo $this->get_field_id('gplus'); ?>" />
       </p>
	  
      <?php
   }
} 

register_widget('CoLabs_Follow');
?>