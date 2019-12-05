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
    $bw_text = "";
    $aw_text = "";
    $ep_text = "";
    if( class_exists("acf") ) {
       $bw_text = get_field('basic_use_case_welcome_text' , get_the_ID());
       $aw_text = get_field('advance_use_case_welcome_text' , get_the_ID());
       $ep_text = get_field('enterprise_use_case_welcome_text' , get_the_ID());
    }

    if( hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_BASIC_PLAN) && !empty($bw_text) ) { 
?>		
        <div class="welcome-section section-wrap">
            <div class="container">
                <div class="section-content">
                    <?php echo $bw_text; ?>                        
                </div>
            </div>
        </div>
    <?php } if( hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ADVANCE_PLAN) && !empty($aw_text) ) { ?>		
        <div class="welcome-section section-wrap">
            <div class="container">
                <div class="section-content">
                    <?php echo $aw_text; ?>                        
                </div>
            </div>
        </div>
    <?php } if( (hubbb_get_user_plan(get_current_user_id(), HUBBB_USE_CASE_ENTERPRISE_PLAN) && !empty($ep_text)) || (get_current_user_id() == TEMP_USER) || (get_current_user_id() == TEMP_USER2 )  || (get_current_user_id() == TEMP_USER3 )  || (get_current_user_id() == TEMP_USER4)  || (get_current_user_id() == TEMP_USER5 )  || (get_current_user_id() == TEMP_USER6 )  || (get_current_user_id() == TEMP_USER7 ) || (get_current_user_id() == TEMP_USER8 ) || (get_current_user_id() == TEMP_USER9 ) ) { ?>		
        <div class="welcome-section section-wrap">
            <div class="container">
                <div class="section-content">
                    <?php echo $ep_text; ?>                        
                </div>
            </div>
        </div>
<?php    
    } 
    get_footer();
}