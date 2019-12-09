<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$order1         = wc_get_order( $order->id);
$order_rec_url  = $order1->get_checkout_order_received_url();
$flag           = false;
$order_items    = $order->get_items();
foreach ($order_items as $item_id => $item_data) {
    $product        = $item_data->get_product();
    $item_total     = $item_data->get_total(); 
    if( $item_total <= 0 ) {
        $flag = true;
    } 
}
$total_item = count($order->get_items());
$total  = $order1->get_total();
if( $total_item > 1 ) {
    $is_are = 'are';
    $s_nots = 's';
} else {
    $is_are = 'is';
    $s_nots = '';
}
$downloads = $order->get_downloadable_items();
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body style="background-color: #FAFBFF;" >
    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="main-table" style="width: 600px;padding-bottom: 50px; text-align:center;margin:0 auto;margin-bottom: 50px;">
        <tr>
           <td align="left" valign="top" class="" width="100%" colspan="12" style="width:100%;">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="padding-top: 16px;">
                            <img src="<?php echo site_url();?>/wp-content/themes/kb18/assets/images/new-logo2.png" height="32px" width="173px">
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" width="100%"  style="background-color:#fff;padding:33px;border: 1px solid #ECEFFC;margin-top: 15px">
                    <tr>
                        <td>	
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <?php if( $total <= 0 ) { ?>
                                        <td align="left" style="font-family: 'Open Sans',sans-serif;font-size: 16px;line-height: 24px;">
                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B"><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B"><?php esc_html_e( 'Your download'.$s_nots.' '.$is_are.' ready!', 'woocommerce' ); ?></p>
                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">Just click the download button<?php echo $s_nots;?> below, and you’ll be all set. If you have any issues, please email <a href="#" style="color:#00AA4F">concierge@kerrybodine.com</a>.</p>
                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">Enjoy,<br>Kerry</p>
                                        </td>
                                    <?php } else if( $flag ) { ?>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="left">
                                                    <tr>
                                                        <td align="left"><p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px"><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
                                                            <p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">We’re excited to get you and your team up and running!</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            <p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;margin-top:15px; "><strong>What’s next:</strong></p>
                                                            <ul style="padding-left: 20px;">
                                                                        <li style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;padding-bottom: 15px;" >
                                                                            If you haven’t submitted the emails for your subscribers yet, you can do it  <a href="<?php echo $order_rec_url; ?>" style="color: #00AA4F;text-decoration: underline;"> here</a>. 
                                                                        </li>
                                                                        <li style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">
                                                                            If you’ve already submitted the subscriber emails, you’re all set! Subscribers will receive emails to activate their accounts.
                                                                        </li>                                                                        
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                                                If you need any help, please email <a href="mailto:concierge@kerrybodine.com." style="color: #00AA4F;text-decoration: underline;">concierge@kerrybodine.com</a>.
                                                            <p>
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">Happy to have you join us,<br/>Kerry</p>
                                                        </td>
                                                    </tr>
                                            </table>
                                        </td>  
                                        <?php /*<td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="left">
                                                    <tr>
                                                        <td align="left"><p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px"><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
                                                            <p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">We’re so happy you found resources that will be useful for you and your organization.</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            <p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;text-align: left"><strong> To download any free resources you selected:</strong> 
                                                                simply click on the download button<?php echo $s_nots;?> below. 
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left"><p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;margin-top:0 "><strong>To activate the subscriptions you purchased:</strong></p>
                                                                <ul style="padding-left: 20px;">
                                                                        <li style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;padding-bottom: 15px;" >
                                                                            If you haven't submitted the emails for your subscribers yet, you'll need to complete <a href="https://www.dropbox.com/sh/6pjid75tgx8glfy/AABfzbIsCkEdJ6Yo2tUsfdCQa?dl=1" target="_blank" style="color: #00AA4F;text-decoration: underline;">this spreadsheet</a> and submit to <a href="mailto:concierge@kerrybodine.com" style="color: #00AA4F;text-decoration: underline;">concierge@kerrybodine.com.</a>
                                                                        </li>
                                                                        <li style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">
                                                                            If you’ve already submitted the subscriber emails, you're all set! Subscribers will receive emails to activate their accounts.
                                                                        </li>                                                                        
                                                                </ul>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                                                <a href="<?php echo $order_rec_url; ?>" style="color: #00AA4F;text-decoration: underline;"><?php echo $order_rec_url; ?></a>
                                                            <p>
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                                                If you have any issues, please email <a href="mailto:concierge@kerrybodine.com." style="color: #00AA4F;text-decoration: underline;">concierge@kerrybodine.com.</a>
                                                            <p>
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">Have a great day,<br>Kerry</p>
                                                        </td>
                                                    </tr>
                                            </table>
                                        </td> */?>
                                    <?php } else { ?>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="left">
                                                    <tr>
                                                        <td align="left"><p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px"><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
                                                            <p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">We’re excited to get you and your team up and running!</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            <p style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;margin-top:15px; "><strong>What’s next:</strong></p>
                                                            <ul style="padding-left: 20px;">
                                                                        <li style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px;padding-bottom: 15px;" >
                                                                            If you haven’t submitted the emails for your subscribers yet, you can do it  <a href="<?php echo $order_rec_url; ?>" style="color: #00AA4F;text-decoration: underline;"> here</a>. 
                                                                        </li>
                                                                        <li style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">
                                                                            If you’ve already submitted the subscriber emails, you’re all set! Subscribers will receive emails to activate their accounts.
                                                                        </li>                                                                        
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" style="color: #58595B;font-family:'Open Sans', sans-serif;font-size: 14px;line-height: 24px">
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                                                If you need any help, please email <a href="mailto:concierge@kerrybodine.com." style="color: #00AA4F;text-decoration: underline;">concierge@kerrybodine.com</a>.
                                                            <p>
                                                            <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">Happy to have you join us,<br/>Kerry</p>
                                                        </td>
                                                    </tr>
                                            </table>
                                        </td>    
                                    <?php } ?>  
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php if( !empty( $order_items ) ) { ?>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <td align="left" style="font-family: 'Open Sans', sans-serif;font-size: 20px;font-weight: 600;	line-height: 32px;padding-top:15px;padding-bottom:15px;">
                                            <font style="color: #58595B;font-family: 'Open Sans', sans-serif;font-size: 20px;font-weight: 600;	line-height: 32px;margin-top: 0;">Order Details
                                            </font>
                                        </td>
                                    </tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                            <?php foreach ($order_items as $item_id => $item ) {
                                                $product = $item->get_product(); 
                                                $product_description = $product->short_description;
                                                $tags = array("<p>", "</p>");
                                                $product_description = str_replace($tags, "", $product_description);
                                                ?>
                                                <tr>
                                                    <td align="left" style="padding-bottom: 10px; color: #58595B;font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;width: 60%;">
                                                        <?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );?>
                                                        <?php echo apply_filters( 'woocommerce_order_item_quantity_html', ' ' . sprintf( '(&times;%s)', $item->get_quantity() ), $item );?>
                                                        <p style="margin: 0px;font-size: 12px;"><?php echo $product_description; ?></p>
                                                    </td>
                                                    <td align="left" style="padding-bottom: 10px; color: #58595B;font-family: 'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;">
                                                        <?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
                                                    </td>
                                                </tr>  
                                            <?php } ?>
                                            <?php
                                            $totals = $order->get_order_item_totals();
                                            if ( $totals ) {
                                                    $i = 0;
                                                    foreach ( $totals as $total_key => $total ) {
                                                        $i++;
                                                        if( $total_key == 'order_total' ) {
                                                            $color = '#00AA4F';
                                                        } else {
                                                            $color = '#58595B';
                                                        }
                                                        if( $total_key == 'cart_subtotal' || $total_key == 'order_total' || $total_key == 'discount') { ?>
                                                            <tr>
                                                                    <td align="left" style="padding-bottom: 10px; color: #58595B;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;text-transform: uppercase;width: 60%;">
                                                                        <?php echo str_replace(':', '', wp_kses_post( $total['label'] )); ?>
                                                                    </td>
                                                                    <td align="left" style="padding-bottom: 10px;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;; color:<?php echo $color;?>">
                                                                        <?php echo wp_kses_post( $total['value'] ); ?>
                                                                    </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    $subscription =reset( wcs_get_subscriptions_for_order( $order->id ) );
                                                    $card_meta_data = get_card_meta_data( $order->id );
                                                    if( !empty( $card_meta_data['last4'] ) ){
                                                    ?>
                                                    <tr>
                                                        <td align="left" style="padding-bottom: 10px; color: #58595B;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;text-transform: uppercase;width: 60%;"><?php esc_html_e( 'Payment', 'woocommerce-subscriptions' ); ?></td>
                                                        <td align="left" style="padding-bottom: 10px;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;; color:#58595B">
                                                            <?php echo 'Card ending in '.$card_meta_data['last4']; ?>
                                                        </td>
                                                    </tr>        
                                                    <?php
                                                    }
                                            }
                                            if ( $order->get_customer_note() ) {
                                                    ?>
                                                    <tr>
                                                        <td align="left" style="padding-bottom: 10px; color: #58595B;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;text-transform: uppercase;width: 60%;">
                                                            <?php esc_html_e( 'Note:', 'woocommerce' ); ?>
                                                        </td>
                                                        <td align="left" style="padding-bottom: 10px;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 15px;line-height: 24px;; color:#00AA4F">
                                                            <?php echo wp_kses_post( wptexturize( $order->get_customer_note() ) ); ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                            }
                                            ?>
                                        </table>
                                    </td>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if( !empty( $downloads ) ) { ?>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" >
                                    <tr>
                                        <td align="left" style="font-family: 'Open Sans', sans-serif;font-size: 20px;font-weight: 600;	line-height: 32px;margin-top: 0;padding-top:15px;padding-bottom:10px;">
                                                <font style="color:#58595B;;font-family: 'Open Sans', sans-serif;font-size: 20px;font-weight: 600;	line-height: 32px;margin-top: 0;">Downloads</font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
<!--                                                <tr style="	background-color: #ECEFFC;height: 40px;">
                                                    <td style="color: #001A1D;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 16px;font-weight: 600;line-height: 24px;text-align: left;    padding-left: 8px;">
                                                            Product
                                                    </td>
                                                    <td style="color: #001A1D;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 16px;font-weight: 600;line-height: 24px;text-align: right;    padding-right: 8px;">
                                                            Action
                                                    </td>
                                                </tr>-->
                                                <!--<tr><td style="padding: 12px"></td><td></td></tr>-->
                                                <?php foreach ( $downloads as $download ) { ?>
                                                    <tr>
                                                        <td style="color: #58595B;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size: 16px;line-height: 24px;text-align: left;">
                                                            <?php echo wp_kses_post( $download['product_name'] ); ?>
                                                            <?php echo apply_filters('woocommerce_short_description', $item->post->post_excerpt); ?>
                                                        </td>
                                                        <td align="right">
                                                            <a style="background-color: #00AA4F; color: #FFFFFF; font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif; font-size: 16px; font-weight: 600; line-height: 20px; text-align: center; padding: 6px 22px; display: inline-block; text-decoration: none; " href="<?php echo esc_url( $download['download_url'] ); ?>">
                                                                <?php echo esc_html( 'DOWNLOAD' ); ?>
                                                            </a>
                                                        </td>
                                                    </tr> 
                                                    <tr><td style="padding: 12px"></td><td></td></tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>  
                </table>
            </td>
       </tr>
    </table>
</body>
</html>