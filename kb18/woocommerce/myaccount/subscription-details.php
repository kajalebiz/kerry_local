<?php
/**
 * Subscription details table
 *
 * @author  Prospress
 * @package WooCommerce_Subscription/Templates
 * @since 2.2.19
 * @version 2.6.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$subscription_orders    = reset( $subscription->get_related_orders() );
$order_id               = $subscription_orders;
$order                  = wc_get_order( $subscription_orders );
$item_count             = $order->get_item_count();
$order_received         = $order->get_checkout_order_received_url();

?>

<p><?php
	/* translators: 1: order number 2: order date 3: order status */
	printf(
		__( 'Subscription #%1$s was placed on %2$s.', 'woocommerce' ),
		'<mark class="order-number">' . $subscription->id . '</mark>',
		'<mark class="order-date">' . esc_html( $subscription->get_date_to_display( 'start_date' ) ) . '</mark>'
//		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
	);
?></p>
<h2 class="woocommerce-order-details__title"><?php _e( 'Subscription details', 'woocommerce' ); ?></h2>
<table class="shop_table subscription_details">
	<tbody>
		<tr>
			<td><?php esc_html_e( 'Status', 'woocommerce-subscriptions' ); ?></td>
			<td><?php echo esc_html( wcs_get_subscription_status_name( $subscription->get_status() ) ); ?></td>
		</tr>
		<?php do_action( 'wcs_subscription_details_table_before_dates', $subscription ); ?>
		<?php
		$dates_to_display = apply_filters( 'wcs_subscription_details_table_dates_to_display', array(
//			'start_date'              => _x( 'Start date', 'customer subscription table header', 'woocommerce-subscriptions' ),
//			'last_order_date_created' => _x( 'Last order date', 'customer subscription table header', 'woocommerce-subscriptions' ),
			'next_payment'            => _x( 'RENEWAL DATE', 'customer subscription table header', 'woocommerce-subscriptions' ),
//			'end'                     => _x( 'Expiry Date', 'customer subscription table header', 'woocommerce-subscriptions' ),
//			'trial_end'               => _x( 'Trial end date', 'customer subscription table header', 'woocommerce-subscriptions' ),
		), $subscription );
		foreach ( $dates_to_display as $date_type => $date_title ) : ?>
			<?php $date = $subscription->get_date( $date_type ); ?>
			<?php if ( ! empty( $date ) ) : ?>
				<tr>
					<td><?php echo esc_html( $date_title ); ?></td>
					<td><?php echo esc_html( $subscription->get_date_to_display( $date_type ) ); ?></td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
                <tr>
                        <td><?php esc_html_e( 'Quantity', 'woocommerce-subscriptions' ); ?></td>
                        <td><?php echo $item_count; ?></td>
                </tr>
		<?php do_action( 'wcs_subscription_details_table_after_dates', $subscription ); ?>
		
		<?php do_action( 'wcs_subscription_details_table_before_payment_method', $subscription ); ?>
		<?php /*if ( $subscription->get_time( 'next_payment' ) > 0 ) : ?>
                    <tr>
                        <td><?php esc_html_e( 'Payment', 'woocommerce-subscriptions' ); ?></td>
                        <td>
                                <span data-is_manual="<?php echo esc_attr( wc_bool_to_string( $subscription->is_manual() ) ); ?>" class="subscription-payment-method"><?php echo esc_html( $subscription->get_payment_method_to_display( 'customer' ) ); ?></span>
                        </td>
                    </tr>
		<?php endif;*/ ?>
		<?php do_action( 'woocommerce_subscription_before_actions', $subscription ); ?>
		
		<?php do_action( 'woocommerce_subscription_after_actions', $subscription ); ?>
	</tbody>
</table>

<?php
$un = array();
$ue = array();
$up = array();
if( class_exists("acf") ) {
    $users_s = get_field('kerrybodine_sub_starter_users' , $order_id);
    $users_p = get_field('kerrybodine_sub_pro_users' , $order_id);
    $users_r = get_field('kerrybodine_sub_enterprise_users' , $order_id);
    
    $users_s_count = count( $users_s );
    $users_p_count = count( $users_p );
    $users_r_count = count( $users_r );

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
    
    $un_count = count( $un );
    $ue_count = count( $ue );
    $up_count = count( $up );
}
?>
<div class="subscription-users">
    <h2 class="woocommerce-order-details__title">
        <?php _e( 'Journey Mapping Master Toolkit subscribers', 'woocommerce' ); ?>
    </h2>
    <?php if( !empty( $un ) || !empty( $ue ) || !empty( $up ) ) { ?>
        <table class="shop_table subscription_details">
                <tbody>
                        <tr>
                            <th><?php esc_html_e( 'Email', 'woocommerce-subscriptions' ); ?></td>
                        </tr>
                        <?php if(!empty($un)) { ?>
                            <?php foreach($un as $un_val) { ?>
                                <tr>
                                    <td><a href="mailto:<?php echo $un_val; ?>"><?php echo $un_val; ?></a></td>
                                </tr>
                            <?php } ?>
                        <?php } if(!empty($ue)) { ?>
                            <?php foreach($ue as $ue_val) { ?>
                                <tr>
                                    <td><a href="mailto:<?php echo $ue_val; ?>"><?php echo $ue_val; ?></a></td>
                                </tr>
                            <?php } ?>
                        <?php } if(!empty($up)) { ?>
                            <?php foreach($up as $up_val) { ?>
                                <tr>
                                    <td><a href="mailto:<?php echo $up_val; ?>"><?php echo $up_val; ?></a></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                </tbody>
        </table>
    <?php } ?>
    <?php 
    $class_sub = '';
    if( ( $users_s_count == $un_count ) && ( $users_p_count == $ue_count ) && ( $users_r_count == $up_count ) ) { 
        $class_sub = 'disable-sub';
        $order_received = '';
    } ?>  
    <?php if( !empty( $order_received ) ) { ?>
        <a href="<?php echo $order_received;?>" class="woocommerce-button button " target="_blank">Add Subscribers</a>
    <?php } else { ?>
        <a class="woocommerce-button button <?php echo $class_sub;?>"><?php echo __('Add Subscribers','kerry');?></a>
    <?php } ?>  
    <p>
        <?php echo __('For additional assistance, please contact ','kerry');?>
        <a href="mailto:concierge@kerrybodine.com"> <?php echo __('concierge@kerrybodine.com','kerry');?></a>
    </p>
</div>
<?php /*if ( $notes = $subscription->get_customer_order_notes() ) : ?>
	<h2><?php esc_html_e( 'Subscription updates', 'woocommerce-subscriptions' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo esc_html( date_i18n( _x( 'l jS \o\f F Y, h:ia', 'date on subscription updates list. Will be localized', 'woocommerce-subscriptions' ), wcs_date_to_time( $note->comment_date ) ) ); ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wp_kses_post( wpautop( wptexturize( $note->comment_content ) ) ); ?>
					</div>
	  				<div class="clear"></div>
	  			</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; */?>