<?php
// =============================== Klasik Woocommerce Product widget ======================================
class Klasik_WooProductWidget extends WP_Widget {
    /** constructor */

	function Klasik_WooProductWidget() {
		$widget_ops = array('classname' => 'widget_klasik_wooproduct', 'description' => __('KlasikThemes WooCommerce Products','klasik') );
		$this->WP_Widget('klasik-theme-wooproduct-widget', __('KlasikThemes WooCommerce Products','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$showposts = apply_filters('widget_showpost', empty($instance['showpost']) ? '' : $instance['showpost']);
		$type = apply_filters('widget_type', empty($instance['type']) ? '' : $instance['type']);
		$customclass = apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		$show_variations = $instance['show_variations'] ? '1' : '0';
		
		global $wp_query, $woocommerce;
        ?>
              <?php echo $before_widget; 
			  		if ( $title!='' )
                        echo $before_title . esc_html($title) . $after_title;
					
					$showposts = (!is_numeric($showposts))? get_option('posts_per_page') : $showposts;
					$categories = $cats;
					
					echo '<div class="klasik-product woocommerce '.$customclass.'">';
					
						$temp = $wp_query;
						$wp_query= null;
						$wp_query = new WP_Query();
						
						if($type=='latest-product'){
						
							$query_args = array('posts_per_page' => $showposts, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
	
							$query_args['meta_query'] = array();
					
							if ( $show_variations == '0' ) {
								$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
								$query_args['parent'] = '0';
							}
					
							$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
							$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
						
						}elseif($type=='featured-product'){
							$query_args = array('posts_per_page' => $showposts, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );
							$query_args['meta_query'] = $woocommerce->query->get_meta_query();
							$query_args['meta_query'][] = array(
								'key' => '_featured',
								'value' => 'yes'
							);
						}else{
							$query_args = array(
								'posts_per_page' => $showposts,
								'post_status' 	 => 'publish',
								'post_type' 	 => 'product',
								'meta_key' 		 => 'total_sales',
								'orderby' 		 => 'meta_value_num',
								'no_found_rows'  => 1,
							);
					
							$query_args['meta_query'] = $woocommerce->query->get_meta_query();
					
							if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {
								$query_args['meta_query'][] = array(
									'key'     => '_price',
									'value'   => 0,
									'compare' => '>',
									'type'    => 'DECIMAL',
								);
							}
						}
						$wp_query->query($query_args);
						global $post;
						
						if ($wp_query->have_posts()) : 
							$x = 0;
							$output = "";
							echo '<ul class="row products">';
							while ($wp_query->have_posts()) : $wp_query->the_post(); 
								
								woocommerce_get_template_part( 'content', 'product' );
								
								$x++;
							endwhile;
							echo '</ul>';
							$wp_query = null; $wp_query = $temp; wp_reset_query();
						endif;
						$wp_query = null; $wp_query = $temp; wp_reset_query();
						echo '<div class="clear"></div>';
					echo '</div>';
				?>
			
              <?php echo $after_widget; ?>
			 
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				

        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
		$instance['showpost'] = (isset($instance['showpost']))? $instance['showpost'] : "";
		$instance['type'] = (isset($instance['type']))? $instance['type'] : "";
		$instance['customclass'] = (isset($instance['customclass']))? $instance['customclass'] : "";
		
		$show_variations = isset( $instance['show_variations'] ) ? (bool) $instance['show_variations'] : false;
		$hide_free_checked = ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) ? ' checked="checked"' : '';
		
        $title = esc_attr($instance['title']);
		$type = esc_attr($instance['type']);
		$showpost = esc_attr($instance['showpost']);
		$customclass = esc_attr($instance['customclass']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('showpost'); ?>"><?php _e('Number of Post:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('showpost'); ?>" name="<?php echo $this->get_field_name('showpost'); ?>" type="text" value="<?php echo $showpost; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Widget Type:', 'klasik'); ?> 
            <select class="" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
            	<option value="latest-product" <?php echo ($type=='latest-product')? 'selected="selected"' : ''; ?>><?php _e('Latest Product','klasik'); ?></option>
                <option value="featured-product" <?php echo ($type=='featured-product')? 'selected="selected"' : ''; ?>><?php _e('Featured Product','klasik'); ?></option>
                <option value="bestseller-product" <?php echo ($type=='bestseller-product')? 'selected="selected"' : ''; ?>><?php _e('Best-Selling Product','klasik'); ?></option>
            </select>
           </label></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
            <p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id('show_variations') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_variations') ); ?>"<?php checked( $show_variations ); ?> />
		<label for="<?php echo $this->get_field_id('show_variations'); ?>"><?php _e( 'Show hidden product variations', 'klasik' ); ?></label></p>
        
        <p><input id="<?php echo esc_attr( $this->get_field_id('hide_free') ); ?>" name="<?php echo esc_attr( $this->get_field_name('hide_free') ); ?>" type="checkbox"<?php echo $hide_free_checked; ?> />
			<label for="<?php echo $this->get_field_id('hide_free'); ?>"><?php _e( 'Hide free products', 'klasik' ); ?></label></p>
            
        <?php
    }

} // class  Widget