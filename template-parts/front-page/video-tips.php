<?php $section = $args['section']; ?>
<section class="front-video-tips" id="videoconsigli" aria-label="<?php esc_attr_e( 'Videoconsigli', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<p><?php echo esc_html( $section['description'] ); ?></p>
	<div class="front-video-tips__grid">
		<?php foreach ( $section['items'] as $item ) : ?>
			<article class="video-tip-card">
				<div class="video-tip-card__placeholder" aria-hidden="true">
					<span class="video-tip-card__play"><svg><use href="#icon-play-video"></use></svg></span>
				</div>
				<h3 class="video-tip-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
			</article>
		<?php endforeach; ?>
	</div>
</section>
