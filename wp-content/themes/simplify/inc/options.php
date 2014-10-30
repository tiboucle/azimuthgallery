<?php
/**
 * Simplify Options Page
 * @ Copyright: D5 Creation, All Rights, www.d5creation.com
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = 'simplify';
	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}
function optionsframework_options() {
	
		
	$options[] = array(
		'name' => __('Simplify Options', 'simplify'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => '<div class="infohead"><span class="donation">'. __('If you like this FREEE Theme You can consider for a small Donation to us. Your Donation will be spent for the Disadvantaged Children and Students. You can visit our','simplify').' <a href="http://d5creation.com/donate/" target="_blank"><strong>'. __('DONATION PAGE','simplify').' </strong></a> '. __('and Take your decision.','simplify').' '. __('You can inspire us writing a ','simplify').'<a href="http://wordpress.org/support/view/theme-reviews/simplify" target="_blank">'.__('Positive Review','simplify').'</a> '.__('of our Theme.','simplify').'</span><br /><br /><span class="donation"> '. __('Need More Features and Options including Exciting 3D Slide and 100+ Advanced Features? Try','simplify').' <a href="http://d5creation.com/theme/simplify/" target="_blank"><strong>Simplify Extend</strong></a>.</span><br /> <br /><span class="donation"> '. __('You can Visit the Simplify Extend Demo ','simplify').' <a href="http://demo.d5creation.com/themes/?theme=Simplify" target="_blank"><strong>'. __('Here','simplify').'</strong></a>.</span><a href="http://d5creation.com/theme/simplify/" target="_blank" class="extendlink"> </a></div>',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Front Page Heading', 'simplify'), 
		'desc' => __('Input your heading text here.  Please limit it within 30 Letters.',  'simplify'),
		'id' => 'heading-text',
		'std' => __('Welcome to the World of Creativity!',  'simplify'),
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Front Page Heading Description',  'simplify'),
		'desc' => __('Input your heading description here. Please limit it within 100 Letters.', 'simplify'), 
		'id' => 'heading-des',
		'std' => __('WordPress is web software you can use to create a beautiful website or blog. We like to say that WordPress is both free and priceless at the same time.', 'simplify'),
		'type' => 'textarea');	
	
	$options[] = array(
		'name' => __('Banner Image/ Slide Image 01',  'simplify'),
		'desc' => __('Upload an image for the Front Page Banner. 930px X 350px image is recommended.',  'simplify'),
		'id' => 'banner-image',
		'std' => get_template_directory_uri() . '/images/slide-image/slide-image1.jpg',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Slide Image 02',  'simplify'),
		'desc' => __('Upload an image for the Front Page Banner. 930px X 350px image is recommended. Leave this field blank if you do not want any slider.', 'simplify'), 
		'id' => 'slide-image',
		'std' => get_template_directory_uri() . '/images/slide-image/slide-image2.jpg',
		'type' => 'upload');
		
	$options[] = array(
		'name' => __('Slide Image 03',  'simplify'),
		'desc' => __('Upload an image for the Front Page Banner. 930px X 350px image is recommended. Leave this field blank if you do not want any slider.', 'simplify'),
		'id' => 'extra-image',
		'std' => get_template_directory_uri() . '/images/slide-image/slide-image3.jpg',
		'type' => 'upload');	
	
	$options[] = array(
		'name' => __('Quote Text',   'simplify'),
		'desc' => __('Input your Quotation here. Plese limit it within 150 Letters.',   'simplify'),
		'id' => 'bottom-quotation',
		'std' => __('All the developers of D5 Creation have come from the disadvantaged part or group of the society. All have established themselves after a long and hard struggle in their life ----- D5 Creation Team',  'simplify'),
		'type' => 'textarea');


// Front Page Fearured Boxs
		
	$options[] = array(
		'desc' => '<span class="featured-area-title">'. __('First Row Featured Boxs', 'simplify') .'</span>', 
		'type' => 'info');
		
	$options[] = array(
		'name' => __('Row Subject',  'simplify'),
		'desc' => __('Input your Row Title Here.',  'simplify'),
		'id' => 'featuredr-title',
		'std' => __('Recent Works',  'simplify'),
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Row Description',  'simplify'),
		'desc' => __('Input the description of Featured Areas. Please limit the words within 30 so that the layout should be clean and attractive.',  'simplify'),
		'id' => 'featuredr-description',
		'std' => __('The Color changing options of Simplify will give the WordPress Driven Site an attractive look.', 'simplify'),
		'type' => 'textarea');
		
		
	$fbsin=array("1","2","3");
	foreach ($fbsin as $fbsinumber) {
	
	$options[] = array(
		'desc' => '<b>' . __('FEATURED BOX: ', 'simplify') . $fbsinumber . '</b>',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Image',  'simplify'),
		'desc' => __('Upload an image for the Featured Box. 200px X 100px image is recommended.  If you do not want to show anything here leave the box blank.', 'simplify'), 
		'id' => 'featured-image' . $fbsinumber,
		'std' => get_template_directory_uri() . '/images/featured-image' . $fbsinumber . '.jpg',
		'type' => 'upload');	
	
	$options[] = array(
		'name' => __('Title',  'simplify'),
		'desc' => __('Input your Featured Title here. Please limit it within 30 Letters. If you do not want to show anything here leave the box blank.',  'simplify'),
		'id' => 'featured-title' . $fbsinumber,
		'std' => __('Simplify Theme for Small Business', 'simplify'),
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Description',  'simplify'),
		'desc' => __('Input the description of Featured Areas. Please limit the words within 30 so that the layout should be clean and attractive.',  'simplify'),
		'id' => 'featured-description' . $fbsinumber,
		'std' => __('The Color changing options of Simplify will give the WordPress Driven Site an attractive look. Simplify is super elegant and Professional Responsive Theme which will create the business widely expressed.',  'simplify'),
		'type' => 'textarea');
	
	}
	
	
	$options[] = array(
		'desc' => '<span class="featured-area-title">'. __('Second Row Featured Boxs', 'simplify') .'</span>', 
		'type' => 'info');
		
	$options[] = array(
		'name' => __('Show Second Row Featured Boxs', 'simplify'),
		'desc' => __('Uncheck this if you do not want to show the Second Row Featured Boxs',  'simplify'),
		'id' => 'srfbox',
		'std' => '1',
		'type' => 'checkbox' );	
	
	$options[] = array(
		'name' => __('Row Subject',  'simplify'),
		'desc' => __('Input your Row Title Here.',  'simplify'),
		'id' => 'featuredr2-title',
		'std' => __('Our Services', 'simplify'),
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Row Description',  'simplify'),
		'desc' => __('Input the description of Featured Areas. Please limit the words within 30 so that the layout should be clean and attractive.', 'simplify'), 
		'id' => 'featuredr2-description',
		'std' => __('Simplify is super elegant and Professional Responsive Theme which will create the business widely expressed.', 'simplify'),
		'type' => 'textarea');
		

	foreach (range(1, 3) as $fbsinumber) {
	
	$options[] = array(
		'desc' => '<b>' . __('FEATURED BOX: ', 'simplify') . $fbsinumber . '</b>',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Image',  'simplify'),
		'desc' => __('Upload an image for the Featured Box. 50px X 50px image is recommended. If you do not want to show anything here leave the box blank.', 'simplify'), 
		'id' => 'featured-image2' . $fbsinumber,
		'std' => get_template_directory_uri() . '/images/featured-image' . $fbsinumber . '.png',
		'type' => 'upload');	
	
	$options[] = array(
		'name' => __('Title',  'simplify'),
		'desc' => __('Input your Featured Title here. Please limit it within 30 Letters. If you do not want to show anything here leave the box blank.',  'simplify'),
		'id' => 'featured-title2' . $fbsinumber,
		'std' => __('Simplify Theme for Business', 'simplify'),
		'type' => 'text'); 
	
	$options[] = array(
		'name' => __('Description',  'simplify'),
		'desc' => __('Input the description of Featured Areas. Please limit the words within 30 so that the layout should be clean and attractive.',  'simplify'),
		'id' => 'featured-description2' . $fbsinumber,
		'std' => __('Simplify is super elegant and Professional Responsive Theme which will create the business widely expressed. The Color changing options of Simplify will give the WordPress Driven Site an attractive look.', 'simplify'),
		'type' => 'textarea');

	}

	$options[] = array(
		'name' => __('Do not show any Posts or Page in the Front Page ',  'simplify'),
		'desc' => __('Check the Box if you do not want to show any Posts or Page in the Front Page', 'simplify'), 
		'id' => 'fpost',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Use Responsive Layout',  'simplify'),
		'desc' => __('Check the Box if you want the Responsive Layout of your Website',  'simplify'),
		'id' => 'responsive',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array(
		'desc' => '<span class="featured-area-title">'.__('Social Links', 'simplify') .'</span>', 
		'type' => 'info');
		
	$options[] = array(
		'name' => __('You Tube Channel Link',  'simplify'),
		'desc' => __('Input your You Tube Channel URL here.',  'simplify'),
		'id' => 'youtube-link',
		'std' => '#',
		'type' => 'text');

	$options[] = array(
		'name' => __('Google Plus Link',  'simplify'),
		'desc' => __('Input your Google Plus URL here.',  'simplify'),
		'id' => 'gplus-link',
		'std' => '#',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Picassa Web Album Link',  'simplify'),
		'desc' => __('Input your Picassa URL here.',  'simplify'),
		'id' => 'picassa-link',
		'std' => '#',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Linked In Link',  'simplify'),
		'desc' => __('Input your Linked In URL here.',  'simplify'),
		'id' => 'li-link',
		'std' => '#',
		'type' => 'text');

	$options[] = array(
		'name' => __('Feed or Blog Link',  'simplify'),
		'desc' => __('Input your Feed or Blog URL here.',  'simplify'),
		'id' => 'feed-link',
		'std' => '#',
		'type' => 'text');
		
		
	
	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>


<?php
}
