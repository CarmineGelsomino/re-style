<?php $section = $args['section']; ?>
<section class="front-newsletter" aria-label="<?php esc_attr_e( 'Newsletter', 're-style' ); ?>">
	<div class="front-newsletter__inner">
		<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
		<h2><?php echo esc_html( $section['title'] ); ?></h2>
		<p><?php echo esc_html( $section['description'] ); ?></p>
		<form class="newsletter-form" action="#" method="post">
			<div class="newsletter-form__row">
				<label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Inserisci la tua email', 're-style' ); ?></label>
				<input type="email" id="newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Inserisci la tua email', 're-style' ); ?>">
				<button type="submit"><?php esc_html_e( 'Iscriviti', 're-style' ); ?></button>
			</div>
			<div class="newsletter-form__consent">
				<input type="checkbox" id="newsletter-privacy" name="privacy" required>
				<label for="newsletter-privacy"><?php esc_html_e( 'Ho letto e accetto la', 're-style' ); ?> <a href="<?php echo esc_url( $section['privacy_url'] ); ?>"><?php esc_html_e( 'Privacy Policy', 're-style' ); ?></a></label>
			</div>
		</form>
		<p class="front-newsletter__note"><?php echo esc_html( $section['note'] ); ?></p>
	</div>
</section>
