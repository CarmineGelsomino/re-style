<?php
/**
 * Dedicated page template for payment methods information.
 *
 * @package ReStyle
 */

get_header();

$shop_url        = function_exists( 're_style_get_shop_page_url' ) ? re_style_get_shop_page_url() : home_url( '/shop/' );
$payment_methods = function_exists( 're_style_get_active_payment_methods' ) ? re_style_get_active_payment_methods() : array();
$method_count    = count( $payment_methods );
$checkout_url    = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout/' );
$allowed_icons   = array(
	'img'  => array(
		'src'    => true,
		'alt'    => true,
		'class'  => true,
		'style'  => true,
		'width'  => true,
		'height' => true,
	),
	'span' => array(
		'class' => true,
		'style' => true,
	),
);
?>
<main id="primary" class="site-main site-main--info-page" tabindex="-1">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 're-style-info-page re-style-payments-page' ); ?>>
			<section class="re-style-info-hero" aria-labelledby="pagamenti-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Pagamenti', 're-style' ); ?></span>
				<h1 id="pagamenti-title" class="entry-title"><?php the_title(); ?></h1>
				<p><?php esc_html_e( "In questa pagina trovi i metodi di pagamento attualmente attivi sullo shop Re Style, insieme a indicazioni utili sulla conferma dell'ordine e sull'assistenza in caso di anomalie al checkout.", 're-style' ); ?></p>

				<nav class="re-style-info-anchor-nav" aria-label="<?php esc_attr_e( 'Indice della pagina metodi di pagamento', 're-style' ); ?>">
					<a class="re-style-info-anchor-link" href="#metodi-attivi">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '01', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php esc_html_e( 'Metodi attivi', 're-style' ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Elenco dei metodi di pagamento attualmente attivi.', 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#conferma-ordine">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '02', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php esc_html_e( 'Conferma ordine', 're-style' ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( "Come viene autorizzato il pagamento e quando l'ordine risulta confermato.", 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#assistenza-pagamenti">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '03', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php esc_html_e( 'Assistenza', 're-style' ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( "Cosa fare se un addebito non va a buon fine o il checkout restituisce errori.", 're-style' ); ?></span>
					</a>
				</nav>
			</section>

			<section id="metodi-attivi" class="re-style-info-section" aria-labelledby="metodi-attivi-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Gateway WooCommerce', 're-style' ); ?></span>
				<h2 id="metodi-attivi-title"><?php esc_html_e( 'Metodi di pagamento attivi', 're-style' ); ?></h2>

				<div class="re-style-info-card-grid re-style-info-card-grid--single">
					<div class="re-style-info-card">
						<ul class="re-style-info-summary-list">
							<li>
								<span><?php esc_html_e( 'Gateway attivi nello shop', 're-style' ); ?></span>
								<strong><?php echo esc_html( number_format_i18n( $method_count ) ); ?></strong>
							</li>
						</ul>
					</div>
				</div>

				<?php if ( ! empty( $payment_methods ) ) : ?>
					<div class="re-style-payment-methods-grid">
						<?php foreach ( $payment_methods as $payment_method ) : ?>
							<div class="re-style-info-card re-style-payment-card">
								<div class="re-style-payment-card__head">
									<div class="re-style-payment-card__title-group">
										<h3><?php echo esc_html( $payment_method['title'] ); ?></h3>
										<span class="re-style-payment-card__badge"><?php esc_html_e( 'Attivo', 're-style' ); ?></span>
									</div>

									<?php if ( '' !== $payment_method['icon_html'] ) : ?>
										<div class="re-style-payment-card__icon" aria-hidden="true">
											<?php echo wp_kses( $payment_method['icon_html'], $allowed_icons ); ?>
										</div>
									<?php endif; ?>
								</div>

								<p>
									<?php echo esc_html( $payment_method['description'] ); ?>
								</p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<div class="re-style-info-note">
						<p><?php esc_html_e( 'Al momento WooCommerce non restituisce gateway di pagamento attivi. Se hai appena modificato le impostazioni, verifica che almeno un metodo sia abilitato e pubblicato.', 're-style' ); ?></p>
					</div>
				<?php endif; ?>
			</section>

			<section id="conferma-ordine" class="re-style-info-section" aria-labelledby="conferma-ordine-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Checkout', 're-style' ); ?></span>
				<h2 id="conferma-ordine-title"><?php esc_html_e( 'Conferma e sicurezza del pagamento', 're-style' ); ?></h2>

				<div class="re-style-info-card-grid">
					<div class="re-style-info-card">
						<h3><?php esc_html_e( "Quando l'ordine viene confermato", 're-style' ); ?></h3>
						<ul class="re-style-info-list">
							<li><?php esc_html_e( "L'ordine viene registrato nel flusso WooCommerce durante il checkout.", 're-style' ); ?></li>
							<li><?php esc_html_e( "La conferma finale dipende dall'autorizzazione del metodo di pagamento scelto.", 're-style' ); ?></li>
							<li><?php esc_html_e( 'Alcuni provider possono richiedere un passaggio aggiuntivo di verifica prima di completare l operazione.', 're-style' ); ?></li>
						</ul>
					</div>

					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Cosa puoi aspettarti al checkout', 're-style' ); ?></h3>
						<ul class="re-style-info-list">
							<li><?php esc_html_e( 'I metodi mostrati in questa pagina sono letti in automatico dai gateway attivi del negozio.', 're-style' ); ?></li>
							<li><?php esc_html_e( 'In fase di checkout la disponibilita effettiva puo variare in base al carrello, al totale ordine o alle regole del provider.', 're-style' ); ?></li>
							<li><?php esc_html_e( "Per i rimborsi approvati viene normalmente usato lo stesso canale del pagamento originario, salvo vincoli del gateway.", 're-style' ); ?></li>
						</ul>
					</div>
				</div>

				<div class="re-style-info-note">
					<p><?php esc_html_e( "Per completare l'acquisto utilizza solo la pagina checkout ufficiale del sito e controlla sempre con attenzione i dati inseriti prima della conferma finale.", 're-style' ); ?></p>
				</div>
			</section>

			<section id="assistenza-pagamenti" class="re-style-info-support" aria-labelledby="assistenza-pagamenti-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Assistenza Clienti', 're-style' ); ?></span>
				<h2 id="assistenza-pagamenti-title"><?php esc_html_e( 'Problemi durante il pagamento?', 're-style' ); ?></h2>
				<div class="re-style-info-support-copy">
					<p><?php esc_html_e( "Se un pagamento viene rifiutato o il checkout si interrompe, ti consigliamo di verificare i dati inseriti, riprovare con il metodo preferito oppure contattarci indicando il numero d'ordine, se già generato, e il problema riscontrato.", 're-style' ); ?></p>
				</div>
				<div class="re-style-page-actions">
					<a class="re-style-page-btn re-style-page-btn--primary" href="<?php echo esc_url( $checkout_url ); ?>"><?php esc_html_e( 'Vai al checkout', 're-style' ); ?></a>
					<a class="re-style-page-btn re-style-page-btn--secondary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Torna allo shop', 're-style' ); ?></a>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
