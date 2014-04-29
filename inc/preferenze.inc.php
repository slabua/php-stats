<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

      if(isset($_POST['whatview'])) $whatview=$_POST['whatview']; else $whatview="";
       if(isset($_POST['scstyle'])) $scstyle=$_POST['scstyle']; else $scstyle="";
	  if(isset($_POST['scdigits'])) $scdigits=$_POST['scdigits']; else $scdigits="";
       if(isset($_GET['newstyle'])) $newstyle=addslashes($_GET['newstyle']); else $newstyle="";

function preferenze() {
global $db,$is_loged_in,$opzioni,$error,$style,$modulo,$string,$pref,$varie,$option,$option_new,$php_stats_esclusion,$whatview,$newstyle,$scstyle,$scdigits,$phpstats_title;
$return="";
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$pref['opzioni'];
//
  if($opzioni=="applica")
    {
    // MOTIVI DI SICUREZZA
    foreach($option_new as $key => $value) $option_new_2[$key]=addslashes($value);
    $ok=1;
    $return.="<br><center>";
    if($option_new_2['admin_pass']!="" OR $option_new_2['pass_confirm']!="") { if($option_new_2['admin_pass']!=$option_new_2['pass_confirm']) { $errore=$error[pref_01]; $ok=0;} }
    if($option_new_2['admin_pass']=="") {$option_new_2['admin_pass']=$option['admin_pass'];}
    if($ok) if(checktext($option_new_2['prune_0_value'])) { $errore=$error['pref_02']; $ok=0; }
    if($ok) if(checktext($option_new_2['prune_1_value'])) { $errore=$error['pref_03']; $ok=0; }
    if($ok) if(checktext($option_new_2['prune_2_value'])) { $errore=$error['pref_03']; $ok=0; }
    if($ok) if(checktext($option_new_2['prune_3_value'])) { $errore=$error['pref_03']; $ok=0; }
    if($ok) if(checktext($option_new_2['prune_4_value'])) { $errore=$error['pref_03']; $ok=0; }
    if($ok) if(checktext($option_new_2['prune_5_value'])) { $errore=$error['pref_03']; $ok=0; }
	if($ok) if(checktext($option_new_2['auto_opt_every'])) { $errore=$error['pref_07']; $ok=0; }
    if($ok) if(checktext($option_new_2['starthits']))     { $errore=$error['pref_04']; $ok=0; }
    if($ok) if(checktext($option_new_2['startvisits']))   { $errore=$error['pref_05']; $ok=0; }
    if($ok) if(checktext($option_new_2['ip_timeout']))    { $errore=$error['pref_06']; $ok=0; }
    if($ok) if(checktext($option_new_2['page_timeout']))  { $errore=$error['pref_06']; $ok=0; }
	if($ok)
    {
	// Calcolo la stringa di identificazione dei moduli
    $option_new_2['moduli']="";
	for($i=0;$i<11;$i++)
      {
      $x="moduli_$i";
	  $y="moduli_m_$i";
	  if(!isset($option[$y])) $option[$y]=0;
      if(isset($option[$x])) 
	    { 
		  if($option[$x]==1) 
		    {
			if($option[$y]==1)
			$value=2;
			else
			$value=1; 
		    }
		  else $value=0; 
		} 
		else $value=0;
      $option_new_2['moduli'].=$value."|";
      }
	for($i=0;$i<6;$i++)
      {
	  if(isset($option_new_2["prune_".$i."_on"]))
      if($option_new_2["prune_".$i."_on"]!=1) $option_new_2["prune_".$i."_on"]=0; else $option_new_2["prune_".$i."_on"]=1;
	  else
	  $option_new_2["prune_".$i."_on"]=0;
      }
	if(!isset($option_new_2['report_w_on'])) $option_new_2['report_w_on']=0;
	if(!isset($option_new_2['auto_optimize'])) $option_new_2['auto_optimize']=0;

    // Limito l'ip timeout
	if($option_new_2['ip_timeout']<1) $option_new_2['ip_timeout']=1;
	if($option_new_2['ip_timeout']>24) $option_new_2['ip_timeout']=24;

	// Limito il page timeout
	if($option_new_2['page_timeout']<60) $option_new_2['page_timeout']=60;
	if($option_new_2['page_timeout']>3600) $option_new_2['page_timeout']=3600;
		
	// APPORTO LE MODIFICHE
    $totale=0;
	while(list($key,$value)=each($option_new_2))
      {
      sql_query("UPDATE $option[prefix]_config SET value='$value' WHERE name='$key'");
      $totale+=@mysql_affected_rows();
      }
	// CALCOLO IL PROSSIMO REPORT  
	$next=mktime(0,0,0,date("m"),(date("d")-date("w")+$option_new_2['report_w_day']+7),date("Y"));
	$oggi=time()-$option_new_2['timezone'];
	if($next-$oggi>604800) $next=$next-604800;
	sql_query("UPDATE $option[prefix]_config SET value='$next' WHERE name='report_w'");
	$totale+=@mysql_affected_rows();

    // VERIFICO CHE SIA AVVENUTO ALMENO UN UPDATE
    if($totale<1)
      {
      $body="$pref[not_done]";
      if(mysql_error()!="") $body.="<br><br>".str_replace("%error%",mysql_error(),$error[error_decl]);
      $return.=info_box($string['error'],$body);
      }
      else
      {
      $return.=info_box($string['information'],$pref['done']);
      }
    }
    else
    {
    $body="$errore<br><br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
    $return.=info_box($string['error'],$body);
    }
  }
  else
  {
  //foreach($option as $key => $value) $option[$key]=stripslashes($value);
  
  $return.="<br>\n<form action=\"admin.php?action=preferenze&opzioni=applica\" method=\"post\">";
  $return.="\n<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="\n\t<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\">$pref[opzioni]</span></td></tr>";
  $return.="</select></td></tr>";
  // STATS ABILITATE
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[stats_disabled]</span></td><td bgcolor=$style[table_bgcolor]><select name=\"option_new[stats_disabled]\">";
  $return.="\n\t\t<option value=\"1\""; if($option['stats_disabled']==1) { $return.="selected"; } $return.=">$pref[stats_disabled_yes]</option>";
  $return.="\n\t\t<option value=\"0\""; if($option['stats_disabled']!=1) { $return.="selected"; } $return.=">$pref[stats_disabled_no]</option>";
  // SCELTA LINGUA
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[lang]</span></td><td bgcolor=$style[table_bgcolor]><select name=\"option_new[language]\">";
  // Inizio lettura directory LINGUE
  $location="lang/";
  $hook=opendir($location);
  while(($file=readdir($hook)) !== false)
     {
     if($file != "." && $file != "..")
       {
       $path=$location . "/" . $file;
       if(is_dir($path)) $elenco0[]=$file;
       }
     }
  closedir($hook);
  natsort($elenco0);
  // Fine lettura directory LANG
  while(list ($key, $val)=each ($elenco0)) 
    {
    $val=chop($val);
    // Leggo il nome della lingua
    $language_name=file("lang/$val/lang.name");
    $return.="\n\t\t<option value=\"$val\""; if($option['language']=="$val") { $return.="selected"; } $return.=">$language_name[0]</option>";
    }
  $return.="</select></td></tr>";
  
  // COSA VISUALIZZO NELLE PAGINE?
  //$return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[view]</span></td><td bgcolor=$style[table_bgcolor]><select name=\"option_new[visualizza]\">";
  //$return.="\n\t\t<option value=\"0\""; if($option['visualizza']==0) { $return.="selected"; } $return.=">$pref[view_1]</option>";
  //$return.="\n\t\t<option value=\"1\""; if($option['visualizza']==1) { $return.="selected"; } $return.=">$pref[view_2]</option>";
  //$return.="\n\t\t<option value=\"2\""; if($option['visualizza']==2) { $return.="selected"; } $return.=">$pref[view_3]</option></select></td>";
  //$return.="</tr>";
  
  // QUANTE CIFRE MINIME METTO?
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[cifre_1]</span></td><td bgcolor=$style[table_bgcolor]><select name=\"option_new[cifre]\">";
  $cifrelist=array("1","2","3","4","5","6","7","8");
  while(list ($key, $val)=each ($cifrelist)) 
    {
    $return.="<option value=\"$val\""; if($option['cifre']==$val) { $return.="selected"; } $return.=">$val</option>";
    }
  $return.="</select><span class=\"tabletextA\"> $pref[cifre_2]</span></td></tr>";

  // SCELTA STILE CONTATORE
  $return.="\n\t<tr><td align=\"right\" valign=\"middle\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[style_1]</span></td><td align=\"left\" valign=\"middle\" bgcolor=$style[table_bgcolor]>";
  if($newstyle!="") $val=$newstyle; else $val=$option['stile'];
  if($val=="0") $return.="<span class=\"tabletextA\">".$pref['style_2']."</span>";
    else
    for($i=0; $i<10; $i=$i+1) $return.="<IMG SRC=\"stili/$val/$i.gif\" align=\"middle\">";
  $return.="<INPUT TYPE=\"hidden\" name=\"option_new[stile]\" value=\"".$val."\">";	
  $return.="\n\n<script>";
  $return.="\nfunction view_styles(url) {";
  $return.="\n\tstili=window.open(url,'stili','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=350,HEIGHT=350,LEFT=0,TOP=0');";
  $return.="\n\t}";  
  $return.="\n</script>";  
  $return.="\n<span class=\"tabletextA\"><a href=\"javascript:view_styles('inc/popup_stili.inc.php?currentstyle=$val');\">".$pref['style_edit']."</a></span>";
  $return.="</td></tr>";
  
  // INDIRIZZO E-MAIL
  $return.="\n\t<tr><td width=\"30%\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[user_mail]</span></td><td bgcolor=$style[table_bgcolor]><input type=\"text\" size=\"50\" maxlength=\"60\" name=\"option_new[user_mail]\" value=\"$option[user_mail]\"></td></tr>";

  // PASSWORD
  $return.="\n\t<tr><td width=\"30%\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[pass_1]</span></td><td bgcolor=$style[table_bgcolor]><input type=\"password\" name=\"option_new[admin_pass]\"><span class=\"tabletextA\"> $pref[pass_2]</span></td></tr>";

  // CONFERMA PASSWORD
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[pass_3]</span></td><td bgcolor=$style[table_bgcolor]><input type=\"password\" name=\"option_new[pass_confirm]\"></td></tr>";
  
  // PROTEGGI LE STATISTICHE
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[use_pass]</span></td><td bgcolor=$style[table_bgcolor]><select name=\"option_new[use_pass]\">";
  $return.="<option value=1"; if($option['use_pass']==1) { $return.=" selected"; } $return.=">$pref[si]</option>";
  $return.="<option value=0"; if($option['use_pass']==0) { $return.=" selected"; } $return.=">$pref[no]</option></select></td></tr>";
  
  // TIMEZONE
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[zone_1]</span></td><td bgcolor=$style[table_bgcolor]><select name=\"option_new[timezone]\">\"";
  $timelist=array("-12","-11","-10","-9","-8","-7","-6","-5","-4","-3","-2","-1","0","+1","+2","+3","+4","+5","+6","+7","+8","+9","+10","+11","+12");
  while(list ($key, $val)=each ($timelist)) {
  $return.="\n\t\t<option value=\"$val\""; if($option['timezone']==$val) { $return.="selected"; } $return.=">$val</option>";
  }
  $return.="</select><span class=\"tabletextA\">$pref[zone_2]</span></td></tr>";
  
  // NOME DEL SITO
  $nomesito=str_replace("\"","'",stripcslashes($option['nomesito']));
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[site_name]</span></td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option_new[nomesito]\" value=\"$nomesito\" maxlength=\"200\" size=\"50\"></td></tr>";

  //Server Url
  $return.="\n\t<tr><td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[site_url]</span></td><td bgcolor=$style[table_bgcolor]><textarea name=\"option_new[server_url]\" cols=\"60\" rows=\"4\">$option[server_url]</textarea></td></tr>";

  // TEMPLATES
  $location="templates/";
  $hook=opendir($location);
  while(($file=readdir($hook))!==false)
     {
     if($file!="." && $file!="..")
       {
       $path=$location."/".$file;
       if(is_dir($path)) $elenco2[]=$file;
       }
     }
  closedir($hook);
  natsort($elenco2);
  // Fine lettura directory TEMPLATES
  $return.="\n\t<tr><td valign=\"top\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[template]</span></td><td bgcolor=$style[table_bgcolor]>";
  while(list ($key, $val)=each ($elenco2))
    {
    $val=chop($val);
    $return.="\n\t\t<input type=\"radio\" name=\"option_new[template]\" value=\"$val\" ";
    if($val==$option['template']) $return.="checked";
    $return.=" class=\"radio\"> <span class=\"tabletextA\"><b>$val</b> </span><br>";
    }
  $return.="</td></tr>";
  
  // Accessi e visite di partenza
  $return.="\n\t<tr><td bgcolor=$style[table_bgcolor] valign=\"top\" align=\"right\"><span class=\"tabletextA\">$pref[starthits]</span></td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option_new[starthits]\" value=\"$option[starthits]\" maxlength=\"8\" size=\"8\"></td></tr>";
  $return.="\n\t<tr><td bgcolor=$style[table_bgcolor] valign=\"top\" align=\"right\"><span class=\"tabletextA\">$pref[startvisits]</span></td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option_new[startvisits]\" value=\"$option[startvisits]\" maxlength=\"8\" size=\"8\"></td></tr>";
  
  // Gestione moduli
  $return.="\n\t<tr><td valign=\"top\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[moduli_desc]</span></td><td bgcolor=$style[table_bgcolor]>";
  for($i=0;$i<11;$i++)
    {
    $x="moduli_$i";
    if($modulo[$i]>0):
    $return.="\n\t\t<input type=\"checkbox\" name=\"option[moduli_$i]\" value=\"1\" class=\"checkbox\" checked><span class=\"tabletextA\">".$pref[$x]."</span><br>";
    else:
    $return.="\n\t\t<input type=\"checkbox\" name=\"option[moduli_$i]\" value=\"1\" class=\"checkbox\"> <span class=\"tabletextA\">".$pref[$x]."</span><br>";
    endif;
    if(($i==1) || ($i==3)|| ($i==4) || ($i==5)) {
	$x="moduli_".$i."_m";
	  if($modulo[$i]=="2")
      $return.="<img src=\"templates/$option[template]/images/arrow_dx_dw.gif\"><input type=\"checkbox\" name=\"option[moduli_m_$i]\" value=\"1\" class=\"checkbox\" checked><span class=\"tabletextA\">".$pref[$x]."</span><br>";
      else
      $return.="<img src=\"templates/$option[template]/images/arrow_dx_dw.gif\"><input type=\"checkbox\" name=\"option[moduli_m_$i]\" value=\"1\" class=\"checkbox\"> <span class=\"tabletextA\">".$pref[$x]."</span><br>";
    }
  }
  $return.="</td></tr>";

  // PRUNING
  $return.="\n\t<tr><td valign=\"top\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[pruning]</span></td>";
  $return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[prune_0_on]\" value=\"1\" class=\"checkbox\"";
  if($option['prune_0_on']==1) $return.=" checked";
  $return.=">";
  $tmp=$pref['prune_0'];
  $return.=str_replace("%value%","<input name=\"option_new[prune_0_value]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[prune_0_value]\">",$tmp);
  
  $return.="<br>";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[prune_1_on]\" value=\"1\" class=\"checkbox\"";
  if($option['prune_1_on']==1) $return.=" checked";
  $return.=">";
  $tmp=$pref['prune_1'];
  $tmp=str_replace("%table_prefix%",$option['prefix'],$tmp);
  $return.=str_replace("%value%","<input name=\"option_new[prune_1_value]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[prune_1_value]\">",$tmp);
  $return.="<br>";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[prune_2_on]\" value=\"1\" class=\"checkbox\"";
  if($option['prune_2_on']==1) $return.=" checked";
  $return.=">";
  $tmp=$pref['prune_2'];
  $tmp=str_replace("%table_prefix%",$option['prefix'],$tmp);
  $return.=str_replace("%value%","<input name=\"option_new[prune_2_value]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[prune_2_value]\">",$tmp);
  $return.="<br>";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[prune_3_on]\" value=\"1\" class=\"checkbox\"";
  if($option['prune_3_on']==1) $return.=" checked";
  $return.=">";
  $tmp=$pref['prune_3'];
  $tmp=str_replace("%table_prefix%",$option['prefix'],$tmp);
  $return.=str_replace("%value%","<input name=\"option_new[prune_3_value]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[prune_3_value]\">",$tmp);
  $return.="<br>";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[prune_4_on]\" value=\"1\" class=\"checkbox\"";
  if($option['prune_4_on']==1) $return.=" checked";
  $return.=">";
  $tmp=$pref['prune_4'];
  $tmp=str_replace("%table_prefix%",$option['prefix'],$tmp);
  $return.=str_replace("%value%","<input name=\"option_new[prune_4_value]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[prune_4_value]\">",$tmp);
  $return.="<br>";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[prune_5_on]\" value=\"1\" class=\"checkbox\"";
  if($option['prune_5_on']==1) $return.=" checked";
  $return.=">";
  $tmp=$pref['prune_5'];
  $tmp=str_replace("%table_prefix%",$option['prefix'],$tmp);  
  $return.=str_replace("%value%","<input name=\"option_new[prune_5_value]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[prune_5_value]\">",$tmp);
  $return.="<br>";
  $return.="\n\t\t<input type=\"checkbox\" name=\"option_new[auto_optimize]\" value=\"1\" class=\"checkbox\"";
  if($option['auto_optimize']==1) $return.=" checked"; $return.=">";
  $tmp=str_replace("%HITS%","<input name=\"option_new[auto_opt_every]\" type=\"text\" size=\"5\" maxlength=\"5\" value=\"$option[auto_opt_every]\">",$pref['auto_optimize']);
  $return.="$tmp";
  $return.="</span></td></tr>";

  // REPORT VIA MAIL
  $return.="\n\t<tr><td valign=\"top\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[report_title]</span></td>";
  $return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
  $return.="<input type=\"checkbox\" name=\"option_new[report_w_on]\" value=\"1\" class=\"checkbox\"";
  if($option['report_w_on']==1) $return.=" checked";
  $return.=">";
  $tmp="<select name=\"option_new[report_w_day]\">";
  $i=0;  
    foreach($varie['days'] as $val) 
    {
    $tmp.="<option value=\"$i\""; if($option['report_w_day']=="$i") { $tmp.="selected"; } $tmp.=">$val</option>";
    $i++;
    }
  $tmp.="</select>";
  $return.=str_replace("%day%",$tmp,$pref['report_desc']);
  $return.="</span></td></tr>";
  
  // TIMEOUT
  $return.="\n\t<tr><td valign=\"top\" align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$pref[timeout]</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
  $return.=str_replace("%value%","<input name=\"option_new[ip_timeout]\" type=\"text\" size=\"2\" maxlength=\"2\" value=\"$option[ip_timeout]\">",$pref['ip_timeout']);
  $return.="<br>";
  $return.=str_replace("%value%","<input name=\"option_new[page_timeout]\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"$option[page_timeout]\">",$pref['page_timeout']);
  $return.="</span></td></tr>";

  // SUBMIT
  $return.="\n\t<tr><td bgcolor=$style[table_bgcolor] colspan=\"2\"><center><input type=\"Submit\" value=\"$pref[salva]\"></center></td></tr>";
  $return.="\n</table>\n</form>";


  
   ///////////////////////////////
  // GENERA CODICE MONITORAGGIO //
  ////////////////////////////////
  $return.="\n<br><br>";
  $return.="<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr><td bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\">$pref[main_codescript]</span></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor]><center>";
  $return.="<textarea name=\"mainscript\" cols=\"100%\" rows=\"6\">";
  $return.="<script language=\"javascript\" src=\"$option[script_url]/php-stats.js.php\"></script>\n<noscript><img src=\"$option[script_url]/php-stats.php\" border=\"0\" alt=\"\"></noscript>";
  $return.="</textarea></center><br>";
  $return.="</td></tr></table><BR>";
  
  
  ///////////////////
  // GENERA CODICE //
  ///////////////////
  $return.="\n<br><br>\n<form action=\"admin.php?action=preferenze#scriptgenerator\" method=\"post\">";
  $return.="<a name=\"scriptgenerator\"></a><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr><td bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\">$pref[codescript]</span></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor]><center>";
  $return.="\n\n\t<table border=\"0\" $style[table_header] width=\"100%\" align=\"center\">";
  $return.="\n\t\t<tr><td align=\"right\"><span class=\"tabletextA\">$pref[cs_mode]</span></td>";
  $return.="<td><select name=\"whatview\">";
  for($i=0;$i<5;$i++) {
  $return.="<option value=\"$i\""; if($whatview==$i) $return.=" selected"; $return.=">".$pref["cs_view_$i"]."</option>";
  }
  $return.="</select></td></tr>";
  
  $return.="\n\t\t<tr><td align=\"right\"><span class=\"tabletextA\">$pref[cs_style]</span></td>";
  $return.="<td><select name=\"scstyle\">";
  $return.="<option value=\"\""; if($scstyle=="") $return.=" selected"; $return.=">$pref[cs_style_defalut]</option>"; // Stile di default
  $return.="<option value=\"0\""; if($scstyle=="0") $return.=" selected"; $return.=">0</option>"; // Stile testuale
  $location="stili/";
  $hook=opendir($location);
  while(($file=readdir($hook))!==false)
     {
     if($file!="." && $file!="..")
       {
       $path=$location."/".$file;
       if(is_dir($path)) $elenco[]=$file;
       }
     }
  closedir($hook);
  natsort($elenco);;
  while(list($key,$val)=each($elenco)) {
    $val=chop($val);
    $return.="<option value=\"$val\""; if($scstyle==$val) $return.=" selected"; $return.=">$val</option>";
    }
  $return.="</select></td></tr>";
  $return.="\n\t\t<tr><td align=\"right\"><span class=\"tabletextA\">$pref[cs_digits]</class></td>";
  $return.="<td><select name=\"scdigits\">";
  $return.="<option value=\"\">$pref[cs_style_defalut]</option>";
  for($i=1;$i<9;$i++) 
    {
	$return.="<option value=\"$i\""; if($scdigits==$i) $return.=" selected"; $return.=">$i</option>";
	}
  $return.="</td></tr>";
  $return.="</table>";
  $return.="<center><textarea name=\"scriptcode\" cols=\"100%\" rows=\"2\">";
  $code="<script language=\"JavaScript\" src=\"$option[script_url]/view_stats.js.php";
  if($whatview!="") $code.="?mode=$whatview";
  if($scstyle!="")
    {
	if($whatview=="") $code.="?"; else $code.="&";
	$code.="style=$scstyle"; 
	}
  if(($scdigits>0) && ($scdigits!="")) 
    {
    if($scstyle=="" && $whatview=="") $code.="?"; else $code.="&";
	$code.="digits=$scdigits"; 
	}
  $code.="\"></script>";
  $return.=$code."</textarea></center><br>";
  $return.="<center><input type=\"submit\" value=\"$pref[submitcode]\"></center><br>";
  $code=stripslashes($code);
  $return.="<span class=\"tabletextA\">".$pref['preview_code']." ".$code."</span>";
  $return.="</form></td></tr></table><BR>";



  ///////////////////////////////
  // REFRESH MOTORI DI RICERCA //
  ///////////////////////////////
  $return.="\n<br><br>\n<form action=\"admin.php?action=refresh\" method=\"post\">";
  $return.="<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr><td bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\">$pref[refresh]</span></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor]><center><span class=\"tabletextA\">$pref[refresh_desc]</span><br><br><input type=\"Submit\" value=\"$pref[refresh_go]\"></center><br></td></tr>";
  $return.="</form></table>";
    
  }
return($return);
}
?>
