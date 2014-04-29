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

function os_browser() {
global $db,$string,$error,$style,$option,$mode,$varie,$modulo,$phpstats_title;
global $mese,$anno,$sel_anno,$sel_mese;

// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['os_browser_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['os_browser_title'];

$return="";
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
if($mode==0) $clause="WHERE mese='$sel_anno-$sel_mese' AND os<>''";
        else $clause="WHERE os<>''";
$query_bas=sql_query("SELECT sum(hits),sum(visits) FROM $option[prefix]_systems $clause");
list($total_hits,$total_accessi)=@mysql_fetch_row($query_bas);
$query_tot=sql_query("SELECT os,hits,visits FROM $option[prefix]_systems $clause");
$num_totale=@mysql_numrows($query_tot);
if($num_totale>0)
  {
  $count=0;
  // Titolo sezione OS
  if($mode==0) {
  $tmp=str_replace("%MESE%",formatmount($sel_mese),$string['os_title_2']);
  $tmp=str_replace("%ANNO%",$sel_anno,$tmp); 
  }
  else
  $tmp=$string['os_title'];
  $return.="<span class=\"pagetitle\">$tmp</span>";
  //
  $result=sql_query("SELECT os,SUM(hits) AS dummy,SUM(visits) FROM $option[prefix]_systems $clause GROUP BY os ORDER BY 'dummy' DESC");
  $return.="<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[os_os]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[os_hits]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
  $return.="</tr>";
  while($row=@mysql_fetch_array($result))
    {
	if($row[0]=="?") 
	  {
	  $image="images/os.php?q=unknown";
	  $row[0]=$string['os_unknown'];
	  }
	  else
	  $image=str_replace(" ","-","images/os.php?q=$row[0]");

    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="<td bgcolor=$style[table_bgcolor] width=\"14\"><img src=\"$image\"></td>";
    $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$row[0]</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$row[1]</b></span><br><span class=\"tabletextA\"><b>$row[2]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($row[1]/MAX($total_hits,1)*330)."\" height=\"7\"> (".round($row[1]*100/MAX($total_hits,1),1)."%)</span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($row[2]/MAX($total_accessi,1)*330)."\" height=\"7\"> (".round($row[2]*100/MAX($total_accessi,1),1)."%)</span></td>";
	$return.="</tr>";
    }
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  $return.="</table>";
  $return.="<br><br>";

  //Browser
  // Titolo sezione Browser
  if($mode==0) {
  $tmp=str_replace("%MESE%",formatmount($sel_mese),$string['browser_title_2']);
  $tmp=str_replace("%ANNO%",$sel_anno,$tmp); 
  }
  else
  $tmp=$string['browser_title'];
  $return.="<span class=\"pagetitle\">$tmp</span>";
  //
  $result=sql_query("SELECT bw,SUM(hits) AS dummy,SUM(visits) FROM $option[prefix]_systems $clause GROUP BY bw ORDER BY 'dummy' DESC");
  $return.="<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[browser_bw]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[browser_hits]</center></span></td>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
  $return.="</tr>";
  while($row=@mysql_fetch_array($result))
    {
    if($row[0]=="?") 
	  { 
	  $image="images/browsers.php?q=unknown";
	  $row[0]=$string['browser_unknown'];
	  }
	  else
	  $image=str_replace(" ","-","images/browsers.php?q=$row[0]");
	
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="<td bgcolor=$style[table_bgcolor] width=\"14\"><img src=\"$image\"></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$row[0]</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$row[1]</b></span><br><span class=\"tabletextA\"><b>$row[2]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($row[1]/MAX($total_hits,1)*330)."\" height=\"7\"> (".round($row[1]*100/MAX($total_hits,1),1)."%)</span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($row[2]/MAX($total_accessi,1)*330)."\" height=\"7\"> (".round($row[2]*100/MAX($total_accessi,1),1)."%)</span></td>";
	$return.="</tr>";
    }
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  $return.="</table>";
  }
  else
  {
  if($mode==1)
    $return.=info_box($string['information'],$error['os_bw']);
    else
    {
    $tmp=str_replace("%MESE%",formatmount($sel_mese),$error['os_bw_2']);
	$tmp=str_replace("%ANNO%",$sel_anno,$tmp);
    $return.=info_box($string['information'],$tmp);
	}
  }
if($modulo[1]==2) 
{
  $return.="<br><br><center>";
  if($mode==0)
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="<form action='./admin.php?action=os_browser' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
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
    $return.="<br><br><a href=\"admin.php?action=os_browser&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_glob]</span></a>";
	$return.="</FORM>";
    }
    else
    $return.="<a href=\"admin.php?action=os_browser&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_mens]</span></a>";
  $return.="</center>";
}  
return($return);
}
?>