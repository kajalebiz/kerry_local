<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage HUBBB
 * @since Hubbb 1.0
 */

if(empty(is_user_has_membership())) {
    $login_page = get_field('hub_option_log_in_page' , 'option');
    header("Location: $login_page");
    exit();
} else {
    get_header();
    $include_ids = array();
?>

    <div class="container">
            <?php 

                if ( have_posts() ) : 
            ?>

                    <?php if ( is_home() && ! is_front_page() ) : ?>
                            <header>
                                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                            </header>
                    <?php endif; ?>

                    <?php
                    // Start the loop.

                    while ( have_posts() ) : the_post();
                            if(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN)){
                                $include_ids = hubbb_starter_plan_user_posts();
                            } elseif(hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN)){
                                $include_ids = hubbb_pro_plan_user_posts();
                            } elseif((hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN))|| get_current_user_id() == TEMP_USER || get_current_user_id() == TEMP_USER2  || get_current_user_id() == TEMP_USER3  || get_current_user_id() == TEMP_USER4  || get_current_user_id() == TEMP_USER5  || get_current_user_id() == TEMP_USER6  || get_current_user_id() == TEMP_USER7 || get_current_user_id() == TEMP_USER8 || get_current_user_id() == TEMP_USER9 ){
                                $include_ids = hubbb_enterprise_plan_user_posts();
                            }
                            if ( (in_array(get_the_ID(),$include_ids) && !empty($include_ids)) || is_super_admin() ) {
                        ?>
                            <div class="section-wrap">
                                <div class="section-content">
                                    <h2><?php the_title(); ?></h2>
                                    <?php the_content(); ?>
                                </div>
                            </div>    
                            <?php                                               
//                        if ( is_singular( 'post' ) ) {
//                            the_post_navigation( array(
//                                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next <i class="fas fa-chevron-right"></i>', 'hubbb' ) . '</span> ' ,
//                                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( '<i class="fas fa-chevron-left"></i> Previous', 'hubbb' ) . '</span> ' ,
//                            ) );
//                        }
                    } else {
                        $content_restrict = get_field('hub_option_content_restrict_text' , 'option');
                        echo "<div class='restrict_content'>".$content_restrict."</div>";
                    }
                    // End the loop.
                    endwhile;


            // If no content, include the "No posts found" template.
            else :
                    get_template_part( 'template-parts/content', 'none' );

            endif;

            ?>	
    </div>
            


<?php get_footer(); 
}