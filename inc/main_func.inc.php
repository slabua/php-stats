<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

// CONNESSIONE DATABASE
function db_connect() {
  global $option;
  $error['no_connection']="<b>ERRORE</b>: Non riesco a connttermi a MySQL! Controllare config.php .";
  $error['no_database']="<b>ERRORE</b>: Il database indicato nel config.php non esiste! Il database va creato prima di effettuare l'installazione.";
  if($option['persistent_conn']==1)
    {
    $db=@mysql_pconnect($option['host'],$option['user_db'],$option['pass_db']);
	if($db==false) { logerrors("DB-PCONN"."\t".time()."\tFAILED"); die($error['no_connection']); }
    }
	else
    {
	$db=@mysql_connect($option['host'],$option['user_db'],$option['pass_db']);
	if($db==false) { logerrors("DB-CONN"."|".date("d/m/Y H:i:s")."|FAILED"); die($error['no_connection']); }
	}
  $db_sel=@mysql_select_db($option[database]);
  if($db_sel==false) { logerrors("DB-SELECT"."|".date("d/m/Y H:i:s")."|FAILED"); die($error['no_database']); }
  }

// ESECUZIONE QUERY //
function sql_query($query) {
  global $option,$db,$return,$error;
  $return=@mysql_query($query);
  if($return==false)
    {
	$error['debug_level']=1;
	$error['debug_level_error']="<b>QUERY:</b><br>$query<br><br><b>MySql ERROR:</b><br>".mysql_errno().": ".mysql_error();
	logerrors("QUERY|".date("d/m/Y H:i:s")."|".$query."|".mysql_error());
	}
  return($return);
  }

// Ricerca in stringa con wildchars //
function search($string,$mask){
	static $in=array('.', '^', '$', '{', '}', '(', ')', '[', ']', '+', '*', '?');
	static $out=array('\\.', '\\^', '\\$', '\\{', '\\}', '\\(', '\\)', '\\[', '\\]', '\\+', '.*', '.');
	$mask='^'.str_replace($in,$out,$mask).'$';
	return(ereg($mask,$string));
}

// Cronometro per tempo creazione pagine //
function get_time() {
	$mtime=microtime();
	$mtime=explode(" ",$mtime);
	$mtime=$mtime[1]+$mtime[0];
	return($mtime);
}

// FUNZIONE CHE GENERA UN ID CASUALE //
function get_random($size=8) {
	$id="";
	srand((double)microtime()*1000000);
	$a="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; // Set caratteri
	for($i=0; $i<$size; $i++) $id.=substr($a,(rand()%(strlen($a))),1);
	return($id);
}

// Filtratura varibili
function filter_urlvar($url,$var) {
$i=0;
$url=str_replace("&amp;","&",$url); //TEST: SERVE????????
$tmp=explode("?",$url);
if($url!=$tmp[0]) {
  $tmp3=explode("&",$tmp[1]);
  foreach($tmp3 as $key) {
    $pos=strpos($key,"$var=");
    $i++;
    if($pos!==0)
      {
      if($i==1) $tmp4="?"; else $tmp4.="&";
      $tmp4.="$key";
      }
    }
  return($tmp[0].$tmp4);
  }
  else
  {
  return($url);
  }
}

function findfirstnonnumber($arg,$offset=0){
  $ord0=ord('0');
  $ord9=ord('9');
  $ordpoint=ord('.');
  for($i=$offset,$tot=strlen($arg);$i<$tot;$i++){
    $tmp=ord($arg{$i});
    if($tmp!=$ordpoint && ($tmp<$ord0 || $tmp>$ord9)) return $i;
  }
  return strlen($arg);
}

function getbrowser($arg){
  $bw=file('def/bw.dat');
  $flag=FALSE;
  for($i=0,$tot=count($bw);$i<$tot;$i++){
    if($bw[$i]{0}!='#'){
      list($nome_bw,$id_bw,$pre_ver,$macro)=explode('|',$bw[$i]);
      if(strpos($arg,$id_bw)!==FALSE){
        $tmp=strpos($arg,$pre_ver);
	if($tmp!==FALSE){
	  $flag=TRUE;
	  $startpos=$tmp+strlen($pre_ver);
	  $endpos=findfirstnonnumber($arg,$startpos);
	  if($endpos==$startpos){
	    $flag=FALSE;
	    continue;
	  }
	  $version=substr($arg,$startpos,$endpos-$startpos);
	  break;
	}
      }
    }
  }
  if($flag) return $nome_bw.' '.$version;
  else{
    logerrors("Unknown BW|$arg");
    return '?';
  }
}

function getos($arg){
  $sysop=" ".ereg_replace(" ","",$arg);
  $os=file("def/os.dat");
  $flag=0;
  while(list($key,$val)=each($os))
    {
    list($nome_os,$id_os)=explode("|",$val);
    if(strpos($sysop,chop($id_os))) { $flag++; break;}
    }
  if($flag==0) logerrors("Unknown OS|$arg");
  return($flag==0 ? "?" : $nome_os);
}

// Restituisco nome del motore e query dall'url passato //
// Revisione in Php-Stats 0.1.8
function getengine($reffer){
$se=file("def/search_engines.dat");
$reffer=str_replace("&amp;","§§§",$reffer); // Il carattere &amp; può dare problemi => rimpiazzo con §§§
$reffer=unhtmlentities($reffer); // DECODIFICO CARATTERI SPECIALI
$nome=""; //Default
$found=0;
foreach($se as $linea)
  {
  $linea=trim($linea);
  if((substr($linea,0,2)!="//") && $linea!="")
    {
    $reffer=strtolower($reffer);
    $tmp=explode("|",$linea);
    if(search($reffer,$tmp[1]))
    if(strpos($reffer,chop($tmp[2]))!==false)
      {
      $nome=$tmp[0];
      $found=1;
      break;
      }
    }
  }
if($found==1)
  {
  $vars=explode("?",$reffer);
  if(count($vars)>1)
    {
    $query=explode(chop($tmp[2]),$vars[1]);
	if(count($query)>1)
	  {
	  $query=explode("&",$query[1]);
	  $query=translate(eregi_replace("\++"," ",ltrim(rtrim(urldecode($query[0])))));
      $query=eregi_replace('( ){2,}',' ',$query);
	  if(strpos(" ".$query,"cache:")==1) $query=""; // NON CONSIDERO LA CACHE DI GOOGLE
	  $query=str_replace("§§§","&amp;",$query);  // Rimetto a posto il carattere &amp;
	  $query=addslashes($query);
	  }
	  else $query="";
    }
	else $query="";
  }
  else $query="";
return array($nome,$query);
}

// Traduzione lettere accentate, simile a utf8_decode()
function translate($string) {
  $ts=array("/</" ,"/>/" ,"/Ã¨/","/Ã¹/","/Ã /","/Ã²/","/Ã¬/");
  $tn=array("&lt;","&gt;", "é"  ,"ù"   ,"à"   ,"ò"   ,"ì");
  return preg_replace($ts,$tn,$string);
}

// Traduzione caratteri speciali
function unhtmlentities($string) {
   $trans_tbl=get_html_translation_table(HTML_ENTITIES);
   $trans_tbl=array_flip($trans_tbl);
   return strtr($string,$trans_tbl);
}

// PRUNING DELLE TABELLE
function prune($table,$offset,$limit=2) {
$righe=@mysql_result(sql_query("SELECT COUNT(1) AS num FROM $table"), 0, "num");
$to_del=$righe-$offset;
if($to_del>0)
  {
  if($limit!=0) $to_del=min($limit,$to_del); // SE 0 -> NO LIMIT!
  $to_prune=sql_query("SELECT date FROM $table ORDER BY date ASC LIMIT $to_del");
  while($row=@mysql_fetch_array($to_prune))
    sql_query("DELETE FROM $table WHERE date='$row[0]' LIMIT 1");
  }
}

/* PRUNING TABELLE OTTIMIZZATA PER MySQL 4
function prune($table,$offset,$limit=2) {
$result=sql_query("SELECT date FROM $table ORDER BY date DESC LIMIT $offset,$limit");
if(mysql_num_rows($result)>0)
while($row=@mysql_fetch_array($result))
  {
  //echo"$row[0]";
  sql_query("DELETE FROM $table WHERE date='$row[0]' LIMIT 1");
  }
} */

// Pruning specifico per i dettagli
function prune_details($table,$offset) {
$righe=mysql_result(sql_query("SELECT COUNT(1) AS num FROM $table"),0,"num");
if($righe-$offset>0)
  {
  list($id)=@mysql_fetch_row(sql_query("SELECT visitor_id FROM $table ORDER BY date ASC LIMIT 1"));
  sql_query("DELETE FROM $table WHERE visitor_id='$id'");
  }
}

function is_internal($ref) {
  global $option;
  $to_esclude=explode("\n",$option['server_url']);
  $int=0;
  foreach ($to_esclude as $i) {
    $i=trim($i);
    if($i!="")
      {
      if((strpos($ref,$i)===false) OR (strpos($ref,$i)!=0)) {} else $int=1;
      }
    }
  return($int);
}

// FUNIZONE PER LOGGARE ERRORI
function logerrors($string) {
global $option;
if($option['logerrors'])
  {
  // Tento di impostare i permessi di scrittura
  if(!@is_writable("php-stats.log")) @chmod("php-stats.log",0666);
  if(@is_writable("php-stats.log"))
    {
    $fp=fopen("php-stats.log","a");
    fputs($fp,$string."\n");
    }
  }
}
// FUNCTION CLEAR CACHE
function do_clear($user_id_tmp="")
{
global $option,$date,$append,$modulo,$secondi,$mese_oggi,$data_oggi;
$do_insert=0;
// Sespecifico l'user_id è perchè ho un accesso a cavallo dei 2 giorni e ha priorità
if($user_id_tmp!="")
  $result=sql_query("SELECT * FROM $option[prefix]_cache WHERE visitor_id='$user_id_tmp' LIMIT 1");
  else
  $result=sql_query("SELECT * FROM $option[prefix]_cache WHERE data<'$secondi' LIMIT 1");
if(mysql_affected_rows()>0) {
  $row=@mysql_fetch_row($result);
  if(($row[4]>0) OR ($row[5]>0))
  {
  // SISTEMI (OS,BW,RESO,COLORS)
  if($modulo[1]){
    $nome_bw=chop(getbrowser($row[8]));
    $nome_os=chop(getos($row[8]));
	$clause="os='$nome_os' AND bw='$nome_bw' AND reso='$row[6]' AND colo='$row[7]'"; if($modulo[1]==2) $clause.=" AND mese='$mese_oggi'";
	sql_query("UPDATE $option[prefix]_systems SET visits=visits+$row[5],hits=hits+$row[4] WHERE $clause $append");
    if(mysql_affected_rows()<1)
	  {
  	  $insert="VALUES('$nome_os','$nome_bw','$row[6]','$row[7]','$row[4]','$row[5]','"; if($modulo[1]==2) $insert.="$mese_oggi"; $insert.="')";
	  sql_query("INSERT INTO $option[prefix]_systems $insert");
	  }
    }
  // LINGUE (impostate dal browser)
  if($modulo[2]){
	sql_query("UPDATE $option[prefix]_langs SET visits=visits+$row[5],hits=hits+$row[4] WHERE lang='$row[10]' $append");
    if(mysql_affected_rows()<1) sql_query("UPDATE $option[prefix]_langs SET visits=visits+$row[5],hits=hits+$row[4] WHERE lang='unknown' $append");
    }
  // ACCESSI GIORNALIERI
  if($modulo[6]){
    sql_query("UPDATE $option[prefix]_daily SET visits=visits+$row[5],hits=hits+$row[4] WHERE data='$row[11]' $append");
    if(mysql_affected_rows()<1) sql_query("INSERT INTO $option[prefix]_daily VALUES('$row[11]','$row[4]','$row[5]')");
    }
  // COUNTRY
  if($modulo[7]){
    if($option['ip-zone'])
	  {
      $ip_number=sprintf("%u",ip2long($row[0]));
      $result2=sql_query("SELECT tld FROM $option[prefix]_ip_zone WHERE $ip_number BETWEEN ip_from AND ip_to");
      if(mysql_affected_rows()>0)  list($domain)=@mysql_fetch_row($result2);  else $domain="unknown";
	  }
	  else
      {
      $tmp=".".$row[9];
      $tmp=strrev($tmp);
      $tmp=explode(".",$tmp);
      $domain=strrev($tmp[0]);
	  }
    sql_query("UPDATE $option[prefix]_domains SET visits=visits+$row[5],hits=hits+$row[4] WHERE tld='$domain' $append");
    if(mysql_affected_rows()<1) sql_query("UPDATE $option[prefix]_domains SET visits=visits+$row[5],hits=hits+$row[4] WHERE tld='unknown' $append");
    }
  // INDIRIZZI IP
  if($modulo[10]){
	$ip_c=sprintf("%u",ip2long($row[0]));
    sql_query("UPDATE $option[prefix]_ip SET visits=visits+$row[5],hits=hits+$row[4],date='$date' WHERE ip='$ip_c' $append");
    if(mysql_affected_rows()<1) sql_query("INSERT INTO $option[prefix]_ip VALUES('$ip_c','$date','$row[4]','$row[5]')");
    if($option['prune_2_on']) prune("$option[prefix]_ip",$option['prune_2_value']);
    }
  }
  if($user_id_tmp=="")
    {
    // CANCELLO IL DATO IN CACHE "SCADUTO"
    sql_query("DELETE FROM $option[prefix]_cache WHERE visitor_id='$row[3]' LIMIT 1");
    // SCRIVO LA PAGINA DI USCITA DAL SITO
	if($modulo[3]) sql_query("UPDATE $option[prefix]_pages SET outs=outs+1 WHERE data='$row[2]' $append");
    }
	else
	// DEPURO DEI DATI IMMESSI NEL DATABASE PRINCIPALE
    sql_query("UPDATE $option[prefix]_cache SET visits='0',hits='0',giorno='$data_oggi' WHERE visitor_id='$row[3]' $append");
  } // Fine trasferimento
return(1);
}
?>