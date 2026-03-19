# Project Brief

## Contesto
- Sito e-commerce custom per cliente.
- Esiste una base frontend statica da trasformare in tema WordPress custom con WooCommerce.
- In questa fase il repository viene impostato come base operativa: analisi, decisioni iniziali, assunzioni conservative e piano tecnico, senza avviare ancora la conversione completa.

## Obiettivi principali
- Convertire il frontend statico in un tema WordPress block-first.
- Garantire personalizzazione nativa tramite Site Editor, `theme.json`, patterns, template HTML e template parts.
- Preparare il tema a WooCommerce 10.6.x con preferenza per WooCommerce Blocks e override legacy solo se indispensabili.
- Mantenere accessibilità WCAG 2.2 AA, SEO tecnico, performance prudenti e coerenza visiva tramite design tokens centralizzati.

## Stato iniziale del repository
- Il repository contiene una base statica in `sito-statico/` composta da tre pagine HTML: homepage (`index.html`), catalogo shop (`shop.html`) e pagina informazioni (`informazioni.html`).
- Gli asset condivisi sono centralizzati in `sito-statico/assets/css/style.css` e `sito-statico/assets/js/main.js`.
- Il CSS usa già variabili custom in `:root` per font, colori, spacing, pulsanti, icone e offset di layout; queste variabili devono guidare la futura modellazione dei design tokens in `theme.json` e del CSS residuale.
- La struttura statica mostra header, topbar, footer e moduli riutilizzabili, ma oggi questi blocchi sono duplicati nelle pagine HTML invece di essere componentizzati.

## Mappatura iniziale della base statica

### Struttura globale condivisa
- `topbar` fissa con messaggi promozionali.
- `header` fisso con logo, navigazione principale, dropdown Shop e icone profilo/preferiti/carrello.
- CTA flottanti per WhatsApp e prenotazione.
- `footer.site-footer` ripetuto nelle pagine statiche.
- Inclusione di una libreria icone SVG inline ripetuta pagina per pagina.

### Homepage statica (`sito-statico/index.html`)
Sezioni principali rilevate:
- Hero introduttiva.
- Servizi con cards e modale descrittiva.
- Anteprima categorie shop.
- Sezione storia/brand.
- Sezione sede e orari.
- Galleria immagini.
- Videoconsigli con modale video.
- Contatti e profilo fondatore.
- FAQ.
- Newsletter.
- Footer.

### Shop statico (`sito-statico/shop.html`)
Blocchi principali rilevati:
- Toolbar con ricerca e sorting.
- Tab categorie.
- Sidebar filtri.
- Griglia prodotti.
- Paginazione.
- Sezione benefici.
- CTA finale verso contatti/servizi.
- Footer.

### Pagina informazioni (`sito-statico/informazioni.html`)
Blocchi principali rilevati:
- Hero informativa con anchor links.
- Sezioni spedizioni, resi e rimborsi, pagamenti, supporto clienti.
- FAQ.
- Footer.

### Asset e contenuti trovati
- Immagini disponibili per logo, hero, servizi, categorie shop, owner e gallery in `sito-statico/assets/img/`.
- CSS monolitico in `sito-statico/assets/css/style.css`.
- JS monolitico in `sito-statico/assets/js/main.js` per modali servizi/video, gallery hover, dropdown shop e FAQ.

### Gap iniziali rilevati
- Alcuni asset referenziati nelle pagine statiche non risultano presenti nel repository: cover video (`video-cover-1.webp` ... `video-cover-4.webp`) e immagini prodotto (`product-1.webp` ... `product-9.webp`).
- I path asset sono assoluti (`/assets/...`) e andranno normalizzati per WordPress.
- Il CSS è pensato per una one-page statica con `scroll-snap`, altezze viewport-based e header/topbar fissi: questa impostazione richiederà adattamento per template WordPress, contenuti dinamici, editor e viste WooCommerce.
- La navigazione attuale usa ancora ancore hardcoded e placeholder `#` per varie azioni.

## Scope attuale
- Definire la base documentale e tecnica del repository.
- Stabilire architettura iniziale del futuro tema.
- Documentare la mappatura del frontend statico e le priorità di conversione.
- Pianificare i prossimi task senza implementarli ora.

## Vincoli confermati
- WordPress target: 6.9.x stable.
- WooCommerce target: 10.6.x stable.
- Approccio block-first con `theme.json` v3.
- No page builder.
- No dipendenze inutili.
- Preferire funzionalità native WordPress/WooCommerce.
- Ridurre al minimo codice PHP, JS e CSS fragili o legacy.
- Layout sempre coerente con uso sistematico delle variabili di stile/design tokens.

## Architettura iniziale proposta

### Tema
- Block theme con slug `client-theme` e text domain `client-theme`, salvo indicazione diversa futura.
- Cartelle previste: `templates/`, `parts/`, `patterns/`, `styles/`, `assets/`, `inc/` solo se serve PHP minimo.
- `theme.json` come sorgente primaria per tokens, typography, spacing, color palette, layout e block styles.

### Strategia di conversione del frontend statico
- Trasformare header, footer e topbar in template parts e pattern riutilizzabili.
- Convertire la homepage in template/patterns a sezioni, evitando hardcode e privilegiando blocchi core.
- Tradurre lo shop statico in combinazione di template WooCommerce + WooCommerce Blocks, minimizzando override di template PHP legacy.
- Riassorbire il più possibile le variabili CSS statiche nei design tokens di `theme.json`; mantenere CSS residuale solo per gap non coperti dai blocchi.
- Valutare se gli elementi flottanti e i comportamenti JS siano davvero necessari nel tema finale oppure se vadano semplificati in chiave accessibile e mantenibile.

### Componenti da modellare come patterns o template parts
- Header principale con navigation block.
- Topbar/announcement bar.
- Footer multi-colonna.
- Hero homepage.
- Sezione servizi.
- Grid categorie shop.
- Sezioni contenuto editoriale (storia, contatti, CTA, FAQ, newsletter).
- Blocchi informativi per spedizioni/resi/pagamenti.

## Requisiti qualità
- WordPress Coding Standards.
- Accessibilità WCAG 2.2 AA minimo.
- Responsive mobile-first.
- Focus states visibili e navigazione tastiera.
- Semantica HTML corretta e gerarchia heading coerente.
- Compatibilità con plugin SEO senza duplicare funzionalità tipiche dei plugin.
- Compatibilità con WooCommerce Blocks e markup ecommerce moderno.
- Performance prudenti: asset essenziali, immagini ottimizzabili, JS ridotto.

## Assunzioni conservative correnti
- Il naming definitivo del brand in frontend resta `Re Style`, ma il tema tecnico userà lo slug `client-theme` finché non verrà richiesto diversamente.
- Le immagini mancanti verranno richieste o sostituite in task successivi; in questa fase non si introducono placeholder artificiali.
- Le funzioni account, wishlist, carrello avanzato, prenotazione e newsletter non sono ancora definite a livello funzionale/plugin e quindi restano fuori dallo scope implementativo iniziale.
- Le sezioni statiche saranno convertite privilegiando contenuti gestibili dall’editor, evitando hardcode nei template quando il contenuto può diventare pattern o contenuto modificabile.

## Rischi iniziali
- Possibile mismatch tra layout statico full-screen e comportamento atteso in WordPress/WooCommerce con contenuti dinamici.
- Possibile necessità di ridurre o riprogettare interazioni JS per rispettare accessibilità, performance e approccio block-first.
- Asset mancanti che impediscono una migrazione pixel-perfect immediata.
- Footer/header duplicati e icone inline ripetute che richiederanno una strategia di consolidamento.

## Piano operativo dei prossimi task
1. Definire skeleton del block theme (`style.css`, `theme.json`, templates minimi, `functions.php` solo se necessario).
2. Estrarre design tokens dal CSS statico e mapparli in `theme.json` + CSS residuale minimo.
3. Convertire header/topbar/footer in template parts e pattern accessibili.
4. Costruire homepage base block-first partendo dalle sezioni statiche prioritarie.
5. Impostare integrazione WooCommerce block-first per archivio shop, singolo prodotto e flussi base.
6. Progettare patterns editoriali riutilizzabili per contenuti informativi, CTA, FAQ e contatti.
7. Allineare asset, media mancanti e strategia immagini/video.
8. Configurare QA tecnico iniziale (linting/WPCS/Theme Check se introdotti).

## Decisioni aperte
- Nome definitivo del tema oltre allo slug tecnico.
- Perimetro delle integrazioni extra-ecommerce: wishlist, prenotazione, newsletter, account avanzato.
- Scelta finale tra mantenimento, semplificazione o eliminazione di alcune interazioni JS statiche.
- Strategia per i media mancanti e per eventuali video reali dei videoconsigli.
