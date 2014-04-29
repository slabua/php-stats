<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");
//
if(isset($_POST['viewcalendar'])) $viewcalendar=addslashes($_POST['viewcalendar']); else $viewcalendar="last";
if(isset($_POST['calendarmode'])) $calendarmode=addslashes($_POST['calendarmode']); else $calendarmode=1;

function calendar() {
global $db,$option,$string,$error,$varie,$style,$viewcalendar,$calendarmode,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['calendar_title'];
// Titolo
$return="<span class=\"pagetitle\">$phpstats_title<br><br></span>";
//
$giorni=array("01"=>31,"02"=>28,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);
$result=sql_query("SELECT min(data) FROM $option[prefix]_daily");
$row=@mysql_fetch_row($result);
$ini_y=substr($row[0],0,4);
if($ini_y=="") $ini_y=date("Y");
$return.="<table border=\"0\" $style[table_header] width=\"95%\" align=\"center\" ><tr>";
$return.="<td bgcolor=$style[table_title_bgcolor] nowrap  class=\"tabletitle\"></td>";
if($viewcalendar=="last")
  {
  if(date("m")<12)
    $anno=date("Y")-1;
    else
    $anno=date("Y");
  $y=date("m")+1;
  }
  else
  {
  $y=1;
  $anno=$viewcalendar;
  }
$conto=1;
while($conto<=12)
  {
  if($y>12)
    {
    $y=1;
    $anno=$anno+1;
    }
    $return.="<td bgcolor=$style[table_title_bgcolor] nowrap class=\"tabletitle\"><center>".formatmount($y,1)."</center></td>";
    $y=$y+1;
    $conto=$conto+1;
  }
$return.="</tr>";
for($k=1;$k<=31;$k++)
  {
  if(strlen($k)==1)
    {
    $k= str_pad($k,2, "0", STR_PAD_LEFT);
    }
  $return.="<tr><td bgcolor=$style[table_title_bgcolor] width=\"10\" nowrap class=\"tabletitle\">$k</td>";
  if($viewcalendar=="last")
    {
    if(date("m")<12)
      {
      $anno=date("Y")-1;
      $y=date("m")+1;
      }
      else
      {
      $anno=date("Y");
      $y=1;
      }
	}
    else
    {
    $y=1;
    }
  $conto=1;
  while($conto<=12)
    {
    if($y>12)
      {
      $y=1;
      $anno=$anno+1;
      }
    $i=1;
    if(strlen($y)==1)
      {
      $y= str_pad($y,2, "0", STR_PAD_LEFT);
      }
    $return.="<td align='right' class='text' bgcolor=$style[table_bgcolor] >";
   //VERIFICO CHE LA QUERY ABBIA SENSO PRIMA DI EFFETTUARLA ;)
   if(($anno % 4) ==0) $giorni["02"]=29; else $giorni["02"]=28; // Anno bisestile????
   $max=$giorni[$y];
   if($k<=$max)
     {
    $result=sql_query("SELECT * FROM $option[prefix]_daily WHERE data='$anno-$y-$k'");
    $i=1;
    //echo"$k - $y<br>";
    if(date("w",mktime(0,0,0,$y,$k,$anno))==0)
      $return.="<span class=\"tabletextB\">";
      else
      $return.="<span class=\"tabletextA\">";
    if(@mysql_num_rows($result)>0)
      {
      while($row=@mysql_fetch_array($result))
        {
        $lista_data=$row[0];
        $lista_accessi=$row[1];
        $lista_visite=$row[2];
        //echo"$lista_data -- $lista_accessi -- $lista_visite -- $k -- $y -- $anno -- $conto<br>";
		if($calendarmode==0) $what=$lista_accessi; else $what=$lista_visite;
		  if(isset($min_accessi[$conto])) 
		    $min_accessi[$conto]=min($min_accessi[$conto],$what);
		    else
		    $min_accessi[$conto]=$what;
		  if(isset($max_accessi[$conto])) 
		    $max_accessi[$conto]=max($max_accessi[$conto],$what);
		    else
		    $max_accessi[$conto]=$what;
		if(isset($giorni_utili[$conto])) $giorni_utili[$conto]++; else $giorni_utili[$conto]=1;
		}
      if($calendarmode==0)
        {
        $return.=$lista_accessi;
        //$totale[$conto]+=$lista_accessi;
		if(isset($totale[$conto])) $totale[$conto]+=$lista_accessi; else $totale[$conto]=$lista_accessi;
        }
        else
        {
        $return.=$lista_visite;
        if(isset($totale[$conto])) $totale[$conto]+=$lista_visite; else $totale[$conto]=$lista_visite;
        }
      }
      else
      {
      $return.="-";
      }
      $return.="</span>";
    }
    else
    {
    $return.="<center></center>";
    }// fine verifica query
  $return.="</td>";
  $y=$y+1;
  $conto=$conto+1;
  }
}
$return.="</tr>";
// Separatore
$return.= "<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"13\" height=\"1\" nowrap></td></tr>";
// TOTALI
$return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
$return.="<td bgcolor=$style[table_bgcolor] width=\"10\" nowrap><span class=\"tabletextA\">".$string['calendar_day_total']."</span></td>";
for($i=1;$i<13;$i++)
  {
  if(!isset($totale[$i])) $totale[$i]="-";
   $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\"><b>".$totale[$i]."</b></span></td>";
  }
$return.="</tr>";
// MINIMI
$return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
$return.="<td bgcolor=$style[table_bgcolor] width=\"10\" nowrap><span class=\"tabletextA\">".$string['calendar_day_worst']."</span></td>";
for($i=1;$i<13;$i++)
  {
  if(!isset($min_accessi[$i])) $min_accessi[$i]="-";
   $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">".$min_accessi[$i]."</span></td>";
  }
$return.="</tr>";
// MASSIMI
$return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
$return.="<td bgcolor=$style[table_bgcolor] width=\"10\" nowrap><span class=\"tabletextA\">".$string['calendar_day_best']."</span></td>";
for($i=1;$i<13;$i++)
  {
  if(!isset($max_accessi[$i])) $max_accessi[$i]="-";
   $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">".$max_accessi[$i]."</span></td>";
  }
$return.="</tr>";
// MEDIA
$return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
$return.="<td bgcolor=$style[table_bgcolor]  width=\"10\" nowrap><span class=\"tabletextA\">".$string['calendar_day_average']."</span></td>";
for($i=1;$i<13;$i++)
  {
  if(!isset($giorni_utili[$i])) $media="-"; else { $media=round((($totale[$i])/$giorni_utili[$i]),1); }
   $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">".$media."</span></td>";
  }
$return.="</tr>";
// Separatore
$return.= "<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"13\" height=\"1\" nowrap></td></tr>";
$return.="</table>";

// FORM CON LA SELEZIONE DELLE OPZIONI CALENDARIO
$return.="<br><br><center><form action='./admin.php?action=calendar' method='POST' name=form1><span class=\"tabletextA\">$string[calendar_view]</span>";
$return.="<SELECT name=calendarmode>";
$return.="<OPTION value='0'"; if($calendarmode==0) $return.=" SELECTED"; $return.=">$string[hits]</OPTION>";
$return.="<OPTION value='1'"; if($calendarmode==1) $return.=" SELECTED"; $return.=">$string[visite]</OPTION></SELECT>";
$return.="<SELECT name=viewcalendar>";
for($i=$ini_y;$i<=date("Y");$i++)
  {
  $return.="<OPTION value='$i'";if($viewcalendar==$i) $return.=" SELECTED"; $return.=">$i</OPTION>";
  }
$return.="<OPTION value='last'";if($viewcalendar=='last') $return.=" SELECTED"; $return.=">$string[calendar_last]</OPTION>";
$return.="</SELECT>";
$return.="<input type=\"submit\" value=\"$string[go]\">";
$return.="</FORM>";
$return.="</center>";
return($return);
}
?>
