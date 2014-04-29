<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

     if(isset($_POST['mounth1'])) $mounth1=addslashes($_POST['mounth1']); else $mounth1="last";
        if(isset($_POST['year1'])) $year1=addslashes($_POST['year1']); else $year1="last";
      if(isset($_POST['mounth2'])) $mounth2=addslashes($_POST['mounth2']); else $mounth2="last";
        if(isset($_POST['year1'])) $year2=addslashes($_POST['year2']); else $year2="last";
if(isset($_POST['view_graphics'])) $view_graphics=addslashes($_POST['view_graphics']); else $view_graphics=0;

function compare() {
global $db,$option,$string,$error,$varie,$style,$mounth1,$year1,$mounth2,$year2,$view_graphics,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['compare_title'];
//
$totali_accessi_1=0; 
$totali_accessi_2=0;
$totali_visite_1=0; 
$totali_visite_2=0; 
$result=sql_query("SELECT * FROM $option[prefix]_daily ORDER BY data ASC LIMIT 0,1");
 if(mysql_affected_rows()>0) {
   while($row=@mysql_fetch_array($result)) list($anno_y,$mese_y,$giorno_y)=explode("-","$row[0]");
   }
   else $anno_y=date("Y");
$mounth_now=date("n");
$year_now=date("Y");
if($mounth1=="last") $mounth1_sel=$mounth_now; else $mounth1_sel=$mounth1;
if($year1=="last") $year1_sel=$year_now; else $year1_sel=$year1;
if($mounth2=="last") $mounth2_sel=($mounth_now-1); else $mounth2_sel=$mounth2;
if($year2=="last") $year2_sel=$year_now; else $year2_sel=$year2;
if($mounth2_sel==0) { $mount2_sel=12; $year2_sel--; }
$return="<br><br><center><form action='./admin.php?action=compare' method='POST' name=form1><span class='testo'>$string[compare_comp]</span>";
$return.="<SELECT name=mounth1>";
for($i=1;$i<=12;$i++) { $return.="<OPTION value='$i'"; if($mounth1_sel==$i) $return.=" SELECTED"; $return.=">".$varie['mounts'][$i-1]."</OPTION>"; }
$return.="</SELECT><SELECT name=year1>";
for($i=$anno_y;$i<=$year_now;$i++) { $return.="<OPTION value='$i'";if($year1_sel==$i) $return.=" SELECTED"; $return.=">$i</OPTION>"; }
$return.="</SELECT><span class='testo'> $string[compare_with] </span><SELECT name=mounth2>";
for($i=1;$i<=12;$i++) { $return.="<OPTION value='$i'";if($mounth2_sel==$i) $return.=" SELECTED"; $return.=">".$varie['mounts'][$i-1]."</OPTION>"; }
$return.="</SELECT><SELECT name=year2>";
for($i=$anno_y;$i<=$year_now;$i++) { $return.="<OPTION value='$i'";if($year2_sel==$i) $return.=" SELECTED"; $return.=">$i</OPTION>"; }
$return.="</SELECT><input name=\"view_graphics\" type=\"hidden\" value=\"1\">";
$return.="&nbsp;<input type=\"submit\" value=\"$string[go]\">";
$return.="</FORM>";
$return.="</center>";
if($view_graphics==1) {
$total_visits=0;
$max_accessi=0;
$max_visite=0;
$return.="<span class=\"pagetitle\">$string[compare_access]<br><br></span>";
$day=0;
for($i=0;$i<=31;$i++)
  {
  $lista_accessi_1[$i]=0;
  $lista_visite_1[$i]=0;
  $lista_accessi_2[$i]=0;
  $lista_visite_2[$i]=0;
 // $giorno=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-$i,date("Y")));
if(checkdate($mounth1,$i,$year1)) {
  $giorno=date("Y-m-d",mktime(0,0,0,$mounth1,$i,$year1));
  $lista_giorni_1[$i]=$giorno;
  $result=sql_query("select * from $option[prefix]_daily where data='$giorno'");
  while($row=@mysql_fetch_array($result))
    {
    $lista_accessi_1[$i]=$row[1];
    $lista_visite_1[$i]=$row[2];
    if($row[1]>$max_accessi) $max_accessi=$row[1];
    if($row[2]>$max_visite) $max_visite=$row[2];
    } }
 if(checkdate($mounth2,$i,$year2)) {
  $giorno=date("Y-m-d",mktime(0,0,0,$mounth2,$i,$year2));
  $lista_giorni_2[$i]=$giorno;
  $result=sql_query("select * from $option[prefix]_daily where data='$giorno'");
  while($row=@mysql_fetch_array($result))
    {
    $lista_accessi_2[$i]=$row[1];
    $lista_visite_2[$i]=$row[2];
    if($row[1]>$max_accessi) $max_accessi=$row[1];
    if($row[2]>$max_visite) $max_visite=$row[2];
    } }
  }
////////////////////////////////////
// GENERO IL GRAFICO IN VERTICALE //
////////////////////////////////////

/////////////////////
// PAGINE VISITATE //
/////////////////////
if($max_accessi<30) $max_v=30; else $max_v=$max_accessi;
$return.="<table bgcolor=$style[table_bgcolor] border=\"0\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\">";
$return.="<tr><td><table bgcolor=$style[table_bgcolor] border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">";
$tmp=round($max_v/6,0);
$max_v=$tmp*6;
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*5)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*4)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*3)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*2)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*1)."</span></td></tr>";
$return.="</table></td>";
for($i=1;$i<=31;$i++)
  {
  $return.="<td height=\"200\" width=\"15\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"><img src=\"templates/$option[template]/images/style_bar_3.gif\"\" width=\"5\" height=\"".($lista_accessi_1[$i]/$max_v*187)."\"  title=\"$lista_accessi_1[$i]\"><img src=\"templates/$option[template]/images/style_bar_4.gif\"\" width=\"5\" height=\"".($lista_accessi_2[$i]/$max_v*187)."\" title=\"$lista_accessi_2[$i]\"></td>";
  }
$return.="<td height=\"200\" width=\"1\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"></td>";
$return.="</td></tr><tr><td><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"></td>";
for($i=1;$i<=31;$i++)
  {
  $giorno=date("d",mktime(0,0,0,$mounth1,$i,$year1));
  if(checkdate($mounth1,$i,$year1)) {
  if(date("w",mktime(0,0,0,$mounth1,$i,$year1))==0) 
  $return.="<td><span class=\"tabletextB\">$giorno</span></td>";
  else
  $return.="<td><span class=\"tabletextA\">$giorno</span></td>";
  } }
$return.="</tr><td><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"></td>";
for($i=1;$i<=31;$i++)
  {
  $giorno=date("d",mktime(0,0,0,$mounth2,$i,$year2));
  if(checkdate($mounth2,$i,$year2)) {
  if(date("w",mktime(0,0,0,$mounth2,$i,$year2))==0) 
  $return.="<td><span class=\"tabletextB\">$giorno</span></td>";
  else
  $return.="<td><span class=\"tabletextA\">$giorno</span></td>";
  } }
$return.="</tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"32\" nowrap></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"32\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> ".$varie['mounts'][$mounth1-1]." $year1 <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> ".$varie['mounts'][$mounth2-1]." $year2 </span></center></td></tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"32\" nowrap></td></tr>";
$return.="</table>";
////////////////
// VISITATORI //
////////////////
$return.="<br><span class=\"pagetitle\">$string[compare_visits]<br><br></span>";
if($max_visite<30) $max_v=30; else $max_v=$max_visite;
$return.="<table bgcolor=$style[table_bgcolor] border=\"0\" cellpadding=\"1\" cellspacing=\"1\" align=\"center\">";
$return.="<tr><td><table bgcolor=$style[table_bgcolor] border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">";
$tmp=round($max_v/6,0);
$max_v=$tmp*6;
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*5)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*4)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*3)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*2)."</span></td></tr>";
$return.="<tr><td height=\"30\"><span class=\"testo\">".($tmp*1)."</span></td></tr>";
$return.="</table></td>";
for($i=1;$i<=31;$i++)
  {
  $return.="<td height=\"200\" width=\"15\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"><img src=\"templates/$option[template]/images/style_bar_3.gif\"\" width=\"5\" height=\"".($lista_visite_1[$i]/$max_v*187)."\"  title=\"$lista_visite_1[$i]\"><img src=\"templates/$option[template]/images/style_bar_4.gif\"\" width=\"5\" height=\"".($lista_visite_2[$i]/$max_v*187)."\" title=\"$lista_visite_2[$i]\"></td>";
  }
$return.="<td height=\"200\" width=\"1\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"></td>";
$return.="</td></tr><tr><td><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"></td>";
for($i=1;$i<=31;$i++)
  {
  $giorno=date("d",mktime(0,0,0,$mounth1,$i,$year1));
  if(checkdate($mounth1,$i,$year1)) {
  if(date("w",mktime(0,0,0,$mounth1,$i,$year1))==0) 
  $return.="<td><span class=\"tabletextB\">$giorno</span></td>";
  else
  $return.="<td><span class=\"tabletextA\">$giorno</span></td>";
  } }
$return.="</tr><td><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"></td>";
for($i=1;$i<=31;$i++)
  {
  $giorno=date("d",mktime(0,0,0,$mounth2,$i,$year2));
  if(checkdate($mounth2,$i,$year2)) {
  if(date("w",mktime(0,0,0,$mounth2,$i,$year2))==0) 
  $return.="<td><span class=\"tabletextB\">$giorno</span></td>";
  else
  $return.="<td><span class=\"tabletextA\">$giorno</span></td>";
  } }
$return.="</tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"32\" nowrap></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"32\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> ".$varie['mounts'][$mounth1-1]." $year1 <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> ".$varie['mounts'][$mounth2-1]." $year2 </span></center></td></tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"32\" nowrap></td></tr>";
$return.="</table>";
//////////////////////////////////////
// GENERO IL GRAFICO IN ORIZZONTALE //
//////////////////////////////////////
$return.="<br><span class=\"pagetitle\">$string[compare_both]<br><br></span>";
$return.="<table border=\"0\" $style[table_header] width=\"90%\">";
$return.="<tr>";
$return.="<td bgcolor=$style[table_title_bgcolor] colspan=\"2\" nowrap><span class=\"tabletitle\"><center>$string[compare_hits]</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>".$varie['mounts_1'][$mounth1-1]." $year1</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>".$varie['mounts_1'][$mounth2-1]." $year2</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] colspan=\"2\" nowrap><span class=\"tabletitle\"><center>$string[compare_visites]</center></span></td>";
$return.="</tr>";
for($i=0;$i<=31;$i++)
  {
$return.= "<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
  $giorno=date("d",mktime(0,0,0,$mounth1,$i,$year1));
  if((checkdate($mounth1,$i,$year1))|(checkdate($mounth2,$i,$year2))) {
  $max=max($max_accessi,1);
  $return.="<td bgcolor=$style[table_bgcolor] align=\"right\" width=\"170\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($lista_accessi_1[$i]/$max*170)."\" height=\"7\"></span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($lista_accessi_2[$i]/$max*170)."\" height=\"7\"></span></td><td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\"><b>$lista_accessi_1[$i]</b></span><br><span class=\"tabletextA\"><b>$lista_accessi_2[$i]</b></span></td>";
  if(checkdate($mounth1,$i,$year1)) {
   if(date("w",mktime(0,0,0,$mounth1,$i,$year1))==0) 
   $return.="<td bgcolor=$style[table_bgcolor] align=\"center\"><span class=\"tabletextB\">$giorno</span></td>";
   else
   $return.="<td bgcolor=$style[table_bgcolor] align=\"center\"><span class=\"tabletextA\">$giorno</span></td>";
   }
  else $return.="<td bgcolor=$style[table_bgcolor]></td>";
  }
  else $return.="<td bgcolor=$style[table_bgcolor]></td><td bgcolor=$style[table_bgcolor]></td><td bgcolor=$style[table_bgcolor]></td>";
  $giorno=date("d",mktime(0,0,0,$mounth2,$i,$year2));
  if((checkdate($mounth1,$i,$year1))|(checkdate($mounth2,$i,$year2))) {
  $max=max($max_visite,1);
  if(checkdate($mounth2,$i,$year2)) {
   if(date("w",mktime(0,0,0,$mounth2,$i,$year2))==0) 
   $return.="<td bgcolor=$style[table_bgcolor] align=\"center\"><span class=\"tabletextB\">$giorno</span></td>";
   else
   $return.="<td bgcolor=$style[table_bgcolor] align=\"center\"><span class=\"tabletextA\">$giorno</span></td>";
   }
  else $return.="<td bgcolor=$style[table_bgcolor]></td>";
  $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$lista_visite_1[$i]</b></span><br><span class=\"tabletextA\"><b>$lista_visite_2[$i]</b></span></td><td bgcolor=$style[table_bgcolor] align=\"left\" width=\"170\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($lista_visite_1[$i]/$max*170)."\" height=\"7\"></span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($lista_visite_2[$i]/$max*170)."\" height=\"7\"></span></td>";
  }
  else $return.="<td bgcolor=$style[table_bgcolor]></td><td bgcolor=$style[table_bgcolor]></td><td bgcolor=$style[table_bgcolor]></td>";
if($lista_accessi_1!="") $totali_accessi_1+=$lista_accessi_1[$i]; else $totali_accessi_1+=0;
if($lista_accessi_2!="") $totali_accessi_2+=$lista_accessi_2[$i]; else $totali_accessi_2+=0;
if($lista_visite_1!="") $totali_visite_1+=$lista_visite_1[$i]; else $totali_visite_1+=0;
if($lista_visite_2!="") $totali_visite_2+=$lista_visite_2[$i]; else $totali_visite_2+=0;  
}
$return.="<tr><td bgcolor=$style[table_bgcolor]></td><td bgcolor=$style[table_bgcolor] align=\"left\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> <b>$totali_accessi_1</b></span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> <b>$totali_accessi_2</b></span></td>";
$return.="<td bgcolor=$style[table_bgcolor] align=\"center\" colspan=\"2\" nowrap><span class=\"tabletextA\"><b>$string[compare_total]</b></span></td>";
$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$totali_visite_1</b> <img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"></span><br><span class=\"tabletextA\"><b>$totali_visite_2</b> <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"></span></td><td bgcolor=$style[table_bgcolor]></td></tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";
$return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"6\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> ".$varie['mounts'][$mounth1-1]." $year1 <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> ".$varie['mounts'][$mounth2-1]." $year2 </span></center></td></tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";  
$return.="</table>";
} 
return($return);
}
?>
