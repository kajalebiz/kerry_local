<?php

/**
 * Menu Headings Top Right
 *
 * @author Eldon Yoder
 * @link http://objectiv.co/
 */

add_action( 'genesis_header_right', 'obj_do_menu_tops' );
function obj_do_menu_tops() {
	$menu_items = get_field( 'menu_items', 'option' );

	if ( is_array( $menu_items ) && ! empty( $menu_items ) ) {
		echo "<div class='obj-menu'>";
		foreach ( $menu_items as $tmi ) {
			obj_do_top_menu_item( $tmi );
		}

		// Append WooCommerce cart to menu
		if ( class_exists( 'WooCommerce' ) &&  WC()->cart->get_cart_contents_count() > 0 ) { ?>
			<div class="obj-menu__top-item">
				<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="icon-cart icon-cart--desktop" title="<?php _e( 'View your shopping cart' ); ?>">
					<div class="icon-cart__counter">
						<?php echo WC()->cart->get_cart_contents_count(); ?>
					</div>
				</a>
			</div>
		<?php } 

		echo '</div>';
	}
}

/**
 * Top Level Menu Item
 *
 * @author Eldon Yoder
 * @link http://objectiv.co/
 */

function obj_do_top_menu_item( $tmi = null ) {
	if ( ! empty( $tmi ) ) {
		$type        = $tmi['type'];
		$top_link    = $tmi['top_link'];
		$link_title  = $top_link['title'];
		$link_url    = $top_link['url'];
		$link_target = $top_link['target'];
		$link_id     = 'obj_menu_' . obj_id_from_string( $link_title, false );
		$current     = obj_check_if_current_url( $link_url );
		$class       = ( $current ) ? 'this-page' : '';
		$drop_menu   = $tmi['drop_down_menu_items'];

		echo 'mega' === $type ? "<div class='obj-menu__top-item mega'>" : "<div class='obj-menu__top-item'>";
		echo "<a href='{$link_url}' class='obj-menu__top-item-link {$class} {$type}'>";
		echo $link_title;
		echo '</a>';
		if ( 'simple' === $type && is_array( $drop_menu ) && ! empty( $drop_menu ) ) {
			echo "<div class='obj-menu__top-item__sub-menu'>";
			echo "<div class='obj-menu__top-item__sub-menu-inner'>";
			foreach ( $drop_menu as $dmi ) {
				echo objectiv_link_link( $dmi['link'], 'obj-menu__top-item__sub-menu-link' );
			}
			echo '</div>';
			echo '</div>';
		} elseif ( 'mega' === $type ) {
			obj_do_top_mega_menu_item( $tmi );
		}
		echo '</div>';
	}
}

/**
 * Mega Menu Hover Details
 *
 * @author Eldon Yoder
 * @link http://objectiv.co/
 */

function obj_do_top_mega_menu_item( $tmi = null ) {
	if ( ! empty( $tmi ) ) {
		$type        = $tmi['type'];
		$top_link    = $tmi['top_link'];
		$link_title  = $top_link['title'];
		$link_id     = 'obj_menu_' . obj_id_from_string( $link_title, false );
		$mega_deets  = $tmi['mega_menu_details'];
		$m_title     = $mega_deets['title'];
		$m_cta_link  = $mega_deets['cta_link'];
		$m_cta_img   = $mega_deets['cta_image'];
		$m_sub_menus = $mega_deets['sub_menus'];

		if ( 'mega' === $type && is_array( $mega_deets ) && ! empty( $mega_deets ) ) {
			echo "<div class='obj-mega-menu__hover' id='{$link_id}'>";
			echo "<div class='wrap'>";
			echo "<div class='obj-mega-menu__hover-inner'>";
			echo "<div class='obj-mega-menu__sub-menu'>";
			?>
			<?php if ( ! empty( $m_title ) || ! empty( $m_cta_link ) ) : ?>
				<div class="obj-mega-menu__first-side">
					<?php if ( ! empty( $m_title ) ) : ?>
						<div class="obj-mega-menu__large-title"><a href="<?php echo $m_title['url']; ?>"><?php echo $m_title['title']; ?></a></div>
					<?php endif; ?>
					<?php if ( ! empty( $m_cta_link ) ) : ?>
						<?php echo objectiv_link_with_img( $m_cta_link, $m_cta_img, 'obj-mega-menu__cta-links' ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $m_sub_menus ) && is_array( $m_sub_menus ) ) : ?>
				<div class="obj-mega-menu__second-side">
					<?php
					foreach ( $m_sub_menus as $m_sub ) :
						obj_do_mega_menu_sub_menu( $m_sub );
					endforeach;
					?>
				</div>
			<?php endif; ?>
			<?php
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
}

function obj_do_mega_menu_sub_menu( $menu = null ) {
	if ( is_array( $menu ) && ! empty( $menu ) ) {
		$color    = $menu['colors'];
		$top_link = $menu['top_link'];
		$sub_menu = $menu['mega_sub_menu_items'];
		echo "<div class='obj-mega-menu__sub-sub-menu {$color}'>";
		echo "<div class='obj-mega-menu__sub-menu-title'>";
		echo objectiv_link_link( $top_link );
		echo '</div>';
		if ( ! empty( $sub_menu ) ) {
			foreach ( $sub_menu as $menu_item ) {
				echo objectiv_link_link( $menu_item['link'], 'obj-mega-menu__sub-menu-item' );
			}
		}
		echo '</div>';
	}
}


function obj_check_if_current_url( $url = null ) {
	// Set up link
	$current_url   = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$comp_link_url = preg_replace( '(^https?://)', '', trailingslashit( $url ) );

	return $comp_link_url === $current_url;
}
