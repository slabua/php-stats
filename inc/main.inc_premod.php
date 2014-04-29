<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

if(!isset($_SERVER)) $_SERVER=$HTTP_SERVER_VARS;
function main() {
global $db,$option,$style,$string,$varie,$modulo,$tabelle,$_SERVER,$phpstats_title;

// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['main_title'];

// Var definition
$hits_questo_mese=0;
$visite_questo_mese=0;
$oggi=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
$this_year=date("Y",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
$ieri=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-1,date("Y")));
$questo_mese=date("Y-m-",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
if ((int)date("d") < 25)
    $scorso_mese=date("Y-m-",mktime(date("G")-$option['timezone'],date("i"),0,date("m")-1,date("d"),date("Y")));
else
    $scorso_mese=date("Y-m-",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-31,date("Y")));
// ACCESSI TOTALI
$result=sql_query("SELECT * FROM $option[prefix]_counters");
list($hits_totali,$visite_totali)=@mysql_fetch_row($result);
// AGGIUNGO ACCESSI DI PARTENZA
$hits_totali_glob=$hits_totali+$option['starthits'];
$visite_totali_glob=$visite_totali+$option['startvisits'];
// MODULO 6
if($modulo[6]):

  $result=sql_query("SELECT SUM(hits),SUM(visits) FROM $option[prefix]_daily WHERE data='$oggi'");
  list($hits_oggi,$visite_oggi)=@mysql_fetch_array($result);
  if(!isset($hits_oggi)) $hits_oggi=0;
  if(!isset($visite_oggi)) $visite_oggi=0;

  $result=sql_query("SELECT SUM(hits),SUM(visits) FROM $option[prefix]_daily WHERE data='$ieri'");
  list($hits_ieri,$visite_ieri)=@mysql_fetch_array($result);
  if(!isset($hits_ieri)) $hits_ieri=0;
  if(!isset($visite_ieri)) $visite_ieri=0;

  $result=sql_query("SELECT SUM(hits),SUM(visits) FROM $option[prefix]_daily WHERE data LIKE '$questo_mese%'");
  list($hits_questo_mese,$visite_questo_mese)=@mysql_fetch_array($result);
  if(!isset($hits_questo_mese)) $hits_questo_mese=0;
  if(!isset($visite_questo_mese)) $visite_questo_mese=0;

  $result=sql_query("SELECT SUM(hits),SUM(visits) FROM $option[prefix]_daily WHERE data LIKE '$scorso_mese%'");
  list($hits_scorso_mese,$visite_scorso_mese)=@mysql_fetch_array($result);
  if(!isset($hits_scorso_mese)) $hits_scorso_mese=0;
  if(!isset($visite_scorso_mese)) $visite_scorso_mese=0;

  $result=sql_query("SELECT SUM(hits),SUM(visits) FROM $option[prefix]_daily WHERE data LIKE '%$this_year%'");
  list($hits_this_year,$visite_this_year)=@mysql_fetch_array($result);
  if(!isset($hits_this_year)) $hits_this_year=0;
  if(!isset($visite_this_year)) $visite_this_year=0;

  //  Giorni trascorsi
  $result=sql_query("SELECT * FROM $option[prefix]_daily ORDER BY data ASC LIMIT 0,1");
  if(mysql_affected_rows()>0) {
    while($row=@mysql_fetch_array($result)) {
      list($anno_y,$mese_y,$giorno_y)=explode("-","$row[0]");
        $data=explode("-",$row[0]);
        $started=str_replace("%mount%",formatmount($data[1]),$varie['date_format']);
        $started=str_replace("%day%",$data[2],$started);
        $started=str_replace("%year%",$data[0],$started);
      }
    list($anno_t,$mese_t,$giorno_t)=explode("-","$oggi");
    $trascorsi=(mktime(0,0,0,$mese_t,$giorno_t,$anno_t)-mktime (0,0,0,$mese_y,$giorno_y,$anno_y))/86400;
	}
	else
	{
	$trascorsi=0;
	$started="-";
	}

endif;

if($modulo[3]):
  // Tempi medi di visita sito-pagine
  $tocount_pages=0;
  $visits_pages=0;
  $presence_pages=0;
  $result=sql_query("SELECT SUM(tocount),SUM(visits),SUM(presence) FROM $option[prefix]_pages");
  list($tocount_pages,$visits_pages,$presence_pages)=@mysql_fetch_row($result);
  if($tocount_pages>0) $tempo_pagina=round(($presence_pages/$tocount_pages),0); else $tempo_pagina=0;
  $tempo_visita=round(($hits_totali/max(1,$visite_totali))*$tempo_pagina,0);

  // Utenti On-Line
  if($option['online_timeout']>0) $tmp=$option['online_timeout']*60;
                             else $tmp=$tempo_pagina*1.3;
  $date=(time()-($option['timezone']*3600)-($tmp));
  $result_ol=sql_query("SELECT data FROM $option[prefix]_cache WHERE data>$date");
  $online=@mysql_num_rows($result_ol);
endif;

if($modulo[4]):
  $result=sql_query("SELECT SUM(visits) FROM $option[prefix]_referer");
  list($total_referer)=mysql_fetch_row($result);
  if(!$total_referer) $total_referer=0;

  $result=sql_query("SELECT SUM(visits) FROM $option[prefix]_query");
  list($total_engine)=mysql_fetch_row($result);
  if(!$total_engine) $total_engine=0;
endif;

if($modulo[6]):
// GIORNO "MIGLIORE"
$result=sql_query("SELECT data, hits FROM $option[prefix]_daily ORDER BY hits DESC LIMIT 1");
if(mysql_num_rows($result)>0) {
  list($max_hits_data,$max_hits)=@mysql_fetch_row($result);
  $data=explode("-",$max_hits_data);
  $max_hits_data=str_replace("%mount%",formatmount($data[1]),$varie['date_format']);
  $max_hits_data=str_replace("%day%",$data[2],$max_hits_data);
  $max_hits_data=str_replace("%year%",$data[0],$max_hits_data);
  }
else { $max_hits="-"; $max_hits_data="-"; }
// GIORNO "PEGGIORE"
$result=sql_query("SELECT data, hits FROM $option[prefix]_daily ORDER BY hits ASC LIMIT 1");
if(mysql_num_rows($result)>0) {
  list($min_hits_data,$min_hits)=@mysql_fetch_row($result);
  $data=explode("-",$min_hits_data);
  $min_hits_data=str_replace("%mount%",formatmount($data[1]),$varie['date_format']);
  $min_hits_data=str_replace("%day%",$data[2],$min_hits_data);
  $min_hits_data=str_replace("%year%",$data[0],$min_hits_data);
  }
else { $min_hits="-"; $min_hits_data="-"; }
endif;

////////////////////////////////////
// VISUALIZZO I DATI DEL SOMMARIO //
////////////////////////////////////

$return="\n<center>\n<table width=\"95%\">\n<tr>\n<td valign=\"top\" align=\"center\">";
$return.="\n\n<!--  SHOW STATS SUMMARY -->";
$return.="\n<br>";
$return.="\n<TABLE $style[table_header] width=\"100%\">";
$return.="\n\t<TR><TD bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\"><center>$string[sommario]</center></span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_tot]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$hits_totali_glob</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visitors_tot]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$visite_totali_glob</span></TD>";
if($modulo[4]):
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[main_tot_referer]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$total_referer</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[main_tot_engine]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$total_engine</span></TD>";
endif;
if($modulo[6]):
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_oggi]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$hits_oggi</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visitors_oggi]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$visite_oggi</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_ieri]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$hits_ieri</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visitors_ieri]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$visite_ieri</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_qm]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$hits_questo_mese</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visitors_qm]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$visite_questo_mese</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_sm]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$hits_scorso_mese</span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visitors_sm]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$visite_scorso_mese</span></TD></TR>";

  $result=sql_query("SELECT min(data) FROM $option[prefix]_daily");
  $row=@mysql_fetch_row($result);
  $ini_year=substr($row[0],0,4);
  if(($this_year!=$ini_year) AND ($ini_year!=""))
    {
    $string['hits_qa']=str_replace("%THIS_YEAR%",$this_year,$string['hits_qa']);
    $string['visitors_qa']=str_replace("%THIS_YEAR%",$this_year,$string['visitors_qa']);
    $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_qa]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$hits_this_year</span></TD></TR>";
    $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visitors_qa]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$visite_this_year</span></TD></TR>";
    }
endif;
if($modulo[3]):
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[perm_site]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".formatperm($tempo_visita)."</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[perm_page]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".formatperm($tempo_pagina)."</span></TD>";
endif;
if($modulo[6]):
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[hits_per_day]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".round(($hits_totali-$hits_oggi)/max(1,$trascorsi),1)."</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[visits_per_day]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".round(($visite_totali-$visite_oggi)/max(1,$trascorsi),1)."</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[pages_per_day]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".round($hits_totali/max(1,$visite_totali),1)."</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[stats_start]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$started</span></TD>";
  $tmp=str_replace("%NUM%",$max_hits ,$string['max_hits']);
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$tmp</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$max_hits_data</span></TD>";
  $tmp=str_replace("%NUM%",$min_hits ,$string['min_hits']);
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$tmp</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$min_hits_data</span></TD>";
endif;
if($modulo[3]):
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[usr_online]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$online</span></TD>";
endif;
if($modulo[3]==2):
  list($max_ol,$time_ol)=explode("|",$option['max_online']);
  if($max_ol) {
    $tmp=str_replace("%DATA%",formatdate($time_ol,3),$string['main_max_ol']);
    $tmp=str_replace("%ORA%",formattime($time_ol,3),$tmp);
    $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$tmp</span></TD><TD bgcolor=$style[table_bgcolor] valign=\"top\"><span class=\"tabletextB\">$max_ol</span></TD>";
    }
endif;
$return.="\n\t<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\" height=\"1\"></td></tr>";
$return.="\n</TABLE>\n<center>";


// SEPARATORE
$return.="\n<td width=\"5%\"></td>";

///////////////////
// Database Info //
///////////////////
$return.="\n</td>\n";
if($option['php_stats_safe']!=1):
  $return.="\n<td valign=\"top\" align=middle>";
  $total=0;
  $return.="\n\n<!--  SHOW TABLES DETAILS -->";
  $return.="\n<br>";
  $return.="\n<table $style[table_header] width=\"100%\" border=\"0\">";
  $return.="\n\t<TR><TD align=\"center\" bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\"><center>$string[table_name]</center></span></TD><TD align=\"center\" bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\"><center>$string[db_status_recs]</center></span></TD><TD align=\"center\" bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\"><center>$string[db_status_size]</center></span></TD></TR>";
  $result=sql_query("SHOW TABLE STATUS like '$option[prefix]_%'");
  while($row=@mysql_fetch_array($result))
    {
	// ATTRIBUISCO GLI SPAZI OCCUPATI DELLE TABELLE
    switch ($row[0])
      {
      case '$option[prefix]_browser':
      $tmp=2048;
      break;
      case '$option[prefix]_domains':
      $tmp=6144;
      break;
      case '$option[prefix]_os';
      $tmp=2048;
      break;
      default:
      $tmp=1024;
      break;
      }
    $tmp=($tmp+$row[5])/1024;
    $total+=$tmp;
    $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".str_replace("$option[prefix]_","",$row[0])."</span></td><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[3]</span></td><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".round($tmp,1)." KB</span></td></tr>";
    }
  //}
  $return.="\n\t<tr><td bgcolor=$style[table_bgcolor] colspan=\"3\" height=\"10\" nowrap><center><span class=\"tabletextA\">$string[db_size]</span><span class=\"tabletextB\">".round($total)." KB</span></center></td></tr>";
  $return.="\n\t<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"3\"></td></tr>";
  $return.="\n</table>";
  $return.="\n\n</td>";
  endif;
$return.="\n</tr>\n</table>";

////////////////////
// Utenti On-Line //
////////////////////

if($modulo[3]):
$online=@mysql_num_rows($result_ol);
if($online>0) {
  $return.="\n\n<!--  SHOW USERS ONLINE DETAILS -->";
  $return.="\n\n<script>";
  $return.="\nfunction popup(url) {";
  $return.="\n\tonline=window.open(url,'online','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=570,HEIGHT=350,LEFT=0,TOP=0');";
  $return.="\n\t}";
  $return.="\nfunction whois(url) {";
  $return.="\nwhois=window.open(url,'whois','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=450,HEIGHT=600,LEFT=0,TOP=0');";
  $return.="\n\t}";
  $return.="\n</script>";
  $return.="\n\n<br>";
  $return.="\n<span class=\"pagetitle\"><center>$string[main_online_title]</center></span>";
  $return.="\n<TABLE $style[table_header] width=\"95%\">";
  $return.="\n\t<tr>";
  $return.="\n\t".draw_table_title($string['main_online_ip']);
  $return.="\n\t".draw_table_title($string['main_online_url']);
  $return.="\n\t".draw_table_title($string['main_online_time']);
  $return.="\n\t".draw_table_title($string['main_online_tracking']);
  $return.="\n\t</tr>";
  if($option['online_timeout']>0) $tmp=$option['online_timeout']*60;
                             else $tmp=$tempo_pagina*1.3;
  $date=(time()-($option['timezone']*3600)-($tmp));
  $result=sql_query("SELECT user_id,data,lastpage FROM $option[prefix]_cache WHERE data>$date ORDER BY user_id ASC");
  while($row=@mysql_fetch_array($result))
    {
	if($option['page_title']==1)
	  {
	  $result_title=sql_query("SELECT titlePage FROM $option[prefix]_pages WHERE data='$row[2]' LIMIT 1");
	  if(mysql_affected_rows()>0)
	    {
		list($title_page)=mysql_fetch_row($result_title);
		$title_page=stripslashes($title_page);
		}
		else $title_page="";
	  }
    $return.="\n\t<tr>";
	$return.="\n\t<td align=right bgcolor=$style[table_bgcolor] width=\"50\" nowrap><span class=\"tabletextA\">";
	if($option['ext_whois']=="") $return.="<a href=\"javascript:whois('whois.php?IP=$row[0]');\">$row[0]</a>";
	                        else $return.="<a href=\"".str_replace("%IP%",$row[0],$option['ext_whois'])."\" target=\"_BLANK\">$row[0]</a>";
	$return.="</span></td>";

	$return.="\n\t<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row[2],"",70,35,-30,$title_page)."</span></td>";
	$return.="\n\t<td bgcolor=$style[table_bgcolor] width=\"50\"><span class=\"tabletextA\">".formattime($row[1])."</span></td>";
    $return.="\n\t<td bgcolor=$style[table_bgcolor] width=\"11\"><a href=\"javascript:popup('tracking.php?what=online&ip=$row[0]');\"><img src=\"templates/$option[template]/images/icon_tracking.gif\" border=0 title=\"".$string['main_track_alt']."\"></a></td>";
	$return.="\n\t</tr>";
	}
  $return.="\n\t<tr>";
  $return.="\n\t<td bgcolor=$style[table_title_bgcolor] colspan=\"4\" height=\"1\"></td>";
  $return.="\n\t</tr>";
  $return.="\n</TABLE>";
  }
endif;

/////////////////
// Server Info //
/////////////////
if($option['show_server_details']==1)
  {
  $return.="\n\n<!--  SHOW SERVER DETAILS -->";
  $return.="\n<br>";
  $return.="\n<TABLE $style[table_header] width=\"95%\">";
  $return.="\n\t<TR><TD bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\"><center>$string[main_sysinfo_title]</center></span></TD></TR>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[main_server_os]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".php_uname()."</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[main_server_ws]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".$_SERVER["SERVER_SOFTWARE"]."</span></TD>";
  $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[main_server_php]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">".phpversion()."</span></TD>";
  if(phpversion()>"4.0.5") {
    $mysql_ver=mysql_get_server_info();
    if($mysql_ver=="") $mysql_ver=$string[main_no_mysql_ver];
    $return.="\n\t<TR><TD align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$string[main_mysql_ver]</span></TD><TD bgcolor=$style[table_bgcolor]><span class=\"tabletextB\">$mysql_ver</span></TD>";
    }
  $return.="\n\t<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\" height=\"1\"></td></tr>";
  $return.="\n</TABLE>";
  }

return($return);
}
?>