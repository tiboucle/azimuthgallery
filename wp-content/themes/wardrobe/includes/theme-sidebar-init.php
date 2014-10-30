<?php

// Register widgetized areas

if (!function_exists('the_widgets_init')) {
	function the_widgets_init() {
	    if ( !function_exists('register_sidebars') )
	        return;
    //Sidebar
	  register_sidebar(array(
		'name'          => sprintf(__('Sidebar','colabsthemes') ),
		'id'            => 'sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3> ',
	  ));
	  
	register_sidebar(array(
		'name'          => sprintf(__('Shop Sidebar','colabsthemes') ),
		'id'            => 'sidebar-shop',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3> ',
	));  
	
	register_sidebar(array(
		'name'          => sprintf(__('Home Sidebar','colabsthemes') ),
		'id'            => 'sidebar-home',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3> ',
	));  

	register_sidebar(array(
		'name'          => sprintf(__('Footer Sidebar','colabsthemes') ),
		'id'            => 'footer-sidebar',
		'before_widget' => '<div id="%1$s" class="widget column col4 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3> ',
	));

    }
}

add_action( 'init', 'the_widgets_init' );


    
?>