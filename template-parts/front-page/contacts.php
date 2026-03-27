<?php $section = $args['section']; ?>
<section class="contacts" id="contatti" aria-label="<?php esc_attr_e( 'Contatti', 're-style' ); ?>">
	<div class="contacts-layout">
		<div class="contacts-info">
			<span class="section-label"><?php echo esc_html( $section['label'] ); ?></span>
			<h2><?php echo esc_html( $section['title'] ); ?></h2>
			<p><?php echo wp_kses_post( nl2br( esc_html( $section['description'] ) ) ); ?></p>
			<div class="contacts-list">
				<div>
					<span class="contact-label"><span class="icon icon-contact" aria-hidden="true"><svg><use href="#icon-mail"></use></svg></span><span>Email</span></span>
					<a href="<?php echo esc_url( 'mailto:' . $section['email'] ); ?>"><?php echo esc_html( $section['email'] ); ?></a>
				</div>
				<div>
					<span class="contact-label"><span class="icon icon-contact" aria-hidden="true"><svg><use href="#icon-smartphone"></use></svg></span><span><?php esc_html_e( 'Telefono', 're-style' ); ?></span></span>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $section['phone'] ) ); ?>"><?php echo esc_html( $section['phone'] ); ?></a>
				</div>
			</div>
			<div class="contacts-socials-wrap">
				<div class="contacts-socials">
				<?php foreach ( $section['socials'] as $social ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
						<span class="icon <?php echo esc_attr( $social['class'] ); ?>">
							<svg aria-hidden="true"><use href="#<?php echo esc_attr( $social['icon'] ); ?>"></use></svg>
						</span>
					</a>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="contacts-owner">
			<img src="<?php echo esc_url( $section['owner']['image'] ); ?>" alt="<?php echo esc_attr( $section['owner']['alt'] ); ?>" loading="lazy" decoding="async">
			<p><?php echo esc_html( $section['owner']['name'] ); ?></p>
		</div>
	</div>
	<a href="<?php echo esc_url( $section['cta']['url'] ); ?>" class="prenota-btn contacts-book-btn"><?php echo esc_html( $section['cta']['label'] ); ?></a>
</section>
