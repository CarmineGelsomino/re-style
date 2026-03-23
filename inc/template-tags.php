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
		$location = ! empty( $args['theme_location'] ) ? $args['theme_location'] : '';
		$items = array();

		switch ( $location ) {
			case 'footer_navigation':
				$items = array(
					array( 'label' => __( 'Storia', 're-style' ), 'url' => home_url( '/#storia' ) ),
					array( 'label' => __( 'Servizi', 're-style' ), 'url' => home_url( '/#servizi' ) ),
					array( 'label' => __( 'Galleria', 're-style' ), 'url' => home_url( '/#galleria' ) ),
					array( 'label' => __( 'Videoconsigli', 're-style' ), 'url' => home_url( '/#videoconsigli' ) ),
					array( 'label' => __( 'Sede e Orari', 're-style' ), 'url' => home_url( '/#sede-orari' ) ),
					array( 'label' => __( 'Contatti', 're-style' ), 'url' => home_url( '/#contatti' ) ),
				);
				break;
			case 'footer_shop':
				$items = array(
					array( 'label' => __( 'Cura dei capelli', 're-style' ), 'url' => '#' ),
					array( 'label' => __( 'Cura della barba', 're-style' ), 'url' => '#' ),
					array( 'label' => __( 'Dispositivi elettronici', 're-style' ), 'url' => '#' ),
				);
				break;
			case 'footer_info':
				$items = array(
					array( 'label' => __( 'Spedizioni', 're-style' ), 'url' => home_url( '/informazioni/#spedizioni' ) ),
					array( 'label' => __( 'Resi e rimborsi', 're-style' ), 'url' => home_url( '/informazioni/#resi-rimborsi' ) ),
					array( 'label' => __( 'Metodi di pagamento', 're-style' ), 'url' => home_url( '/informazioni/#pagamenti' ) ),
					array( 'label' => __( 'Supporto clienti', 're-style' ), 'url' => home_url( '/informazioni/#supporto-clienti' ) ),
					array( 'label' => __( 'Faq', 're-style' ), 'url' => home_url( '/#faq' ) ),
				);
				break;
			case 'footer_legal':
				$items = array(
					array( 'label' => __( 'Privacy Policy', 're-style' ), 'url' => '#' ),
					array( 'label' => __( 'Cookie Policy', 're-style' ), 'url' => '#' ),
					array( 'label' => __( 'Termini e Condizioni', 're-style' ), 'url' => '#' ),
				);
				break;
		}

		if ( empty( $items ) ) {
			$items = array(
				array( 'label' => __( 'Home', 're-style' ), 'url' => home_url( '/' ) ),
			);
		}

		echo '<ul id="' . esc_attr( $menu_id ) . '" class="menu footer-menu">';
		foreach ( $items as $item ) {
			echo '<li class="menu-item"><a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['label'] ) . '</a></li>';
		}
		echo '</ul>';
	}
}

if ( ! function_exists( 're_style_get_topbar_default_messages' ) ) {
	/**
	 * Returns default topbar messages.
	 *
	 * @return string[]
	 */
	function re_style_get_topbar_default_messages() {
		return array(
			__( 'Buy from our shop', 're-style' ),
			__( 'Free shipping over EUR 50', 're-style' ),
			__( 'Book your services', 're-style' ),
		);
	}
}

if ( ! function_exists( 're_style_get_free_shipping_notice' ) ) {
	/**
	 * Returns a WooCommerce-aware free shipping notice when available.
	 *
	 * @return string
	 */
	function re_style_get_free_shipping_notice() {
		if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'WC_Shipping_Zones' ) ) {
			return '';
		}

		$shipping_methods = array();
		$zones            = WC_Shipping_Zones::get_zones();

		foreach ( $zones as $zone ) {
			if ( empty( $zone['shipping_methods'] ) || ! is_array( $zone['shipping_methods'] ) ) {
				continue;
			}

			$shipping_methods = array_merge( $shipping_methods, $zone['shipping_methods'] );
		}

		$default_zone = WC_Shipping_Zones::get_zone_by( 'zone_id', 0 );

		if ( $default_zone && method_exists( $default_zone, 'get_shipping_methods' ) ) {
			$shipping_methods = array_merge( $shipping_methods, $default_zone->get_shipping_methods( true ) );
		}

		$lowest_min_amount      = null;
		$has_threshold_message  = false;
		$has_generic_available  = false;

		foreach ( $shipping_methods as $method ) {
			if ( ! is_object( $method ) ) {
				continue;
			}

			$method_id = '';

			if ( isset( $method->id ) && is_string( $method->id ) ) {
				$method_id = $method->id;
			} elseif ( isset( $method->method_id ) && is_string( $method->method_id ) ) {
				$method_id = $method->method_id;
			}

			if ( 'free_shipping' !== $method_id ) {
				continue;
			}

			$enabled = isset( $method->enabled ) ? $method->enabled : 'no';

			if ( 'yes' !== $enabled ) {
				continue;
			}

			$requires = '';

			if ( isset( $method->requires ) && is_string( $method->requires ) ) {
				$requires = $method->requires;
			} elseif ( method_exists( $method, 'get_option' ) ) {
				$requires = (string) $method->get_option( 'requires', '' );
			}

			$min_amount = 0;

			if ( isset( $method->min_amount ) ) {
				$min_amount = (float) $method->min_amount;
			} elseif ( method_exists( $method, 'get_option' ) ) {
				$min_amount = (float) $method->get_option( 'min_amount', 0 );
			}

			if ( in_array( $requires, array( 'min_amount', 'either', 'both' ), true ) && $min_amount > 0 ) {
				$has_threshold_message = true;

				if ( null === $lowest_min_amount || $min_amount < $lowest_min_amount ) {
					$lowest_min_amount = $min_amount;
				}

				continue;
			}

			if ( '' === $requires ) {
				$has_generic_available = true;
			}
		}

		if ( $has_threshold_message && null !== $lowest_min_amount && function_exists( 'wc_price' ) ) {
			return sprintf(
				/* translators: %s free shipping threshold price. */
				__( 'Free shipping from %s', 're-style' ),
				wp_strip_all_tags( wc_price( $lowest_min_amount ) )
			);
		}

		if ( $has_threshold_message && null !== $lowest_min_amount ) {
			$price = number_format_i18n( $lowest_min_amount, 2 );

			if ( function_exists( 'get_woocommerce_currency_symbol' ) ) {
				$price = get_woocommerce_currency_symbol() . $price;
			}

			return sprintf(
				/* translators: %s free shipping threshold price. */
				__( 'Free shipping from %s', 're-style' ),
				$price
			);
		}

		if ( $has_generic_available ) {
			return __( 'Free shipping available', 're-style' );
		}

		return '';
	}
}

if ( ! function_exists( 're_style_get_floating_book_action' ) ) {
	/**
	 * Returns the floating booking CTA label and URL.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_floating_book_action() {
		$defaults = array(
			'label' => __( 'Book', 're-style' ),
			'url'   => '#contatti',
		);

		$label = get_theme_mod( 're_style_home_floating_book_label', $defaults['label'] );
		$url   = get_theme_mod( 're_style_home_floating_book_url', $defaults['url'] );

		$label = is_string( $label ) && '' !== trim( $label ) ? trim( $label ) : $defaults['label'];
		$url   = is_string( $url ) && '' !== trim( $url ) ? trim( $url ) : $defaults['url'];

		return array(
			'label' => $label,
			'url'   => $url,
		);
	}
}

if ( ! function_exists( 're_style_get_topbar_messages' ) ) {
	/**
	 * Returns topbar messages.
	 *
	 * @return string[]
	 */
	function re_style_get_topbar_messages() {
		$default_messages = re_style_get_topbar_default_messages();
		$serialized       = get_theme_mod( 're_style_home_topbar_messages', implode( "\n", $default_messages ) );
		$parsed_messages  = re_style_parse_single_value_lines( $serialized, 'value' );
		$messages         = ! empty( $parsed_messages ) ? wp_list_pluck( $parsed_messages, 'value' ) : $default_messages;
		$show_shipping    = (bool) get_theme_mod( 're_style_home_topbar_enable_free_shipping', false );

		if ( $show_shipping ) {
			$shipping_notice = re_style_get_free_shipping_notice();

			if ( $shipping_notice ) {
				$messages = array_filter(
					$messages,
					static function ( $message ) {
						return __( 'Free shipping over EUR 50', 're-style' ) !== $message;
					}
				);

				$messages[] = $shipping_notice;
			}
		}

		$messages = array_filter(
			array_map( 'trim', $messages ),
			static function ( $message ) {
				return '' !== $message;
			}
		);

		return array_values( array_unique( $messages ) );
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

			$wishlist_page = get_page_by_path( 'lista-preferiti' );

			if ( ! $wishlist_page instanceof WP_Post ) {
				$wishlist_page = get_page_by_path( 'wishlist' );
			}

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
