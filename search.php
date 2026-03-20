<?php
/**
 * Search results template.
 *
 * @package ReStyle
 */

get_header();
?>
<main id="primary" class="site-main">
	<header class="archive-header">
		<h1 class="archive-title">
			<?php
			printf(
				esc_html__( 'Search results for: %s', 're-style' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="content-list">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'search' );
			endwhile;
			?>
		</div>

		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
