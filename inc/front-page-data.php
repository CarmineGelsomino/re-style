<?php
/**
 * Front page data helpers.
 *
 * @package ReStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 're_style_asset_url' ) ) {
	/**
	 * Returns a theme asset URL.
	 *
	 * @param string $path Relative asset path.
	 * @return string
	 */
	function re_style_asset_url( $path ) {
		return get_template_directory_uri() . '/' . ltrim( $path, '/' );
	}
}

if ( ! function_exists( 're_style_shop_url' ) ) {
	/**
	 * Returns the WooCommerce shop URL when available.
	 *
	 * @return string
	 */
	function re_style_shop_url() {
		if ( function_exists( 'wc_get_page_permalink' ) ) {
			$url = wc_get_page_permalink( 'shop' );

			if ( $url ) {
				return $url;
			}
		}

		if ( post_type_exists( 'product' ) ) {
			$url = get_post_type_archive_link( 'product' );

			if ( $url ) {
				return $url;
			}
		}

		return '#shop';
	}
}

if ( ! function_exists( 're_style_get_front_page_defaults' ) ) {
	/**
	 * Returns default homepage content.
	 *
	 * @return array<string, mixed>
	 */
	function re_style_get_front_page_defaults() {
		return array(
			'hero'       => array(
				'title'         => 'Il tuo stile, valorizzato in ogni dettaglio',
				'description'   => 'Un punto di riferimento a Casoria (NA) per chi cerca consulenza, tecnica e cura del dettaglio, con servizi professionali e una selezione di prodotti grooming da usare anche a casa.',
				'primary_cta'   => array(
					'label' => 'Prenota ora',
					'url'   => '#contatti',
				),
				'secondary_cta' => array(
					'label' => 'Vai allo shop',
					'url'   => re_style_shop_url(),
				),
				'meta'          => array( 'Barber & Grooming' ),
				'image'         => array(
					'src' => re_style_asset_url( 'assets/img/hero.webp' ),
					'alt' => 'Interno del salone Re Style con postazioni da barbiere e ambiente moderno.',
				),
			),
			'services'   => array(
				'label'       => 'Servizi',
				'title'       => 'Scegli il look adatto a te',
				'description' => 'Clicca su ogni servizio per maggiori informazioni e scegli il trattamento piu adatto a te.',
				'image'       => array(
					'src' => re_style_asset_url( 'assets/img/servizi.webp' ),
					'alt' => 'Postazione professionale Re Style con poltrona, specchio illuminato e prodotti per capelli e barba.',
				),
				'cta'         => array(
					'label' => 'Prenota il tuo servizio',
					'url'   => '#contatti',
				),
				'items'       => array(
					array( 'title' => 'Shampoo', 'description' => 'Trattamento detergente delicato per capelli e cute, ideale per iniziare il servizio con pulizia e freschezza.' ),
					array( 'title' => 'Barba', 'description' => 'Servizio di regolazione e definizione barba studiato in base alla forma del viso per un risultato ordinato e curato.' ),
					array( 'title' => 'Taglio capelli', 'description' => 'Taglio personalizzato eseguito dopo una consulenza iniziale per valorizzare lineamenti, stile e tipologia di capello.' ),
					array( 'title' => 'Colore capelli', 'description' => 'Colorazione parziale o totale senza ammoniaca per coprire i capelli bianchi o effettuare un cambio look dopo attenta consulenza.' ),
					array( 'title' => 'Acconciatura', 'description' => 'Servizio di styling e acconciatura per occasioni speciali o per un look impeccabile e duraturo.' ),
					array( 'title' => 'Colore barba', 'description' => 'Colore dedicato alla copertura dei peli bianchi nella zona barba, con prodotti specifici per aree sensibili.' ),
					array( 'title' => 'Decolorazione', 'description' => 'Decolorazione completa o parziale dei capelli di 4 o 5 toni, dopo un accurata consulenza del capello.' ),
					array( 'title' => 'Schiaritura sun-effect', 'description' => 'Tecnica di schiaritura a caldo, completa o parziale, per un immediato effetto colpi di sole.' ),
					array( 'title' => 'Barba con vaporizzatore', 'description' => 'Servizio barba con utilizzo del vapore per ammorbidire la pelle e ridurre arrossamenti nei mesi freddi.' ),
					array( 'title' => 'Keratina', 'description' => 'Trattamento per rendere piu lisci e gestibili i capelli ricci, crespi o ribelli, agendo in profondita sulla fibra.' ),
					array( 'title' => 'Permanente', 'description' => 'Trattamento di lunga durata per ottenere movimento e riccio in base alla struttura e alla lunghezza del capello.' ),
					array( 'title' => 'Cono therapy', 'description' => 'Sistema a calore pensato per favorire la rimozione delle impurita e del cerume in modo controllato.' ),
				),
			),
			'shop'       => array(
				'label'       => 'Shop',
				'title'       => 'La tua routine grooming',
				'description' => 'Scopri una selezione di prodotti pensati per prenderti cura di capelli e barba ogni giorno, con strumenti e soluzioni professionali scelti per mantenere il tuo stile anche a casa.',
				'cta'         => array(
					'label' => 'Scopri tutti i prodotti',
					'url'   => re_style_shop_url(),
				),
				'items'       => array(
					array( 'title' => 'Cura dei capelli', 'url' => re_style_shop_url(), 'image' => re_style_asset_url( 'assets/img/capelli-shop.webp' ), 'alt' => 'Prodotti professionali per la cura dei capelli.' ),
					array( 'title' => 'Cura della barba', 'url' => re_style_shop_url(), 'image' => re_style_asset_url( 'assets/img/barba-shop.webp' ), 'alt' => 'Prodotti grooming per la cura e la definizione della barba.' ),
					array( 'title' => 'Dispositivi elettronici', 'url' => re_style_shop_url(), 'image' => re_style_asset_url( 'assets/img/dispositivi-elettronici-shop.webp' ), 'alt' => 'Dispositivi elettronici professionali per capelli e barba.' ),
				),
			),
			'history'    => array(
				'label'         => 'Storia',
				'title'         => 'Una passione nata presto, diventata esperienza, stile e vocazione',
				'description'   => 'Il nostro percorso nel mondo della bellezza inizia a 12 anni e cresce nel tempo attraverso studio, riconoscimenti, formazione costante e una cura attenta per ogni dettaglio. Oggi portiamo avanti questo lavoro con la stessa passione di sempre, offrendo un servizio completo, tecnico e professionale.',
				'milestones'    => array(
					array( 'value' => '12 anni', 'label' => 'Nasce la passione' ),
					array( 'value' => '2006', 'label' => 'Accademia A.N.A.M.' ),
					array( 'value' => '24 anni', 'label' => 'Apertura attivita' ),
					array( 'value' => '10+ anni', 'label' => 'Formazione continua' ),
				),
				'primary_cta'   => array(
					'label' => 'Prenota il tuo appuntamento',
					'url'   => '#contatti',
				),
				'secondary_cta' => array(
					'label' => 'Richiedi una consulenza',
					'url'   => '#contatti',
				),
			),
			'location'   => array(
				'label'    => 'Sede e Orari',
				'title'    => 'Vieni a trovarci',
				'address'  => 'Via Po, 11, 80026 Casoria NA',
				'maps_url' => 'https://www.google.com/maps?q=Via+Po+11,+Casoria',
				'schedule' => array(
					array( 'days' => 'Domenica e Lunedi', 'hours' => 'Chiuso' ),
					array( 'days' => 'Martedi - Venerdi', 'hours' => '09:00 - 13:00 | 15:30 - 20:00' ),
					array( 'days' => 'Sabato', 'hours' => '09:00 - 13:30 | 15:30 - 20:00' ),
				),
				'note'     => 'Gli orari possono variare nei giorni festivi.',
				'cta'      => array(
					'label' => 'Prenota',
					'url'   => '#contatti',
				),
			),
			'gallery'    => array(
				'label'       => 'Galleria',
				'title'       => 'I nostri lavori, il nostro stile',
				'description' => 'Una selezione di tagli, styling e dettagli che raccontano il nostro modo di lavorare.',
				'groups'      => array(
					array( 'images' => array( 'gallery_0.webp', 'gallery_1.webp', 'gallery_2.webp' ) ),
					array( 'images' => array( 'gallery_3.webp', 'gallery_4.webp', 'gallery_5.webp' ) ),
					array( 'images' => array( 'gallery_6.webp', 'gallery_7.webp', 'gallery_8.webp' ) ),
					array( 'images' => array( 'gallery_9.webp', 'gallery_10.webp', 'gallery_11.webp' ) ),
				),
			),
			'video_tips' => array(
				'label'       => 'Videoconsigli',
				'title'       => 'Consigli pratici per il tuo stile',
				'description' => 'Scopri una selezione di consigli rapidi su capelli, barba e grooming quotidiano, pensati per aiutarti a mantenere il tuo look anche a casa.',
				'items'       => array(
					array( 'title' => 'Come sistemare il ciuffo' ),
					array( 'title' => 'Cura quotidiana della barba' ),
					array( 'title' => 'Il prodotto giusto per i capelli' ),
					array( 'title' => 'Mantieni il taglio piu a lungo' ),
				),
			),
			'contacts'   => array(
				'label'       => 'Contatti',
				'title'       => 'Parliamone insieme',
				'description' => 'Per informazioni, prenotazioni o richieste, contattaci. Ti invitiamo a seguirci sui nostri canali social.',
				'email'       => 'info@restyle.it',
				'phone'       => '+39 328 550 5045',
				'owner'       => array(
					'name'  => 'Domenico Ferrara',
					'image' => re_style_asset_url( 'assets/img/domenico-ferrara-re-style.webp' ),
					'alt'   => 'Domenico Ferrara, fondatore di Re Style.',
				),
				'socials'     => array(
					array( 'label' => 'Instagram', 'url' => '#' ),
					array( 'label' => 'Facebook', 'url' => '#' ),
					array( 'label' => 'TikTok', 'url' => '#' ),
					array( 'label' => 'YouTube', 'url' => '#' ),
				),
				'cta'         => array(
					'label' => 'Prenota',
					'url'   => '#contatti',
				),
			),
			'faq'        => array(
				'label'       => 'FAQ',
				'title'       => 'Domande frequenti',
				'description' => 'Qui trovi le risposte alle domande piu comuni su prenotazioni, servizi, shop e assistenza.',
				'items'       => array(
					array( 'question' => 'E necessario prenotare?', 'answer' => 'Si, la prenotazione e consigliata per garantirti l orario piu comodo e ridurre i tempi di attesa.' ),
					array( 'question' => 'Posso ricevere una consulenza prima del servizio?', 'answer' => 'Certo. Prima del servizio valutiamo insieme stile, tipologia di capello o barba e risultato desiderato.' ),
					array( 'question' => 'Effettuate servizi per eventi o cerimonie?', 'answer' => 'Si, realizziamo servizi dedicati per eventi speciali, cerimonie e matrimoni con soluzioni personalizzate.' ),
					array( 'question' => 'Posso acquistare i prodotti anche senza un servizio in salone?', 'answer' => 'Si, puoi acquistare i prodotti grooming selezionati anche senza prenotare un servizio.' ),
				),
			),
			'newsletter' => array(
				'label'       => 'Newsletter',
				'title'       => 'Resta aggiornato sul tuo stile',
				'description' => 'Iscriviti per ricevere novita, consigli grooming, promozioni dedicate e aggiornamenti su servizi e prodotti Re Style.',
				'note'        => 'Riceverai comunicazioni informative e promozionali relative a servizi, novita e prodotti Re Style.',
				'privacy_url' => get_privacy_policy_url() ? get_privacy_policy_url() : '#',
			),
		);
	}
}

if ( ! function_exists( 're_style_serialize_pair_list' ) ) {
	/**
	 * Serializes an array of pair items for textarea controls.
	 *
	 * @param array<int, array<string, string>> $items  Source items.
	 * @param string                            $first  First key.
	 * @param string                            $second Second key.
	 * @return string
	 */
	function re_style_serialize_pair_list( $items, $first, $second ) {
		$lines = array();

		foreach ( $items as $item ) {
			if ( empty( $item[ $first ] ) ) {
				continue;
			}

			$lines[] = $item[ $first ] . ' | ' . ( isset( $item[ $second ] ) ? $item[ $second ] : '' );
		}

		return implode( "\n", $lines );
	}
}

if ( ! function_exists( 're_style_serialize_single_value_list' ) ) {
	/**
	 * Serializes a single-value list for textarea controls.
	 *
	 * @param array<int, array<string, string>> $items Source items.
	 * @param string                            $key   Item key.
	 * @return string
	 */
	function re_style_serialize_single_value_list( $items, $key ) {
		$lines = array();

		foreach ( $items as $item ) {
			if ( empty( $item[ $key ] ) ) {
				continue;
			}

			$lines[] = $item[ $key ];
		}

		return implode( "\n", $lines );
	}
}

if ( ! function_exists( 're_style_parse_pair_lines' ) ) {
	/**
	 * Parses textarea lines into two-key arrays.
	 *
	 * @param string $value  Serialized lines.
	 * @param string $first  First key.
	 * @param string $second Second key.
	 * @return array<int, array<string, string>>
	 */
	function re_style_parse_pair_lines( $value, $first, $second ) {
		$lines = preg_split( '/\r\n|\r|\n/', (string) $value );
		$items = array();

		foreach ( $lines as $line ) {
			$line = trim( $line );

			if ( '' === $line ) {
				continue;
			}

			$parts = array_map( 'trim', explode( '|', $line, 2 ) );

			if ( empty( $parts[0] ) ) {
				continue;
			}

			$items[] = array(
				$first  => sanitize_text_field( $parts[0] ),
				$second => isset( $parts[1] ) ? sanitize_text_field( $parts[1] ) : '',
			);
		}

		return $items;
	}
}

if ( ! function_exists( 're_style_parse_single_value_lines' ) ) {
	/**
	 * Parses one-value-per-line textarea content.
	 *
	 * @param string $value Serialized lines.
	 * @param string $key   Item key.
	 * @return array<int, array<string, string>>
	 */
	function re_style_parse_single_value_lines( $value, $key ) {
		$lines = preg_split( '/\r\n|\r|\n/', (string) $value );
		$items = array();

		foreach ( $lines as $line ) {
			$line = trim( $line );

			if ( '' === $line ) {
				continue;
			}

			$items[] = array(
				$key => sanitize_text_field( $line ),
			);
		}

		return $items;
	}
}

if ( ! function_exists( 're_style_get_mod_value' ) ) {
	/**
	 * Returns a scalar theme mod with default fallback.
	 *
	 * @param string $key     Theme-mod suffix.
	 * @param string $default Default value.
	 * @return string
	 */
	function re_style_get_mod_value( $key, $default ) {
		$value = get_theme_mod( 're_style_home_' . $key, $default );
		return is_string( $value ) && '' !== trim( $value ) ? trim( $value ) : $default;
	}
}

if ( ! function_exists( 're_style_front_page_data' ) ) {
	/**
	 * Returns homepage data with Customizer overrides applied.
	 *
	 * @return array<string, mixed>
	 */
	function re_style_front_page_data() {
		$defaults = re_style_get_front_page_defaults();
		$data     = $defaults;

		$data['hero']['title']                  = re_style_get_mod_value( 'hero_title', $defaults['hero']['title'] );
		$data['hero']['description']            = re_style_get_mod_value( 'hero_description', $defaults['hero']['description'] );
		$data['hero']['primary_cta']['label']   = re_style_get_mod_value( 'hero_primary_label', $defaults['hero']['primary_cta']['label'] );
		$data['hero']['primary_cta']['url']     = re_style_get_mod_value( 'hero_primary_url', $defaults['hero']['primary_cta']['url'] );
		$data['hero']['secondary_cta']['label'] = re_style_get_mod_value( 'hero_secondary_label', $defaults['hero']['secondary_cta']['label'] );
		$data['hero']['secondary_cta']['url']   = re_style_get_mod_value( 'hero_secondary_url', $defaults['hero']['secondary_cta']['url'] );
		$data['hero']['image']['src']           = re_style_get_mod_value( 'hero_image', $defaults['hero']['image']['src'] );
		$data['hero']['image']['alt']           = re_style_get_mod_value( 'hero_image_alt', $defaults['hero']['image']['alt'] );
		$hero_meta                              = re_style_parse_single_value_lines( re_style_get_mod_value( 'hero_meta', implode( "\n", $defaults['hero']['meta'] ) ), 'value' );
		$data['hero']['meta']                   = ! empty( $hero_meta ) ? wp_list_pluck( $hero_meta, 'value' ) : $defaults['hero']['meta'];

		$data['services']['label']         = re_style_get_mod_value( 'services_label', $defaults['services']['label'] );
		$data['services']['title']         = re_style_get_mod_value( 'services_title', $defaults['services']['title'] );
		$data['services']['description']   = re_style_get_mod_value( 'services_description', $defaults['services']['description'] );
		$data['services']['cta']['label']  = re_style_get_mod_value( 'services_cta_label', $defaults['services']['cta']['label'] );
		$data['services']['cta']['url']    = re_style_get_mod_value( 'services_cta_url', $defaults['services']['cta']['url'] );
		$data['services']['image']['src']  = re_style_get_mod_value( 'services_image', $defaults['services']['image']['src'] );
		$data['services']['image']['alt']  = re_style_get_mod_value( 'services_image_alt', $defaults['services']['image']['alt'] );
		$data['services']['items']         = re_style_parse_pair_lines( re_style_get_mod_value( 'services_items', re_style_serialize_pair_list( $defaults['services']['items'], 'title', 'description' ) ), 'title', 'description' );
		$data['services']['items']         = ! empty( $data['services']['items'] ) ? $data['services']['items'] : $defaults['services']['items'];

		$data['shop']['label']             = re_style_get_mod_value( 'shop_label', $defaults['shop']['label'] );
		$data['shop']['title']             = re_style_get_mod_value( 'shop_title', $defaults['shop']['title'] );
		$data['shop']['description']       = re_style_get_mod_value( 'shop_description', $defaults['shop']['description'] );
		$data['shop']['cta']['label']      = re_style_get_mod_value( 'shop_cta_label', $defaults['shop']['cta']['label'] );
		$data['shop']['cta']['url']        = re_style_get_mod_value( 'shop_cta_url', $defaults['shop']['cta']['url'] );

		for ( $index = 0; $index < 3; $index++ ) {
			$item_key = $index + 1;

			$data['shop']['items'][ $index ]['title'] = re_style_get_mod_value( 'shop_item_' . $item_key . '_title', $defaults['shop']['items'][ $index ]['title'] );
			$data['shop']['items'][ $index ]['url']   = re_style_get_mod_value( 'shop_item_' . $item_key . '_url', $defaults['shop']['items'][ $index ]['url'] );
			$data['shop']['items'][ $index ]['image'] = re_style_get_mod_value( 'shop_item_' . $item_key . '_image', $defaults['shop']['items'][ $index ]['image'] );
			$data['shop']['items'][ $index ]['alt']   = re_style_get_mod_value( 'shop_item_' . $item_key . '_alt', $defaults['shop']['items'][ $index ]['alt'] );
		}

		$data['history']['label']                  = re_style_get_mod_value( 'history_label', $defaults['history']['label'] );
		$data['history']['title']                  = re_style_get_mod_value( 'history_title', $defaults['history']['title'] );
		$data['history']['description']            = re_style_get_mod_value( 'history_description', $defaults['history']['description'] );
		$data['history']['primary_cta']['label']   = re_style_get_mod_value( 'history_primary_label', $defaults['history']['primary_cta']['label'] );
		$data['history']['primary_cta']['url']     = re_style_get_mod_value( 'history_primary_url', $defaults['history']['primary_cta']['url'] );
		$data['history']['secondary_cta']['label'] = re_style_get_mod_value( 'history_secondary_label', $defaults['history']['secondary_cta']['label'] );
		$data['history']['secondary_cta']['url']   = re_style_get_mod_value( 'history_secondary_url', $defaults['history']['secondary_cta']['url'] );
		$data['history']['milestones']             = re_style_parse_pair_lines( re_style_get_mod_value( 'history_milestones', re_style_serialize_pair_list( $defaults['history']['milestones'], 'value', 'label' ) ), 'value', 'label' );
		$data['history']['milestones']             = ! empty( $data['history']['milestones'] ) ? $data['history']['milestones'] : $defaults['history']['milestones'];

		$data['location']['label']          = re_style_get_mod_value( 'location_label', $defaults['location']['label'] );
		$data['location']['title']          = re_style_get_mod_value( 'location_title', $defaults['location']['title'] );
		$data['location']['address']        = re_style_get_mod_value( 'location_address', $defaults['location']['address'] );
		$data['location']['maps_url']       = re_style_get_mod_value( 'location_maps_url', $defaults['location']['maps_url'] );
		$data['location']['note']           = re_style_get_mod_value( 'location_note', $defaults['location']['note'] );
		$data['location']['cta']['label']   = re_style_get_mod_value( 'location_cta_label', $defaults['location']['cta']['label'] );
		$data['location']['cta']['url']     = re_style_get_mod_value( 'location_cta_url', $defaults['location']['cta']['url'] );
		$data['location']['schedule']       = re_style_parse_pair_lines( re_style_get_mod_value( 'location_schedule', re_style_serialize_pair_list( $defaults['location']['schedule'], 'days', 'hours' ) ), 'days', 'hours' );
		$data['location']['schedule']       = ! empty( $data['location']['schedule'] ) ? $data['location']['schedule'] : $defaults['location']['schedule'];

		$data['gallery']['label']           = re_style_get_mod_value( 'gallery_label', $defaults['gallery']['label'] );
		$data['gallery']['title']           = re_style_get_mod_value( 'gallery_title', $defaults['gallery']['title'] );
		$data['gallery']['description']     = re_style_get_mod_value( 'gallery_description', $defaults['gallery']['description'] );

		$data['video_tips']['label']        = re_style_get_mod_value( 'video_tips_label', $defaults['video_tips']['label'] );
		$data['video_tips']['title']        = re_style_get_mod_value( 'video_tips_title', $defaults['video_tips']['title'] );
		$data['video_tips']['description']  = re_style_get_mod_value( 'video_tips_description', $defaults['video_tips']['description'] );
		$data['video_tips']['items']        = re_style_parse_single_value_lines( re_style_get_mod_value( 'video_tips_items', re_style_serialize_single_value_list( $defaults['video_tips']['items'], 'title' ) ), 'title' );
		$data['video_tips']['items']        = ! empty( $data['video_tips']['items'] ) ? $data['video_tips']['items'] : $defaults['video_tips']['items'];

		$data['contacts']['label']          = re_style_get_mod_value( 'contacts_label', $defaults['contacts']['label'] );
		$data['contacts']['title']          = re_style_get_mod_value( 'contacts_title', $defaults['contacts']['title'] );
		$data['contacts']['description']    = re_style_get_mod_value( 'contacts_description', $defaults['contacts']['description'] );
		$data['contacts']['email']          = re_style_get_mod_value( 'contacts_email', $defaults['contacts']['email'] );
		$data['contacts']['phone']          = re_style_get_mod_value( 'contacts_phone', $defaults['contacts']['phone'] );
		$data['contacts']['owner']['name']  = re_style_get_mod_value( 'contacts_owner_name', $defaults['contacts']['owner']['name'] );
		$data['contacts']['owner']['image'] = re_style_get_mod_value( 'contacts_owner_image', $defaults['contacts']['owner']['image'] );
		$data['contacts']['owner']['alt']   = re_style_get_mod_value( 'contacts_owner_alt', $defaults['contacts']['owner']['alt'] );
		$data['contacts']['cta']['label']   = re_style_get_mod_value( 'contacts_cta_label', $defaults['contacts']['cta']['label'] );
		$data['contacts']['cta']['url']     = re_style_get_mod_value( 'contacts_cta_url', $defaults['contacts']['cta']['url'] );
		$data['contacts']['socials']        = re_style_parse_pair_lines( re_style_get_mod_value( 'contacts_socials', re_style_serialize_pair_list( $defaults['contacts']['socials'], 'label', 'url' ) ), 'label', 'url' );
		$data['contacts']['socials']        = ! empty( $data['contacts']['socials'] ) ? $data['contacts']['socials'] : $defaults['contacts']['socials'];

		$data['faq']['label']               = re_style_get_mod_value( 'faq_label', $defaults['faq']['label'] );
		$data['faq']['title']               = re_style_get_mod_value( 'faq_title', $defaults['faq']['title'] );
		$data['faq']['description']         = re_style_get_mod_value( 'faq_description', $defaults['faq']['description'] );
		$data['faq']['items']               = re_style_parse_pair_lines( re_style_get_mod_value( 'faq_items', re_style_serialize_pair_list( $defaults['faq']['items'], 'question', 'answer' ) ), 'question', 'answer' );
		$data['faq']['items']               = ! empty( $data['faq']['items'] ) ? $data['faq']['items'] : $defaults['faq']['items'];

		$data['newsletter']['label']        = re_style_get_mod_value( 'newsletter_label', $defaults['newsletter']['label'] );
		$data['newsletter']['title']        = re_style_get_mod_value( 'newsletter_title', $defaults['newsletter']['title'] );
		$data['newsletter']['description']  = re_style_get_mod_value( 'newsletter_description', $defaults['newsletter']['description'] );
		$data['newsletter']['note']         = re_style_get_mod_value( 'newsletter_note', $defaults['newsletter']['note'] );
		$data['newsletter']['privacy_url']  = re_style_get_mod_value( 'newsletter_privacy_url', $defaults['newsletter']['privacy_url'] );

		return $data;
	}
}
