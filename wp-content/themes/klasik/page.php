<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */

get_header(); ?>
                        
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php the_content( __( 'Read More', 'klasik' ) ); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'klasik' ), 'after' => '</div>' ) ); ?>
            <?php edit_post_link( __( 'Edit', 'klasik' ), '<span class="edit-link">', '</span>' ); ?>
            <div class="clear"></div>
            
        </div><!-- #post -->

        <?php comments_template( '', true ); ?>

        <?php endwhile; ?>
        
        <div class="clear"></div><!-- clear float --> 
                  	
<?php get_footer(); ?>