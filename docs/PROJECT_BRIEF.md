# Project Brief

## Contesto
- Sito e-commerce custom per cliente
- Esiste già una base frontend statica
- Obiettivo: convertire in tema WordPress + WooCommerce

## Obiettivi principali
- Tema custom block-first
- Personalizzabile
- Accessibile
- SEO-friendly
- Mantenibile
- Coerente con standard WordPress/WooCommerce attuali

## Stato iniziale
- Esistono già: homepage statica, header, footer, menu, variabili di css
- Repository/branch di lavoro già creato

## Scope attuale
- Conversione frontend statico -> tema WP
- Integrazione WooCommerce
- Definizione design system nel tema
- Template base ecommerce
- QA tecnico

## Vincoli
- No page builder
- No dipendenze inutili
- Preferire native features WordPress/WooCommerce
- Ridurre al minimo codice fragile o legacy

## Architettura scelta
- Block theme
- theme.json v3
- template parts
- patterns
- CSS residuale minimo
- PHP minimo e solo se necessario

## Requisiti qualità
- WPCS
- WCAG 2.2 AA minimo
- Responsive
- Performance prudente
- Compatibilità plugin SEO
- Compatibilità WooCommerce blocks

## Decisioni aperte
- Nome definitivo tema
- Palette definitiva
- Font definitivi
- Necessità o meno di style variations
- Eventuali template custom shop/category/blog oltre ai base