<?php
/**
 * Footer menu column.
 *
 * @package ReStyle
 */

$args = wp_parse_args(
	$args,
	array(
		'title'      => '',
		'title_url'  => '',
		'location'   => '',
		'menu_id'    => 'footer-menu',
		'aria_label' => '',
	)
);
?>
<section class="footer-col">
	<?php if ( $args['title'] ) : ?>
		<?php if ( ! empty( $args['title_url'] ) ) : ?>
			<a href="<?php echo esc_url( $args['title_url'] ); ?>" class="section-label"><?php echo esc_html( $args['title'] ); ?></a>
		<?php else : ?>
			<span class="section-label"><?php echo esc_html( $args['title'] ); ?></span>
		<?php endif; ?>
	<?php endif; ?>

	<nav class="footer-navigation" aria-label="<?php echo esc_attr( $args['aria_label'] ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => $args['location'],
				'menu_id'        => $args['menu_id'],
				'menu_class'     => 'menu footer-menu',
				'container'      => false,
				'fallback_cb'    => 're_style_footer_menu_fallback',
			)
		);
		?>
	</nav>
</section>
