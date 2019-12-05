<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Template Name: Log In Template
 *
 * @package WordPress
 * @subpackage hubbb
 * @since hubbb 1.0
 */

get_header(); ?>
	<div class="container">
		<div class="section-wrap text-center">
			<?php 
			    if ( is_active_sidebar( 'login' )  ) {  
			        dynamic_sidebar( 'login' );    
			    } 
			?>	
		</div>
	</div>
<?php
    get_footer();
?>