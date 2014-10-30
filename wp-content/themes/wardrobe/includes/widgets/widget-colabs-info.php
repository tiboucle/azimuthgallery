<?php
/*---------------------------------------------------------------------------------*/
/* Info widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_Info extends WP_Widget {

   function CoLabs_Info() {
	   $widget_ops = array('description' => 'Widget with a simple address information.' );
       parent::WP_Widget(false, __('ColorLabs - Address Info', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = apply_filters('widget_title', $instance['title'] );
	?>
		<?php echo $before_widget; ?>
        <?php if ($title) { echo $before_title . $title . $after_title; } 
		$text = '<div class="paper-block ducktape">';
		$text .= '<h5>' . $instance['title2'] . '</h5>';
		$text .= '<p>';
		if($instance['address']){
		$text .= $instance['address'] . '<br>';
		}
		if($instance['address']||$instance['state']||$instance['zip-code']){
		$text .= $instance['city'] . ', ' . $instance['state'] . ' ' . $instance['zip-code'] . '<br>';
		}
		if($instance['phone']){
		$text .= $instance['phone'] . '<br>';
		}
		$text .= $instance['email'];
		$text .= '</p>';
		
		 
		$text .= '</div>';
		
		echo $text . $after_widget;
		?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       $instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['title2'] = strip_tags( $new_instance['title2'] );

		$instance['address'] = $new_instance['address'];

		$instance['zip-code'] = $new_instance['zip-code'];

		$instance['state'] = $new_instance['state'];

		$instance['city'] = $new_instance['city'];
		
		$instance['phone'] = $new_instance['phone'];
		
		$instance['email'] = $new_instance['email'];

		return $instance;
   }

   function form($instance) {        
   
       $defaults = array( 
            'title' => __( 'Need Help?', 'colabsthemes' ),
            'title2' => 'Contact Us',
            'address' => 'Cemara 42 Street',
            'zip-code' => '1234',
            'state' => 'Jawa Barat',
            'city' => 'Bandung',
			'phone' => '+1 123.456.789',
			'email' => 'sales(at)yourstore.com'
        );
        
		$instance = wp_parse_args( (array) $instance, $defaults );

       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
	   <p>
			<label><?php _e( 'Other Title', 'colabsthemes' ) ?>:
				<textarea id="<?php echo $this->get_field_id( 'title2' ); ?>" name="<?php echo $this->get_field_name( 'title2' ); ?>" ><?php echo $instance['title2']; ?></textarea>
			</label>
        </p>             
		
		<p>
			<label><?php _e( 'Address', 'colabsthemes' ) ?>:
				<input type="text" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" />
			</label>
        </p>             
		
		<p>
			<label><?php _e( 'Zip Code', 'colabsthemes' ) ?>:
				<input type="text" id="<?php echo $this->get_field_id( 'zip-code' ); ?>" name="<?php echo $this->get_field_name( 'zip-code' ); ?>" value="<?php echo $instance['zip-code']; ?>" />
			</label>
        </p>             
		
		<p>
			<label><?php _e( 'State', 'colabsthemes' ) ?>:
				<input type="text" id="<?php echo $this->get_field_id( 'state' ); ?>" name="<?php echo $this->get_field_name( 'state' ); ?>" value="<?php echo $instance['state']; ?>" />
			</label>
        </p>             
		
		<p>
			<label><?php _e( 'City', 'colabsthemes' ) ?>:
				<input type="text" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php echo $instance['city']; ?>" />
			</label>
        </p> 
		<p>
			<label><?php _e( 'Phone', 'colabsthemes' ) ?>:
				<input type="text" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo $instance['phone']; ?>" />
			</label>
        </p> 
		<p>
			<label><?php _e( 'Email', 'colabsthemes' ) ?>:
				<input type="text" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" />
			</label>
        </p> 
      <?php
   }
} 

register_widget('CoLabs_Info');
?>