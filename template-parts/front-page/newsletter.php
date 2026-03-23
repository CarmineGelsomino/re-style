<?php $section = $args['section']; ?>
<section class="newsletter" aria-label="<?php esc_attr_e( 'Newsletter', 're-style' ); ?>">
	<div class="newsletter-inner">
		<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
		<h2><?php echo esc_html( $section['title'] ); ?></h2>
		<p><?php echo esc_html( $section['description'] ); ?></p>
		<form id="oc-newsletter-form" class="newsletter-form" action="" method="post">
			<div class="newsletter-form-row">
				<label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Inserisci la tua email', 're-style' ); ?></label>
				<input type="email" id="newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Inserisci la tua email', 're-style' ); ?>" required>
				<button type="submit"><?php esc_html_e( 'Iscriviti', 're-style' ); ?></button>
			</div>
			<div class="newsletter-consent">
				<input type="checkbox" id="newsletter-consent" name="consent" value="1" required>
				<label for="newsletter-consent"><?php esc_html_e( 'Ho letto e accetto la', 're-style' ); ?> <a href="<?php echo esc_url( $section['privacy_url'] ); ?>"><?php esc_html_e( 'Privacy Policy', 're-style' ); ?></a></label>
			</div>
		</form>
		<p class="newsletter-note"><?php echo esc_html( $section['note'] ); ?></p>
	</div>
</section>
