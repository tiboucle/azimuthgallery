<?php
/*---------------------------------------------------------------------------------*/
/* Best Seller widget */
/*---------------------------------------------------------------------------------*/
class Colabs_Best_Sellers_Widget extends WP_Widget {

   function Colabs_Best_Sellers_Widget() {
	   $widget_ops = array('description' => 'Show Best Sellers Products.' );
       parent::WP_Widget(false, __('ColorLabs - Best Sellers Product', 'colabsthemes'),$widget_ops);      
   }

   function widget($args, $instance) {  
   wp_reset_query();
    global $wpdb;
		
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Best Sellers' : $instance['title']);
		$txt_img = empty($instance['image']) ? 'text' : $instance['image'];
		
			
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;
		global $plugin,$wpdb;
		if($plugin=='wpsc'){
			$sql = "SELECT DISTINCT prodid, name, count(prodid) as prodnum from " . $wpdb->prefix. "wpsc_cart_contents group by prodid order by prodnum DESC LIMIT ".$number;
			$bests = $wpdb->get_results($sql);

			if($bests){
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			echo '<ul class="product_list_widget">';
			foreach($bests as $best) {
				$prod_id=$best->prodid;	
				?>
				<li>
				<?php if($txt_img=='enable')colabs_image('width=80&height=80&id='.$prod_id);?>
				<a href="<?php echo get_permalink($prod_id);?>">
					<?php echo get_the_title($prod_id);?>
				</a> <?php echo colabs_the_product_price(false,false,$prod_id);?>
				</li>
				<?php
			}
			echo '</ul>';
			echo $after_widget;
			}
		}else if($plugin=='jigoshop'){
			$sql = "SELECT $wpdb->posts.ID AS ID
			FROM $wpdb->posts
			WHERE $wpdb->posts.post_status = 'publish' 
			AND $wpdb->posts.post_type = 'shop_order' LIMIT $number ";
			$bests = $wpdb->get_results($sql);
			$best_id=array();
				foreach($bests as $best) {
					$order_items = (array) maybe_unserialize( get_post_meta($best->ID, 'order_items', true) );
					foreach ($order_items as $item){
					$best_id[]=$item['id'];
					}
				}
				$result = array_unique($best_id);
				$counts = count($result);
			if($best_id){
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			echo '<ul class="product_list_widget">';
			for ($z=0;$z<$counts;$z++){
				$prod_id=$result[$z];	
				$_product = &new jigoshop_product($prod_id);
				?>
				<li>
				<?php if($txt_img=='enable')colabs_image('width=80&height=80&id='.$prod_id);?>
				<a href="<?php echo get_permalink($prod_id);?>">
					<?php echo get_the_title($prod_id);?>
				</a> <?php echo $_product->get_price_html();?>
				</li>
				<?php
			}
			echo '</ul>';
			echo $after_widget;
			}
		
		}else if($plugin=='woo'){
    	$query_args = array(
    		'showposts' 	=> $number, 
    		'nopaging' 		=> 0, 
    		'post_status' 	=> 'publish', 
    		'post_type' 	=> 'product',
    		'meta_key' 		=> 'total_sales',
    		'orderby' 		=> 'meta_value'
    	);

		$r = new WP_Query($query_args);
		
		if ($r->have_posts()) :
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="product_list_widget">
		<?php  while ($r->have_posts()) : $r->the_post(); $_product = &new woocommerce_product(get_the_ID()); ?>
		<li>
			<?php if($txt_img=='enable')colabs_image('width=80&height=80');?>
			<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
			<?php if ( get_the_title() ) the_title(); else the_ID(); ?>
		</a> <?php echo $_product->get_price_html(); ?></li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
		endif;	
    	}		
		
   }

   function update($new_instance, $old_instance) {                
       $instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['image'] = strip_tags(stripslashes($new_instance['image']));
		$instance['number'] = strip_tags(stripslashes($new_instance['number']));
		
		return $instance;
   }

   function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Best Sellers', 'image'=>'enable', 'best_sellers_id'=>'') );
		
		$title = htmlspecialchars($instance['title']);
		$txt_img = htmlspecialchars($instance['image']);
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) $number = 5;
		
		# Output the options
		echo '<p><label for="' . $this->get_field_name('title') . '">' . __('Title:') . ' </label> <input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Text or Image
		if ($txt_img == "enable"){
		   $text = '<INPUT TYPE=RADIO ' . 'id="' . $this->get_field_id('image') . '" NAME="' . $this->get_field_name('image') . '" VALUE="enable" CHECKED>Enable';
		   $image = '<INPUT TYPE=RADIO ' . 'id="' . $this->get_field_id('image') . '" NAME="' . $this->get_field_name('image') . '" VALUE="image">Disable';		   
		}
		else{
		   $text = '<INPUT TYPE=RADIO ' . 'id="' . $this->get_field_id('image') . '" NAME="' . $this->get_field_name('image') . '" VALUE="enable">Enable';			
		   $image = '<INPUT TYPE=RADIO ' . 'id="' . $this->get_field_id('image') . '" NAME="' . $this->get_field_name('image') . '" VALUE="disable" CHECKED>Disable';
	  }
		echo '<p><label for="' . $this->get_field_name('image') . '">' . __('Text or Image?') . '</label><br/>' . $text . '&nbsp;&nbsp;' . $image . '</p>';
    
    # Best Sellers Product ID
		echo '<p><label for="' . $this->get_field_name('number') . '">' . __('Number of products to show:') . ' </label><input id="' . $this->get_field_id('number') . '" name="' . $this->get_field_name('number') . '" type="text" value="' . $number . '" /></p>';     
	}
} 

register_widget('Colabs_Best_Sellers_Widget');
?>