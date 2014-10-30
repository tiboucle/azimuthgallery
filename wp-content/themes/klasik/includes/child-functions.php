<?php
function klasik_child_setup() {
	remove_action( 'widgets_init', 'klasik_footer1_sidebar_init' );
	remove_action( 'widgets_init', 'klasik_footer2_sidebar_init' );
	remove_action( 'widgets_init', 'klasik_footer3_sidebar_init' );
	remove_action( 'widgets_init', 'klasik_footer4_sidebar_init' );
	
}

add_action( 'after_setup_theme', 'klasik_child_setup' );

define('KLASIK_SLIDERTEXTEFFECT', 'moveFromLeft');

/* class klasik */
add_filter( 'body_class', 'klasik_body_class' );
function klasik_body_class( $classes ) {
	// add 'class-name' to the $classes array
	$classes[] = 'childclass';
	// return the $classes array
	return $classes;
}
