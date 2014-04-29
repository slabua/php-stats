<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

$date=time()-$option['timezone']*3600;
$mese=date("m",$date);
$anno=date("Y",$date);

if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
     if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else if($modulo[4]<2) $mode=1; else $mode=0;
     if(isset($_GET['mese'])) list($sel_anno,$sel_mese)=explode("-",addslashes($_GET['mese']));
     if(isset($_GET['sort'])) $sort=addslashes($_GET['sort']); else $sort=1; 
    if(isset($_GET['order'])) $order=addslashes($_GET['order']); else $order=0; // Default order
if(isset($_GET['engine_details'])) $engine_details=addslashes($_GET['engine_details']); else $engine_details=""; 
if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
	
function engines() {
global $db,$string,$error,$varie,$style,$option,$start,$mode,$modulo;
global $mese,$anno,$sel_anno,$sel_mese,$sort,$order,$engine_details,$phpstats_title;
$return="";
$max_hits=0;
$total_hits=0;
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
if($mode==0) {
  $clause="WHERE mese='$sel_anno-$sel_mese'";
  $clause_expl="WHERE engine='$engine_details' AND mese='$sel_anno-$sel_mese'";
  }
  else 
  {
  $clause="";
  $clause_expl="WHERE engine='$engine_details'";
  }
// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['se_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['se_title'];
//							 
$result=sql_query("SELECT SUM(visits) FROM $option[prefix]_query $clause GROUP BY engine");
while($row=@mysql_fetch_array($result)) 
  {
  if($row[0]>$max_hits) $max_hits=$row[0];
  $total_hits+=$row[0];
  }
if($total_hits>0)
  {
  $return.="<span class=\"pagetitle\">$phpstats_title</span><br><br>";
  $return.="\n<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";						
  $tables=array("engine"=>"engine","hits"=>"dummy");
  $modes=array("0"=>"DESC","1"=>"ASC");
  if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="dummy";
  if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
  $q_append2="$q_sort $q_order";
  $return.="<tr>";
  $return.=draw_table_title("");
  $return.=draw_table_title($string['se_name'],"engine","admin.php?action=engines&mode=$mode",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['se_hits'],"hits","admin.php?action=engines&mode=$mode",$tables,$q_sort,$q_order);
  $return.=draw_table_title("");
  $return.=draw_table_title("");
  $return.="</tr>";
  $result=sql_query("SELECT engine,SUM(visits) AS dummy FROM $option[prefix]_query $clause GROUP BY engine ORDER BY $q_append2");
  while($row=@mysql_fetch_array($result))
    {
	$image=str_replace(" ","-","images/engines.php?q=$row[0]");
    $return.="\n<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="\n\t<td bgcolor=$style[table_bgcolor] width=\"16\"><img src=\"$image\"></td>";
	$return.="\n\t<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$row[0]</span></td>";
	$return.="\n\t<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$row[1]</b></span></td>";
	$return.="\n\t<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($row[1]/$max_hits*100)."\" height=\"7\"> (".round($row[1]*100/$total_hits,2)."%)</span></td>";
    if($row[0]=="$engine_details")
	  $return.="\n\t<td bgcolor=$style[table_bgcolor] align=\"right\" valign=\"middle\" width=\"16\"><a href=\"admin.php?action=engines&mode=$mode&sort=$sort&order=$order&mese=$sel_anno-$sel_mese\"><img src=\"templates/$option[template]/images/icon_collapse.gif\" border=\"0\" title=\"$string[se_collapse_alt]\"></a></td>";
	  else
	  $return.="\n\t<td bgcolor=$style[table_bgcolor] align=\"right\" valign=\"middle\" width=\"16\"><a href=\"admin.php?action=engines&mode=$mode&engine_details=$row[0]&sort=$sort&order=$order&mese=$sel_anno-$sel_mese\"><img src=\"templates/$option[template]/images/icon_expand.gif\" border=\"0\" title=\"$string[se_expand_alt]\"></a></td>";
	$return.="\n</tr>";
	if($row[0]=="$engine_details")
	  {
	  $return.="\n\n<!-- QUERY DETAILS -->";
	  $rec_pag=50; // risultati visualizzayi per pagina
      $query_tot_expl=sql_query("SELECT data FROM $option[prefix]_query $clause_expl GROUP BY data");
      $num_totale=@mysql_numrows($query_tot_expl);
      $numero_pagine=ceil($num_totale/$rec_pag);
      $pagina_corrente= ceil(($start/$rec_pag)+1);
	  $return.="\n<tr>";
	  $return.="\n\t<td bgcolor=$style[table_bgcolor] nowrap=\"1\" colspan=\"5\">";
	  $return.="<img src=\"templates/$option[template]/images/arrow_dx_dw.gif\" border=\"0\"> <span class=\"tabletextA\">".$string['se_details']."</span>";
	  $return.="\n\t\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" width=\"90%\" bgcolor=\"$style[bg_pops]\">";
	  $return.="\n\t\t<tr>";
	  $return.=draw_table_title($string['se_query']);
	  $return.=draw_table_title($string['se_hits']);
	  $return.="</tr>";
	  $result_expl=sql_query("SELECT data,SUM(visits) AS dummy FROM $option[prefix]_query $clause_expl GROUP BY data ORDER BY dummy DESC LIMIT $start,$rec_pag");
	  while($row_expl=@mysql_fetch_array($result_expl)) 
	    {
		$row_expl[0]=htmlspecialchars($row_expl[0]);
	    $return.="\n\t\t<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
        $return.="\n\t\t\t<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".stripslashes(trim($row_expl[0]))."</span></td>";
		$return.="\n\t\t\t<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".$row_expl[1]."</span></td>";	  	  
	    $return.="\n\t\t</tr>";
	    }
	  $return.="\n\t\t<tr>\n\t\t\t<td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"2\" nowrap></td></tr>";
      if($numero_pagine>1)
        {
        $return.="\n\t\t<tr>\n\t\t\t<td bgcolor=$style[table_bgcolor] colspan=\"2\" height=\"15\" nowrap>".pag_bar("admin.php?action=engines&mode=$mode&engine_details=$row[0]&sort=$sort&order=$order&mese=$sel_anno-$sel_mese",$pagina_corrente,$numero_pagine,$rec_pag)."</td></tr>";
        $return.="\n\t\t<tr>\n\t\t\t<td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"2\" nowrap></td></tr>";
        }	
	  $return.="\n\t\t</table><br>";
	  $return.="\n\t</td>";
	  $return.="\n</tr>";
	  $return.="\n\n<!-- END QUERY DETAILS -->";
	  }
	  	  
    }
  $return.="\n<tr>\n\t<td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"5\" nowrap></td>\n</tr>";						
  $return.="\n</table>";
  }
  else
  {
  if($mode==1)
    $return.=info_box($string['information'],$error['engines']);
    else
    {
    $tmp=str_replace("%MESE%",formatmount($sel_mese),$error['engines_2']);
	$tmp=str_replace("%ANNO%",$sel_anno,$tmp);
    $return.=info_box($string['information'],$tmp);
	}
  }
$return.="<br><br><center>";
if($modulo[4]==2) 
  {
  if($mode==0)
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="<form action='./admin.php?action=engines' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
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
      $return.="<OPTION value='$i'";
	  if($sel_anno==$i) $return.=" SELECTED"; 
	  $return.=">$i</OPTION>";
      }
    $return.="</SELECT>";
    $return.="<input type=\"submit\" value=\"$string[go]\">";
    $return.="</FORM>";
    $return.="<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=engines&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[os_vis_glob]</a></span></td></tr>";
    }
    else
	{
	$return.="<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
    $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=engines&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[os_vis_mens]</a></span></td></tr>";
	}
  //$return.="<tr><td><span class=\"testo\"><a href=\"print.php?what=engines\"><img src=templates/$option[template]/images/icon_print.gif border=\"0\"> $string[printable]</a></span></td></tr>";	
  $return.="</table></center>";
  }
return($return);
}
?>
