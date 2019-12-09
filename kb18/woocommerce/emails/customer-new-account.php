<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
                                    <td align="left" style="font-family: 'Open Sans',sans-serif;font-size: 16px;line-height: 24px;">
                                        <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                            <?php   $current_user = get_user_by('login', $user_login ); ?>
                                            <?php printf( esc_html__( 'Hi', 'woocommerce' ) ); ?>
                                            <?php   echo $current_user->user_firstname.'!'; ?>
                                            <?php //   echo $current_user->user_lastname.'!'; ?>
                                        </p>
                                        <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                            Thanks for creating an account with Bodine & Co.  You can access your account details to view orders, change your password, and more. Click here for easy access: <?php echo  make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) );?>
                                        </p>
                                        <?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated ) : ?>
                                                <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">
                                                    <?php printf( esc_html__( 'Your password has been automatically generated: %s', 'woocommerce' ), '<strong>' . esc_html( $user_pass ) . '</strong>' ); ?>
                                                </p>
                                        <?php endif; ?>
                                        <p style="font-family: 'Open Sans',sans-serif;font-size: 14px;line-height: 24px;color:#58595B">Happy to have you here,<br>Kerry</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
       </tr>
    </table>
</body>
</html>