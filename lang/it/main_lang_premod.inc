<?php
// MENU DI AMMINISTRAZIONE
$admin_menu['main']="Sommario";
$admin_menu['reso']="Risoluzione e Colori";
$admin_menu['os_browser']="Os e Browser";
$admin_menu['systems']="Sistemi";
$admin_menu['pages']="Pagine visitate";
$admin_menu['percorsi']="Percorsi di visita";
$admin_menu['time_pages']="Tempi permanenza";
$admin_menu['referer']="Referer esterni";
$admin_menu['engines']="Motori di ricerca";
$admin_menu['query']="Query ai motori";
$admin_menu['searched_words']="Parole cercate";
$admin_menu['details']="Dettagli visitatori";
$admin_menu['ip']="Indirizzi IP";
$admin_menu['lang']="Lingue";
$admin_menu['backup']="Backup/Ripristino";
$admin_menu['restore']="Ripristina Database";
$admin_menu['hourly']="Accessi per ora";
$admin_menu['daily']="Ultimi 30 giorni";
$admin_menu['weekly']="Accessi per giorno";
$admin_menu['monthly']="Accessi per mese";
$admin_menu['calendar']="Calendario accessi";
$admin_menu['compare']="Confronta mesi";
$admin_menu['country']="Paesi";
$admin_menu['downloads']="Downloads";
$admin_menu['clicks']="Clicks";
$admin_menu['reset']="Azzera statistiche";
$admin_menu['options']="Opzioni";
$admin_menu['esclusioni']="Esclusioni";
$admin_menu['optimize_tables']="Ottimizza tabelle";
$admin_menu['downadmin']="Downloads Admin";
$admin_menu['clicksadmin']="Clicks Admin";
$admin_menu['login']="<b>Login</b>";
$admin_menu['logout']="<b>Logout</b>";
$admin_menu['trend']="Previsione accessi";
$admin_menu['errorlogviewer']="Visualizza error-log";
// Voci di menu addizionali
$admin_menu['menu_general']="Generale";
$admin_menu['menu_sistems']="Sistemi";
$admin_menu['menu_engines']="Motori";
$admin_menu['menu_stats']="Statistiche";
$admin_menu['menu_others']="Varie";
$admin_menu['menu_options']="Opzioni";

// VOCI GENERALI
$string['error']="<b>ERRORE<b>";
$string['error_title']="Errore";
$string['warning']="<b>ATTENZIONE</b>";
$string['information']="<b>Informazione</b>";
$string['visite']="Visitatori";
$string['hits']="Pagine visitate";
$string['unknown']="Unknown";
$string['insert_pass']="Inserire la password:";
$string['login']="Login";
$string['login_title']="Login";
$string['logout']="Logout";
$string['logout_title']="Logout";
$string['logout_done']="<b>Log-out effettuato.</b>";
$string['mode']="Mostra per <b>%tipo%</b>.";
$string['forgot_pass']="Dimenticato la password?";
$string['forgot_pass_js_confirm']="Procedo con l\'invio della nuova password?";
$string['mail_sent_title']="Invio nuova password";
$string['mail_subject']="Richiesta nuova password per Php-Stats";
$string['mail_sent']="La mail con la nuova password è stata inviata.<br>Essa non sarà attiva fino a che non verrà confermata.<br><br>Leggere la mail per ulteriori spiegazioni.";
$string['mail_error']="Impossibile inviare la mail con la nuova password, invio fallito.";
$string['new_pass_activ_title']="Attivazione nuova password";
$string['new_pass_activ']="La nuova password inviata nella mail è ora attiva.";
$string['new_pass_error']="La chiave di attivazione non è valida. La nuova password non è stata attivata.";
$string['go']="Go!";
$string['search']="Cerca";
$string['printable']="Mostra una versione adatta alla stampa";
$string['gen_on']="Generato da %php-stats-ver% il %data%.";

// Main page
$string['main_title']="Sommario";
$string['db_status']="<b>Database Status</b>";
$string['table_name']="Tabella";
$string['db_status_size']="Dimensione";
$string['db_status_recs']="Records";
$string['main_online_title']="<b>Dettagli degli utenti attualmente online</b>";
$string['main_online_ip']="IP";
$string['main_online_url']="Pagina corrente";
$string['main_online_time']="Ora";
$string['main_online_tracking']="T";
$string['main_sysinfo_title']="Server info";
$string['main_server_ws']="Webserver";
$string['main_server_os']="Sistema Operativo";
$string['main_server_php']="Versione Php";
$string['main_no_mysql_ver']="?";
$string['main_mysql_ver']="Versione MySQL";
$string['main_track_alt']="Visualizza tutte le pagine visitate da questo utente";
$string['main_max_ol']="Record massimo utenti online:<br>(%DATA% alle %ORA%)";
$string['max_hits']="Giorno con più pagine viste (%NUM%)";
$string['min_hits']="Giorno con meno pagine viste (%NUM%)";
$string['sommario']="Riepilogo generale";
$string['db_size']="Spazio utilizzato: ";
$string['hits_tot']="<b>Pagine visitate totali</b>";
$string['visitors_tot']="<b>Visitatori totali</b>";
$string['main_tot_referer']="Visitatori provenienti da siti esterni";
$string['main_tot_engine']="Visitatori provenienti da motori di ricerca";
$string['hits_oggi']="<b>Pagine visitate di oggi</b>";
$string['visitors_oggi']="<b>Visitatori di oggi</b>";
$string['hits_ieri']="Pagine visitate di ieri";
$string['visitors_ieri']="Visitatori di ieri";
$string['hits_qm']="Pagine visitate di questo mese";
$string['visitors_qm']="Visitatori di questo mese";
$string['hits_sm']="Pagine visitate dello scorso mese";
$string['visitors_sm']="Visitatori dello scorso mese";
$string['hits_qa']="Pagine visitate nel %THIS_YEAR%";
$string['visitors_qa']="Visitatori nel %THIS_YEAR%";
$string['perm_site']="Permanenza media sul sito";
$string['perm_page']="Permanenza media a pagina";
$string['usr_online']="<b>Utenti attualmente online</b>";
$string['hits_per_day']="Pagine visitate giornaliere (media)";
$string['visits_per_day']="Visitatori giornalieri (media)";
$string['pages_per_day']="Pagine viste per visitatore";
$string['stats_start']="Statistiche iniziate il";

// Details page
$string['details_title']="Dettagli visitatori";
$string['details_os']="Sistema operativo";
$string['details_browser']="Browser";
$string['details_reso']="Risoluzione";
$string['details_ip']="IP";
$string['details_lang']="Lingua:";
$string['details_country']="Paese:";
$string['details_server']="Host:";
$string['details_referer']="Referer:";
$string['details_ora']="Ora";
$string['details_pageviewed']="Pagine visitate [%VISITEDPAGES%]";
$string['details_query']="Query:";
$string['details_down']="<i>Download: <b>%NAME%</b></i>";
$string['details_down_err']="<i>Errore: l'id %ID% non risulta tra i download!</i>";
$string['details_click']="<i>Click: <b>%NAME%</b></i>";
$string['details_click_err']="<i>Errore: l'id %ID% non risulta tra i click!</i>";

// Browser and os page
$string['os_browser_title']="Sistemi Operativi e Browsers";
$string['os_browser_title_2']="Sistemi Operativi e Browsers (%MESE% %ANNO%)";
$string['browser_title']="Browsers";
$string['browser_title_2']="Browsers (%MESE% %ANNO%)";
$string['browser_bw']="Browser";
$string['browser_hits']="Accessi";
$string['browser_unknown']="Altri";
$string['os_title']="Sistemi Operativi";
$string['os_title_2']="Sistemi Operativi (%MESE% %ANNO%)";
$string['os_os']="Sistema operativo";
$string['os_hits']="Accessi";
$string['os_unknown']="Altri";
$string['os_vis_mens']="Visualizza suddividendo in base ai mesi";
$string['os_vis_glob']="Visualizza tutti, senza suddividere per mese";

// Reso page
$string['reso_colo_title']="Risoluzioni e profondità di colore";
$string['reso_colo_title_2']="Risoluzioni e profondità di colore (%MESE% %ANNO%)";
$string['reso_title']="Risoluzioni";
$string['reso_title_2']="Risoluzioni (%MESE% %ANNO%)";
$string['reso_reso']="Risoluzione";
$string['reso_hits']="Accessi";
$string['reso_altre']="Altre risoluzioni";
$string['colo_title']="Profondità di colore";
$string['colo_title_2']="Profondità di colore (%MESE% %ANNO%)";
$string['colo_colo']="Profondità";
$string['colo_hits']="Accessi";
$string['reso_vis_mens']="Visualizza in base ai mesi";
$string['reso_vis_glob']="Visualizza tutti";

// Systems Page
$string['systems_title']="Sistemi: Top 50";
$string['systems_title_2']="Sistemi: Top 50 (%MESE% %ANNO%)";
$string['systems_os']="Sistema operativo";
$string['systems_bw']="Browser";
$string['systems_reso']="Risoluzione";
$string['systems_colo']="Colori";

// Pagine
$string['pages_title']="Pagine visitate";
$string['pages_page']="Pagina";
$string['pages_hits']="Accessi";
$string['pages_perc']="%";
$string['pages_in']="In";
$string['pages_out']="Out";
$string['pages_io']="I-O";
$string['pages_tracking']="T";
$string['pages_tracking_alt']="Visualizza gli ultimi accessi a questa pagina";
$string['no_pages']="Spiacente, nessun risultato trovato con questi termini di ricerca.";
$string['pages_results']="Termini cercati: \"<b>%query%</b>\". Trovati <b>%trovati%</b> risultati.";

// Percorsi di visita
$string['percorsi_title']="Percorsi di visita";
$string['percorsi_lev_1']="Pagina di ingresso al sito";
$string['percorsi_lev_2']="Seconda pagina visitata";
$string['percorsi_lev_3']="Terza pagina visitata";
$string['percorsi_lev_4']="Quarta pagina visitata";
$string['percorsi_lev_5']="Quinta pagina visitata";
$string['percorsi_lev_6']="Sesta pagina visitata";
$string['percorsi_outs']="Ultima pagina visitata (pagina di uscita dal sito)";
$string['percorsi_prob']="Ricorrenza";
$string['percorsi_hits']="Visite";
$string['percorsi_altre']="-<br>-<br>-<br><br>";
$string['percorsi_noresult']="Spiacente, nessuna pagina disponibile per la determinazione dei percorsi di visita";

// Time online
$string['time_pages_title']="Tempi di permanenza medi sulle pagine";
$string['time_pages_url']="Indirizzo";
$string['time_pages_perm']="Permanenza";
$string['time_pages_tot']="Totale";

// Refers
$string['refers_title']="Referer esterni";
$string['refers_title_2']="Referer esterni (%MESE% %ANNO%)";
$string['refers_group_title']="Referers esterni raggruppati per dominio";
$string['refers_group_title_2']="Referers esterni raggruppati per dominio (%MESE% %ANNO%)";
$string['refers_url']="Url";
$string['refers_date']="Ultimo accesso";
$string['refers_hits']="Accessi";
$string['refers_tracking']="T";
$string['refers_url_1']="Dominio";
$string['refers_date_1']="Ultimo accesso";
$string['refers_hits_1']="Accessi";
$string['refers_mode_0']="Visualizza i referers senza raggrupparli per domini";
$string['refers_mode_1']="Visualizza i referers raggruppadoli per domini";
$string['refers_alt_1']="Visualizza la cronologia di questo referer\n(La cronologia è tratta dai dettagli)";
$string['refers_alt_2']="Visualizza tutti i referers di questo dominio";
$string['alt_visitlink']="Visualizza l'url originaria del reffer";

// Search engines
$string['se_title']="Motori di ricerca";
$string['se_title_2']="Motori di ricerca (%MESE% %ANNO%)";
$string['se_name']="Motore";
$string['se_hits']="Accessi";
$string['se_query']="Query";
$string['se_details']="<b>Dettagli:</b>";
$string['se_expand_alt']="Visulizza le query di questo motore";
$string['se_collapse_alt']="Togli i dettagli sulle query di questo motore";

// Query ai motori
$string['query_title']="Query ai motori di ricerca";
$string['query_title_2']="Query ai motori di ricerca (%MESE% %ANNO%)";
$string['query_mode_1']="Visualizza dividendolo le query per motore di ricerca";
$string['query_mode_2']="Visualizza senza dividere le query per motore di ricerca";
$string['query']="Query";
$string['query_hits']="Accessi";
$string['query_engine']="Motore";
$string['query_vis_mens']="Visualizza suddividendo le query per mesi";
$string['query_vis_glob']="Togli la visualizzazione per mesi";
$string['query_last_m']="Scorso mese: %HITS% accessi";
$string['query_last_v']="Variazione: %VARIAZIONE%";
$string['query_details']="<b>Dettagli:</b>";
$string['query_expand_alt']="Visualizza i motori a cui è stata effettuata la query";
$string['query_collapse_alt']="Non visualizzare i motori a cui è stata effettuata la query";

// Parole cercate
$string['searched_words_title']="Parole più cercate ai motori di ricerca";
$string['searched_words_title_2']="Parole più cercate ai motori di ricerca (%MESE% %ANNO%)";
$string['searched_words_query_vis_mens']="Visualizza suddividendo le parole cercate per mesi";
$string['searched_words_query_vis_glob']="Togli la visualizzazione per mesi delle parole cercate";
$string['searched_words_last_m']="Scorso mese: %HITS%";
$string['searched_words_last_v']="Variazione: %VARIAZIONE%";

// Hourly
$string['hourly_title']="Accessi per ora di visita";
$string['hourly_title_2']="Accessi per ora di visita (%MESE% %ANNO%)";

// Weekly
$string['weekly_title']="Accessi per giorno della settimana";
$string['weekly_title_2']="Accessi per giorno della settimana (%MESE% %ANNO%)";
$string['weekly_day']="Giorno";
$string['weekly_hits']="Accessi";
$string['weekly_vis_mens']="Visualizza suddividendo in base ai mesi";
$string['weekly_vis_glob']="Visualizza tutti, senza suddividere per mese";

// Daily
$string['daily_title']="Accessi degli ultimi 30 giorni";

// Ultimi 12 mesi
$string['monthly_title']="Accessi degli ultimi 12 mesi";
$string['monthly_nome']="Mese";
$string['monthly_hits']="Accessi";

// Calendar
$string['calendar_title']="Calendario accessi";
$string['calendar_view']="Visualizza:";
$string['calendar_last']="Ultimi 12 mesi";
$string['calendar_day_total']="Tot.";
$string['calendar_day_worst']="Min";
$string['calendar_day_best']="Max";
$string['calendar_day_average']="Media";

// COMPARE
$string['compare_title']="Confronto mesi";
$string['compare_comp']="Confronta ";
$string['compare_with']=" con ";
$string['compare_access']="Confronto pagine visitate";
$string['compare_visits']="Confronto visitatori";
$string['compare_both']="Confronto generale";
$string['compare_hits']="Accessi";
$string['compare_visites']="Visite";
$string['compare_total']="Totali";

// IP
$string['ip_title']="Indirizzi IP";
$string['ip']="IP";
$string['ip_last_visit']="Ultimo accesso";
$string['ip_visite']="Visitatori";
$string['ip_hits']="Pagine";
$string['ip_tracking']="T";

// Paesi di provenienza
$string['continent_title']="Continenti di provenienza dei visitatori";
$string['country_title']="Paesi di provenienza dei visitatori";
$string['country']="Paese";
$string['country_hits']="Pagine visitate";
$string['country_visits']="Visitatori";

// Lingue
$string['bw_lang_title']="Lingue dei browser";
$string['bw_lang']="Lingua";
$string['bw_lang_hits']="Pagine visitate";
$string['bw_lang_visits']="Visitatori";

// TREND
$string['trend_title']="Previsioni accessi";
$string['trend_day']="<b>Giorno</b>";
$string['trend_hits']="<b>Pagine visitate</b>";
$string['trend_visits']="<b>Visitatori</b>";
$string['trend_nodaily']="<b>Spiacente, per la previsione sono necessari almeno 31 giorni di campione.</b>";

// Optimization
$string['optm_title']="Ottimizzazione tabelle";
$string['optm_ok']="<b>Le tabelle sono state ottimizzate correttamente!</b>";
$string['optm_er']="<b>Le tabelle non sono state ottimizzate correttamente a causa di un errore.</b>";

// REFRESH
$string['refr_title']="Riconoscimento referers in Motori di ricerca";
$string['refr_summary']="Analizzati %analizzati% referer (di cui %rimossi% spostati)";
$string['refr_next']="Analisi prossimi %HOWMANY% referers tra 5 secondi (<a href=\"%URL%\">oppure clicca qui</a>)";
$string['refr_end']="Fatto.";
$string['refr_err']="Errore spostando:";

// EXCLUSIONS
$string['esclude_title']="Esclusioni dalle statistiche";
$string['esclude_subtitle']="<b>Esclusione tramite cookie</b>";
$string['esclude_status_of']="Questo PC è attualmente <b>incluso</b> nelle statistiche.";
$string['esclude_status_on']="Questo PC è attualmente <b>escluso</b> dalle statistiche.";
$string['esclude_esc']="Clicca per escludere";
$string['esclude_inc']="Clicca per includere";

// Reset page
$string['reset_title']="Reset statistiche";
$string['reset_done']="<b>Reset effettuato.</b>";
$string['reset_err']="<b>ATTENZIONE:</b> nessun campo da resettare selezionato!";
$string['reset_selall']="Seleziona tutti";
$string['reset_desall']="Deseleziona tutti";
$string['reset_01']="Contatori generali";
$string['reset_02']="Dettagli visitatori";
$string['reset_03']="Sistemi Operativi,Browsers,Risoluzioni e Colori";
$string['reset_04']="Lingue";
$string['reset_05']="Pagine visitate";
$string['reset_06']="Tempi di permanenza";
$string['reset_07']="Referers";
$string['reset_08']="Motori di ricerca";
$string['reset_09']="Query ai motori di ricerca";
$string['reset_10']="Statistiche orarie";
$string['reset_11']="Paesi";
$string['reset_12']="Accessi giornalieri";
$string['reset_13']="IP";
$string['reset_14']="Record utenti online";
$string['reset_30']="Downloads";
$string['reset_31']="Clicks";
$string['reset_do']="Esegui reset";

// Downloads
$string['link_ok']="Ok";
$string['link_broken']="Link non valido!";
$string['down_elenco_id']="id";
$string['down_elenco_name']="Nome";
$string['down_elenco_url']="Percorso";
$string['down_elenco_n']="Downloads";
$string['down_elenco_status']="S";
$string['down_edit']="Modifica";
$string['down_del']="Cancella";
$string['down_id']="id del download:";
$string['down_name']="Nome:";
$string['down_url']="Percorso:";
$string['down_status']="Stato:";
$string['down_date']="Data di creazione:";
$string['down_title']="Dwnloads";
$string['down_admin_title']="Amministrazione downloads";
$string['down_title_edit']="Modifica download con id=%id%";
$string['down_title_new']="Aggiungi nuovo download";
$string['down_title_summary']="<b>Riepilogo:</b>";
$string['down_salva']="Salva";
$string['down_edit_ok']="<b>Modifiche apportate con successo.</b>";
$string['down_new_ok']="<b>Inserimento avvenuto con successo. Vedi il riepilo per i dettagli.</b>";
$string['down_delete_ok']="<b>Download cancellato con successo.</b>";
$string['down_codescript']="Codice html da inserire nelle pagine";
$string['down_downcli']="Clicca sull'id di un download per ottenere un esempio di codice.";
$string['down_js_confirm']="Cancello download con id=%id% ?";

// Clicks
$string['click_stats_disabled']="<center><br><br>Spiacenti, ma il servizio è temporameamente in manutenzione.<br><br>Per favore, riprovate tra qualche minuto.</center>";
$string['link_ok']="Ok";
$string['link_broken']="Link non valido!";
$string['click_elenco_id']="id";
$string['click_elenco_name']="Nome";
$string['click_elenco_url']="Percorso";
$string['click_elenco_n']="clicks";
$string['click_elenco_status']="S";
$string['click_edit']="Modifica";
$string['click_del']="Cancella";
$string['click_id']="id del \"click\" da monitorare:";
$string['click_name']="Nome:";
$string['click_url']="Percorso:";
$string['click_status']="Stato:";
$string['click_date']="Data di creazione:";
$string['click_title']="Clicks";
$string['click_admin_title']="Amministrazione \"clicks\"";
$string['click_title_edit']="Modifica \"click\" con id=%id%";
$string['click_title_new']="Aggiungi nuovo \"click\"";
$string['click_title_summary']="<b>Riepilogo:</b>";
$string['click_salva']="Salva";
$string['click_edit_ok']="<b>Modifiche apportate con successo.</b>";
$string['click_new_ok']="<b>Inserimento avvenuto con successo.</b>";
$string['click_delete_ok']="<b>\"click\" cancellato con successo.</b>";
$string['click_codescript']="Codice html da inserire nelle pagine";
$string['click_downcli']="Clicca sull'id di un \"click\" per ottenere un esempio di codice.";
$string['click_js_confirm']="Cancello click con id=%id% ?";

// Backup-Ripristino
$string['backup_title']="Backup/Ripristino";
$string['backup_backup']="<b>Backup Database</b>";
$string['backup_cmp']="Compresso";
$string['backup_mode']="Tipo di BackUp";
$string['backup_mode_1']="Struttura e Dati";
$string['backup_mode_2']="Solo Struttura";
$string['backup_backup_go']="Avvia Backup Database";
$string['backup_restore']="<b>Ripristino Database</b>";
$string['backup_restore_desc']="Clicca su sfoglia ed allega il file compresso o sql per il ripristino";
$string['backup_restore_go']="Avvia Ripristino Database";
$string['backup_restore_success']="<b>Ripristino avvenuto con successo.</b>";
$string['backup_restore_failure']="<b>ERRORE</b>: Il ripristino non è avvenuto: sono presenti errori nel file.</b>";
$string['backup_restore_diffver']="<b>ERRORE</b>: Il file specificato non è un file di backup ritenuto valido.<br>E' possibile che sia un backup di una versione di Php-Stats diversa da quella installata.";

// ERRORI
$error['reso']="<b>Spiacente, nessun dato relativo alle risoluzioni presente.</b>";
$error['reso_2']="<b>Spiacente, nessun dato relativo alle risoluzioni presente nel mese di %MESE% %ANNO%.</b>";
$error['details']="<b>Spiacente, nessun data relativo ai dettagli presente.</b>";
$error['os_bw']="<b>Spiacente, nessun dato relativo a sistemi operativi e browser presente.</b>";
$error['os_bw_2']="<b>Spiacente, nessun dato relativo a sistemi operativi e browser presente nel mese di %MESE% %ANNO%.</b>";
$error['pages']="<b>Spiacente, nessuna pagina visitata presente.</b>";
$error['referer']="<b>Spiacente, nessun referer esterno al sito presente.</b>";
$error['referer_2']="<b>Spiacente, nessun referer esterno al sito presente nel mese di %MESE% %ANNO%.</b>";
$error['engines']="<b>Spiacente, nessun motore di ricerca riconosciuto.</b>";
$error['engines_2']="<b>Spiacente, nessun motore di ricerca riconosciuto nel mese di %MESE% %ANNO%.</b>";
$error['query']="<b>Spiacente, nessuna query ai motori di ricerca riconosciuta.</b>";
$error['query_2']="<b>Spiacente, nessuna query ai motori di ricerca riconosciuta nel mese di %MESE% %ANNO%.</b>";
$error['searched_words']="<b>Spiacente, non è possibile elencare nessuna parola cercata ai motori di ricerca.</b>";
$error['searched_words_2']="<b>Spiacente, non è possibile elencare nessuna parola cercata ai motori di ricerca nel mese di %MESE% %ANNO%.</b>";
$error['bad_pwd']="<b>ATTENZIONE: password non valida!</b>";
$error['bw_lang_none']="<b>Spiacente, nessun dato presente nel database sulle lingue.</b>";
$error['country']="<b>Spiacente, nessun dato relativo ai peasi di provenienza memorizzato.</b>";
$error['downloads']="<b>Spiacente, nessun download monitorato al momento.</b>";
$error['clicks']="<b>Spiacente, nessun \"click\" monitorato al momento.</b>";
$error['ip']="<b>Spiacente, nessun IP memorizzato al momento</b>";
$error['pref_01']="<b>La password non è confermata.</b>";
$error['pref_02']="<b>Il valore immesso per la memorizzazione dei dettagli contiene caratteri non validi.</b>";
$error['pref_03']="<b>Il valore immesso per il limite dei records contiene caratteri non validi.</b>";
$error['pref_04']="<b>Il valore immesso per il numero di pagine visitate iniziale contiene caratteri non validi.</b>";
$error['pref_05']="<b>Il valore immesso per il numero di visitatori iniziale contiene caratteri non validi.</b>";
$error['pref_06']="<b>Il valore immesso per il timeout contiene caratteri non validi.</b>";
$error['pref_07']="<b>Il valore immesso per il numero di hits per l'auto-ottimizzazione delle tabelle contiene caratteri non validi.</b>";

// FATAL ERRORS
$error['critical_err']="<b>Impossibile visualizzare la funzione richiesta.</b>";
$error['no_connection']="ERRORE: impossibile effettuare la connessione al database.";
$error['file_down']="<b>ERRORE</b>: il file ['<b>%filename%</b>'] non è disponibile al download.";
$error['click_down']="<b>ERRORE</b>: l'url ['<b>%filename%</b>'] non è momentaneamente disponibile.";
$error['down_noid']="<b>Nessun download associato a questo id.</b>";
$error['down_errs_id']="<B>ERRORE:</B> L'id può solo essere un campo numerico.";
$error['click_noid']="<b>Nessun click da monitorare associato a questo id</b>";
$error['click_errs_id']="<B>ERRORE:</B> L'id può solo essere un campo numerico.";
$error['down_url']="<b>L'url del download non può essere vuoto.</b>";
$error['click_url']="<b>L'url del click non può essere vuoto.</b>";
$error['down_no_update']="<b>Nessuna modica apportata!</b>";
$error['click_no_update']="<b>Nessuna modica apportata!</b>";
$error['down_no_delete']="<b>Impossibile cancellare il download con id=%id% .";
$error['click_no_delete']="<b>Impossibile cancellare il click con id=%id% .";
$error['error_decl']="<b>Errore MySQL:</b> %error%";
$error['upload_01']="<b>ERRORE:</b> File non specificato o Impossibile effettuare l'upload del file.";
$error['upload_02']="<b>ERRORE:</b> Il file non è stato trovato sul server, probabile upload fallito.<br>Controllare che la dimensione del file sia inferiore di quella consentita.";
$error['upload_03']="<b>ERRORE:</b> Il file non è stato riconosciuto come formato valido.<br>Assicurarsi che il file abbia estensioni <b>.sql</b> oppure <b>.gz</b>.";
$error['upload_04']="<b>ERRORE:</b> Impossibile decomprimere il file. E' possibile che le librerie zlib non siano disponibili";

// OPTIONS
$pref['opzioni']="Opzioni generali";
$pref['stats_disabled']="Stato monitoraggio:";
$pref['stats_disabled_yes']="Monitoraggio NON Attivo";
$pref['stats_disabled_no']="Monitoraggio Attivo";
$pref['lang']="Lingua predefinita:";
$pref['view']="Nelle pagine mostra:";
$pref['view_1']="Nulla";
$pref['view_2']="Visite";
$pref['view_3']="Accessi";
$pref['cifre_1']="Numero di cifre minimo (default):";
$pref['cifre_2']="(solo per il contatore grafico)";
$pref['style_1']="Stile del contatore (default):";
$pref['style_2']="0123456789  <b>(Modalità testuale)</b>";
$pref['style_edit']="[Cambia stile]";
$pref['popup_select_tit']="Stili disponibili";
$pref['pass_1']="Nuova Password:";
$pref['pass_2']=" (solo se si desidera cambiarla)";
$pref['pass_3']="Ridigita Password:";
$pref['use_pass']="Proteggi le statistiche:";
$pref['zone_1']="Timezone:";
$pref['zone_2']=" (utile se il server ha fuso orario diverso)";
$pref['site_name']="Nome del sito:";
$pref['site_url']="Url del sito:<br>(uno per linea, max 255 caratteri totali)";
$pref['script_url']="Url dello script:";
$pref['template']="Skin:";
$pref['si']="Si";
$pref['no']="No";
$pref['salva']="Applica";
$pref['back']="Indietro";
$pref['done']="<b>Modifiche apportate con successo.</b>";
$pref['not_done']="<b>ATTENZIONE: Nessuna modifica apportata!</b>";
$pref['startvisits']="Numero visitatori di partenza";
$pref['starthits']="Numero pagine visitate di partenza";
$pref['submitcode']="Genera Codice (e anteprima)";
$pref['last_visit']="Ultima Visita";
$pref['moduli_desc']="Attiva monitoraggio:";
$pref['moduli_0']="Dettagli";
$pref['moduli_1']="Info sul client (Browser,OS,Risoluzione,Colori)";
$pref['moduli_1_m']="Attiva suddivisione mensile";
$pref['moduli_2']="Lingua del browser";
$pref['moduli_3']="Pagine visitate, tempo di permanenza e utenti on-line";
$pref['moduli_3_m']="Memorizza il record massimo degli utenti on-line";
$pref['moduli_4']="Referer e Motori di ricerca";
$pref['moduli_4_m']="Attiva suddivisione mensile";
$pref['moduli_5']="Visite orarie";
$pref['moduli_5_m']="Attiva suddivisione mensile";
$pref['moduli_6']="Visite giornaliere/mensili";
$pref['moduli_7']="Paesi di provenienza";
$pref['moduli_8']="Downloads";
$pref['moduli_9']="Clicks";
$pref['moduli_10']="IP";
$pref['user_mail']="Indirizzo e-mail:";
$pref['pruning']="Limitazioni database";
$pref['prune_0']="Memorizza i dettagli per %value% ore.";
$pref['prune_1']="Limita tabella <b>%table_prefix%_details</b> a %value% records.";
$pref['prune_2']="Limita tabella <b>%table_prefix%_ip</b> a %value% records.";
$pref['prune_3']="Limita tabella <b>%table_prefix%_query</b> a %value% records.";
$pref['prune_4']="Limita tabella <b>%table_prefix%_pages</b> a %value% records.";
$pref['prune_5']="Limita tabella <b>%table_prefix%_referer</b> a %value% records.";
$pref['auto_optimize']="Ottimizza automaticamente le tabelle ogni %HITS% hits.";
$pref['timeout']="Timeout:";
$pref['ip_timeout']="Timeout per considerare un IP come unico: %value% (ore)";
$pref['page_timeout']="Timeout di permanenza sulle pagine: %value% (secondi)";
$pref['report_title']="Report delle statistiche";
$pref['report_desc']="Invia un report riassuntivo settimanale ogni: %day%";
$pref['main_codescript']="Script da inserire nelle pagine per attivarne il monitoraggio";
$pref['codescript']="Script da inserire nelle pagine per visualizzare le informazioni selezionate";
$pref['cs_view_0']="Visitatori on-line";
$pref['cs_view_1']="Visitatori del giorno corrente";
$pref['cs_view_2']="Pagine visitate del giorno corrente";
$pref['cs_view_3']="Visitatori totali";
$pref['cs_view_4']="Pagine visitate totali";
$pref['cs_mode']="Cosa vuoi visualizzare?";
$pref['cs_style']="Con quale stile?";
$pref['cs_style_defalut']="Default";
$pref['cs_style_view']="[ visualizza tutti gli stili disponibili ]";
$pref['cs_digits']="Numero (minimo) di cifre visualizzate?";
$pref['cs_digits_default']="Default";
$pref['preview_code']="Anteprima:";
$pref['refresh']="Riconoscimento motori di ricerca dai referers";
$pref['refresh_desc']="Utilizzare questa funzione se avete cambiato il file delle definizioni dei motori di ricerca.<br><b>ATTENZIONE</b>: l'operazione non può essere annullata.";
$pref['refresh_go']="Esegui riconoscimento";

// VARIE
$varie['page_time']="Pagina creata in %TOTALTIME% secondi";
$varie['server_time']="Server timestamp %SERVER_TIME%";
$varie['date_format']="%day% %mount% %year%";    // 13 Agosto 2002
$varie['date_format_2']="%mount% %year%";
$varie['date_format_3']="%day%/%mount%/%year%"; // compact mode 
$varie['perm_format']="%minutes%m:%seconds%s";
$varie['perm_format_2']="%hours%h:%minutes%m:%seconds%s";
$varie['time_format']="H:i:s"; // PHP date() format
$varie['days']=array("Domenica","Lunedi","Martedi","Mercoledi","Giovedi","Venerdi","Sabato");
$varie['mounts']=array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
$varie['mounts_1']=array("Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic");
$varie['pag_x_y']="Pagina <b>%current%</b> di <b>%total%</b>";
$varie['next']="[Avanti &gt;&gt;]";
$varie['prev']="[&lt;&lt; Indietro]";

// TRACKING
$tracking['title']="Data Tracking";
$tracking['pages']="<b>Cronologia degli ultimi accessi per la pagina:<br>%url%</b>";
$tracking['pages_date']="Data";
$tracking['pages_time']="Ora";
$tracking['pages_ip']="IP";
$tracking['online']="<b>Altre pagine visitate per l'utente online con IP %IP%</b><br>";
$tracking['online_time']="Ora";
$tracking['online_url']="Pagina visitata";
$tracking['online_err_nonoline']="<b>Spiacente</b>: Nessun utente con questo IP risulta essere online.<br>Probabilmente l'utente non sta più visitando il sito.";
$tracking['online_err_nopage']="<b>Spiacente</b>: Nessuna pagina visitata è stata trovata per questo IP.";
$tracking['referer']="<b>Cronologia degli ultimi accessi provenienti da<br>%URL%</b>";
$tracking['referer_date']="Data";
$tracking['referer_time']="Ora";
$tracking['referer_ip']="IP";
$tracking['total']="%total% risultati trovati.";
$tracking['fine']="<b>Fine tracking.</b>";
$tracking['noresult']="<b>Spiacente:</b> Nessun risultato.";
$tracking['domain_title']="<b>Rererers provenienti da %DOMAIN%</b>";
$tracking['domain_mese']="( Dati relativi a: <b>%MESE% %ANNO%</b> )";
$tracking['domain_url']="Pagina visitata";
$tracking['domain_hits']="Hits";
$tracking['domain_err_nopage']="<b>Spiacente</b>: Nessun referer per questo dominio.";
$tracking['close_window']="Chiudi questa finestra.";

// CLEAR CACHE
$string['clear_cache_title']="Riconoscimento dati in cache...";
$string['clear_cache_start']="<br><br>Riconoscimento in corso... attendere.";
$string['clear_cache_done']="Riconoscimento dati eseguito.";

// WHOIS
$string['whois_title']="Whois per l'IP: %IP%";
$string['whois_result']="<b>Risultati del whois:</b>";
$string['whois_connecting']="Connessione al server %SERVER%...<br><br>";
$string['whois_deferring']="Inoltro al server whois specifico: %SERVER%...<br><br>";
$string['whois_err_1']="Impossibile effettuare il whois, IP non specificato.";
$string['whois_err_2']="Time-out o errore di connessione al server %SERVER% (porta 43)";

// WRONG PASSWORD
$string['wrong_pass_title']="Password non valida";
$string['wrong_pass']="<b>ATTENZIONE: password non valida!</b>";

// TIPS
$string['tips_cache_refresh_1']="<b>Suggerimento:</b> Alcune informazioni di questa pagina non includono 1 dato presente nella cache non ancora riconosciuto in automatico.  Per riconoscere questo dato adesso, potete <a href=\"javascript:clearcache('clear_cache.php');\">cliccare qui</a>.";
$string['tips_cache_refresh_2']="<b>Suggerimento:</b> Alcune informazioni di questa pagina non includono %NUMCACHE% dati presenti nella cache non ancora riconosciuti in automatico.  Per riconoscere questi dati adesso, potete <a href=\"javascript:clearcache('clear_cache.php');\">cliccare qui</a>.";
$string['tips_update_availb']="<b>ATTENZIONE:</b> Nuova versione di Php-Stats disponibile, si consiglia di effettuare l'update al più presto.";

// ERRORLOG VIEWER
$string['viewerrlog_title']="Error-log viewer";
$string['viewerrlog_void']="<b>L'error-log è vuoto: nessun errore è occorso dall'ultimo reset.</b>";
$string['viewerrlog_nr']="L'error-log non è accessibile in lettura, non esiste o è corrotto.";
$string['viewerrlog_nw']="L'error-log è impostato in sola lettura.";
$string['viewerrlog_reset_error']="L'error-log non è accessibile in scrittura, non esiste o non è stato possibile crearlo.";
$string['viewerrlog_reset_done']="L'error-log è stato azzerato.";
$string['viewerrlog_reset']="Azzera l'error-log";

// COPYRIGHT
$string['copyright']="Powered by <a href=\"http://www.php-stats.com\">Php-Stats</a>";
?>