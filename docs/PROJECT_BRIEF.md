# Project Brief

## Tipo progetto
Tema custom e-commerce per WordPress + WooCommerce.

## Stato iniziale
Esiste già un frontend statico con:
- homepage
- header
- footer
- menu/navigazione
- variabili css ben definite

## Obiettivo principale
Convertire il frontend statico esistente in un tema custom WordPress + WooCommerce di tipo classic theme.

## Direzione architetturale
Classic theme moderno:
- template PHP
- template hierarchy standard WordPress
- theme.json per design token e impostazioni/stili globali dove utile
- CSS mantenibile
- JS minimo
- supporto WooCommerce con override ridotti al minimo

## Obiettivi principali
- conversione fedele del design statico
- alta manutenibilità
- buona personalizzazione nativa
- implementazione attenta ad accessibilità
- base tecnica SEO solida
- compatibilità WooCommerce
- documentazione chiara per sviluppo futuro

## Vincoli
- no page builder
- no block theme / no full site editing
- no dipendenze inutili
- no logica business nel tema
- override WooCommerce legacy solo se realmente necessari
- preferire meccanismi nativi WordPress e WooCommerce

## Qualità attesa
- HTML semantico
- layout responsive
- navigazione e form accessibili
- focus states visibili
- gerarchia titoli coerente
- tema pronto per traduzioni
- best practice WordPress
- organizzazione asset scalabile

## File documentali
- AGENTS.md = regole operative stabili per Codex
- docs/PROJECT_BRIEF.md = brief funzionale e tecnico
- docs/IMPLEMENTATION_LOG.md = log cronologico delle implementazioni

## Decisioni aperte
- slug finale del tema se diverso da client-theme
- necessità o meno di opzioni Customizer aggiuntive
- politica definitiva sugli override WooCommerce dopo la prima integrazione