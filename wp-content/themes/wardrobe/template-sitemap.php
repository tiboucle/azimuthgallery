<?php
/* Template Name: Sitemap */
?>
<?php get_header();global $colabs_posttype,$colabs_taxonomy,$plugin;?><!-- .header -->

	<div class="page-section row">
		<div class="breadcrumbs">
			<?php colabs_breadcrumb();?>
		</div><!-- .breadcrumbs -->

		

		<div class="post">
		<div class="entry-content">
			<h2 class="entry-header"><?php _e('Sitemap','colabsthemes');?></h2>
			
			<h4><?php _e('Pages :','colabsthemes');?></h4>
				<ul >
				<?php wp_list_pages('depth=1&title_li='); ?>
				</ul>

			<h4><?php _e('RSS Feed :','colabsthemes');?></h4>
				<ul>
						<li><a href="<?php bloginfo('rdf_url'); ?>" title="RDF/RSS 1.0 feed"><acronym title="Resource Description Framework">RDF</acronym>/<acronym title="Really Simple Syndication">RSS</acronym> 1.0 feed</a></li>
						<li><a href="<?php bloginfo('rss_url'); ?>" title="RSS 0.92 feed"><acronym title="Really Simple Syndication">RSS</acronym> 0.92 feed</a></li>
						<li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS 2.0 feed"><acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed</a></li>
						<li><a href="<?php bloginfo('atom_url'); ?>" title="Atom feed">Atom feed</a></li>
				</ul>

			 <h4 ><?php _e('Blog Categories :','colabsthemes');?></h4>
				<ul >
				<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>
				</ul>

			<h4><?php _e('Monthly Archives :','colabsthemes');?></h2>
				<ul >
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
				
			<?php 
					$taxonomy     = $colabs_taxonomy;
					$orderby      = 'name'; 
					$show_count   = 1;      // 1 for yes, 0 for no
					$pad_counts   = 1;      // 1 for yes, 0 for no
					$hierarchical = 1;      // 1 for yes, 0 for no
					$title        = '';
					
					$args = array(
						'taxonomy'     => $taxonomy,
						'orderby'      => $orderby,
						'show_count'   => $show_count,
						'pad_counts'   => $pad_counts,
						'hierarchical' => $hierarchical,
						'title_li'     => $title
					);
					?>
                <h4><?php _e('Product Categories :','colabsthemes');?></h4>
				<ul >
				<?php wp_list_categories( $args ); ?>
				</ul>	
		</div><!-- .content -->
		</div>
		
	</div><!-- .main -->


<?php get_footer();?>
