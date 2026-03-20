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
		'location'   => '',
		'menu_id'    => 'footer-menu',
		'aria_label' => '',
	)
);
?>
<section class="footer-column">
	<?php if ( $args['title'] ) : ?>
		<h2 class="footer-column__title"><?php echo esc_html( $args['title'] ); ?></h2>
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
