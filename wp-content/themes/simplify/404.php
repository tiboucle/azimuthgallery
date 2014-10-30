<?php

/* 	Simplify Theme's 404 Error Page
	Copyright: 2012-2014, D5 Creation, www.d5creation.com
	Based on the Simplest D5 Framework for WordPress
	Since Simplify 1.0
*/

get_header(); ?>
<div id="container">
<h1 class="page-title"><?php echo __('Not Found', 'simplify'); ?></h1>
<h3 class="arc-src"><span><?php echo __('Apologies, but the page you requested could not be found. Perhaps searching will help.', 'simplify'); ?></span></h3>

<?php get_search_form(); ?>
<p><a href="<?php echo home_url(); ?>" title="Browse the Home Page"><?php echo __('&laquo; Or Return to the Home Page', 'simplify'); ?></a></p><br /><br />

<h2 class="post-title-color"><?php echo __('You can also Visit the Following. These are the Featured Contents', 'simplify'); ?></h2>
<div class="content-ver-sep"></div><br />
<?php get_template_part( 'featured-box' ); ?>
 
<?php get_footer(); ?>