<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php if ( function_exists( 'colabs_title') ){ colabs_title(); }else{ echo get_bloginfo('name'); ?>&nbsp;<?php wp_title(); } ?></title>
<?php
	if ( function_exists( 'colabs_meta') ) colabs_meta();
	if ( function_exists( 'colabs_meta_head') )colabs_meta_head(); 
    global $colabs_options,$site_title,$site_url,$site_description;    
?>
    <link href="<?php bloginfo('template_url'); ?>/includes/css/colabs-css.css" rel="stylesheet" type="text/css" />
    
<?php 
    if ( function_exists( 'colabs_head') ) colabs_head();
    wp_head(); 
	$site_title = get_bloginfo( 'name' );
	$site_url = home_url( '/' );
	$site_description = get_bloginfo( 'description' );
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	global $colabs_posttype,$colabs_taxonomy,$woocommerce,$plugin;
	if (is_plugin_active('wp-e-commerce/wp-shopping-cart.php')) {
		$colabs_posttype='wpsc-product';
		$colabs_taxonomy='wpsc_product_category';
		$plugin='wpsc';
	}else if (is_plugin_active('jigoshop/jigoshop.php')){
		$colabs_posttype='product';
		$colabs_taxonomy='product_cat';
		$plugin='jigoshop';
	}else if (is_plugin_active('woocommerce/woocommerce.php')){
		$colabs_posttype='product';
		$colabs_taxonomy='product_cat';	
		$plugin='woo';
	}else{
		$colabs_posttype='post';
		$colabs_taxonomy='category';
		$plugin='';
	}
?>
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
</head>
<body <?php body_class(); ?>>

<div class="header container">
	<div class="row">
	<h1 class="logo column col3">
		<?php
			if (get_option('colabs_logotitle')=='logo'){
				if ( isset($colabs_options['colabs_logo']) && $colabs_options['colabs_logo'] ) {
					echo '<a href="' . $site_url . '" title="' . $site_description . '"><img src="' . $colabs_options['colabs_logo'] . '" alt="' . $site_title . '" /></a>';
				} 
			}else {
				echo '<a href="' . $site_url . '">' . $site_title . '</a>';
			} // End IF Statement						
		?>
	</h1><!-- .logo -->

	<div class="navigation column col9">
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_class' => '', 'fallback_cb'=>'colabs_nav_fallback', 'depth' => 1) );?><!-- .menu -->

			<div class="action fr">
				<?php if ($plugin=='woo') {?>
					<div class="cart">
						<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'colabsthemes'); ?>">
							<span> 
							<?php 
							echo sprintf(_n('%d item &ndash; ', '%d items &ndash; ', $woocommerce->cart->cart_contents_count, 'colabsthemes'), $woocommerce->cart->cart_contents_count);
							echo $woocommerce->cart->get_cart_total();
							?>
							</span>
						</a>
					</div>
				<?php }elseif ($plugin=='jigoshop'){?>
					<?php colabs_headercart();?>
				<?php }elseif($plugin=='wpsc'){?>
				<div class="cart">
					<?php if(wpsc_cart_item_count() > 0){?>
					<a target="_parent" href="<?php echo get_option('shopping_cart_url'); ?>" title="<?php _e('Checkout', 'wpsc'); ?>">
					<?php }?>
					<?php printf( _n('%d item', '%d items', wpsc_cart_item_count(), 'colabsthemes'), wpsc_cart_item_count() ); ?> - <?php echo wpsc_cart_total_widget(); ?>
					<?php if(wpsc_cart_item_count() > 0){?>
					</a>
					<?php }?>
				</div>
				<?php }?>
				<?php if(!is_user_logged_in()) {?>
					<?php if(get_option('users_can_register')){?>
					<a href="<?php echo home_url() ?>/wp-login.php?action=register" class="buttons orange"><?php _e('Register','colabsthemes');?></a>
					<?php }?>
					<a href="<?php echo home_url() ?>/wp-login.php" class="buttons blue"><?php _e('Login','colabsthemes');?></a>	
				<?php }else {?>
					<a href="<?php if ($plugin=='wpsc') {echo get_option('user_account_url');}else if ($plugin=='jigoshop') {$page = get_page_by_path('my-account');echo get_permalink( $page->ID );}else if($plugin=='woo'){ echo get_permalink( get_option('woocommerce_myaccount_page_id') );} ?>" title="<?php _e('My Account','colabsthemes'); ?>" class="buttons orange"><?php _e('My Account','colabsthemes');?></a>
					<a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="buttons blue"><?php _e('Log Out','colabsthemes');?></a>
				<?php }?>
			</div>
		</div><!-- .navigation -->

	</div><!-- .row -->
</div><!-- .header -->

<div class="second-nav container">
	<div class="row">
		<a class="btn-navbar collapsed">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
		<div class="nav-collapse collapse">
			<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container_class' => '', 'fallback_cb'=>'colabs_nav_fallback') );?>
		</div>
	</div>
</div><!-- .second-nav -->

<div class="main container">
	<div class="row">

	

	<div class="content column col9 <?php if(get_option('colabs_layout_settings')!='two-col-left'){echo 'fr';}?>">
