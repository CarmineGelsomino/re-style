<?php
/**
 * Product archive template.
 *
 * @package ReStyle
 */

defined( 'ABSPATH' ) || exit;

get_header();

$shop_url          = re_style_get_shop_page_url();
$order_by_options  = re_style_get_shop_orderby_options();
$current_orderby   = re_style_get_current_shop_orderby();
$active_term_slug  = re_style_get_shop_active_term_slug();
$taxonomy_filters  = re_style_get_shop_taxonomy_filters();
$filter_exclusions = array_map(
	static function ( $filter ) {
		return 'filter_' . $filter['taxonomy'];
	},
	$taxonomy_filters
);
$availability_sets = re_style_get_shop_availability_filters();
$price_values      = re_style_get_shop_price_filter_values();
?>
<main id="primary" class="site-main shop-page-main">
	<?php woocommerce_output_all_notices(); ?>

	<section class="shop-toolbar-section" aria-label="<?php esc_attr_e( 'Strumenti shop', 're-style' ); ?>">
		<div class="shop-toolbar-top">
			<form class="shop-search" action="<?php echo esc_url( $shop_url ); ?>" method="get" role="search">
				<label for="shop-search-input" class="screen-reader-text"><?php esc_html_e( 'Cerca prodotti', 're-style' ); ?></label>
				<span class="shop-search-icon" aria-hidden="true">
					<svg viewBox="0 0 1024 1024" focusable="false">
						<use href="#icon-search"></use>
					</svg>
				</span>
				<input
					type="search"
					id="shop-search-input"
					name="shop_search"
					value="<?php echo esc_attr( re_style_get_shop_search_term() ); ?>"
					placeholder="<?php esc_attr_e( 'Cerca prodotti, categorie o brand', 're-style' ); ?>">
				<?php re_style_render_shop_hidden_fields( array( 'shop_search' ) ); ?>
			</form>

			<div class="shop-toolbar-controls">
				<?php if ( ! empty( $order_by_options ) ) : ?>
					<form class="shop-toolbar-actions" action="<?php echo esc_url( $shop_url ); ?>" method="get">
						<label for="shop-sort" class="screen-reader-text"><?php esc_html_e( 'Ordina prodotti', 're-style' ); ?></label>
						<select id="shop-sort" name="orderby" onchange="this.form.submit()">
							<?php foreach ( $order_by_options as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $current_orderby, $value ); ?>>
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<?php re_style_render_shop_hidden_fields( array( 'orderby' ) ); ?>
					</form>
				<?php endif; ?>

				<button
					type="button"
					class="shop-filters-toggle"
					aria-expanded="false"
					aria-controls="shop-filters-panel">
					<?php esc_html_e( 'Filtri', 're-style' ); ?>
				</button>
			</div>
		</div>

		<div class="shop-categories-tabs" aria-label="<?php esc_attr_e( 'Categorie shop', 're-style' ); ?>">
			<a href="<?php echo esc_url( $shop_url ); ?>" class="shop-tab <?php echo '' === $active_term_slug ? 'is-active' : ''; ?>">
				<?php esc_html_e( 'Tutti', 're-style' ); ?>
			</a>

			<?php foreach ( re_style_get_shop_category_tabs() as $term ) : ?>
				<a
					href="<?php echo esc_url( get_term_link( $term ) ); ?>"
					class="shop-tab <?php echo $active_term_slug === $term->slug ? 'is-active' : ''; ?>">
					<?php echo esc_html( $term->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="shop-layout-page" aria-label="<?php esc_attr_e( 'Catalogo prodotti', 're-style' ); ?>">
		<button
			type="button"
			class="shop-filters-overlay"
			aria-hidden="true"
			tabindex="-1">
		</button>

		<aside
			id="shop-filters-panel"
			class="shop-sidebar"
			aria-label="<?php esc_attr_e( 'Filtri prodotti', 're-style' ); ?>"
			aria-hidden="false">
			<form class="shop-filters-card" action="<?php echo esc_url( $shop_url ); ?>" method="get">
				<div class="shop-filters-card__header">
					<h2><?php esc_html_e( 'Filtri', 're-style' ); ?></h2>
					<button
						type="button"
						class="shop-filters-close"
						aria-label="<?php esc_attr_e( 'Chiudi filtri', 're-style' ); ?>">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<?php foreach ( $taxonomy_filters as $filter ) : ?>
					<div class="shop-filter-block">
						<h3><?php echo esc_html( $filter['label'] ); ?></h3>

						<?php foreach ( $filter['terms'] as $term ) : ?>
							<label>
								<input
									type="checkbox"
									name="<?php echo esc_attr( 'filter_' . $filter['taxonomy'] ); ?>[]"
									value="<?php echo esc_attr( $term->slug ); ?>"
									<?php checked( in_array( $term->slug, $filter['selected'], true ) ); ?>>
								<span><?php echo esc_html( $term->name ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>

				<div class="shop-filter-block">
					<h3><?php esc_html_e( 'Disponibilita', 're-style' ); ?></h3>

					<?php foreach ( $availability_sets as $availability ) : ?>
						<label>
							<input
								type="checkbox"
								name="<?php echo esc_attr( $availability['key'] ); ?>"
								value="1"
								<?php checked( $availability['selected'] ); ?>>
							<span><?php echo esc_html( $availability['label'] ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>

				<div class="shop-filter-block">
					<h3><?php esc_html_e( 'Fascia prezzo', 're-style' ); ?></h3>
					<div class="shop-price-range">
						<label for="shop-min-price" class="screen-reader-text"><?php esc_html_e( 'Prezzo minimo', 're-style' ); ?></label>
						<input
							type="number"
							id="shop-min-price"
							name="min_price"
							min="0"
							step="0.01"
							inputmode="decimal"
							value="<?php echo esc_attr( $price_values['min'] ); ?>"
							placeholder="<?php esc_attr_e( 'Min', 're-style' ); ?>">
						<label for="shop-max-price" class="screen-reader-text"><?php esc_html_e( 'Prezzo massimo', 're-style' ); ?></label>
						<input
							type="number"
							id="shop-max-price"
							name="max_price"
							min="0"
							step="0.01"
							inputmode="decimal"
							value="<?php echo esc_attr( $price_values['max'] ); ?>"
							placeholder="<?php esc_attr_e( 'Max', 're-style' ); ?>">
					</div>
				</div>

				<?php
				re_style_render_shop_hidden_fields(
					array_merge(
						$filter_exclusions,
						array(
							'min_price',
							'max_price',
							'in_stock',
							'on_sale',
							'new_arrivals',
							'product-page',
							'paged',
							'orderby',
							'shop_search',
						)
					),
					false
				);
				?>

				<?php if ( '' !== re_style_get_shop_search_term() ) : ?>
					<input type="hidden" name="shop_search" value="<?php echo esc_attr( re_style_get_shop_search_term() ); ?>">
				<?php endif; ?>

				<?php if ( '' !== $current_orderby ) : ?>
					<input type="hidden" name="orderby" value="<?php echo esc_attr( $current_orderby ); ?>">
				<?php endif; ?>

				<div class="shop-filter-actions">
					<button type="submit" class="shop-filter-btn-primary"><?php esc_html_e( 'Applica filtri', 're-style' ); ?></button>
					<a class="shop-filter-btn-secondary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Reset', 're-style' ); ?></a>
				</div>
			</form>
		</aside>

		<div class="shop-results">
			<div class="shop-results-head">
				<p><?php echo esc_html( re_style_get_shop_result_count_text() ); ?></p>
			</div>

			<?php if ( woocommerce_product_loop() ) : ?>
				<ul class="products products-grid">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
				</ul>

				<?php woocommerce_pagination(); ?>
			<?php else : ?>
				<div class="woocommerce-info woocommerce-info--empty">
					<?php esc_html_e( 'Nessun prodotto trovato con i filtri selezionati.', 're-style' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/woocommerce/archive-benefits' ); ?>
	<?php get_template_part( 'template-parts/woocommerce/archive-cta' ); ?>
</main>
<?php
get_footer();
