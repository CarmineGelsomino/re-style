<?php $section = $args['section']; ?>
<section class="video-tips" id="videoconsigli" aria-label="<?php esc_attr_e( 'Videoconsigli', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<p><?php echo esc_html( $section['description'] ); ?></p>
	<div class="video-tips-grid">
		<?php foreach ( $section['items'] as $item ) : ?>
			<article class="video-tip-card">
				<button
					class="video-tip-trigger"
					type="button"
					aria-labelledby="<?php echo esc_attr( $item['id'] ); ?>"
					aria-label="<?php echo esc_attr( $item['aria_label'] ); ?>"
					data-video-mode="<?php echo esc_attr( isset( $item['video_mode'] ) ? $item['video_mode'] : 'file' ); ?>"
					data-video-src="<?php echo esc_attr( $item['video_src'] ); ?>"
					data-video-title="<?php echo esc_attr( $item['title'] ); ?>">
					<img src="<?php echo esc_url( $item['cover'] ); ?>" alt="<?php echo esc_attr( $item['cover_alt'] ); ?>" loading="lazy" decoding="async">
					<span class="video-tip-play" aria-hidden="true">
						<svg><use href="#icon-play-video"></use></svg>
					</span>
				</button>
				<h3 class="video-tip-title" id="<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['title'] ); ?></h3>
			</article>
		<?php endforeach; ?>
	</div>
	<div class="video-modal" id="videoModal" aria-hidden="true">
		<div class="video-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="videoModalTitle">
			<div class="video-modal-media">
				<button class="video-modal-close" id="closeVideoModal" type="button" aria-label="<?php esc_attr_e( 'Chiudi video', 're-style' ); ?>">
					<svg aria-hidden="true"><use href="#icon-close-modal"></use></svg>
				</button>
				<video id="videoModalPlayer" controls playsinline preload="metadata">
					<source id="videoModalSource" src="" type="video/mp4">
					<?php esc_html_e( 'Il tuo browser non supporta il tag video.', 're-style' ); ?>
				</video>
				<iframe id="videoModalEmbed" src="" title="<?php esc_attr_e( 'Video tutorial', 're-style' ); ?>" allow="autoplay; fullscreen; picture-in-picture; encrypted-media" allowfullscreen hidden></iframe>
			</div>
			<h3 id="videoModalTitle"></h3>
		</div>
	</div>
</section>
