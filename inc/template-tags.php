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
		echo '<ul id="primary-menu" class="menu">';
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 're-style' ) . '</a></li>';
		echo '</ul>';
	}
}

if ( ! function_exists( 're_style_footer_menu_fallback' ) ) {
	/**
	 * Outputs a safe fallback for the footer navigation.
	 *
	 * @return void
	 */
	function re_style_footer_menu_fallback() {
		echo '<ul id="footer-menu" class="menu">';
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 're-style' ) . '</a></li>';
		echo '</ul>';
	}
}
