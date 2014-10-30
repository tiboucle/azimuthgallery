<?php get_header('shop'); ?>

<?php do_action('woocommerce_before_main_content'); // <div id="container"><div id="content" role="main"> ?>

	<?php $term = get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']); ?>
	<div class="section items-grid row">	
	<?php woocommerce_catalog_ordering();?>
	<h3 class="section-title"><?php echo wptexturize($term->name); ?></h3>
		
	<?php if ($term->description) : ?><div class="term_description"><?php echo wpautop(wptexturize($term->description)); ?></div><?php endif; ?>
	
	<?php woocommerce_get_template_part( 'loop', 'shop' ); ?>
	
	<?php colabs_pagination();//do_action('woocommerce_pagination'); ?>
	</div>
<?php do_action('woocommerce_after_main_content'); // </div></div> ?>


<?php get_footer('shop'); ?>