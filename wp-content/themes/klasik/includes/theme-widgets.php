<?php
/**
 * Loads up all the widgets defined by this theme. Note that this function will not work for versions of WordPress 2.7 or lower
 *
 */

$path_pfilterwidget = get_template_directory() . '/includes/widgets/klasik-pfilter-widget.php';
if(file_exists($path_pfilterwidget)) include_once ($path_pfilterwidget);

$path_featureswidget = get_template_directory() . '/includes/widgets/klasik-features-widget.php';
if(file_exists($path_featureswidget)) include_once ($path_featureswidget);

$path_recentwidget = get_template_directory() . '/includes/widgets/klasik-recentposts-widget.php';
if(file_exists($path_recentwidget)) include_once ($path_recentwidget);

$path_latestnwwidget = get_template_directory() . '/includes/widgets/klasik-latestnews-widget.php';
if(file_exists($path_latestnwwidget)) include_once ($path_latestnwwidget);

$path_advancedwidget = get_template_directory() . '/includes/widgets/klasik-advancedpost-widget.php';
if(file_exists($path_advancedwidget)) include_once ($path_advancedwidget);

$path_testiwidget = get_template_directory() . '/includes/widgets/klasik-testimonial-widget.php';
if(file_exists($path_testiwidget)) include_once ($path_testiwidget);

$path_teamwidget = get_template_directory() . '/includes/widgets/klasik-team-widget.php';
if(file_exists($path_teamwidget)) include_once ($path_teamwidget);

$path_actionwidget = get_template_directory() . '/includes/widgets/klasik-action-widget.php';
if(file_exists($path_actionwidget)) include_once ($path_actionwidget);

$path_pagewidget = get_template_directory() . '/includes/widgets/klasik-page-widget.php';
if(file_exists($path_pagewidget)) include_once ($path_pagewidget);

$path_eventswidget = get_template_directory() . '/includes/widgets/klasik-events-widget.php';
if(file_exists($path_eventswidget)) include_once ($path_eventswidget);

$path_imgcarouselwidget = get_template_directory() . '/includes/widgets/klasik-imagecarousel-widget.php';
if(file_exists($path_imgcarouselwidget)) include_once ($path_imgcarouselwidget);

if( function_exists('is_woocommerce')){
	$path_woofpwidget = get_template_directory() . '/includes/widgets/klasik-product-widget.php';
	if(file_exists($path_woofpwidget)) include_once ($path_woofpwidget);
}

add_action("widgets_init", "klasik_theme_widgets");

function klasik_theme_widgets() {
	register_widget("Klasik_PFilterWidget");
	register_widget("Klasik_FeaturesWidget");
	register_widget("Klasik_RecentPostsWidget");
	register_widget("Klasik_AdvancedPostsWidget");
	register_widget("Klasik_TestimonialWidget");
	register_widget("Klasik_TeamWidget");
	register_widget("Klasik_PCarouselWidget");
	register_widget("Klasik_CallToActionWidget");
	register_widget("Klasik_PageinWidget");
	register_widget("Klasik_LatestNewsWidget");
	register_widget("Klasik_EventsWidget");
	
	if( function_exists('is_woocommerce')){
		register_widget("Klasik_WooProductWidget");
	}
}