<?php
// =============================== Klasik Recent Posts widget ======================================
class Klasik_RecentPostsWidget extends WP_Widget {
    /** constructor */

	function Klasik_RecentPostsWidget() {
		$widget_ops = array('classname' => 'widget_klasik_recentposts', 'description' => __('KlasikThemes Recent Posts','klasik') );
		$this->WP_Widget('klasik-recentposts-widget', __('KlasikThemes Recent Posts','klasik'), $widget_ops);
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
		$disableimage = apply_filters('widget_disableimage', isset($instance['disableimage']));
		$disabledate = apply_filters('widget_disabledate', isset($instance['disabledate']));
		$disabletext = apply_filters('widget_disabletext', isset($instance['disabletext']));
		$disablemore = apply_filters('widget_disablemore', isset($instance['disablemore']));
		$readmoretext = apply_filters('widget_readmoretext', empty($instance['readmoretext']) ? '' : $instance['readmoretext']);
		$orderby = apply_filters('widget_orderby', empty($instance['orderby']) ? '' : $instance['orderby']);
		$order = apply_filters('widget_order', empty($instance['order']) ? '' : $instance['order']);
		
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

					$output .='<div class="klasik-recentpost-widget '.$customclass.'">';
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
								"ignore_sticky_posts" => true,
								"showposts" => $showposts,
								"orderby" => $orderby,
								"order" => $order
							);
							
							if($category == 0) $category = "";
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
							
							if ($wp_query->have_posts()) : 
								$x = 0;
								while ($wp_query->have_posts()) : $wp_query->the_post(); 
								
								$custom = get_post_custom($post->ID);
								$cf_thumb = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'alignleft'));
								
			
								$x++;
								
								if($x%$cols==0){
									$omega = "omega";
								}elseif($x%$cols==1){
									$omega = "alpha";
								}else{
									$omega = "";
								}
			
								
								$output .='<div class="'.$colclass.' columns '.$omega.'">';
									$output .='<div class="recent-item">';
									
									$custom = get_post_custom($post->ID);
									
									if(has_post_thumbnail($post->ID) ){
										$thumb = get_the_post_thumbnail($post->ID, 'widget-post', array('class' => 'frame'));
									}else{
										$thumb ="";
									}
									
									if($thumb!="" && !$disableimage){
										$output .= '<div class="recent-thumb">'.$thumb.'</div>';
									}
									

									$output .= '<h3 class="recent-title"><a href="'.get_permalink().'">'. get_the_title().'</a></h3>';
									if(!$disabledate){
										$output .= '<span class="smalldate">'. get_the_date() .'</span>';
									}
									$output .= '<div class="sep"></div>';

									if(!$disabletext){
									$output.='<div class="recent-text">';
										if($longdesc>0){
											$excerpt = klasik_string_limit_char(get_the_excerpt(), $longdesc);
										}else{
											$excerpt = get_the_excerpt();
										}
										$output.= $excerpt;
									$output.='</div>';
									}
									
									if(!$disablemore){
									$output.='<div class="recent-link">';
										if($readmoretext==''){
											$moretext = __('Read More','klasik');
										}else{
											$moretext = $readmoretext;
										}
										$output.= '<a href="'.get_permalink().'" class="more-link">'.$moretext.'</a>';
									$output.='</div>';
									}
									$output.='<div class="clear"></div>';
									
									$output.='</div>';
								$output .='</div>';
			
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
		$instance['disableimage'] = (isset($instance['disableimage']))? $instance['disableimage'] : "";
		$instance['disabledate'] = (isset($instance['disabledate']))? $instance['disabledate'] : "";
		$instance['disabletext'] = (isset($instance['disabletext']))? $instance['disabletext'] : "";
		$instance['disablemore'] = (isset($instance['disablemore']))? $instance['disablemore'] : "";
		$instance['readmoretext'] = (isset($instance['readmoretext']))? $instance['readmoretext'] : "";
		$instance['orderby'] = (isset($instance['orderby']))? $instance['orderby'] : "";
		$instance['order'] = (isset($instance['order']))? $instance['order'] : "";
					
        $title = esc_attr($instance['title']);
		$category = esc_attr($instance['category']);
		$cols = esc_attr($instance['cols']);
		$longdesc = esc_attr($instance['longdesc']);
		$customclass = esc_attr($instance['customclass']);
		$showpost = esc_attr($instance['showpost']);
		$disableimage = esc_attr($instance['disableimage']);
		$disabledate = esc_attr($instance['disabledate']);
		$disabletext = esc_attr($instance['disabletext']);
		$disablemore = esc_attr($instance['disablemore']);
		$readmoretext = esc_attr($instance['readmoretext']);
		$orderby = esc_attr($instance['orderby']);
		$order = esc_attr($instance['order']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			
            <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'klasik'); ?><br />
			<?php 
			$args = array(
			'selected'         => $category,
			'show_option_all'  => 'All Categories',
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

            <p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order By:', 'klasik'); ?> </label>
            <select name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>">
			<?php foreach ( $this->get_orderby_options() as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['orderby'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>
			</select>
            </p>

            <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:', 'klasik'); ?> 
            <select name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>">
			<?php foreach ( $this->get_order_options() as $k => $v ) { ?>
				<option value="<?php echo $k; ?>"<?php selected( $instance['order'], $k ); ?>><?php echo $v; ?></option>
			<?php } ?>
			</select>
            </p>

            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>
            
            <p>
			<?php if($instance['disableimage']){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                            <input type="checkbox" name="<?php echo $this->get_field_name('disableimage'); ?>" id="<?php echo $this->get_field_id('disableimage'); ?>" value="true" <?php echo $checked; ?> />			<label for="<?php echo $this->get_field_id('disableimage'); ?>"><?php _e('Disable Image', 'klasik'); ?> </label></p>
            
            <p>
			<?php if($instance['disabledate']){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                            <input type="checkbox" name="<?php echo $this->get_field_name('disabledate'); ?>" id="<?php echo $this->get_field_id('disabledate'); ?>" value="true" <?php echo $checked; ?> />			<label for="<?php echo $this->get_field_id('disabledate'); ?>"><?php _e('Disable Date', 'klasik'); ?> </label></p>
            
            <p>
			<?php if($instance['disabletext']){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                            <input type="checkbox" name="<?php echo $this->get_field_name('disabletext'); ?>" id="<?php echo $this->get_field_id('disabletext'); ?>" value="true" <?php echo $checked; ?> />			<label for="<?php echo $this->get_field_id('disabletext'); ?>"><?php _e('Disable Text', 'klasik'); ?> </label></p>
      		
            <p> 
			<?php if($instance['disablemore']){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                            <input type="checkbox" name="<?php echo $this->get_field_name('disablemore'); ?>" id="<?php echo $this->get_field_id('disablemore'); ?>" value="true" <?php echo $checked; ?> />			<label for="<?php echo $this->get_field_id('disablemore'); ?>"><?php _e('Disable More Text', 'klasik'); ?></label></p>
        	
            <p><label for="<?php echo $this->get_field_id('readmoretext'); ?>"><?php _e('Read More Text', 'klasik'); ?><input class="widefat" id="<?php echo $this->get_field_id('readmoretext'); ?>" name="<?php echo $this->get_field_name('readmoretext'); ?>" type="text" value="<?php echo $readmoretext; ?>" /> </label></p>

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
	
	protected function get_orderby_options () {
		return array(
					'date' 			=> __( 'Date', 'klasik' ),		
					'title' 		=> __( 'Title', 'klasik' ),
					'rand' 			=> __( 'Random Order', 'klasik' ),
					'none' 			=> __( 'No Order', 'klasik' )
					);
	} // End get_orderby_options()


	protected function get_order_options () {
		return array(
					'DESC' 			=> __( 'Descending', 'klasik' ),
					'ASC' 			=> __( 'Ascending', 'klasik' )
					);
	} // End get_order_options()

} // class  Widget