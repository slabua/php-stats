<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

$date=time()-$option['timezone']*3600;
$mese=date("m",$date);
$anno=date("Y",$date);
    if(isset($_GET['debug'])) $debug=addslashes($_GET['debug']); else $debug=0;
if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
     if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else if($modulo[5]<2) $mode=1; else $mode=0;

function hourly() {
global $db,$option,$string,$error,$varie,$style,$mode,$modulo,$phpstats_title;
global $mese,$anno,$sel_anno,$sel_mese;
$return="";
$max=0;
$max_min=30;

// INIZIALIZZO LE VARIABILI
for($i=0;$i<24;$i++) { 
  $lista_accessi[$i]=0;
  $lista_visite[$i]=0;
  }
					 
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
if($mode==0) $clause="WHERE mese='$sel_anno-$sel_mese'";
        else $clause="";
// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['hourly_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['hourly_title'];
// 
$return.="<span class=\"pagetitle\">$phpstats_title</span><br><br>";
//
$result=sql_query("SELECT * FROM $option[prefix]_hourly $clause");
if(mysql_num_rows($result)>0) 
  {
  while($row=@mysql_fetch_array($result)) 
    {
    $lista_accessi[$row[0]]+=$row[1];
     $lista_visite[$row[0]]+=$row[2];
	}
  $max=max($lista_accessi);
  foreach($lista_accessi as $key => $val)
    {
    $row[0]=$key;
    $row[1]=$val;
    $row[2]=$lista_visite[$key];
    }
  }  
$return.="<table bgcolor=$style[table_bgcolor] border=\"0\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\">";
$return.="<tr><td><table bgcolor=$style[table_bgcolor] border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">";
$max=max($max,$max_min);
$tmp=max(round($max/6,0),1);
$max=max($tmp*6,1);
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*5)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*4)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*3)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*2)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*1)."</span></td></tr>";
$return.="</table></td>";
foreach($lista_accessi as $key => $val)
  {
  $row[0]=$key;
  $row[1]=$val;
  $row[2]=$lista_visite[$key];
  $return.="<td height=\"200\" width=\"15\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"><img src=\"templates/$option[template]/images/style_bar_3.gif\"\" width=\"5\" height=\"".($row[1]/$max*187)."\"  title=\"$row[1]\"><img src=\"templates/$option[template]/images/style_bar_4.gif\"\" width=\"5\" height=\"".($row[2]/$max*187)."\" title=\"$row[2]\"></td>";
  }
$return.="<td height=\"200\" width=\"1\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"></td>";
$return.="</td></tr><tr><td></td>";
for($i=0;$i<24;$i++)
  {
  if($i<10) $count="0".$i; else $count=$i;
  $return.="<td><span class=\"testo\">$count</span></td>";
  }
$return.="</tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"26\" nowrap></td></tr>";
$return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"26\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"26\" nowrap></td></tr>";
$return.="</table>";

if($modulo[5]==2) 
{
  $return.="<br><br><center>";
  if($mode==0)
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="<form action='./admin.php?action=hourly' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
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
    $return.="<br><br><a href=\"admin.php?action=hourly&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_glob]</span></a>";
    $return.="</FORM>";
    }
    else
    $return.="<a href=\"admin.php?action=hourly&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_mens]</span></a>";
  $return.="</center>";
}  
return($return);
}
?>
