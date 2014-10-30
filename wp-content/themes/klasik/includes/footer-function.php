<?php
// get website title
if(!function_exists("klasik_footer_text")){
	function klasik_footer_text(){
	
		$foot= stripslashes(klasik_get_option( 'klasik_footer'));
		if($foot!=""){
        	echo $foot;
        }
		
	}// end klasik_footer_text()
}

// Copyright
if(!function_exists("klasik_copyright_text")){
	function klasik_copyright_text(){

			_e('Copyright', 'klasik'); echo ' &copy; ';
			
				echo date('Y') . ' <a href="'.home_url( '/').'">'.get_bloginfo('name') .'</a>.';
			?>
			<?php _e(' Designed by', 'klasik'); ?>	<a href="<?php echo esc_url( __( 'http://www.klasikthemes.com', 'klasik' ) ); ?>" title=""><?php _e('Klasik Themes','')?></a>.
            
        <?php 
		
	}// end klasik_copyright_text()
}


if(!function_exists("klasik_print_js_menu")){
	
	function klasik_print_js_menu(){
	?>
	<script type="text/javascript">
	//Add Class Js to html
	jQuery('html').addClass('js');	
	
	//=================================== MENU ===================================//
	jQuery("ul.sf-menu").supersubs({ 
	minWidth		: 10,		// requires em unit.
	maxWidth		: 13,		// requires em unit.
	extraWidth		: 3	// extra width can ensure lines don't sometimes turn over due to slight browser differences in how they round-off values
						   // due to slight rounding differences and font-family 
	}).superfish();  // call supersubs first, then superfish, so that subs are 
					 // not display:none when measuring. Call before initialising 
					 // containing tabs for same reason. 
	
	//=================================== MOBILE MENU DROPDOWN ===================================//
	jQuery('#topnav').tinyNav({
		active: 'current-menu-item'
	});	
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_menu",1);
}

if(!function_exists("klasik_print_js_carousel")){
	
	function klasik_print_js_carousel(){
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		//Add Class Js to html
		jQuery('.flexslider-carousel').flexslider({
			animation: "slide",
			touch:true,
			animationLoop: false,
			controlNav: false,
			itemWidth: 160,
			itemMargin: 0,
			minItems: 2,
			maxItems: 6
		});
	});
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_carousel",2);
}

if(!function_exists("klasik_print_js_prettyphoto")){
	
	function klasik_print_js_prettyphoto(){
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		runprettyPhoto();
	});
	
	function runprettyPhoto(){
		//=================================== PRETTYPHOTO ===================================//
		jQuery('a[data-rel]').each(function() {jQuery(this).attr('rel', jQuery(this).data('rel'));});
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({
			animationSpeed:'slow',
			theme:'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
			gallery_markup:'',
			social_tools: false,
			slideshow:2000
		});
	}
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_prettyphoto",3);
}

if(!function_exists("klasik_print_js_quicksand")){
	
	function klasik_print_js_quicksand(){
	?>
	<script type="text/javascript">
	function runquicksand(){
		// get the action filter option item on page load
		var $filterType = jQuery('#filter li.current a').attr('class');
		
		var $holder = jQuery('.portfoliolist');
	
		var $data = $holder.clone();
		
		jQuery('#filter li a').click(function(e) {
			jQuery('#filter li').removeClass('current');
			
			var $filterType = jQuery(this).data('filter');
			
			jQuery(this).parent().addClass('current');
			
			if ($filterType == '*') {
				var $filteredData = $data.find('div.item');
			} 
			else {
				var $filteredData = $data.find('div.item.' + $filterType );
			}
			
			$holder.quicksand($filteredData, {
				easing: 'easeOutQuart',
				adjustWidth: 'dynamic',
				enhancement: function(){
					runprettyPhoto();
					jQuery('.klasik-pf-img a').hover(
						function() {
							jQuery(this).find('.rollover').stop().fadeTo(500, 0.6);
						},
						function() {
							jQuery(this).find('.rollover').stop().fadeTo(500, 0);
						}
					
					);
				}
			});
			return false;
		});
	}
	
	jQuery(window).load(function(){
		runquicksand();
	});
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_quicksand",4);
}

if(!function_exists("klasik_print_js_tabs")){
	
	function klasik_print_js_tabs(){
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		//=================================== TABS AND TOGGLE ===================================//
		//jQuery tab
		jQuery(".tab-content").hide(); //Hide all content
		jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
		jQuery(".tab-content:first").show(); //Show first tab content
		//On Click Event
		jQuery("ul.tabs li").click(function() {
			jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
			jQuery(this).addClass("active"); //Add "active" class to selected tab
			jQuery(".tab-content").hide(); //Hide all tab content
			var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			jQuery(activeTab).show(); //Fade in the active content
			return false;
		});
	});
	</script>
	<?php
	}
	add_action("klasik_foot","klasik_print_js_tabs",5);
}

if(!function_exists("klasik_foot")){
	function klasik_foot(){
		do_action("klasik_foot");
	}
}
add_action("wp_footer","klasik_foot",20);

?>
