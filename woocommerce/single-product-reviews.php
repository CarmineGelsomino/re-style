<?php
/**
 * Product reviews.
 *
 * Narrow override introduced because the hook-only approach still allowed
 * incorrect/fallback review rendering in the custom single-product layout.
 *
 * @package ReStyle
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$product_id = $product->get_id();
$comments   = get_comments(
	array(
		'post_id' => $product_id,
		'status'  => 'approve',
		'parent'  => 0,
	)
);

if ( ! comments_open( $product_id ) && empty( $comments ) ) {
	return;
}

$reviewer = wp_get_current_commenter();
$fields   = array(
	'author' => sprintf(
		'<p class="comment-form-author"><label for="author">%1$s&nbsp;<span class="required">*</span></label><input id="author" name="author" type="text" value="%2$s" size="30" autocomplete="name" required /></p>',
		esc_html__( 'Nome', 'woocommerce' ),
		esc_attr( $reviewer['comment_author'] )
	),
	'email'  => sprintf(
		'<p class="comment-form-email"><label for="email">%1$s&nbsp;<span class="required">*</span></label><input id="email" name="email" type="email" value="%2$s" size="30" autocomplete="email" required /></p>',
		esc_html__( 'Email', 'woocommerce' ),
		esc_attr( $reviewer['comment_author_email'] )
	),
);

$comment_form = array(
	'title_reply'          => ! empty( $comments )
		? esc_html__( 'Aggiungi una recensione', 're-style' )
		: sprintf(
			/* translators: %s product title. */
			esc_html__( 'Recensisci per primo "%s"', 're-style' ),
			get_the_title()
		),
	'title_reply_to'       => esc_html__( 'Lascia una risposta a %s', 're-style' ),
	'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
	'title_reply_after'    => '</h3>',
	'comment_notes_before' => '',
	'comment_notes_after'  => '',
	'label_submit'         => esc_html__( 'Invia', 're-style' ),
	'logged_in_as'         => '',
	'fields'               => $fields,
	'comment_field'        => '',
	'class_submit'         => 'submit',
);

if ( 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
	$comment_form['comment_field'] .= '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'La tua valutazione', 're-style' ) . '&nbsp;<span class="required">*</span></label><select name="rating" id="rating" required>
		<option value="">' . esc_html__( 'Valuta&hellip;', 'woocommerce' ) . '</option>
		<option value="5">' . esc_html__( 'Perfetto', 'woocommerce' ) . '</option>
		<option value="4">' . esc_html__( 'Buono', 'woocommerce' ) . '</option>
		<option value="3">' . esc_html__( 'Medio', 'woocommerce' ) . '</option>
		<option value="2">' . esc_html__( 'Non male', 'woocommerce' ) . '</option>
		<option value="1">' . esc_html__( 'Molto scarso', 'woocommerce' ) . '</option>
	</select></p>';
}

$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'La tua recensione', 're-style' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
			<?php esc_html_e( 'Recensioni', 're-style' ); ?>
		</h2>

		<?php if ( ! empty( $comments ) ) : ?>
			<ol class="commentlist">
				<?php
				wp_list_comments(
					apply_filters(
						'woocommerce_product_review_list_args',
						array(
							'callback' => 'woocommerce_comments',
						)
					),
					$comments
				);
				?>
			</ol>

			<?php
			if ( get_comment_pages_count( $comments ) > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'Ancora non ci sono recensioni.', 're-style' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) !== 'yes' || wc_customer_bought_product( '', get_current_user_id(), $product ? $product->get_id() : 0 ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) ); ?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required">
			<?php esc_html_e( 'Devi aver effettuato l\'accesso e acquistato questo prodotto per pubblicare una recensione.', 're-style' ); ?>
		</p>
	<?php endif; ?>
</div>
