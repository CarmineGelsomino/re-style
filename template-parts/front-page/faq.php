<?php $section = $args['section']; ?>
<section class="front-faq" id="faq" aria-label="<?php esc_attr_e( 'Domande frequenti', 're-style' ); ?>">
	<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
	<h2><?php echo esc_html( $section['title'] ); ?></h2>
	<p><?php echo esc_html( $section['description'] ); ?></p>
	<div class="front-faq__grid">
		<?php foreach ( $section['items'] as $index => $item ) : ?>
			<?php $faq_id = $index + 1; ?>
			<article class="faq-item">
				<button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-<?php echo esc_attr( $faq_id ); ?>" id="faq-question-<?php echo esc_attr( $faq_id ); ?>">
					<span><?php echo esc_html( $item['question'] ); ?></span>
					<span class="faq-icon" aria-hidden="true">&gt;</span>
				</button>
				<div class="faq-answer" id="faq-answer-<?php echo esc_attr( $faq_id ); ?>" role="region" aria-labelledby="faq-question-<?php echo esc_attr( $faq_id ); ?>" aria-hidden="true">
					<div class="faq-answer__inner">
						<p><?php echo esc_html( $item['answer'] ); ?></p>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
