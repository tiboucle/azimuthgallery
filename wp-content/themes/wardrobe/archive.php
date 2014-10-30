<?php get_header();global $colabs_posttype,$colabs_taxonomy,$plugin;?>
	<div class="page-section row">
			
			<div class="breadcrumbs">
				 <?php colabs_breadcrumb();?>
			</div>
			
			<div class="content-helper row">
				<div class="search-form fr">
					<form role="search" method="get" id="searchform" action="<?php home_url( '/' ); ?>" >
						<input type="text" placeholder="Enter your search here..." name="s" id="s">
						<input type="submit">
					</form>	
				</div>

				<div class="category-switcher fr">
					<?php _e('SORT BY CATEGORY','colabsthemes'); ?>
					<?php wp_dropdown_categories();?>
					<script type="text/javascript"><!--
						var dropdown = document.getElementById("cat");
						function onCatChange() {
							if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
								location.href = "<?php echo get_option('home');
					?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
							}
						}
						dropdown.onchange = onCatChange;
					--></script>
				</div>
			</div><!-- .content-helper -->
			
			<?php wp_reset_query();?>
			<?php while (have_posts()) : the_post(); ?>
			<div class="post">
			
				<ul class="entry-meta">
					
					<li class="meta-date"><?php the_time('F j, Y');?></li>
					<li class="meta-author"><?php the_author_posts_link(); ?></li>
					<li class="meta-category"><?php the_category(' ,');?></li>
					<li class="meta-comment"><a href="<?php comments_link(); ?>"><?php comments_number( __('Add Comment','colabsthemes'), __('1 Comment','colabsthemes'), __('% Comments','colabsthemes') ); ?></a></li>
					<?php if(colabs_image('return=true')){?>
					<li class="meta-image"><?php colabs_image('width=97&height=96');?></li>
					<?php }?>
				</ul><!-- .entry-meta -->

				<div class="entry-content">
					<h2 class="entry-header">
						<a href="<?php the_permalink();?>"><?php the_title();?></a>
					</h2>
					
					<?php colabs_custom_excerpt();?>
					
				</div><!-- .entry-content -->
			
			</div>
			<?php endwhile; ?>

			<?php colabs_pagination();?><!-- .pagination -->
		</div><!-- .page-section -->

<?php get_footer();?>