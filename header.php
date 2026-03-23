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
	<?php $header_actions = re_style_get_header_action_links(); ?>

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

			<div class="site-header__mobile-controls">
				<?php foreach ( array( 'wishlist', 'cart' ) as $mobile_action_key ) : ?>
					<?php if ( isset( $header_actions[ $mobile_action_key ] ) ) : ?>
						<a class="site-header__mobile-icon-link<?php echo 'cart' === $mobile_action_key ? ' site-header__mobile-icon-link--cart' : ''; ?>" href="<?php echo esc_url( $header_actions[ $mobile_action_key ]['url'] ); ?>" aria-label="<?php echo esc_attr( $header_actions[ $mobile_action_key ]['label'] ); ?>">
							<span class="site-header__mobile-icon" aria-hidden="true">
								<svg viewBox="0 0 1024 1024" focusable="false">
									<use href="#<?php echo esc_attr( $header_actions[ $mobile_action_key ]['icon'] ); ?>"></use>
								</svg>
							</span>
							<?php if ( ! empty( $header_actions[ $mobile_action_key ]['badge'] ) ) : ?>
								<?php echo $header_actions[ $mobile_action_key ]['badge']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Theme-generated cart badge HTML with controlled numeric output. ?>
							<?php endif; ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>

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
			</div>

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

				<?php if ( isset( $header_actions['account'] ) ) : ?>
					<a class="site-header__mobile-account-link" href="<?php echo esc_url( $header_actions['account']['url'] ); ?>"><?php esc_html_e( 'Il mio account', 're-style' ); ?></a>
				<?php endif; ?>
			</nav>

			<ul class="site-header__actions nav-right" aria-label="<?php esc_attr_e( 'Quick actions', 're-style' ); ?>">
				<?php foreach ( $header_actions as $action_key => $action ) : ?>
					<li class="site-header__action-item">
						<a class="site-header__action-link<?php echo 'cart' === $action_key ? ' site-header__action-link--cart' : ''; ?>" href="<?php echo esc_url( $action['url'] ); ?>" aria-label="<?php echo esc_attr( $action['label'] ); ?>">
							<span class="site-header__action-icon" aria-hidden="true">
								<svg viewBox="0 0 1024 1024" focusable="false">
									<use href="#<?php echo esc_attr( $action['icon'] ); ?>"></use>
								</svg>
							</span>
							<?php if ( ! empty( $action['badge'] ) ) : ?>
								<?php echo $action['badge']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Theme-generated cart badge HTML with controlled numeric output. ?>
							<?php endif; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</header>
