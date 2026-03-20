<?php
/**
 * Site topbar announcements.
 *
 * @package ReStyle
 */

$messages = re_style_get_topbar_messages();

if ( empty( $messages ) ) {
	return;
}
?>
<div class="topbar" role="region" aria-label="<?php esc_attr_e( 'Site announcements', 're-style' ); ?>">
	<div class="topbar__track">
		<div class="topbar__group">
			<?php foreach ( $messages as $message ) : ?>
				<span><?php echo esc_html( $message ); ?></span>
			<?php endforeach; ?>
		</div>
		<div class="topbar__group" aria-hidden="true">
			<?php foreach ( $messages as $message ) : ?>
				<span><?php echo esc_html( $message ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</div>
