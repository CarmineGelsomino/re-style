<?php
/**
 * Front page template.
 *
 * @package ReStyle
 */

get_header();

$page_title = get_bloginfo( 'name' );

if ( have_posts() ) {
	the_post();
	$page_title = get_the_title() ? get_the_title() : $page_title;
}

$front_page = re_style_front_page_data();
?>
<?php get_template_part( 'template-parts/site/floating-actions' ); ?>

<main id="primary" class="site-main site-main--front-page" tabindex="-1">
	<h1 class="screen-reader-text"><?php echo esc_html( $page_title ); ?></h1>

	<?php get_template_part( 'template-parts/front-page/hero', null, array( 'section' => $front_page['hero'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/services', null, array( 'section' => $front_page['services'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/shop-categories', null, array( 'section' => $front_page['shop'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/history', null, array( 'section' => $front_page['history'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/location-hours', null, array( 'section' => $front_page['location'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/gallery', null, array( 'section' => $front_page['gallery'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/video-tips', null, array( 'section' => $front_page['video_tips'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/contacts', null, array( 'section' => $front_page['contacts'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/faq', null, array( 'section' => $front_page['faq'] ) ); ?>
	<?php get_template_part( 'template-parts/front-page/newsletter', null, array( 'section' => $front_page['newsletter'] ) ); ?>
</main>
<?php
get_footer();
