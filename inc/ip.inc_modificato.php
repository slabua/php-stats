<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
 if(isset($_GET['sort'])) $sort=addslashes($_GET['sort']); else $sort=2; // Default sort
if(isset($_GET['order'])) $order=addslashes($_GET['order']); else $order=0; // Default order

function ip() {
global $db,$string,$error,$style,$option,$varie,$start,$sort,$order,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['ip_title'];
$return="";
// ORDINAMENTO MENU e QUERY
$tables=array("ip"=>"ip","data"=>"date","accessi"=>"hits","visite"=>"visits");
$modes=array("0"=>"DESC","1"=>"ASC");
if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="hits";
if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
$q_append="$q_sort $q_order";
$rec_pag=50; // risultati visualizzati per pagina
  $return.="\n<script>\n";
  $return.="function whois(url) {\n";
  $return.="whois=window.open(url,'nome','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=450,HEIGHT=600,LEFT=0,TOP=0');\n";
  $return.="}\n";

  $return.="function tracking(url) {\n";
  $return.="tracking=window.open(url,'nome_2','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=640,HEIGHT=400,LEFT=0,TOP=0');\n";
  $return.="}\n";
  $return.="</script>\n";
$query_tot=sql_query("SELECT * FROM $option[prefix]_ip");
$num_totale=@mysql_numrows($query_tot);
if($num_totale>0)
  {
  $numero_pagine=ceil($num_totale/$rec_pag);
  $pagina_corrente=ceil(($start/$rec_pag)+1);
  // Titolo
  $return.="<span class=\"pagetitle\">$phpstats_title<br></span>";
  //
  if($numero_pagine>1)
    {
    $tmp=str_replace("%current%",$pagina_corrente,$varie['pag_x_y']);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
    }
  $return.="<br><table border=\"0\" $style[table_header] width=\"550\" align=\"center\"><tr>";
  $return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
  $return.=draw_table_title($string['ip'],"ip","admin.php?action=ip",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['ip_last_visit'],"data","admin.php?action=ip",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['ip_hits'],"accessi","admin.php?action=ip",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['ip_visite'],"visite","admin.php?action=ip",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['ip_tracking']);
  $return.="</tr>";
  $result=sql_query("SELECT * FROM $option[prefix]_ip ORDER BY $q_append LIMIT $start,$rec_pag");
  $current=$start;
  while($row=@mysql_fetch_array($result))
    {
    $current++;
//
	$ip=explode(".",$row[0]);
    for($i=0;$i<4;$i++)
      {
      if(substr($ip[$i],0,1)=="0") $ip[$i]=substr($ip[$i],1,3);
      if(substr($ip[$i],0,1)=="0") $ip[$i]=substr($ip[$i],1,2);
      }
//
	// Formato IP
	// $row[0]=long2ip($row[0]);
    $row[0]="$ip[0].$ip[1].$ip[2].$ip[3]";

    $return.="<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\"><td width=\"5\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$current</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
	if($option['ext_whois']=="") $return.="<a href=\"javascript:whois('whois.php?IP=$row[0]');\">$row[0]</a>";
	                        else $return.="<a href=\"".str_replace("%IP%",$row[0],$option['ext_whois'])."\" target=\"_BLANK\">$row[0]</a>";
	$return.="</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formatdate($row[1])." - ".formattime($row[1])."</span></td>";
    $return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[2]</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[3]</span></td><td bgcolor=$style[table_bgcolor] width=\"11\"><a href=\"javascript:tracking('tracking.php?what=ip&page=$row[0]');\"><img src=\"templates/$option[template]/images/icon_tracking.gif\" border=0></a></td></tr>";
    }
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";
  if($numero_pagine>1)
    {
    $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"6\" height=\"20\" nowrap>";
    $return.=pag_bar("admin.php?action=ip&sort=$sort&order=$order",$pagina_corrente,$numero_pagine,$rec_pag);
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";
    }
  $return.="</table>";
  }
  else
  {
  $return.=info_box($string['information'],$error['ip']);
  }
return($return);
}
?>
