<?php
global $wp_query;	
$image_width = get_option('product_image_width');
/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
?>

<div class="section items-grid row">
	<?php if(wpsc_display_products()): ?>
	<ul>
		<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
		<li class="column">
					<?php colabs_image('width=202&height=202');?>
					<div class="item-detail">
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
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
													<input type="submit" value="<?php _e('Add To Cart','colabsthemes');?>" name="Buy" class="wpsc_buy_button button yellow cart dark" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
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
						
					</div>
		</li>
		<?php endwhile;?>
	</ul>
	<?php endif;?>
	
				<div class="wpsc-pagination">
<?php wpsc_pagination();//colabs_pagination();?><!-- .pagination -->
</div>
	
</div>
