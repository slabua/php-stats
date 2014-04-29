<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

$date=time()-$option['timezone']*3600;
$mese=date("m",$date);
$anno=date("Y",$date);

if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
    if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
     if(isset($_GET['sort'])) $sort=addslashes($_GET['sort']); else $sort=1; // Default sort
    if(isset($_GET['order'])) $order=addslashes($_GET['order']); else $order=0; // Default order
        if(isset($_GET['q'])) $q=addslashes($_GET['q']); else { if(isset($_POST['q'])) $q=addslashes($_POST['q']); else $q=""; }
     if(isset($_GET['mese'])) list($sel_anno,$sel_mese)=explode("-",addslashes($_GET['mese']));
     if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else if($modulo[4]<2) $mode=1; else $mode=0;
    if(isset($_GET['group'])) $group=addslashes($_GET['group']); else $group=0;

function referer() {
global $db,$string,$error,$varie,$style,$option,$start,$q,$pref,$sort,$order,$group,$mode,$mese,$anno,$sel_anno,$sel_mese,$phpstats_title;
$return="";

// Costruisco la parte di query per i mesi e/o la ricerca
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
    if(($q=="") && ($mode==0)) $q_append=" WHERE mese='$sel_anno-$sel_mese'";
elseif(($q!="") && ($mode==0)) $q_append=" WHERE mese='$sel_anno-$sel_mese' AND data LIKE '%$q%'";
elseif(($q!="") && ($mode!=0)) $q_append=" WHERE data LIKE '%$q%'";
  else $q_append="";

if($group==0) {
// MODALITA' NORMALE, NON RAGGRUPPATA PER DOMINIO

// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['refers_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['refers_title'];

$return.="\n<script>\n";
$return.="function popup(url) {\n";
$return.="test=window.open(url,'nome','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=360,HEIGHT=480,LEFT=0,TOP=0');\n";
$return.="}\n";
$return.="</script>\n";

// ORDINAMENTO MENU e QUERY
$tables=array("pagina"=>"data","visits"=>"dummy","date"=>"date");
$modes=array("0"=>"DESC","1"=>"ASC");
if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="dummy";
if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
$q_append2="$q_sort $q_order";
$rec_pag=100; // risultati visualizzayi per pagina
$query_tot=sql_query("SELECT data FROM $option[prefix]_referer $q_append GROUP BY data");
$num_totale=@mysql_numrows($query_tot);
$numero_pagine=ceil($num_totale/$rec_pag);
$pagina_corrente=ceil(($start/$rec_pag)+1);
$result=sql_query("SELECT data,SUM(visits) as dummy,date,mese FROM $option[prefix]_referer $q_append GROUP BY data ORDER BY $q_append2 LIMIT $start,$rec_pag");
$righe=@mysql_num_rows($result);
if($righe>0) {
  $return.="<span class=\"pagetitle\">$phpstats_title</span><br>";
  if($q!="")
    {
    $string['pages_results']=str_replace("%query%",$q,$string['pages_results']);
    $string['pages_results']=str_replace("%trovati%",$num_totale,$string['pages_results']);
    $return.="<br>$string[pages_results]<br>";
    }
  if($numero_pagine>1)
    {
    $tmp=$varie['pag_x_y'];
    $tmp=str_replace("%current%",$pagina_corrente,$tmp);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
    }
  $return.="<br><table $style[table_header] width=\"95%\" align=\"center\"><tr>";
  $return.=draw_table_title("$string[refers_url]","pagina","admin.php?action=referer&q=$q&group=$group&mode=$mode&mese=$sel_anno-$sel_mese",$tables,$q_sort,$q_order);
  $return.=draw_table_title("$string[refers_date]","date","admin.php?action=referer&q=$q&group=$group&mode=$mode&mese=$sel_anno-$sel_mese",$tables,$q_sort,$q_order);
  $return.=draw_table_title("$string[refers_hits]","visits","admin.php?action=referer&q=$q&group=$group&mode=$mode&mese=$sel_anno-$sel_mese",$tables,$q_sort,$q_order);
  $return.=draw_table_title("$string[refers_tracking]");
  $return.="</tr>";
  $numer_of=(1+(($pagina_corrente-1)*$rec_pag));
  while($row=@mysql_fetch_array($result))
    {
    $row[0]=htmlspecialchars($row[0]);
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	//$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$numer_of</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row[0], "", 60, 25, -30)."</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\">".formatdate($row[2],3)." - ".formattime($row[2])."</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\"><b>$row[1]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\"><a href=\"javascript:popup('tracking.php?what=referer&page=".str_replace("&","§§",$row[0])."')\"><img src=\"templates/$option[template]/images/icon_tracking.gif\" border=0 title=\"$string[refers_alt_1]\"></a></td>";
	$return.="</tr>";
    $numer_of++;
    }
  $return.= "<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  if($numero_pagine>1)
    {
    $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" height=\"20\" nowrap>";
    $return.=pag_bar("admin.php?action=referer&mese=$sel_anno-$sel_mese&q=$q&sort=$sort&order=$order&group=$group&mode=$mode",$pagina_corrente,$numero_pagine,$rec_pag);
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
    }
  $return.="</table>";

  // RICERCA
  if($righe>0) $return.=write_monthly();
  }
  else
  {
  if($q!="")
    {
    $body="$string[no_pages]<br><br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
    $return.=info_box($string['information'],$body);
    }
    else
    {
	if($mode==1)
      $return.=info_box($string['information'],$error['referer']);
      else
      {
      $tmp=str_replace("%MESE%",formatmount($sel_mese),$error['referer_2']);
	  $tmp=str_replace("%ANNO%",$sel_anno,$tmp);
      $return.=info_box($string['information'],$tmp);
	  }
	}
	$return.=write_monthly_of();
  }
} // FINE MODALITA' NORMALE
else
{
// INZIO MODALITA' RAGGRUPPATA PER DOMINIO  

// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['refers_group_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['refers_group_title'];

$return.="\n<script>\n";
$return.="function popup(url) {\n";
$return.="test=window.open(url,'nome','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=570,HEIGHT=340,LEFT=0,TOP=0');\n";
$return.="}\n";
$return.="</script>\n";
//$return.="<span class=\"tabletextA\">$string[refers_title]</span><br>";

// ORDINAMENTO MENU e QUERY
$tables=array("pagina"=>"dom","visits"=>"vis","date"=>"last");
$modes=array("0"=>"DESC","1"=>"ASC");
if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="vis";
if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
$q_append2="$q_sort $q_order";
$rec_pag=100; // risultati visualizzayi per pagina
  
$query_tot=sql_query("SELECT SUBSTRING_INDEX(data,'/',3) as dom FROM $option[prefix]_referer $q_append GROUP BY dom");
$num_totale=@mysql_numrows($query_tot);
$numero_pagine=ceil($num_totale/$rec_pag);
$pagina_corrente=ceil(($start/$rec_pag)+1);
$result=sql_query("SELECT SUBSTRING_INDEX(data,'/',3) as dom, SUM(visits) as vis, MAX(date) as last FROM $option[prefix]_referer $q_append GROUP BY dom ORDER BY $q_append2 LIMIT $start,$rec_pag");
$righe=@mysql_num_rows($result);
if($righe>0) 
  {
  $return.="<span class=\"pagetitle\">$phpstats_title</span><br>";
  if($q!="")
    {
    $string['pages_results']=str_replace("%query%",$q,$string['pages_results']);
    $string['pages_results']=str_replace("%trovati%",$num_totale,$string['pages_results']);
    $return.="<br>$string[pages_results]<br>";
    }
  if($numero_pagine>1)
    {
    $tmp=$varie['pag_x_y'];
    $tmp=str_replace("%current%",$pagina_corrente,$tmp);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
    }
  $return.="<br><table $style[table_header] width=\"95%\" align=\"center\"><tr>";
  $return.=draw_table_title("$string[refers_url_1]","pagina","admin.php?action=referer&group=1&q=$q&group=$group&mode=$mode&mese=$sel_anno-$sel_mese",$tables,$q_sort,$q_order);
  $return.=draw_table_title("$string[refers_date_1]","date","admin.php?action=referer&group=1&q=$q&group=$group&mode=$mode&mese=$sel_anno-$sel_mese",$tables,$q_sort,$q_order);
  $return.=draw_table_title("$string[refers_hits_1]","visits","admin.php?action=referer&group=1&q=$q&group=$group&mode=$mode&mese=$sel_anno-$sel_mese",$tables,$q_sort,$q_order);
  $return.=draw_table_title("$string[refers_tracking]");
  $return.="</tr>";
  $numer_of=(1+(($pagina_corrente-1)*$rec_pag));
  while($row=@mysql_fetch_array($result))
    {
    $row[0]=htmlspecialchars($row[0]);
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row[0], "", 60, 25, -30)."</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\">".formatdate($row[2],3)." - ".formattime($row[2])."</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\"><b>$row[1]</b></span></td>";
	if($mode==0)
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\"><a href=\"javascript:popup('tracking.php?what=referer_domain&domain=".str_replace("&","§§",$row[0])."&mese=$sel_anno-$sel_mese')\"><img src=\"templates/$option[template]/images/icon_tracking.gif\" border=0 title=\"$string[refers_alt_2]\"></a></td>";
	else
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap><span class=\"tabletextA\"><a href=\"javascript:popup('tracking.php?what=referer_domain&domain=".str_replace("&","§§",$row[0])."')\"><img src=\"templates/$option[template]/images/icon_tracking.gif\" border=0 title=\"$string[refers_alt_2]\"></a></td>";
	$return.="</tr>";
    $numer_of++;
    }
  $return.= "<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  if($numero_pagine>1)
    {
    $return.= "<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" height=\"20\" nowrap>";
    $return.=pag_bar("admin.php?action=referer&mese=$sel_anno-$sel_mese&q=$q&sort=$sort&order=$order&group=1&mode=$mode",$pagina_corrente,$numero_pagine,$rec_pag);
    $return.= "<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
    }
  $return.="</table>";

  // RICERCA
  if($righe>0) $return.=write_monthly();
  }
  else
  {
  if($q!="")
    {
    $body="$string[no_pages]<br><br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
    $return.=info_box($string['information'],$body);
    }
    else
    $return.=info_box($string['information'],$error['referer']);
	$return.=write_monthly_of();
  }
}
return($return);
}

function write_monthly() {
global $db,$string,$error,$varie,$style,$option,$start,$q,$pref,$sort,$order,$group,$mode,$mese,$anno,$sel_anno,$sel_mese;
global $modulo;
$return="";
if($group==0) 
  { $new_group=1; $string_group=$string['refers_mode_1']; } 
  else
  { $new_group=0; $string_group=$string['refers_mode_0']; } 
$return.="<br><br><center><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
$return.="<tr><td colspan=\"2\"><span class=\"testo\">";
$return.="<form action='./admin.php?action=referer&group=$group&mode=$mode&mese=$sel_anno-$sel_mese' method='POST' name='form1'>";
$return.="<span class=\"testo\">$string[search]:";
$return.="<input name=\"q\" type=\"text\" size=\"30\" maxlength=\"50\" value=\"$q\">";
$return.="<input type=\"submit\" value=\"$string[go]\">";
$return.="</span></form>";
$return.="</td></tr>";
if($modulo[4]==2) 
  {
  if($mode==0)
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="<tr><td colspan=\"2\"><span class=\"testo\">";
	$return.="<form action='./admin.php?action=referer' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
    $return.="<SELECT name=sel_mese>";
    for($i=1;$i<13;$i++) 
	  {
      $return.="<OPTION value='$i'"; if($sel_mese==$i) $return.=" SELECTED"; $return.=">".$varie['mounts'][$i-1]."</OPTION>";
      }
    $return.="</SELECT>";
    $return.="<SELECT name=sel_anno>";
    $result=sql_query("SELECT min(data) FROM $option[prefix]_daily");
    $row=@mysql_fetch_row($result);
    $ini_y=substr($row[0],0,4);
	if($ini_y=="") $ini_y=$anno;
    for($i=$ini_y;$i<=$anno;$i++)
      {
      $return.="<OPTION value='$i'"; if($sel_anno==$i) $return.=" SELECTED"; $return.=">$i</OPTION>";
      }
    $return.="</SELECT>";
    $return.="<input type=\"submit\" value=\"$string[go]\">";
    $return.="</FORM>";
	$return.="</td></tr>";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=referer&group=$group&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[os_vis_glob]</a></span></td></tr>";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=referer&q=$q&sort=$sort&order=$order&group=$new_group&mode=$mode&mese=$sel_anno-$sel_mese\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string_group</a></span></td></tr>";	
    }
    else
	{
    $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=referer&group=$group&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[os_vis_mens]</a></span></td></tr>";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=referer&q=$q&sort=$sort&order=$order&group=$new_group&mode=$mode\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string_group</a></span></td></tr>";	
	}
  }
$return.="</table></center>";
return($return);
}

function write_monthly_of() {
global $db,$string,$error,$varie,$style,$option,$start,$q,$pref,$sort,$order,$group,$mode,$mese,$anno,$sel_anno,$sel_mese;
global $modulo;
$return="";
if($modulo[4]==2) 
  {
  $return.="<br><br><center><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
  if($mode==0)
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="<tr><td colspan=\"2\"><span class=\"testo\">";
	$return.="<form action='./admin.php?action=referer' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
    $return.="<SELECT name=sel_mese>";
    for($i=1;$i<13;$i++) 
	  {
      $return.="<OPTION value='$i'";
	  if($sel_mese==$i) $return.=" SELECTED";
	  $return.=">".$varie['mounts'][$i-1]."</OPTION>";
      }
    $return.="</SELECT>";
    $return.="<SELECT name=sel_anno>";
    $result=sql_query("SELECT min(data) FROM $option[prefix]_daily");
    $row=@mysql_fetch_row($result);
    $ini_y=substr($row[0],0,4);
	if($ini_y=="") $ini_y=$anno;
    for($i=$ini_y;$i<=$anno;$i++)
      {
      $return.="<OPTION value='$i'";
	  if($sel_anno==$i) $return.=" SELECTED";
	  $return.=">$i</OPTION>";
      }
    $return.="</SELECT>";
    $return.="<input type=\"submit\" value=\"$string[go]\">";
    $return.="</FORM>";
	$return.="</td></tr>";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=referer&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[os_vis_glob]</a></span></td></tr>";
    }
    else
	{
    $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=referer&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[os_vis_mens]</a></span></td></tr>";
	}
  $return.="</table></center>";
  }
return($return);
}
?>
