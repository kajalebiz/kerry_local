<?php
/**
 * WooCommerce Memberships
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Memberships to newer
 * versions in the future. If you wish to customize WooCommerce Memberships for your
 * needs please refer to https://docs.woocommerce.com/document/woocommerce-memberships/ for more information.
 *
 * @author    SkyVerge
 * @copyright Copyright (c) 2014-2019, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

/**
 * Renders a section on My Account page to list customer memberships.
 *
 * @type \WC_Memberships_User_Membership[] $customer_memberships array of user membership objects
 * @type int $user_id the current user ID
 *
 * @version 1.13.0
 * @since 1.0.0
 */
global $post;

if ( ! empty( $customer_memberships ) ) : 
    
    ?>



        
        <table class="shop_table shop_table_responsive my_account_orders my_account_memberships my_membership_settings">
            <thead>
                <tr>
                    <th colspan="2"><?php esc_html_e( 'Membership Details', 'woocommerce-memberships' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $customer_memberships as $customer_membership ) : ?>

                    <?php if ( ! $customer_membership->get_plan() ) { continue; } ?>
                <tr class="my-membership-detail-user-membership-status">
                    <td><?php esc_html_e( 'Status', 'woocommerce-memberships' ); ?></td>
                    <td><?php echo esc_html( wc_memberships_get_user_membership_status_name( $customer_membership->get_status() ) ); ?></td>
                </tr>
                <tr class="my-membership-detail-user-membership-start-date">
                    <td><?php esc_html_e( 'Start Date', 'woocommerce-memberships' ); ?></td>
                    <td>
                        <?php
                        $order           = $customer_membership->get_order();
                        $order_datetime  = $order ? wc_memberships_get_order_date( $order, 'created' ) : null;
                        $order_timestamp = $order_datetime ? $order_datetime->getTimestamp() : null;
                        $past_start_date = $order_timestamp ? ( $customer_membership->get_start_date( 'timestamp' ) < $order_timestamp ) : false;

                        // show the order date instead if the start date is in the past
                        if ( $past_start_date && $order && $customer_membership->get_plan()->is_access_length_type( 'fixed' ) ) {
                                $start_time = $order_timestamp;
                        } else {
                                $start_time = $customer_membership->get_local_start_date( 'timestamp' );
                        }

                        ?>
                        <?php if ( ! empty( $start_time ) && is_numeric( $start_time ) ) : ?>
                                <time datetime="<?php echo date( 'Y-m-d', $start_time ); ?>" title="<?php echo esc_attr( date_i18n( wc_date_format(), $start_time ) ); ?>"><?php echo date_i18n( wc_date_format(), $start_time ); ?></time>
                        <?php else : ?>
                                <?php esc_html_e( 'N/A', 'woocommerce-memberships' ); ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="my-membership-detail-user-membership-expires">
                    <td><?php esc_html_e( 'Expires', 'woocommerce-memberships' ); ?></td>
                    <td>
                        <?php if ( $end_time = $customer_membership->get_local_end_date( 'timestamp', ! $customer_membership->is_expired() ) ) : ?>
                                <time datetime="<?php echo date( 'Y-m-d', $end_time ); ?>" title="<?php echo esc_attr( date_i18n( wc_date_format(), $end_time ) ); ?>"><?php echo date_i18n( wc_date_format(), $end_time ); ?></time>
                        <?php else : ?>
                                <?php esc_html_e( 'N/A', 'woocommerce-memberships' ); ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="my-membership-detail-user-membership-actions">
                    <td><?php esc_html_e( 'Actions', 'woocommerce-memberships' ); ?></td>
                    <td>
                        <?php

                            echo wc_memberships_get_members_area_action_links( 'my-memberships', $customer_membership, $post );

                            // ask confirmation before cancelling a membership
                            wc_enqueue_js( "
                                    jQuery( document ).ready( function() {
                                            $( '.membership-actions' ).on( 'click', '.button.cancel', function( e ) {
                                                    e.stopImmediatePropagation();
                                                    return confirm( '" . esc_html__( 'Are you sure that you want to cancel your membership?', 'woocommerce-memberships' ) . "' );
                                            } );
                                    } );
                            " );
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
	</table>


	<?php

else :

	?>
	<p>
		<?php

		/**
		 * Filters the text for non members in My Account area.
		 *
		 * @since 1.9.0
		 *
		 * @param string $no_memberships_text the text displayed to users without memberships
		 * @param int $user_id the current user
		 */
		echo (string) apply_filters( 'wc_memberships_my_memberships_no_memberships_text', __( "Looks like you don't have a membership yet!", 'woocommerce-memberships' ), $user_id );

		?>
	</p>
	<?php

endif;
