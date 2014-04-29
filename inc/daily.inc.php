<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

function daily() {
global $db,$option,$string,$error,$varie,$style,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['daily_title'];
// Titolo
$return="<span class=\"pagetitle\">$phpstats_title<br><br></span>";
//
$day=0;
$total_visits=0;
$max=0;
for($i=0;$i<=30;$i++)
  {
  $lista_accessi[$i]=0;
  $lista_visite[$i]=0;
  $giorno=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-$i,date("Y")));
  $lista_giorni[$i]=$giorno;
  //$sql="select * from $option[prefix]_daily where to_days(now( )) - to_days(data) < 32 order by 'data' desc";
  $result=sql_query("select * from $option[prefix]_daily where data='$giorno'");
  while($row=@mysql_fetch_array($result))
    {
    $lista_accessi[$i]=$row[1];
    $lista_visite[$i]=$row[2];
    if($row[1]>$max) $max=$row[1];
    }
  }
////////////////////////////////////
// GENERO IL GRAFICO IN VERTICALE //
////////////////////////////////////
if($max<30) $max_v=30; else $max_v=$max;
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
for($i=29;$i>=0;$i--)
  {
  $return.="<td height=\"200\" width=\"15\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"><img src=\"templates/$option[template]/images/style_bar_3.gif\"\" width=\"5\" height=\"".($lista_accessi[$i]/$max_v*187)."\"  title=\"$lista_accessi[$i]\"><img src=\"templates/$option[template]/images/style_bar_4.gif\"\" width=\"5\" height=\"".($lista_visite[$i]/$max_v*187)."\" title=\"$lista_visite[$i]\"></td>";
  }
$return.="<td height=\"200\" width=\"1\" valign=\"bottom\" align=\"center\" background=\"templates/$option[template]/images/table_grid.gif\"></td>";
$return.="</td></tr><tr><td></td>";
for($i=29;$i>=0;$i--)
  {
  $giorno=date("d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-$i,date("Y")));
  if(date("w",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-$i,date("Y")))==0)
  $return.="<td><span class=\"tabletextB\">$giorno</span></td>";
  else
  $return.="<td><span class=\"tabletextA\">$giorno</span></td>";
  }
$return.="</tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"32\" nowrap></td></tr>";
  $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"32\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"32\" nowrap></td></tr>";
$return.="</table>";

//////////////////////////////////////
// GENERO IL GRAFICO IN ORIZZONTALE //
//////////////////////////////////////
$return.="<br><br><table border=\"0\" width=\"90%\" $style[table_header]>";
$return.="<tr>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>Data</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>Accessi</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
$return.="</tr>";
for($i=0;$i<=29;$i++)
  {
  if($lista_visite[$i+1]>0)
    {
    $variazione=round(($lista_visite[$i]-$lista_visite[$i+1])/$lista_visite[$i+1]*100,1);
    if($variazione<-15) $img="templates/$option[template]/images/icon_level_1.gif";
    elseif(($variazione>=-15) && ($variazione<-5)) $img="templates/$option[template]/images/icon_level_2.gif";
    elseif(($variazione>-5) && ($variazione<5)) $img="templates/$option[template]/images/icon_level_3.gif";
    elseif(($variazione>5) && ($variazione<15)) $img="templates/$option[template]/images/icon_level_4.gif";
    elseif($variazione>15) $img="templates/$option[template]/images/icon_level_5.gif";
    if($variazione>0) $variazione="+".$variazione;
    $variazione.=" %";
    }
    else
    {
    $variazione="-";
    $img="templates/$option[template]/images/icon_level_unkn.gif";
    if($lista_visite[$i]>0) {
      $img="templates/$option[template]/images/icon_level_5.gif";
      }
    }
  if($lista_visite[$i]==0)
    {
    $variazione="-";
    $img="templates/$option[template]/images/icon_level_unkn.gif";
    }
  // Variazione accessi
  //$variazione2=round(($lista_accessi[$i]-$lista_accessi[$i+1])/$lista_accessi[$i+1]*100,1);
  //if($variazione2>0) $variazione2="+".$variazione2;
  //  $variazione2.=" %";
  $data=explode("-",$lista_giorni[$i]);
  $tmp=str_replace("%mount%", formatmount($data[1]),$varie['date_format']);
  $tmp=str_replace("%day%",$data[2],$tmp);
  $tmp=str_replace("%year%",$data[0],$tmp);
  $giorno=$tmp;
  $mese_tmp[0]=$data[1];
  if(!isset($mese_tmp[1])) $mese_tmp[1]="";
  if($mese_tmp[1]=="") $mese_tmp[1]=$mese_tmp[0];
  if($mese_tmp[0]!=$mese_tmp[1]) $return.="<tr><td  bgcolor=$style[table_bgcolor] height=\"1\" colspan=\"5\"></td></tr>";
  $return.= "<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\"><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"";
  if(date("w",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")-$i,date("Y")))==0)
    $return.="tabletextB";
    else
    $return.="tabletextA";
  $max=max($max,1);
  //$return.="\">$giorno</span></td><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$lista_accessi[$i]</b></span><br><span class=\"tabletextA\"><b>$lista_visite[$i]</b></span></td><td bgcolor=$style[table_bgcolor] width=\"300\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($lista_accessi[$i]/$max*250)."\" height=\"7\"></span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($lista_visite[$i]/$max * 250)."\" height=\"7\"></span></td><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">".$variazione2."<br>".$variazione."</span></td><td bgcolor=$style[table_bgcolor] width=\"16\"><img src=\"$img\"></td></tr>";
  $return.="\">$giorno</span></td><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$lista_accessi[$i]</b></span><br><span class=\"tabletextA\"><b>$lista_visite[$i]</b></span></td><td bgcolor=$style[table_bgcolor] width=\"300\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($lista_accessi[$i]/$max*250)."\" height=\"7\"></span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($lista_visite[$i]/$max * 250)."\" height=\"7\"></span></td><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">".$variazione."</span></td><td bgcolor=$style[table_bgcolor] width=\"16\"><img src=\"$img\"></td></tr>";
  $mese_tmp[1]=$mese_tmp[0];
  }
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"5\" nowrap></td></tr>";
$return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"5\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"5\" nowrap></td></tr>";  
$return.="</table>";
return($return);
}
?>
