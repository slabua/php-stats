<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");
// Variabili esterne
if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;

function details() {
global $db,$string,$error,$style,$option,$varie,$start,$modulo,$phpstats_title;
include("lang/$option[language]/bw_lang.php");
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['details_title'];

$rec_pag=10; // risultati visualizzayi per pagina

if($modulo[7]) if($option['ip-zone']) include("lang/$option[language]/domains_lang.php");

$last_visitor_id="";
  $return ="<script>\n";
  $return.="function whois(url) {\n";
  $return.="test=window.open(url,'nome','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=450,HEIGHT=600,LEFT=0,TOP=0');\n";
  $return.="}\n";
  $return.="</script>\n";
$query_tot=sql_query("SELECT visitor_id FROM $option[prefix]_details GROUP BY visitor_id");
$num_totale=@mysql_numrows($query_tot);
if($num_totale>0) {
  // Titolo
  $return.="<span class=\"pagetitle\">$phpstats_title</span>";
  //
  $numero_pagine=ceil($num_totale/$rec_pag);
  $pagina_corrente= ceil(($start/$rec_pag)+1);
  if($numero_pagine>1)
    {
    $tmp=$varie['pag_x_y'];
    $tmp=str_replace("%current%",$pagina_corrente,$tmp);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
    }
  $return.="\n\n<ol start=".(1+(($pagina_corrente-1)*$rec_pag)).">";
  $result=sql_query("SELECT * FROM $option[prefix]_details GROUP BY visitor_id ORDER BY date DESC LIMIT $start,$rec_pag");
  $closed=1;
  while($row=@mysql_fetch_array($result))
    {
    $count=0;
    $last_visitor_id=$row[0];
    $result2=sql_query("SELECT * FROM $option[prefix]_details WHERE visitor_id='$row[0]' ORDER BY date ASC");
	$visitor_pages=mysql_num_rows($result2);
	while($row2=@mysql_fetch_array($result2))
      {
      if($count==0)
        {
        if($closed==0)
          {
          $return.="\n\t\t</table>\n\t\t</td>\n\t</tr>\n</table>";
          $closed=1;
          }
        $return.="\n\n<!--  NEW VISITOR-->";  
        $return.="\n<br>\n<li class=\"testo\"><span class=\"testo\">".formatdate($row2[5])." - ".formattime($row2[5])."</span><br>";
        $return.="\n<table width=\"90%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#000000\">\n\t<tr>\n\t\t<td bordercolor=\"#d9dbe9\">";
		$return.="\n\t\t<table $style[table_header] width=\"100%\">";
        $return.="\n\t\t\t<tr>";
		$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[details_os]</center></span></td>";
		$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[details_browser]</center></span></td>";
		$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[details_reso]</center></span></td>";
		$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[details_ip]</center></span></td>";
		$return.="</tr>";
        // Corpo della tabella
        $return.="\n\t\t\t<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".getos($row2[3])."</span></td>";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".getbrowser($row2[3])."</span></td>";
		$reso="";
		if($row2[8]=="") $reso="?"; else $reso=$row2[8];
		if($row2[9]!="") $reso.=" ".$row2[9]." bit";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$reso</span></td>";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
		if($option['ext_whois']=="") $return.="<a href=\"javascript:whois('whois.php?IP=$row2[1]');\">$row2[1]</a>";
      	                        else $return.="<a href=\"".str_replace("%IP%",$row2[1],$option['ext_whois'])."\" target=\"_BLANK\">$row2[1]</a>";
		$return.="</span></td>";
		$return.="</tr>";
        $return.="\n\t\t</table>";

		$count=0;
		$table="";
		// LINGUA DEL BROWSER
        if(isset($bw_lang[$row2[4]]) && $bw_lang!="")  // Non visualizzo se non è settata la lingua
		  {
	      $table.="\n\t\t\t<tr>";
		  $table.="<td bgcolor=$style[table_title_bgcolor] width=\"5%\" nowrap><span class=\"tabletitle\"><center>&nbsp;$string[details_lang]&nbsp;</center></span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".$lang=$bw_lang[$row2[4]]."</span></td>";
          $table.="</tr>";
		  $count++;
		  }
		// PAESE
		if($option['ip-zone'] && $modulo[7]) {
		  $ip_number=sprintf("%u",ip2long($row[1])); 
		  $result3=sql_query("SELECT tld FROM $option[prefix]_ip_zone WHERE $ip_number BETWEEN ip_from AND ip_to");
		  if(mysql_affected_rows()>0)  list($domain)=@mysql_fetch_row($result3);  else $domain="unknown";
		  $domain=$domain_name[$domain];
	      $table.="\n\t\t\t<tr>";
		  $table.="<td bgcolor=$style[table_title_bgcolor] width=\"5%\" nowrap><span class=\"tabletitle\"><center>&nbsp;$string[details_country]&nbsp;</center></span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".$domain."</span></td>";
          $table.="</tr>";		  
		  }  
		// HOST
		if(($row2[2]!=$row2[1]) && ($row2[2]!="")) // Non visualizzo se HOST è vuoto
		  {
		  $table.="\n\t\t\t<tr>";
          $table.="<td bgcolor=$style[table_title_bgcolor] width=\"5%\" nowrap><span class=\"tabletitle\"><center>&nbsp;$string[details_server]&nbsp;</center></span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row2[2]</span></td>";
          $table.="</tr>";
		  $count++;
		  }
		// REFERER o MOTORE DI RICERCA
        if($row2[6]!="") 
		  {
          $table.="\n\t\t\t<tr>";
		  list($nome_motore,$query)=getengine($row2[6]);
		  $query=stripslashes($query); // \' -> '
		  if(($nome_motore!="") AND ($query!="")) 
		    {
			$image=str_replace(" ","-","images/engines.php?q=$nome_motore");
			$table.="<td bgcolor=$style[table_title_bgcolor] width=\"5%\" nowrap><span class=\"tabletitle\"><center>&nbsp;$string[details_referer]&nbsp;</center></span></td>";
			$table.="<td bgcolor=$style[table_bgcolor]>";
			$table.="<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
			$table.="<tr>";
			$table.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"$image\" align=\"absmiddle\"> $nome_motore</span></td>";
			$table.="<td bgcolor=$style[table_title_bgcolor] width=\"50\" nowrap><span class=\"tabletitle\"><center>$string[details_query]</center></span></td>";
			$table.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$query</span></td>";
			$table.="<td bgcolor=$style[table_bgcolor] width=\"11\"><a href=\"$row2[6]\" target=\"_BLANK\"><img src=\"templates/$option[template]/images/icon_viewlink.gif\" border=0 ALT=\"$string[alt_visitlink]\"></a></td>";			
			$table.="</tr>";
			$table.="</table>";
            $table.="</span></td></tr>";
		    }
		    else
		    {
		    $table.="<td bgcolor=$style[table_title_bgcolor] width=\"5%\" nowrap><span class=\"tabletitle\"><center>&nbsp;$string[details_referer]&nbsp;</center></span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
			//$row2[6]=urldecode($row2[6]);
			$row2[6]=htmlspecialchars($row2[6]);
			$table.=formaturl($row2[6],"",70,35,-30);
		    $table.="</span></td></tr>";
			}
		  $count++;	
		  }
        if($count)
		  {
  		  $return.="\n\t\t<table $style[table_header] width=\"100%\">";
          $return.=$table;
		  $return.="\n\t\t</table>";  
		  }
        $return.="\n\t\t<table border=\"0\" $style[table_header] width=\"100%\">";
        $return.="\n\t\t\t<tr><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[details_ora]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>".str_replace("%VISITEDPAGES%",$visitor_pages,$string['details_pageviewed'])."</center></span></td></tr>";
		$row2[10]=stripslashes(trim($row2[10]));
		$return.="\n\t\t\t<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this,'$style[table_bgcolor]', '$style[table_bgcolor]')\"><td bgcolor=$style[table_bgcolor] width=\"10%\"><span class=\"tabletextA\">&nbsp;".formattime($row2[5])."&nbsp;</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row2[7],"",70,35,-30,$row2[10])."</span></td></tr>";
        $closed=0;
        }
        else
        {
        $return.=check_details($row2[5],$row2[7],$row2[10]);
        $closed=0;
        }
      $count++;
      }
    }
  if($closed==0) { $return.="</table></td></tr></table>"; $closed=1; }
  $return.="</ol>";
  if($numero_pagine>1)
    {
	$return.="<br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\">";
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
	$return.="<tr><td bgcolor=$style[table_bgcolor] height=\"20\" nowrap>";
    $return.=pag_bar("admin.php?action=details",$pagina_corrente,$numero_pagine,$rec_pag);
    $return.="</td></tr>";
    $return.="<tr><td height=\"1\"bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
    $return.="</table>";
	}
  }
  else
  {
  $return.=info_box($string['information'],$error['details']);
  }
  return($return);
}


function check_details($time,$page,$title) {
global $option,$db,$style,$string;
$return="\n\t\t\t<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this,'$style[table_bgcolor]','$style[table_bgcolor]')\"><td bgcolor=$style[table_bgcolor] width=\"10%\"><span class=\"tabletextA\">&nbsp;".formattime($time)."&nbsp;</span></td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">";
		if(substr($page,0,3)=="dwn") 
		  {
		  list($dummy,$id)=explode("|",$page);
		  $res_name=sql_query("SELECT nome,url FROM $option[prefix]_downloads WHERE id='$id' LIMIT 1");
		  if(mysql_num_rows($res_name)>0) 
		    {
			list($name,$url)=@mysql_fetch_row($res_name);
			$return.=str_replace("%NAME%",$name,$string['details_down']);
			}
			else
			$return.=str_replace("%ID%",$id,$string['details_down']);;
		  }
		  elseif(substr($page,0,3)=="clk") 
		  {
		  list($dummy,$id)=explode("|",$page);
		  $res_name=sql_query("SELECT nome,url FROM $option[prefix]_clicks WHERE id='$id' LIMIT 1");
		  if(mysql_num_rows($res_name)>0) 
		    {
			list($name,$url)=@mysql_fetch_row($res_name);
			$return.=str_replace("%NAME%",$name,$string['details_click']);
			}
			else
			$return.=str_replace("%ID%",$id,$string['details_click']);;
		  }
		  else
		  {
		  // VISUALIZZO IL TITOLO DELLE PAGINE SE PRESENTE E SE ATTIVO
          $return.=formaturl($page,"",70,35,-30,stripslashes($title));			
          }
		  $return.="</span></td></tr>";
          return($return);
		  }
?>
