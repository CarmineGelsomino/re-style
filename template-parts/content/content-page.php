<?php
/**
 * Page content template.
 *
 * @package ReStyle
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-page' ); ?>>
	<?php if ( ( ! function_exists( 're_style_is_account_page' ) || ! re_style_is_account_page() ) && ( ! function_exists( 're_style_is_wishlist_page' ) || ! re_style_is_wishlist_page() ) ) : ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
