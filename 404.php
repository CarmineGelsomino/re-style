<?php
/**
 * 404 template.
 *
 * @package ReStyle
 */

get_header();

$error_404 = function_exists( 're_style_get_404_data' ) ? re_style_get_404_data() : array(
	'label'           => __( 'Errore 404', 're-style' ),
	'title'           => __( 'Pagina non trovata', 're-style' ),
	'description'     => __( 'La pagina che stai cercando non e disponibile.', 're-style' ),
	'primary_label'   => __( 'Torna alla home', 're-style' ),
	'primary_url'     => home_url( '/' ),
	'secondary_label' => __( 'Vai allo shop', 're-style' ),
	'secondary_url'   => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
);
?>
<main id="primary" class="site-main site-main--404">
	<section class="error-404 not-found re-style-404-shell">
		<div class="re-style-404-copy">
			<span class="re-style-page-label"><?php echo esc_html( $error_404['label'] ); ?></span>
			<p class="re-style-404-code" aria-hidden="true">404</p>

			<header class="page-header re-style-404-header">
				<h1 class="page-title"><?php echo esc_html( $error_404['title'] ); ?></h1>
			</header>

			<div class="page-content re-style-404-content">
				<p><?php echo esc_html( $error_404['description'] ); ?></p>

				<div class="re-style-page-actions">
					<?php if ( '' !== $error_404['primary_label'] && '' !== $error_404['primary_url'] ) : ?>
						<a class="re-style-page-btn re-style-page-btn--primary" href="<?php echo esc_url( $error_404['primary_url'] ); ?>">
							<?php echo esc_html( $error_404['primary_label'] ); ?>
						</a>
					<?php endif; ?>

					<?php if ( '' !== $error_404['secondary_label'] && '' !== $error_404['secondary_url'] ) : ?>
						<a class="re-style-page-btn re-style-page-btn--secondary" href="<?php echo esc_url( $error_404['secondary_url'] ); ?>">
							<?php echo esc_html( $error_404['secondary_label'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
