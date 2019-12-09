<?php

/*
Template Name: My Account Page
*/

get_header();
echo '<div class="kb_myaccount_page">'.do_shortcode('[woocommerce_my_account]').'</div>';
//do_action( 'objectiv_page_content' );
get_footer();
?>