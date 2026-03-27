<?php
/**
 * Asset loading callbacks.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_get_asset_version' ) ) {
	/**
	 * Returns a cache-busting version for a theme asset.
	 *
	 * @param string $relative_path Asset path relative to the theme root.
	 * @return string
	 */
	function re_style_get_asset_version( $relative_path ) {
		$asset_path = get_template_directory() . '/' . ltrim( $relative_path, '/' );

		if ( file_exists( $asset_path ) ) {
			return (string) filemtime( $asset_path );
		}

		return wp_get_theme()->get( 'Version' );
	}
}

if ( ! function_exists( 're_style_enqueue_assets' ) ) {
	/**
	 * Enqueues frontend assets.
	 *
	 * @return void
	 */
	function re_style_enqueue_assets() {
		wp_enqueue_style(
			're-style-fonts',
			re_style_get_google_fonts_url(),
			array(),
			null
		);

		wp_enqueue_style(
			're-style-main',
			get_template_directory_uri() . '/assets/css/main.css',
			array( 're-style-fonts' ),
			re_style_get_asset_version( 'assets/css/main.css' )
		);

		wp_add_inline_style( 're-style-main', re_style_get_design_tokens_css() );

		if ( is_front_page() ) {
			wp_enqueue_style(
				're-style-front-page',
				get_template_directory_uri() . '/assets/css/front-page.css',
				array( 're-style-main' ),
				re_style_get_asset_version( 'assets/css/front-page.css' )
			);
		}

		if ( is_page( array( 'resi-e-rimborsi', 'spedizioni', 'pagamenti', 'supporto-clienti' ) ) ) {
			wp_enqueue_style(
				're-style-pages',
				get_template_directory_uri() . '/assets/css/pages.css',
				array( 're-style-main' ),
				re_style_get_asset_version( 'assets/css/pages.css' )
			);
		}

		if (
			function_exists( 'is_woocommerce' )
			&& (
				is_woocommerce()
				|| re_style_is_shop_archive()
				|| ( function_exists( 'is_cart' ) && is_cart() )
				|| ( function_exists( 'is_checkout' ) && is_checkout() )
				|| ( function_exists( 'is_account_page' ) && is_account_page() )
			)
		) {
			wp_enqueue_style(
				're-style-woocommerce',
				get_template_directory_uri() . '/assets/css/woocommerce.css',
				array( 're-style-main' ),
				re_style_get_asset_version( 'assets/css/woocommerce.css' )
			);
		}

		wp_enqueue_script(
			're-style-theme',
			get_template_directory_uri() . '/assets/js/theme.js',
			array(),
			re_style_get_asset_version( 'assets/js/theme.js' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 're_style_enqueue_assets' );
