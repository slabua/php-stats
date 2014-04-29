<?php   ////////////////////////////////////////////////
        //   ___ _  _ ___     ___ _____ _ _____ ___   //
        //  | _ \ || | _ \___/ __|_   _/_\_   _/ __|  //
        //  |  _/ __ |  _/___\__ \ | |/ _ \| | \__ \  //
        //  |_| |_||_|_|0.1.8|___/ |_/_/ \_\_| |___/  //
        //                                            //
      ///////////////////////////////////////////////////
      //   Author: Roberto Valsania (Webmaster76)      //
      //    Staff: Matrix, Viewsource, PaoDJ, Fabry    //
      // Homepage: www.php-stats.com,                  //
      //           www.php-stats.it,                   //
	  //           www.php-stat.com                    //              
      ///////////////////////////////////////////////////


//////////////////////
// CONFIGURAZIONE  //
/////////////////////
      $option['host']="localhost";                   // Indirizzo server MySQL o IP
  $option['database']="my_database";                 // Nome database
   $option['user_db']="database";                    // Utente
   $option['pass_db']="1234";                        // Password
$option['script_url']="http://tuosito.it/stats";     // Indirizzo di installazione di Php-Stats

////////////////////////
// VARIABILI AVANZATE //
////////////////////////
             $option['prefix']="php_stats";  // Prefisso per le tabelle di Php-Stats (default "php_stats")
		 $option['callviaimg']=0;   // 1 richiama Php-Stats attraverso immagine trasparente 1x1 pixel, 0 attraverso javascript
     $option['php_stats_safe']=0;   // 0 se avete MySQL 3.23 o superiore ; 1 per MySQL 3.22
       $option['out_compress']=1;   // 1 compressione dell'output (PHP>4.0.4)
    $option['persistent_conn']=0;   // 1 utilizza utilizza una connessione persistente a mysql
        $option['autorefresh']=3;   // In MINUTI, aggiornamento automatico pagine dell'admin // default 3
$option['show_server_details']=1;   // Visualizzati nella pagina principale
          $option['short_url']=1;   // Mostra url brevi quando possibile
	      $option['ext_whois']="";  // "http://www.yourwhois.com/adress?ip=%IP%"; %IP% verrà tradotto nell'IP numerico
     $option['online_timeout']=0;   // in minuti, 0 per conteggio dinamico // default 5
         $option['page_title']=1;   // 1 memorizza i titoli delle pagine
           $option['log_host']=1;   // 1 registra l'host tra i dettagli (WARNING:SLOW!) // default 0
        $option['clear_cache']=0;   // 1 ricoscimento cache continuo (WARNING:SLOW!)
	      $option['full_recn']=1;   // 1 motori e refers riconosciuti ad ogni pagina visitata (WARNING:SLOW!) // default 0
          $option['logerrors']=0;   // 1 registra gli errori nel file php-stats.log (deve avere i permessi in scrittura)
          $option['www_trunc']=0;   // Trasforma http://www. in http:// per evitare di avere la stessa pagina monitorata 2 volte
                $default_pages=array("/","/index.htm","/index.html","/default.htm","/index.asp","/index.php"); // Pagine di default del server, troncate considerate come la stessa
	  
//////////////////////
// OPZIONI SPECIALI //
//////////////////////
            $option['ip-zone']=0;   // 1 usa il database degli IP per il riconoscimento dei paesi.
                                    // DEVE ESSERE INSTALLATO A PARTE!
           
/////////////////////////////////////////////////
// NON MODIFICARE NULLA DA QUESTO PUNTO IN POI //
/////////////////////////////////////////////////
if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
if(!isset($_SERVER)) $_SERVER=$HTTP_SERVER_VARS;
if(isset($_SERVER['HTTPS'])) if($_SERVER['HTTPS']=="on") $option['script_url']=str_replace("http:/","https:/",$option['script_url']);
if(substr($option['script_url'],-1)=="/") $option['script_url']=substr($option['script_url'],0,-1);
?>
