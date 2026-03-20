<?php
/**
 * Global footer template.
 *
 * @package ReStyle
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">
			<div class="footer-grid">
				<?php
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Navigation', 're-style' ),
						'location'   => 'footer_navigation',
						'menu_id'    => 'footer-navigation-menu',
						'aria_label' => __( 'Footer navigation menu', 're-style' ),
					)
				);
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Shop', 're-style' ),
						'location'   => 'footer_shop',
						'menu_id'    => 'footer-shop-menu',
						'aria_label' => __( 'Footer shop menu', 're-style' ),
					)
				);
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Information', 're-style' ),
						'location'   => 'footer_info',
						'menu_id'    => 'footer-info-menu',
						'aria_label' => __( 'Footer information menu', 're-style' ),
					)
				);
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Legal', 're-style' ),
						'location'   => 'footer_legal',
						'menu_id'    => 'footer-legal-menu',
						'aria_label' => __( 'Footer legal menu', 're-style' ),
					)
				);
				?>
			</div>

			<p class="site-footer__credits">
				<?php
				printf(
					esc_html__( '%1$s %2$s. All rights reserved.', 're-style' ),
					esc_html__( 'Copyright', 're-style' ),
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
