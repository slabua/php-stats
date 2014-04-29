<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die('Php-Stats internal file.');

list($mese,$anno)=explode('-',date('m-Y',time()-$option['timezone']*3600));

if(isset($_GET['debug'])) $debug=addslashes($_GET['debug']); else $debug=0;
if(isset($_POST['sel_mese'])) $sel_mese=addslashes($_POST['sel_mese']); else $sel_mese=$mese;
if(isset($_POST['sel_anno'])) $sel_anno=addslashes($_POST['sel_anno']); else $sel_anno=$anno;
if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else if($modulo[1]<2) $mode=1; else $mode=0;
if(isset($_GET['group'])) $group=addslashes($_GET['group'])-0; else $group=0;

function os_browser() {
global $db,$string,$error,$style,$option,$mode,$group,$varie,$modulo,$phpstats_title;
global $mese,$anno,$sel_anno,$sel_mese;

// Titolo pagina (riportata anche nell'admin)
switch($group){
	case 0:
		if($mode==0) $phpstats_title=str_replace(Array('%MESE%','%ANNO%'),Array(formatmount($sel_mese),$sel_anno),$string['os_browser_title_2']);
		else $phpstats_title=$string['os_browser_title'];
		break;
	case 1:
		if($mode==0) $phpstats_title=str_replace(Array('%MESE%','%ANNO%'),Array(formatmount($sel_mese),$sel_anno),$string['os_browser_title_2a']);
		else $phpstats_title=$string['os_browser_titlea'];
		break;
	case 2:
		if($mode==0) $phpstats_title=str_replace(Array('%MESE%','%ANNO%'),Array(formatmount($sel_mese),$sel_anno),$string['os_browser_title_2b']);
		else $phpstats_title=$string['os_browser_titleb'];
		break;
}

$return='';
if(strlen($sel_mese)<2) $sel_mese='0'.$sel_mese;

$clause=($mode==0 ? "WHERE mese='$sel_anno-$sel_mese' AND os<>''" : "WHERE os<>''");

$query_bas=sql_query("SELECT sum(hits),sum(visits) FROM $option[prefix]_systems $clause");
list($total_hits,$total_accessi)=@mysql_fetch_row($query_bas);
$query_tot=sql_query("SELECT os,hits,visits FROM $option[prefix]_systems $clause");
$num_totale=@mysql_numrows($query_tot);
if($num_totale>0){
	$count=0;
	// Titolo sezione OS
	if($mode==0) $tmp=str_replace(Array('%MESE%','%ANNO%'),Array(formatmount($sel_mese),$sel_anno),$string['os_title_2']);
	else $tmp=$string['os_title'];
	$return.="<span class=\"pagetitle\">$tmp</span>";
	//
	
	$result=sql_query("SELECT os,SUM(hits) AS dummy,SUM(visits) FROM $option[prefix]_systems $clause GROUP BY os ORDER BY 'dummy' DESC");
	//RAGGRUPPAMENTO DEGLI OS
	if($group==0){
		$oshits=Array();//Array(hits,visits,nome,immagine);
		while($row=@mysql_fetch_row($result)){
			if($row[0]=='?') $oshits[]=Array($row[1]-0,$row[2]-0,$string['os_unknown'],'images/os.php?q=unknown');
			else $oshits[]=Array($row[1]-0,$row[2]-0,$row[0],str_replace(' ','-','images/os.php?q='.$row[0]));
		}
	}
	else{
		$osnames;//id di oshits
		$oshits=Array();//Array(hits,visits,nome,immagine);
		while($row=@mysql_fetch_row($result)){
			if($row[0]=='?') $tmpname=$string['os_unknown'];
			else{
				$tmpname=explode(' ',$row[0]);
				$tmpname=$tmpname[0];
			}
			
			if(isSet($osnames[$tmpname])){
				$oshits[$osnames[$tmpname]][0]+=$row[1]-0;
				$oshits[$osnames[$tmpname]][1]+=$row[2]-0;
			}
			else{
				$tmpimage=($tmpname==$string['os_unknown'] ? 'images/os.php?q=unknown' : str_replace(' ','-','images/os.php?q='.$tmpname));
				$oshits[]=Array($row[1]-0,$row[2]-0,$tmpname,$tmpimage);
				$osnames[$tmpname]=count($oshits)-1;
			}
		}
		unset($osnames);
		rsort($oshits);
	}
	//
	$return.=
	"<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >".
	"<tr>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap></td>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[os_os]</center></span></td>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[os_hits]</center></span></td>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>".
	"</tr>";
	for($i=0,$tot=count($oshits);$i<$tot;$i++){
		list($curoshits,$curosvisits,$curosname,$curosimg)=$oshits[$i];
		$return.=
		"<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">".
		"<td bgcolor=$style[table_bgcolor] width=\"14\"><img src=\"$curosimg\"></td>".
		"<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$curosname</span></td>".
		"<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$curoshits</b></span><br><span class=\"tabletextA\"><b>$curosvisits</b></span></td>".
		"<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($curoshits/MAX($total_hits,1)*330)."\" height=\"7\"> (".round($curoshits*100/MAX($total_hits,1),1)."%)</span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($curosvisits/MAX($total_accessi,1)*330)."\" height=\"7\"> (".round($curosvisits*100/MAX($total_accessi,1),1)."%)</span></td>".
		"</tr>";
	}
	unset($oshits);
	$return.=
	"<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>".
	"<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>".
	"<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>".
	"</table>".
	"<br><br>";

	//Browser
	// Titolo sezione Browser
	if($mode==0) $tmp=str_replace(Array('%MESE%','%ANNO%'),Array(formatmount($sel_mese),$sel_anno),$string['browser_title_2']);
	else  $tmp=$string['browser_title'];
	$return.="<span class=\"pagetitle\">$tmp</span>";
	//
	$result=sql_query("SELECT bw,SUM(hits) AS dummy,SUM(visits) FROM $option[prefix]_systems $clause GROUP BY bw ORDER BY 'dummy' DESC");
	//RAGGRUPPAMENTO DEI BROWSERS
	if($group==0){
		$bwhits=Array();//Array(hits,visits,nome,immagine);
		while($row=@mysql_fetch_row($result)){
			if($row[0]=='?') $bwhits[]=Array($row[1]-0,$row[2]-0,$string['browser_unknown'],'images/browsers.php?q=unknown');
			else $bwhits[]=Array($row[1]-0,$row[2]-0,$row[0],str_replace(' ','-','images/browsers.php?q='.$row[0]));
		}
	}
	else if($group==1){
		$bwnames;//id di bwhits
		$bwhits=Array();//Array(hits,visits,nome,immagine);
		while($row=@mysql_fetch_row($result)){
			if($row[0]=='?') $tmpname=$string['browser_unknown'];
			else{
				$tmp=explode(' ',$row[0]);
				$tmpname=$tmp[0];
				for($i=1,$tot=count($tmp);$i<$tot;$i++){//per i browser che hanno nomi con lo spazio
					$ordch=ord($tmp[$i]{0});
					if($ordch<ord('0') || $ordch>ord('9')) $tmpname.=' '.$tmp[$i];
					else break;
				}
			}
			
			if(isSet($bwnames[$tmpname])){
				$bwhits[$bwnames[$tmpname]][0]+=$row[1]-0;
				$bwhits[$bwnames[$tmpname]][1]+=$row[2]-0;
			}
			else{
				$tmpimage=($tmpname==$string['browser_unknown'] ? 'images/browsers.php?q=unknown' : str_replace(' ','-','images/browsers.php?q='.$tmpname));
				$bwhits[]=Array($row[1]-0,$row[2]-0,$tmpname,$tmpimage);
				$bwnames[$tmpname]=count($bwhits)-1;
			}
		}
		unset($bwnames);
		rsort($bwhits);
	}
	else{
		$bwnames;//id di bwhits
		$bwhits=Array();//Array(hits,visits,nome,immagine);
		$bwmacro=Array();//nomi delle macro
		$tmp=file('def/bw.dat');
		for($i=0,$tot=count($tmp);$i<$tot;$i++){
			if($tmp[$i]{0}!='#'){
				$tmp2=explode('|',$tmp[$i]);
				$bwmacro[str_replace(' ','_',$tmp2[0])]=chop($tmp2[3]);
			}
		}
		while($row=@mysql_fetch_array($result)){
			if($row[0]=='?') $tmpname=$string['browser_unknown'];
			else{
				$tmp=explode(' ',$row[0]);
				$tmpname=$tmp[0];
				for($i=1,$tot=count($tmp);$i<$tot;$i++){//per i browser che hanno nomi con lo spazio
					$ordch=ord($tmp[$i]{0});
					if($ordch<ord('0') || $ordch>ord('9')) $tmpname.='_'.$tmp[$i];
					else break;
				}
				$tmpname=$bwmacro[$tmpname];
			}
			
			if(isSet($bwnames[$tmpname])){
				$bwhits[$bwnames[$tmpname]][0]+=$row[1]-0;
				$bwhits[$bwnames[$tmpname]][1]+=$row[2]-0;
			}
			else{
				$tmpimage=($tmpname==$string['browser_unknown'] ? 'images/browsers.php?q=unknown' : str_replace(' ','-','images/browsers.php?q='.$tmpname));
				$bwhits[]=Array($row[1]-0,$row[2]-0,$tmpname,$tmpimage);
				$bwnames[$tmpname]=count($bwhits)-1;
			}
		}
		rsort($bwhits);
	}
	//
	$return.=
	"<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >".
	"<tr>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap></td>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[browser_bw]</center></span></td>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[browser_hits]</center></span></td>".
	"<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>".
	"</tr>";
	for($i=0,$tot=count($bwhits);$i<$tot;$i++){
		list($curbwhits,$curbwvisits,$curbwname,$curbwimg)=$bwhits[$i];
		$return.=
		"<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">".
		"<td bgcolor=$style[table_bgcolor] width=\"14\"><img src=\"$curbwimg\"></td>".
		"<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$curbwname</span></td>".
		"<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$curbwhits</b></span><br><span class=\"tabletextA\"><b>$curbwvisits</b></span></td>".
		"<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($curbwhits/MAX($total_hits,1)*330)."\" height=\"7\"> (".round($curbwhits*100/MAX($total_hits,1),1)."%)</span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($curbwvisits/MAX($total_accessi,1)*330)."\" height=\"7\"> (".round($curbwvisits*100/MAX($total_accessi,1),1)."%)</span></td>".
		"</tr>";
	}
	unset($bwhits);
	$return.=
	"<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>".
	"<tr><td bgcolor=$style[table_bgcolor] colspan=\"4\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>".
	"<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>".
	"</table>";
}
else{
	if($mode==1) $return.=info_box($string['information'],$error['os_bw']);
	else{
		$tmp=str_replace(Array('%MESE%','%ANNO%'),Array(formatmount($sel_mese),$sel_anno),$error['os_bw_2']);
		$return.=info_box($string['information'],$tmp);
	}
}
if($modulo[1]==2){
	$return.=
	"<br><center><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">".
	"<tr><td colspan=\"2\"><span class=\"testo\">";
	if($mode==0){
		// SELEZIONE MESE DA VISUALIZZARE
		$return.=
		"<form action='./admin.php?action=os_browser' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>".
		"<SELECT name=sel_mese>";
		for($i=1;$i<13;$i++){
			$return.="<OPTION value='$i'"; if($sel_mese==$i) $return.=" SELECTED"; $return.=">".$varie['mounts'][$i-1]."</OPTION>";
		}
		$return.=
		"</SELECT>".
		"<SELECT name=sel_anno>";
		$result=sql_query("SELECT min(data) FROM $option[prefix]_daily");
		$row=@mysql_fetch_row($result);
		$ini_y=substr($row[0],0,4);
		if($ini_y=='') $ini_y=$anno;
		for($i=$ini_y;$i<=$anno;$i++){
			$return.="<OPTION value='$i'";if($sel_anno==$i) $return.=" SELECTED"; $return.=">$i</OPTION>";
		}
		$return.=
		"</SELECT>".
		"<input type=\"submit\" value=\"$string[go]\">".
		"</td></tr>".
		"<tr><td><a href=\"admin.php?action=os_browser&mode=1&group=$group\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_glob]</span></a></td></tr>".
		"</FORM>";
	}
	else $return.="<tr><td><a href=\"admin.php?action=os_browser&mode=0&group=$group\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_vis_mens]</span></a></td></tr>";
	if($group!=0) $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=os_browser&group=0".($mode==0 ? "&mode=0&mese=$sel_anno-$sel_mese" : '&mode=1')."\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_mode_0]</span></a></td></tr>";
	if($group!=1) $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=os_browser&group=1".($mode==0 ? "&mode=0&mese=$sel_anno-$sel_mese" : '&mode=1')."\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_mode_1]</span></a></td></tr>";
	if($group!=2) $return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=os_browser&group=2".($mode==0 ? "&mode=0&mese=$sel_anno-$sel_mese" : '&mode=1')."\"><img src=templates/$option[template]/images/icon_changevis.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"><span class='testo'> $string[os_mode_2]</span></a></td></tr>";
	$return.="</table></center>";
}
return($return);
}
?>