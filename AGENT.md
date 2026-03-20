# AGENTS.md

## Obiettivo del progetto
Convertire un frontend statico esistente in un tema custom WordPress + WooCommerce di tipo classic theme, moderno, mantenibile, accessibile, SEO-friendly e personalizzabile, senza usare page builder.

## Tipo di tema
Questo progetto deve essere sviluppato come CLASSIC THEME moderno, non come block theme.

Usare:
- template PHP classici
- template hierarchy standard di WordPress
- theme.json per design token, impostazioni editor e stili globali dove utile
- API native WordPress e WooCommerce
- PHP custom minimo, pulito e ben organizzato

Non trasformare il progetto in un block theme o in un tema full site editing.

## Stack target
- WordPress: linea stabile corrente 6.9.x
- WooCommerce: linea stabile corrente 10.6.x
- PHP: compatibile con ambienti hosting WordPress moderni supportati
- Architettura: classic theme con feature moderne progressive

## Contesto del progetto
Esiste già un frontend statico che include:
- homepage
- header
- footer
- navigazione/menu
- style ben definito e variabili da riportare in tutto il sito.

Questa base statica è il riferimento principale per la conversione in tema WordPress.

## Regole architetturali principali
- usare template PHP classici
- rispettare la template hierarchy di WordPress
- usare correttamente get_header(), get_footer(), get_template_part() e API correlate
- evitare logica business nel tema
- mantenere al minimo gli override WooCommerce
- preferire hook, supporti tema e stili prima di creare override template
- usare theme.json quando migliora la manutenibilità
- mantenere CSS scalabile e ordinato
- prestare molta attenzioni alle variabili create CSS
- usare JS solo se davvero necessario

## Obiettivo di personalizzazione
Il tema deve essere personalizzabile senza introdurre pannelli admin inutili.

Preferire:
- menu, logo, impostazioni native WordPress dove appropriato
- Customizer solo se realmente necessario nel contesto di un classic theme
- template-parts riusabili
- theme supports sensati
- editor styles coerenti con il frontend

Evitare:
- page builder
- pannelli opzioni fragili o ridondanti
- impostazioni duplicate rispetto a quelle già offerte da WordPress
- contenuti hardcoded quando dovrebbero essere modificabili

## Requisiti accessibilità
Il tema deve puntare a buone pratiche WCAG 2.2 AA.

Considerare sempre:
- landmark semantici
- corretta gerarchia dei titoli
- navigazione da tastiera
- focus visibile
- contrasto sufficiente
- form accessibili
- testo link significativo
- compatibilità con alt text immagini
- navigazione accessibile
- skip link dove opportuno
- evitare ARIA non necessaria

## Requisiti SEO
Il tema deve fornire una base tecnica SEO solida.

Considerare sempre:
- HTML semantico
- gerarchia heading pulita
- link interni crawlable
- compatibilità con plugin SEO
- markup immagini corretto
- caricamento asset attento alle performance
- nessuna duplicazione di funzioni tipiche dei plugin SEO
- compatibilità WooCommerce per flussi legati a product data e structured data

## Sicurezza e qualità codice
Seguire le best practice WordPress:
- sanitizzare input
- eseguire escaping output
- usare nonce dove necessario
- rendere il tema pronto per traduzioni
- seguire WordPress Coding Standards quando applicabile
- evitare API deprecate se esistono alternative stabili

## Regole WooCommerce
- dichiarare correttamente il supporto WooCommerce nel tema
- evitare override legacy non necessari
- preferire compatibilità tramite supporti, hook, markup e stili
- documentare ogni override WooCommerce e la motivazione
- garantire coerenza grafica per shop, archive prodotto, single product, cart, checkout, account, notices, form e tabelle

## Disciplina documentale
Prima di ogni task leggere:
- AGENTS.md
- docs/PROJECT_BRIEF.md
- docs/IMPLEMENTATION_LOG.md

Dopo ogni task completato:
1. aggiornare docs/IMPLEMENTATION_LOG.md
2. aggiornare docs/PROJECT_BRIEF.md se cambiano scope, assunzioni o architettura
3. riportare sempre:
   - file creati/modificati
   - decisioni prese
   - assunzioni
   - verifiche eseguite
   - TODO / rischi residui

## Modalità di lavoro
- analizzare prima il codice esistente
- fare modifiche mirate solo sul task richiesto
- evitare refactor fuori scope
- preservare il più possibile il design esistente
- quando una conversione 1:1 dal frontend statico a WordPress non è adatta, scegliere la soluzione più mantenibile e documentare il compromesso

## Convenzioni consigliate
Salvo diversa indicazione del repository, usare:
- slug tema: client-theme
- text domain: client-theme
- prefix funzioni: client_theme_
- cartelle organizzate come:
  - assets/
  - inc/
  - template-parts/
  - woocommerce/
  - docs/

## Cosa evitare
- trasformare il tema in block theme
- astrazioni eccessive
- dipendenze inutili
- framework pesanti senza richiesta esplicita
- logica business nei template
- architettura CSS duplicata o fragile
- override WooCommerce non giustificati
- regressioni di accessibilità
- decisioni non documentate

## Formato di completamento di ogni task
Alla fine di ogni task fornire sempre:
- Riepilogo
- File modificati
- Decisioni chiave
- Verifiche
- TODO / Rischi residui