<?php
/**
 * Dedicated page template for returns and refunds information.
 *
 * @package ReStyle
 */

get_header();

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
?>
<main id="primary" class="site-main site-main--info-page" tabindex="-1">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 're-style-info-page' ); ?>>
			<section class="re-style-info-hero" aria-labelledby="resi-e-rimborsi-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Informazioni', 're-style' ); ?></span>
				<h1 id="resi-e-rimborsi-title" class="entry-title"><?php the_title(); ?></h1>
				<p><?php esc_html_e( "In questa pagina trovi le condizioni per richiedere un reso, le modalita di rimborso e le indicazioni utili per contattare l'assistenza in modo rapido e corretto.", 're-style' ); ?></p>

				<nav class="re-style-info-anchor-nav" aria-label="<?php esc_attr_e( 'Indice della pagina resi e rimborsi', 're-style' ); ?>">
					<a class="re-style-info-anchor-link" href="#resi">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '01', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php esc_html_e( 'Resi', 're-style' ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Requisiti, tempi e preparazione del pacco prima della restituzione.', 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#rimborsi">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '02', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php esc_html_e( 'Rimborsi', 're-style' ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( "Condizioni di approvazione, controlli e tutela dell'azienda.", 're-style' ); ?></span>
					</a>
					<a class="re-style-info-anchor-link" href="#assistenza-resi">
						<span class="re-style-info-anchor-kicker"><?php esc_html_e( '03', 're-style' ); ?></span>
						<span class="re-style-info-anchor-title"><?php esc_html_e( 'Assistenza', 're-style' ); ?></span>
						<span class="re-style-info-anchor-description"><?php esc_html_e( 'Canali e indicazioni pratiche per ricevere supporto sul processo.', 're-style' ); ?></span>
					</a>
				</nav>
			</section>

			<section id="resi" class="re-style-info-section" aria-labelledby="resi-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Resi', 're-style' ); ?></span>
				<h2 id="resi-title"><?php esc_html_e( 'Come gestire un reso', 're-style' ); ?></h2>

				<div class="re-style-info-card-grid">
					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Quando puoi richiederlo', 're-style' ); ?></h3>
						<ul class="re-style-info-list">
							<li><?php esc_html_e( 'Il reso puo essere richiesto entro 14 giorni dalla consegna del prodotto.', 're-style' ); ?></li>
							<li><?php esc_html_e( 'Gli articoli devono essere integri, non utilizzati e restituiti con confezione originale e accessori inclusi.', 're-style' ); ?></li>
							<li><?php esc_html_e( "Se il prodotto arriva danneggiato o non conforme, e consigliato segnalarlo subito allegando foto e numero d'ordine.", 're-style' ); ?></li>
						</ul>
					</div>

					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Preparazione del pacco', 're-style' ); ?></h3>
						<ol class="re-style-info-steps">
							<li><strong><?php esc_html_e( 'Proteggi il prodotto:', 're-style' ); ?></strong> <?php esc_html_e( 'riponi articolo, accessori e documentazione nella confezione originale, se disponibile.', 're-style' ); ?></li>
							<li><strong><?php esc_html_e( 'Chiudi il pacco con cura:', 're-style' ); ?></strong> <?php esc_html_e( 'usa un imballo adeguato per evitare danni durante il trasporto.', 're-style' ); ?></li>
							<li><strong><?php esc_html_e( 'Prepara i dettagli della richiesta:', 're-style' ); ?></strong> <?php esc_html_e( "tieni a portata di mano numero d'ordine, motivo del reso e recapiti utili.", 're-style' ); ?></li>
						</ol>
					</div>
				</div>

				<div class="re-style-info-note">
					<p><?php esc_html_e( 'Per velocizzare la verifica, consigliamo di inviare la richiesta appena emerge il problema e prima di aprire o utilizzare il prodotto, quando possibile.', 're-style' ); ?></p>
				</div>
			</section>

			<section id="rimborsi" class="re-style-info-section" aria-labelledby="rimborsi-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Rimborsi', 're-style' ); ?></span>
				<h2 id="rimborsi-title"><?php esc_html_e( 'Informativa sui rimborsi', 're-style' ); ?></h2>

				<div class="re-style-info-card-grid">
					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Termini di restituzione', 're-style' ); ?></h3>
						<ul class="re-style-info-list">
							<li><?php esc_html_e( 'Il prodotto puo essere restituito entro 14 giorni dalla data di consegna.', 're-style' ); ?></li>
							<li><?php esc_html_e( 'Il prodotto non deve essere stato aperto e, salvo il caso in cui sia completamente danneggiato, tutte le sue parti originali devono essere incluse.', 're-style' ); ?></li>
						</ul>
					</div>

					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Procedura di restituzione', 're-style' ); ?></h3>
						<ol class="re-style-info-steps">
							<li><strong><?php esc_html_e( 'Preparazione del pacco:', 're-style' ); ?></strong> <?php esc_html_e( 'imballa il prodotto con cura, utilizzando la confezione originale.', 're-style' ); ?></li>
							<li><strong><?php esc_html_e( 'Programmazione del ritiro:', 're-style' ); ?></strong> <?php esc_html_e( 'contatta il nostro servizio di assistenza per programmare il ritiro. Un corriere passera a ritirare il pacco presso il tuo indirizzo.', 're-style' ); ?></li>
						</ol>
					</div>

					<div class="re-style-info-card">
						<h3><?php esc_html_e( 'Condizioni di rimborso', 're-style' ); ?></h3>
						<ul class="re-style-info-list">
							<li><?php esc_html_e( 'Non accettiamo rimborsi se il prodotto e stato aperto o utilizzato.', 're-style' ); ?></li>
							<li><?php esc_html_e( "I fondi saranno restituiti al cliente solo dopo l'arrivo del pacco presso la nostra sede e dopo il controllo delle condizioni del prodotto.", 're-style' ); ?></li>
							<li><?php esc_html_e( 'La richiesta di rimborso viene valutata in base allo stato del prodotto restituito.', 're-style' ); ?></li>
							<li><?php esc_html_e( 'E obbligatorio fornire una breve spiegazione del motivo della restituzione.', 're-style' ); ?></li>
						</ul>
					</div>

					<div class="re-style-info-card">
						<h3><?php esc_html_e( "Tutela dell'azienda", 're-style' ); ?></h3>
						<ul class="re-style-info-list">
							<li><?php esc_html_e( 'Ci riserviamo il diritto di rifiutare richieste di rimborso se il prodotto restituito non rispetta le condizioni indicate.', 're-style' ); ?></li>
							<li><?php esc_html_e( "In caso di restituzioni fraudolente, ci riserviamo il diritto di segnalare l'evento alle autorita competenti.", 're-style' ); ?></li>
							<li><?php esc_html_e( 'Ti invitiamo a conservare una copia della ricevuta di spedizione del pacco restituito per eventuali riferimenti futuri.', 're-style' ); ?></li>
						</ul>
					</div>
				</div>
			</section>

			<section id="assistenza-resi" class="re-style-info-support" aria-labelledby="assistenza-resi-title">
				<span class="re-style-page-label"><?php esc_html_e( 'Assistenza Clienti', 're-style' ); ?></span>
				<h2 id="assistenza-resi-title"><?php esc_html_e( 'Serve aiuto con il processo di reso?', 're-style' ); ?></h2>
				<div class="re-style-info-support-copy">
					<p><?php esc_html_e( 'Per ulteriori domande o per assistenza sul processo di restituzione, contattaci. Siamo qui per aiutarti.', 're-style' ); ?></p>
					<p><?php esc_html_e( 'Grazie per la tua comprensione e collaborazione.', 're-style' ); ?></p>
				</div>
				<div class="re-style-page-actions">
					<a class="re-style-page-btn re-style-page-btn--primary" href="<?php echo esc_url( home_url( '/#contatti' ) ); ?>"><?php esc_html_e( 'Contattaci', 're-style' ); ?></a>
					<a class="re-style-page-btn re-style-page-btn--secondary" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Torna allo shop', 're-style' ); ?></a>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
