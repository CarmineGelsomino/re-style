<?php
/**
 * Product loop card template.
 *
 * @package ReStyle
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
	return;
}

$badge        = re_style_get_product_badge( $product );
$category     = re_style_get_product_primary_category_name( $product );
$description  = re_style_get_loop_product_description( $product );
$price_html   = re_style_get_product_loop_price_html( $product );
$button_html  = re_style_get_loop_add_to_cart_html( $product );
$wishlist     = re_style_get_wishlist_button_html( $product, 'loop' );
$product_link = get_permalink( $product->get_id() );
?>
<li <?php wc_product_class( 'product-card', $product ); ?>>
	<?php echo $wishlist; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Theme-generated wishlist button HTML with escaped attributes. ?>

	<a href="<?php echo esc_url( $product_link ); ?>" class="product-media">
		<?php if ( ! empty( $badge['label'] ) ) : ?>
			<span class="product-badge <?php echo esc_attr( $badge['class'] ); ?>"><?php echo esc_html( $badge['label'] ); ?></span>
		<?php endif; ?>

		<?php if ( has_post_thumbnail( $product->get_id() ) ) : ?>
			<?php echo get_the_post_thumbnail( $product->get_id(), 'woocommerce_thumbnail' ); ?>
		<?php else : ?>
			<?php echo wc_placeholder_img( 'woocommerce_thumbnail' ); ?>
		<?php endif; ?>
	</a>

	<div class="product-info">
		<?php if ( '' !== $category ) : ?>
			<span class="product-category"><?php echo esc_html( $category ); ?></span>
		<?php endif; ?>

		<h3><a href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( get_the_title( $product->get_id() ) ); ?></a></h3>

		<?php if ( '' !== $description ) : ?>
			<p><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<div class="product-bottom">
			<div class="product-price-group"><?php echo wp_kses_post( $price_html ); ?></div>
			<?php echo wp_kses_post( $button_html ); ?>
		</div>
	</div>
</li>
