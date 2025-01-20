# Ek Mappa dei talenti

**Versione:** 1.0  
**Autore:** Riccardo Pirani
**Descrizione:** Plugin per la gestione della mappa dei talenti. Questo plugin consente di visualizzare e gestire una mappa interattiva dei talenti in WordPress.

## Installazione

1. Scarica il file ZIP del plugin.
2. Carica il file nella cartella `wp-content/plugins/` del tuo sito WordPress.
3. Estrai il file ZIP.
4. Accedi al pannello di amministrazione di WordPress.
5. Vai su **Plugin** e attiva il plugin **Ek Mappa dei talenti**.

## Funzionalità

- **Attivazione e disattivazione del plugin**: Il plugin esegue una serie di azioni durante la sua attivazione e disattivazione tramite i rispettivi hook.
- **Gestione della mappa dei talenti**: Fornisce un'interfaccia per gestire e visualizzare la mappa dei talenti all'interno di WordPress.
- **Caricamento di file CSV**: Permette l'importazione di dati dalla mappa tramite file CSV.
- **Estensioni future**: Il plugin è progettato per essere estendibile, con la possibilità di aggiungere funzionalità aggiuntive.

## Uso

Il plugin non ha una configurazione specifica tramite l'interfaccia utente di WordPress. Dopo averlo attivato, eseguirà le operazioni di attivazione e disattivazione predefinite.

### Funzioni di attivazione

Il plugin esegue la funzione `ek_activation()` durante l'attivazione, che eseguirà il codice definito nel file `includes/class-activator.php`.

### Funzioni di disattivazione

Durante la disattivazione, il plugin esegue la funzione `ek_deactivation()`, che eseguirà il codice definito nel file `includes/class-deactivator.php`.

## Struttura del Plugin

Il plugin è organizzato nella seguente struttura di directory:
