<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;

function downloads() {
global $db,$string,$error,$style,$option,$varie,$start,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['down_title'];
//
$rec_pag=10; // risultati visualizzayi per pagina
$max_hits=0;
$total_hits=0;
$query_tot=sql_query("SELECT id FROM $option[prefix]_downloads");
$num_totale=@mysql_numrows($query_tot);
$numero_pagine=ceil($num_totale/$rec_pag);
$pagina_corrente= ceil(($start/$rec_pag)+1);
$return="\n<SCRIPT>function link(id) {\n";
$return.="document.codice.downcode.value=\"<a href='$option[script_url]/download.php?id=\"+id+\"'>Download</a>\";\n";
$return.="}\n";
$return.="</SCRIPT>\n";
while($row=@mysql_fetch_array($query_tot))
  {
  if($row[0]>$max_hits) $max_hits=$row[0];
  $total_hits+=$row[0];
  }
$result=sql_query("SELECT * FROM $option[prefix]_downloads ORDER BY 'downloads' DESC LIMIT $start,$rec_pag");
if(@mysql_num_rows($result)>0) {
  $return.="<span class=\"pagetitle\">$phpstats_title<br><br></span>";
  if($numero_pagine>1)
    {
    $tmp=$varie['pag_x_y'];
    $tmp=str_replace("%current%",$pagina_corrente,$tmp);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div><br>";
    }
  $current=$start;
  $return.="<table border=\"0\" $style[table_header] width=\"100%\">";
  $return.="<tr><td bgcolor=$style[table_title_bgcolor] nowrap></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_name]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_url]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_id]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_n]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_status]</center></span></td></tr>";
  while($row=@mysql_fetch_array($result))
    {
    $id=$row[0];
    $downloads_log_nome=$row[1];
    $downloads_log_url=$row[2];
    $downloads_log_accessi=$row[4];
    $current++;
    $return.="<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\"><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$current</span></td><td bgcolor=$style[table_bgcolor] nowrap><span class=\"tabletextA\">$downloads_log_nome</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($downloads_log_url, "", 55, 22, -25)."</span></td>";
    $return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><center><a href=\"javascript:link('$id');\" onClick=\"link('$id')\">$id</a></center></span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">&nbsp;<b>$downloads_log_accessi</b></span></td><td bgcolor=$style[table_bgcolor]><center>".checkfile($downloads_log_url)."</center></td></tr>";
    }
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";
    if($numero_pagine>1)
    {
    $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"6\" height=\"20\" nowrap>".pag_bar("admin.php?action=downloads",$pagina_corrente,$numero_pagine,$rec_pag)."</td></tr>";
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";
    }
  $return.="</table>";		
  // GENERA CODICE
  $return.="<br><br><form name=\"codice\">";
  $return.="<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  $return.="<tr><td bgcolor=$style[table_title_bgcolor]><span class=\"tabletitle\">$string[down_codescript]</span></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor]><center><textarea name=\"downcode\" cols=\"100\" rows=\"2\">$string[down_downcli]</textarea></center></form></td></tr>";
  $return.="</table>";
  }
  else
  {
  $return.=info_box($string['information'],$error['downloads']);
  }
return($return);
}
?>
