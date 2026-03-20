<?php $section = $args['section']; ?>
<section class="history" id="storia" aria-label="<?php esc_attr_e( 'Storia', 're-style' ); ?>">
	<div class="history-layout">
		<div class="history-content">
			<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
			<h2><?php echo esc_html( $section['title'] ); ?></h2>
			<p><?php echo wp_kses_post( nl2br( esc_html( $section['description'] ) ) ); ?></p>
			<div class="history-milestones">
				<?php foreach ( $section['milestones'] as $item ) : ?>
					<div class="milestone">
						<span><?php echo esc_html( $item['value'] ); ?></span>
						<p><?php echo esc_html( $item['label'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="history-cta">
				<a href="<?php echo esc_url( $section['primary_cta']['url'] ); ?>" class="history-btn history-btn-primary"><?php echo esc_html( $section['primary_cta']['label'] ); ?></a>
				<a href="<?php echo esc_url( $section['secondary_cta']['url'] ); ?>" class="history-btn history-btn-secondary"><?php echo esc_html( $section['secondary_cta']['label'] ); ?></a>
			</div>
		</div>
	</div>
</section>
