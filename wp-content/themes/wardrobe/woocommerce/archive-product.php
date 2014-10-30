<?php get_header('shop'); ?>
	  
<?php do_action('woocommerce_before_main_content'); // <div id="container"><div id="content" role="main"> ?>
	<div class="section items-grid row">
	<?php 
		$shop_page_id = get_option('woocommerce_shop_page_id');
		$shop_page = get_post($shop_page_id);
		$shop_page_title = (get_option('woocommerce_shop_page_title')) ? get_option('woocommerce_shop_page_title') : $shop_page->post_title;
		woocommerce_catalog_ordering();
	?>
	
	<?php if (is_search()) : ?>		
		<h3 class="section-title"><?php _e('Search Results:', 'woothemes'); ?> &ldquo;<?php the_search_query(); ?>&rdquo; <?php if (get_query_var('paged')) echo ' &mdash; Page '.get_query_var('paged'); ?></h3>
	<?php else : ?>
		<h3 class="section-title"><?php echo apply_filters('the_title', $shop_page_title); ?></h3>
	<?php endif; ?>
	
	<?php echo apply_filters('the_content', $shop_page->post_content); ?>

	<?php woocommerce_get_template_part( 'loop', 'shop' ); ?>
	
	<?php colabs_pagination();//do_action('woocommerce_pagination'); ?>
	</div>
<?php do_action('woocommerce_after_main_content'); // </div></div> ?>


<?php get_footer('shop'); ?>