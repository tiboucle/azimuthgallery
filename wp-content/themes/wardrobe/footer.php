<?php global $colabs_options,$site_title,$site_url,$site_description; ?>
<div class="footer section row">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-sidebar') ) : ?>
				
			<?php
			/* Best Seller Widget */
			$bestseller = new Colabs_Best_Sellers_Widget();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget column col4 widget_colabs_best_sellers_widget">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Best Sellers', 'colabsthemes' ),
				'image' =>'enable',
				'number' => 2			
			);
			$bestseller->widget( $args, $instance );
			?>
			
			<?php
			/* Twitter Widget */
			$twitter = new CoLabs_Twitter();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget column col4 widget_colabs_twitter">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Twitter', 'colabsthemes' ),
				'username' =>'colorlabs',
				'limit' => 2			
			);
			$twitter->widget( $args, $instance );
			?>
			
			<?php
			/* Flickr Widget */
			$flickr = new CoLabs_flickr();	
			$args = array(
				'before_title' => '<h4 class="widget-title">',
				'after_title' => '</h4>',
				'before_widget' => '<div class="widget column col4 widget_colabs_flickr">',
				'after_widget' => '</div>'
			);
			
			$instance = array(
				'title' => __( 'Photos on Flickr', 'colabsthemes' ),
				'id' =>'36587311@N08',
				'type' => 'user',		
				'sorting' => 'random',
				'number' => 4,
				'size' => 's'
			);
			$flickr->widget( $args, $instance );
			?>
	
			
			<?php endif; ?>
		</div><!-- .footer -->

	</div><!-- .content -->
	<?php get_sidebar();?>
	</div><!-- .main -->
</div><!-- .container -->
 <?php wp_footer(); ?>
</body>
</html>

      

   

