<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if( !is_user_logged_in() ){
    wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ).'subscriptions/' );
}
$current_user = wp_get_current_user();
$current_user_mail  = $current_user->user_email;
$current_user_name  = $current_user->username;
$current_user_id  = $current_user->ID;
$order_id   = wc_get_order_id_by_order_key( $_GET['key'] );
if( !empty( $order_id ) ){
    $order      = new WC_Order( $order_id );
    $order_mail = $order->get_billing_email();
}
if( !empty( $current_user_mail ) && !empty( $order_mail ) ){
    if( $current_user_mail != $order_mail ){
        wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
    }
}
if (class_exists('acf')) {
    $page_title     = get_field('thank_you_page_title', 'option');
    $resorces_link  = get_field('thank_you_more_resources_link', 'option');
}
if(isset($_GET['key'])){
    $order_id   = wc_get_order_id_by_order_key( $_GET['key'] );    
    
    if( !empty($order_id) ){
        //store key value from URL.....
        $order      = new WC_Order( $order_id );
        $order_mail = $order->get_billing_email();
        update_post_meta( $order_id, 'kerrybodine_sub_enterprise_parent_order_key', $order_mail );       
    }
}

?>
<div class="main_page_order_thank_you">
    <h2 class="page_title"><?php echo $page_title; ?></h2>
    <div class="woocommerce-order">

            <?php if ( $order ) : ?>

                    <?php if ( $order->has_status( 'failed' ) ) : ?>

                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
                                    <?php if ( is_user_logged_in() ) : ?>
                                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
                                    <?php endif; ?>
                            </p>

                    <?php else : ?>
                            <?php if( $order->get_total() == 0  ){ ?>
                                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you! Check your inbox for your download.', 'woocommerce' ), $order ); ?></p>
                            <?php } ?>
                            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                                    <li class="woocommerce-order-overview__order order">
                                            <span><?php _e( 'Order number', 'woocommerce' ); ?></span>
                                            <strong><?php echo $order->get_order_number(); ?></strong>
                                    </li>

                                    <li class="woocommerce-order-overview__date date">
                                            <span><?php _e( 'Date', 'woocommerce' ); ?></span>
                                            <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
                                    </li>

                                    <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                                            <li class="woocommerce-order-overview__email email">
                                                    <span><?php _e( 'Email', 'woocommerce' ); ?></span>
                                                    <strong><?php echo $order->get_billing_email(); ?></strong>
                                            </li>
                                    <?php endif; ?>

                                    <li class="woocommerce-order-overview__total total">
                                            <span><?php _e( 'Total', 'woocommerce' ); ?></span>
                                            <strong><?php echo $order->get_formatted_order_total(); ?></strong>
                                    </li>

                                    <?php 
                                    $card_meta_data = get_card_meta_data( $order_id );
                                    if ( !empty( $card_meta_data['last4'] ) ) : ?>
                                            <li class="woocommerce-order-overview__payment-method method">
                                                    <span><?php _e( 'Payment', 'woocommerce' ); ?></span>
                                                    <strong><?php echo 'Card ending in '.$card_meta_data['last4']; ?></strong>
                                            </li>
                                    <?php endif; ?>

                            </ul>

                            <?php 
                                acf_form_head();
                                $order_id  = $order->get_id();
                                $sub_products = array();                                
                                foreach ($order->get_items() as $item_id => $item_data) {
                                    $sub_products['product_id'][]   = $item_data->get_product_id();
                                    $sub_products['product_quat'][] = $item_data->get_quantity(); // Get the item quantity
                                }
                                $j = 0;
                                for($j=0; $j < count($sub_products['product_id']) ; $j++)  {
                                    $pro_id = $sub_products['product_id'][$j];
                                    $pro_qt = $sub_products['product_quat'][$j];
                                    if(!have_rows('kerrybodine_sub_starter_users',$order_id) && $pro_id == HUBBB_BASIC_PRODUCT){
                                        for($i=0; $i < $pro_qt ; $i++)  {
                                            add_row('kerrybodine_sub_starter_users',array(),$order_id);
                                        }                                
                                    } elseif(!have_rows('kerrybodine_sub_pro_users',$order_id) && $pro_id == HUBBB_ADVANCE_PRODUCT){
                                        for($k=0; $k < $pro_qt ; $k++)  {
                                            add_row('kerrybodine_sub_pro_users',array(),$order_id);
                                        } 
                                    } elseif(!have_rows('kerrybodine_sub_enterprise_users',$order_id) && $pro_id == HUBBB_ENTERPRISE_PRODUCT){
                                        for($l=0; $l < $pro_qt ; $l++)  {
                                            add_row('kerrybodine_sub_enterprise_users',array(),$order_id);
                                        } 
                                    }
                                }


                                if(in_array(HUBBB_BASIC_PRODUCT, $sub_products['product_id'])) {
                                    acf_form(array(
                                                'id'                => 'basic-mem',
                                                'post_id'           => $order_id,
                                                'field_groups'      => array(HUBBB_BASIC_FGROUP_ID),                                        
                                                'submit_value'      => 'Send Invitations',
                                                'updated_message'   => __("Thank you!", 'acf'),
                                    ));
                                }
                                if(in_array(HUBBB_ADVANCE_PRODUCT, $sub_products['product_id'])) {
                                    acf_form(array(
                                                'id'                => 'advance-mem',
                                                'post_id'           => $order_id,
                                                'field_groups'      => array(HUBBB_ADVANCE_FGROUP_ID),                                        
                                                'submit_value'      => 'Send Invitations',
                                                'updated_message'   => __("Thank you!", 'acf'),
                                    )); 
                                }
                                if(in_array(HUBBB_ENTERPRISE_PRODUCT, $sub_products['product_id'])) {
                                    acf_form(array(
                                                'id'                => 'ent-mem',
                                                'post_id'           => $order_id,
                                                'field_groups'      => array(HUBBB_ENTERPRISE_FGROUP_ID),                                        
                                                'submit_value'      => 'Send Invitations',
                                                'updated_message'   => __("Thank you!", 'acf'),
                                    )); 
                                }

                                $un = array();
                                $ue = array();
                                $uep = array();
                                if( class_exists("acf") ) {
                                    $users_s = get_field('kerrybodine_sub_starter_users' , $order_id);
                                    $users_p = get_field('kerrybodine_sub_pro_users' , $order_id);
                                    $users_e = get_field('kerrybodine_sub_enterprise_users' , $order_id);

                                    foreach($users_s as $users_s_val){
                                        if(!empty($users_s_val['kerrybodine_sub_starter_email'])){
                                            $un[] = $users_s_val['kerrybodine_sub_starter_email'];
                                        }
                                    }

                                    foreach($users_p as $users_p_val){
                                        if(!empty($users_p_val['kerrybodine_sub_pro_email'])){
                                            $ue[] = $users_p_val['kerrybodine_sub_pro_email'];
                                        }
                                    }

                                    foreach($users_e as $users_e_val){
                                        if(!empty($users_e_val['kerrybodine_sub_enterprise_email'])){
                                            $uep[] = $users_e_val['kerrybodine_sub_enterprise_email'];
                                        }
                                    }

                                    if($un){
                                ?>
                                    <script>
                                        jQuery( "#basic-mem .acf-form-submit" ).remove();
                                        jQuery('#basic-mem').find(':input').each(function () {
                                            jQuery(this).prop('readonly', true);
                                        });
                                    </script>
                                <?php  } if($ue){ ?>
                                    <script>
                                        jQuery( "#advance-mem .acf-form-submit" ).remove();
                                        jQuery('#advance-mem').find(':input').each(function () {
                                            jQuery(this).prop('readonly', true);
                                        });
                                    </script>
                                <?php  } if($uep){ ?>
                                    <script>
                                        $cnt = 0;
                                        $total_fields = jQuery('#ent-mem').find('table.acf-table tbody tr').length - 1;
                                        jQuery('#ent-mem').find('table.acf-table tbody tr').each(function (){
                                           if(jQuery(this).find(':input').val() !== "" ){
                                               $cnt++;
                                           }
                                        });                                        
                                        jQuery('#ent-mem').find(':input').each(function () {                                            
                                            if(jQuery(this).val() !== ""){
                                                jQuery(this).prop('readonly', true);
                                                jQuery(this).addClass('mail_sent');
                                                if( jQuery(this).attr('type') == "email" ){
                                                    jQuery(this).after('<div class="sent_msg"><p>Invitation sent</p></div>');
                                                }
                                            }
                                        });                                        
                                        if( $total_fields === $cnt ){
                                            jQuery( "#ent-mem .acf-form-submit input" ).attr('disabled','disabled');
                                        }
                                    </script>
                                <?php       
                                    }
                                } 
                            ?>

                    <?php endif; ?>

                    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                    <?php // do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

            <?php else : ?>

                    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you! Check your inbox for your download.', 'woocommerce' ), null ); ?></p>

            <?php endif; ?>

    </div>
    <a class="back_page_link" href="<?php echo $resorces_link['url']; ?>" target="<?php echo $resorces_link['target']; ?>"><?php echo $resorces_link['title']; ?></a>
</div>