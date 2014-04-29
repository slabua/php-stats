<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");
//
if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else $mode="?";

function country() {
global $db,$mode,$option,$string,$style,$error,$phpstats_title;
include("lang/$option[language]/domains_lang.php");
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['country_title'];
$return="";
if($mode=="hits") { $mode="hits"; $img="templates/$option[template]/images/style_bar_1.gif"; } else {$mode="visits"; $img="templates/$option[template]/images/style_bar_2.gif"; }
$total=0;
$result=sql_query("select SUM($mode) from $option[prefix]_domains");
list($total)=@mysql_fetch_row($result);
if($total>0)
  {
  ////////////////////////
  // CARTINA CONTINENTI //
  ////////////////////////
  // Titolo
  $return.="<span class=\"pagetitle\">$string[continent_title]<br><br></span>";
  //
  $result=sql_query("SELECT SUM($mode),area FROM $option[prefix]_domains GROUP BY area");
  while($row=@mysql_fetch_array($result)) $area[$row[1]]=$row[0];
  $return.="<table border=\"0\" $style[table_header] width=\"482\" height=\"259\" align=\"center\">";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
  $return.="<tr>";
  $return.="<td bgcolor=$style[table_bgcolor]>";
  $return.="<table width=\"482\" height=\"259\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" background=\"templates/$option[template]/images/continent_map.gif\">";
  $return.="<tr>";
  $return.="<td width=\"163\" rowspan=\"5\" align=\"center\" valign=\"middle\"><span class=\"tabletextA\"><b>".$domain_name['area_AM']." ".$area['AM']."<br>(".round($area['AM']/$total*100,2)."%)</b></span></td>";
  $return.="<td width=\"162\" align=\"center\" valign=\"bottom\"><span class=\"tabletextA\"><b>".$domain_name['area_EU']." ".$area['EU']."<br>(".round($area['EU']/$total*100,2)."%)</b></span></td>";
  $return.="<td width=\"116\"></td>";
  $return.="<td width=\"41\"></td>";
  $return.="</tr>";
  $return.="<tr>"; 
  $return.="<td>&nbsp;</td>";
  $return.="<td align=\"left\" valign=\"top\"><span class=\"tabletextA\"><b>".$domain_name['area_AS']." ".($area['AS']+$area['GUS'])."<br>(".round(($area['AS']+$area['GUS'])/$total*100,2)."%)</b></span></td>";
  $return.="<td>&nbsp;</td>";
  $return.="</tr>";
  $return.="<tr>";
  $return.="<td align=\"center\"><span class=\"tabletextA\"><b>".$domain_name['area_AF']." ".$area['AF']."<br>(".round($area['AF']/$total*100,2)."%)</b></span></td>";
  $return.="<td>&nbsp;</td>";
  $return.="<td>&nbsp;</td>";
  $return.="</tr>";
  $return.="<tr>";
  $return.="<td>&nbsp;</td>";
  $return.="<td colspan=\"2\" align=\"center\"><span class=\"tabletextA\"><b>".$domain_name['area_OZ']." ".$area['OZ']."<br>(".round($area['OZ']/$total*100,2)."%)</b></span></td>";
  $return.="</tr>";
  $return.="<tr>"; 
  $return.="<td colspan=\"3\">&nbsp;</td>";
  $return.="</tr>";
  $return.="</table>";
  $return.="</tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";	
  $return.="</td></table>";
  if($mode=="hits") { $tipo=$string['visite']; $new_mode="visits";} else { $tipo=$string['hits']; $new_mode="hits"; }
  $return.="<br><center><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class=\"testo\"><a href=\"admin.php?action=country&mode=$new_mode\">".str_replace("%tipo%",$tipo,$string['mode'])."</a></span></center>";
  /////////////////////  
  // DETTAGLI DOMINI //
  /////////////////////
  $return.="<br><br>";
  $return.="<span class=\"pagetitle\">$string[country_title]<br><br></span>";
  $return.="<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\"><tr>";
  $return.=draw_table_title("");
  $return.=draw_table_title($string['country']);
  if($mode=="hits") 
    $return.=draw_table_title($string['country_hits']);
	else
	$return.=draw_table_title($string['country_visits']);
  $return.=draw_table_title("");
  $return.="</tr>";
  $result=sql_query("select tld,$mode from $option[prefix]_domains WHERE $mode>0 ORDER BY $mode DESC");
  while($row=@mysql_fetch_array($result))
    {
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="<td bgcolor=$style[table_bgcolor] nowrap width=\"14\"><img src=\"images/flags.php?q=$row[0]\" align=\"absmiddle\"></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\" nowrap ><span class=\"tabletextA\">";
	if($row[0]!="unknown") $return.=$domain_name[$row[0]]." (.$row[0])";
                      else $return.=$domain_name[$row[0]];
	$return.="</span></td>";
	$return.="<td align=\"right\" bgcolor=$style[table_bgcolor] nowrap><span class=\"tabletextA\"><b>$row[1]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] nowrap><span class=\"tabletextA\"><img src=\"$img\" width=\"".($row[1]/$total*200)."\" height=\"7\"> (".round($row[1]*100/$total,1)."%)</span></td>";
	$return.="</tr>";
    }
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";	
  $return.="</table>";
  $return.="<br><center><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class=\"testo\"><a href=\"admin.php?action=country&mode=$new_mode\">".str_replace("%tipo%",$tipo,$string['mode'])."</a></span></center>";
  }
  else
  {
  $return.=info_box($string['information'],$error['country']);
  }
return($return);
}
?>
