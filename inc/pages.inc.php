<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die('Php-Stats internal file.');

if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
 if(isset($_GET['sort'])) $sort=addslashes($_GET['sort']); else $sort=1; // Default sort
if(isset($_GET['order'])) $order=addslashes($_GET['order']); else $order=0; // Default order
    if(isset($_GET['q'])) $q=addslashes($_GET['q']); else { if(isset($_POST['q'])) $q=addslashes($_POST['q']); else $q=""; }
 if(isset($_GET['mode'])) $mode=addslashes($_GET['mode'])-0; else $mode=0;

function pages(){
global $db,$string,$varie,$error,$style,$option,$start,$pref,$q,$sort,$order,$phpstats_title,$mode;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['pages_title'];

$return='';
$rec_pag=50; // risultati visualizzati per pagina
$max_hits=0;
$q_append=($q!='' ? " WHERE data like '%$q%' " : '');

// ORDINAMENTO MENU e QUERY
$tables=array('pagina'=>'data','hits'=>'hits','in'=>'lev_1','out'=>'outs','io'=>'io');
$modes=array('0'=>'DESC','1'=>'ASC');
$q_sort=(isset($tables[$sort]) ? $tables[$sort] : 'hits');
$q_order=(isset($modes[$order]) ? $modes[$order] : 'DESC');
$q_append2="$q_sort $q_order";
$query_tot=sql_query("SELECT hits FROM $option[prefix]_pages $q_append");
$num_totale=@mysql_numrows($query_tot);
$numero_pagine=ceil($num_totale/$rec_pag);
$pagina_corrente=ceil(($start/$rec_pag)+1);

if($num_totale>0){
	$result=sql_query("SELECT SUM(hits) FROM $option[prefix]_pages");
	list($totale_hits)=@mysql_fetch_row($result);
	
	$return.=
	"\n<script>".
	"\nfunction popup(url) {".
	"\n\ttest=window.open(url,'nome','SCROLLBARS=1,STATUS=NO,TOOLBAR=NO,RESIZABLE=YES,LOCATION=NO,MENU=NO,WIDTH=320,HEIGHT=480,LEFT=0,TOP=0');".
	"\n}".
	"\n</script>";
	
	// Titolo
	$return.="<span class=\"pagetitle\">$phpstats_title<br></span>";
	
	if($q!=''){
		$string['pages_results']=str_replace('%query%',$q,$string['pages_results']);
		$string['pages_results']=str_replace('%trovati%',$num_totale,$string['pages_results']);
		$return.="<span class=\"testo\"><br>$string[pages_results]<br></span>";
	}
	
	if($numero_pagine>1){
		$tmp=str_replace(Array('%current%','%total%'),Array($pagina_corrente,$numero_pagine),$varie['pag_x_y']);
		$return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
	}
	
	$return.=
	"<br><table border=\"0\" $style[table_header] width=\"95%\"><tr>".
	draw_table_title($string['pages_page'],"pagina","admin.php?action=pages&q=$q",$tables,$q_sort,$q_order).
	draw_table_title($string['pages_hits'],"hits","admin.php?action=pages&q=$q",$tables,$q_sort,$q_order).
	draw_table_title($string['pages_perc']).
	draw_table_title($string['pages_in'],"in","admin.php?action=pages&q=$q",$tables,$q_sort,$q_order).
	draw_table_title($string['pages_out'],"out","admin.php?action=pages&q=$q",$tables,$q_sort,$q_order).
	draw_table_title($string['pages_io'],"io","admin.php?action=pages&q=$q",$tables,$q_sort,$q_order).
	draw_table_title($string['pages_tracking']).
	"</tr>";
	
	$result=sql_query("SELECT * , (lev_1-outs) as io FROM $option[prefix]_pages $q_append ORDER BY $q_append2 LIMIT $start,$rec_pag");
	
	while($row=@mysql_fetch_array($result)){
		$row[13]=stripslashes(trim($row[13]));
		if($row[6]==0) $row[6]='-';
		if($row[12]==0) $row[12]='-';
		if($row[14]==0) $row[14]='-';
		$return.=
		"<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">".
		"<td align=\"left\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row[0],$row[13],55,22,-25,$row[13],$mode)."</span></td>".
		"<td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[1]</span></td>".
		"<td align=\"right\" bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".round(($row[1]*100)/$totale_hits,2)."%</span></td>".
		"<td align=\"right\" bgcolor=$style[table_bgcolor] width=\"30\"><span class=\"tabletextA\">$row[6]</span></td>".
		"<td align=\"right\" bgcolor=$style[table_bgcolor] width=\"30\"><span class=\"tabletextA\">$row[12]</span></td>".
		"<td align=\"right\" bgcolor=$style[table_bgcolor] width=\"30\"><span class=\"tabletextA\">$row[14]</span></td>";
		$row[0]=str_replace('&','§§',$row[0]);
		$return.="<td bgcolor=$style[table_bgcolor] width=\"11\"><a href=\"javascript:popup('tracking.php?page=$row[0]');\"><img src=\"templates/$option[template]/images/icon_tracking.gif\" title=\"$string[pages_tracking_alt]\" border=0></a></td></tr>";
	}
	$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"7\" nowrap></td></tr>";
	
	if($numero_pagine>1){
		$return.=
		"<tr><td bgcolor=$style[table_bgcolor] colspan=\"7\" height=\"20\" nowrap>".
		pag_bar("admin.php?action=pages&q=$q&sort=$sort&order=$order",$pagina_corrente,$numero_pagine,$rec_pag).
		"</td></tr>".
		"<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"7\" nowrap></td></tr>";
	}
	$return.="</table>";
	
	// RICERCA
	$query_tot=sql_query("SELECT hits FROM $option[prefix]_pages");
	$num_totale=@mysql_numrows($query_tot);
	if($num_totale>$rec_pag){
		$return.=
		"<center>\n".
		"<form action='./admin.php?action=pages?mode=$mode' method='POST' name=form1>\n".
		"<FONT face=verdana size=1>$string[search]:\n".
		"<input name=\"q\" type=\"text\" size=\"30\" maxlength=\"50\" value=\"$q\">".
		"<input type=\"submit\" value=\"$string[go]\">".
		"</FONT>".
		"</FORM>".
		"</center>";
	}
	// SELEZIONE MODALITA'
	$return.="<br><center><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	if($mode!=0) $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=pages&mode=0\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[pages_mode_0]</span></a></td></tr>";
	if($mode!=1) $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=pages&mode=1\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[pages_mode_1]</span></a></td></tr>";
	if($mode!=2) $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=pages&mode=2\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[pages_mode_2]</span></a></td></tr>";
	$return.="</table></center>";
	
}
else{
	if($q!=''){
		$body="$string[no_pages]<br><br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
		$return.=info_box($string['information'],$body);
	}
	else $return.=info_box($string['information'],$error['pages']);
}
return($return);
}
?>
