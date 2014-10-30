<?php
/*---------------------------------------------------------------------------------*/
/* Search widget */
/*---------------------------------------------------------------------------------*/
class CoLabs_Product_Search extends WP_Widget {

   function CoLabs_Product_Search() {
	   $widget_ops = array('description' => 'Product Search widget.' );
       parent::WP_Widget(false, __('ColorLabs - Product Search', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
    extract( $args );
   	$title = apply_filters('widget_title', $instance['title'] );
	global $colabs_posttype;
	?>
		<?php echo $before_widget; 
		if ($title) { echo $before_title . $title . $after_title; } 
			$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url() ) . '">';		
			$form .= '<input type="text" class="widefat" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Search for products', 'colabsthemes') . '" />';
			$form .= '<input type="hidden" name="post_type" value="'.$colabs_posttype.'" />';
			$form .= '</form>';	
		if (is_plugin_active('jigoshop/jigoshop.php')){	
		echo apply_filters('jigoshop_product_search_form', $form, $instance, $this->id_base);	
		}else{
			echo $form;
		}
		echo $after_widget; ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {        
   
       $title = esc_attr($instance['title']);

       ?>
       <p>
	   	   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','colabsthemes'); ?></label>
	       <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
       </p>
      <?php
   }
} 

register_widget('CoLabs_Product_Search');
?>