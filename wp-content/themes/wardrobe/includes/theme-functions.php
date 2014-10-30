<?php 

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Excerpt
- Page navigation
- CoLabsTabs - Popular Posts
- CoLabsTabs - Latest Posts
- CoLabsTabs - Latest Comments
- Post Meta
- Dynamic Titles
- WordPress 3.0 New Features Support
- using_ie - Check IE
- post-thumbnail - WP 3.0 post thumbnails compatibility
- automatic-feed-links Features
- Twitter button - twitter
- Facebook Like Button - fblike
- Facebook Share Button - fbshare
- Google +1 Button - [google_plusone]
-- Load Javascript for Google +1 Button
- colabs_link - Alternate Link & RSS URL
- Open Graph Meta Function
- colabs_share - Twitter, FB & Google +1
- Post meta Portfolio
- Customize theme

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* SET GLOBAL CoLabs VARIABLES
/*-----------------------------------------------------------------------------------*/

// Slider Tags
	$GLOBALS['slide_tags_array'] = array();
// Duplicate posts 
	$GLOBALS['shownposts'] = array();

/*-----------------------------------------------------------------------------------*/
/* Excerpt
/*-----------------------------------------------------------------------------------*/

//Add excerpt on pages
if(function_exists('add_post_type_support'))
add_post_type_support('page', 'excerpt');

/** Excerpt character limit */
/* Excerpt length */
function colabs_excerpt_length($length) {
if( get_option('colabs_excerpt_length') != '' ){
        return get_option('colabs_excerpt_length');
    }else{
        return 45;
    }
}
add_filter('excerpt_length', 'colabs_excerpt_length');

/** Remove [..] in excerpt */
function colabs_trim_excerpt($text) {
  return rtrim($text,'[...]');
}
add_filter('get_the_excerpt', 'colabs_trim_excerpt');

/** Add excerpt more */
function colabs_excerpt_more($more) {
    global $post;
	//return '<span class="more"><a href="'. get_permalink($post->ID) . '">'. __( 'Read more', 'colabsthemes' ) . '&hellip;</a></span>';
}
add_filter('excerpt_more', 'colabs_excerpt_more');

// Shorten Excerpt text for use in theme
function colabs_excerpt($text, $chars = 120) {
	$text = $text." ";
	$text = substr($text,0,$chars);
	$text = substr($text,0,strrpos($text,' '));
	$text = $text."...";
	return $text;
}



// get_the_excerpt filter
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_trim_excerpt');

function custom_trim_excerpt($text) { // Fakes an excerpt if needed
global $post;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 45);
		$words = explode(' ', $text, $excerpt_length + 1);
		if (count($words) > $excerpt_length) {
			array_pop($words);
            $excerpt_more = apply_filters('excerpt_more', '...');
			array_push($words, '...');
            array_push($words, $excerpt_more);
			$text = implode(' ', $words);
		}
	}
	return $text;
}
//Custom Excerpt Function
function colabs_custom_excerpt($limit,$more) {
	global $post;
	if ($limit=='')$limit=35;
	$print_excerpt = '<p>';
	$output = $post->post_excerpt;
	if ($output!=''){
	$print_excerpt .= $output;
	}else{
	$content = get_the_content('');
	$content = strip_shortcodes( $content );
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = strip_tags($content);	
	$excerpt = explode(' ',$content, $limit);
	array_pop($excerpt);
	$print_excerpt .= implode(" ",$excerpt).$more;
	}
	$print_excerpt .= '</p>';
	echo $print_excerpt;
}
function colabs_product_excerpt($limit,$more) {
	if ($limit=='')$limit=35;
	$print_excerpt = '<p>';
	$content = get_the_content('');
	$content = strip_shortcodes( $content );
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = strip_tags($content);	
	$excerpt = explode(' ',$content, $limit);
	array_pop($excerpt);
	$print_excerpt .= implode(" ",$excerpt).$more;
	$print_excerpt .= '</p>';
	echo $print_excerpt;
}
/*-----------------------------------------------------------------------------------*/
/* Breadcrumbs */
/*-----------------------------------------------------------------------------------*/
if(!function_exists('colabs_breadcrumb')){
function colabs_breadcrumb() {
     
  $delimiter = '&raquo;';
  $home = 'Home'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    //echo '<div id="crumbs">';
 
    global $post;
    $homeLink = get_bloginfo('url');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() || is_tax() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . single_cat_title('', false) . $after;
	
	} elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        //echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    } 
 
    /* if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    } */
 
    //echo '</div>';
 
  }
}}

/*End of Breadcrumbs*/

/*-----------------------------------------------------------------------------------*/
/* Page navigation */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_pagenav')) {
	function colabs_pagenav() {   
	    
			 if ( get_next_posts_link() || get_previous_posts_link() ) { ?>

                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Previous Entries', 'colabsthemes' ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Next Entries <span class="meta-nav">&raquo;</span>', 'colabsthemes' ) ); ?></div>

			<?php } ?>

		<?php 
	}
}

if (!function_exists('colabs_postnav')) {
	function colabs_postnav() {
		?>
    <div class="navigation">
        <div class="navleft fl"><?php next_post_link('%link','&laquo; Prev') ;?></div>
		<div class="navcenter gohome"><a href="<?php echo get_option('home');?>">Back to home</a></div>
        <div class="navright fr"><?php previous_post_link('%link','Next &raquo;'); ?></div>
        
    </div><!--/.navigation-->
		<?php 
	}
}


if (!function_exists('colabs_custom_pagination')) {
function colabs_custom_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }
	 
 
     if(1 != $pages)
     {
         echo "<div id='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link($paged - 1)."'>Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='link-button current'>".$i."</span>":"<a class='link-button' href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link($paged + 1)."'>Next</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a class='link-button' href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}
}
/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_404')) {
	function colabs_404(){

        echo "<p>It seems that page you were looking for doesn't exist.Try searching the site.</p>";
   
	}
}
/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Popular Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_tabs_popular')) {
	function colabs_tabs_popular( $posts = 5, $size = 35 ) {
		global $post;
		$args=array(
			  'post_type' => array('post','review'),
			  'post_status' => 'publish',
			  'showposts' => $posts,
			  'orderby' => 'comment_count',
			  'caller_get_posts'=> 1
			);
		$popular = get_posts($args);
		foreach($popular as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) colabs_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach;
	}
}

/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Latest Posts */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_tabs_latest')) {
	function colabs_tabs_latest( $posts = 5, $size = 35 ) {
		global $post;
		$args=array(
			  'post_type' => array('post','review'),
			  'post_status' => 'publish',
			  'showposts' => $posts,
			  'orderby' => 'post_date',
			  'order'=> 'desc',
			  'caller_get_posts'=> 1
			);
		$latest = get_posts($args);
		foreach($latest as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) colabs_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach; 
	}
}

/*-----------------------------------------------------------------------------------*/
/* CoLabsTabs - Latest Comments */
/*-----------------------------------------------------------------------------------*/
if (!function_exists('colabs_tabs_comments')) {
	function colabs_tabs_comments( $posts = 5, $size = 35 ) {
		global $wpdb;
		$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
		comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved,
		comment_type,comment_author_url,
		SUBSTRING(comment_content,1,50) AS com_excerpt
		FROM $wpdb->comments
		LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
		$wpdb->posts.ID)
		WHERE comment_approved = '1' AND comment_type = '' AND
		post_password = '' AND ($wpdb->posts.post_type='post' OR $wpdb->posts.post_type='page')
		ORDER BY comment_date_gmt DESC LIMIT ".$posts;
		
		$comments = $wpdb->get_results($sql);
		
		foreach ($comments as $comment) {
		?>
		<li>
			<?php echo get_avatar( $comment, $size ); ?>
		
			<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php _e('on ', 'colabsthemes'); ?> <?php echo $comment->post_title; ?>">
                <span class="author"><?php echo strip_tags($comment->comment_author); ?></span></a>: <span class="comment"><?php echo strip_tags($comment->com_excerpt); ?>...</span>
			
			<div class="fix"></div>
		</li>
		<?php 
		}
	}
}



/*-----------------------------------------------------------------------------------*/
/* Dynamic Titles */
/*-----------------------------------------------------------------------------------*/
// This sets your <title> depending on what page you're on, for better formatting and for SEO

function dynamictitles() {
	
	if ( is_single() ) {
      wp_title('');
     
 
} else if ( is_page() || is_paged() ) {
      
      echo (''.__('Archive for','colabsthemes').'');
 
} else if ( is_author() ) {
     
      wp_title(''.__('Author','colabsthemes').'');	  
	  
} else if ( is_category() ) {
      
      wp_title(''.__('Category for','colabsthemes').'');
      

} else if ( is_tag() ) {
      
      wp_title(''.__('Tag archive for','colabsthemes').'');

} else if ( is_archive() ) {
      
      echo (''.__('Archive for','colabsthemes').'');
     

} else if ( is_search() ) {
      
      echo (''.__('Search Results for ','colabsthemes').'');
		the_search_query();
} else if ( is_404() ) {
      
      echo (''.__('404 Error (Page Not Found)','colabsthemes').'');
	  
} else if ( is_home() ) {
      bloginfo('name');
      echo (' | ');
      bloginfo('description');
 
} else {
      bloginfo('name');
      echo (' | ');
      echo (''.$blog_longd.'');
}
}

/*-----------------------------------------------------------------------------------*/
/* WordPress 3.0 New Features Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_nav_menus') ) {
	add_theme_support( 'nav-menus' );
    register_nav_menus( array(
        'main-menu' => __( 'Main Menu','colabsthemes' ),
		'secondary-menu' => __( 'Secondary Menu','colabsthemes' ),
));    
}

if (!function_exists('colabs_nav_fallback')) {
function colabs_nav_fallback($div_id){
    
		
        wp_page_menu('title_li=&menu_class=');

}}
add_filter('wp_page_menu','add_menuclass');
function add_menuclass($ulclass) {
return preg_replace('/<ul>/', '<ul class="menu">', $ulclass, 1);
}
/*-----------------------------------------------------------------------------------*/
/* using_ie - Check IE */
/*-----------------------------------------------------------------------------------*/
//check IE
function using_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;    
}

/*-----------------------------------------------------------------------------------*/
/*  WP 3.0 post thumbnails compatibility */
/*-----------------------------------------------------------------------------------*/
if(function_exists( 'add_theme_support')){
	//if(get_option( 'colabs_post_image_support') == 'true'){
    if( get_option('colabs_post_image_support') ){
        add_theme_support( 'post-thumbnails' );		
		// set height, width and crop if dynamic resize functionality isn't enabled
		if ( get_option( 'colabs_pis_resize') <> "true" ) {
			$hard_crop = get_option( 'colabs_pis_hard_crop' );
			if($hard_crop == 'true') {$hard_crop = true; } else { $hard_crop = false;} 
			add_image_size( 'headline-thumb', 978, 99999, $hard_crop);
			
		}
	}
} 

/*-----------------------------------------------------------------------------------*/
/*  automatic-feed-links Features  */
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) && get_option('colabs_feedlinkurl') == '' ) {
add_theme_support( 'automatic-feed-links' );
}

/*-----------------------------------------------------------------------------------*/
/* colabs_link - Alternate Link & RSS URL */
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_head', 'colabs_link' );
if (!function_exists('colabs_link')) {
function colabs_link(){ 
?>	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('colabs_feedlinkurl') ) { echo get_option('colabs_feedlinkurl'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	
<?php 
}}

/*-----------------------------------------------------------------------------------*/
/*  Open Graph Meta Function    */
/*-----------------------------------------------------------------------------------*/
function colabs_meta_head(){
    do_action( 'colabs_meta' );
}
add_action( 'colabs_meta', 'og_meta' );  

if (!function_exists('og_meta')) {
function og_meta(){ ?>
	<?php if ( is_home() && get_option( 'colabs_og_enable' ) == '' ) { ?>
	<meta property="og:title" content="<?php echo bloginfo('name');; ?>" />
	<meta property="og:type" content="author" />
	<meta property="og:url" content="<?php echo get_option('home'); ?>" />
	<meta property="og:image" content="<?php echo get_option('colabs_og_img'); ?>"/>
	<meta property="og:site_name" content="<?php echo get_option('colabs_og_sitename'); ?>" />
	<meta property="fb:admins" content="<?php echo get_option('colabs_og_admins'); ?>" />
	<meta property="og:description" content="<?php echo get_option('blogdescription '); ?>" />
	<?php } ?>
	
	<?php if ( ( is_page() || is_single() ) && get_option( 'colabs_og_enable' ) == '' ) { ?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?php echo get_post_meta($post->ID, 'yourls_shorturl', true) ?>" />
	<meta property="og:image" content="<?php $values = get_post_custom_values("Image"); ?><?php echo get_option('home'); ?>/<?php echo $values[0]; ?>"/>
	<meta property="og:site_name" content="<?php echo get_option('colabs_og_sitename'); ?>" />
	<meta property="fb:admins" content="<?php echo get_option('colabs_og_admins'); ?>" />
	<?php } ?>
    
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
}}
	
/*-----------------------------------------------------------------------------------*/	
/* Search Form*/
/*-----------------------------------------------------------------------------------*/
function custom_search( $form ) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <input type="text" value="'. esc_attr__('Search') .'" name="s" id="s" />
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'custom_search' );

/*-----------------------------------------------------------------------------------*/
/* CoLabs - Footer Credit */
/*-----------------------------------------------------------------------------------*/
function colabs_credit(){
global $themename,$colabs_options;
if( $colabs_options['colabs_footer_credit'] != 'true' ){ ?>
            Copyright &copy; 2011 <a href="http://colorlabsproject.com/themes/<?php echo get_option('colabs_themename'); ?>/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo get_option('colabs_themename'); ?></a> <br> by <a href="http://colorlabsproject.com/" title="Colorlabs">ColorLabs & Company</a>. All rights reserved.
<?php }else{ echo stripslashes( $colabs_options['colabs_footer_credit_txt'] ); } 
}


/*-----------------------------------------------------------------------------------*/
/*  is_mobile - Check Mobile Version */
/*-----------------------------------------------------------------------------------*/
if(!function_exists('is_mobile')){
function is_mobile(){
	$regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
	$regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
	$regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";	
	$regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
	$regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
	$regex_match.=")/i";		
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}}


/*-----------------------------------------------------------------------------------*/
/*  colabs_share - Twitter, FB & Google +1    */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'colabs_share' ) ) {
function colabs_share() {
    
$return = '';


$colabs_share_twitter = get_option('colabs_single_share_twitter');
$colabs_share_fblike = get_option('colabs_single_share_fblike');
$colabs_share_fb = get_option('colabs_single_share_fb');
$colabs_share_google_plusone = get_option('colabs_single_share_google_plusone');


    //Share Button Functions 
    global $colabs_options;
    $url = get_permalink();
    $share = '';
    
    //Twitter Share Button
    if(function_exists('colabs_shortcode_twitter') && $colabs_share_twitter == "true"){
        $tweet_args = array(  'url' => $url,
   							'style' => 'horizontal',
   							'source' => ( $colabs_options['colabs_twitter_username'] )? $colabs_options['colabs_twitter_username'] : '',
   							'text' => '',
   							'related' => '',
   							'lang' => '',
   							'float' => 'left'
                        );

        $share .= colabs_shortcode_twitter($tweet_args);
    }
    
   
        
    //Google +1 Share Button
    if( function_exists('colabs_shortcode_google_plusone') && $colabs_share_google_plusone == "true"){
        $google_args = array(
						'size' => 'medium',
						'language' => '',
						'count' => '',
						'href' => $url,
						'callback' => '',
						'float' => 'left'
					);        

        $share .= colabs_shortcode_google_plusone($google_args);       
    }
	
	 //Facebook Like Button
    if(function_exists('colabs_shortcode_fblike') && $colabs_share_fblike == "true"){
    $fblike_args = 
    array(	
        'float' => 'left',
        'url' => '',
        'style' => 'button_count',
        'showfaces' => 'false',
        'width' => '62',
        'height' => '',
        'verb' => 'like',
        'colorscheme' => 'light',
        'font' => 'arial'
        );
        $share .= colabs_shortcode_fblike($fblike_args);    
    }
    
    $return .= '<div class="social_share clearfloat">'.$share.'</div><div class="clear"></div>';
    
    return $return;
}
}
function colabs_headercart() {
    if ( ! class_exists( 'Jigoshop_Widget_Cart' ) )
        return; 
	
	// quantity
	$qty = 0;
	if (sizeof(jigoshop_cart::$cart_contents)>0) : foreach (jigoshop_cart::$cart_contents as $item_id => $values) :
	
		$qty += $values['quantity'];
	
	endforeach; endif;
	echo '<div class="cart">';
	echo '<a class="trigger" href="' . jigoshop_cart::get_cart_url() . '">
			-' . $qty . ' item &ndash; ' . jigoshop_cart::get_cart_total() . ' 
		</a> ';
	echo '</div>';	
	
}

/*-----------------------------------------------------------------------------------*/
/*  Update cart wp e-commerce    */
/*-----------------------------------------------------------------------------------*/
function update_cart_count(){
		if ( ($_REQUEST['wpsc_ajax_action'] == 'add_to_cart') && $_REQUEST['ajax'] == TRUE ) {
				$totalprice = wpsc_cart_total_widget();
				$output = "<a href='".get_option('shopping_cart_url')."'>";
				$output .= "<span class='cart-icon'></span>";
				$output .= sprintf( _n('%d item - ', '%d items - ', wpsc_cart_item_count(), 'colabstheme'), wpsc_cart_item_count());
				$output .= "$totalprice";
				$output .= "</a>";
				echo "jQuery('.action .cart').html(\"$output\")";
				exit;
		}
}
add_action( 'wpsc_alternate_cart_html', 'update_cart_count' );

function default_sidebar(){
global $colabs_posttype,$colabs_taxonomy,$plugin,$site_title,$site_url,$site_description,$colabs_options;
?>

<?php
			/* Search Widget */
			$search = new CoLabs_Product_Search();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget widget_colabs_search">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Find Products', 'colabsthemes' )
			);
			$search->widget( $args, $instance );
		?>
		
		<?php
			/* Category Product Widget */
			$taxonomy_categories = new CoLabs_Taxonomy_Categories();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Brands', 'colabsthemes' ),
				'widgettaxonomy' => $colabs_taxonomy 
			);
			$taxonomy_categories->widget( $args, $instance );
		?>

		

		<?php
			/* Info Widget */
			$info = new CoLabs_Info();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget widget_colabs_subscribe">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Need Help?', 'colabsthemes' ),
				'title2' => 'Flamboyant Square - Seasons Building',
				'address' => 'Jalan Sukajadi 232',
				'zip-code' => '40153',
				'state' => 'Jawa Barat',
				'city' => 'Bandung',
				'email' => 'hello@colorlabsproject.com'
			);
			$info->widget( $args, $instance );
		?>
			<?php
				/* Subscribe Widget */
				$subscribe = new CoLabs_Subscribe();	
				$args = array(
					'before_title' => '<h4 class="widget-title">',
					'after_title' => '</h4>',
					'before_widget' => '<div class="widget widget_colabs_subscribe">',
					'after_widget' => '</div>'
				);
				
				$instance = array(
					'title' => __( 'Subscribe', 'colabsthemes' )
				);
				$subscribe->widget( $args, $instance );
			?>

			<?php
			/* Facebook Widget */
			$facebook = new CoLabs_Widget_Facebook();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Facebook Friends', 'colabsthemes' ),
				'fid' =>'101618976863',
				'connections' => '9', 
				'width' => '187',
				'height' => '365'				
			);
			$facebook->widget( $args, $instance );
			?>
			
			<?php
				/* Follow Widget */
				$follow = new CoLabs_Follow();	
				$args = array(
					'before_title' => '<h4 class="widget-title">',
					'after_title' => '</h4>',
					'before_widget' => '<div class="widget widget_colabs_follow">',
					'after_widget' => '</div>'
				);
				
				$instance = array(
					'title' => __( 'Follow Us', 'colabsthemes' ),
					'twitter' => 'http://www.twitter.com/colorlabs',
					'facebook' => 'http://www.facebook.com/colorlabs',
					'gplus' => 'http://plus.google.com'
				);
				$follow->widget( $args, $instance );
			?>
		
<?php
}
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('woocommerce/woocommerce.php')){
	remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	add_action( 'woocommerce_after_single_product_summary', 'colabs_output_related_products', 20);

	if (!function_exists('colabs_output_related_products')) {
		function colabs_output_related_products() {
			// 2 Related Products in 2 columns
			colabs_related_products( 2, 2 );
		}
	}

	if (!function_exists('colabs_related_products')) {
		function colabs_related_products( $posts_per_page = 4, $post_columns = 4, $orderby = 'rand' ) {

			global $_product, $woocommerce_loop;

			// Pass vars to loop
			$woocommerce_loop['columns'] = $post_columns;

			$related = $_product->get_related();
			if (sizeof($related)>0) :
				echo '<div class="section items-grid row"><h3 class="section-title">'.__('Related Products', 'colabsthemes').'</h2>';
				$args = array(
					'post_type'	=> 'product',
					'ignore_sticky_posts'	=> 1,
					'posts_per_page' => $posts_per_page,
					'orderby' => $orderby,
					'post__in' => $related
				);
				$args = apply_filters('woocommerce_related_products_args', $args);
				query_posts($args);
				woocommerce_get_template_part( 'loop', 'shop' );
				echo '</div>';
			endif;
			wp_reset_query();

		}
	}
}

if (is_plugin_active('jigoshop/jigoshop.php')){
	remove_action( 'jigoshop_after_single_product_summary', 'jigoshop_output_related_products', 20);
	add_action( 'jigoshop_after_single_product_summary', 'colabs_output_related_products_j', 20);

	if (!function_exists('colabs_output_related_products_j')) {
		function colabs_output_related_products_j() {
			// 2 Related Products in 2 columns
			colabs_related_products_j( 2, 2 );
		}
	}

	if (!function_exists('colabs_related_products_j')) {
		function colabs_related_products_j( $posts_per_page = 4, $post_columns = 4, $orderby = 'rand' ) {

			global $_product, $columns, $per_page;
			
			$per_page = $posts_per_page;

			// Pass vars to loop
			$columns = $post_columns;

			$related = $_product->get_related();
			if (sizeof($related)>0) :
				echo '<div class="section items-grid row"><h3 class="section-title">'.__('Related Products', 'colabsthemes').'</h2>';
				$args = array(
					'post_type'	=> 'product',
					'ignore_sticky_posts'	=> 1,
					'posts_per_page' => $per_page,
					'orderby' => $orderby,
					'post__in' => $related
				);
				$args = apply_filters('jigoshop_related_products_args', $args);
				query_posts($args);
				jigoshop_get_template_part( 'loop', 'shop' );
				echo '</div>';
			endif;
			wp_reset_query();

		}
	}
} 
if (is_plugin_active('wp-e-commerce/wp-shopping-cart.php')){
	function colabs_the_product_price( $no_decimals = false, $only_normal_price = false, $product_id ) {
		global $wpsc_query, $wpsc_variations, $wpdb;
		if ($product_id=='')$product_id = get_the_ID();
		if ( ! empty( $wpsc_variations->first_variations ) ) {
			$from_text = apply_filters( 'wpsc_product_variation_text', ' from ' );
			$output = wpsc_product_variation_price_available( $product_id, __( " {$from_text} %s", 'wpsc' ), $only_normal_price );
		} else {
			$price = $full_price = get_post_meta( $product_id, '_wpsc_price', true );

			if ( ! $only_normal_price ) {
				$special_price = get_post_meta( $product_id, '_wpsc_special_price', true );

				if ( ( $full_price > $special_price ) && ( $special_price > 0 ) )
					$price = $special_price;
			}

			if ( $no_decimals == true )
				$price = array_shift( explode( ".", $price ) );

			$price = apply_filters( 'wpsc_do_convert_price', $price );
			$args = array(
				'display_as_html' => false,
				'display_decimal_point' => ! $no_decimals
			);
			$output = wpsc_currency_display( $price, $args );
		}
		return $output;
	}
}
// Front-end includes
if (!is_admin()) :

    get_template_part('includes/theme-login');
    get_template_part('includes/form/form');
    get_template_part('includes/form/form-process');


endif;

// contains the reCaptcha anti-spam system. Called on reg pages
function colabsthemes_recaptcha() {

    // process the reCaptcha request if it's been enabled
    if (get_option('colabs_captcha_enable') == 'true' && get_option('colabs_captcha_theme') && get_option('colabs_captcha_public_key')) :
?>
        <script type="text/javascript">
        // <![CDATA[
         var RecaptchaOptions = {
            custom_translations : {
                instructions_visual : "<?php _e('Type the two words:','colabsthemes') ?>",
                instructions_audio : "<?php _e('Type what you hear:','colabsthemes') ?>",
                play_again : "<?php _e('Play sound again','colabsthemes') ?>",
                cant_hear_this : "<?php _e('Download sound as MP3','colabsthemes') ?>",
                visual_challenge : "<?php _e('Visual challenge','colabsthemes') ?>",
                audio_challenge : "<?php _e('Audio challenge','colabsthemes') ?>",
                refresh_btn : "<?php _e('Get two new words','colabsthemes') ?>",
                help_btn : "<?php _e('Help','colabsthemes') ?>",
                incorrect_try_again : "<?php _e('Incorrect. Try again.','colabsthemes') ?>",
            },
            theme: "<?php echo get_option('colabs_captcha_theme') ?>",
            lang: "en",
            tabindex: 5
         };
        // ]]>
        </script>

        <p>
        <?php
        // let's call in the big boys. It's captcha time.
        require_once (TEMPLATEPATH . '/includes/lib/recaptchalib.php');
        echo recaptcha_get_html(get_option('colabs_captcha_public_key'));
        ?>
        </p>

<?php
    endif;  // end reCaptcha

}


//Customize theme
add_theme_support('custom-background');
function colabs_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'title_tagline' );

	// option
	// -----start----- //

	//Access the WordPress Categories via an Array
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (is_plugin_active('wp-e-commerce/wp-shopping-cart.php')) {
			$colabs_taxonomy='wpsc_product_category';
		}else if (is_plugin_active('jigoshop/jigoshop.php')){
			$colabs_taxonomy='product_cat';
		}else if (is_plugin_active('woocommerce/woocommerce.php')){
			$colabs_taxonomy='product_cat';	
		}else{
			$colabs_taxonomy='category';
		}
	$colabs_product_categories = array();  
	$colabs_product_categories_obj = get_categories('taxonomy='.$colabs_taxonomy.'&hide_empty=0');
	foreach ($colabs_product_categories_obj as $colabs_product_cat) {
		$colabs_product_categories[$colabs_product_cat->cat_ID] = $colabs_product_cat->cat_name;}
		
	// -----end----- //
	
	// Style Frontpage
	//------------------
	$wp_customize->add_section( 'frontpage', array(
		'title'    => __("Frontpage Settings", "colabsthemes" ),
		'priority' => 21,
	) );

	$wp_customize->add_setting( 'colabs_headline_product', array(
		'type'              => 'option',
		'default'           => '',
		'sanitize_callback' => 'sanitize_key',
	) );
  
	$wp_customize->add_control( 'colabs_headline_product', array(
		'label'   => __('Category Product', 'colabsthemes'),
		'section'    => 'frontpage',
		'type'       => 'select',
		'choices'    => $colabs_product_categories,
	) );
  
	// Logo Settings
	  // -------------
	  /* $wp_customize->add_section( 'logo_settings', array(
		'title'    => __( 'Logo Settings', 'colabsthemes' ),
		'priority' => 20,
	  ) );

	  $wp_customize->add_setting( 'colabs_logo', array(
		'type'        => 'option',
		'capability'  => 'manage_options',
	  ) );

	  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'colabs_logo', array(
		'label'    => __( 'Logo', 'colabsthemes' ),
		'section'  => 'logo_settings',
		'settings' => 'colabs_logo',
		'priority' => 5,
		'label'      => __('Upload a logo for your theme. Best image size in 206x59 px', 'colabsthemes')
	  ) ) ); */	
	  
	  //Layout
	  //------------------
	  $wp_customize->add_section( 'layout_setting', array(
		'title'    => __( 'Layout Setting', 'colabsthemes' ),
		'priority' => 22,
	  ) );

	  $wp_customize->add_setting( 'colabs_layout_settings', array(
		'type'              => 'option',
		'default'           => get_option('colabs_layout_settings'),
		'sanitize_callback' => 'sanitize_key',
	  ) );

	  $layouts = array(
		'two-col-left' => __('Two Column - Content on left', 'colabsthemes'),
		'two-col-right' => __('Two Column - Content on Right', 'colabsthemes')
	  );
	  $wp_customize->add_control( 'layout_setting', array(
		'section'    => 'layout_setting',
		'type'       => 'radio',
		'settings'   => 'colabs_layout_settings',
		'choices'    => $layouts,
		'label'      => __('Select main content and sidebar alignment. Choose between 1, 2 column layout.', 'colabsthemes')
	  ) ); 
	
}
add_action( 'customize_register', 'colabs_customize_register' );	

function colabs_customize_preview_js() {
  wp_enqueue_script( 'colabs-customizer', get_stylesheet_directory_uri() . '/includes/js/theme-customizer.js', array( 'customize-preview' ), '20120620', true );
}
add_action( 'customize_preview_init', 'colabs_customize_preview_js' );
?>