<?php $section = $args['section']; ?>
<section class="front-hero" aria-label="<?php esc_attr_e( 'Introduzione', 're-style' ); ?>">
	<div class="front-hero__layout">
		<div class="front-hero__copy">
			<h2><?php echo esc_html( $section['title'] ); ?></h2>
			<p><?php echo esc_html( $section['description'] ); ?></p>
			<div class="front-hero__actions">
				<a href="<?php echo esc_url( $section['primary_cta']['url'] ); ?>" class="button button--primary"><?php echo esc_html( $section['primary_cta']['label'] ); ?></a>
				<a href="<?php echo esc_url( $section['secondary_cta']['url'] ); ?>" class="button button--secondary"><?php echo esc_html( $section['secondary_cta']['label'] ); ?></a>
			</div>
			<div class="front-hero__meta">
				<?php foreach ( $section['meta'] as $meta ) : ?>
					<span><?php echo esc_html( $meta ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="front-hero__media">
			<img src="<?php echo esc_url( $section['image']['src'] ); ?>" alt="<?php echo esc_attr( $section['image']['alt'] ); ?>">
		</div>
	</div>
</section>
