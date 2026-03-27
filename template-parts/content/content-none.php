<?php
/**
 * Empty state template.
 *
 * @package ReStyle
 */

?>
<section class="no-results not-found">
	<header class="page-header">
		<h2 class="page-title"><?php esc_html_e( 'Nothing to display', 're-style' ); ?></h2>
	</header>

	<div class="page-content">
		<p><?php esc_html_e( 'Content is not available yet.', 're-style' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</section>
