# Implementation Log

## Regola di compilazione
Per ogni task aggiungere:
- ID task
- Obiettivo
- File letti
- File creati/modificati
- Decisioni prese
- Assunzioni
- Verification
- TODO / rischi residui

---

## Task TEMPLATE

### Task ID
T000

### Obiettivo
Descrizione breve

### File letti
- AGENTS.md
- docs/PROJECT_BRIEF.md
- docs/IMPLEMENTATION_LOG.md

### File creati/modificati
- elenco file

### Decisioni prese
- decisione 1
- decisione 2

### Assunzioni
- assunzione 1

### Verification
- comando/test/check eseguito
- esito

### TODO / rischi residui
- punto 1
- punto 2

---

## Task Entries

### Task ID
T000

### Obiettivo
Impostare la base operativa del repository attraverso analisi iniziale completa della documentazione e del frontend statico esistente, senza avviare ancora la conversione completa a tema WordPress.

### File letti
- AGENTS.md
- README.md
- docs/PROJECT_BRIEF.md
- docs/IMPLEMENTATION_LOG.md
- sito-statico/index.html
- sito-statico/shop.html
- sito-statico/informazioni.html
- sito-statico/assets/css/style.css
- sito-statico/assets/js/main.js

### File creati/modificati
- docs/PROJECT_BRIEF.md
- docs/IMPLEMENTATION_LOG.md

### Decisioni prese
- Confermato approccio block-first con block theme, `theme.json` v3 e uso prioritario di templates HTML, template parts e patterns.
- Definita come priorità la trasformazione dei design tokens già presenti nel CSS statico in configurazione centrale del tema, evitando di portare nel tema WordPress il CSS monolitico così com’è.
- Stabilito che header, topbar e footer dovranno essere consolidati in componenti riutilizzabili, perché nella base statica risultano duplicati tra le pagine.
- Stabilito che la conversione WooCommerce dovrà preferire WooCommerce Blocks e ridurre al minimo gli override legacy di template PHP.
- Stabilito che in questa fase si interviene solo sulla documentazione progettuale e non su scaffolding del tema o conversione dei template.

### Analisi iniziale della struttura statica trovata
- La homepage statica contiene una struttura one-page con hero, servizi, shop teaser, storia, sede e orari, galleria, videoconsigli, contatti, FAQ, newsletter e footer.
- La pagina `shop.html` contiene un archivio prodotti statico con toolbar, ricerca, sorting, filtri laterali, griglia prodotti, paginazione, blocchi benefici e CTA finale.
- La pagina `informazioni.html` contiene contenuti editoriali utili al futuro ecommerce: spedizioni, resi e rimborsi, pagamenti, supporto clienti e FAQ.
- Il file `style.css` centralizza già variabili CSS in `:root` per tipografia, palette, spacing, bottoni, icone e offset; queste variabili rappresentano la base dei futuri design tokens del tema.
- Il file `main.js` concentra comportamenti per modale servizi, galleria hover, dropdown shop, modale video e accordion FAQ; alcuni di questi comportamenti dovranno essere rivalutati rispetto a accessibilità, mantenibilità e compatibilità block-first.

### Mappatura operativa iniziale
- Header: logo, navigazione principale, dropdown categorie shop e icone utility.
- Footer: footer multi-colonna condiviso con link informativi, contatti e area copyright.
- Menu: navigazione principale attualmente hardcoded con ancore interne in homepage e link statici tra pagine.
- Homepage: struttura sezionale forte, potenzialmente convertibile in template homepage + patterns modulari.
- Assets: CSS e JS unificati, immagini presenti per hero/servizi/categorie/gallery/owner, ma con media referenziati e non presenti per prodotti e cover video.

### Rischi
- Il layout statico usa `scroll-snap`, sezioni full-height e offset fissi che non sono direttamente adatti a WordPress/WooCommerce con contenuti dinamici, editor e viewport mobili.
- Le interazioni JS attuali potrebbero risultare superflue, ridondanti o non pienamente accessibili in un contesto block theme.
- I path assoluti `/assets/...` non sono pronti per WordPress e richiederanno una strategia di asset loading coerente.
- Mancano asset referenziati per product cards e video cover, quindi non è possibile assumere una conversione visuale completa senza ulteriori materiali.
- Diverse CTA puntano a `#` o a flussi non ancora definiti (prenotazione, wishlist, account, newsletter), quindi è necessario mantenere assunzioni conservative.

### Assunzioni
- Il tema tecnico userà lo slug `client-theme` e text domain `client-theme` finché non arriverà un naming definitivo diverso.
- Il blocco topbar promozionale verrà trattato come elemento di layout configurabile e non come contenuto hardcoded nei template finali.
- Le funzioni wishlist, prenotazione e newsletter non saranno implementate finché non verranno definite dipendenze/plugin o specifiche funzionali.
- Le immagini mancanti saranno gestite in task futuri senza introdurre placeholder artificiali in questa fase.
- Il layout dovrà rimanere coerente attraverso variabili di stile centralizzate, con priorità ai tokens di `theme.json` e CSS residuale solo dove necessario.

### Piano dei prossimi task
- T001: creare skeleton minimo del block theme (`style.css`, `theme.json`, templates base, metadata tema) senza introdurre logica superflua.
- T002: estrarre e normalizzare i design tokens dal CSS statico verso `theme.json` e definire il CSS residuale minimo.
- T003: convertire header, topbar e footer in template parts/patterns accessibili e riutilizzabili.
- T004: costruire il template homepage block-first con priorità a hero, servizi, story, contatti e FAQ.
- T005: impostare l’integrazione WooCommerce block-first per archive shop, single product e pagine core ecommerce.
- T006: progettare e registrare patterns editoriali riutilizzabili per CTA, contenuti informativi, newsletter e sezioni trust.
- T007: definire strategia media e asset mancanti, inclusi prodotti, cover video, icone e ottimizzazione immagini.
- T008: impostare checklist e tooling di QA tecnico (WPCS/Theme Check/lint dove realmente utile e documentato).

### Verification
- `cat AGENTS.md`
  - Letto e recepito il perimetro operativo del repository.
- `cat docs/PROJECT_BRIEF.md`
  - Letto il brief iniziale e usato come base per l’aggiornamento.
- `cat docs/IMPLEMENTATION_LOG.md`
  - Letto il formato richiesto per il log.
- `rg --files -g '!node_modules' -g '!vendor' -g '!dist' -g '!build' .`
  - Mappata la struttura del repository senza scansioni ricorsive lente.
- `sed -n '1,260p' sito-statico/index.html`
  - Analizzata la homepage statica e le prime sezioni condivise.
- `sed -n '1,260p' sito-statico/shop.html`
  - Analizzata la struttura dello shop statico.
- `sed -n '1,260p' sito-statico/informazioni.html`
  - Analizzata la pagina informativa statica.
- `sed -n '1,520p' sito-statico/assets/css/style.css`
  - Analizzato il sistema di variabili CSS e il layout statico.
- `sed -n '1,220p' sito-statico/assets/js/main.js`
  - Analizzati i comportamenti interattivi esistenti.
- `rg -n "<(header|footer|main|section|nav|h1|h2|h3)\\b|id=\\\"|class=\\\"(topbar|hero|services|history|shop|gallery|video|faq|contact|footer|info|products|archive|cart|checkout)" sito-statico/index.html sito-statico/shop.html sito-statico/informazioni.html`
  - Creata una mappa rapida di sezioni, landmark e heading.
- `rg -n "assets/(img|css|js)/[A-Za-z0-9_./-]+" sito-statico/index.html sito-statico/shop.html sito-statico/informazioni.html`
  - Mappati gli asset referenziati nei file statici.
- `python - <<'PY' ... PY`
  - Verificata la presenza fisica degli asset referenziati; rilevate immagini mancanti per prodotti e cover video.

### TODO / rischi residui
- Creare lo scaffold reale del tema solo nel task successivo, mantenendo la separazione tra tokens, layout, patterns e logica minima.
- Verificare nei prossimi task se il layout full-screen statico debba essere reinterpretato per una UX WordPress più flessibile.
- Confermare quali componenti interattivi restano necessari dopo la conversione block-first.
- Ottenere o sostituire in modo esplicito i media mancanti prima della conversione visuale dello shop e dei videoconsigli.
