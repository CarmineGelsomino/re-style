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

if ( ! function_exists( 're_style_is_single_product' ) ) {
	/**
	 * Returns whether the current request is a single product page.
	 *
	 * @return bool
	 */
	function re_style_is_single_product() {
		return function_exists( 'is_product' ) && is_product();
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
			$label           = $taxonomy;

			if ( 'product_cat' === $taxonomy && $taxonomy_object && ! empty( $taxonomy_object->labels->name ) ) {
				$label = $taxonomy_object->labels->name;
			} elseif ( $taxonomy_object && ! empty( $taxonomy_object->labels->singular_name ) ) {
				$label = $taxonomy_object->labels->singular_name;
			}

			$filters[] = array(
				'taxonomy' => $taxonomy,
				'label'    => $label,
				'terms'    => $terms,
				'selected' => re_style_get_shop_filter_values( $taxonomy ),
			);
		}

		return $filters;
	}
}

if ( ! function_exists( 're_style_get_shop_category_tabs' ) ) {
	/**
	 * Returns category tabs for the archive toolbar.
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

		if ( empty( $terms ) ) {
			$terms = get_terms(
				array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
				)
			);
		}

		return is_wp_error( $terms ) ? array() : $terms;
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
		$min_price = isset( $_GET['min_price'] ) && function_exists( 'wc_format_decimal' ) ? wc_format_decimal( wp_unslash( $_GET['min_price'] ) ) : '';
		$max_price = isset( $_GET['max_price'] ) && function_exists( 'wc_format_decimal' ) ? wc_format_decimal( wp_unslash( $_GET['max_price'] ) ) : '';

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
		$catalog_orderby = apply_filters(
			'woocommerce_default_catalog_orderby_options',
			array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by latest', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		if ( '' !== re_style_get_shop_search_term() ) {
			$catalog_orderby['relevance'] = __( 'Sort by relevance', 'woocommerce' );
		}

		$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', $catalog_orderby );

		if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
			unset( $catalog_orderby['rating'] );
		}

		return is_array( $catalog_orderby ) ? $catalog_orderby : array();
	}
}

if ( ! function_exists( 're_style_get_current_shop_orderby' ) ) {
	/**
	 * Returns the current orderby value.
	 *
	 * @return string
	 */
	function re_style_get_current_shop_orderby() {
		$orderby = isset( $_GET['orderby'] ) && function_exists( 'wc_clean' ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : '';

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
						esc_attr( sanitize_text_field( (string) $item ) )
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
	 * Returns whether a product belongs to the latest five items of any assigned
	 * product category.
	 *
	 * @param WC_Product $product Product object.
	 * @return bool
	 */
	function re_style_is_product_new_arrival( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return false;
		}

		$term_ids = wc_get_product_term_ids( $product->get_id(), 'product_cat' );

		if ( empty( $term_ids ) ) {
			return false;
		}

		static $latest_ids_by_term = array();

		foreach ( $term_ids as $term_id ) {
			$term_id = (int) $term_id;

			if ( ! isset( $latest_ids_by_term[ $term_id ] ) ) {
				$latest_ids_by_term[ $term_id ] = get_posts(
					array(
						'post_type'              => 'product',
						'post_status'            => 'publish',
						'fields'                 => 'ids',
						'posts_per_page'         => 5,
						'orderby'                => 'date',
						'order'                  => 'DESC',
						'ignore_sticky_posts'    => true,
						'no_found_rows'          => true,
						'update_post_meta_cache' => false,
						'update_post_term_cache' => false,
						'tax_query'              => array(
							array(
								'taxonomy'         => 'product_cat',
								'field'            => 'term_id',
								'terms'            => array( $term_id ),
								'include_children' => true,
							),
						),
					)
				);
			}

			if ( in_array( $product->get_id(), $latest_ids_by_term[ $term_id ], true ) ) {
				return true;
			}
		}

		return false;
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

		if ( re_style_is_product_new_arrival( $product ) ) {
			return array(
				'label' => __( 'Novita', 're-style' ),
				'class' => 'badge-new',
			);
		}

		if ( $product->is_on_sale() ) {
			return array(
				'label' => __( 'Promo', 're-style' ),
				'class' => 'badge-promo',
			);
		}

		foreach ( array( 'product_cat', 'product_tag' ) as $taxonomy ) {
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
	 * Returns a concise product description for archive cards.
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
				$description = '' !== trim( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;
			}
		}

		return wp_trim_words( wp_strip_all_tags( $description ), 16, '...' );
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

if ( ! function_exists( 're_style_get_loop_add_to_cart_html' ) ) {
	/**
	 * Returns loop add-to-cart HTML.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	function re_style_get_loop_add_to_cart_html( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		ob_start();

		woocommerce_template_loop_add_to_cart(
			array(
				'class' => 'product-btn button alt',
			)
		);

		return (string) ob_get_clean();
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

		if ( re_style_is_single_product() ) {
			$classes[] = 're-style-single-product';
		}

		return $classes;
	}
}
add_filter( 'body_class', 're_style_body_classes_woocommerce' );

if ( ! function_exists( 're_style_customize_single_product_layout' ) ) {
	/**
	 * Reorganizes the single product layout while keeping WooCommerce core
	 * templates in place.
	 *
	 * @return void
	 */
	function re_style_customize_single_product_layout() {
		if ( ! re_style_is_single_product() ) {
			return;
		}

		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

		add_action( 'woocommerce_single_product_summary', 're_style_output_single_product_description', 20 );
		add_action( 'woocommerce_after_single_product_summary', 're_style_output_single_product_reviews_section', 30 );
	}
}
add_action( 'wp', 're_style_customize_single_product_layout' );

if ( ! function_exists( 're_style_get_single_product_description_text' ) ) {
	/**
	 * Returns the descriptive copy used in the single product summary.
	 *
	 * @param WC_Product $product Product object.
	 * @return string
	 */
	function re_style_get_single_product_description_text( $product ) {
		if ( ! $product instanceof WC_Product ) {
			return '';
		}

		$description = trim( wp_strip_all_tags( $product->get_short_description() ) );

		if ( '' !== $description ) {
			return $description;
		}

		$post = get_post( $product->get_id() );

		if ( ! $post instanceof WP_Post ) {
			return '';
		}

		$fallback = '' !== trim( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;

		return wp_trim_words( wp_strip_all_tags( $fallback ), 48, '...' );
	}
}

if ( ! function_exists( 're_style_output_single_product_description' ) ) {
	/**
	 * Outputs the product description block inside the summary column.
	 *
	 * @return void
	 */
	function re_style_output_single_product_description() {
		global $product;

		$description = re_style_get_single_product_description_text( $product );

		if ( '' === $description ) {
			return;
		}

		?>
		<div class="re-style-single-description">
			<h2 class="re-style-single-description__title"><?php esc_html_e( 'Descrizione', 're-style' ); ?></h2>
			<div class="re-style-single-description__content">
				<p><?php echo esc_html( $description ); ?></p>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 're_style_output_single_product_reviews_section' ) ) {
	/**
	 * Outputs the reviews block below related products.
	 *
	 * @return void
	 */
	function re_style_output_single_product_reviews_section() {
		if ( ! comments_open() && ! get_comments_number() ) {
			return;
		}

		echo '<section class="re-style-single-reviews-section" aria-label="' . esc_attr__( 'Recensioni prodotto', 're-style' ) . '">';
		comments_template();
		echo '</section>';
	}
}

if ( ! function_exists( 're_style_output_single_quantity_decrease_button' ) ) {
	/**
	 * Outputs the quantity decrease button for single product forms.
	 *
	 * @return void
	 */
	function re_style_output_single_quantity_decrease_button() {
		if ( ! re_style_is_single_product() ) {
			return;
		}

		echo '<button type="button" class="re-style-quantity-button re-style-quantity-button--minus" aria-label="' . esc_attr__( 'Diminuisci quantita', 're-style' ) . '">-</button>';
	}
}
add_action( 'woocommerce_before_quantity_input_field', 're_style_output_single_quantity_decrease_button' );

if ( ! function_exists( 're_style_output_single_quantity_increase_button' ) ) {
	/**
	 * Outputs the quantity increase button for single product forms.
	 *
	 * @return void
	 */
	function re_style_output_single_quantity_increase_button() {
		if ( ! re_style_is_single_product() ) {
			return;
		}

		echo '<button type="button" class="re-style-quantity-button re-style-quantity-button--plus" aria-label="' . esc_attr__( 'Aumenta quantita', 're-style' ) . '">+</button>';
	}
}
add_action( 'woocommerce_after_quantity_input_field', 're_style_output_single_quantity_increase_button' );

if ( ! function_exists( 're_style_related_products_args' ) ) {
	/**
	 * Normalizes related products output for the custom single-product layout.
	 *
	 * @param array $args Related product arguments.
	 * @return array
	 */
	function re_style_related_products_args( $args ) {
		if ( ! re_style_is_single_product() ) {
			return $args;
		}

		$args['posts_per_page'] = 4;
		$args['columns']        = 4;

		return $args;
	}
}
add_filter( 'woocommerce_output_related_products_args', 're_style_related_products_args' );

if ( ! function_exists( 're_style_related_products_heading' ) ) {
	/**
	 * Returns the related products heading copy.
	 *
	 * @param string $heading Existing heading.
	 * @return string
	 */
	function re_style_related_products_heading( $heading ) {
		if ( re_style_is_single_product() ) {
			return __( 'Prodotti correlati', 're-style' );
		}

		return $heading;
	}
}
add_filter( 'woocommerce_product_related_products_heading', 're_style_related_products_heading' );

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
			$query->set(
				'orderby',
				array(
					'date' => 'DESC',
					'ID'   => 'DESC',
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

		return (string) preg_replace( '/>(.*?)</', '>' . esc_html( $label ) . '<', $html, 1 );
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
