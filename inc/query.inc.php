<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

$date=time()-$option['timezone']*3600;
$mese=date("m",$date);
$anno=date("Y",$date);

if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
    if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
     if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else if($modulo[4]<2) $mode=1; else $mode=0;
     if(isset($_GET['mese'])) list($sel_anno,$sel_mese)=explode("-",addslashes($_GET['mese']));
     if(isset($_GET['sort'])) $sort=addslashes($_GET['sort']); else $sort=1; 
    if(isset($_GET['order'])) $order=addslashes($_GET['order']); else $order=0; // Default order
	if(isset($_GET['q'])) $q=addslashes($_GET['q']); else { if(isset($_POST['q'])) $q=addslashes($_POST['q']); else $q=""; }
if(isset($_GET['engine_details'])) $engine_details=urldecode(str_replace("&amp;","&",$_GET['engine_details'])); else $engine_details=""; 

function query() {
global $db,$string,$error,$varie,$style,$option,$start,$mode,$modulo,$q,$pref,$phpstats_title;
global $mese,$anno,$sel_anno,$sel_mese,$sort,$order,$engine_details;
$return="";
$rec_pag=50; // risultati visualizzati per pagina
$max_hits=0;
$total_hits=0;
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;
if(($mode==0) OR ($mode==2)) 
  {
  $clause="WHERE mese='$sel_anno-$sel_mese'"; if($q!="") $clause.=" AND data LIKE '%$q%'";
  $clause_expl="WHERE data='$engine_details' AND mese='$sel_anno-$sel_mese'"; $clause_expl.=" AND data LIKE '%$q%'";
  }
  else 
  {
  $clause=""; if($q!="") $clause.="WHERE data LIKE '%$q%'";
  $clause_expl="WHERE data='$engine_details'"; $clause_expl.=" AND data LIKE '%$q%'";
  }
// Titolo pagina (riportata anche nell'admin)
if(($mode==0) OR ($mode==2)) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['query_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['query_title'];
// INTESTAZIONE ("pagina X di Y")
if(($mode==0) OR ($mode==1))
  $query_tot=sql_query("SELECT SUM(visits) FROM $option[prefix]_query $clause GROUP BY data");
  else
  $query_tot=sql_query("SELECT SUM(visits),data FROM $option[prefix]_query $clause GROUP BY data");
$num_totale=@mysql_numrows($query_tot);

$numero_pagine=ceil($num_totale/$rec_pag);
$pagina_corrente= ceil(($start/$rec_pag)+1);
while($row=@mysql_fetch_array($query_tot))
  {
  if($row[0]>$max_hits) $max_hits=$row[0];
  $total_hits+=$row[0];
  }
if($total_hits>0) 
  {
  $return.="<span class=\"pagetitle\">$phpstats_title</span><br>";
  if($q!="")
    {
    $string['pages_results']=str_replace("%query%",$q,$string['pages_results']);
    $string['pages_results']=str_replace("%trovati%",$num_totale,$string['pages_results']);
    $return.="<br>$string[pages_results]<br>";
    }
  if($numero_pagine>1)
    {
    $tmp=$varie['pag_x_y'];
    $tmp=str_replace("%current%",$pagina_corrente,$tmp);
    $tmp=str_replace("%total%",$numero_pagine,$tmp);
    $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
    }
  $return.="<br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
  if(($mode==0) OR ($mode==1))
  {
  /////////////////////////////////
  // MODALITA' DIVISA PER MOTORE //
  /////////////////////////////////
  $tables=array("query"=>"data","hits"=>"dummy","motore"=>"engine");
  $modes=array("0"=>"DESC","1"=>"ASC");
  if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="dummy";
  if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
  $q_append2="$q_sort $q_order";
  $return.="<tr>";
  $return.=draw_table_title($string['query'],"query","admin.php?action=query&mode=$mode&mese=$sel_anno-$sel_mese&q=$q",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['query_hits'],"hits","admin.php?action=query&mode=$mode&mese=$sel_anno-$sel_mese&q=$q",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['query_engine'],"motore","admin.php?action=query&mode=$mode&mese=$sel_anno-$sel_mese&q=$q",$tables,$q_sort,$q_order);
  if($mode==0) $return.=draw_table_title("");
  $return.=draw_table_title("");
  $return.="</tr>";
  
  if($mode==0):
    // MEMORIZZO LE QUERY DEL MESE PRECEDENTE PER I CONFRONTI
    $mese_prec=date("Y-m",mktime(0,0,0,$sel_mese-1,1,$sel_anno));
	$result=sql_query("SELECT data,engine,SUM(visits) as dummy FROM $option[prefix]_query WHERE mese='$mese_prec' GROUP BY data,engine");
    while($row=@mysql_fetch_array($result))
      {
	  $row[0]=htmlspecialchars($row[0]);
	  $query["$row[0]"."|"."$row[1]"]=$row[2];
      }
  endif;
  
  $result=sql_query("SELECT data,engine,SUM(visits) as dummy FROM $option[prefix]_query $clause GROUP BY engine,data ORDER by $q_append2, 'date' DESC LIMIT $start,$rec_pag");
  while($row=@mysql_fetch_array($result))
    {
    $row[0]=htmlspecialchars($row[0]);
	$image=str_replace(" ","-","images/engines.php?q=$row[1]");
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$row[0]</span></td><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$row[2]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"$image\" align=\"absmiddle\"> $row[1]</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($row[2]/$max_hits*100)."\" height=\"7\"> (".round($row[2]*100/$total_hits,2)."%)</span></td>";

	if($mode==0):
	if(isset($query["$row[0]"."|"."$row[1]"])) {
	  $prec=$query["$row[0]"."|"."$row[1]"];
	  $variazione=round(($row[2]-$prec)/$row[2]*100,1);
	        if($variazione<-15)                      $img="templates/$option[template]/images/icon_level_1.gif";
      elseif(($variazione>=-15) && ($variazione<-5)) $img="templates/$option[template]/images/icon_level_2.gif";
       elseif(($variazione>=-5) && ($variazione<5))  $img="templates/$option[template]/images/icon_level_3.gif";
        elseif(($variazione>=5) && ($variazione<15)) $img="templates/$option[template]/images/icon_level_4.gif";
        elseif($variazione>=15)                      $img="templates/$option[template]/images/icon_level_5.gif";
      if($variazione>0) $variazione="+".$variazione;
      $variazione.=" %";
	  $alt_img=str_replace("%HITS%",$prec,$string['query_last_m']);
	  $alt_img.="\n".str_replace("%VARIAZIONE%",$variazione,$string['query_last_v']);
  	  $return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"$img\" title=\"$alt_img\"></span></td>";
	  }
	  else
	  $return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/icon_level_new.gif\"></span></td>";
    endif;
  	
	$return.="</tr>";
	
    }
  }
  else
  {
  /////////////////////////////////////
  // MODALITA' NON DIVISA PER MOTORE //
  /////////////////////////////////////
  $tables=array("query"=>"data","hits"=>"dummy");
  $modes=array("0"=>"DESC","1"=>"ASC");
  if(isset($tables[$sort])) $q_sort=$tables[$sort]; else $q_sort="dummy";
  if(isset($modes[$order])) $q_order=$modes[$order]; else $q_order="DESC";
  $q_append2="$q_sort $q_order";
  $return.="<tr>";
  $return.=draw_table_title("");
  $return.=draw_table_title($string['query'],"query","admin.php?action=query&mode=$mode&mese=$sel_anno-$sel_mese&q=$q",$tables,$q_sort,$q_order);
  $return.=draw_table_title($string['query_hits'],"hits","admin.php?action=query&mode=$mode&mese=$sel_anno-$sel_mese&q=$q",$tables,$q_sort,$q_order);
  $return.=draw_table_title("");
  if($mode==2) $return.=draw_table_title("");
  $return.="</tr>";
  
  if($mode==2):
    // MEMORIZZO LE QUERY DEL MESE PRECEDENTE PER I CONFRONTI
    $mese_prec=date("Y-m",mktime(0,0,0,$sel_mese-1,1,$sel_anno));
    $result=sql_query("SELECT data,engine,SUM(visits) as dummy FROM $option[prefix]_query WHERE mese='$mese_prec' GROUP BY data");
    while($row=@mysql_fetch_array($result))
      {
	  //$query[htmlspecialchars($row[0])]=$row[2];
	  $query[$row[0]]=$row[2];
      }
  endif;
  
  $result=sql_query("SELECT data,engine,SUM(visits) AS dummy ,date FROM $option[prefix]_query $clause GROUP BY data ORDER BY $q_append2 LIMIT $start,$rec_pag");
  while($row=@mysql_fetch_array($result))
    {
    $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
	  if($row[0]=="$engine_details")
	  $return.="\n\t<td bgcolor=$style[table_bgcolor] align=\"right\" valign=\"middle\" width=\"16\"><a href=\"admin.php?action=query&mode=$mode&sort=$sort&order=$order&mese=$sel_anno-$sel_mese&start=$start&q=$q\"><img src=\"templates/$option[template]/images/icon_collapse.gif\" border=\"0\" title=\"$string[query_collapse_alt]\"></a></td>";
	  else
	  $return.="\n\t<td bgcolor=$style[table_bgcolor] align=\"right\" valign=\"middle\" width=\"16\"><a href=\"admin.php?action=query&mode=$mode&engine_details=".urlencode(str_replace("&","&amp;",$row[0]))."&sort=$sort&order=$order&mese=$sel_anno-$sel_mese&start=$start&q=$q\"><img src=\"templates/$option[template]/images/icon_expand.gif\" border=\"0\" title=\"$string[query_expand_alt]\"></a></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$row[0]</span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$row[2]</b></span></td>";
	$return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($row[2]/$max_hits*100)."\" height=\"7\"> (".round($row[2]*100/$total_hits,2)."%)</span></td>";
	
    if($mode==2):
	if(isset($query["$row[0]"])) {
	  $prec=$query["$row[0]"];
	  $variazione=round(($row[2]-$prec)/$row[2]*100,1);
	                             if($variazione<-15)  $img="templates/$option[template]/images/icon_level_1.gif";
       elseif(($variazione>=-15) && ($variazione<-5)) $img="templates/$option[template]/images/icon_level_2.gif";
        elseif(($variazione>=-5) && ($variazione<5))  $img="templates/$option[template]/images/icon_level_3.gif";
         elseif(($variazione>=5) && ($variazione<15)) $img="templates/$option[template]/images/icon_level_4.gif";
      elseif($variazione>=15) $img="templates/$option[template]/images/icon_level_5.gif";
      if($variazione>0) $variazione="+".$variazione;
      $variazione.=" %";
	  $alt_img=str_replace("%HITS%",$prec,$string['query_last_m']);
	  $alt_img.="\n".str_replace("%VARIAZIONE%",$variazione,$string['query_last_v']);
  	  $return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"$img\" title=\"$alt_img\"></span></td>";
	  }
	  else
	  $return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/icon_level_new.gif\"></span></td>";
	  endif;
	$return.="\n</tr>";
	if(addslashes($row[0])==$engine_details)
	  {
	  $return.="\n\n<!-- QUERY DETAILS -->";
	  $return.="\n<tr>";
	  $return.="\n\t<td bgcolor=$style[table_bgcolor] nowrap=\"1\" colspan=\"5\">";
	  $return.="<img src=\"templates/$option[template]/images/arrow_dx_dw.gif\" border=\"0\"> <span class=\"tabletextA\">".$string['query_details']."</span>";
	  $return.="\n\t\t<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\" width=\"90%\" bgcolor=\"$style[bg_pops]\">";
	  $return.="\n\t\t<tr>";
	  $return.=draw_table_title("");
	  $return.=draw_table_title($string['se_query']);
	  $return.=draw_table_title($string['se_hits']);
	  $return.="</tr>";
	  $result_expl=sql_query("SELECT engine,SUM(visits) AS dummy FROM $option[prefix]_query $clause_expl GROUP BY engine ORDER BY dummy DESC");
	  while($row_expl=@mysql_fetch_array($result_expl)) 
	    {
		$row_expl[0]=htmlspecialchars($row_expl[0]);
	    $return.="\n\t\t<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
        $image=str_replace(" ","-","images/engines.php?q=$row_expl[0]");
		$return.="\n\t\t\t<td bgcolor=$style[table_bgcolor] width=\"16\"><span class=\"tabletextA\"><img src=\"".$image."\"></span></td>";
		$return.="\n\t\t\t<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".$row_expl[0]."</span></td>";
		$return.="\n\t\t\t<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".$row_expl[1]."</span></td>";	  	  
	    $return.="\n\t\t</tr>";
	    }
	  $return.="\n\t\t<tr>\n\t\t\t<td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"3\" nowrap></td></tr>";
	  $return.="\n\t\t</table><br>";
	  $return.="\n\t</td>";
	  $return.="\n</tr>";
	  $return.="\n\n<!-- END QUERY DETAILS -->";
	  }	
	$return.="</tr>";
    }
  }
  if(($mode==0) || ($mode==2)) $colspan=5; else $colspan=4;
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"$colspan\" nowrap></td></tr>";
  if($numero_pagine>1)
    {
    $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"$colspan\" height=\"20\" nowrap>";
    $return.=pag_bar("admin.php?action=query&mode=$mode&mese=$sel_anno-$sel_mese&sort=$sort&order=$order&q=$q",$pagina_corrente,$numero_pagine,$rec_pag);
    $return.="</td></tr>";
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"$colspan\" nowrap></td></tr>";
    }
  if($mode=="0")
    {
	$tipo=$string['query_mode_2'];
	$new_mode=2;
	$print_url="print.php?what=query-mens&mese=$sel_anno-$sel_mese";
	}
  elseif($mode=="1") 
    { 
	$tipo=$string['query_mode_2'];
	$new_mode=3;
	$print_url="print.php?what=query&mese=$sel_anno-$sel_mese";
	} 
  elseif($mode=="2")
	{
	$tipo=$string['query_mode_1']; 
	$new_mode=0;
	$print_url="print.php?what=query-tot-mens&mese=$sel_anno-$sel_mese";
	}
  else
    {
	$tipo=$string['query_mode_1']; 
	$new_mode=1;
	$print_url="print.php?what=query-tot&mese=$sel_anno-$sel_mese";
	}
  $return.="</td></tr>";
  $return.="</table><br>";
  }
  else
  {
  // Controllo se provengo da una ricerca o se proprio non ci sono dati!
  if($q!="")
    {
    $body="$string[no_pages]<br><br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
    $return.=info_box($string['information'],$body);
    }
    else
	{
	if(($mode==1) OR ($mode==3))
      $return.=info_box($string['information'],$error['query']);
      else
      {
      $tmp=str_replace("%MESE%",formatmount($sel_mese),$error['query_2']);
	  $tmp=str_replace("%ANNO%",$sel_anno,$tmp);
      $return.=info_box($string['information'],$tmp);
	  }
	}
  }
// INIZIO FORM
$return.="<br><center>";
$return.="<form action='./admin.php?action=query&mode=$mode' method='POST' name=form1>";
// Box di ricerca
$return.="<span class=\"testo\">$string[search]:";
$return.="<input name=\"q\" type=\"text\" size=\"30\" maxlength=\"50\" value=\"$q\">";
if($modulo[4]==2) 
{
  if($mode==0) $new_mode1=1;
  if($mode==1) $new_mode1=0;
  if($mode==2) $new_mode1=3;
  if($mode==3) $new_mode1=2;
  if(($mode==0) OR ($mode==2))
    {
    // SELEZIONE MESE DA VISUALIZZARE
    $return.="&nbsp;<span class=\"tabletextA\">$string[calendar_view]</span><SELECT name=sel_mese>";
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
    $return.="&nbsp;<input type=\"submit\" value=\"$string[go]\">";
    $return.="</FORM>";
    $return.="<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=query&mode=$new_mode1&q=$q\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[query_vis_glob]</a></span></td></tr>";
    }
    else
	{
	$return.="<input type=\"submit\" value=\"$string[go]\">";
    $return.="</FORM>";
    $return.="<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=query&mode=$new_mode1&q=$q\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[query_vis_mens]</a></span></td></tr>";
    }
  if($total_hits>0) {
  $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=query&mode=$new_mode&mese=$sel_anno-$sel_mese&q=$q\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $tipo</a></span></td></tr>";
  $return.="<tr><td><span class=\"testo\"><a href=\"$print_url\"><img src=templates/$option[template]/images/icon_print.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[printable]</a></span></td></tr>";
  }
  $return.="</table></center>";
}
else
{
if($total_hits>0) {
  $return.="<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
  $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=query&mode=$new_mode&mese=$sel_anno-$sel_mese&q=$q\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $tipo</a></span></td></tr>";
  $return.="<tr><td><span class=\"testo\"><a href=\"$print_url\"><img src=templates/$option[template]/images/icon_print.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[printable]</a></span></td></tr>";  
  $return.="</table>";
  }
}   
return($return);
}
?>
