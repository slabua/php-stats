<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
 if(isset($_GET['sort'])) $sort=addslashes($_GET['sort']); else $sort=2; // Default sort
if(isset($_GET['order'])) $order=addslashes($_GET['order']); else $order=0; // Default order

function time_pages() {
global $db,$string,$error,$varie,$style,$option,$start,$sort,$order,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['time_pages_title'];
$return="";
// ORDINAMENTO MENU e QUERY
$tables=array("pagina"=>"data","permanenza"=>"count","totale"=>"presence");
$modes=array("0"=>"DESC","1"=>"ASC");
if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="presence";
if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
$q_append="$q_sort $q_order";
$rec_pag=50; // risultati visualizzayi per pagina
$max_hits=0;
$query_tot=sql_query("SELECT tocount FROM $option[prefix]_pages WHERE tocount>0");
$num_totale=@mysql_numrows($query_tot);
if($num_totale>0)
  {
  $numero_pagine=ceil($num_totale/$rec_pag);
  $pagina_corrente= ceil(($start/$rec_pag)+1);
  // Titolo
  $return.="<span class=\"pagetitle\">$phpstats_title</span><br>";
  //
  if($numero_pagine>1)
    {
    $tmp=str_replace("%current%",$pagina_corrente,$varie['pag_x_y']);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
    }
  $return.="<br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\"><tr>";
  $return.=draw_table_title($string['time_pages_url'],"pagina","admin.php?action=time_pages",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['time_pages_perm'],"permanenza","admin.php?action=time_pages",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['time_pages_tot'],"totale","admin.php?action=time_pages",$tables,$q_sort,$q_order);
  $return.="</tr>";

  $result=sql_query("SELECT data,hits,visits,(presence/tocount) as count,presence,titlePage FROM $option[prefix]_pages WHERE tocount>0 ORDER BY $q_append LIMIT $start,$rec_pag");
  while($row=@mysql_fetch_array($result))
    {
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\">".formaturl($row[0],"",60,25,-25,stripslashes(trim($row[5])))."</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\"><b>".formatperm($row[3])."</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formatperm($row[4],2)."</span></td>";
	$return.="</tr>";
    }
  $return.= "<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
  if($numero_pagine>1)
    {
    $return.= "<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" height=\"20\" nowrap>";
    $return.=pag_bar("admin.php?action=time_pages&sort=$sort&order=$order",$pagina_corrente,$numero_pagine,$rec_pag);
    $return.= "<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";
    }
  $return.="</table>";
  }
  else
  {
  $return.=info_box($string['information'],$error['pages']);
  }
return($return);
}
?>
