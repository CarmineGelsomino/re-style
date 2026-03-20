<?php $section = $args['section']; ?>
<section class="front-services" id="servizi" aria-label="<?php esc_attr_e( 'Servizi', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<p><?php echo esc_html( $section['description'] ); ?></p>
	<div class="front-services__layout">
		<div class="front-services__image">
			<img src="<?php echo esc_url( $section['image']['src'] ); ?>" alt="<?php echo esc_attr( $section['image']['alt'] ); ?>">
		</div>
		<div class="front-services__content">
			<div class="front-services__grid">
				<?php foreach ( $section['items'] as $item ) : ?>
					<button class="service-card" type="button" data-title="<?php echo esc_attr( $item['title'] ); ?>" data-description="<?php echo esc_attr( $item['description'] ); ?>">
						<?php echo esc_html( $item['title'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>
			<a href="<?php echo esc_url( $section['cta']['url'] ); ?>" class="button button--primary button--full"><?php echo esc_html( $section['cta']['label'] ); ?></a>
		</div>
	</div>
	<div class="service-modal" id="serviceModal" aria-hidden="true">
		<div class="service-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="serviceModalTitle">
			<button class="service-modal__close" id="closeServiceModal" type="button" aria-label="<?php esc_attr_e( 'Chiudi finestra', 're-style' ); ?>">
				<svg aria-hidden="true"><use href="#icon-close-modal"></use></svg>
			</button>
			<h3 id="serviceModalTitle"></h3>
			<p id="serviceModalDescription"></p>
		</div>
	</div>
</section>
