<?php
/**
 * Shop archive CTA section.
 *
 * @package ReStyle
 */

$contact_url  = home_url( '/#contatti' );
$services_url = home_url( '/#servizi' );
?>
<section class="shop-cta-section" aria-label="<?php esc_attr_e( 'Supporto clienti', 're-style' ); ?>">
	<div class="shop-cta-inner">
		<div class="shop-cta-actions">
			<a href="<?php echo esc_url( $contact_url ); ?>" class="shop-cta-btn shop-cta-btn-primary"><?php esc_html_e( 'Contattaci', 're-style' ); ?></a>
			<a href="<?php echo esc_url( $services_url ); ?>" class="shop-cta-btn shop-cta-btn-secondary"><?php esc_html_e( 'Scopri i servizi', 're-style' ); ?></a>
		</div>
	</div>
</section>
