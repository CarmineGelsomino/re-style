<?php
/**
 * Dedicated page template for customer support information.
 *
 * @package ReStyle
 */

get_header();

$support_data   = re_style_get_support_page_data();
$support_email  = sanitize_email( $support_data['support_email'] );
$support_phone  = isset( $support_data['support_phone'] ) ? trim( (string) $support_data['support_phone'] ) : '';
$support_digits = preg_replace( '/\D+/', '', $support_phone );
$whatsapp_url   = $support_digits ? 'https://wa.me/' . $support_digits : '';
?>
<main id="primary" class="site-main site-main--info-page" tabindex="-1">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 're-style-info-page re-style-support-page' ); ?>>
			<section class="re-style-info-hero" aria-labelledby="supporto-clienti-title">
				<span class="re-style-page-label"><?php echo esc_html( $support_data['label'] ); ?></span>
				<h1 id="supporto-clienti-title" class="entry-title"><?php echo esc_html( $support_data['title'] ); ?></h1>
				<p><?php echo esc_html( $support_data['description'] ); ?></p>

				<nav class="re-style-info-anchor-nav" aria-label="<?php esc_attr_e( 'Indice della pagina supporto clienti', 're-style' ); ?>">
					<a class="re-style-info-anchor-link" href="#contatti-diretti">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '01', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php echo esc_html( $support_data['channels_title'] ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Email, cellulare e accesso rapido a WhatsApp per ricevere assistenza.', 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#come-ti-aiutiamo">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '02', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php echo esc_html( $support_data['response_title'] ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'I principali temi su cui il supporto puo accompagnarti prima e dopo l acquisto.', 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#contatto-rapido">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '03', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php echo esc_html( $support_data['support_title'] ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Un riepilogo essenziale per contattarci in modo semplice e veloce.', 're-style' ); ?></span>
					</a>
				</nav>
			</section>

			<section id="contatti-diretti" class="re-style-info-section" aria-labelledby="contatti-diretti-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Contatti', 're-style' ); ?></span>
				<h2 id="contatti-diretti-title"><?php echo esc_html( $support_data['channels_title'] ); ?></h2>
				<p class="re-style-info-section-intro"><?php echo esc_html( $support_data['channels_intro'] ); ?></p>

				<div class="re-style-info-card-grid re-style-support-channels-grid">
					<?php if ( $support_email ) : ?>
						<div class="re-style-info-card re-style-support-channel-card">
							<span class="re-style-support-channel-card__label"><?php esc_html_e( 'Email supporto', 're-style' ); ?></span>
							<h3><?php esc_html_e( 'Scrivici quando vuoi', 're-style' ); ?></h3>
							<p><?php esc_html_e( 'Ideale per richieste dettagliate, aggiornamenti ordine e invio di eventuali immagini o informazioni utili.', 're-style' ); ?></p>
							<a class="re-style-info-support-link" href="<?php echo esc_url( 'mailto:' . $support_email ); ?>"><?php echo esc_html( $support_email ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $support_phone ) : ?>
						<div class="re-style-info-card re-style-support-channel-card">
							<span class="re-style-support-channel-card__label"><?php esc_html_e( 'Cellulare', 're-style' ); ?></span>
							<h3><?php esc_html_e( 'Parla direttamente con noi', 're-style' ); ?></h3>
							<p><?php esc_html_e( 'Usiamo il numero già configurato nei contatti del tema, cosi la comunicazione resta coerente in tutto il sito.', 're-style' ); ?></p>
							<a class="re-style-info-support-link" href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $support_phone ) ); ?>"><?php echo esc_html( $support_phone ); ?></a>
						</div>
					<?php endif; ?>

					<?php if ( $whatsapp_url ) : ?>
						<div class="re-style-info-card re-style-support-channel-card">
							<span class="re-style-support-channel-card__label"><?php esc_html_e( 'WhatsApp', 're-style' ); ?></span>
							<h3><?php esc_html_e( 'Assistenza rapida in chat', 're-style' ); ?></h3>
							<p><?php esc_html_e( 'Perfetto per dubbi veloci su ordini, spedizioni o disponibilita, mantenendo un contatto immediato dal tuo smartphone.', 're-style' ); ?></p>
							<a class="re-style-info-support-link" href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Apri la chat WhatsApp', 're-style' ); ?></a>
						</div>
					<?php endif; ?>
				</div>
			</section>

			<section id="come-ti-aiutiamo" class="re-style-info-section" aria-labelledby="come-ti-aiutiamo-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Assistenza', 're-style' ); ?></span>
				<h2 id="come-ti-aiutiamo-title"><?php echo esc_html( $support_data['response_title'] ); ?></h2>

				<div class="re-style-info-card-grid">
					<?php foreach ( $support_data['response_items'] as $item ) : ?>
						<div class="re-style-info-card">
							<h3><?php echo esc_html( $item['title'] ); ?></h3>
							<p><?php echo esc_html( $item['description'] ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="re-style-info-card re-style-support-checklist-card">
					<h3><?php echo esc_html( $support_data['checklist_title'] ); ?></h3>
					<ul class="re-style-info-list">
						<?php foreach ( $support_data['checklist_items'] as $item ) : ?>
							<li><?php echo esc_html( $item['text'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</section>

			<section id="contatto-rapido" class="re-style-info-support" aria-labelledby="contatto-rapido-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Supporto Re Style', 're-style' ); ?></span>
				<h2 id="contatto-rapido-title"><?php echo esc_html( $support_data['support_title'] ); ?></h2>
				<div class="re-style-info-support-copy">
					<p>
						<?php echo esc_html( $support_data['support_description'] ); ?>
						<?php if ( $support_email ) : ?>
							<a class="re-style-info-support-link" href="<?php echo esc_url( 'mailto:' . $support_email ); ?>"><?php echo esc_html( $support_email ); ?></a>
						<?php endif; ?>
						<?php if ( $support_phone ) : ?>
							<?php esc_html_e( ' oppure chiamaci al ', 're-style' ); ?>
							<a class="re-style-info-support-link" href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $support_phone ) ); ?>"><?php echo esc_html( $support_phone ); ?></a>.
						<?php endif; ?>
					</p>
				</div>
				<div class="re-style-page-actions">
					<a class="re-style-page-btn re-style-page-btn--primary" href="<?php echo esc_url( $support_data['primary_url'] ); ?>"><?php echo esc_html( $support_data['primary_label'] ); ?></a>
					<a class="re-style-page-btn re-style-page-btn--secondary" href="<?php echo esc_url( $support_data['secondary_url'] ); ?>"><?php echo esc_html( $support_data['secondary_label'] ); ?></a>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
