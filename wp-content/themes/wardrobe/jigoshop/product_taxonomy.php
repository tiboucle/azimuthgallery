<?php
/**
 * Product taxonomy template
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
	<?php $term = get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']); ?>
			
	<h3 class="section-title"><?php echo wptexturize($term->name); ?></h3>
		
	<?php echo wpautop(wptexturize($term->description)); ?>
	
	<?php jigoshop_get_template_part( 'loop', 'shop' ); ?>
	
	<?php colabs_pagination();//do_action('jigoshop_pagination'); ?>
	</div>
<?php do_action('jigoshop_after_main_content'); // </div></div> ?>



<?php get_footer('shop'); ?>