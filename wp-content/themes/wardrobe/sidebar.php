<?php global $colabs_posttype,$colabs_taxonomy,$plugin,$site_title,$site_url,$site_description,$colabs_options;?>
<div class="sidebar column col3 <?php if(get_option('colabs_layout_settings')=='two-col-left'){echo 'fr';}?>">
	<?php 
	wp_reset_query();
	if(is_home()){
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home') ) : 
			default_sidebar();
		endif; 
	}elseif((@$wp_query->query_vars['post_type'] == 'product')||is_page('products-page')||
		is_page('checkout')||is_page('transaction-results')||is_page('your-account')||
		is_page('my-account')||is_page('change-password')||is_page('edit-address')||
		is_page('view-order')||is_page('order-tracking')||is_page('pay')||
		is_page('thanks')||is_page('cart')
		){
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-shop') ) : 
			default_sidebar();
		endif; 
	}else{
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar') ) : 
			default_sidebar();
		endif;
	}
	?>
	<div class="widget credit-card">
			<h4 class="widget-title"><?php _e("We Accept","colabsthemes"); ?></h4>
			<img src="<?php bloginfo("template_url")?>/images/credit-card/visa.png">
			<img src="<?php bloginfo("template_url")?>/images/credit-card/mastercard.png">
			<img src="<?php bloginfo("template_url")?>/images/credit-card/paypal.png">
			<img src="<?php bloginfo("template_url")?>/images/credit-card/card1.png">
			<img src="<?php bloginfo("template_url")?>/images/credit-card/card2.png">
			</div>
			
		<div class="widget copyright">
			<?php colabs_credit();?>
		</div>
	</div><!-- .sidebar -->


