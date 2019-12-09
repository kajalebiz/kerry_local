<?php

/*
Template Name: Activate
 */

date_default_timezone_set("Asia/Kolkata");
get_header();
if(isset($_GET['key'])) {    
    $key                = $_GET['key'];
    $order_id           = $_GET['orderid'];
    $order_id           = !empty($order_id) ? $order_id : 'shop_order';
    $pro                = substr($key, 0, 1);
    $keys               = substr($key, 1);
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
//                $pa         = password_generate(10);
//                $pasrdxf    = (string) $pa;
//                wp_set_password($pasrdxf, $user->ID );
                $memberships = wc_memberships_get_user_active_memberships( $user->ID );
                if ( empty( $memberships ) ) { 
                    $user_membership    = wc_memberships_create_user_membership( array(
                            'plan_id'    => (int) HUBBB_USE_CASE_ENTERPRISE_PLAN,
                            'user_id'    => (int) $user->ID,
                            'product_id' => (int) HUBBB_ENTERPRISE_PRODUCT,
                            'order_id'   => (int) $order_id,
                    ), 'create' );
                    $subscriptions_ids = wcs_get_subscriptions_for_order( (int) $order_id ); 
                    if(!empty( $subscriptions_ids )){
                        foreach( $subscriptions_ids as $subscription_id => $subscription_obj ){
                            if((int) $order_id ===  (int) $subscription_obj->data['parent_id']){     
                                $sub_end_date       =   get_post_meta((int) $subscription_obj->id,'_schedule_end',true);
                                update_post_meta((int) $user_membership->id,'_subscription_id',(int) $subscription_obj->id);
                                if( !empty( $sub_end_date ) ){
                                }
                                update_post_meta((int) $user_membership->id,'_end_date','Never' );
                                break;
                            }
                        }
                    }
                }
        ?>
        <div class="wp-activate-container">
                    <h2>You account has been activated!</h2>
            <div id="signup-welcome">
                <p><span class="h3">Username:</span> <?php echo $email_id_decrypted; ?></p>
            </div>
            <p class="view">
                            <div class="login-btn button">
                                <a href="https://hub.kerrybodine.com/login/">Log in</a>
                            </div>
            </p>
                        <p class="woocommerce-LostPassword lost_password">
                                <a href="<?php echo 'https://kerrybodine.com/reset-password/?site='.my_simple_crypt( 'https://hub.kerrybodine.com/' ); ?>"><?php esc_html_e( 'Forgot password?', 'woocommerce' ); ?></a>
                        </p>
        </div>
        <?php
        
            } else {
                $pass_e             = password_generate(10);
            $result_e           = wp_create_user( $email_id_decrypted, $pass_e , $email_id_decrypted );
            if( is_wp_error( $result_e )){
                echo "<div class='wp-activate-container'><h2>".$result_e->get_error_message()."</h2></div>";
            } else {

            if( $pro == "S" ) {
                $user_membership    = wc_memberships_create_user_membership( array(
                                        'plan_id'    => (int) HUBBB_USE_CASE_BASIC_PLAN,
                                        'user_id'    => (int) $result_e,
                                        'product_id' => (int) HUBBB_BASIC_PRODUCT,
                                            'order_id'   => (int) $order_id,
                                ), 'create' );
            } else if($pro == "P"){
                $user_membership    = wc_memberships_create_user_membership( array(
                                        'plan_id'    => (int) HUBBB_USE_CASE_ADVANCE_PLAN,
                                        'user_id'    => (int) $result_e,
                                        'product_id' => (int) HUBBB_ADVANCE_PRODUCT,
                                            'order_id'   => (int) $order_id,
                                ), 'create' );




            } else if($pro == "E"){
                $user_membership    = wc_memberships_create_user_membership( array(
                                        'plan_id'    => (int) HUBBB_USE_CASE_ENTERPRISE_PLAN,
                                        'user_id'    => (int) $result_e,
                                        'product_id' => (int) HUBBB_ENTERPRISE_PRODUCT,
                                            'order_id'   => (int) $order_id,
                                ), 'create' );

            }
                $subscriptions_ids = wcs_get_subscriptions_for_order( (int) $order_id ); 
                if(!empty( $subscriptions_ids )){
                    foreach( $subscriptions_ids as $subscription_id => $subscription_obj ){
                        if((int) $order_id ===  (int) $subscription_obj->data['parent_id']){     
                            $sub_end_date       =   get_post_meta((int) $subscription_obj->id,'_schedule_end',true);
                            update_post_meta((int) $user_membership->id,'_subscription_id',(int) $subscription_obj->id);
                            if( !empty( $sub_end_date ) ){
                            }
                            update_post_meta((int) $user_membership->id,'_end_date','Never' );
                            break;
                        }
                    }
                }
        ?>
        <div class="wp-activate-container">
                            <h2>Your account has been activated!</h2>

                <div id="signup-welcome">
                <p><span class="h3">Username:</span> <?php echo $email_id_decrypted; ?></p>
                <p><span class="h3">Password:</span> <?php echo $pass_e; ?></p>
                </div>
                <p class="view">
                                    <div class="login-btn button">
                                        <a href="https://hub.kerrybodine.com/login/">Log in</a>
        </div>
                                </p>                                    
                                <p class="woocommerce-LostPassword lost_password">
                                        <a href="<?php echo 'https://kerrybodine.com/reset-password/?site='.my_simple_crypt( 'https://hub.kerrybodine.com/' ); ?>"><?php esc_html_e( 'Forgot password?', 'woocommerce' ); ?></a>
                                </p>
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