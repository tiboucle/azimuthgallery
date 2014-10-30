<?php
function klasik_sidebar_init() {

	register_sidebar( array(
		'name' 					=> __( 'Post Sidebar', 'klasik' ),
		'id' 						=> 'post-sidebar',
		'description' 		=> __( 'Located at the left/right side of archives, single and search.', 'klasik' ),
		'before_widget' 	=> '<ul><li id="%1$s" class="widget-container %2$s"><div class="box">',
		'after_widget' 		=> '<div class="clear"></div></div></li></ul>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 			=> '</h3>',
	));	
	
}

function klasik_footer_sidebar_init(){
	
	$footcolumn = klasik_get_option( 'klasik_foot_column','3');

	//get column
	if($footcolumn=="1"){
		$typecol = "twelve columns";
	}elseif($footcolumn=="2"){
		$typecol = "six columns";
	}elseif($footcolumn=="3"){
		$typecol = "four columns";
	}elseif($footcolumn=="4"){
		$typecol = "three columns";
	}elseif($footcolumn=="5"){
		$typecol = "one_fifth columns";
	}else{
		$typecol = "two columns";
	}
	

	register_sidebar(array(
		'name'          => __('Footer Sidebar', 'klasik' ),
		'id'         	=> 'footer',
		'description'   => __( 'Located at the footer column.', 'klasik' ),
		'before_widget' => '<div class="' . $typecol . '"><div class="widget-footer"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}


function klasik_footer1_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer1 Sidebar', 'klasik' ),
		'id'         	=> 'footer1',
		'description'   => __( 'Located at the footer column 1.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer2_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer2 Sidebar', 'klasik' ),
		'id'         	=> 'footer2',
		'description'   => __( 'Located at the footer column 2.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));	
	
}

function klasik_footer3_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer3 Sidebar', 'klasik' ),
		'id'         	=> 'footer3',
		'description'   => __( 'Located at the footer column 3.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer4_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer4 Sidebar', 'klasik' ),
		'id'         	=> 'footer4',
		'description'   => __( 'Located at the footer column 4.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer5_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer5 Sidebar', 'klasik' ),
		'id'         	=> 'footer5',
		'description'   => __( 'Located at the footer column 5.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_footer6_sidebar_init(){

	register_sidebar(array(
		'name'          => __('Footer6 Sidebar', 'klasik' ),
		'id'         	=> 'footer6',
		'description'   => __( 'Located at the footer column 6.', 'klasik' ),
		'before_widget' => '<div class="widget-bottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
}

function klasik_contenttop_sidebar(){
	
	register_sidebar(array(
		'name'          => __('Content Top', 'klasik' ),
		'id'         	=> 'contenttop',
		'description'   => __( 'Located at the top of the content.', 'klasik' ),
		'before_widget' => '<div class="widget-contenttop"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

function klasik_contentbottom_sidebar(){
	register_sidebar(array(
		'name'          => __('Content Bottom', 'klasik' ),
		'id'         	=> 'contentbottom',
		'description'   => __( 'Located at the bottom of the content.', 'klasik' ),
		'before_widget' => '<div class="widget-contentbottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

function klasik_maintop_sidebar(){	
		register_sidebar(array(
		'name'          => __('Main Top', 'klasik' ),
		'id'         	=> 'maintop',
		'description'   => __( 'Located at the top of the content.', 'klasik' ),
		'before_widget' => '<div class="widget-maintop"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

function klasik_mainbottom_sidebar(){	
	register_sidebar(array(
		'name'          => __('Main Bottom', 'klasik' ),
		'id'         	=> 'mainbottom',
		'description'   => __( 'Located at the bottom of the content.', 'klasik' ),
		'before_widget' => '<div class="widget-mainbottom"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));

}
function klasik_homefeatures_sidebar(){	
	register_sidebar(array(
		'name'          => __('Homepage Features', 'klasik' ),
		'id'         	=> 'homefeatures',
		'description'   => __( 'Located at the bottom of the highlight.', 'klasik' ),
		'before_widget' => '<div class="widget-features"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

function klasik_homeshowcase_sidebar(){	
	register_sidebar(array(
		'name'          => __('Homepage Showcase', 'klasik' ),
		'id'         	=> 'homeshowcase',
		'description'   => __( 'Located at the bottom of the features.', 'klasik' ),
		'before_widget' => '<div class="widget-showcase"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}
function klasik_homehighlight_sidebar(){	
	register_sidebar(array(
		'name'          => __('Homepage Highlight', 'klasik' ),
		'id'         	=> 'homehighlight',
		'description'   => __( 'Located at the bottom of the slider.', 'klasik' ),
		'before_widget' => '<div class="widget-highlight"><ul><li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clear"></div></li></ul><div class="clear"></div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}


/** Register sidebars by running klasik_sidebar_init() on the widgets_init hook. */
add_action( 'widgets_init', 'klasik_sidebar_init' );
add_action( 'widgets_init', 'klasik_contenttop_sidebar' );
add_action( 'widgets_init', 'klasik_contentbottom_sidebar' );
add_action( 'widgets_init', 'klasik_maintop_sidebar' );
add_action( 'widgets_init', 'klasik_mainbottom_sidebar' );
add_action( 'widgets_init', 'klasik_homefeatures_sidebar' );
add_action( 'widgets_init', 'klasik_homeshowcase_sidebar' );
add_action( 'widgets_init', 'klasik_homehighlight_sidebar' );
add_action( 'widgets_init', 'klasik_footer_sidebar_init' );
add_action( 'widgets_init', 'klasik_footer1_sidebar_init' );
add_action( 'widgets_init', 'klasik_footer2_sidebar_init' );
add_action( 'widgets_init', 'klasik_footer3_sidebar_init' );
add_action( 'widgets_init', 'klasik_footer4_sidebar_init' );
