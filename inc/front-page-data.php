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
	function re_style_asset_url( $path ) {
		return get_template_directory_uri() . '/' . ltrim( $path, '/' );
	}
}

if ( ! function_exists( 're_style_shop_url' ) ) {
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

if ( ! function_exists( 're_style_front_page_data' ) ) {
	function re_style_front_page_data() {
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
