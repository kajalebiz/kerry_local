<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage HUBBB
 * @since Hubbb 1.0
 */

get_header(); ?>
<div class="container">
	<div class="section-wrap">
	     <section class="error-404 not-found">
	            <header class="page-header">
	                    <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'hubbb' ); ?></h1>
	            </header><!-- .page-header -->

	            <div class="page-content">
	                    <p><?php _e( 'It looks like nothing was found at this location.', 'hubbb' ); ?></p>

	                    <?php // get_search_form(); ?>
	            </div><!-- .page-content -->
	    </section><!-- .error-404 -->
    </div>
</div>
               

<?php get_footer(); ?>