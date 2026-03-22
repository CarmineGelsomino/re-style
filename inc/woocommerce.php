<?php
/**
 * WooCommerce integration helpers.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_is_shop_archive' ) ) {
	/**
	 * Returns whether the current request is a WooCommerce catalog archive.
	 *
	 * @return bool
	 */
	function re_style_is_shop_archive() {
		return function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() );
	}
}

if ( ! function_exists( 're_style_get_shop_page_url' ) ) {
	/**
	 * Returns the canonical shop page URL.
	 *
	 * @return string
	 */
	function re_style_get_shop_page_url() {
		if ( function_exists( 'wc_get_page_permalink' ) ) {
			$url = wc_get_page_permalink( 'shop' );

			if ( $url ) {
				return $url;
			}
		}

		return home_url( '/' );
	}
}

if ( ! function_exists( 're_style_get_shop_search_term' ) ) {
	/**
	 * Returns the current catalog search term from the custom archive form.
	 *
	 * @return string
	 */
	function re_style_get_shop_search_term() {
		$search = isset( $_GET['shop_search'] ) ? wp_unslash( $_GET['shop_search'] ) : '';

		return is_string( $search ) ? trim( sanitize_text_field( $search ) ) : '';
	}
}

if ( ! function_exists( 're_style_get_shop_filter_values' ) ) {
	/**
	 * Returns sanitized selected filter values for a taxonomy.
	 *
	 * @param string $taxonomy Taxonomy name.
	 * @return string[]
	 */
	function re_style_get_shop_filter_values( $taxonomy ) {
		$key    = 'filter_' . $taxonomy;
		$values = isset( $_GET[ $key ] ) ? wp_unslash( $_GET[ $key ] ) : array();

		if ( ! is_array( $values ) ) {
			$values = array( $values );
		}

		$values = array_map( 'sanitize_title', $values );
		$values = array_filter(
			$values,
			static function ( $value ) {
				return '' !== $value;
			}
		);

		if ( empty( $values ) && is_tax( $taxonomy ) ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				$values[] = $term->slug;
			}
		}

		return array_values( array_unique( $values ) );
	}
}

if ( ! function_exists( 're_style_get_shop_taxonomy_filters' ) ) {
	/**
	 * Returns dynamic product taxonomies to expose in the sidebar.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	function re_style_get_shop_taxonomy_filters() {
		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return array();
		}

		$taxonomies = array( 'product_cat' );

		if ( function_exists( 'wc_get_attribute_taxonomy_names' ) ) {
			foreach ( wc_get_attribute_taxonomy_names() as $attribute_taxonomy ) {
				if ( taxonomy_exists( $attribute_taxonomy ) ) {
					$taxonomies[] = $attribute_taxonomy;
				}
			}
		}

		$filters = array();

		foreach ( array_unique( $taxonomies ) as $taxonomy ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => true,
				)
			);

			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				continue;
			}

			$taxonomy_object = get_taxonomy( $taxonomy );

			$filters[] = array(
				'taxonomy' => $taxonomy,
				'label'    => $taxonomy_object && ! empty( $taxonomy_object->labels->singular_name ) ? $taxonomy_object->labels->singular_name : $taxonomy,
				'terms'    => $terms,
				'selected' => re_style_get_shop_filter_values( $taxonomy ),
			);
		}

		return $filters;
	}
}

if ( ! function_exists( 're_style_get_shop_category_tabs' ) ) {
	/**
	 * Returns top-level category tabs for the archive toolbar.
	 *
	 * @return WP_Term[]
	 */
	function re_style_get_shop_category_tabs() {
		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'parent'     => 0,
				'hide_empty' => true,
			)
		);

		if ( is_wp_error( $terms ) ) {
			return array();
		}

		return $terms;
	}
}

if ( ! function_exists( 're_style_get_shop_availability_filters' ) ) {
	/**
	 * Returns availability filters with selected state.
	 *
	 * @return array<int, array<string, string|bool>>
	 */
	function re_style_get_shop_availability_filters() {
		return array(
			array(
				'key'      => 'in_stock',
				'label'    => __( 'Disponibile', 're-style' ),
				'selected' => ! empty( $_GET['in_stock'] ),
			),
			array(
				'key'      => 'on_sale',
				'label'    => __( 'In offerta', 're-style' ),
				'selected' => ! empty( $_GET['on_sale'] ),
			),
			array(
				'key'      => 'new_arrivals',
				'label'    => __( 'Nuovi arrivi', 're-style' ),
				'selected' => ! empty( $_GET['new_arrivals'] ),
			),
		);
	}
}

if ( ! function_exists( 're_style_get_shop_price_filter_values' ) ) {
	/**
	 * Returns sanitized min and max price values.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_shop_price_filter_values() {
		$min_price = isset( $_GET['min_price'] ) ? wc_format_decimal( wp_unslash( $_GET['min_price'] ) ) : '';
		$max_price = isset( $_GET['max_price'] ) ? wc_format_decimal( wp_unslash( $_GET['max_price'] ) ) : '';

		return array(
			'min' => '' !== $min_price ? (string) $min_price : '',
			'max' => '' !== $max_price ? (string) $max_price : '',
		);
	}
}

if ( ! function_exists( 're_style_get_shop_orderby_options' ) ) {
	/**
	 * Returns the WooCommerce order by options.
	 *
	 * @return array<string, string>
	 */
	function re_style_get_shop_orderby_options() {
		if ( function_exists( 'woocommerce_catalog_orderby' ) ) {
			$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by latest', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
			) );

			return is_array( $catalog_orderby ) ? $catalog_orderby : array();
		}

		return array();
	}
}

if ( ! function_exists( 're_style_get_current_shop_orderby' ) ) {
	/**
	 * Returns the current orderby value.
	 *
	 * @return string
	 */
	function re_style_get_current_shop_orderby() {
		$orderby = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : '';

		if ( '' !== $orderby ) {
			return $orderby;
		}

		return (string) apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
	}
}

if ( ! function_exists( 're_style_get_shop_preserved_query_args' ) ) {
	/**
	 * Returns current filter query args except the provided exclusions.
	 *
	 * @param string[] $exclude Keys to exclude.
	 * @param bool     $include_archive_context Whether to preserve current taxonomy archive context.
	 * @return array<string, mixed>
	 */
	function re_style_get_shop_preserved_query_args( $exclude = array(), $include_archive_context = true ) {
		$query_args = wp_unslash( $_GET );

		if ( ! is_array( $query_args ) ) {
			return array();
		}

		foreach ( $exclude as $key ) {
			unset( $query_args[ $key ] );
		}

		unset( $query_args['paged'] );

		if ( $include_archive_context && is_tax() ) {
			$term = get_queried_object();

			if ( $term instanceof WP_Term ) {
				$filter_key = 'filter_' . $term->taxonomy;

				if ( ! isset( $query_args[ $filter_key ] ) && ! in_array( $filter_key, $exclude, true ) ) {
					$query_args[ $filter_key ] = array( $term->slug );
				}
			}
		}

		return $query_args;
	}
}

if ( ! function_exists( 're_style_render_shop_hidden_fields' ) ) {
	/**
	 * Outputs hidden fields for preserved GET params.
	 *
	 * @param string[] $exclude Keys to exclude.
	 * @param bool     $include_archive_context Whether to preserve current taxonomy archive context.
	 * @return void
	 */
	function re_style_render_shop_hidden_fields( $exclude = array(), $include_archive_context = true ) {
		foreach ( re_style_get_shop_preserved_query_args( $exclude, $include_archive_context ) as $key => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $item ) {
					printf(
						'<input type="hidden" name="%1$s[]" value="%2$s">',
						esc_attr( $key ),
						esc_attr( sanitize_text_field( $item ) )
					);
				}

				continue;
			}

			printf(
				'<input type="hidden" name="%1$s" value="%2$s">',
				esc_attr( $key ),
				esc_attr( sanitize_text_field( (string) $value ) )
			);
		}
	}
}

if ( ! function_exists( 're_style_get_shop_active_term_slug' ) ) {
	/**
	 * Returns the active product category slug for tabs.
	 *
	 * @return string
	 */
	function re_style_get_shop_active_term_slug() {
		if ( is_tax( 'product_cat' ) ) {
			$term = get_queried_object();

			return $term instanceof WP_Term ? $term->slug : '';
		}

		$selected_categories = re_style_get_shop_filter_values( 'product_cat' );

		return 1 === count( $selected_categories ) ? $selected_categories[0] : '';
	}
}

if ( ! function_exists( 're_style_is_product_new_arrival' ) ) {
	/**
	 * Returns whether a product should receive the "new" badge.
	 *
	 * @param WC_Product $product Product object.
	 * @return bool
	 */
	function re_style_is_product_new_arrival( $product ) {
		$newness_days = (int) apply_filters( 're_style_shop_newness_days', 30 );
		$created      = $product instanceof WC_Product ? $product->get_date_created() : false;

		if ( ! $created ) {
			return false;
		}

		$threshold = strtotime( '-' . absint( $newness_days ) . ' days' );

		return $created->getTimestamp() >= $threshold;
	}
}

if ( ! function_exists( 're_style_get_product_badge' ) ) {
	/**
	 * Returns the most appropriate badge for a loop product.
	 *
	 * @param WC_Product $product Product object.
	 * @return array<string, string>
	 */
	function re_style_get_product_badge( $product ) {
		$default_badge = array(
			'label' => '',
			'class' => '',
		);

		if ( ! $product instanceof WC_Product ) {
			return $default_badge;
		}

		if ( $product->is_on_sale() ) {
			return array(
				'label' => __( 'Promo', 're-style' ),
				'class' => 'badge-promo',
			);
		}

		if ( re_style_is_product_new_arrival( $product ) ) {
			return array(
				'label' => __( 'Novità', 're-style' ),
				'class' => 'badge-new',
			);
		}

		$kit_taxonomies = array( 'product_cat', 'product_tag' );

		foreach ( $kit_taxonomies as $taxonomy ) {
			if ( has_term( array( 'kit', 'kits', 'bundle', 'bundles' ), $taxonomy, $product->get_id() ) ) {
				return array(
					'label' => __( 'Kit', 're-style' ),
					'class' => 'badge-kit',
				);
			}
		}

		return $default_badge;
	}
}

if ( ! function_exists( 're_style_get_loop_product_description' ) ) {
	/**
	 * Returns a concise product description for the archive cards.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	function re_style_get_loop_product_description( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$description = $product->get_short_description();

		if ( '' === trim( wp_strip_all_tags( $description ) ) ) {
			$post = get_post( $product->get_id() );

			if ( $post instanceof WP_Post ) {
				$description = $post->post_excerpt;
			}
		}

		return wp_trim_words( wp_strip_all_tags( $description ), 22, '...' );
	}
}

if ( ! function_exists( 're_style_get_product_primary_category_name' ) ) {
	/**
	 * Returns the first product category label for loop cards.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	function re_style_get_product_primary_category_name( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$terms = get_the_terms( $product->get_id(), 'product_cat' );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return '';
		}

		return (string) $terms[0]->name;
	}
}

if ( ! function_exists( 're_style_get_product_loop_price_html' ) ) {
	/**
	 * Returns custom loop price markup aligned with the static card design.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	function re_style_get_product_loop_price_html( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$regular_price = $product->get_regular_price();
		$sale_price    = $product->get_sale_price();
		$current_price = $product->get_price();

		if ( '' !== $sale_price && '' !== $regular_price && (float) $sale_price < (float) $regular_price ) {
			return sprintf(
				'<span class="product-price-old">%1$s</span><span class="product-price">%2$s</span>',
				wp_kses_post( wc_price( wc_get_price_to_display( $product, array( 'price' => (float) $regular_price ) ) ) ),
				wp_kses_post( wc_price( wc_get_price_to_display( $product, array( 'price' => (float) $sale_price ) ) ) )
			);
		}

		if ( '' !== $current_price ) {
			return sprintf(
				'<span class="product-price">%s</span>',
				wp_kses_post( $product->get_price_html() )
			);
		}

		return '';
	}
}

if ( ! function_exists( 're_style_get_shop_result_count_text' ) ) {
	/**
	 * Returns the archive result count text.
	 *
	 * @global WP_Query $wp_query WordPress query.
	 * @return string
	 */
	function re_style_get_shop_result_count_text() {
		global $wp_query;

		$count = $wp_query instanceof WP_Query ? (int) $wp_query->found_posts : 0;

		if ( 1 === $count ) {
			return __( '1 prodotto', 're-style' );
		}

		return sprintf(
			/* translators: %d number of products found. */
			_n( '%d prodotto', '%d prodotti', $count, 're-style' ),
			$count
		);
	}
}

if ( ! function_exists( 're_style_body_classes_woocommerce' ) ) {
	/**
	 * Adds WooCommerce context classes used by the catalog styling.
	 *
	 * @param string[] $classes Existing classes.
	 * @return string[]
	 */
	function re_style_body_classes_woocommerce( $classes ) {
		if ( re_style_is_shop_archive() ) {
			$classes[] = 'shop-page';
			$classes[] = 're-style-shop-archive';
		}

		return $classes;
	}
}
add_filter( 'body_class', 're_style_body_classes_woocommerce' );

if ( ! function_exists( 're_style_modify_shop_query' ) ) {
	/**
	 * Applies catalog filters to the WooCommerce main product query.
	 *
	 * @param WP_Query $query Main query object.
	 * @return void
	 */
	function re_style_modify_shop_query( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! re_style_is_shop_archive() ) {
			return;
		}

		$tax_query = (array) $query->get( 'tax_query', array() );

		foreach ( re_style_get_shop_taxonomy_filters() as $filter ) {
			if ( empty( $filter['selected'] ) ) {
				continue;
			}

			$tax_query[] = array(
				'taxonomy' => $filter['taxonomy'],
				'field'    => 'slug',
				'terms'    => $filter['selected'],
			);
		}

		if ( count( $tax_query ) > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		$query->set( 'tax_query', $tax_query );

		$meta_query = (array) $query->get( 'meta_query', array() );

		if ( ! empty( $_GET['in_stock'] ) ) {
			$meta_query[] = array(
				'key'     => '_stock_status',
				'value'   => 'instock',
				'compare' => '=',
			);
		}

		$price_values = re_style_get_shop_price_filter_values();

		if ( '' !== $price_values['min'] || '' !== $price_values['max'] ) {
			$meta_query[] = array(
				'key'     => '_price',
				'value'   => array(
					'' !== $price_values['min'] ? (float) $price_values['min'] : 0,
					'' !== $price_values['max'] ? (float) $price_values['max'] : PHP_INT_MAX,
				),
				'compare' => 'BETWEEN',
				'type'    => 'DECIMAL(10,2)',
			);
		}

		$query->set( 'meta_query', $meta_query );

		if ( ! empty( $_GET['on_sale'] ) && function_exists( 'wc_get_product_ids_on_sale' ) ) {
			$on_sale_ids = wc_get_product_ids_on_sale();

			$query->set( 'post__in', ! empty( $on_sale_ids ) ? array_map( 'absint', $on_sale_ids ) : array( 0 ) );
		}

		if ( ! empty( $_GET['new_arrivals'] ) ) {
			$newness_days = (int) apply_filters( 're_style_shop_newness_days', 30 );

			$query->set(
				'date_query',
				array(
					array(
						'after'     => gmdate( 'Y-m-d', strtotime( '-' . absint( $newness_days ) . ' days' ) ),
						'inclusive' => true,
					),
				)
			);
		}

		$search = re_style_get_shop_search_term();

		if ( '' !== $search ) {
			$query->set( 's', $search );
		}
	}
}
add_action( 'pre_get_posts', 're_style_modify_shop_query' );

if ( ! function_exists( 're_style_adjust_woocommerce_loop_hooks' ) ) {
	/**
	 * Realigns WooCommerce loop hooks with the custom catalog card structure.
	 *
	 * @return void
	 */
	function re_style_adjust_woocommerce_loop_hooks() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		add_action( 'woocommerce_before_shop_loop_item', 're_style_render_loop_product_media', 10 );
		add_action( 'woocommerce_shop_loop_item_title', 're_style_render_loop_product_header', 10 );
		add_action( 'woocommerce_after_shop_loop_item_title', 're_style_render_loop_product_excerpt', 15 );
		add_action( 'woocommerce_after_shop_loop_item', 're_style_render_loop_product_footer', 10 );
	}
}
add_action( 'after_setup_theme', 're_style_adjust_woocommerce_loop_hooks', 20 );

if ( ! function_exists( 're_style_add_product_card_classes' ) ) {
	/**
	 * Adds custom loop classes for CSS parity.
	 *
	 * @param string[]    $classes Existing classes.
	 * @param WC_Product  $product Product object.
	 * @return string[]
	 */
	function re_style_add_product_card_classes( $classes, $product ) {
		if ( re_style_is_shop_archive() ) {
			$classes[] = 'product-card';
		}

		if ( $product instanceof WC_Product && re_style_is_product_new_arrival( $product ) ) {
			$classes[] = 'is-new-arrival';
		}

		return $classes;
	}
}
add_filter( 'woocommerce_post_class', 're_style_add_product_card_classes', 10, 2 );

if ( ! function_exists( 're_style_render_loop_product_media' ) ) {
	/**
	 * Outputs the custom catalog card media block.
	 *
	 * @return void
	 */
	function re_style_render_loop_product_media() {
		global $product;

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$badge = re_style_get_product_badge( $product );

		echo '<a class="product-media" href="' . esc_url( get_permalink( $product->get_id() ) ) . '">';

		if ( ! empty( $badge['label'] ) ) {
			echo '<span class="product-badge ' . esc_attr( $badge['class'] ) . '">' . esc_html( $badge['label'] ) . '</span>';
		}

		if ( has_post_thumbnail( $product->get_id() ) ) {
			echo get_the_post_thumbnail( $product->get_id(), 'woocommerce_thumbnail' );
		} else {
			echo wc_placeholder_img( 'woocommerce_thumbnail' );
		}

		echo '</a>';
		echo '<div class="product-info">';
	}
}

if ( ! function_exists( 're_style_render_loop_product_header' ) ) {
	/**
	 * Outputs the custom catalog card title block.
	 *
	 * @return void
	 */
	function re_style_render_loop_product_header() {
		global $product;

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$category_name = re_style_get_product_primary_category_name( $product );

		if ( '' !== $category_name ) {
			echo '<span class="product-category">' . esc_html( $category_name ) . '</span>';
		}

		echo '<h3><a href="' . esc_url( get_permalink( $product->get_id() ) ) . '">' . esc_html( get_the_title( $product->get_id() ) ) . '</a></h3>';
	}
}

if ( ! function_exists( 're_style_render_loop_product_excerpt' ) ) {
	/**
	 * Outputs the custom catalog card description block.
	 *
	 * @return void
	 */
	function re_style_render_loop_product_excerpt() {
		global $product;

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$description = re_style_get_loop_product_description( $product );

		if ( '' !== $description ) {
			echo '<p>' . esc_html( $description ) . '</p>';
		}
	}
}

if ( ! function_exists( 're_style_render_loop_product_footer' ) ) {
	/**
	 * Outputs the custom catalog card footer block.
	 *
	 * @return void
	 */
	function re_style_render_loop_product_footer() {
		global $product;

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		echo '<div class="product-bottom">';
		echo '<div class="product-price-group">' . wp_kses_post( re_style_get_product_loop_price_html( $product ) ) . '</div>';

		woocommerce_template_loop_add_to_cart(
			array(
				'class' => 'product-btn button alt',
			)
		);

		echo '</div>';
		echo '</div>';
	}
}

if ( ! function_exists( 're_style_filter_loop_add_to_cart_args' ) ) {
	/**
	 * Normalizes loop add-to-cart classes for the custom card footer.
	 *
	 * @param array      $args Loop args.
	 * @param WC_Product $product Product object.
	 * @return array
	 */
	function re_style_filter_loop_add_to_cart_args( $args, $product ) {
		if ( ! re_style_is_shop_archive() ) {
			return $args;
		}

		$args['class'] = 'product-btn button alt';

		if ( ! empty( $args['attributes']['aria-describedby'] ) ) {
			unset( $args['attributes']['aria-describedby'] );
		}

		if ( $product instanceof WC_Product && $product->is_purchasable() ) {
			$args['attributes']['aria-label'] = sprintf(
				/* translators: %s product title. */
				__( 'Aggiungi %s al carrello', 're-style' ),
				$product->get_name()
			);
		}

		return $args;
	}
}
add_filter( 'woocommerce_loop_add_to_cart_args', 're_style_filter_loop_add_to_cart_args', 10, 2 );

if ( ! function_exists( 're_style_filter_loop_add_to_cart_link' ) ) {
	/**
	 * Replaces generic button labels with the catalog CTA copy from the mockup.
	 *
	 * @param string     $html Add to cart HTML.
	 * @param WC_Product $product Product object.
	 * @param array      $args Loop args.
	 * @return string
	 */
	function re_style_filter_loop_add_to_cart_link( $html, $product, $args ) {
		if ( ! re_style_is_shop_archive() || ! $product instanceof WC_Product ) {
			return $html;
		}

		$label = $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock()
			? __( 'Aggiungi', 're-style' )
			: __( 'Scopri', 're-style' );

		return preg_replace( '/>(.*?)</', '>' . esc_html( $label ) . '<', $html, 1 );
	}
}
add_filter( 'woocommerce_loop_add_to_cart_link', 're_style_filter_loop_add_to_cart_link', 10, 3 );

if ( ! function_exists( 're_style_filter_pagination_args' ) ) {
	/**
	 * Adjusts pagination labels for the custom archive.
	 *
	 * @param array $args Pagination args.
	 * @return array
	 */
	function re_style_filter_pagination_args( $args ) {
		$args['prev_text'] = __( 'Pagina precedente', 're-style' );
		$args['next_text'] = __( 'Pagina successiva', 're-style' );

		return $args;
	}
}
add_filter( 'woocommerce_pagination_args', 're_style_filter_pagination_args' );
