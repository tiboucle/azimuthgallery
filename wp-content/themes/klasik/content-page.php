<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
    
            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'klasik' ), 'after' => '</div>' ) ); ?>
            </div><!-- .entry-content -->
            <footer class="entry-meta">
                <?php edit_post_link( __( 'Edit', 'klasik' ), '<span class="edit-link">', '</span>' ); ?>
            </footer><!-- .entry-meta -->
            <div class="clear"></div>
        </div>
	</article><!-- #post -->
