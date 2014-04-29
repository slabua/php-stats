<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

function monthly() {
global $db,$option,$string,$style,$error,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['monthly_title'];
// Titolo
$return="<span class=\"pagetitle\">$phpstats_title<br><br></span>";
//
$max=0;
$giorni=array("01"=>31,"02"=>28,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);
$anno=date("m",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
if(($anno % 4) ==0) $giorni["02"]=29; else $giorni["02"]=28; // Anno bisestile????
for($i=0;$i<=13;$i++)
  {
  $lista_accessi[$i]=0;
  $lista_visite[$i]=0;
  $mese=date("Y-m",mktime(0,0,0,date("m")-$i,date("1"),date("Y")));
  $lista_mesi[$i]=$mese;
  $result=sql_query("SELECT * FROM $option[prefix]_daily WHERE data LIKE '$mese%'");
  $lista_accessi[$mese]=0;
  $lista_visite[$mese]=0;
  while($row=@mysql_fetch_array($result))
    {
    $lista_accessi[$i]+=$row[1];
    $lista_visite[$i]+=$row[2];
    if($lista_accessi[$i]>$max) $max=$lista_accessi[$i];
    }
  }
if($max<1) $max=1; // Per evitare il warning di "Division by Zero"
$return.="<table border=\"0\" width=\"90%\" $style[table_header]  align=\"center\" >";
$return.="<tr>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[monthly_nome]</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[monthly_hits]</center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center></center></span></td>";
$return.="</tr>";
for($i=0;$i<=12;$i++)
  {
  if($lista_visite[$i+1]>0)
    {
	if($i==0) {
	$mese=date("m",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
	$giorno=date("j",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
	$variazione=round((($lista_visite[$i]*($giorni[$mese]/$giorno))-$lista_visite[$i+1])/$lista_visite[$i+1]*100,1);
	}
	else
	$variazione=round(($lista_visite[$i]-$lista_visite[$i+1])/$lista_visite[$i+1]*100,1);
	if($variazione<-15) $img="templates/$option[template]/images/icon_level_1.gif";
    elseif(($variazione>=-15) && ($variazione<-5)) $img="templates/$option[template]/images/icon_level_2.gif";
    elseif(($variazione>=-5) && ($variazione<=5)) $img="templates/$option[template]/images/icon_level_3.gif";
    elseif(($variazione>5) && ($variazione<15)) $img="templates/$option[template]/images/icon_level_4.gif";
    elseif($variazione>=15) $img="templates/$option[template]/images/icon_level_5.gif";
    if($variazione>0) $variazione="+".$variazione;
    $variazione.=" %";
    if($i==0) $variazione="($variazione)"; // Metto tra parentesi il mese corrente
	}
    else
    {
    $variazione="-";
    $img="templates/$option[template]/images/icon_level_unkn.gif";
    if($lista_visite[$i]>0) $img="templates/$option[template]/images/icon_level_5.gif";
    }
  if($lista_visite[$i]==0)
    {
    $variazione="-";
    $img="templates/$option[template]/images/icon_level_unkn.gif";
    }
  $return.= "<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\"><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">".formatdate($lista_mesi[$i],1)."</span></td><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>$lista_accessi[$i]</b></span><br><span class=\"tabletextA\"><b>$lista_visite[$i]</b></span></td><td bgcolor=$style[table_bgcolor] width=\"300\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"".($lista_accessi[$i]/$max * 300)."\" height=\"7\"></span><br><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"".($lista_visite[$i]/$max * 300)."\" height=\"7\"></span></td><td bgcolor=$style[table_bgcolor] align=\"center\"><span class=\"tabletextA\">".$variazione."</span></td><td bgcolor=$style[table_bgcolor] width=\"16\"><img src=\"$img\"></td></tr>";
  }
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"5\" nowrap></td></tr>";
$return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"5\" nowrap><span class=\"tabletextA\"><center><img src=\"templates/$option[template]/images/style_bar_1.gif\" width=\"7\" height=\"7\"> $string[hits] <img src=\"templates/$option[template]/images/style_bar_2.gif\" width=\"7\" height=\"7\"> $string[visite]</span></center></td></tr>";
$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"5\" nowrap></td></tr>";
$return.="</table>";
return($return);
}
?>
