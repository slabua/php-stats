<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

function report(){
global $db,$option,$style,$varie,$modulo,$mese_oggi;
  
  include("lang/$option[language]/main_lang.inc"); 
  include("inc/admin_func.inc.php");
  
  // PREPARO LA MAIL  
  $site=explode("\n",$option['server_url']);
  $site_url=$site[0];
  $mail_soggetto="Report settimanale statistiche su $site_url";
  $intestazioni ="From: Php-Stats at $site[0]<$option[user_mail]>\n";
  $intestazioni.="X-Sender: <$option[user_mail]>\n";
  $intestazioni.="X-Mailer: PHP-STATS\n"; // mailer
  $intestazioni.="X-Priority: 1\n"; // Messaggio urgente!
  $intestazioni.="Return-Path: <$option[user_mail]>\n";  // Indirizzo di ritorno per errori
  $ver=$option['phpstats_ver'];
  
  // VISITATORI E VISITE TOTALI  
  $hits_this_week=0;
  $visite_this_week=0;
  // Contatori
  $result=sql_query("SELECT * FROM $option[prefix]_counters");
  list($hits,$visits)=@mysql_fetch_row($result);
  $hits_totali=$hits+$option['starthits'];
  $visite_totali=$visits+$option['startvisits'];
  
  // VISITARORI E PAGINE VISITATE NEGLI ULTIMI 7 GIORNI IN DETTAGLIO
  $dettagli="\n";
  for($i=0;$i<=7;$i++)
    {
    $max=0;
    $lista_accessi[$i]=0;
    $lista_visite[$i]=0;
    $giorno=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-$i-1,date("Y")));
    $lista_giorni[$i]=$giorno;
    $result=sql_query("select * from $option[prefix]_daily where data='$giorno'");
    while($row=@mysql_fetch_array($result))
      {
      $lista_accessi[$i]=$row[1];
      $lista_visite[$i]=$row[2];
	  $hits_this_week+=$row[1];
	  $visite_this_week+=$row[2];
      if($row[1]>$max) $max=$row[1];
      }
    }
  for($i=0;$i<=7;$i++)
    {
    $data=explode("-",$lista_giorni[$i]);
    $tmp=str_replace("%mount%", formatmount($data[1]),$varie['date_format']);
    $tmp=str_replace("%day%",$data[2],$tmp);
    $tmp=str_replace("%year%",$data[0],$tmp);
    $giorno=$tmp;
     $toshow=substr("                                   ".$giorno,strlen($giorno));
    $toshow.=substr("               ".$lista_accessi[$i],strlen($lista_accessi[$i]));
    $toshow.=substr("               ".$lista_visite[$i],strlen($lista_visite[$i]));
    $dettagli.="$toshow\n";
    }

  // REFERER (TOP 25)
  $site_referers="";
  if($modulo[4]==2)
    $result=sql_query("select * from $option[prefix]_referer WHERE mese='$mese_oggi' ORDER BY visits DESC LIMIT 25");
    else
    $result=sql_query("select * from $option[prefix]_referer ORDER BY visits DESC LIMIT 25");
  while($row=@mysql_fetch_array($result))
    {
	$site_referers.=$row[0]." (".$row[1].")\n";
	}

  // MOTORI DI RICERCA (TOP 25)
  $site_engines="";
  if($modulo[4]==2)
    $result=sql_query("select * from $option[prefix]_query WHERE mese='$mese_oggi' ORDER BY visits DESC LIMIT 25");
    else
    $result=sql_query("select * from $option[prefix]_query ORDER BY visits DESC LIMIT 25"); 
  while($row=@mysql_fetch_array($result))
    {
	$site_engines.=$row[0]." (".$row[2].", ".$row[1].")\n";
	}
 
  
  // COMPILO IL TEMPLATE
  eval("\$mail_messaggio=\"".gettemplate("lang/$option[language]/report_weekly.tpl")."\";");
  
  // SPEDISCO LA MAIL
  $ok=@mail($option['user_mail'],$mail_soggetto,$mail_messaggio,$intestazioni);
  // Alcuni server mail non accettano le intestazioni, provo a spedire senza intestazioni se l'invio è fallito
  if($ok==False)
    $ok=@mail($option['user_mail'],$mail_soggetto,$mail_messaggio);
  if($ok!=False)
    {
    // SE L'INVIO E' OK PROGRAMMO IL DATABASE PER IL PROSSIMO INVIO
	$next=mktime(0,0,0,date("m"),(date("d")-date("w")+$option['report_w_day']+7),date("Y"));
	$oggi=time()-($option['timezone']*3600);
	if($next-$oggi>604800) $next=$next-604800;
    sql_query("UPDATE $option[prefix]_config SET value='$next' WHERE name='report_w'");
	}
	else
	logerrors("Weekly Report"."|".date("d/m/Y H:i:s")."|FAILED");
}
?>