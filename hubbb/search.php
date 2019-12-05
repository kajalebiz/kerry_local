<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage HUBBB
 * @since Hubbb 1.0
 */

get_header(); ?>

    <div class="container">
    	<div class="section-wrap">
           
			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'hubbb' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				// End the loop.
				endwhile;

				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'hubbb' ),
					'next_text'          => __( 'Next page', 'hubbb' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'hubbb' ) . ' </span>',
				) );

	                    // If no content, include the "No posts found" template.
	                    else :
	                            get_template_part( 'template-parts/content', 'none' );

	                    endif;
			?>
		</div>
            
    </div><!-- .content-area -->

<?php get_footer(); ?>