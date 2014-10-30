<?php

add_action('init', 'reviews');


if ( ! function_exists( 'reviews' ) ) {
function reviews() {
	$args = array(
		'description' => 'Reviews Post Type',
		'show_ui' => true,
		'menu_position' => 4,
		'labels' => array(
			'name'=> 'Reviews',
			'singular_name' => 'Reviews',
			'add_new' => 'Add New Review', 
			'add_new_item' => 'Add New Review',
			'edit' => 'Edit Reviews',
			'edit_item' => 'Edit Review',
			'new-item' => 'New Review',
			'view' => 'View Reviews',
			'view_item' => 'View Reviews',
			'search_items' => 'Search Reviews',
			'not_found' => 'No Reviews Found',
			'not_found_in_trash' => 'No Reviews Found in Trash',
			'parent' => 'Parent Review'
		),
		'public' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
        'publicly_queryable' => true,        
		'rewrite' => array( 'slug' => 'review' ),
        'has_archive' => true, 
        'taxonomies' => array( 'review_category','post_tag' ),
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'custom-fields')
	);
	register_post_type( 'review' , $args );
    
	register_taxonomy('review_category',
			array ( 'review' ),
			array (
			'labels' => array (
					'name' => 'Review Categories',
					'singular_name' => 'Review Category',
					'search_items' => 'Search Review Categories',
					'popular_items' => 'Popular Review Categories',
					'all_items' => 'All Review Categories',
					'parent_item' => 'Parent Review Categories',
					'parent_item_colon' => 'Parent Review Categories:',
					'edit_item' => 'Edit Review Categories',
					'update_item' => 'Update Review Categories',
					'add_new_item' => 'Add New Review Categories',
					'new_item_name' => 'New Review Categories',
			),
					'hierarchical' =>true,
					'show_ui' => true,
					'show_tagcloud' => true,
					'rewrite' => array( 'slug' => 'review_category' ),
                    'query_var' => true,
            ));
    
    flush_rewrite_rules();    
}
}



?>