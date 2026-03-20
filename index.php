<?php
/**
 * Main fallback template.
 *
 * @package ReStyle
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<div class="content-list">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', get_post_type() );
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
