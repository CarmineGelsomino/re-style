<?php
/**
 * Theme setup callbacks.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_setup' ) ) {
	/**
	 * Registers theme supports and navigation.
	 *
	 * @return void
	 */
	function re_style_setup() {
		load_theme_textdomain( 're-style', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 120,
				'width'       => 320,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor.css' );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 're-style' ),
				'footer'  => __( 'Footer Menu', 're-style' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 're_style_setup' );

if ( ! function_exists( 're_style_content_width' ) ) {
	/**
	 * Sets the global content width.
	 *
	 * @return void
	 */
	function re_style_content_width() {
		$GLOBALS['content_width'] = apply_filters( 're_style_content_width', 1200 );
	}
}
add_action( 'after_setup_theme', 're_style_content_width', 0 );
