<?php

/*********For Localization**************/
add_action('after_setup_theme', 'klasik_load_textdomain');
function klasik_load_textdomain(){
	load_theme_textdomain( 'klasik', get_template_directory().'/languages' );
	load_theme_textdomain( 'klasik', get_stylesheet_directory().'/languages' );
}
/*********End For Localization**************/


// The excerpt based on character
if(!function_exists("klasik_string_limit_char")){
	function klasik_string_limit_char($excerpt, $substr=0, $strmore = ""){
		$string = strip_tags(str_replace('...', '...', $excerpt));
		if ($substr>0) {
			$string = substr($string, 0, $substr);
		}
		if(strlen($excerpt)>=$substr){
			$string .= $strmore;
		}
		return $string;
	}
}
// The excerpt based on words
if(!function_exists("klasik_string_limit_words")){
	function klasik_string_limit_words($string, $word_limit){
	  $words = explode(' ', $string, ($word_limit + 1));
	  if(count($words) > $word_limit)
	  array_pop($words);
	  
	  return implode(' ', $words);
	}
}

if(!function_exists("klasik_get_category")){
	function klasik_get_category(){
		global $post;
		$categories = get_the_category();
		$separator = ', ';
		$catoutput = '';
		if($categories){
			foreach($categories as $category) {
				$catoutput .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'klasik' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
			}
		}
		
		return trim($catoutput, $separator);
	}
}

if( !function_exists('klasik_is_pagepost')){
	function klasik_is_pagepost(){
		global $post;
		
		if( is_404() || is_archive() || is_attachment() || is_search() ){
			$custom = false;
		}else{
			$custom = true;
		}
		
		return $custom;
	}
}

if( !function_exists('klasik_get_customdata')){
	function klasik_get_customdata($pid=""){
		global $post;
		
		if($pid!=""){
			$custom = get_post_custom($pid);
		}elseif( klasik_is_pagepost() ){
			$custom = get_post_custom(get_the_ID());
		}else{
			$custom = array();
		}
		
		return $custom;
	}
}

if( !function_exists('klasik_get_imgsize')){
	function klasik_get_imgsize(){
	
		global $imgconf;
		$defaultimg = klasik_default_image();
		$imageconfs = (isset($imgconf) && is_array($imgconf))? $imgconf : array();
		
		$imageconfs = array_merge($defaultimg, $imageconfs);
		
		return $imageconfs;
	}
}

if( !function_exists('klasik_get_customstyle')){
	function klasik_get_customstyle(){
	
		global $customstyles;
		$defaultimg = klasik_default_styles();
		$imageconfs = (isset($customstyles) && is_array($customstyles))? $customstyles : array();
		
		$imageconfs = array_merge($defaultimg, $imageconfs);
		
		return $imageconfs;
	}
}

if( !function_exists('klasik_get_configval')){
	function klasik_get_configval($confstr,$defval=""){
	
		if(defined($confstr)){
			$return = constant($confstr);
		}else{
			$return = $defval;
		}
		
		return $return;
		
	}
}

if( !function_exists('klasik_widget_count')){
	function klasik_widget_count( $sidebar_name ) {
		global $sidebars_widgets;
		$count = count ($sidebars_widgets[$sidebar_name]);
		
		return $count;
	
	}
}


/* Remove inline styles printed when the gallery shortcode is used.*/
function klasik_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'klasik_remove_gallery_css' );

/*Template for comments and pingbacks. */
if ( ! function_exists( 'klasik_comment' ) ) :
function klasik_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="con-comment">
		<div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div><!-- .comment-author .vcard -->


		<div class="comment-body">
			<?php  printf( __( '%s ', 'klasik' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            <span class="time">
               <?php
                /* translators: 1: date, 2: time */
                printf( __( '%1$s %2$s', 'klasik' ), get_comment_date(),  get_comment_time() ); ?>
            </span>
			<div class="commenttext">
			<?php comment_text(); ?>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'klasik' ); ?></em>
			<?php endif; ?>
            <?php edit_comment_link( __( 'Edit', 'klasik' ), '<span class="com-link">', '</span>' );?>
			<?php comment_reply_link( 
                array_merge( 
                    $args, array(
                    'before' => '<span class="com-reply">', 
                    'depth' => $depth, 
                    'max_depth' => $args['max_depth'],
                    'after'      => '</span>' 
                    ) 
                ) 
            ); ?>
            
			</div>
            <div class="arrow"></div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'klasik' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'klasik'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*Prints HTML with meta information for the current post (category, tags and permalink).*/
if ( ! function_exists( 'klasik_posted_in' ) ) :
function klasik_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'Categories: %1$s <br/> Tags: %2$s', 'klasik' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'Categories: %1$s', 'klasik' );
	} else {
		$posted_in = __( '', 'klasik' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if( ! function_exists('klasik_filter_title') ){
	function klasik_filter_title($title) {
		if ($title == '') {
			return __('Untitled','klasik');
		} else {
			return $title;
		}
	}
	add_filter('the_title', 'klasik_filter_title');
}

/* for top menu */
function nav_page_fallback() {
if(is_front_page()){$class="current_page_item";}else{$class="";}
print '<ul id="topnav" class="sf-menu"><li class="'.$class.'"><a href=" '.home_url( '/') .' " title=" '.__('Click for Home','klasik').' ">'.__('Home','klasik').'</a></li>';
    wp_list_pages( 'title_li=&sort_column=menu_order' );
print '</ul>';
}

/* for shortcode widget  */
add_filter('widget_text', 'do_shortcode');

/* for removing the wpautop */
function klasik_run_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
	
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
 
add_filter( 'the_content', 'klasik_run_shortcode', 7 );


// Numbered Pagination
if ( !function_exists( 'klasik_pagination' ) ) {
	
	function klasik_pagination() {
		
		$prev_arrow = is_rtl() ? '&rsaquo;' : '&lsaquo;';
		$next_arrow = is_rtl() ? '&lsaquo;' : '&rsaquo;';
		
		global $wp_query;
		$total = $wp_query->max_num_pages;
		$big = 999999999; // need an unlikely integer
		if( $total > 1 )  {
			 if( !$current_page = get_query_var('paged') )
				 $current_page = 1;
			 if( get_option('permalink_structure') ) {
				 $format = 'page/%#%/';
			 } else {
				 $format = '&paged=%#%';
			 }
			echo paginate_links(array(
				'base'			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total,
				'mid_size'		=> 3,
				'type' 			=> 'list',
				'prev_text'		=> $prev_arrow,
				'next_text'		=> $next_arrow,
			 ) );
		}
	}
	
}


// Enqueue scripts
function klasik_comment_js(){
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action('wp_enqueue_scripts', 'klasik_comment_js');



/**
* WooCommerce Extra Feature
* --------------------------
*
* Change number of related products on product page
* Set your own value for 'posts_per_page'
*
*/
function woo_related_products_limit() {
global $product;
$args['posts_per_page'] = 6;
return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
function jk_related_products_args( $args ) {
 
$args['posts_per_page'] = 4; // 4 related products
$args['columns'] = 4; // arranged in 2 columns
return $args;
}


/* Make all future posts visible in single post */
add_filter('the_posts', 'show_future_posts');
function show_future_posts($posts){ 
   global $wp_query, $wpdb;
   if(is_single() && $wp_query->post_count ==0){ 
      $posts = $wpdb->get_results($wp_query->request);
   } 
   return $posts;
};


?>