<?php

// =============================== Klasik Image Carousel widget ======================================
class Klasik_PCarouselWidget extends WP_Widget {
    /** constructor */

	function Klasik_PCarouselWidget() {
		$widget_ops = array('classname' => 'widget_klasik_pcarousel', 'description' => __('KlasikThemes Image Carousel','klasik') );
		$this->WP_Widget('klasik-pcarousel-widget', __('KlasikThemes Image Carousel','klasik'), $widget_ops);
	}


  /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$mediaid = apply_filters('widget_mediaid', empty($instance['mediaid']) ? '' : $instance['mediaid']);
		$customclass = apply_filters('widget_customclass', empty($instance['customclass']) ? '' : $instance['customclass']);
		
		$instance['category'] = esc_attr(isset($instance['category'])? $instance['category'] : "");
		
		global $wp_query;

		  echo $before_widget; 
				if ( $title!='' )
					echo $before_title . esc_html($title) . $after_title;
					
				$cf_imagecarousel = $mediaid;
				
				if($cf_imagecarousel!=""){
					$include = $cf_imagecarousel;
					$arrinclude = explode(',',$cf_imagecarousel);
					$orderby = 'post__in';
					$order = 'ASC';
					
					if(count($arrinclude)==1){
						$postobj = get_post($include);
						$id = $postobj->ID;
						
						if($postobj){
							if($postobj->post_type!='attachment'){
								$_attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
							}else{
								$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
							}
						}else{
							$_attachments = array();
						}
					}elseif(count($arrinclude)>1){
						$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
					}else{
						$_attachments = array();
					}
					
					$attachments = array();
					foreach ($_attachments as $key => $val) {
					  $attachments[$val->ID] = $_attachments[$key];
					}
					
					$tpl = '<li>%%IMAGE%%</li>';
					$tpl = apply_filters( 'klasik_pcarousel_item_template', $tpl );
					
					if(count($attachments)){
				?>

					<div class="flexslider-carousel row <?php echo $customclass; ?>">
                    <ul class="slides">
					<?php
                    
                     foreach ($attachments as $id => $attachment) {
                     	
						$template = $tpl;
						
                        $link = wp_get_attachment_image($id, 'widget-carousel', false, false);
                        $image_attributes = wp_get_attachment_image_src($id, 'full', false);// returns an array
						
						$alttext = get_post_meta( $attachment->ID , '_wp_attachment_image_alt', true);
						$image_title = $attachment->post_title;
						$caption = $attachment->post_excerpt;
						$description = $attachment->post_content;
						
						//IMAGEID
						$template = str_replace( '%%ID%%', $attachment->ID, $template );
						
						//IMAGESRC
						$template = str_replace( '%%IMAGE%%', $link, $template );
						
						//IMAGETITLE
						$template = str_replace( '%%TITLE%%', $image_title, $template );
						
						//IMAGEALT
						$template = str_replace( '%%ALT%%', $alttext, $template );
						
						//IMAGECAPTION
						$template = str_replace( '%%CAPTION%%', $caption, $template );
						
						//IMAGEDESC
						$template = str_replace( '%%DESC%%', $description, $template );
						
						//PORTFOLIOFULLIMAGE
						$pffullimg = (isset($image_attributes[0]))? $image_attributes[0] : '';
						$template = str_replace( '%%FULLIMG%%', $pffullimg, $template );
						
						echo $template;

                     }
                    ?>
                    </ul>
                    </div>
				<?php
					}
				}

		  echo $after_widget;

    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				

        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$instance['title'] = (isset($instance['title']))? $instance['title'] : "";
		$instance['mediaid'] = (isset($instance['mediaid']))? $instance['mediaid'] : "";
		$instance['customclass'] = (isset($instance['customclass']))? $instance['customclass'] : "";
					
        $title = esc_attr($instance['title']);
		$mediaid = esc_attr($instance['mediaid']);
		$customclass = esc_attr($instance['customclass']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

            <p><label for="<?php echo $this->get_field_id('mediaid'); ?>"><?php _e('Media IDs:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('mediaid'); ?>" name="<?php echo $this->get_field_name('mediaid'); ?>" type="text" value="<?php echo $mediaid; ?>" /></label></p>
            
            <p><label for="<?php echo $this->get_field_id('customclass'); ?>"><?php _e('Custom Class:', 'klasik'); ?> <input class="widefat" id="<?php echo $this->get_field_id('customclass'); ?>" name="<?php echo $this->get_field_name('customclass'); ?>" type="text" value="<?php echo $customclass; ?>" /></label></p>

        <?php
    }


} // class  Widget