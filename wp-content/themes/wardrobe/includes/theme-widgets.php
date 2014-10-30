<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/*---------------------------------------------------------------------------------*/
/* Loads all the .php files found in /includes/widgets/ directory */
/*---------------------------------------------------------------------------------*/

include( TEMPLATEPATH . '/includes/widgets/widget-colabs-tabs.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-ad-sidebar.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-flickr.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-search.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-twitter.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-about.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-subscribe.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-info.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-list-taxonomy.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-follow.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-fbfriends.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-product-search.php' );
include( TEMPLATEPATH . '/includes/widgets/widget-colabs-bestseller.php' );

/*---------------------------------------------------------------------------------*/
/* Deregister Default Widgets */
/*---------------------------------------------------------------------------------*/
if (!function_exists('colabs_deregister_widgets')) {
	function colabs_deregister_widgets(){
	    unregister_widget('WP_Widget_Search'); 
		if (is_plugin_active('jigoshop/jigoshop.php')){	
		unregister_widget('Jigoshop_Widget_Product_Search');	
		} 
		if (is_plugin_active('woocommerce/woocommerce.php')){	
		unregister_widget('WooCommerce_Widget_Product_Search');	
		unregister_widget('WooCommerce_Widget_Best_Sellers');	
		} 
	}
}
add_action('widgets_init', 'colabs_deregister_widgets');  


?>