<?php
/**
 * Small template helpers.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_posted_on' ) ) {
	/**
	 * Prints a small published date string.
	 *
	 * @return void
	 */
	function re_style_posted_on() {
		$time_string = sprintf(
			'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		printf(
			'<span class="posted-on">%s</span>',
			wp_kses_post( $time_string )
		);
	}
}

if ( ! function_exists( 're_style_primary_menu_fallback' ) ) {
	/**
	 * Outputs a safe fallback for the primary navigation.
	 *
	 * @return void
	 */
	function re_style_primary_menu_fallback() {
		echo '<ul id="primary-menu" class="menu primary-menu">';
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 're-style' ) . '</a></li>';
		echo '</ul>';
	}
}

if ( ! function_exists( 're_style_footer_menu_fallback' ) ) {
	/**
	 * Outputs a safe fallback for footer navigation locations.
	 *
	 * @param array $args wp_nav_menu arguments.
	 * @return void
	 */
	function re_style_footer_menu_fallback( $args = array() ) {
		$menu_id = ! empty( $args['menu_id'] ) ? $args['menu_id'] : 'footer-menu';

		echo '<ul id="' . esc_attr( $menu_id ) . '" class="menu footer-menu">';
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 're-style' ) . '</a></li>';
		echo '</ul>';
	}
}

if ( ! function_exists( 're_style_get_topbar_messages' ) ) {
	/**
	 * Returns topbar messages.
	 *
	 * @return string[]
	 */
	function re_style_get_topbar_messages() {
		return array(
			__( 'Buy from our shop', 're-style' ),
			__( 'Free shipping over EUR 50', 're-style' ),
			__( 'Book your services', 're-style' ),
		);
	}
}

if ( ! function_exists( 're_style_get_brand_logo_url' ) ) {
	/**
	 * Returns the static brand logo as a fallback for the header.
	 *
	 * @return string
	 */
	function re_style_get_brand_logo_url() {
		return get_template_directory_uri() . '/assets/img/logo.webp';
	}
}

if ( ! function_exists( 're_style_get_header_action_links' ) ) {
	/**
	 * Returns header action links with conservative WordPress/WooCommerce fallbacks.
	 *
	 * @return array<string, array<string, string>>
	 */
	function re_style_get_header_action_links() {
		$account_url  = wp_login_url( home_url( '/' ) );
		$wishlist_url = home_url( '/' );
		$cart_url     = home_url( '/' );

		if ( class_exists( 'WooCommerce' ) ) {
			$account_url = wc_get_page_permalink( 'myaccount' );
			$cart_url    = wc_get_cart_url();

			$wishlist_page = get_page_by_path( 'wishlist' );

			if ( $wishlist_page instanceof WP_Post ) {
				$wishlist_url = get_permalink( $wishlist_page );
			} else {
				$wishlist_url = wc_get_page_permalink( 'shop' );
			}
		}

		return array(
			'account'  => array(
				'label' => __( 'Profile', 're-style' ),
				'icon'  => 'icon-user',
				'url'   => $account_url,
			),
			'wishlist' => array(
				'label' => __( 'Favorites', 're-style' ),
				'icon'  => 'icon-favourite',
				'url'   => $wishlist_url,
			),
			'cart'     => array(
				'label' => __( 'Cart', 're-style' ),
				'icon'  => 'icon-cart',
				'url'   => $cart_url,
			),
		);
	}
}

if ( ! function_exists( 're_style_body_classes' ) ) {
	/**
	 * Adds contextual body classes used by theme styling.
	 *
	 * @param string[] $classes Existing body classes.
	 * @return string[]
	 */
	function re_style_body_classes( $classes ) {
		if ( is_front_page() ) {
			$classes[] = 're-style-front-page';
		}

		return $classes;
	}
}
add_filter( 'body_class', 're_style_body_classes' );
