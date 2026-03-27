<?php
/**
 * Page template.
 *
 * @package ReStyle
 */

get_header();
?>
<main id="primary" class="site-main" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content/content', 'page' );
	endwhile;
	?>
</main>
<?php
get_footer();
