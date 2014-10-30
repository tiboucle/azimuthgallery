<?php get_header();global $colabs_posttype,$colabs_taxonomy,$plugin;?>
	<?php if(get_option('colabs_promo_text')){?>
	<div class="promo row">
		<h3 ><?php echo get_option('colabs_promo_text');?></h3>
	</div><!-- .promo -->
	<?php }?>
	<?php
		wp_reset_query();
		$headline = get_option('colabs_headline_product');
		$headline_limit= get_option('colabs_headline_limit');
		if($headline_limit=='')$headline_limit=3;
		query_posts( array(
				'showposts' => $headline_limit,
				'post_type' => $colabs_posttype,
				'tax_query' => array(
									array(
									'taxonomy' => $colabs_taxonomy,
									'field' => 'id',
									'terms' => $headline
									)
								)
			));
		if ( have_posts() ):
	?>
	<div class="flex-container ducktape row">
			<div class="flexslider">
				<ul class="slides">
					<?php while ( have_posts() ) : the_post(); ?>
					<li>
						<?php colabs_image('width=682&height=371');?>
						<div class="flex-caption">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						</div>
					</li>
					<?php endwhile; ?>
				</ul>
			</div><!-- .flexslider -->
	</div><!-- .flex-container -->
	<?php endif;?>
	
	<?php
		wp_reset_query();
		if($colabs_posttype=='wpsc-product'){
			$featured = get_option('sticky_products');
			$arg = array(
						'post__in' 			=> $featured,
						'post_type' 		=> $colabs_posttype
					 );
		}else if($colabs_posttype=='product'){
			if($plugin=='woo'){
				$arg = array(
						'post_type' 		=> $colabs_posttype,
						'meta_key'			=> '_featured',
						'meta_value'		=> 'yes'
					 );	
			}else		 
			$arg = array(
                    'post_type' 		=> $colabs_posttype,
					'meta_key'			=> 'featured',
					'meta_value'		=> 'yes'
                 );
		}else if($plugin=='woo'){
			$arg = array(
                    'post_type' 		=> $colabs_posttype,
					'meta_key'			=> '_featured',
					'meta_value'		=> 'yes'
                 );		 
		}else {
			$arg = array(
                    'post_type' 		=> $colabs_posttype,
                    'posts_per_page' 	=> 6,
                    'paged' 			=> 1
                 );
		}
		query_posts($arg);
		if ( have_posts() ):
	?>
	<div class="featured section items-grid row">
			<h3 class="section-title"><?php _e( 'Featured Products', 'colabsthemes' ); ?></h3>
			<ul>
				<?php while ( have_posts() ) : the_post(); ?>
				<li class="column">
					<?php colabs_image('width=202&height=202');?>
					<div class="item-detail">
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<?php if($plugin=='woo'){?>
							<?php global $_product; $_product = &new woocommerce_product( $post->ID );?>
							<p class="item-price"><?php echo $_product->get_price_html(); ?></p>
							<a href="<?php echo $_product->add_to_cart_url(); ?>" class="buttons orange buy"><?php _e('Add To Cart','colabsthemes');?></a>
						<?php }elseif($plugin=='jigoshop'){?>
							<?php global $_product; $_product = &new jigoshop_product( $post->ID );?>
							<p class="item-price"><?php echo $_product->get_price_html(); ?></p>
							<a href="<?php echo $_product->add_to_cart_url(); ?>" class="buttons orange buy"><?php _e('Add To Cart','colabsthemes');?></a>
						<?php }elseif($plugin=='wpsc'){?>
							<p class="item-price"><?php echo wpsc_the_product_price(); ?></p>
							<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
							<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
							<?php else: ?>
							<?php $action = htmlentities(wpsc_this_page_url(), ENT_QUOTES, 'UTF-8' ); ?>					
							<?php endif; ?>
							<form class="product_form"  enctype="multipart/form-data" action="<?php echo $action; ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>" >
								<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>
									<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
									<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>
								<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
										<?php if(wpsc_product_has_stock()) : ?>
											<div class="wpsc_buy_button_container">
												
													<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
													<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
													<input class="wpsc_buy_button" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'colabsthemes' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
													<?php else: ?>
													<input type="submit" value="<?php _e('Add To Cart','colabsthemes'); ?>" name="Buy" class="wpsc_buy_button button yellow cart dark" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
													<?php endif; ?>
												<div class="wpsc_loading_animation">
													<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
													<?php _e('Updating cart...', 'colabsthemes'); ?>
												</div><!--close wpsc_loading_animation-->	
											</div><!--close wpsc_buy_button_container-->
										<?php endif ; ?>
								<?php endif ; ?>
									
								<?php do_action ( 'wpsc_product_form_fields_end' ); ?>
							</form>
						<?php }?>
					</div>
				</li>
				<?php endwhile; ?>
				
			</ul>
		</div><!-- .featured.section -->
		<?php endif;?>
		
		<?php
		wp_reset_query();
		$latest_limit= get_option('colabs_latest_limit');
		if($latest_limit=='')$latest_limit=2;
		query_posts( array(
				'showposts' => $latest_limit
			));
		if ( have_posts() ):
		?>
		<div class="latest section row">
			<h3 class="section-title"><?php _e( 'Latest News', 'colabsthemes' ); ?></h3>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="news column">
				<h4 class="news-title"><?php the_title(); ?></h4>
				<?php colabs_custom_excerpt();?>
				<a href="<?php the_permalink(); ?>" class="more-link"><?php _e( 'Continue Reading', 'colabsthemes' ); ?></a>
			</div>
			<?php endwhile; ?>
		</div><!-- .latest.section -->
		<?php endif;?>
<?php get_footer();?>