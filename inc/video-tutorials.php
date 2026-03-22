<?php
/**
 * Video tutorial editorial model.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_register_video_tutorial_post_type' ) ) {
	/**
	 * Registers the dedicated video tutorial post type.
	 *
	 * @return void
	 */
	function re_style_register_video_tutorial_post_type() {
		$labels = array(
			'name'                  => __( 'Video Tutorial', 're-style' ),
			'singular_name'         => __( 'Video Tutorial', 're-style' ),
			'menu_name'             => __( 'OC | Video Tutorial', 're-style' ),
			'name_admin_bar'        => __( 'Video Tutorial', 're-style' ),
			'add_new'               => __( 'Aggiungi nuovo', 're-style' ),
			'add_new_item'          => __( 'Aggiungi video tutorial', 're-style' ),
			'edit_item'             => __( 'Modifica video tutorial', 're-style' ),
			'new_item'              => __( 'Nuovo video tutorial', 're-style' ),
			'view_item'             => __( 'Visualizza video tutorial', 're-style' ),
			'search_items'          => __( 'Cerca video tutorial', 're-style' ),
			'not_found'             => __( 'Nessun video tutorial trovato.', 're-style' ),
			'not_found_in_trash'    => __( 'Nessun video tutorial nel cestino.', 're-style' ),
			'all_items'             => __( 'Tutti i video tutorial', 're-style' ),
			'featured_image'        => __( 'Immagine di copertina', 're-style' ),
			'set_featured_image'    => __( 'Imposta immagine di copertina', 're-style' ),
			'remove_featured_image' => __( 'Rimuovi immagine di copertina', 're-style' ),
			'use_featured_image'    => __( 'Usa come immagine di copertina', 're-style' ),
		);

		register_post_type(
			'oc_video_tutorial',
			array(
				'labels'             => $labels,
				'public'             => false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => false,
				'has_archive'        => false,
				'publicly_queryable' => false,
				'exclude_from_search'=> true,
				'menu_icon'          => 'dashicons-video-alt3',
				'menu_position'      => 24,
				'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
			)
		);
	}
}
add_action( 'init', 're_style_register_video_tutorial_post_type' );

if ( ! function_exists( 're_style_add_video_tutorial_meta_box' ) ) {
	/**
	 * Registers the video source meta box.
	 *
	 * @return void
	 */
	function re_style_add_video_tutorial_meta_box() {
		add_meta_box(
			're-style-video-tutorial-source',
			__( 'Sorgente video', 're-style' ),
			're_style_render_video_tutorial_meta_box',
			'oc_video_tutorial',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 're_style_add_video_tutorial_meta_box' );

if ( ! function_exists( 're_style_render_video_tutorial_meta_box' ) ) {
	/**
	 * Renders the video source meta box.
	 *
	 * @param WP_Post $post Current post object.
	 * @return void
	 */
	function re_style_render_video_tutorial_meta_box( $post ) {
		$source_type   = get_post_meta( $post->ID, '_re_style_video_source_type', true );
		$attachment_id = absint( get_post_meta( $post->ID, '_re_style_video_attachment_id', true ) );
		$external_url  = get_post_meta( $post->ID, '_re_style_video_external_url', true );
		$upload_url    = $attachment_id ? wp_get_attachment_url( $attachment_id ) : '';

		if ( ! in_array( $source_type, array( 'upload', 'external' ), true ) ) {
			$source_type = 'upload';
		}

		wp_nonce_field( 're_style_save_video_tutorial', 're_style_video_tutorial_nonce' );
		?>
		<div class="re-style-video-source-box">
			<p><?php esc_html_e( 'Inserisci un titolo, imposta l\'immagine in evidenza come copertina e scegli se usare un file caricato o un link esterno.', 're-style' ); ?></p>
			<p>
				<label>
					<input type="radio" name="re_style_video_source_type" value="upload" <?php checked( $source_type, 'upload' ); ?>>
					<?php esc_html_e( 'Carica o seleziona un file video', 're-style' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="re_style_video_source_type" value="external" <?php checked( $source_type, 'external' ); ?>>
					<?php esc_html_e( 'Usa un link esterno', 're-style' ); ?>
				</label>
			</p>

			<div class="re-style-video-source-upload" <?php echo 'upload' === $source_type ? '' : 'style="display:none;"'; ?>>
				<input type="hidden" name="re_style_video_attachment_id" value="<?php echo esc_attr( $attachment_id ); ?>">
				<p>
					<label for="re-style-video-upload-url"><strong><?php esc_html_e( 'File video selezionato', 're-style' ); ?></strong></label>
					<input type="text" id="re-style-video-upload-url" class="widefat" value="<?php echo esc_url( $upload_url ); ?>" readonly>
				</p>
				<p>
					<button type="button" class="button re-style-select-video"><?php esc_html_e( 'Seleziona video', 're-style' ); ?></button>
					<button type="button" class="button button-link-delete re-style-clear-video" <?php echo $upload_url ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Rimuovi video', 're-style' ); ?></button>
				</p>
			</div>

			<div class="re-style-video-source-external" <?php echo 'external' === $source_type ? '' : 'style="display:none;"'; ?>>
				<p>
					<label for="re-style-video-external-url"><strong><?php esc_html_e( 'URL video o embed', 're-style' ); ?></strong></label>
					<input type="url" id="re-style-video-external-url" class="widefat" name="re_style_video_external_url" value="<?php echo esc_url( $external_url ); ?>" placeholder="https://">
				</p>
				<p class="description"><?php esc_html_e( 'Puoi usare un file video diretto oppure un link YouTube/Vimeo. Il frontend gestirà automaticamente il player corretto.', 're-style' ); ?></p>
			</div>

			<p class="description"><?php esc_html_e( 'L\'ordinamento in homepage segue l\'ordine attributo del contenuto. Usa "Attributi pagina > Ordine" per riordinare le card.', 're-style' ); ?></p>
		</div>
		<?php
	}
}

if ( ! function_exists( 're_style_save_video_tutorial_meta' ) ) {
	/**
	 * Saves video tutorial meta fields.
	 *
	 * @param int $post_id Current post ID.
	 * @return void
	 */
	function re_style_save_video_tutorial_meta( $post_id ) {
		if ( ! isset( $_POST['re_style_video_tutorial_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['re_style_video_tutorial_nonce'] ) ), 're_style_save_video_tutorial' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'oc_video_tutorial' !== get_post_type( $post_id ) ) {
			return;
		}

		$source_type = isset( $_POST['re_style_video_source_type'] ) ? sanitize_key( wp_unslash( $_POST['re_style_video_source_type'] ) ) : 'upload';

		if ( ! in_array( $source_type, array( 'upload', 'external' ), true ) ) {
			$source_type = 'upload';
		}

		$attachment_id = isset( $_POST['re_style_video_attachment_id'] ) ? absint( wp_unslash( $_POST['re_style_video_attachment_id'] ) ) : 0;
		$external_url  = isset( $_POST['re_style_video_external_url'] ) ? esc_url_raw( wp_unslash( $_POST['re_style_video_external_url'] ) ) : '';

		update_post_meta( $post_id, '_re_style_video_source_type', $source_type );
		update_post_meta( $post_id, '_re_style_video_attachment_id', $attachment_id );

		if ( $external_url ) {
			update_post_meta( $post_id, '_re_style_video_external_url', $external_url );
		} else {
			delete_post_meta( $post_id, '_re_style_video_external_url' );
		}
	}
}
add_action( 'save_post_oc_video_tutorial', 're_style_save_video_tutorial_meta' );

if ( ! function_exists( 're_style_enqueue_video_tutorial_admin_assets' ) ) {
	/**
	 * Enqueues admin assets for the video tutorial editor.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 * @return void
	 */
	function re_style_enqueue_video_tutorial_admin_assets( $hook_suffix ) {
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( ! $screen || 'oc_video_tutorial' !== $screen->post_type ) {
			return;
		}

		$theme = wp_get_theme();

		wp_enqueue_media();
		wp_enqueue_script(
			're-style-video-tutorial-admin',
			get_template_directory_uri() . '/assets/js/admin-video-tutorials.js',
			array(),
			$theme->get( 'Version' ),
			true
		);
	}
}
add_action( 'admin_enqueue_scripts', 're_style_enqueue_video_tutorial_admin_assets' );

if ( ! function_exists( 're_style_get_video_tutorial_embed_url' ) ) {
	/**
	 * Converts known provider URLs to embed URLs when possible.
	 *
	 * @param string $url Raw source URL.
	 * @return string
	 */
	function re_style_get_video_tutorial_embed_url( $url ) {
		$url  = trim( (string) $url );
		$host = wp_parse_url( $url, PHP_URL_HOST );
		$path = (string) wp_parse_url( $url, PHP_URL_PATH );

		if ( ! $host ) {
			return '';
		}

		$host = strtolower( $host );
		$path = trim( $path, '/' );

		if ( false !== strpos( $host, 'youtu.be' ) ) {
			$video_id = trim( $path, '/' );

			return $video_id ? 'https://www.youtube.com/embed/' . rawurlencode( $video_id ) . '?rel=0' : '';
		}

		if ( false !== strpos( $host, 'youtube.com' ) ) {
			$video_id = '';

			if ( 'watch' === $path ) {
				$query = wp_parse_url( $url, PHP_URL_QUERY );

				if ( $query ) {
					parse_str( $query, $query_args );
					$video_id = isset( $query_args['v'] ) ? sanitize_text_field( $query_args['v'] ) : '';
				}
			} elseif ( 0 === strpos( $path, 'embed/' ) ) {
				$video_id = substr( $path, strlen( 'embed/' ) );
			} elseif ( 0 === strpos( $path, 'shorts/' ) ) {
				$video_id = substr( $path, strlen( 'shorts/' ) );
			}

			return $video_id ? 'https://www.youtube.com/embed/' . rawurlencode( $video_id ) . '?rel=0' : '';
		}

		if ( false !== strpos( $host, 'vimeo.com' ) ) {
			$segments = array_values( array_filter( explode( '/', $path ) ) );
			$video_id = end( $segments );

			if ( $video_id && preg_match( '/^\d+$/', $video_id ) ) {
				return 'https://player.vimeo.com/video/' . rawurlencode( $video_id );
			}
		}

		return '';
	}
}

if ( ! function_exists( 're_style_get_video_tutorial_source_data' ) ) {
	/**
	 * Returns the normalized source data for a video tutorial.
	 *
	 * @param int $post_id Video tutorial post ID.
	 * @return array<string, string>
	 */
	function re_style_get_video_tutorial_source_data( $post_id ) {
		$source_type   = get_post_meta( $post_id, '_re_style_video_source_type', true );
		$attachment_id = absint( get_post_meta( $post_id, '_re_style_video_attachment_id', true ) );
		$external_url  = trim( (string) get_post_meta( $post_id, '_re_style_video_external_url', true ) );

		if ( 'upload' === $source_type && $attachment_id ) {
			$attachment_url = wp_get_attachment_url( $attachment_id );

			if ( $attachment_url ) {
				return array(
					'mode' => 'file',
					'url'  => $attachment_url,
				);
			}
		}

		if ( $external_url ) {
			$embed_url = re_style_get_video_tutorial_embed_url( $external_url );

			if ( $embed_url ) {
				return array(
					'mode' => 'embed',
					'url'  => $embed_url,
				);
			}

			return array(
				'mode' => 'file',
				'url'  => esc_url_raw( $external_url ),
			);
		}

		return array(
			'mode' => '',
			'url'  => '',
		);
	}
}

if ( ! function_exists( 're_style_get_video_tutorial_items' ) ) {
	/**
	 * Returns published video tutorial items for the homepage.
	 *
	 * @return array<int, array<string, string>>
	 */
	function re_style_get_video_tutorial_items() {
		$query = new WP_Query(
			array(
				'post_type'              => 'oc_video_tutorial',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'orderby'                => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => true,
			)
		);

		if ( ! $query->have_posts() ) {
			return array();
		}

		$items = array();

		foreach ( $query->posts as $post ) {
			$post_id = $post->ID;
			$title   = get_the_title( $post_id );
			$source  = re_style_get_video_tutorial_source_data( $post_id );

			if ( '' === $title || '' === $source['url'] || '' === $source['mode'] ) {
				continue;
			}

			$cover_id  = get_post_thumbnail_id( $post_id );
			$cover_url = $cover_id ? wp_get_attachment_image_url( $cover_id, 'large' ) : '';

			if ( ! $cover_url ) {
				$cover_url = re_style_asset_url( 'assets/img/hero.webp' );
			}

			$cover_alt = $cover_id ? trim( (string) get_post_meta( $cover_id, '_wp_attachment_image_alt', true ) ) : '';

			if ( '' === $cover_alt ) {
				$cover_alt = sprintf(
					/* translators: %s video title. */
					__( 'Copertina video: %s', 're-style' ),
					$title
				);
			}

			$items[] = array(
				'id'         => 'video-tip-title-' . $post_id,
				'title'      => $title,
				'aria_label' => sprintf(
					/* translators: %s video title. */
					__( 'Apri video: %s', 're-style' ),
					$title
				),
				'video_src'  => $source['url'],
				'video_mode' => $source['mode'],
				'cover'      => $cover_url,
				'cover_alt'  => $cover_alt,
			);
		}

		wp_reset_postdata();

		return $items;
	}
}
