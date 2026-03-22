<?php
/**
 * Asset loading callbacks.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_enqueue_assets' ) ) {
	/**
	 * Enqueues frontend assets.
	 *
	 * @return void
	 */
	function re_style_enqueue_assets() {
		$theme = wp_get_theme();

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
			$theme->get( 'Version' )
		);

		wp_add_inline_style( 're-style-main', re_style_get_design_tokens_css() );

		if ( is_front_page() ) {
			wp_enqueue_style(
				're-style-front-page',
				get_template_directory_uri() . '/assets/css/front-page.css',
				array( 're-style-main' ),
				$theme->get( 'Version' )
			);
		}

		if ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || re_style_is_shop_archive() ) ) {
			wp_enqueue_style(
				're-style-woocommerce',
				get_template_directory_uri() . '/assets/css/woocommerce.css',
				array( 're-style-main' ),
				$theme->get( 'Version' )
			);
		}

		wp_enqueue_script(
			're-style-theme',
			get_template_directory_uri() . '/assets/js/theme.js',
			array(),
			$theme->get( 'Version' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 're_style_enqueue_assets' );
