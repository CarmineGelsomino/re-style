<?php
/**
 * Global header template.
 *
 * @package ReStyle
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/site/icon-sprite' ); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 're-style' ); ?></a>
<div id="page" class="site">
	<?php get_template_part( 'template-parts/site/topbar' ); ?>

	<header id="masthead" class="site-header">
		<div class="site-header__inner">
			<div class="site-branding">
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<a class="site-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<img class="site-branding__logo" src="<?php echo esc_url( re_style_get_brand_logo_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>
					<?php
				}
				?>
			</div>

			<button
				class="site-header__menu-toggle"
				type="button"
				aria-expanded="false"
				aria-controls="site-navigation"
				aria-label="<?php esc_attr_e( 'Open menu', 're-style' ); ?>">
				<span class="site-header__menu-toggle-line" aria-hidden="true"></span>
				<span class="site-header__menu-toggle-line" aria-hidden="true"></span>
				<span class="site-header__menu-toggle-line" aria-hidden="true"></span>
			</button>

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 're-style' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'menu primary-menu nav-left',
						'container'      => false,
						'fallback_cb'    => 're_style_primary_menu_fallback',
					)
				);
				?>
			</nav>

			<ul class="site-header__actions nav-right" aria-label="<?php esc_attr_e( 'Quick actions', 're-style' ); ?>">
				<?php foreach ( re_style_get_header_action_links() as $action ) : ?>
					<li class="site-header__action-item">
						<a class="site-header__action-link" href="<?php echo esc_url( $action['url'] ); ?>" aria-label="<?php echo esc_attr( $action['label'] ); ?>">
							<span class="site-header__action-icon" aria-hidden="true">
								<svg viewBox="0 0 1024 1024" focusable="false">
									<use href="#<?php echo esc_attr( $action['icon'] ); ?>"></use>
								</svg>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</header>
