<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

$date=time()-$option['timezone']*3600;
$mese=date("m",$date);
$anno=date("Y",$date);

if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
     if(isset($_GET['mese'])) list($sel_anno,$sel_mese)=explode("-",addslashes($_GET['mese']));
     if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else $mode=0;

function weekly() {
global $db,$option,$string,$error,$varie,$style,$mode,$mese,$anno,$sel_anno,$sel_mese,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['weekly_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['weekly_title'];
//
$accessi=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0);
$hits=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0);
$hits_tot=0;
$accs_tot=0;
$hits_max=1;
$accs_max=1;

// Costruzione query
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
if($mode==1) $result=sql_query("select * from $option[prefix]_daily");
        else $result=sql_query("select * from $option[prefix]_daily WHERE data LIKE '$sel_anno-$sel_mese-%'");

// Lettura risultati
while($row=@mysql_fetch_array($result))
  {
  list($anno,$mese,$giorno)=explode("-",$row[0]);
  $oggi=date("w",mktime (0,0,0,$mese,$giorno,$anno));
  $hits[$oggi]+=$row[1];
  $accessi[$oggi]+=$row[2];
  $hits_tot+=$row[1];
  $accs_tot+=$row[2];
  }
$hits_max=max($hits);
$accs_max=max($accessi); 

$return="";
// Titolo
$return.="<span class=\"pagetitle\">$phpstats_title<br><br></span>";
//
$return.="<table border=\"0\" width=\"90%\" $style[table_header] align=\"center\" >";
$return.="<tr><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[weekly_day]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[weekly_hits]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td></tr>";
for($i=0;$i<7;$i++)
  {
  $oggi=$varie['days'][$i];
  $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
  $return.="<td bgcolor=$style[table_bgcolor] align=\"right\" width=\"150\"><span class=\"tabletextA\">$oggi</span></td>";
  $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$hits[$i]</b></span><br><span class=\"tabletextA\"><b>$accessi[$i]</b></span></td>";
  $return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($hits[$i]/max($hits_max,1)*250)."\" height=\"7\"> (".round($hits[$i]*100/max($hits_tot,1),1)."%)</span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($accessi[$i]/max($hits_max,1)*250)."\" height=\"7\"> (".round($accessi[$i]*100/max($accs_tot,1),1)."%)</span></td></tr>";
  }
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"3\" nowrap></td></tr>";
$return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"3\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"3\" nowrap></td></tr>";
$return.="</table>";  

// BOX SCELTA MESE
$return.="<br><br><center><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
if($mode==0)
  {
  // SELEZIONE MESE DA VISUALIZZARE
  $return.="<tr><td colspan=\"2\"><span class=\"testo\">";
  $return.="<form action='./admin.php?action=weekly' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
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
  $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=weekly&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[weekly_vis_glob]</a></span></td></tr>";
  }
  else
  {
  $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=weekly&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[weekly_vis_mens]</a></span></td></tr>";
  }
$return.="</table></center>";
// FINE SCELTA MESE

return($return);
}
?>