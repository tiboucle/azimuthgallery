<?php get_header();global $colabs_posttype,$colabs_taxonomy,$plugin;?>
	<div class="page-section row">
						
			<div class="breadcrumbs">
				 <?php colabs_breadcrumb();?>
			</div>

			<div class="post">
			<?php wp_reset_query();?>
			<?php if ( have_posts() ):?>
			<?php while (have_posts()) : the_post(); ?>

				<div class="<?php if($plugin!='wpsc')echo 'entry-content';?>">
					<h2 class="entry-header">
						<?php the_title();?>
					</h2>
					<?php   
					$single_top = get_post_custom_values("colabs_single_top");
					if (($single_top[0]!='')||($single_top[0]=='none')){
					?>
						<div class="singleimage">
							<?php 
									
							if ($single_top[0]=='single_video'){
								$embed = colabs_get_embed('colabs_embed',635,335,'single_video',$post->ID);
								if ($embed!=''){
									echo $embed; 
								}
							}elseif($single_top[0]=='single_image'){
								colabs_image('width=635');				
							}
										
							?>
						</div>
					<?php }?>
					<?php the_content();?>
					
					
				</div><!-- .entry-content -->
			<?php endwhile; ?>
			<?php comments_template( '', true ); ?><!-- #comments --><!-- #comments -->
			<?php else: ?>
				
				<h2><?php _e('No posts found. Try a different search?','colabsthemes');?></h2>
				
			<?php endif;?>
			</div>

		</div><!-- .page-section -->

<?php get_footer();?>