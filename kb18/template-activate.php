<?php

/*
Template Name: Activate
 */

date_default_timezone_set("Asia/Kolkata");
get_header();

if(isset($_GET['key'])) {    
    $key = $_GET['key'];
    $pro = substr($key, 0, 1);
    $keys =substr($key, 1);
    $email_id_decrypted = my_simple_crypt( $keys, 'd' );
    
    global $wpdb;
    $res = $wpdb->get_results( "SELECT created_at FROM user_activation_links WHERE user_email = '$email_id_decrypted'", ARRAY_A );
    $created_at     = $res[0]['created_at'];
    $current_date   = date("Y-m-d G:i:s");
    $created_at_48  = date('Y-m-d G:i:s', strtotime($created_at. ' + 2 days'));    
   if($created_at_48 >= $current_date){
            $exists = email_exists( $email_id_decrypted );
            if ( $exists ) {
                $user = get_user_by( 'email', $email_id_decrypted );
                $password  = password_generate(12);
                wp_set_password( $password, $user->ID );
        ?>
        <div class="wp-activate-container">
            <h2>Your account is now active!</h2>
            <div id="signup-welcome">
                <p><span class="h3">Username:</span> <?php echo $email_id_decrypted; ?></p>
                <p><span class="h3">Password:</span> <?php echo $password; ?></p>
            </div>
            <p class="view">
                    Your account is now activated. <a href="https://hub.kerrybodine.com/login/">Log in</a> or go back to the <a href="https://hub.kerrybodine.com/">homepage</a>.
            </p>
        </div>
        <?php
            } else {

            $pass_e             = password_generate(12);

            $result_e           = wp_create_user( $email_id_decrypted, $pass_e , $email_id_decrypted );
            if( is_wp_error( $result_e )){
                echo "<div class='wp-activate-container'><h2>".$result_e->get_error_message()."</h2></div>";
            } else {

            if( $pro == "S" ) {
                $user_membership    = wc_memberships_create_user_membership( array(
                                        'plan_id'    => (int) HUBBB_USE_CASE_BASIC_PLAN,
                                        'user_id'    => (int) $result_e,
                                        'product_id' => (int) HUBBB_BASIC_PRODUCT,
                                        'order_id'   => (int) 'shop_order',
                                ), 'create' );
            } else if($pro == "P"){
                $user_membership    = wc_memberships_create_user_membership( array(
                                        'plan_id'    => (int) HUBBB_USE_CASE_ADVANCE_PLAN,
                                        'user_id'    => (int) $result_e,
                                        'product_id' => (int) HUBBB_ADVANCE_PRODUCT,
                                        'order_id'   => (int) 'shop_order',
                                ), 'create' );

            } else if($pro == "E"){
                $user_membership    = wc_memberships_create_user_membership( array(
                                        'plan_id'    => (int) HUBBB_USE_CASE_ENTERPRISE_PLAN,
                                        'user_id'    => (int) $result_e,
                                        'product_id' => (int) HUBBB_ENTERPRISE_PRODUCT,
                                        'order_id'   => (int) 'shop_order',
                                ), 'create' );

            }
        ?>
        <div class="wp-activate-container">
            <h2>Your account is now active!</h2>
                <div id="signup-welcome">
                <p><span class="h3">Username:</span> <?php echo $email_id_decrypted; ?></p>
                <p><span class="h3">Password:</span> <?php echo $pass_e; ?></p>
                </div>
                <p class="view">
                        Your account is now activated. <a href="https://hub.kerrybodine.com/login/">Log in</a> or go back to the <a href="https://hub.kerrybodine.com/">homepage</a>.</p>
        </div>
        <?php
            }
            }
    }else{ ?>
        <div class="wp-activate-container form-validate">            
            <?php echo do_shortcode('[gravityform id="20" title="false" description="false" ajax="true"]'); ?>
        </div>
   <?php }
} else {
?>
    <div class="wp-activate-container">            
        <h2>Activation Key Required</h2>
    </div>
<?php
}
get_footer();