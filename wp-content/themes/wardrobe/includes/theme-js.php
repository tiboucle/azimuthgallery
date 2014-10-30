<?php
if (!is_admin()) add_action( 'wp_print_scripts', 'colabsthemes_add_javascript' );

if (!function_exists('colabsthemes_add_javascript')) {

	function colabsthemes_add_javascript () {
		
        wp_enqueue_script('jquery');	
		wp_enqueue_script( 'sooperfish', trailingslashit( get_template_directory_uri() ) . 'includes/js/jquery.sooperfish.js', array('jquery') );
		wp_enqueue_script( 'flexslider', trailingslashit( get_template_directory_uri() ) . 'includes/js/jquery.flexslider-min.js', array('jquery') );
		wp_enqueue_script( 'infiniteScroll', trailingslashit( get_template_directory_uri() ) . 'includes/js/jquery.infinitescroll.min.js', array('jquery') );
		wp_enqueue_script( 'zero', trailingslashit( get_template_directory_uri() ) . 'includes/js/zero.js', array('jquery') );

		wp_localize_script( 'zero', 'config', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		) );

		/* We add some JavaScript to pages with the comment form to support sites with threaded comments (when in use). */        
        	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
        
	} /* // End colabsthemes_add_javascript() */
	
} /* // End IF Statement */

/*-----------------------------------------------------------------------------------*/
/* Ajax action for retrieving data for maps
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_get-map', 'getMapData' );
add_action( 'wp_ajax_get-map', 'getMapData' );

function getMapData() {
	wp_reset_query();
	$tagid = $_POST['tag'];
	$catid = $_POST['cat'];
	$author = $_POST['author'];
	query_posts( array(
		'showposts' => -1,
		'tag_id' => $tagid,
		'cat' => $catid,
		'author' => $author,
		'post_type' => array(
			'review',
			'post'
		),
	) );
	while( have_posts() ) {
		the_post();
		global $post;
		$map = get_post_meta($post->ID, 'map', true);
		$latlng = explode( ',', $map );


		// Check if maps location not empty
		if( ! empty( $map ) ) {
			$data[] = array(
				'title' => get_the_title(),
				'lat' => str_replace(' ', '', $latlng[0] ),
				'lng' => str_replace(' ', '', $latlng[1] ),
				'permalink' => get_permalink(),
				'cat_id' => get_the_category(),
				'post_type' => get_post_type()
			);
		}
	} // endwhile

	header( "Content-Type: application/json" );
	echo json_encode( $data );

	exit;
}

/*-----------------------------------------------------------------------------------*/
/* Ajax action for Load more blog post
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_loadmore', 'loadPost' );
add_action( 'wp_ajax_loadmore', 'loadPost' );

function loadPost() {
	$pagination = $_POST['paged'];

	// Create response array for return value for ajax
	$response = array();
	$response['message'] = 'Success';
	$response['data'] = '';
	
	wp_reset_query();
	query_posts( array(
		'showposts'	=> 8,
		'post_type' => 'post',
		'paged' => $pagination
	) );
	if( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			$num_comments = get_comments_number();
			if ( comments_open() ){
		 	  if($num_comments == 0){
		 	  	$comments = __('No Comments');
		 	  }
		 	  elseif($num_comments > 1){
		 	  	$comments = $num_comments. __(' Comments');
		 	  }
		 	  else{
		 	  	$comments = __("1 Comment");
		 	  }
		 	};
		 
		 	$categories = array();
		 	$catlink = array();
		 	foreach( get_the_category() as $category ) {
		 		$cat = '<a href="'. get_category_link( $category->cat_ID ) .'" rel="category tag">'. $category->cat_name .'</a>';
		 		array_push($catlink, $cat);
		 	}

			$response['data'] .= "<div class=\"post column col3\">";
			$response['data'] .= "<div class=\"entry-image\">" . colabs_image('width=209&return=true') ."</div>";
			$response['data'] .= "<p class=\"entry-category\">";
			$response['data'] .= implode(", ", $catlink);
			$response['data'] .= "</p>";
			$response['data'] .= "<h3 class=\"entry-title\"><a href=\"" . get_permalink() . "\">" . get_the_title() . "</a></h3>";
			$response['data'] .= "<div class=\"entry-content\"><p>". get_the_excerpt() ."</p></div>";
			$response['data'] .= "<div class=\"entry-meta\">
									<span>" . get_the_time('F j, Y') . "</span>
									<span><a href=\"" . get_comments_link(). "\">". $comments ."</a></span>
									<span>" .  __('Posted by','colabsthemes') . "
										<a href=\"". get_author_posts_url(get_the_author_meta( 'ID' )) ."\">". get_the_author() ."</a>
									</span>
								</div>";
			$response['data'] .= "</div>";
		}
	} else {
		$response['message'] = __("No more post.");
	};

	header( "Content-Type: application/json" );
	echo json_encode( $response );

	exit;
};

?>