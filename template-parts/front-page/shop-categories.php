<?php $section = $args['section']; ?>
<section class="shop" id="shop" aria-label="<?php esc_attr_e( 'Shop', 're-style' ); ?>">
	<div class="shop-head">
		<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
		<h2><?php echo esc_html( $section['title'] ); ?></h2>
		<p><?php echo esc_html( $section['description'] ); ?></p>
	</div>
	<div class="shop-grid">
		<?php foreach ( $section['items'] as $item ) : ?>
			<a href="<?php echo esc_url( $item['url'] ); ?>" class="shop-card">
				<img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>" loading="lazy" decoding="async">
				<span><?php echo esc_html( $item['title'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</div>
	<a href="<?php echo esc_url( $section['cta']['url'] ); ?>" class="prenota-btn shop-btn"><?php echo esc_html( $section['cta']['label'] ); ?></a>
</section>
