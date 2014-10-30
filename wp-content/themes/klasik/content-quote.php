<?php
/**
 * The template for displaying posts in the Quote post format
 *
 * @package WordPress
 * @subpackage Klasik
 * @since Klasik 1.0
 */
?>

	<?php 
	$thumb = "";
	if(has_post_thumbnail($post->ID) ){
		$thumb = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'imgquote'));
	}
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="articlecontainer">
            <div class="entry-quote">
                <div class="entry-content">
                    <div class="quote-text">
                        <blockquote>
                            <?php echo get_the_excerpt(); ?>
                        </blockquote>
                     	<div class="quotearrow"></div>
                        <div class="quoteinfo">
                            <?php
                            $withimg = "";
                            if($thumb!=""){
                                echo '<span class="frame">'.$thumb.'</span>';
                                $withimg = "withimg";
                            }
                            ?>
                            <span class="info <?php echo $withimg; ?>"><?php the_title(); ?></span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>

                </div><!-- entry-content -->
                
            </div>
            <div class="clear"></div>
        </div>
	</article><!-- #post -->
