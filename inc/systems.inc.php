<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

$date=time()-$option['timezone']*3600;
$mese=date("m",$date);
$anno=date("Y",$date);

    if(isset($_GET['debug'])) $debug=addslashes($_GET['debug']); else $debug=0;
if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
     if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else if($modulo[1]<2) $mode=1; else $mode=0;

function systems() {
global $db,$string,$error,$style,$option,$mode,$varie,$modulo,$phpstats_title;

global $mese,$anno,$sel_anno,$sel_mese;
$limite=50;
$return="";
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
if($mode==0) $clause="WHERE mese='$sel_anno-$sel_mese' AND os<>''";
        else $clause="WHERE os<>''";
$query_bas=sql_query("SELECT sum(hits),sum(visits) FROM $option[prefix]_systems $clause");
list($total_hits,$total_accessi)=@mysql_fetch_row($query_bas);
$query_tot=sql_query("SELECT os,hits,visits FROM $option[prefix]_systems $clause");
$num_totale=@mysql_numrows($query_tot);
// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['systems_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['systems_title'];
//  
if($num_totale>0)
  {
  $count=0;
  $return.="<span class=\"pagetitle\">$phpstats_title</span>";
  $result=sql_query("SELECT os,bw,reso,colo,SUM(hits) as hits,SUM(visits) FROM $option[prefix]_systems $clause GROUP BY os,bw,reso,colo ORDER BY hits DESC");
  $return.="<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[systems_os]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[systems_bw]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[systems_reso]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[systems_colo]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[os_hits]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
  $return.="</tr>";
  while(($row=@mysql_fetch_array($result)) && ($count<$limite))
    {
	$count++;
	($row[0]=="?") ? $image1="images/os.php?q=unknown" : $image1=str_replace(" ","-","images/os.php?q=$row[0]");
	($row[1]=="?") ? $image2="images/browsers.php?q=unknown" : $image2=str_replace(" ","-","images/browsers.php?q=$row[1]");
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
    $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$count</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\"><img src=\"$image1\" align=\"absmiddle\"> $row[0]</span></td>";
    $return.="<td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\"><img src=\"$image2\" align=\"absmiddle\"> $row[1]</span></td>";	
	$return.="<td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\">$row[2]</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\">$row[3] bit</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$row[4]</b></span><br><span class=\"tabletextA\"><b>$row[5]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($row[4]/MAX($total_hits,1)*180)."\" height=\"7\"> (".round($row[4]*100/MAX($total_hits,1),1)."%)</span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($row[5]/MAX($total_accessi,1)*180)."\" height=\"7\"> (".round($row[5]*100/MAX($total_accessi,1),1)."%)</span></td>";
	$return.="</tr>";
    }
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"7\" nowrap></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"7\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"7\" nowrap></td></tr>";
  $return.="</table>";
  }
  else
  {
  $return.=info_box($string['information'],$error['os_bw']);
  }
if($modulo[1]==2) 
{
  $return.="<br><br><center>";
  if($mode==0)
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="<form action='./admin.php?action=systems' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
    $return.="<SELECT name=sel_mese>";
    for($i=1;$i<13;$i++) {
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
      $return.="<OPTION value='$i'";if($sel_anno==$i) $return.=" SELECTED"; $return.=">$i</OPTION>";
      }
    $return.="</SELECT>";
    $return.="<input type=\"submit\" value=\"$string[go]\">";
    $return.="<br><br><a href=\"admin.php?action=systems&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_glob]</span></a>";
    $return.="</FORM>";
    }
    else
    $return.="<a href=\"admin.php?action=systems&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_mens]</span></a>";
  $return.="</center>";
}  
return($return);
}