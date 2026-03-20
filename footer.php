<?php
/**
 * Global footer template.
 *
 * @package ReStyle
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">
			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 're-style' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_id'        => 'footer-menu',
						'container'      => false,
						'fallback_cb'    => 're_style_footer_menu_fallback',
					)
				);
				?>
			</nav>
			<p class="site-footer__credits">
				<?php
				printf(
					esc_html__( '%1$s %2$s. All rights reserved.', 're-style' ),
					'©',
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</p>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
