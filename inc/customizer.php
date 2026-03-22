<?php
/**
 * Customizer settings and runtime design-token helpers.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_get_design_token_defaults' ) ) {
	/**
	 * Returns default design-token values.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_design_token_defaults() {
		return array(
			'background'      => '#f7f7f7',
			'surface'         => '#f0eadb',
			'text'            => '#1c1c1c',
			'accent'          => '#d0b985',
			'border'          => '#c8c8c8',
			'muted'           => '#8a8a8a',
			'font_primary'    => '"Poppins", sans-serif',
			'font_secondary'  => '"Raleway", sans-serif',
			'font_size_label' => '0.75rem',
			'font_size_body'  => '1rem',
			'font_size_lead'  => '1.125rem',
			'font_size_title' => '1.5rem',
			'font_size_h2'    => '2.5rem',
			'font_size_hero'  => '4.5rem',
			'space_gutter'    => '1rem',
			'space_section'   => '4rem',
			'space_stack'     => '1.5rem',
			'radius'          => '0.5rem',
			'content_width'   => '1200px',
			'content_narrow'  => '760px',
			'topbar_height'   => '1.875rem',
			'header_height'   => '4.5rem',
		);
	}
}

if ( ! function_exists( 're_style_get_google_fonts_url' ) ) {
	/**
	 * Returns the Google Fonts stylesheet URL used by the theme.
	 *
	 * @return string
	 */
	function re_style_get_google_fonts_url() {
		return 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Raleway:wght@400;500;600;700&display=swap';
	}
}

if ( ! function_exists( 're_style_sanitize_css_length' ) ) {
	/**
	 * Sanitizes a CSS length value.
	 *
	 * @param string $value Raw value.
	 * @return string
	 */
	function re_style_sanitize_css_length( $value ) {
		$value = is_string( $value ) ? trim( $value ) : '';

		if ( preg_match( '/^\d+(?:\.\d+)?(?:px|rem|em|vw|vh|%)$/', $value ) ) {
			return $value;
		}

		return '';
	}
}

if ( ! function_exists( 're_style_get_design_tokens' ) ) {
	/**
	 * Returns design tokens merged with Customizer overrides.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_design_tokens() {
		$defaults = re_style_get_design_token_defaults();
		$tokens   = array();

		foreach ( $defaults as $key => $default ) {
			$mod = get_theme_mod( 're_style_token_' . $key, $default );

			if ( 0 === strpos( $key, 'font_' ) || false !== strpos( $key, 'width' ) || false !== strpos( $key, 'space_' ) || in_array( $key, array( 'radius', 'topbar_height', 'header_height' ), true ) ) {
				$sanitized = re_style_sanitize_css_length( $mod );

				if ( ! $sanitized && 0 !== strpos( $key, 'font_' ) ) {
					$sanitized = $default;
				}

				if ( 0 === strpos( $key, 'font_' ) && false === strpos( $key, 'font_size_' ) ) {
					$sanitized = sanitize_text_field( $mod );
				}

				$tokens[ $key ] = $sanitized ? $sanitized : $default;
				continue;
			}

			$tokens[ $key ] = sanitize_hex_color( $mod ) ? sanitize_hex_color( $mod ) : $default;
		}

		return $tokens;
	}
}

if ( ! function_exists( 're_style_get_design_tokens_css' ) ) {
	/**
	 * Builds CSS custom properties for the active design tokens.
	 *
	 * @param string $selector CSS selector target.
	 * @return string
	 */
	function re_style_get_design_tokens_css( $selector = ':root' ) {
		$tokens = re_style_get_design_tokens();

		$declarations = array(
			'--wp--preset--color--background: ' . $tokens['background'],
			'--wp--preset--color--surface: ' . $tokens['surface'],
			'--wp--preset--color--text: ' . $tokens['text'],
			'--wp--preset--color--accent: ' . $tokens['accent'],
			'--wp--preset--color--border: ' . $tokens['border'],
			'--wp--preset--color--muted: ' . $tokens['muted'],
			'--wp--preset--font-family--primary: ' . $tokens['font_primary'],
			'--wp--preset--font-family--secondary: ' . $tokens['font_secondary'],
			'--wp--preset--font-size--label: ' . $tokens['font_size_label'],
			'--wp--preset--font-size--body: ' . $tokens['font_size_body'],
			'--wp--preset--font-size--lead: ' . $tokens['font_size_lead'],
			'--wp--preset--font-size--title: ' . $tokens['font_size_title'],
			'--wp--preset--font-size--heading-xl: ' . $tokens['font_size_h2'],
			'--wp--preset--font-size--display: ' . $tokens['font_size_hero'],
			'--wp--preset--spacing--gutter: ' . $tokens['space_gutter'],
			'--wp--preset--spacing--section: ' . $tokens['space_section'],
			'--wp--preset--spacing--stack: ' . $tokens['space_stack'],
			'--re-style-radius: ' . $tokens['radius'],
			'--re-style-content-width: ' . $tokens['content_width'],
			'--re-style-content-narrow: ' . $tokens['content_narrow'],
			'--re-style-topbar-height: ' . $tokens['topbar_height'],
			'--re-style-header-height: ' . $tokens['header_height'],
		);

		return $selector . '{' . implode( ';', $declarations ) . ';}';
	}
}

if ( ! function_exists( 're_style_sanitize_image_url' ) ) {
	/**
	 * Sanitizes an image URL or attachment URL from the Customizer.
	 *
	 * @param string $value Raw image URL.
	 * @return string
	 */
	function re_style_sanitize_image_url( $value ) {
		return esc_url_raw( $value );
	}
}

if ( ! function_exists( 're_style_sanitize_checkbox' ) ) {
	/**
	 * Sanitizes a checkbox value.
	 *
	 * @param mixed $value Raw checkbox value.
	 * @return bool
	 */
	function re_style_sanitize_checkbox( $value ) {
		return ! empty( $value );
	}
}

if ( ! function_exists( 're_style_customize_register' ) ) {
	/**
	 * Registers Customizer settings for design tokens and homepage content.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager.
	 * @return void
	 */
	function re_style_customize_register( $wp_customize ) {
		$token_defaults      = re_style_get_design_token_defaults();
		$front_page_defaults = re_style_get_front_page_defaults();

		$wp_customize->add_panel(
			're_style_theme_options',
			array(
				'title'       => __( 'Re Style Theme Options', 're-style' ),
				'description' => __( 'Design tokens and editable homepage content for the classic theme.', 're-style' ),
				'priority'    => 30,
			)
		);

		$wp_customize->add_section(
			're_style_design_tokens',
			array(
				'title'    => __( 'Design Tokens', 're-style' ),
				'panel'    => 're_style_theme_options',
				'priority' => 10,
			)
		);

		$color_controls = array(
			'background' => __( 'Background color', 're-style' ),
			'surface'    => __( 'Surface color', 're-style' ),
			'text'       => __( 'Text color', 're-style' ),
			'accent'     => __( 'Accent color', 're-style' ),
			'border'     => __( 'Border color', 're-style' ),
			'muted'      => __( 'Muted color', 're-style' ),
		);

		foreach ( $color_controls as $key => $label ) {
			$setting_id = 're_style_token_' . $key;

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $token_defaults[ $key ],
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$setting_id,
					array(
						'label'   => $label,
						'section' => 're_style_design_tokens',
					)
				)
			);
		}

		$text_controls = array(
			'font_primary'    => __( 'Primary font stack', 're-style' ),
			'font_secondary'  => __( 'Secondary font stack', 're-style' ),
			'font_size_label' => __( 'Label font size', 're-style' ),
			'font_size_body'  => __( 'Body font size', 're-style' ),
			'font_size_lead'  => __( 'Lead font size', 're-style' ),
			'font_size_title' => __( 'Card title font size', 're-style' ),
			'font_size_h2'    => __( 'Section heading size', 're-style' ),
			'font_size_hero'  => __( 'Hero display size', 're-style' ),
			'space_gutter'    => __( 'Global gutter', 're-style' ),
			'space_section'   => __( 'Section vertical spacing', 're-style' ),
			'space_stack'     => __( 'Component stack spacing', 're-style' ),
			'radius'          => __( 'Base radius', 're-style' ),
			'content_width'   => __( 'Content width', 're-style' ),
			'content_narrow'  => __( 'Narrow content width', 're-style' ),
			'topbar_height'   => __( 'Topbar height', 're-style' ),
			'header_height'   => __( 'Header height', 're-style' ),
		);

		foreach ( $text_controls as $key => $label ) {
			$setting_id = 're_style_token_' . $key;

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $token_defaults[ $key ],
					'sanitize_callback' => 0 === strpos( $key, 'font_primary' ) || 0 === strpos( $key, 'font_secondary' ) ? 'sanitize_text_field' : 're_style_sanitize_css_length',
				)
			);

			$wp_customize->add_control(
				$setting_id,
				array(
					'label'       => $label,
					'section'     => 're_style_design_tokens',
					'type'        => 'text',
					'description' => in_array( $key, array( 'font_primary', 'font_secondary' ), true ) ? __( 'Insert a valid CSS font-family stack.', 're-style' ) : __( 'Use a CSS length such as 1rem, 1200px or 4rem.', 're-style' ),
				)
			);
		}

		$sections = array(
			'site_shell' => __( 'Site Header & Floating CTA', 're-style' ),
			'hero'       => __( 'Homepage Hero', 're-style' ),
			'services'   => __( 'Homepage Services', 're-style' ),
			'shop'       => __( 'Homepage Shop', 're-style' ),
			'history'    => __( 'Homepage Story', 're-style' ),
			'location'   => __( 'Homepage Location', 're-style' ),
			'gallery'    => __( 'Homepage Gallery', 're-style' ),
			'video_tips' => __( 'Homepage Video Tips', 're-style' ),
			'contacts'   => __( 'Homepage Contacts', 're-style' ),
			'faq'        => __( 'Homepage FAQ', 're-style' ),
			'newsletter' => __( 'Homepage Newsletter', 're-style' ),
		);

		foreach ( $sections as $slug => $title ) {
			$wp_customize->add_section(
				're_style_home_' . $slug,
				array(
					'title'    => $title,
					'panel'    => 're_style_theme_options',
					'priority' => 20,
				)
			);
		}

		$controls = array(
			array( 'id' => 'topbar_messages', 'section' => 'site_shell', 'label' => __( 'Topbar messages', 're-style' ), 'default' => implode( "\n", re_style_get_topbar_default_messages() ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One message per line.', 're-style' ) ),
			array( 'id' => 'topbar_enable_free_shipping', 'section' => 'site_shell', 'label' => __( 'Show WooCommerce free shipping message automatically', 're-style' ), 'default' => false, 'type' => 'checkbox', 'sanitize' => 're_style_sanitize_checkbox', 'description' => __( 'When enabled, the topbar adds a message based on the active WooCommerce free shipping method and threshold.', 're-style' ) ),
			array( 'id' => 'floating_book_label', 'section' => 'site_shell', 'label' => __( 'Floating button text', 're-style' ), 'default' => __( 'Book', 're-style' ) ),
			array( 'id' => 'floating_book_url', 'section' => 'site_shell', 'label' => __( 'Floating button URL', 're-style' ), 'default' => '#contatti', 'sanitize' => 'esc_url_raw' ),

			array( 'id' => 'hero_title', 'section' => 'hero', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['hero']['title'] ),
			array( 'id' => 'hero_description', 'section' => 'hero', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['hero']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'hero_primary_label', 'section' => 'hero', 'label' => __( 'Primary CTA label', 're-style' ), 'default' => $front_page_defaults['hero']['primary_cta']['label'] ),
			array( 'id' => 'hero_primary_url', 'section' => 'hero', 'label' => __( 'Primary CTA URL', 're-style' ), 'default' => $front_page_defaults['hero']['primary_cta']['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'hero_secondary_label', 'section' => 'hero', 'label' => __( 'Secondary CTA label', 're-style' ), 'default' => $front_page_defaults['hero']['secondary_cta']['label'] ),
			array( 'id' => 'hero_secondary_url', 'section' => 'hero', 'label' => __( 'Secondary CTA URL', 're-style' ), 'default' => $front_page_defaults['hero']['secondary_cta']['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'hero_meta', 'section' => 'hero', 'label' => __( 'Meta labels', 're-style' ), 'default' => implode( "\n", $front_page_defaults['hero']['meta'] ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One label per line.', 're-style' ) ),
			array( 'id' => 'hero_image', 'section' => 'hero', 'label' => __( 'Hero image', 're-style' ), 'default' => $front_page_defaults['hero']['image']['src'], 'type' => 'image', 'sanitize' => 're_style_sanitize_image_url' ),
			array( 'id' => 'hero_image_alt', 'section' => 'hero', 'label' => __( 'Hero image alt text', 're-style' ), 'default' => $front_page_defaults['hero']['image']['alt'] ),

			array( 'id' => 'services_label', 'section' => 'services', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['services']['label'] ),
			array( 'id' => 'services_title', 'section' => 'services', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['services']['title'] ),
			array( 'id' => 'services_description', 'section' => 'services', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['services']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'services_cta_label', 'section' => 'services', 'label' => __( 'CTA label', 're-style' ), 'default' => $front_page_defaults['services']['cta']['label'] ),
			array( 'id' => 'services_cta_url', 'section' => 'services', 'label' => __( 'CTA URL', 're-style' ), 'default' => $front_page_defaults['services']['cta']['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'services_image', 'section' => 'services', 'label' => __( 'Services image', 're-style' ), 'default' => $front_page_defaults['services']['image']['src'], 'type' => 'image', 'sanitize' => 're_style_sanitize_image_url' ),
			array( 'id' => 'services_image_alt', 'section' => 'services', 'label' => __( 'Services image alt text', 're-style' ), 'default' => $front_page_defaults['services']['image']['alt'] ),
			array( 'id' => 'services_items', 'section' => 'services', 'label' => __( 'Services list', 're-style' ), 'default' => re_style_serialize_pair_list( $front_page_defaults['services']['items'], 'title', 'description' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One service per line using Title | Description.', 're-style' ) ),

			array( 'id' => 'shop_label', 'section' => 'shop', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['shop']['label'] ),
			array( 'id' => 'shop_title', 'section' => 'shop', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['shop']['title'] ),
			array( 'id' => 'shop_description', 'section' => 'shop', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['shop']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'shop_cta_label', 'section' => 'shop', 'label' => __( 'CTA label', 're-style' ), 'default' => $front_page_defaults['shop']['cta']['label'] ),
			array( 'id' => 'shop_cta_url', 'section' => 'shop', 'label' => __( 'CTA URL', 're-style' ), 'default' => $front_page_defaults['shop']['cta']['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'shop_item_1_title', 'section' => 'shop', 'label' => __( 'Card 1 title', 're-style' ), 'default' => $front_page_defaults['shop']['items'][0]['title'] ),
			array( 'id' => 'shop_item_1_url', 'section' => 'shop', 'label' => __( 'Card 1 URL', 're-style' ), 'default' => $front_page_defaults['shop']['items'][0]['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'shop_item_1_image', 'section' => 'shop', 'label' => __( 'Card 1 image', 're-style' ), 'default' => $front_page_defaults['shop']['items'][0]['image'], 'type' => 'image', 'sanitize' => 're_style_sanitize_image_url' ),
			array( 'id' => 'shop_item_1_alt', 'section' => 'shop', 'label' => __( 'Card 1 alt text', 're-style' ), 'default' => $front_page_defaults['shop']['items'][0]['alt'] ),
			array( 'id' => 'shop_item_2_title', 'section' => 'shop', 'label' => __( 'Card 2 title', 're-style' ), 'default' => $front_page_defaults['shop']['items'][1]['title'] ),
			array( 'id' => 'shop_item_2_url', 'section' => 'shop', 'label' => __( 'Card 2 URL', 're-style' ), 'default' => $front_page_defaults['shop']['items'][1]['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'shop_item_2_image', 'section' => 'shop', 'label' => __( 'Card 2 image', 're-style' ), 'default' => $front_page_defaults['shop']['items'][1]['image'], 'type' => 'image', 'sanitize' => 're_style_sanitize_image_url' ),
			array( 'id' => 'shop_item_2_alt', 'section' => 'shop', 'label' => __( 'Card 2 alt text', 're-style' ), 'default' => $front_page_defaults['shop']['items'][1]['alt'] ),
			array( 'id' => 'shop_item_3_title', 'section' => 'shop', 'label' => __( 'Card 3 title', 're-style' ), 'default' => $front_page_defaults['shop']['items'][2]['title'] ),
			array( 'id' => 'shop_item_3_url', 'section' => 'shop', 'label' => __( 'Card 3 URL', 're-style' ), 'default' => $front_page_defaults['shop']['items'][2]['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'shop_item_3_image', 'section' => 'shop', 'label' => __( 'Card 3 image', 're-style' ), 'default' => $front_page_defaults['shop']['items'][2]['image'], 'type' => 'image', 'sanitize' => 're_style_sanitize_image_url' ),
			array( 'id' => 'shop_item_3_alt', 'section' => 'shop', 'label' => __( 'Card 3 alt text', 're-style' ), 'default' => $front_page_defaults['shop']['items'][2]['alt'] ),

			array( 'id' => 'history_label', 'section' => 'history', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['history']['label'] ),
			array( 'id' => 'history_title', 'section' => 'history', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['history']['title'] ),
			array( 'id' => 'history_description', 'section' => 'history', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['history']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'history_milestones', 'section' => 'history', 'label' => __( 'Milestones', 're-style' ), 'default' => re_style_serialize_pair_list( $front_page_defaults['history']['milestones'], 'value', 'label' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One milestone per line using Value | Label.', 're-style' ) ),
			array( 'id' => 'history_primary_label', 'section' => 'history', 'label' => __( 'Primary CTA label', 're-style' ), 'default' => $front_page_defaults['history']['primary_cta']['label'] ),
			array( 'id' => 'history_primary_url', 'section' => 'history', 'label' => __( 'Primary CTA URL', 're-style' ), 'default' => $front_page_defaults['history']['primary_cta']['url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'history_secondary_label', 'section' => 'history', 'label' => __( 'Secondary CTA label', 're-style' ), 'default' => $front_page_defaults['history']['secondary_cta']['label'] ),
			array( 'id' => 'history_secondary_url', 'section' => 'history', 'label' => __( 'Secondary CTA URL', 're-style' ), 'default' => $front_page_defaults['history']['secondary_cta']['url'], 'sanitize' => 'esc_url_raw' ),

			array( 'id' => 'location_label', 'section' => 'location', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['location']['label'] ),
			array( 'id' => 'location_title', 'section' => 'location', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['location']['title'] ),
			array( 'id' => 'location_address', 'section' => 'location', 'label' => __( 'Address', 're-style' ), 'default' => $front_page_defaults['location']['address'] ),
			array( 'id' => 'location_maps_url', 'section' => 'location', 'label' => __( 'Google Maps URL', 're-style' ), 'default' => $front_page_defaults['location']['maps_url'], 'sanitize' => 'esc_url_raw' ),
			array( 'id' => 'location_schedule', 'section' => 'location', 'label' => __( 'Schedule', 're-style' ), 'default' => re_style_serialize_pair_list( $front_page_defaults['location']['schedule'], 'days', 'hours' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One row per line using Days | Hours.', 're-style' ) ),
			array( 'id' => 'location_note', 'section' => 'location', 'label' => __( 'Note', 're-style' ), 'default' => $front_page_defaults['location']['note'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'location_cta_label', 'section' => 'location', 'label' => __( 'CTA label', 're-style' ), 'default' => $front_page_defaults['location']['cta']['label'] ),
			array( 'id' => 'location_cta_url', 'section' => 'location', 'label' => __( 'CTA URL', 're-style' ), 'default' => $front_page_defaults['location']['cta']['url'], 'sanitize' => 'esc_url_raw' ),

			array( 'id' => 'gallery_label', 'section' => 'gallery', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['gallery']['label'] ),
			array( 'id' => 'gallery_title', 'section' => 'gallery', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['gallery']['title'] ),
			array( 'id' => 'gallery_description', 'section' => 'gallery', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['gallery']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),

			array( 'id' => 'video_tips_label', 'section' => 'video_tips', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['video_tips']['label'] ),
			array( 'id' => 'video_tips_title', 'section' => 'video_tips', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['video_tips']['title'] ),
			array( 'id' => 'video_tips_description', 'section' => 'video_tips', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['video_tips']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'video_tips_items', 'section' => 'video_tips', 'label' => __( 'Video card titles', 're-style' ), 'default' => re_style_serialize_single_value_list( $front_page_defaults['video_tips']['items'], 'title' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One title per line.', 're-style' ) ),

			array( 'id' => 'contacts_label', 'section' => 'contacts', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['contacts']['label'] ),
			array( 'id' => 'contacts_title', 'section' => 'contacts', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['contacts']['title'] ),
			array( 'id' => 'contacts_description', 'section' => 'contacts', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['contacts']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'contacts_email', 'section' => 'contacts', 'label' => __( 'Email', 're-style' ), 'default' => $front_page_defaults['contacts']['email'], 'sanitize' => 'sanitize_email' ),
			array( 'id' => 'contacts_phone', 'section' => 'contacts', 'label' => __( 'Phone', 're-style' ), 'default' => $front_page_defaults['contacts']['phone'] ),
			array( 'id' => 'contacts_owner_name', 'section' => 'contacts', 'label' => __( 'Owner name', 're-style' ), 'default' => $front_page_defaults['contacts']['owner']['name'] ),
			array( 'id' => 'contacts_owner_image', 'section' => 'contacts', 'label' => __( 'Owner image', 're-style' ), 'default' => $front_page_defaults['contacts']['owner']['image'], 'type' => 'image', 'sanitize' => 're_style_sanitize_image_url' ),
			array( 'id' => 'contacts_owner_alt', 'section' => 'contacts', 'label' => __( 'Owner image alt text', 're-style' ), 'default' => $front_page_defaults['contacts']['owner']['alt'] ),
			array( 'id' => 'contacts_socials', 'section' => 'contacts', 'label' => __( 'Social links', 're-style' ), 'default' => re_style_serialize_pair_list( $front_page_defaults['contacts']['socials'], 'label', 'url' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One social link per line using Label | URL.', 're-style' ) ),
			array( 'id' => 'contacts_cta_label', 'section' => 'contacts', 'label' => __( 'CTA label', 're-style' ), 'default' => $front_page_defaults['contacts']['cta']['label'] ),
			array( 'id' => 'contacts_cta_url', 'section' => 'contacts', 'label' => __( 'CTA URL', 're-style' ), 'default' => $front_page_defaults['contacts']['cta']['url'], 'sanitize' => 'esc_url_raw' ),

			array( 'id' => 'faq_label', 'section' => 'faq', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['faq']['label'] ),
			array( 'id' => 'faq_title', 'section' => 'faq', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['faq']['title'] ),
			array( 'id' => 'faq_description', 'section' => 'faq', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['faq']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'faq_items', 'section' => 'faq', 'label' => __( 'FAQ items', 're-style' ), 'default' => re_style_serialize_pair_list( $front_page_defaults['faq']['items'], 'question', 'answer' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field', 'description' => __( 'One FAQ per line using Question | Answer.', 're-style' ) ),

			array( 'id' => 'newsletter_label', 'section' => 'newsletter', 'label' => __( 'Label', 're-style' ), 'default' => $front_page_defaults['newsletter']['label'] ),
			array( 'id' => 'newsletter_title', 'section' => 'newsletter', 'label' => __( 'Title', 're-style' ), 'default' => $front_page_defaults['newsletter']['title'] ),
			array( 'id' => 'newsletter_description', 'section' => 'newsletter', 'label' => __( 'Description', 're-style' ), 'default' => $front_page_defaults['newsletter']['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'newsletter_note', 'section' => 'newsletter', 'label' => __( 'Consent note', 're-style' ), 'default' => $front_page_defaults['newsletter']['note'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'id' => 'newsletter_privacy_url', 'section' => 'newsletter', 'label' => __( 'Privacy policy URL', 're-style' ), 'default' => $front_page_defaults['newsletter']['privacy_url'], 'sanitize' => 'esc_url_raw' ),
		);

		foreach ( $controls as $control ) {
			$setting_id = 're_style_home_' . $control['id'];

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $control['default'],
					'sanitize_callback' => isset( $control['sanitize'] ) ? $control['sanitize'] : 'sanitize_text_field',
				)
			);

			if ( isset( $control['type'] ) && 'image' === $control['type'] ) {
				$wp_customize->add_control(
					new WP_Customize_Image_Control(
						$wp_customize,
						$setting_id,
						array(
							'label'       => $control['label'],
							'section'     => 're_style_home_' . $control['section'],
							'description' => isset( $control['description'] ) ? $control['description'] : '',
						)
					)
				);

				continue;
			}

			$wp_customize->add_control(
				$setting_id,
				array(
					'label'       => $control['label'],
					'section'     => 're_style_home_' . $control['section'],
					'type'        => isset( $control['type'] ) ? $control['type'] : 'text',
					'description' => isset( $control['description'] ) ? $control['description'] : '',
				)
			);
		}
	}
}
add_action( 'customize_register', 're_style_customize_register' );

if ( ! function_exists( 're_style_enqueue_block_editor_assets' ) ) {
	/**
	 * Loads editor-facing fonts and token overrides.
	 *
	 * @return void
	 */
	function re_style_enqueue_block_editor_assets() {
		wp_enqueue_style(
			're-style-editor-fonts',
			re_style_get_google_fonts_url(),
			array(),
			null
		);

		wp_add_inline_style( 'wp-edit-blocks', re_style_get_design_tokens_css( '.editor-styles-wrapper' ) );
	}
}
add_action( 'enqueue_block_editor_assets', 're_style_enqueue_block_editor_assets' );
