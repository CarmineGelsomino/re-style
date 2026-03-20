<?php $section = $args['section']; ?>
<section class="location-hours" id="sede-orari" aria-label="<?php esc_attr_e( 'Sede e Orari', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<div class="location-hours-layout">
		<div class="location-col">
			<h3><?php esc_html_e( 'Indirizzo', 're-style' ); ?></h3>
			<p class="location-address">
				<span class="icon icon-contact" aria-hidden="true"><svg><use href="#icon-position"></use></svg></span>
				<span><?php echo esc_html( $section['address'] ); ?></span>
			</p>
			<a href="<?php echo esc_url( $section['maps_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="maps-btn history-btn-secondary"><?php esc_html_e( 'Apri su Google Maps', 're-style' ); ?></a>
		</div>
		<div class="location-col">
			<h3><?php esc_html_e( 'Orari', 're-style' ); ?></h3>
			<div class="schedule-list">
				<?php foreach ( $section['schedule'] as $row ) : ?>
					<div>
						<span><?php echo esc_html( $row['days'] ); ?></span>
						<span><?php echo esc_html( $row['hours'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="holiday-note"><?php echo esc_html( $section['note'] ); ?></p>
		</div>
	</div>
	<a href="<?php echo esc_url( $section['cta']['url'] ); ?>" class="prenota-btn location-book-btn"><?php echo esc_html( $section['cta']['label'] ); ?></a>
</section>
