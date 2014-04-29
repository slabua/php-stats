<?
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

// Troncatura URL //
function formaturl($url, $title='', $maxwidth=60, $width1=15, $width2=-20, $link_title='', $mode=0){
  global $option,$short_url,$style;
  $flag=FALSE;
	
  if(!trim($title)) $title='unknown'; //titolo pagina
  $longurl=(preg_match("/[a-z]:\/\//si", $url) ? $url : "http://$url"); //url lunga (per i link)
	
  if($option['short_url']){//troncatura url
    $tmp=explode("\n",$option['server_url']);
      foreach($tmp as $server){
        $server=trim($server);
          if($server!=''){
            if(strpos($url,$server)===0){
              $url=str_replace($server,'',$url);
              $flag=TRUE;
            }
          }
      }
  }
  
  $isflash=(strpos($url,'.swf?page=')===FALSE ? FALSE : TRUE); //compatibilità flash integration mod
  if($url=='') $url='/';
  
  if($isflash) $icon="<img src=\"templates/$option[template]/images/icon_flash.gif\" border=\"0\">"; //icona flash
  else if($flag) $icon="<img src=\"templates/$option[template]/images/icon_home.gif\" border=\"0\">"; //icona home
  else $icon=''; //nessuna icona

  switch($mode){
    default:
    case 0://visualizza url
      $linktext=(strlen($url)>$maxwidth ? substr($url,0,$width1).'...'.substr($url,$width2) : $url);
      break;
    case 1://visualizza titolo
      $linktext=(strlen($title)>$maxwidth ? substr($title,0,$width1).'...'.substr($title,$width2) : $title);
      break;
    case 2://visualizza titolo (url)
      $maxwidth-=3;//considero lo spazio e le parentesi
      
      $pos=strpos($url,'?');//cerco la query string
      if($pos!==FALSE) $url=substr($url,0,$pos);//taglio la query string
      
      $titlelength=strlen($title);
      $urllength=strlen($url);
      if($titlelength+$urllength>$maxwidth){//controllo se titolo e url sono più lunghe di maxwidth
	$tmp=floor($maxwidth/3);
	if($titlelength<$tmp*2){//uso lo spazio risparmiato per l'url
	  $tmp=$maxwidth-$titlelength;//spazio disponibile per url
	  $width1=floor(($tmp-3)/2);
          $width2=-$width1;
	  $url=substr($url,0,$width1).'...'.substr($url,$width2);
        }
	else if($urllength<$tmp){//uso lo spazio risparmiato per il title
	  $tmp=$maxwidth-$urllength;//spazio disponibile per title
	  $width1=floor(($tmp-3)/2);
          $width2=-$width1;
	  $title=substr($title,0,$width1).'...'.substr($title,$width2);
	}
	else{//title 2/3 di spazio, url 1/3 di spazio
	  $width1=floor(($tmp-3)/2);
          $width2=-$width1;
	  $url=substr($url,0,$width1).'...'.substr($url,$width2);
	  $width1=floor($tmp-3);//($tmp-3)*2/2
          $width2=-$width1;
	  $title=substr($title,0,$width1).'...'.substr($title,$width2);
	}
      }
      $linktext="$title ($url)";
  }
  return "<a href=\"$longurl\" title=\"$link_title\" target=\"_blank\">$icon ".str_replace('\\"', '"', $linktext)."</a>";
}

// Formattazione mese //
function formatmount($mount,$mode=0){ // 0 -> MESE NORMALE 1 -> MESE ABBREVIATO
global $varie;
return($mode==0 ? $varie['mounts'][$mount-1] : $varie['mounts_1'][$mount-1]);
}

// Formattazione ora //
function formattime($time){
return($time!=0 ? date("H:i:s",$time) : "");
}

function formatdate($date,$mode=0){
global $varie;
if($date!=0)
  {
  if($mode==0)
    {
    $tmp=$varie['date_format'];
    $tmp=str_replace("%mount%", formatmount(date("n", $date)),$tmp);
    $tmp=str_replace("%day%",date("j", $date),$tmp);
    $tmp=str_replace("%year%",date("Y", $date),$tmp);
    }
    elseif($mode==1)
    {
    $tmp=$varie['date_format_2'];
    list($anno,$mese)=explode("-",$date);
    $tmp=str_replace("%mount%", formatmount($mese),$tmp);
    $tmp=str_replace("%year%",$anno,$tmp);
    }
    else
    {
    $tmp=$varie['date_format_3'];
    $tmp=str_replace("%mount%",date("m", $date),$tmp);
    $tmp=str_replace("%day%",date("d", $date),$tmp);
    $tmp=str_replace("%year%",date("y", $date),$tmp);
    }
  return($tmp);	
  }  
}

function formatperm($value,$mode=1){
global $varie;
$value=round($value,0);
if($mode==1) 
  {
  $minuti=floor($value/60);
  $secondi=$value-($minuti*60);
  if($secondi<10) $secondi="0".$secondi;
  if($minuti<10) $minuti="0".$minuti;
  $tmp=$varie['perm_format'];
  $tmp=str_replace("%minutes%",$minuti,$tmp);
  $tmp=str_replace("%seconds%",$secondi,$tmp);
  }
  else
  {
  $ore=floor($value/3600);
  $value=$value-($ore*3600);
  $minuti=floor($value/60);
  $secondi=$value-($minuti*60);
  if($ore<10) $ore="0$ore";
  if($secondi<10) $secondi="0$secondi";
  if($minuti<10) $minuti="0$minuti";
  $tmp=$varie['perm_format_2'];
  $tmp=str_replace("%hours%",$ore,$tmp);
  $tmp=str_replace("%minutes%",$minuti,$tmp);
  $tmp=str_replace("%seconds%",$secondi,$tmp);
  }

return($tmp);
}


// Verifica l'esistenza di un file sul server
function checkfile($url) {
global $string,$option;
$url=chop($url);
$url=str_replace(" ","%20",$url);
$check=@fopen($url,"r");
if($check==false) return("<img src=\"templates/$option[template]/images/icon_bullet_red.gif\" title=\"$string[link_broken]\">");
             else return("<img src=\"templates/$option[template]/images/icon_bullet_green.gif\" title=\"$string[link_ok]\">");
}


// Funzione per check dei campi (0=numerico,1=alfanumerico)
function checktext($campo,$mode=0)
{
$ok=0;
if($mode==0) $car_permessi="_1234567890"; else $car_permessi="_abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789_";
$str_lenght=strlen($campo);
for ($i=0; $i<=$str_lenght; $i=$i+1)
  {
  $str_temp=substr($campo,$i-1,1);
  $chk=(strpos($car_permessi,$str_temp) ? strpos($car_permessi,$str_temp)+1 : 0);
  if($chk==0) $ok=1;
  }
return($ok);
}

// Prepara l'HTML dal template
function gettemplate($template) {
$file=file($template);
$template=implode("",$file);
$template=str_replace("\"","",$template);
return $template;
}

// CREA INFOBOX
function info_box($title,$body,$width=200,$cellspacing=10) {
global $style;
$return ="<br><br><table border=\"0\" $style[table_header] width=\"$width\">";
$return.="<tr><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\">$title</span></td>";
$return.="<tr><td align=\"center\" valign=\"middle\" bgcolor=$style[table_bgcolor] nowrap>";
$return.="<table width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"$cellspacing\" border=\"0\"><tr><td align=\"center\" valign=\"middle\"  nowrap>";
$return.="<span class=\"tabletextA\">$body</span></td></tr>";
$return.="</td></tr></table>";
$return.="<tr><td height=\"1\"bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
$return.="</table>";
return($return);
}

function draw_table_title($titolo,$pagina="",$base_url="",$tables="",$q_sort="",$q_order="") {
global $option,$style;
$return="<td bgcolor=$style[table_title_bgcolor] nowrap>";
if($pagina=="")
  {
  $return.="<center><span class=\"tabletitle\">$titolo</span></center></td>";
  }
else
  {
  $return.="<a href=\"$base_url&sort=$pagina";
  if($q_sort==$tables["$pagina"])
    {
    if($q_order=="ASC") $return.="&order=0";
    else
    $return.="&order=1";
    }
  /*  else
    {
    if($q_order=="ASC") $return.="&order=1";
    else
    $return.="&order=0";
    }
    */
  $return.="\">";
  $return.="<center><span class=\"tabletitle\">";
  if($q_sort==$tables["$pagina"])
    {
    if($q_order=="ASC")
      $return.="<img src=\"templates/$option[template]/images/asc_order.gif\" border=0 align=\"middle\"> ";
      else
      $return.="<img src=\"templates/$option[template]/images/dsc_order.gif\" border=0 align=\"middle\"> ";
    }
  $return.="$titolo</span></center></a></td>";
}
return($return);
}

// VISUALIZZA LA BARRA DELLA PAGINAZIONE
function pag_bar($base_url,$pagina_corrente,$numero_pagine,$rec_pag){
global $varie,$style;
  $return="\n\n<center><span class=\"tabletextA\">";
  if($pagina_corrente>1) $return.="\n<a href=\"$base_url&start=".(($pagina_corrente-2)*$rec_pag)."\">$varie[prev]</a>&nbsp&nbsp";
  if(($pagina_corrente>5) AND ($numero_pagine>6)) $pi=$pagina_corrente-2; else $pi=1;
  if($pagina_corrente<($numero_pagine-3))
    {
    if($numero_pagine>6)
      $pf=max(($pagina_corrente+2),6);
      else
      $pf=$numero_pagine;
    }
    else $pf=$numero_pagine;
  if($pi>1) $return.="<a href=\"$base_url&start=0\">1</a>&nbsp... ";
  for($pagina=$pi; $pagina<=$pf; $pagina++)
    {
    if($pagina==$pagina_corrente) $return.="<b>$pagina</b> "; 
	                         else $return.= "<a href=\"$base_url&start=".(($pagina-1)*$rec_pag)."\">".$pagina."</a>&nbsp";
    }
  if(($numero_pagine-$pf)>0) $return.="... <a href=\"$base_url&start=".(($numero_pagine-1)*$rec_pag)."\">$numero_pagine</a>&nbsp";
  if($pagina_corrente<$numero_pagine) $return.= "<a href=\"$base_url&start=".(($pagina_corrente)*$rec_pag)."\">&nbsp$varie[next]</a>";
  $return.="</span></center>";
return($return);
}

// PULIZIA DELLA CACHE E TRASFERIMENTO DATI DALLA CACHE AL DATABASE //
function clear_cache() {
global $option,$modulo;
$result=sql_query("SELECT * FROM $option[prefix]_cache");
if(mysql_affected_rows()>0) {
  $date=time()-$option['timezone']*3600;
  if($option['php_stats_safe']!=1) $append="LIMIT 1"; // MySQL 3.22 dont' have LIMIT in UPDATE select!!!!
  while($row=@mysql_fetch_array($result)) 
    {
    if(($row[4]>0) OR ($row[5]>0)) {
    // determino il mese in formato AAAA-MM
    list($y,$m,$d)=explode("-",$row[11]);
    $mese_oggi=$y."-".$m;  
    // SISTEMI (OS,BW,RESO,COLORS)
    if($modulo[1]):
      $nome_bw=chop(getbrowser($row[8]));
      $nome_os=chop(getos($row[8]));
      $clause="os='$nome_os' AND bw='$nome_bw' AND reso='$row[6]' AND colo='$row[7]'"; if($modulo[1]==2) $clause.=" AND mese='$mese_oggi'";
      sql_query("UPDATE $option[prefix]_systems SET visits=visits+$row[5],hits=hits+$row[4] WHERE $clause $append");
      if(mysql_affected_rows()<1)
	    {
	    $insert="VALUES('$nome_os','$nome_bw','$row[6]','$row[7]','$row[4]','$row[5]','"; if($modulo[1]==2) $insert.="$mese_oggi"; $insert.="')";
	    sql_query("INSERT INTO $option[prefix]_systems $insert");
	    }
    endif;
    // LINGUE (impostate dal browser)
    if($modulo[2]):
      sql_query("UPDATE $option[prefix]_langs SET visits=visits+$row[5],hits=hits+$row[4] WHERE lang='$row[10]' $append");
      if(mysql_affected_rows()<1) sql_query("UPDATE $option[prefix]_langs SET visits=visits+$row[5],hits=hits+$row[4] WHERE lang='unknown' $append");
    endif;  
    // ACCESSI GIORNALIERI 
    if($modulo[6]):
      sql_query("UPDATE $option[prefix]_daily SET visits=visits+$row[5],hits=hits+$row[4] WHERE data='$row[11]' $append");
      if(mysql_affected_rows()<1) sql_query("INSERT INTO $option[prefix]_daily VALUES('$row[11]','$row[4]','$row[5]')");
    endif;
    // COUNTRY
    if($modulo[7]):
      if($option['ip-zone'])
        {
        $ip_number=sprintf("%u",ip2long($row[0])); 
        $result2=sql_query("SELECT tld FROM $option[prefix]_ip_zone WHERE $ip_number BETWEEN ip_from AND ip_to");
        if(mysql_affected_rows()>0) list($domain)=@mysql_fetch_row($result2);  else $domain="unknown";
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
    endif;
    // INDIRIZZI IP
    if($modulo[10]): 
      $ip_c=sprintf("%u",ip2long($row[0]));
      sql_query("UPDATE $option[prefix]_ip SET visits=visits+$row[5],hits=hits+$row[4],date='$date' WHERE ip='$ip_c' $append");
      if(mysql_affected_rows()<1) sql_query("INSERT INTO $option[prefix]_ip VALUES('$ip_c','$date','$row[4]','$row[5]')");
    endif;
    // DEPURO DEI DATI IMMESSI NEL DATABASE PRINCIPALE
    sql_query("UPDATE $option[prefix]_cache SET visits='0',hits='0' WHERE visitor_id='$row[3]' $append"); 
    }
  }
}
}
?>
