<?php
/**
 * Wishlist page helpers.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_get_wishlist_page_id' ) ) {
	/**
	 * Returns the wishlist page ID if a matching page exists.
	 *
	 * @return int
	 */
	function re_style_get_wishlist_page_id() {
		$page = get_page_by_path( 'lista-preferiti' );

		if ( $page instanceof WP_Post ) {
			return (int) $page->ID;
		}

		$page = get_page_by_path( 'wishlist' );

		return $page instanceof WP_Post ? (int) $page->ID : 0;
	}
}

if ( ! function_exists( 're_style_is_wishlist_page' ) ) {
	/**
	 * Returns whether the current request targets the wishlist page.
	 *
	 * @return bool
	 */
	function re_style_is_wishlist_page() {
		$page_id = re_style_get_wishlist_page_id();

		return $page_id > 0 && is_page( $page_id );
	}
}

if ( ! function_exists( 're_style_ensure_wishlist_page' ) ) {
	/**
	 * Creates the wishlist page if the plugin did not generate it.
	 *
	 * @return void
	 */
	function re_style_ensure_wishlist_page() {
		if ( ! shortcode_exists( 'mia_lista_preferiti' ) || re_style_get_wishlist_page_id() > 0 ) {
			return;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => __( 'Lista preferiti', 're-style' ),
				'post_name'    => 'lista-preferiti',
				'post_content' => '[mia_lista_preferiti]',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			),
			true
		);

		if ( ! is_wp_error( $page_id ) ) {
			update_option( 're_style_wishlist_page_id', (int) $page_id );
		}
	}
}
add_action( 'init', 're_style_ensure_wishlist_page', 20 );

if ( ! function_exists( 're_style_inject_wishlist_shortcode' ) ) {
	/**
	 * Returns the wishlist page title configured by the plugin.
	 *
	 * @return string
	 */
	function re_style_get_wishlist_plugin_title() {
		$settings = get_option( 'mio_wishlist_settings', array() );
		$title    = isset( $settings['label_page_title'] ) ? (string) $settings['label_page_title'] : '';

		return '' !== $title ? $title : __( 'La Mia Lista dei Preferiti', 're-style' );
	}
}

if ( ! function_exists( 're_style_inject_wishlist_shortcode' ) ) {
	/**
	 * Ensures the wishlist page renders the plugin shortcode even if the page
	 * content is empty or was not created correctly by the plugin.
	 *
	 * @param string $content Original page content.
	 * @return string
	 */
	function re_style_inject_wishlist_shortcode( $content ) {
		if ( is_admin() || ! re_style_is_wishlist_page() || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		if ( ! shortcode_exists( 'mia_lista_preferiti' ) ) {
			return $content;
		}

		return do_shortcode( '[mia_lista_preferiti]' );
	}
}
add_filter( 'the_content', 're_style_inject_wishlist_shortcode', 20 );

if ( ! function_exists( 're_style_add_wishlist_body_class' ) ) {
	/**
	 * Adds a body class for wishlist-specific styling.
	 *
	 * @param string[] $classes Existing classes.
	 * @return string[]
	 */
	function re_style_add_wishlist_body_class( $classes ) {
		if ( re_style_is_wishlist_page() ) {
			$classes[] = 're-style-wishlist-page';
		}

		return $classes;
	}
}
add_filter( 'body_class', 're_style_add_wishlist_body_class' );
