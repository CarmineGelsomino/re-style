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
			'font_size_label' => '12px',
			'font_size_body'  => '16px',
			'font_size_lead'  => '18px',
			'font_size_title' => '24px',
			'font_size_h2'    => '40px',
			'font_size_hero'  => '72px',
			'space_gutter'    => '16px',
			'space_section'   => '64px',
			'space_stack'     => '24px',
			'radius'          => '8px',
			'content_width'   => '1200px',
			'content_narrow'  => '760px',
			'topbar_height'   => '30px',
			'header_height'   => '72px',
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

		if ( preg_match( '/^\d+(?:\.\d+)?(?:px|vw|vh|%)$/', $value ) ) {
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

if ( ! function_exists( 're_style_get_theme_option_value' ) ) {
	/**
	 * Returns a scalar theme-mod value with fallback for non-home sections.
	 *
	 * @param string $scope   Setting scope.
	 * @param string $key     Setting key.
	 * @param string $default Default value.
	 * @return string
	 */
	function re_style_get_theme_option_value( $scope, $key, $default ) {
		$value = get_theme_mod( 're_style_' . $scope . '_' . $key, $default );

		return is_string( $value ) && '' !== trim( $value ) ? trim( $value ) : $default;
	}
}

if ( ! function_exists( 're_style_get_404_defaults' ) ) {
	/**
	 * Returns default 404-page content.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_404_defaults() {
		$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

		return array(
			'label'           => __( 'Errore 404', 're-style' ),
			'title'           => __( 'Pagina non trovata', 're-style' ),
			'description'     => __( 'La pagina che stai cercando potrebbe essere stata spostata, rinominata oppure non essere piu disponibile. Puoi tornare alla home oppure visitare lo shop.', 're-style' ),
			'primary_label'   => __( 'Torna alla home', 're-style' ),
			'primary_url'     => home_url( '/' ),
			'secondary_label' => __( 'Vai allo shop', 're-style' ),
			'secondary_url'   => $shop_url ? $shop_url : home_url( '/' ),
		);
	}
}

if ( ! function_exists( 're_style_get_404_data' ) ) {
	/**
	 * Returns 404-page content with Customizer overrides.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_404_data() {
		$defaults = re_style_get_404_defaults();

		return array(
			'label'           => re_style_get_theme_option_value( '404', 'label', $defaults['label'] ),
			'title'           => re_style_get_theme_option_value( '404', 'title', $defaults['title'] ),
			'description'     => re_style_get_theme_option_value( '404', 'description', $defaults['description'] ),
			'primary_label'   => re_style_get_theme_option_value( '404', 'primary_label', $defaults['primary_label'] ),
			'primary_url'     => re_style_get_theme_option_value( '404', 'primary_url', $defaults['primary_url'] ),
			'secondary_label' => re_style_get_theme_option_value( '404', 'secondary_label', $defaults['secondary_label'] ),
			'secondary_url'   => re_style_get_theme_option_value( '404', 'secondary_url', $defaults['secondary_url'] ),
		);
	}
}

if ( ! function_exists( 're_style_get_account_page_defaults' ) ) {
	/**
	 * Returns default account-page intro content.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_account_page_defaults() {
		$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

		return array(
			'label'           => __( 'Area personale', 're-style' ),
			'title'           => __( 'Il tuo account Re Style', 're-style' ),
			'description'     => __( 'Da qui puoi accedere ai tuoi ordini, modificare indirizzi e dettagli profilo oppure consultare i contenuti riservati del tuo account.', 're-style' ),
			'primary_label'   => __( 'Vai allo shop', 're-style' ),
			'primary_url'     => $shop_url ? $shop_url : home_url( '/' ),
			'secondary_label' => __( 'Torna alla home', 're-style' ),
			'secondary_url'   => home_url( '/' ),
		);
	}
}

if ( ! function_exists( 're_style_get_account_page_data' ) ) {
	/**
	 * Returns account-page intro content with Customizer overrides.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_account_page_data() {
		$defaults = re_style_get_account_page_defaults();

		return array(
			'label'           => re_style_get_theme_option_value( 'account', 'label', $defaults['label'] ),
			'title'           => re_style_get_theme_option_value( 'account', 'title', $defaults['title'] ),
			'description'     => re_style_get_theme_option_value( 'account', 'description', $defaults['description'] ),
			'primary_label'   => re_style_get_theme_option_value( 'account', 'primary_label', $defaults['primary_label'] ),
			'primary_url'     => re_style_get_theme_option_value( 'account', 'primary_url', $defaults['primary_url'] ),
			'secondary_label' => re_style_get_theme_option_value( 'account', 'secondary_label', $defaults['secondary_label'] ),
			'secondary_url'   => re_style_get_theme_option_value( 'account', 'secondary_url', $defaults['secondary_url'] ),
		);
	}
}

if ( ! function_exists( 're_style_get_shipping_page_defaults' ) ) {
	/**
	 * Returns default shipping-page content.
	 *
	 * @return array<string, mixed>
	 */
	function re_style_get_shipping_page_defaults() {
		$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );

		return array(
			'label'                => __( 'Spedizioni', 're-style' ),
			'title'                => __( 'Consegna veloce e sicura per i tuoi prodotti beauty', 're-style' ),
			'description'          => __( 'Acquista i tuoi prodotti di bellezza preferiti con una consegna veloce e sicura. Qui trovi tutte le informazioni sulle modalita di spedizione disponibili.', 're-style' ),
			'costs_title'          => __( 'Costi e tempi di spedizione', 're-style' ),
			'costs_items'          => array(
				array(
					'label' => __( 'Costo standard', 're-style' ),
					'value' => __( '7,50 euro', 're-style' ),
				),
				array(
					'label' => __( 'Tempi di consegna', 're-style' ),
					'value' => __( "Entro 2 giorni lavorativi dall'elaborazione dell'ordine.", 're-style' ),
				),
				array(
					'label' => __( 'Spedizione gratuita', 're-style' ),
					'value' => __( 'Per ordini a partire da 79,90 euro.', 're-style' ),
				),
			),
			'costs_note'           => __( 'Le condizioni di spedizione possono variare in base a promozioni attive o codici sconto. Ti invitiamo a verificare le offerte in corso prima di completare il pagamento.', 're-style' ),
			'process_title'        => __( 'Processo di spedizione', 're-style' ),
			'process_steps'        => array(
				array(
					'text' => __( "Conferma il tuo ordine e scegli l'indirizzo di spedizione.", 're-style' ),
				),
				array(
					'text' => __( 'Ricevi una mail con il tracking per monitorare lo stato della consegna.', 're-style' ),
				),
				array(
					'text' => __( 'Il tuo pacco sara consegnato entro il tempo indicato.', 're-style' ),
				),
			),
			'delivery_title'       => __( 'Metodi di consegna', 're-style' ),
			'delivery_description' => __( 'Collaboriamo con corrieri affidabili per garantire la massima sicurezza e puntualita nella consegna.', 're-style' ),
			'faq_title'            => __( 'Domande frequenti', 're-style' ),
			'faq_items'            => array(
				array(
					'question' => __( 'Quando viene spedito il mio ordine?', 're-style' ),
					'answer'   => __( 'Gli ordini vengono elaborati entro 24 ore e consegnati entro 2 giorni lavorativi.', 're-style' ),
				),
				array(
					'question' => __( "Posso modificare l'indirizzo di spedizione dopo l'ordine?", 're-style' ),
					'answer'   => __( 'Contatta il nostro servizio clienti il prima possibile per verificare la disponibilita della modifica.', 're-style' ),
				),
				array(
					'question' => __( 'Cosa succede se non sono presente alla consegna?', 're-style' ),
					'answer'   => __( 'Il corriere effettuera un secondo tentativo di consegna o lascera istruzioni per il ritiro presso un punto di raccolta.', 're-style' ),
				),
			),
			'support_title'        => __( 'Hai bisogno di aiuto?', 're-style' ),
			'support_description'  => __( 'Per qualsiasi domanda sulla spedizione, puoi contattarci direttamente a', 're-style' ),
			'support_email'        => 'servizio-clienti@site.com',
			'primary_label'        => __( 'Contattaci', 're-style' ),
			'primary_url'          => home_url( '/#contatti' ),
			'secondary_label'      => __( 'Torna allo shop', 're-style' ),
			'secondary_url'        => $shop_url ? $shop_url : home_url( '/' ),
		);
	}
}

if ( ! function_exists( 're_style_get_shipping_page_data' ) ) {
	/**
	 * Returns shipping-page content with Customizer overrides.
	 *
	 * @return array<string, mixed>
	 */
	function re_style_get_shipping_page_data() {
		$defaults      = re_style_get_shipping_page_defaults();
		$costs_items   = re_style_parse_pair_lines( re_style_get_theme_option_value( 'shipping', 'costs_items', re_style_serialize_pair_list( $defaults['costs_items'], 'label', 'value' ) ), 'label', 'value' );
		$process_steps = re_style_parse_single_value_lines( re_style_get_theme_option_value( 'shipping', 'process_steps', re_style_serialize_single_value_list( $defaults['process_steps'], 'text' ) ), 'text' );
		$faq_items     = re_style_parse_pair_lines( re_style_get_theme_option_value( 'shipping', 'faq_items', re_style_serialize_pair_list( $defaults['faq_items'], 'question', 'answer' ) ), 'question', 'answer' );

		return array(
			'label'                => re_style_get_theme_option_value( 'shipping', 'label', $defaults['label'] ),
			'title'                => re_style_get_theme_option_value( 'shipping', 'title', $defaults['title'] ),
			'description'          => re_style_get_theme_option_value( 'shipping', 'description', $defaults['description'] ),
			'costs_title'          => re_style_get_theme_option_value( 'shipping', 'costs_title', $defaults['costs_title'] ),
			'costs_items'          => ! empty( $costs_items ) ? $costs_items : $defaults['costs_items'],
			'costs_note'           => re_style_get_theme_option_value( 'shipping', 'costs_note', $defaults['costs_note'] ),
			'process_title'        => re_style_get_theme_option_value( 'shipping', 'process_title', $defaults['process_title'] ),
			'process_steps'        => ! empty( $process_steps ) ? $process_steps : $defaults['process_steps'],
			'delivery_title'       => re_style_get_theme_option_value( 'shipping', 'delivery_title', $defaults['delivery_title'] ),
			'delivery_description' => re_style_get_theme_option_value( 'shipping', 'delivery_description', $defaults['delivery_description'] ),
			'faq_title'            => re_style_get_theme_option_value( 'shipping', 'faq_title', $defaults['faq_title'] ),
			'faq_items'            => ! empty( $faq_items ) ? $faq_items : $defaults['faq_items'],
			'support_title'        => re_style_get_theme_option_value( 'shipping', 'support_title', $defaults['support_title'] ),
			'support_description'  => re_style_get_theme_option_value( 'shipping', 'support_description', $defaults['support_description'] ),
			'support_email'        => re_style_get_theme_option_value( 'shipping', 'support_email', $defaults['support_email'] ),
			'primary_label'        => re_style_get_theme_option_value( 'shipping', 'primary_label', $defaults['primary_label'] ),
			'primary_url'          => re_style_get_theme_option_value( 'shipping', 'primary_url', $defaults['primary_url'] ),
			'secondary_label'      => re_style_get_theme_option_value( 'shipping', 'secondary_label', $defaults['secondary_label'] ),
			'secondary_url'        => re_style_get_theme_option_value( 'shipping', 'secondary_url', $defaults['secondary_url'] ),
		);
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
		$error_404_defaults  = re_style_get_404_defaults();
		$account_defaults    = re_style_get_account_page_defaults();
		$shipping_defaults   = re_style_get_shipping_page_defaults();

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
					'description' => in_array( $key, array( 'font_primary', 'font_secondary' ), true ) ? __( 'Insert a valid CSS font-family stack.', 're-style' ) : __( 'Use a CSS length such as 12px, 1200px or 64px. Responsive values like vw, vh and % remain allowed where needed.', 're-style' ),
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

		$wp_customize->add_section(
			're_style_error_404',
			array(
				'title'    => __( '404 Page', 're-style' ),
				'panel'    => 're_style_theme_options',
				'priority' => 22,
			)
		);

		$wp_customize->add_section(
			're_style_account_page',
			array(
				'title'    => __( 'Account Page', 're-style' ),
				'panel'    => 're_style_theme_options',
				'priority' => 23,
			)
		);

		$wp_customize->add_section(
			're_style_shipping_page',
			array(
				'title'    => __( 'Shipping Page', 're-style' ),
				'panel'    => 're_style_theme_options',
				'priority' => 24,
			)
		);

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

		$page_controls = array(
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'label', 'label' => __( 'Eyebrow label', 're-style' ), 'default' => $error_404_defaults['label'] ),
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'title', 'label' => __( 'Title', 're-style' ), 'default' => $error_404_defaults['title'] ),
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'description', 'label' => __( 'Description', 're-style' ), 'default' => $error_404_defaults['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'primary_label', 'label' => __( 'Primary button label', 're-style' ), 'default' => $error_404_defaults['primary_label'] ),
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'primary_url', 'label' => __( 'Primary button URL', 're-style' ), 'default' => $error_404_defaults['primary_url'], 'sanitize' => 'esc_url_raw' ),
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'secondary_label', 'label' => __( 'Secondary button label', 're-style' ), 'default' => $error_404_defaults['secondary_label'] ),
			array( 'scope' => '404', 'section' => 'error_404', 'id' => 'secondary_url', 'label' => __( 'Secondary button URL', 're-style' ), 'default' => $error_404_defaults['secondary_url'], 'sanitize' => 'esc_url_raw' ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'label', 'label' => __( 'Eyebrow label', 're-style' ), 'default' => $account_defaults['label'] ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'title', 'label' => __( 'Title', 're-style' ), 'default' => $account_defaults['title'] ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'description', 'label' => __( 'Description', 're-style' ), 'default' => $account_defaults['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'primary_label', 'label' => __( 'Primary button label', 're-style' ), 'default' => $account_defaults['primary_label'] ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'primary_url', 'label' => __( 'Primary button URL', 're-style' ), 'default' => $account_defaults['primary_url'], 'sanitize' => 'esc_url_raw' ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'secondary_label', 'label' => __( 'Secondary button label', 're-style' ), 'default' => $account_defaults['secondary_label'] ),
			array( 'scope' => 'account', 'section' => 'account_page', 'id' => 'secondary_url', 'label' => __( 'Secondary button URL', 're-style' ), 'default' => $account_defaults['secondary_url'], 'sanitize' => 'esc_url_raw' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'label', 'label' => __( 'Eyebrow label', 're-style' ), 'default' => $shipping_defaults['label'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'title', 'label' => __( 'Title', 're-style' ), 'default' => $shipping_defaults['title'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'description', 'label' => __( 'Description', 're-style' ), 'default' => $shipping_defaults['description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'costs_title', 'label' => __( 'Costs section title', 're-style' ), 'default' => $shipping_defaults['costs_title'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'costs_items', 'label' => __( 'Costs and timing items', 're-style' ), 'default' => re_style_serialize_pair_list( $shipping_defaults['costs_items'], 'label', 'value' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'costs_note', 'label' => __( 'Costs note', 're-style' ), 'default' => $shipping_defaults['costs_note'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'process_title', 'label' => __( 'Process section title', 're-style' ), 'default' => $shipping_defaults['process_title'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'process_steps', 'label' => __( 'Process steps', 're-style' ), 'default' => re_style_serialize_single_value_list( $shipping_defaults['process_steps'], 'text' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'delivery_title', 'label' => __( 'Delivery section title', 're-style' ), 'default' => $shipping_defaults['delivery_title'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'delivery_description', 'label' => __( 'Delivery description', 're-style' ), 'default' => $shipping_defaults['delivery_description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'faq_title', 'label' => __( 'FAQ section title', 're-style' ), 'default' => $shipping_defaults['faq_title'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'faq_items', 'label' => __( 'FAQ items', 're-style' ), 'default' => re_style_serialize_pair_list( $shipping_defaults['faq_items'], 'question', 'answer' ), 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'support_title', 'label' => __( 'Support title', 're-style' ), 'default' => $shipping_defaults['support_title'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'support_description', 'label' => __( 'Support description', 're-style' ), 'default' => $shipping_defaults['support_description'], 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'support_email', 'label' => __( 'Support email', 're-style' ), 'default' => $shipping_defaults['support_email'], 'sanitize' => 'sanitize_email' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'primary_label', 'label' => __( 'Primary button label', 're-style' ), 'default' => $shipping_defaults['primary_label'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'primary_url', 'label' => __( 'Primary button URL', 're-style' ), 'default' => $shipping_defaults['primary_url'], 'sanitize' => 'esc_url_raw' ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'secondary_label', 'label' => __( 'Secondary button label', 're-style' ), 'default' => $shipping_defaults['secondary_label'] ),
			array( 'scope' => 'shipping', 'section' => 'shipping_page', 'id' => 'secondary_url', 'label' => __( 'Secondary button URL', 're-style' ), 'default' => $shipping_defaults['secondary_url'], 'sanitize' => 'esc_url_raw' ),
		);

		foreach ( $page_controls as $control ) {
			$setting_id = 're_style_' . $control['scope'] . '_' . $control['id'];

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $control['default'],
					'sanitize_callback' => isset( $control['sanitize'] ) ? $control['sanitize'] : 'sanitize_text_field',
				)
			);

			$wp_customize->add_control(
				$setting_id,
				array(
					'label'   => $control['label'],
					'section' => 're_style_' . $control['section'],
					'type'    => isset( $control['type'] ) ? $control['type'] : 'text',
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
