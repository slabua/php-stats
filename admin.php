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

// Inizializzazione delle variabili
           $short_url=1;  // Mostra url corti quando possibile
         $is_loged_in=0;  // Non loggato
             $refresh=0;  // Nessun refresh della pagina se non diversamente specificato
		  $update_msg=0;  // Nessun update disponibile
$error['debug_level']=0;  // Debug si sttiva da solo in caso di errore
			   $style=""; // In caso di register globals=on
		  $cache_recn=0;  // Flag riconoscimento cache
       $protect_action=array("login","esclusioni","preferenze","refresh","backup","resett","downadmin","clicksadmin","optimize_tables","viewerrorlog"); // Azioni che richiedono il login
	 $norefresh_action=array("login","logout","esclusioni","preferenze","refresh","backup","resett","downadmin","clicksadmin","optimize_tables","viewerrorlog"); // Azioni che non hanno refresh in visualizzazione
      $cache_recn_arr=array("main","os_browser","reso","systems","daily","weekly","monthly","calendar","compare","country","bw_lang","trend","ip");  // Azioni che usano la cache

// SECURITY ISSUES
define('IN_PHPSTATS',true);

// Richiamo variabili esterne 
                         if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
                if(isset($_GET['action'])) $action=$_GET['action']; else $action="main";
               if(isset($_GET['opzioni'])) $opzioni=addslashes($_GET['opzioni']); else $opzioni="";
                      
					  if(!isset($_COOKIE)) $_COOKIE=$HTTP_COOKIE_VARS;
        if(isset($_COOKIE['pass_cookie'])) $pass_cookie=$_COOKIE['pass_cookie']; else $pass_cookie="";
if(isset($_COOKIE['php_stats_esclusion'])) $php_stats_esclusion=$_COOKIE['php_stats_esclusion'];
    if(isset($_COOKIE['php_stats_cache'])) $php_stats_cache=$_COOKIE['php_stats_cache']; else $php_stats_cache=0;
                        
						if(!isset($_POST)) $_POST=$HTTP_POST_VARS;
                 if(isset($_POST['pass'])) $pass=addslashes($_POST['pass']); else $pass="";
               if(isset($_POST['option'])) $option=$_POST['option'];
           if(isset($_POST['option_new'])) $option_new=$_POST['option_new'];
                      
					  if(!isset($_SERVER)) $_SERVER=$HTTP_SERVER_VARS;
	   if(isset($_SERVER['QUERY_STRING'])) $QUERY_STRING=addslashes($_SERVER['QUERY_STRING']); else $QUERY_STRING="";
	        if(isset($_SERVER['PHP_SELF'])) $PHP_SELF=addslashes($_SERVER['PHP_SELF']); else $PHP_SELF="admin.php";

// inclusione delle principali funzioni esterne
if(!@include("config.php")) die("<b>ERRORE</b>: File config.php non accessibile.");
if(!@include("inc/main_func.inc.php")) die("<b>ERRORE</b>: File main_func.inc.php non accessibile.");
if(!@include("inc/admin_func.inc.php")) die("<b>ERRORE</b>: File admin_func.inc.php non accessibile.");

$start_time=get_time();

if($option['out_compress']) ob_start("ob_gzhandler");
if($option['prefix']=="") $option['prefix']="php_stats";

// Connessione a MySQL e selezione database
db_connect();

//Leggo le variabili di configurazione.
$result=sql_query("SELECT name,value FROM $option[prefix]_config");
if(mysql_num_rows($result)!=40) die("<b>ERRORE</b>: Anomalia nella tabella $option[prefix]_config, dati di configurazione in numero non corretto (non 40).");
while($row=@mysql_fetch_array($result)) $option[$row[0]]=$row[1];
$modulo=explode("|",$option['moduli']);
if($option['template']=="") $option['template']="default";
$template_path="templates/".$option['template'];

///////////////////
// PULIZIA CACHE //
///////////////////
if(!$option['clear_cache']) 
  { // Controllo se non si � forzato il riconoscimento continuo
  if(($php_stats_cache!="1") || (time()>($option['last_cache_time']+1200)))
    {
    if(in_array($action,$cache_recn_arr)) $cache_recn=1; else $cache_recn=0;
    }
  }  
if($cache_recn==1):
if(isset($_GET['do'])) $do=$_GET['do']; else $do=0;
if($do==0) 
  {
  // VISUALIZZO MESSAGGIO DI ATTESA
  $url=$option['script_url']."/admin.php?do=1";
  if($QUERY_STRING!="") $url.="&redirect=".urlencode($QUERY_STRING);
  if(!@include("lang/$option[language]/cache_refr_lang.inc")) die("<b>ERRORE</b>: File $option[language]/cache_refr_lang.inc non accessibile.");
  $message="<span class=\"testo\">$message1</span>";
  }
  else
  {
  // VISUALIZZO MESSAGGIO DI AVVENUTO RICONOSCIMENTO
  setcookie("php_stats_cache","1"); // Scade alla chiusura del browser
  clear_cache();
  mysql_query("UPDATE $option[prefix]_config SET value='".time()."' WHERE name='last_cache_time'");
  if(isset($_GET['redirect'])) $redirect="admin.php?".$_GET['redirect']; else $redirect="admin.php";
  $url=$redirect;
  if(!@include("lang/$option[language]/cache_refr_lang.inc")) die("<b>ERRORE</b>: File $option[language]/cache_refr_lang.inc non accessibile.");
  $message="<span class=\"testo\">$message2</span>";
  }
$template="$template_path/cache_refresh.tpl";
$file=file($template);
$template=implode("",$file);
$template=str_replace("%URL%",$url,$template);
$template=str_replace("%MESSAGE%",$message,$template);
// FINE RICONOSCIMENTO CACHE

else:

///////////////////////////////
// PAGINA DI AMMINISTRAZIONE //
///////////////////////////////

// Controllo password
if($pass_cookie==md5($option['admin_pass'])) $is_loged_in=1;
if($action=="enter")
  {
  $cripted_pass=md5($pass); // Criptazione password nel cookie
  setcookie("pass_cookie","",time());
  setcookie("pass_cookie","$cripted_pass",time()+22896000);
  if($pass==$option['admin_pass']) { $is_loged_in=1; $action="main"; } else $action="wrong_pass";
  }
if($action=="logout" || $action=="login")
  {
  setcookie("pass_cookie","",time(),"/"); // Per risolvere un bug con NS devo cancellare il cookie con il parametro "/"
  setcookie("pass_cookie","",time());
  if($action=="logout") $is_loged_in=0;
  }
if($option['use_pass']) if($is_loged_in!=1) if($action!="wrong_pass") if($action!="send_password") $action="login";
// Controllo se l'azione richiede il login
foreach($protect_action as $value) 
  if($action==$value AND $is_loged_in!=1) $action="login";
if($action=="esclusioni" AND $opzioni=="change") 
  { 
  setcookie("php_stats_esclusion",$option_new,(time()+311040000)); 
  if($option_new==1) $php_stats_esclusion=1; else $php_stats_esclusion=0;
  }
// ELABORAZIONE DATI NELLA CACHE
if(in_array($action,$cache_recn_arr)) 
 { 
 if($option['clear_cache']) { clear_cache(); $clear_tip=0; } else $clear_tip=1;
 } 
 else 
 $clear_tip=0;

// Memorizzo l'action per usi futuri
$trad_action=$action;

// Inclusioni secondarie: template della pagina e language pack.
if(!@include("lang/$option[language]/main_lang.inc")) die("<b>ERRORE</b>: File $option[language]/main_lang.inc non accessibile."); // Language file
if(!@include("$template_path/def.php")) die("<b>ERRORE</b>: File $template_path/def.php non accessibile.");                // Template defs
if(!@include("inc/$action.inc.php"))
  {
  $body="<img src=\"templates/$option[template]/images/icon_warning.gif\" align=\"middle\"><span class=\"tabletextB\">&nbsp;$error[critical_err]</span>";
  $action=info_box("<b>$string[error]</b>",$body);
  $phpstats_title=$string['error_title'];
  }
  else $action=$action();

// Visualizzo suggerimenti se necessario  
if($clear_tip==1) {										   
  $cache_clear=mysql_query("SELECT hits FROM $option[prefix]_cache WHERE hits>0");
  $num_cache=@mysql_num_rows($cache_clear);
  if($num_cache>0)
    {
    $tips="<br>\n<script>";
    $tips.="\nfunction clearcache(url) {";
    $tips.="\n\tclearcache=window.open(url,'clearcache','SCROLLBARS=0,STATUS=NO,TOOLBAR=NO,RESIZABLE=NO,LOCATION=NO,MENU=NO,WIDTH=250,HEIGHT=100,LEFT=0,TOP=0');";
    $tips.="\n\t}";
    $tips.="\n</script>"; 
    $tips.="\n<table $style[table_header] width=\"95%\">";
    $tips.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
	$tips.="<tr bgcolor=\"$style[table_tips_bgcolor]\"><td width=\"95%\" bgcolor=\"$style[table_tips_bgcolor]\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/icon_tips.gif\" align=\"absmiddle\" border=\"0\">";
	if($num_cache==1) $tips.=str_replace("%NUMCACHE%",$num_cache,$string['tips_cache_refresh_1']); 
	             else $tips.=str_replace("%NUMCACHE%",$num_cache,$string['tips_cache_refresh_2']);
	$tips.="</span></td></tr>";
    $tips.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
    $tips.="</table>";
    $action=$action.$tips;
	}
  }
if($option['upd_available']) 
  {
    $tips ="<br>\n<table $style[table_header] width=\"95%\">";
    $tips.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
	$tips.="<tr bgcolor=\"$style[table_tips_bgcolor]\"><td width=\"95%\" bgcolor=\"$style[table_tips_bgcolor]\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/icon_tips.gif\" align=\"absmiddle\" border=\"0\">$string[tips_update_availb]</span></td></tr>";
    $tips.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
    $tips.="</table>";
    $action=$action.$tips;  
  }
  
// DEBUG MODE in caso di errori MySQL
if($error['debug_level']) $action=info_box("<b>PHP-STATS AUTO DEBUG MODE</b>",$error['debug_level_error']);

// Visualizzo il login se non si � loggati o il logout se lo si �.
if($is_loged_in) { $admin_menu['status']=$admin_menu['logout']; $admin_menu['status_rev']="logout"; }
            else { $admin_menu['status']=$admin_menu['login']; $admin_menu['status_rev']="login"; }

// Check nuove versioni
if($is_loged_in)
if(((time()-$option['last_update'])>(432000*2)) && (!$option['upd_available']))
  {
  $update=@file("http://www.php-stats.com/check.php?url=".trim($option['script_url'])."&ver=".trim($option['phpstats_ver'])."&lang=".trim($option['language']));
  if($update!=false)
    {
	$tmp="";
	while(list($line_num,$line)=each($update)) $tmp.=$line;
    if(strstr($tmp,"<!-- Version Checker -->"))
	  {
      $update_msg=$tmp;	
	  sql_query("UPDATE $option[prefix]_config SET value='1' WHERE name='upd_available'");
	  }
    sql_query("UPDATE $option[prefix]_config SET value='".time()."' WHERE name='last_update'");
	}
  }
// Fine delle elaborazioni primarie.
$end_time=get_time();

// Inclusione template-script esterno
include("$template_path/template.php");

endif; // della scelta cache/admin

// Restituisco la pagina  
echo $template;

// Chiusura connessione a MySQL se necessario.
if($option['persistent_conn']!=1) mysql_close();
?>
