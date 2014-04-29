<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

function percorsi() {
global $db,$option,$string,$error,$varie,$style,$phpstats_title;

// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['percorsi_title'];
$limit=10;
$what=array("lev_1","lev_2","lev_3","lev_4","lev_5","lev_6","outs");
$found=0;
$page="";

foreach($what as $key) 
  {
  $result=sql_query("SELECT SUM($key) from $option[prefix]_pages");
  list($total)=mysql_fetch_row($result);
  $result=sql_query("SELECT data,$key,titlePage from $option[prefix]_pages WHERE $key>0 ORDER BY $key DESC LIMIT 0,$limit");
  if($total>0):
  $found=1;
  if($key=="outs") $page.="<center><span class=\"tabletextA\">$string[percorsi_altre]</span></center>";
  $page.="\n<TABLE $style[table_header] width=\"90%\">";
  $page.="\n\t<tr>";
  $page.="\n\t".draw_table_title($string['percorsi_'.$key]);
  $page.="\n\t".draw_table_title($string['percorsi_hits']);
  $page.="\n\t".draw_table_title($string['percorsi_prob']);
  $page.="\n\t</tr>";
  while($row=mysql_fetch_array($result))
    {
    $page.="<tr>";
	$page.="<td align=left bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row[0],"",55,22,-25,$row[2])."</span></td>";
	$page.="<td align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[1]</span></td>";
	$page.="<td align=right bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".round($row[1]/$total*100,2)."%</span></td>";
    $page.="</tr>";
    }
  $page.="</table><span class=\"tabletextA\"><br></span>";
  endif;
  }
if($found==0)
  $return=info_box($string['information'],$string['percorsi_noresult']);
  else
  $return="<span class=\"pagetitle\">$phpstats_title<br><br></span>".$page;
return $return;
}
?>