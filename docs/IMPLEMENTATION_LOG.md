# Implementation Log

## Regola di compilazione
Per ogni task aggiungere una nuova sezione con:
- Task ID
- Obiettivo
- File letti
- File creati/modificati
- Decisioni prese
- Assunzioni
- Verifiche
- TODO / Rischi residui

---

## T000

### Obiettivo
Analisi iniziale del repository e impostazione della documentazione base per lo sviluppo di un WordPress + WooCommerce classic theme moderno.

### File letti
- file presenti nella root del repository
- file del frontend statico esistente
- eventuali asset relativi a homepage, header, footer e menu

### File creati/modificati
- AGENTS.md
- docs/PROJECT_BRIEF.md
- docs/IMPLEMENTATION_LOG.md

### Decisioni prese
- il progetto sarà sviluppato come classic theme moderno
- theme.json verrà usato dove utile anche se il tema resta classic
- la compatibilità WooCommerce dovrà privilegiare supporti, hook e stili prima degli override template
- il lavoro verrà suddiviso in task piccoli per ridurre errori e mantenere coerenza

### Assunzioni
- il frontend statico è il riferimento visivo principale
- il branch corrente è dedicato a questa implementazione
- non devono essere introdotti page builder
- il cliente desidera personalizzazione senza passare a full site editing

### Verifiche
- file documentali creati
- direzione architetturale definita
- workflow a task pronto

### TODO / Rischi residui
- ispezionare la struttura reale del repository
- mappare i file statici verso template WordPress
- definire slug/text domain finali se diversi da client-theme
- identificare cosa richiede template PHP, template-parts e possibili override WooCommerce