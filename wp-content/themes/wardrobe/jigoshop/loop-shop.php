<?php
/**
 * Loop shop template
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

<?php
global $columns, $per_page;

do_action('jigoshop_before_shop_loop');

$loop = 0;

if (!isset($columns) || !$columns) $columns = apply_filters('loop_shop_columns', 4);
//if (!isset($per_page) || !$per_page) $per_page = apply_filters('loop_shop_per_page', get_option('posts_per_page'));

//if ($per_page > get_option('posts_per_page')) query_posts( array_merge( $wp_query->query, array( 'posts_per_page' => $per_page ) ) );

ob_start();

if (have_posts()) : while (have_posts()) : the_post(); $_product = &new jigoshop_product( $post->ID ); $loop++;

	?>
	<li class="column">
					<?php colabs_image('width=202&height=202');?>
					<div class="item-detail">
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						
							<?php global $_product; $_product = &new jigoshop_product( $post->ID );?>
							<p class="item-price"><?php echo $_product->get_price_html(); ?></p>
							<a href="<?php echo $_product->add_to_cart_url(); ?>" class="buttons orange buy"><?php _e('Add To Cart','colabsthemes');?></a>
						
					</div>
				</li><?php

	if ($loop==$per_page) break;

endwhile; endif;

if ($loop==0) :

	echo '<p class="info">'.__('No products found which match your selection.', 'jigoshop').'</p>';

else :

	$found_posts = ob_get_clean();

	echo '<ul >' . $found_posts . '</ul><div class="clear"></div>';

endif;

do_action('jigoshop_after_shop_loop');
