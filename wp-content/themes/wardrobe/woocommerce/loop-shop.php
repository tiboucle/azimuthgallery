<?php

global $woocommerce_loop,$colabs_posttype,$colabs_taxonomy,$plugin;;

$woocommerce_loop['loop'] = 0;
$woocommerce_loop['show_products'] = true;

if (!isset($woocommerce_loop['columns']) || !$woocommerce_loop['columns']) $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);

?>

<?php do_action('woocommerce_before_shop_loop'); ?>

<ul >

	<?php 
	
	do_action('woocommerce_before_shop_loop_products');
	
	if ($woocommerce_loop['show_products'] && have_posts()) : while (have_posts()) : the_post(); 
	
		$_product = &new woocommerce_product( $post->ID ); 
		
		if (!$_product->is_visible()) continue; 
		
		$woocommerce_loop['loop']++;
		
		?>
		<li class="column">
					<?php colabs_image('width=202&height=202');?>
					<div class="item-detail">
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						
							<?php global $_product; $_product = &new woocommerce_product( $post->ID );?>
							<p class="item-price"><?php echo $_product->get_price_html(); ?></p>
							<a href="<?php echo $_product->add_to_cart_url(); ?>" class="buttons orange buy"><?php _e('Add To Cart','colabsthemes');?></a>
						
					</div>
				</li><?php 
		
	endwhile; endif;
	
	if ( !have_posts() ) echo '<li class="info">'.__('No products found which match your selection.', 'colabsthemes').'</li>';

	?>

</ul>

<div class="clear"></div>

<?php do_action('woocommerce_after_shop_loop'); ?>