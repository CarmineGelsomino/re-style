<?php $section = $args['section']; ?>
<section class="front-location" id="sede-orari" aria-label="<?php esc_attr_e( 'Sede e Orari', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<div class="front-location__layout">
		<div class="front-location__column">
			<h3><?php esc_html_e( 'Indirizzo', 're-style' ); ?></h3>
			<p class="front-location__address">
				<span class="icon icon-contact" aria-hidden="true"><svg><use href="#icon-position"></use></svg></span>
				<span><?php echo esc_html( $section['address'] ); ?></span>
			</p>
			<a href="<?php echo esc_url( $section['maps_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="button button--secondary"><?php esc_html_e( 'Apri su Google Maps', 're-style' ); ?></a>
		</div>
		<div class="front-location__column">
			<h3><?php esc_html_e( 'Orari', 're-style' ); ?></h3>
			<div class="front-location__schedule">
				<?php foreach ( $section['schedule'] as $row ) : ?>
					<div>
						<span><?php echo esc_html( $row['days'] ); ?></span>
						<span><?php echo esc_html( $row['hours'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="front-location__note"><?php echo esc_html( $section['note'] ); ?></p>
		</div>
	</div>
	<a href="<?php echo esc_url( $section['cta']['url'] ); ?>" class="button button--primary button--full"><?php echo esc_html( $section['cta']['label'] ); ?></a>
</section>
