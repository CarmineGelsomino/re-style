<?php
/**
 * Dedicated page template for shipping information.
 *
 * @package ReStyle
 */

get_header();

$shipping_data = re_style_get_shipping_page_data();
$support_email = sanitize_email( $shipping_data['support_email'] );
?>
<main id="primary" class="site-main site-main--info-page" tabindex="-1">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 're-style-info-page re-style-shipping-page' ); ?>>
			<section class="re-style-info-hero" aria-labelledby="spedizioni-title">
				<span class="re-style-page-label"><?php echo esc_html( $shipping_data['label'] ); ?></span>
				<h1 id="spedizioni-title" class="entry-title"><?php echo esc_html( $shipping_data['title'] ); ?></h1>
				<p><?php echo esc_html( $shipping_data['description'] ); ?></p>

				<nav class="re-style-info-anchor-nav" aria-label="<?php esc_attr_e( 'Indice della pagina spedizioni', 're-style' ); ?>">
					<a class="re-style-info-anchor-link" href="#costi-spedizione">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '01', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php echo esc_html( $shipping_data['costs_title'] ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Costi, soglia gratuita e tempi di consegna previsti.', 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#processo-spedizione">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '02', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php echo esc_html( $shipping_data['process_title'] ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( "Cosa succede dall'ordine alla consegna del pacco.", 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#faq-spedizioni">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '03', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php echo esc_html( $shipping_data['faq_title'] ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Risposte rapide alle domande piu frequenti sulla spedizione.', 're-style' ); ?></span>
					</a>
				</nav>
			</section>

			<section id="costi-spedizione" class="re-style-info-section" aria-labelledby="costi-spedizione-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Spedizioni', 're-style' ); ?></span>
				<h2 id="costi-spedizione-title"><?php echo esc_html( $shipping_data['costs_title'] ); ?></h2>

				<div class="re-style-info-card-grid re-style-info-card-grid--single">
					<div class="re-style-info-card">
						<ul class="re-style-info-summary-list">
							<?php foreach ( $shipping_data['costs_items'] as $item ) : ?>
								<li>
									<span><?php echo esc_html( $item['label'] ); ?></span>
									<strong><?php echo esc_html( $item['value'] ); ?></strong>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div class="re-style-info-note">
					<p><?php echo esc_html( $shipping_data['costs_note'] ); ?></p>
				</div>
			</section>

			<section id="processo-spedizione" class="re-style-info-section" aria-labelledby="processo-spedizione-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Consegna', 're-style' ); ?></span>
				<h2 id="processo-spedizione-title"><?php echo esc_html( $shipping_data['process_title'] ); ?></h2>

				<div class="re-style-info-card-grid">
					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Come funziona', 're-style' ); ?></h3>
						<ol class="re-style-info-steps">
							<?php foreach ( $shipping_data['process_steps'] as $step ) : ?>
								<li><?php echo esc_html( $step['text'] ); ?></li>
							<?php endforeach; ?>
						</ol>
					</div>

					<div class="re-style-info-card">
						<h3><?php echo esc_html( $shipping_data['delivery_title'] ); ?></h3>
						<p><?php echo esc_html( $shipping_data['delivery_description'] ); ?></p>
					</div>
				</div>
			</section>

			<section id="faq-spedizioni" class="re-style-info-section" aria-labelledby="faq-spedizioni-title">
				<span class="re-style-page-label"><?php esc_html_e( 'FAQ', 're-style' ); ?></span>
				<h2 id="faq-spedizioni-title"><?php echo esc_html( $shipping_data['faq_title'] ); ?></h2>

				<div class="re-style-info-faq-grid">
					<?php foreach ( $shipping_data['faq_items'] as $faq_item ) : ?>
						<div class="re-style-info-card re-style-info-faq-card">
							<h3><?php echo esc_html( $faq_item['question'] ); ?></h3>
							<p><?php echo esc_html( $faq_item['answer'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</section>

			<section class="re-style-info-support" aria-labelledby="supporto-spedizioni-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Assistenza Clienti', 're-style' ); ?></span>
				<h2 id="supporto-spedizioni-title"><?php echo esc_html( $shipping_data['support_title'] ); ?></h2>
				<div class="re-style-info-support-copy">
					<p>
						<?php echo esc_html( $shipping_data['support_description'] ); ?>
						<?php if ( $support_email ) : ?>
							<a class="re-style-info-support-link" href="<?php echo esc_url( 'mailto:' . $support_email ); ?>"><?php echo esc_html( $support_email ); ?></a>.
						<?php endif; ?>
					</p>
				</div>
				<div class="re-style-page-actions">
					<a class="re-style-page-btn re-style-page-btn--primary" href="<?php echo esc_url( $shipping_data['primary_url'] ); ?>"><?php echo esc_html( $shipping_data['primary_label'] ); ?></a>
					<a class="re-style-page-btn re-style-page-btn--secondary" href="<?php echo esc_url( $shipping_data['secondary_url'] ); ?>"><?php echo esc_html( $shipping_data['secondary_label'] ); ?></a>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
