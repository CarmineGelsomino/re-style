<?php $section = $args['section']; ?>
<section class="front-contacts" id="contatti" aria-label="<?php esc_attr_e( 'Contatti', 're-style' ); ?>">
	<div class="front-contacts__layout">
		<div class="front-contacts__info">
			<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
			<h2><?php echo esc_html( $section['title'] ); ?></h2>
			<p><?php echo esc_html( $section['description'] ); ?></p>
			<div class="front-contacts__list">
				<div>
					<span class="contact-label"><span class="icon icon-contact" aria-hidden="true"><svg><use href="#icon-mail"></use></svg></span><span>Email</span></span>
					<a href="<?php echo esc_url( 'mailto:' . $section['email'] ); ?>"><?php echo esc_html( $section['email'] ); ?></a>
				</div>
				<div>
					<span class="contact-label"><span class="icon icon-contact" aria-hidden="true"><svg><use href="#icon-smartphone"></use></svg></span><span><?php esc_html_e( 'Telefono', 're-style' ); ?></span></span>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $section['phone'] ) ); ?>"><?php echo esc_html( $section['phone'] ); ?></a>
				</div>
			</div>
			<div class="front-contacts__socials">
				<?php foreach ( $section['socials'] as $social ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>" aria-label="<?php echo esc_attr( $social['label'] ); ?>"><?php echo esc_html( $social['label'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="front-contacts__owner">
			<img src="<?php echo esc_url( $section['owner']['image'] ); ?>" alt="<?php echo esc_attr( $section['owner']['alt'] ); ?>">
			<p><?php echo esc_html( $section['owner']['name'] ); ?></p>
		</div>
	</div>
	<a href="<?php echo esc_url( $section['cta']['url'] ); ?>" class="button button--primary button--full"><?php echo esc_html( $section['cta']['label'] ); ?></a>
</section>
