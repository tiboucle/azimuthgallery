<?php
function klasik_script() {
		
		wp_enqueue_script('jquery');
		
		wp_register_script('prettyphoto-js', get_template_directory_uri().'/js/jquery.prettyPhoto.js', array('jquery'), '3.1.5', true);
		wp_enqueue_script('prettyphoto-js');
	
	if (!is_admin()) {
		
		wp_register_script('flexslider-js', get_template_directory_uri().'/js/jquery.flexslider-min.js', array('jquery'), '2.1', true);
		wp_enqueue_script('flexslider-js');
		
		wp_register_script('elastislide-js', get_template_directory_uri().'/js/jquery.elastislide.js', array('jquery'), '1.0', true);
		wp_enqueue_script('elastislide-js');
		
		wp_register_script('jquicksand', get_template_directory_uri().'/js/quicksand.js', array('jquery'), '1.2.1', true);
		wp_enqueue_script('jquicksand');
		
		wp_register_script('jhoverIntent', get_template_directory_uri().'/js/hoverIntent.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jhoverIntent');
		
		wp_register_script('jsuperfish', get_template_directory_uri().'/js/superfish.js', array('jquery'), '1.4.8', true);
		wp_enqueue_script('jsuperfish');
		
		wp_register_script('jsupersubs', get_template_directory_uri().'/js/supersubs.js', array('jquery'), '0.2', true);
		wp_enqueue_script('jsupersubs');
		
		wp_register_script('jeasing', get_template_directory_uri().'/js/jquery.easing.1.3.js', array('jquery'), '1.3', true);
		wp_enqueue_script('jeasing');
	
		wp_register_script('tinynav', get_template_directory_uri().'/js/tinynav.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('tinynav');
		
		wp_register_script('retinajs', get_template_directory_uri().'/js/retina-1.1.0.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('retinajs');
		
		wp_register_script('camerajs', get_template_directory_uri().'/js/camera.min.js', array('jquery'), '1.3.3', true);
		wp_enqueue_script('camerajs');
		
		wp_register_script('jcustom', get_stylesheet_directory_uri().'/js/custom.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jcustom');
		
	}
}
add_action('init', 'klasik_script');