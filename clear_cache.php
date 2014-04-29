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
	  
// SECURITY ISSUES
define('IN_PHPSTATS', true);
$style=""; // In caso di register globals=on

// Richiamo variabili esterne 
                         if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
                if(isset($_GET['do'])) $do=$_GET['do']; else $do=0;

// inclusione delle principali funzioni esterne
if(!@include("config.php")) die("<b>ERRORE</b>: File config.php non accessibile.");
if(!@include("inc/main_func.inc.php")) die("<b>ERRORE</b>: File main_func.inc.php non accessibile.");

$start_time=get_time();
if($option['out_compress']==1) ob_start("ob_gzhandler");
if($option['prefix']=="") $option['prefix']="php_stats";

// Connessione a MySQL e selezione database
db_connect();

//Leggo le variabili di configurazione.
$result=sql_query("SELECT name,value FROM $option[prefix]_config");
if(mysql_num_rows($result)!=40) die("<b>ERRORE</b>: Anomalia nella tabella $option[prefix]_config, dati di configurazione in numero non corretto (non 40).");
while($row=@mysql_fetch_array($result)) $option[$row[0]]=$row[1];
$modulo=explode("|",$option['moduli']);
if($option['template']=="") $option['template']="default";
if(!is_dir("templates/$option[template]")) $template_path="templates/default"; else $template_path="templates/$option[template]";

// Inlcusione file di linguaggio e template
include("lang/".$option['language']."/main_lang.inc");
include("$template_path/def.php");

$page ="<html>\n<head>\n<title>$string[clear_cache_title]</title>";
$page.="\n<link rel=\"stylesheet\" href=\"$template_path/styles.css\" type=\"text/css\">";
$page.="\n<META NAME=\"ROBOTS\" CONTENT=\"NONE\">";
$page.="\n</head>";
$page.="\n<body bgcolor=\"$style[bg_pops]\" onload=\"self.focus()\">";

if($do==1)
  {
  if(!@include("inc/admin_func.inc.php")) die("<b>ERRORE</b>: File admin_func.inc.php non accessibile.");
  clear_cache();
  $page.="\n<span class=\"testo\"><center>$string[clear_cache_done]</center></span>";
  
  // Chiusura automatica da figonedellamaronna
 
  $page.="\n<span class=\"testo\"><center><a>Aggiornamento in corso...</a></span></center>";
  $page.="<script>setTimeout('window.close()',3000)</script>";
  $page.="\n<script>window.opener.location=window.opener.location;</script>";
  }
  else
  {
  $page.="\n<span class=\"testo\"><center>$string[clear_cache_start]</center></span>";
  $page.="\n<script>window.location=\"clear_cache.php?do=1\";</script>";
  }
$page.="\n</body>\n</html>";

// Restituisco la pagina
echo $page;
?>