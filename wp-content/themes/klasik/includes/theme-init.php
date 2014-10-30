<?php

add_action( 'after_setup_theme', 'klasik_setup' );

function klasik_default_image(){
	$imgconf = array(
	);
	return $imgconf;
}

if ( ! function_exists( 'klasik_setup' ) ):

function klasik_setup() {
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'gallery', 'video', 'audio' ) );
	
	//Add Custom Image Size
	add_image_size( 'widget-feature', '50', '50', true );
	add_image_size( 'widget-portfolio', '750', '444', true );
	add_image_size( 'widget-advancedpost', '550', '330', true );
	add_image_size( 'widget-latestnews', '550', '330', true );
	add_image_size( 'widget-post', '100', '100', true );
	add_image_size( 'widget-testimonial', '100', '100', true );
	add_image_size( 'image-slider', '1170', '480', true );
	add_image_size( 'entry-image', '750', '320', true );
	add_image_size( 'entry-gallery', '750', '320', true );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'mainmenu' => __( 'Main Menu', 'klasik' )

	) );
	
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	
	//This theme support woocommerce now.
	add_theme_support( 'woocommerce' );
	
}
endif;


if ( ! function_exists( 'klasik_theme_support' ) ):

function klasik_theme_support() {
	$args = "";
	 add_theme_support( 'custom-header', $args );
	 add_theme_support( 'custom-background', $args );
}
endif;