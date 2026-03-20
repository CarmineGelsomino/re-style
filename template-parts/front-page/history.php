<?php $section = $args['section']; ?>
<section class="front-history" id="storia" aria-label="<?php esc_attr_e( 'Storia', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<p><?php echo esc_html( $section['description'] ); ?></p>
	<div class="front-history__milestones">
		<?php foreach ( $section['milestones'] as $item ) : ?>
			<div class="milestone">
				<span><?php echo esc_html( $item['value'] ); ?></span>
				<p><?php echo esc_html( $item['label'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="front-history__actions">
		<a href="<?php echo esc_url( $section['primary_cta']['url'] ); ?>" class="button button--primary"><?php echo esc_html( $section['primary_cta']['label'] ); ?></a>
		<a href="<?php echo esc_url( $section['secondary_cta']['url'] ); ?>" class="button button--secondary"><?php echo esc_html( $section['secondary_cta']['label'] ); ?></a>
	</div>
</section>
