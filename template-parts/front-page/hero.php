<?php $section = $args['section']; ?>
<section class="hero" aria-label="<?php esc_attr_e( 'Introduzione', 're-style' ); ?>">
	<div class="hero-layout">
		<div class="hero-copy">
			<h2><?php echo esc_html( $section['title'] ); ?></h2>
			<p><?php echo esc_html( $section['description'] ); ?></p>
			<div class="hero-actions">
				<a href="<?php echo esc_url( $section['primary_cta']['url'] ); ?>" class="hero-btn hero-btn-primary"><?php echo esc_html( $section['primary_cta']['label'] ); ?></a>
				<a href="<?php echo esc_url( $section['secondary_cta']['url'] ); ?>" class="hero-btn hero-btn-secondary"><?php echo esc_html( $section['secondary_cta']['label'] ); ?></a>
			</div>
			<div class="hero-meta">
				<?php foreach ( $section['meta'] as $meta ) : ?>
					<span><?php echo esc_html( $meta ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="hero-visual-col">
			<div class="hero-visual-frame">
				<img src="<?php echo esc_url( $section['image']['src'] ); ?>" alt="<?php echo esc_attr( $section['image']['alt'] ); ?>" fetchpriority="high">
			</div>
		</div>
	</div>
</section>
