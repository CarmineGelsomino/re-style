<?php
/**
 * Single post template.
 *
 * @package ReStyle
 */

get_header();
?>
<main id="primary" class="site-main" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/content', get_post_type() );

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>
</main>
<?php
get_footer();
