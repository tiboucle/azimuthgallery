<?php

//Enable CoLabsSEO on these custom Post types
//$seo_post_types = array('post','page');
//define("SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action('init','colabs_global_options');
function colabs_global_options(){
	// Populate CoLabsThemes option in array for use in theme
	global $colabs_options;
	$colabs_options = get_option('colabs_options');
}

add_action('admin_head','colabs_options');  
if (!function_exists('colabs_options')) {
function colabs_options(){
	
// VARIABLES
$themename = "Wardrobe";
$manualurl = 'http://colorlabsproject.com';
$shortname = "colabs";

//Access the WordPress Categories via an Array
$colabs_categories = array();  
$colabs_categories_obj = get_categories('hide_empty=0');
foreach ($colabs_categories_obj as $colabs_cat) {
    $colabs_categories[$colabs_cat->cat_ID] = $colabs_cat->cat_name;}
//$categories_tmp = array_unshift($colabs_categories, "Select a category:");

//Access the WordPress Pages via an Array
$colabs_pages = array();
$colabs_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($colabs_pages_obj as $colabs_page) {
    $colabs_pages[$colabs_page->ID] = $colabs_page->post_name; }
//$colabs_pages_tmp = array_unshift($colabs_pages, "Select a page:");       

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

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }
    }
}

$images_dir =  get_template_directory_uri() . '/functions/images/';
	
//More Options
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");

$other_entries_10 = array("Select a number:","1","2","3","4","5","6","7","8","9","10");

$other_entries_4 = array("Select a number:","1","2","3","4");

// THIS IS THE DIFFERENT FIELDS
$options = array();

// General Settings
$options[] = array( "name" => __("General Settings", "colabsthemes" ),
					"type" => "heading",
					"icon" => "general");

$options[] = array( "name" => __( "Use for blog title/logo", "colabsthemes" ),
					"desc" => __( "Select title or logo for your blog.", "colabsthemes" ),
					"id" => $shortname."_logotitle",
					"std" => "logo",
					"type" => "select2",
					"options" => array( "logo" => __( "Logo", "colabsthemes" ), "title" => __( "Title", "colabsthemes" ) ) ); 					

$options[] = array( "name" => __("Custom Logo", "colabsthemes" ),
					"desc" => __("Upload a logo for your theme, or specify an image URL directly. Best image size in 260x60 px", "colabsthemes" ),
					"id" => $shortname."_logo",
					"std" => trailingslashit( get_bloginfo('template_url') ) . "images/logo.png",
					"type" => "upload");

$options[] = array( "name" => __("Custom Favicon", "colabsthemes" ),
					"desc" => __("Upload a 16x16px ico image that will represent your website's favicon. Favicon/bookmark icon will be shown at the left of your blog's address in visitor's internet browsers.", "colabsthemes" ),
					"id" => $shortname."_custom_favicon",
					"std" => trailingslashit( get_bloginfo('template_url') ) . "images/favicon.png",
					"type" => "upload"); 
									
$options[] = array( "name" => __( 'Main Layout', 'colabsthemes' ),
                    "desc" => __( 'Select main content and sidebar alignment. Choose between left or right sidebar layout.', 'colabsthemes' ),
                    "id" => $shortname . "_layout_settings", //colabs_layout
                    "std" => "two-col-right",
                    "type" => "images",
                    "options" => array(                                                        
                                'two-col-right' => $images_dir . '2cr.png',
								'two-col-left' => $images_dir . '2cl.png')
                    );
					
$options[] = array( "name" => __('Enable / Disable reCaptcha', 'colabsthemes'),
					"desc" => sprintf(__('%2$s. reCaptcha is a free anti-spam service provided by Google. Learn more about <a target="_new" href="%1$s">reCaptcha</a>.', 'colabsthemes'), 'http://code.google.com/apis/recaptcha/', __('Set this option to yes to enable the reCaptcha service that will protect your site against spam registrations. It will show a verification box on your registration page that requires a human to read and enter the words','colabsthemes') ),
					"id" => $shortname."_captcha_enable",
                    'class' => 'collapsed',
					"std" => "true",
					"type" => "checkbox");

$options[] = array( "name" => __('reCaptcha Public Key', 'colabsthemes'),
					"desc" => sprintf( '%3$s. %1$s' . __('Sign up for a free <a target="_new" href="%2$s">Google reCaptcha</a> account.','colabsthemes'), '<div class="captchaico"></div>', 'https://www.google.com/recaptcha/admin/create', __('Enter your public key here to enable an anti-spam service on your new user registration page (requires a free Google reCaptcha account). Leave it blank if you do not wish to use this anti-spam feature','colabsthemes') ),
					"id" => $shortname."_captcha_public_key",
					"std" => "",
                    'class' => 'hidden',
					"type" => "text");

$options[] = array( "name" => __('reCaptcha Private Key', 'colabsthemes'),
					"desc" => sprintf( '%3$s. %1$s' . __('Sign up for a free <a target="_new" href="%2$s">Google reCaptcha</a> account.','colabsthemes'), '<div class="captchaico"></div>', 'https://www.google.com/recaptcha/admin/create', __('Enter your private key here to enable an anti-spam service on your new user registration page (requires a free Google reCaptcha account). Leave it blank if you do not wish to use this anti-spam feature','colabsthemes') ),
					"id" => $shortname."_captcha_private_key",
					"std" => "",
                    'class' => 'hidden',
					"type" => "text");

$options[] = array( "name" => __('Choose Theme', 'colabsthemes'),
					"desc" => __('Select the color scheme you wish to use for reCaptcha.', 'colabsthemes'),
					"id" => $shortname."_captcha_theme",
					"std" => "",
                    'class' => 'hidden last',
					"type" => "select2",
					"options" => array( 'red' => __('Red', 'colabsthemes'), 'white' => __('White', 'colabsthemes'), 'blackglass' => __('Black', 'colabsthemes'), 'clean'  => __('Clean', 'colabsthemes') )
                    );
                    
$options[] = array( "name" => __("Enable PressTrends Tracking", "colabsthemes" ),
					"desc" => __("PressTrends is a simple usage tracker that allows us to see how our customers are using our themes, so that we can help improve them for you. <strong>None</strong> of your personal data is sent to PressTrends.", "colabsthemes" ),
					"id" => $shortname."_pt_enable",
					"std" => "true",
					"type" => "checkbox");

$options[] = array( "name" => "Disable Responsive",
					"desc" => "You can disable responsive module for your site.",
					"id" => $shortname."_disable_mobile",
					"std" => "false",
					"type" => "checkbox");
					
// FrontPage Options
$options[] = array( "name" => __("FrontPage Settings", "colabsthemes" ),
					"type" => "heading",
					"icon" => "home");
					
$options[] = array( "name" => __("Promo Text", "colabsthemes" ),
					"desc" => __("Enter your promotion to show at the frontpage", "colabsthemes" ),
					"id" => $shortname."_promo_text",
					"type" => "text");	
					
$options[] = array( "name" => __("Headline Slider", "colabsthemes" ),
					"desc" => __("You can assign which product category to be displayed at the slider section on frontpage. ", "colabsthemes" ),
					"id" => $shortname."_headline_product",
                    "std" => "",
					"type" => "select2",
					"options" => $colabs_product_categories );

$options[] = array( "name" => __("Slider Limit", "colabsthemes" ),
					"desc" => __("Enter your limit of your product to show at the slider", "colabsthemes" ),
					"id" => $shortname."_headline_limit",
					"std" => "3",
					"type" => "text");						

					
$options[] = array( "name" => __("Latest Post Limit", "colabsthemes" ),
					"desc" => __("Enter your limit of your post to show at latest section", "colabsthemes" ),
					"id" => $shortname."_latest_limit",
					"std" => "2",
					"type" => "text");	
					
/* //Social Settings	 */				
$options[] = array( "name" => __("Social Networking", "colabsthemes" ),
					"icon" => "misc",
					"type" => "heading");	

$options[] = array( "name" => __("Enable/Disable Social Share Button", "colabsthemes" ),
					"desc" => __("Select which social share button you would like to enable on single post & pages.", "colabsthemes" ),
					"id" => $shortname."_single_share",
					"std" => array("fblike","twitter","google_plusone"),
					"type" => "multicheck2",
                    "class" => "",
					"options" => array(
                                    "fblike" => "Facebook Like Button",                                    
                                    "twitter" => "Twitter Share Button",
                                    "google_plusone" => "Google +1 Button",
                                )
                    ); 					

// Open Graph Settings
$options[] = array( "name" => __("Open Graph Settings", "colabsthemes" ),
					"type" => "heading",
					"icon" => "graph");

$options[] = array( "name" => __("Open Graph", "colabsthemes" ),
					"desc" => __("Enable or disable Open Graph Meta tags.", "colabsthemes" ),
					"id" => $shortname."_og_enable",
					"type" => "select2",
                    "std" => "",
                    "class" => "collapsed",
					"options" => array("" => "Enable", "disable" => "Disable") );

$options[] = array( "name" => __("Site Name", "colabsthemes" ),
					"desc" => __("Open Graph Site Name ( og:site_name ).", "colabsthemes" ),
					"id" => $shortname."_og_sitename",
					"std" => "",
                    "class" => "hidden",
					"type" => "text");

$options[] = array( "name" => __("Admin", "colabsthemes" ),
					"desc" => __("Open Graph Admin ( fb:admins ).", "colabsthemes" ),
					"id" => $shortname."_og_admins",
					"std" => "",
                    "class" => "hidden",
					"type" => "text");

$options[] = array( "name" => __("Image", "colabsthemes" ),
					"desc" => __("You can put the url for your Open Graph Image ( og:image ).", "colabsthemes" ),
					"id" => $shortname."_og_img",
					"std" => "",
                    "class" => "hidden last",
					"type" => "text");

//Dynamic Images 					                   
$options[] = array( "name" => __("Thumbnail Settings", "colabsthemes" ),
					"type" => "heading",
					"icon" => "image");
                    
$options[] = array( "name" => __("WordPress Featured Image", "colabsthemes" ),
					"desc" => __("Use WordPress Featured Image for post thumbnail.", "colabsthemes" ),
					"id" => $shortname."_post_image_support",
					"std" => "true",
					"class" => "collapsed",
					"type" => "checkbox");

$options[] = array( "name" => __("WordPress Featured Image - Dynamic Resize", "colabsthemes" ),
					"desc" => __("Resize post thumbnail dynamically using WordPress native functions (requires PHP 5.2+).", "colabsthemes" ),
					"id" => $shortname."_pis_resize",
					"std" => "true",
					"class" => "hidden",
					"type" => "checkbox");
                    
$options[] = array( "name" => __("WordPress Featured Image - Hard Crop", "colabsthemes" ),
					"desc" => __("Original image will be cropped to match the target aspect ratio.", "colabsthemes" ),
					"id" => $shortname."_pis_hard_crop",
					"std" => "true",
					"class" => "hidden last",
					"type" => "checkbox");
                    
$options[] = array( "name" => __("TimThumb Image Resizer", "colabsthemes" ),
					"desc" => __("Enable timthumb.php script which dynamically resizes images added thorugh post custom field.", "colabsthemes" ),
					"id" => $shortname."_resize",
					"std" => "true",
					"type" => "checkbox");
                    
$options[] = array( "name" => __("Automatic Thumbnail", "colabsthemes" ),
					"desc" => __("Generate post thumbnail from the first image uploaded in post (if there is no image specified through post custom field or WordPress Featured Image feature).", "colabsthemes" ),
					"id" => $shortname."_auto_img",
					"std" => "true",
					"type" => "checkbox");
                    
$options[] = array( "name" => __("Thumbnail Image in RSS Feed", "colabsthemes" ),
					"desc" => __("Add post thumbnail to RSS feed article.", "colabsthemes" ),
					"id" => $shortname."_rss_thumb",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => __("Thumbnail Image Dimensions", "colabsthemes" ),
					"desc" => __("Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.", "colabsthemes" ),
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_thumb_w',
											'type' => 'text',
											'std' => 100,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_thumb_h',
											'type' => 'text',
											'std' => 100,
											'meta' => 'Height')
								  ));

$options[] = array( "name" => __("Custom Field Image", "colabsthemes" ),
					"desc" => __("Enter your custom field image name to change the default name (default name: image).", "colabsthemes" ),
					"id" => $shortname."_custom_field_image",
					"std" => "",
					"type" => "text");
					
// Analytics ID, RSS feed

$options[] = array( "name" => __("Analytics ID & Feedburner", "colabsthemes" ),
					"type" => "heading",
					"icon" => "statistics");
					
$options[] = array( "name" => __("GoSquared Token", "colabsthemes" ),
					"desc" => __("You can use GoSquared real-time web analytics. Enter your GoSquared Token here (ex. GSN-893821-D).",	 "colabsthemes" ),
					"id" => $shortname."_gosquared_id",
					"std" => "",
					"type" => "text");					
                    
$options[] = array( "name" => __("Google Analytics", "colabsthemes" ),
					"desc" => __("Manage your website statistics with Google Analytics, put your Analytics Code here", "colabsthemes" ).". (ex : </br>
									&#60;script type='text/javascript'	&#62;</br>
								  var _gaq = _gaq || [];</br>
								  _gaq.push(['_setAccount', 'UA-2809127-42']);</br>
								  _gaq.push(['_trackPageview']);</br>

								  (function() {</br>
									var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;</br>
									ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';</br>
									var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);</br>
								  })();</br>
								&#60;&#47;script&#62;</br>).",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => __("Feedburner URL", "colabsthemes" ),
					"desc" => __("Feedburner URL. This will replace RSS feed link. Start with http://.", "colabsthemes" ),
					"id" => $shortname."_feedlinkurl",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => __("Feedburner Comments URL", "colabsthemes" ),
					"desc" => __("Feedburner URL. This will replace RSS comment feed link. Start with http://.", "colabsthemes" ),
					"id" => $shortname."_feedlinkcomments",
					"std" => "",
					"type" => "text");
					
		
				

// Footer Settings
$options[] = array( "name" => __("Footer Settings", "colabsthemes" ),
					"type" => "heading",
					"icon" => "footer");    

$options[] = array( "name" => __("Enable / Disable Custom Credit (Right)", "colabsthemes" ),
					"desc" => __("Activate to add custom credit on footer area.", "colabsthemes" ),
					"id" => $shortname."_footer_credit",
					"class" => "collapsed",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => __("Footer Credit", "colabsthemes" ),
                    "desc" => __("You can customize footer credit on footer area here.", "colabsthemes" ),
                    "id" => $shortname."_footer_credit_txt",
                    "std" => "",
					"class" => "hidden last",                    
                    "type" => "textarea");
/* //Contact Form */
$options[] = array( "name" => __("Contact Form", "colabsthemes" ),
					"type" => "heading",
					"icon" => "general");    
$options[] = array( "name" => __("Destination Email Address", "colabsthemes" ),
					"desc" => __("All inquiries made by your visitors through the Contact Form page will be sent to this email address.", "colabsthemes" ),
					"id" => $shortname."_contactform_email",
					"std" => "",
					"type" => "text"); 

				
					
// Add extra options through function
if ( function_exists("colabs_options_add") )
	$options = colabs_options_add($options);

if ( get_option('colabs_template') != $options) update_option('colabs_template',$options);      
if ( get_option('colabs_themename') != $themename) update_option('colabs_themename',$themename);   
if ( get_option('colabs_shortname') != $shortname) update_option('colabs_shortname',$shortname);
if ( get_option('colabs_manual') != $manualurl) update_option('colabs_manual',$manualurl);

//PressTrends
$colabs_pt_auth = "bo3ynvtl3b6uir78ygvtjxal0iskizz2c"; 
update_option('colabs_pt_auth',$colabs_pt_auth);

// CoLabs Metabox Options
// Start name with underscore to hide custom key from the user
$colabs_metaboxes = array();
$colabs_metabox_settings = array();
global $post;

    //Metabox Settings
    $colabs_metabox_settings['post'] = array(
                                'id' => 'colabsthemes-settings',
								'title' => 'ColorLabs' . __( ' Image/Video Settings', 'colabsthemes' ),
								'callback' => 'colabsthemes_metabox_create',
								'page' => 'post',
								'context' => 'normal',
								'priority' => 'high',
                                'callback_args' => ''
								);
                                    
    $colabs_metabox_settings['page'] = array();

	
	$colabs_metabox_settings['review'] = array(
                                'id' => 'colabsthemes-settings',
								'title' => 'ColorLabs' . __( ' Review Detail Settings', 'colabsthemes' ),
								'callback' => 'colabsthemes_metabox_create',
								'page' => 'review',
								'context' => 'normal',
								'priority' => 'high',
                                'callback_args' => ''
								);
									


								
if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {
	$colabs_metaboxes[] = array (  "name"  => $shortname."_single_top",
					            "std"  => "Image",
					            "label" => "Item to Show",
					            "type" => "radio",
					            "desc" => "Choose Image/Embed Code to appear at the single top.",
								"options" => array(	"none" => "None",
													"single_image" => "Image",
													"single_video" => "Embed" ));
	$colabs_metaboxes[] = array (	"name" => "image",
								"label" => "Post Custom Image",
								"type" => "upload",
                                "class" => "single_image",
								"desc" => "Upload an image or enter an URL.");
	
	$colabs_metaboxes[] = array (  "name"  => $shortname."_embed",
					            "std"  => "",
					            "label" => "Video Embed Code",
					            "type" => "textarea",
                                "class" => "single_video",
					            "desc" => "Enter the video embed code for your video (YouTube, Vimeo or similar)");
								
	$colabs_metaboxes[] = array (  "name"  => "map",
					            "std"  => "",
					            "label" => "Google Maps Location",
					            "type" => "text",
					            "desc" => "The map should ly using previously entered data.");							
					            
} // End post

if ( ( get_post_type() == 'review') || ( !get_post_type() ) ) {
	$colabs_metaboxes[] = array (  "name"  => $shortname."_single_top",
					            "std"  => "Image",
					            "label" => "Item to Show",
					            "type" => "radio",
					            "desc" => "Choose Image/Embed Code to appear at the single top.",
								"options" => array(	"none" => "None",
													"single_image" => "Image",
													"single_video" => "Embed" ));
	$colabs_metaboxes[] = array (	"name" => "image",
								"label" => "Post Custom Image",
								"type" => "upload",
                                "class" => "single_image",
								"desc" => "Upload an image or enter an URL.");
	
	$colabs_metaboxes[] = array (  "name"  => $shortname."_embed",
					            "std"  => "",
					            "label" => "Video Embed Code",
					            "type" => "textarea",
                                "class" => "single_video",
					            "desc" => "Enter the video embed code for your video (YouTube, Vimeo or similar)");	
								
	$colabs_metaboxes[] = array (  "name"  => "map",
					            "std"  => "",
					            "label" => "Google Maps Location",
					            "type" => "text",
					            "desc" => "The map should ly using previously entered data.");		

}

 


	


// Add extra metaboxes through function
if ( function_exists("colabs_metaboxes_add") ){
	$colabs_metaboxes = colabs_metaboxes_add($colabs_metaboxes);
    }
if ( get_option('colabs_custom_template') != $colabs_metaboxes){
    update_option('colabs_custom_template',$colabs_metaboxes);
    }
if ( get_option('colabs_metabox_settings') != $colabs_metabox_settings){
    update_option('colabs_metabox_settings',$colabs_metabox_settings);
    }
     
}
}



?>