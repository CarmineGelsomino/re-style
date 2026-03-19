# AGENTS.md

## Obiettivo del repository
Convertire un frontend statico esistente in un tema custom WordPress + WooCommerce moderno, mantenibile, accessibile, SEO-friendly e personalizzabile, con approccio block-first.

## Versioni target
- WordPress target: 6.9.x stable
- WooCommerce target: 10.6.x stable
- Compatibilità forward-looking: evitare soluzioni fragili rispetto a WordPress 7.0
- Usare theme.json v3
- Non usare API deprecate se esistono alternative stabili

## Architettura richiesta
- Preferire block theme
- Preferire template HTML, template parts, patterns e theme.json
- Usare PHP solo dove realmente necessario
- Minimizzare override WooCommerce legacy
- Preferire integrazione con WooCommerce Blocks e global styles
- Separare chiaramente:
  - design tokens
  - layout
  - componenti/patterns
  - logica PHP minima
  - CSS residuale

## Personalizzazione
Il tema deve essere facilmente personalizzabile senza page builder.
Preferire:
- theme.json
- style variations se utili
- patterns
- block styles
- editor controls nativi
Evitare:
- pannelli admin custom inutili
- opzioni duplicate rispetto a Site Editor / block settings
- hardcode di contenuti nel tema

## Standard obbligatori
- WordPress Coding Standards
- sicurezza WordPress standard (escaping, sanitization, nonce dove serve)
- internazionalizzazione pronta
- accessibilità WCAG 2.2 AA minimo
- semantica HTML corretta
- keyboard navigation
- focus states visibili
- skip link / landmark quando applicabile
- responsive mobile-first
- performance prudente
- SEO tecnico di base corretto

## SEO / dati strutturati
Il tema deve:
- produrre markup semantico corretto
- rispettare gerarchia heading
- supportare bene immagini e alt text
- non ostacolare plugin SEO
- non duplicare funzioni da plugin SEO
- mantenere compatibilità con dati strutturati ecommerce/product/merchant listing quando i dati sono disponibili via WooCommerce/plugin

## Modalità di lavoro
Per ogni task:
1. leggere AGENTS.md + docs/PROJECT_BRIEF.md + docs/IMPLEMENTATION_LOG.md
2. analizzare il codice esistente prima di modificare
3. fare modifiche mirate solo al task richiesto
4. evitare refactor extra non richiesti
5. aggiornare sempre:
   - docs/IMPLEMENTATION_LOG.md
   - docs/PROJECT_BRIEF.md se cambiano assunzioni o requisiti
6. aggiungere una sezione "Verification" nel log con controlli eseguiti e limiti residui

## Regole di output
Quando completi un task:
- elenca file creati/modificati
- spiega decisioni architetturali prese
- segnala TODO o rischi residui
- indica come verificare manualmente
- non introdurre dipendenze nuove senza documentarle

## Tooling preferito
Se utile, configurare:
- Composer per PHPCS + WordPress Coding Standards + WPThemeReview
- Theme Check
- npm scripts solo se realmente necessari
- niente framework frontend pesanti salvo richiesta esplicita

## Convenzioni tema
Usare, salvo diversa indicazione:
- slug tema: client-theme
- text domain: client-theme
- namespace PHP coerente se introdotto
- naming consistente e leggibile

## Cosa evitare
- page builder
- funzioni duplicate di plugin noti
- logica business nel tema
- override WooCommerce superflui
- customizer/settings ridondanti rispetto a block theme
- markup non accessibile
- CSS non scalabile
- dipendenze non motivate