<?php get_header();global $colabs_posttype,$colabs_taxonomy,$plugin;?>
	<div class="page-section row">
			
			<div class="breadcrumbs">
				 <?php colabs_breadcrumb();?>
			</div>

			<div class="post">
			<?php wp_reset_query();?>
			<?php while (have_posts()) : the_post(); ?>
				<ul class="entry-meta">
					<?php if(colabs_image('return=true')){?>
					<li class="meta-image"><?php colabs_image('width=97&height=96');?></li>
					<?php }?>
					<li class="meta-date"><?php the_time('F j, Y');?></li>
					<li class="meta-author"><?php the_author_posts_link(); ?></li>
					<li class="meta-category"><?php the_category(' ,');?></li>
					<li class="meta-comment"><a href="<?php comments_link(); ?>"><?php comments_number( __('Add Comment','colabsthemes'), __('1 Comment','colabsthemes'), __('% Comments','colabsthemes') ); ?></a></li>
				</ul><!-- .entry-meta -->

				<div class="entry-content">
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
					<?php the_tags();?>
					<?php echo colabs_share(); ?>
					<div class="entry-author">
						<?php $email = get_the_author_email(); ?>
						<?php echo get_avatar( $email, $size = '70'); ?>
						<div class="author-description">
							<h6><?php _e('About The Author','colabsthemes');?></h6>
							<p><?php the_author_meta( 'description' ); ?></p>
							<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php _e('View all post by','colabsthemes');?> <?php the_author_meta('display_name'); ?></a>
						</div>
					</div><!-- .entry-author -->
				</div><!-- .entry-content -->
			<?php endwhile; ?>
			<?php comments_template( '', true ); ?><!-- #comments --><!-- #comments -->
			</div>

		</div><!-- .page-section -->

<?php get_footer();?>