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

// DEFINIZIONE VARIABILI PRINCIPALI
define('IN_PHPSTATS',true);

// VARIABILI ESTERNE
                                if(!isset($_COOKIE)) $_COOKIE=$HTTP_COOKIE_VARS;
          if(isset($_COOKIE['php_stats_esclusion'])) $php_stats_esclusion=$_COOKIE['php_stats_esclusion']; else $php_stats_esclusion=0;
                                if(!isset($_SERVER)) $_SERVER=$HTTP_SERVER_VARS;
                 if(isset($_SERVER['HTTP_REFERER'])) $HTTP_REFERER=$_SERVER['HTTP_REFERER'];
                  if(isset($_SERVER['REMOTE_ADDR'])) $ip=$_SERVER['REMOTE_ADDR'];
                                   if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
                          if(isset($_GET['NS_url'])) $NS_url=htmlspecialchars(addslashes(urldecode($_GET['NS_url']))); else $NS_url="";

// DETERMINO L'IP DI UTENTI DIETRO PROXY
if(isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])) 
  {
  $real_ip=$HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
  if(eregi("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$",$real_ip)) $ip=$real_ip; // Se l'IP è valido è l'IP reale dell'utente
  }				
// Inclusioni necessarie
@include("config.php");
@include("inc/main_func.inc.php");
$s=urldecode(urlencode("§§")); //Codifica e decodifica del sepatarore
if(!isset($option['prefix'])) $option['prefix']="php_stats";
if($option['php_stats_safe']) $append=""; else $append="LIMIT 1"; // MySQL 3.22 dont' have LIMIT in UPDATE select!!!!
if($option['page_title']) 
  if(isset($_GET['t'])) $title=htmlspecialchars(addslashes(urldecode($_GET['t']))); else $title=""; 
  else $title="";
// Compressione buffer
if($option['out_compress']) ob_start("ob_gzhandler");
// Connessione a MySQL e selezione database
db_connect();
// Lettura variabili
$result=sql_query("SELECT name,value FROM $option[prefix]_config");
while($row=@mysql_fetch_array($result)) $option[$row[0]]=$row[1];
if($option['stats_disabled']) die(); // Statistiche attive?
$modulo=explode("|",$option['moduli']); // Leggo i moduli da attivare
if($php_stats_esclusion!="1") // Verifico se questo pc è escluso dalle stats
{ 
// PREPARARO VARIABILI
if(strstr($NS_url,"NS_url")) $NS_url="";
if(isset($HTTP_REFERER)) $loaded=htmlspecialchars(addslashes($HTTP_REFERER)); else { if($NS_url=="") $loaded="?"; else $loaded=str_replace($s,"&",$NS_url); } // Pagina visualizzata
//if(substr($loaded,-1)=="/") $loaded=substr($loaded,0,strlen($loaded)-1);
if($option['www_trunc']) if(strtolower(substr($loaded,0,11))=="http://www.") $loaded=eregi_replace("http://www.","http://",$loaded);
foreach($default_pages as $key)
  {
  $tmp=strlen($key);
  if(strtolower(substr($loaded,-$tmp))==$key) 
    {
	$loaded=substr($loaded,0,strlen($loaded)-$tmp);
	break;
	}
  }
$date=time()-$option['timezone']*3600;
$mese_oggi=date("Y-m",$date); // Y-m
$data_oggi=$mese_oggi."-".date("d",$date); // Y-m-d
$ora=date("G",$date);
$loaded=filter_urlvar($loaded,"sid"); // ELIMINO VARIABILI SPECIFICHE NELLE PAGINE VISITATE (esempio il session-id) 
$secondi=$date-3600*$option['ip_timeout']; // CALCOLO LA SCANDEZA DELLA CACHE
/////////////////////////////////////////////////////////////////////////////////////////////
// VERIFICO SE L'IP E' PRESENTE NELLA CACHE: SE NECESSARIO LO INSERISCO OPPURE LO AGGIORNO //
/////////////////////////////////////////////////////////////////////////////////////////////
$cache_cleared=0; // Flag -> La cache ha subito una pulizia
    $do_update=0; // Flag -> Devo eseguire l'update della cache
    $do_insert=0; // Flag -> Devo eseguire l'inserimento nella cache
$result=sql_query("SELECT data,lastpage,user_id,visitor_id,giorno,level FROM $option[prefix]_cache WHERE user_id='$ip' LIMIT 1");
if(mysql_affected_rows()>0) 
  { 
  list($last_page_time,$last_page_url,$user_id,$visitor_id,$giorno,$level)=@mysql_fetch_row($result);
  // Aggiornamento tempo di permanenza dell'ultima pagina
  if($modulo[3]):
    $tmp=$date-$last_page_time;
    if($tmp<$option['page_timeout']) sql_query("UPDATE $option[prefix]_pages SET presence=presence+$tmp,tocount=tocount+1,date=$date WHERE data='$last_page_url' $append");
  endif;
  // VERIFICO SCADENZA PAGINA IN CASO DI IP IDENTICI
  if($last_page_time<$secondi) 
    { // SCADUTO
	$cache_cleared=do_clear(); // PULIZIA TOTALE
	$do_insert=1; // DEVO INSERIRE IL NUOVO VISITATORE
	}
	else
    { // NON SCADUTO
	if($data_oggi!=$giorno) // Controllo visite a cavallo di 2 giorni
	  $cache_cleared=do_clear($visitor_id); // PULIZIA PARZIALE, NON CANCELLO
	$do_update=1; // Ma aggiorno sempre un dato non scaduto
    }
  }
  else $do_insert=1; // Se non trovo l'IP nella cache inserisco.
  
if($do_update) // AGGIORNAMENTO CACHE
    {
    sql_query("UPDATE $option[prefix]_cache SET data='$date',lastpage='$loaded',giorno='$data_oggi',hits=hits+1,level=level+1 WHERE user_id='$ip' $append");
    $is_uniqe=0;
	$level++;
    $update_hv="hits=hits+1";
	}

if($do_insert) // INSERIMENTO DATI IN CACHE
  { 
  if(isset($_GET['c'])) $c=htmlspecialchars(addslashes(urldecode($_GET['c']))); else $c="?";
  if(isset($_GET['w'])) $w=htmlspecialchars(addslashes(urldecode($_GET['w']))); else $w="";
  if(isset($_GET['h'])) $h=htmlspecialchars(addslashes(urldecode($_GET['h']))); else $h="";
  if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $HTTP_ACCEPT_LANGUAGE=htmlspecialchars(addslashes($_SERVER['HTTP_ACCEPT_LANGUAGE'])); else $HTTP_ACCEPT_LANGUAGE="?";
  if(isset($_SERVER['HTTP_USER_AGENT'])) $HTTP_USER_AGENT=htmlspecialchars(addslashes($_SERVER['HTTP_USER_AGENT'])); else $HTTP_USER_AGENT="?";
  $HTTP_USER_AGENT=str_replace(" ","",$HTTP_USER_AGENT);
  if(strstr($w,"w")) $w="";
  if(strstr($h,"h")) $h="";
  if(strstr($c,"c")) $c="";
  $reso=$w."x".$h;
  if($reso=="x") $reso="?";
  $tmp=explode(",",$HTTP_ACCEPT_LANGUAGE);
  $lang=strtolower($tmp[0]); 
  if(($modulo[7] && ($option['ip-zone']==0)) || $option['log_host']) $host=gethostbyaddr($ip); else $host="";
  $visitor_id=get_random(30);
  sql_query("INSERT INTO $option[prefix]_cache VALUES('$ip','$date','$loaded','$visitor_id','1','1','$reso','$c','$HTTP_USER_AGENT','$host','$lang','$data_oggi','1')");
  $is_uniqe=1;
  $level=1;
  $update_hv="visits=visits+1,hits=hits+1";
  }
//////////////////////////////////////////////////////////
// DATI NON SALVATI IN CACHE E CONTINUAMENTE AGGIORNATI //  
//////////////////////////////////////////////////////////
// CONTATORI PRINCIPALI
sql_query("UPDATE $option[prefix]_counters SET $update_hv $append");
// SCRIVO LA PAGINA VISUALIZZATA
if($modulo[3]):
  $what="hits=hits+1";
  if($level<7) $what.=", lev_".$level."=lev_".$level."+1";
  sql_query("UPDATE $option[prefix]_pages SET $what,date='$date' WHERE data='$loaded' $append");
  if(mysql_affected_rows()<1) 
    {
    $lev_1=0; $lev_2=0; $lev_3=0; $lev_4=0; $lev_5=0; $lev_6=0;
    if($level<7) eval("\$lev_".$level."=1;");
    sql_query("INSERT INTO $option[prefix]_pages VALUES('$loaded','1','$is_uniqe','0','0','$date','$lev_1','$lev_2','$lev_3','$lev_4','$lev_5','$lev_6','0','$title')");
	}
  if($option['prune_4_on']) prune("$option[prefix]_pages",$option['prune_4_value']); 
endif;
// PREPARO REFERER
if(isset($_GET['f'])) $reffer=htmlspecialchars(addslashes($_GET['f'])); else $reffer="";
if(is_internal($reffer)) 
  $reffer=""; 
  else 
  { 
  if($is_uniqe || $option['full_recn']) 
    {
    if($reffer!="") $reffer=str_replace($s,"&",$reffer);
    if(strstr($reffer,"reffer")) $reffer="";
    $reffer=filter_urlvar($reffer,"sid"); // ELIMINO VARIABILI SPECIFICHE NEI REFERER (esempio il session-id) 
    }
    else
	$reffer="";
  }  
// SCRIVO I MOTORI DI RICERCA, QUERY e REFERER 
if($modulo[4]):
  if($reffer!="")
  {
  if(substr($reffer,-1)=="/") $reffer=substr($reffer,0,strlen($reffer)-1);
  list($nome_motore,$query)=getengine($reffer);
  if(($nome_motore!="") AND ($query!=""))
    {
	// MOTORI DI RICERCA E QUERY
	$clause="data='$query' AND engine='$nome_motore'"; if($modulo[4]==2) $clause.=" AND mese='$mese_oggi'";
	sql_query("UPDATE $option[prefix]_query SET visits=visits+1, date='$date' WHERE $clause $append");
    if(mysql_affected_rows()<1)
	  {
	  $insert="VALUES('$query','$nome_motore','1','$date','"; if($modulo[4]==2) $insert.="$mese_oggi"; $insert.="')";
	  sql_query("INSERT INTO $option[prefix]_query $insert");
      if($option['prune_3_on']) prune("$option[prefix]_query",$option['prune_3_value']); 
	  }
	}
    else
    {
	// REFERERS
	$reffer_dec=urldecode($reffer);
	$clause="data='$reffer_dec'"; if($modulo[4]==2) $clause.=" AND mese='$mese_oggi'";
    sql_query("UPDATE $option[prefix]_referer SET visits=visits+1,date='$date' WHERE $clause $append");
    if(mysql_affected_rows()<1)
	  {
	  $insert="VALUES('$reffer_dec','1','$date','";	if($modulo[4]==2) $insert.="$mese_oggi"; $insert.="')"; 
	  sql_query("INSERT INTO $option[prefix]_referer $insert");
	  }
    if($option['prune_5_on']) prune("$option[prefix]_referer",$option['prune_5_value']);
    }
  }
endif;
// SCRIVO I DETTAGLI 
if($modulo[0]):
  if($is_uniqe) $what="'$visitor_id','$ip','$host','$HTTP_USER_AGENT','$lang','$date','$reffer','$loaded','$reso','$c','$title'";
           else $what="'$visitor_id','$ip','','','','$date','','$loaded','','','$title'";
  sql_query("INSERT INTO $option[prefix]_details VALUES ($what)");
  if($option['prune_0_on']) { $limit=$option['prune_0_value']*3600; $secondi2=$date-$limit; sql_query("DELETE FROM $option[prefix]_details WHERE date<$secondi2 LIMIT 2"); }
  if($option['prune_1_on']) prune_details("$option[prefix]_details",$option['prune_1_value']);
endif;
// ACCESSI ORARI
if($modulo[5]):
  $clause="data='$ora'"; if($modulo[5]==2) $clause.=" AND mese='$mese_oggi'";
  sql_query("UPDATE $option[prefix]_hourly SET $update_hv WHERE $clause $append");
  if(mysql_affected_rows()<1) 
    {
    $insert="VALUES('$ora','1','$is_uniqe','"; if($modulo[5]==2) $insert.="$mese_oggi"; $insert.="')"; 
    sql_query("INSERT INTO $option[prefix]_hourly $insert");
    }
endif;
// MAX UTENTI ON-LINE
if($modulo[3]==2):
  list($max_ol,$time_ol)=explode("|",$option['max_online']);
  if($option['online_timeout']==0) $tmp=$date-5*60; else $tmp=$date-$option['online_timeout']*60;
  $result=sql_query("SELECT data FROM $option[prefix]_cache WHERE data>$tmp");
  $online=@mysql_num_rows($result);
  if($online>$max_ol) sql_query("UPDATE $option[prefix]_config SET value='$online|$date' WHERE name='max_online' $append");
endif;

// Se non l'ho fatto prima, se necessario pulisco, un dato in cache
if(!$cache_cleared) { do_clear(); $cache_cleared=1; }

}// FINE ESCLUSIONE

// VERIFICO SE DEVO SPEDIRE L' E-MAIL CON IL PROMEMORIA DEGLI ACCESSI
if($option['report_w_on']) if($date>$option['report_w']) { include("inc/report.inc.php"); report(); }

// OPTIMIZE TABLES
if($option['auto_optimize']) 
  {
  if(!isset($hits)) list($hits)=@mysql_fetch_row(sql_query("SELECT hits FROM $option[prefix]_counters LIMIT 1"));
  if(($hits % $option['auto_opt_every'])==0):
    $query="OPTIMIZE TABLES $option[prefix]_cache";
    if($option['prune_1_on'] || $option['prune_0_on']) $query.=",$option[prefix]_details";
    if($option['prune_2_on']) $query.=",$option[prefix]_ip";
    if($option['prune_4_on']) $query.=",$option[prefix]_pages";
    if($option['prune_3_on']) $query.=",$option[prefix]_query";
    if($option['prune_5_on']) $query.=",$option[prefix]_referer";
    sql_query($query);
  endif;
  }

// Chiusura connessione a MySQL se necessario
if(!$option['persistent_conn']) mysql_close();

if($option['callviaimg']) 
  {
  // Immagine fittizia 1 pixel x 1 pixel trasparente
  header("Content-Type: image/gif");
  echo base64_decode("R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
  exit;
  }
?>