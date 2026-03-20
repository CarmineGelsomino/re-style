<?php $section = $args['section']; ?>
<section class="gallery" id="galleria" aria-label="<?php esc_attr_e( 'Galleria', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<p><?php echo esc_html( $section['description'] ); ?></p>
	<div class="gallery-grid">
		<?php foreach ( $section['groups'] as $group ) : ?>
			<?php
			$images = array_map(
				static function ( $file ) {
					return re_style_asset_url( 'assets/img/' . $file );
				},
				$group['images']
			);
			?>
			<div class="gallery-card" data-images="<?php echo esc_attr( implode( ',', $images ) ); ?>">
				<img src="<?php echo esc_url( $images[0] ); ?>" alt="">
			</div>
		<?php endforeach; ?>
	</div>
</section>
