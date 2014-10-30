<?php
/**
 * Archive template
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package    Jigoshop
 * @category   Catalog
 * @author     Jigowatt
 * @copyright  Copyright (c) 2011 Jigowatt Ltd.
 * @license    http://jigoshop.com/license/commercial-edition
 */
?>

<?php get_header('shop'); ?>

<?php do_action('jigoshop_before_main_content'); // <div id="container"><div id="content" role="main"> ?>
	<div class="section items-grid row">
	<?php if (is_search()) : ?>		
		<h3 class="section-title"><?php _e('Search Results:', 'jigoshop'); ?> &ldquo;<?php the_search_query(); ?>&rdquo; <?php if (get_query_var('paged')) echo ' &mdash; Page '.get_query_var('paged'); ?></h3>
	<?php else : ?>
		<h3 class="section-title"><?php _e('All Products', 'jigoshop'); ?></h3>
	<?php endif; ?>
	
	<?php 
		$shop_page_id = get_option('jigoshop_shop_page_id');
		$shop_page = get_post($shop_page_id);
		echo apply_filters('the_content', $shop_page->post_content);
	?>

	<?php jigoshop_get_template_part( 'loop', 'shop' ); ?>
	
	<?php colabs_pagination();//do_action('jigoshop_pagination'); ?>
	</div>

<?php do_action('jigoshop_after_main_content'); // </div></div> ?>

<?php get_footer('shop'); ?>