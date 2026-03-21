<?php
/**
 * Global footer template.
 *
 * @package ReStyle
 */

?>
	<footer id="colophon" class="site-footer" aria-label="<?php esc_attr_e( 'Footer', 're-style' ); ?>">
		<div class="site-footer-inner">
			<div class="footer-grid">
				<?php
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Navigazione', 're-style' ),
						'title_url'  => home_url( '/' ),
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
						'title_url'  => home_url( '/#shop' ),
						'location'   => 'footer_shop',
						'menu_id'    => 'footer-shop-menu',
						'aria_label' => __( 'Footer shop menu', 're-style' ),
					)
				);
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Informazioni', 're-style' ),
						'title_url'  => home_url( '/informazioni/#info-hero' ),
						'location'   => 'footer_info',
						'menu_id'    => 'footer-info-menu',
						'aria_label' => __( 'Footer information menu', 're-style' ),
					)
				);
				get_template_part(
					'template-parts/navigation/footer-column',
					null,
					array(
						'title'      => __( 'Legale', 're-style' ),
						'location'   => 'footer_legal',
						'menu_id'    => 'footer-legal-menu',
						'aria_label' => __( 'Footer legal menu', 're-style' ),
					)
				);
				?>
			</div>

			<div class="footer-bottom">
				<p>
					<?php echo esc_html( sprintf( __( '© %s Re Style. Tutti i diritti sono riservati. Sito realizzato da', 're-style' ), gmdate( 'Y' ) ) ); ?>
					<span><?php esc_html_e( 'OC Corporation', 're-style' ); ?></span>.
				</p>
			</div>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
