<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<p><?php
	/* translators: 1: order number 2: order date 3: order status */
	printf(
		__( 'Order #%1$s was placed on %2$s.', 'woocommerce' ),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
		'<mark class="order-date">' . wc_format_datetime( $order->get_date_created(),'M. d, Y' ) . '</mark>'
//		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	);
?></p>

<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
	<h2><?php _e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); 
/*
                            $un = array();
                            $ue = array();
                            $up = array();
                            if( class_exists("acf") ) {
                                $users_s = get_field('kerrybodine_sub_starter_users' , $order_id);
                                $users_p = get_field('kerrybodine_sub_pro_users' , $order_id);
                                $users_r = get_field('kerrybodine_sub_enterprise_users' , $order_id);
                                
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
                                
                                foreach($users_r as $users_r_val){
                                    if(!empty($users_r_val['kerrybodine_sub_enterprise_email'])){
                                        $up[] = $users_r_val['kerrybodine_sub_enterprise_email'];
                                    }
                                }                                                              
                            } 
                        ?>
        
        <div class="my_account_email_section">
            <?php if(!empty($un)) { ?>
                <section class="woocommerce-customer-details">
                        <h2 class="woocommerce-column__title">Journey Mapping Starter Kit Users List</h2>
                        <address>
                            <?php foreach($un as $un_val) { ?>
                                <p class="woocommerce-customer-details--email"><?php echo $un_val; ?></p>
                            <?php } ?>
                        </address>
                 </section>
            <?php } if(!empty($ue)) { ?>
                <section class="woocommerce-customer-details">
                       <h2 class="woocommerce-column__title">Journey Mapping Toolkit Pro Users List</h2>
                       <address>
                           <?php foreach($ue as $ue_val) { ?>
                                <p class="woocommerce-customer-details--email"><?php echo $ue_val; ?></p>
                           <?php } ?>
                       </address>
                </section>
            <?php } if(!empty($up)) { ?>
                <section class="woocommerce-customer-details">
                       <h2 class="woocommerce-column__title">Journey Mapping Toolkit Pro Users List</h2>
                       <address>
                           <?php foreach($up as $up_val) { ?>
                                <p class="woocommerce-customer-details--email"><?php echo $up_val; ?></p>
                           <?php } ?>
                       </address>
                </section>
            <?php } ?>
        </div> */?>