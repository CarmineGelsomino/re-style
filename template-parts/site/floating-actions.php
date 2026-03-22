<?php
/**
 * Floating homepage actions.
 *
 * @package ReStyle
 */

?>
<a href="https://wa.me/393285505045" class="floating-whatsapp-btn" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Contact us on WhatsApp', 're-style' ); ?>">
	<span class="icon icon-whatsapp-fixed" aria-hidden="true">
		<svg><use href="#icon-whatsapp"></use></svg>
	</span>
</a>
<?php $floating_book = re_style_get_floating_book_action(); ?>
<a href="<?php echo esc_url( $floating_book['url'] ); ?>" class="floating-book-btn" aria-label="<?php echo esc_attr( $floating_book['label'] ); ?>">
	<span><?php echo esc_html( $floating_book['label'] ); ?></span>
</a>
