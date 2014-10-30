<?php
/**
 * The Header for our theme.
 *
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

<?php get_template_part( 'site-header'); ?>

<?php $disableSlider = klasik_get_option( 'klasik_disable_slider' ,'');?>

<div id="bodychild">
	<div id="outercontainer">
    
        <!-- HEADER -->
        <div id="outerheader">
        	<div id="headercontainer">
                <div class="container">
                    <header id="top">
                        <div class="row">
                        
                            <div id="logo" class="four columns"><?php klasik_logo();?></div>
                            <section id="navigation" class="eight columns">
                                <nav id="nav-wrap">
                                    <?php wp_nav_menu( array(
                                      'container'       => 'ul', 
                                      'menu_class'      => 'sf-menu',
                                      'menu_id'         => 'topnav', 
                                      'depth'           => 0,
                                      'sort_column'    => 'menu_order',
                                      'fallback_cb'     => 'nav_page_fallback',
                                      'theme_location' => 'mainmenu' 
                                      )); 
                                    ?>
                                </nav><!-- nav -->	
                                <div class="clear"></div>
                            </section>
                            <div class="clear"></div>
                            
                        </div>
                        <div class="clear"></div>
                    </header>
                </div>
                <div class="clear"></div>
            </div>
		</div>
        <!-- END HEADER -->

		<!-- AFTERHEADER -->
        

        
        <?php 

		//$disableSlider = 1;
		
        if( is_front_page() && !$disableSlider  ){
		
			echo '
			<div id="outerslider">
				<div class="container">
					<div class="row">
					<div class="twelve columns">
						<div id="slidercontainer">
							<section id="slider">
								
			
			';
			
			get_template_part( 'slider');
				
			echo '
								
								<div class="clear"></div>
							</section>
							
						</div>
					</div>
					</div>
				</div>
			</div>
			';
			
			$outermainclass = "";
        }else{
			$outermainclass = "noslider"; 
		}
		//$wp_query = null; $wp_query = $temp; wp_reset_query();
		
		if($outermainclass=='noslider'){
		?>
            <div id="outerafterheader" class="<?php echo $outermainclass; ?>" <?php echo klasik_page_image() ?>>
                <div class="container">
                    <div class="row">
                        <div class="twelve columns">
                            <div id="afterheader">
                                <?php  
                                    klasik_page_title();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
		}
		?>
        <!-- END AFTERHEADER -->
        
        

        
		<?php 
		if( is_front_page() && is_active_sidebar('homefeatures')){
		?>
        <!-- FEATURE -->
        <div id="home-featurecontent" class="<?php echo $outermainclass; ?>">
        	<div class="container">
            	<div class="row">
                    <div class="twelve columns">
                    	<div class="home-feature">
                        <?php if ( ! dynamic_sidebar( 'homefeatures' ) ){ } ?>
                     	</div>
                    </div>
            	</div>
            </div>
            <div class="clear"></div>
        </div>
        <!-- END FEATURE -->

		<?php 
		}
		?>
        
        <?php 
		if (is_front_page()) {
		if(is_active_sidebar('homeshowcase')){ 
		?>
        <!-- SHOWCASE -->
        <div id="home-showcasecontent" class="<?php echo $outermainclass; ?>">
        <div class="showcase-wrap">
        	<div class="container">
            	<div class="row">
                    <div class="twelve columns">
                        <div class="home-showcase">
                            <?php if ( ! dynamic_sidebar( 'homeshowcase' ) ){ } ?>
                            <div class="clear"></div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
        </div>
        <!-- END SHOWCASE -->
        
        <?php } 
		}
		?>
        
        <?php 
		if (is_front_page()) {
		if(is_active_sidebar('homehighlight')){ 
		?>
        <!-- HIGHLIGHT -->
        <div id="home-highlightcontent" class="<?php echo $outermainclass; ?>">
        <div class="highlight-wrap">
        	<div class="container">
            	<div class="row">
                    <div class="twelve columns">
                        <div class="home-highlight">
                            <?php if ( ! dynamic_sidebar( 'homehighlight' ) ){ } ?>
                            <div class="clear"></div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
        </div>
        <!-- END HIGHLIGHT -->
        
        <?php } 
		}
		?>


        <!-- MAIN CONTENT -->
        <div id="outermain" class="<?php echo $outermainclass; ?>">
        	<div id="maincontainer">
                <div class="container">
                    <div class="row">
                    <?php get_template_part('layout-header'); ?>
							