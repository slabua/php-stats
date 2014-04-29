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

function searched_words() {
global $db,$option,$style,$string,$varie,$error,$modulo,$mode,$phpstats_title;
global $mese,$anno,$sel_anno,$sel_mese;

$search=array("\"","'","+"," AND "," OR ","+","(",")",":",".","[","]","\\","/");
$replace=array("", ""," "," "," "," "," "," "," "," "," "," "," "," ");
	
if(strlen("$sel_mese")<2) $sel_mese="0".$sel_mese;

$return="";

if($mode==0) 
  $clause="WHERE mese='$sel_anno-$sel_mese'";
  else
  $clause="";
// Titolo pagina (riportata anche nell'admin)
if($mode==0) {
  $phpstats_title=str_replace("%MESE%",formatmount($sel_mese),$string['searched_words_title_2']);
  $phpstats_title=str_replace("%ANNO%",$sel_anno,$phpstats_title); 
  }
  else
  $phpstats_title=$string['searched_words_title'];
//  
$result=sql_query("SELECT data,visits FROM $option[prefix]_query $clause");
$num_totale=@mysql_numrows($result);
if($num_totale>0)
  {
  while($row=mysql_fetch_array($result))
    {
    // ELIMINO CARATTERI NON UTILI
    $row[0]=str_replace($search,$replace,$row[0]);
    $row[0]=eregi_replace('( ){2,}',' ',$row[0]);
    $this_query_words=explode(" ",$row[0]);
    foreach($this_query_words as $word) 
      {
      if(strlen($word)>2)
	    {
        if(isset($word_list[$word]))
	      $word_list[$word]+=$row[1];
          else
          $word_list[$word]=$row[1];
        }
      }
    }
  arsort($word_list);
 
  if($mode==0){
    // MEMORIZZO LE QUERY DEL MESE PRECEDENTE PER I CONFRONTI
    $mese_prec=date("Y-m",mktime(0,0,0,$sel_mese-1,1,$sel_anno));
	$result=sql_query("SELECT data,visits FROM $option[prefix]_query WHERE mese='$mese_prec'");
    while($row=mysql_fetch_array($result))
    {
    // ELIMINO CARATTERI NON UTILI
    $row[0]=str_replace($search,$replace,$row[0]);
    $row[0]=eregi_replace('( ){2,}',' ',$row[0]);
    $this_query_words=explode(" ",$row[0]);
    foreach($this_query_words as $word) 
      {
      if(strlen($word)>2) // Non considero parole con meno di 3 lettere
	    {
        if(isset($word_list_2[$word])) $word_list_2[$word]+=$row[1];
                                  else $word_list_2[$word]=$row[1];
        }
      }
    }
  }
  // Titolo pagina
  $return.="<span class=\"pagetitle\">$phpstats_title</span><br><br>";
  // Inizio tabella risultati
  $return.="\n<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\">";
  if($mode==0)
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";	
    else
	$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"3\" nowrap></td></tr>";
  $i=1;
  foreach ($word_list as $key => $value) 
    { 
    $return.="\n<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
    $return.="\n\t<td bgcolor=$style[table_bgcolor] width=\"30\" align=\"right\" nowrap><span class=\"tabletextA\">$i</span></td>";
    $return.="\n\t<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$key</span></td>";
    $return.="\n\t<td bgcolor=$style[table_bgcolor] width=\"30\" nowrap><span class=\"tabletextA\">$value</span></td>";
	
	// VARIAZIONI RISPETTO AL MESE PRECEDENTE
	if($mode==0):
	if(isset($word_list_2[$key])) {
	  $prec=$word_list_2[$key];
	  $variazione=round(($value-$prec)/$value*100,1);
	        if($variazione<-15)                      $img="templates/$option[template]/images/icon_level_1.gif";
      elseif(($variazione>=-15) && ($variazione<-5)) $img="templates/$option[template]/images/icon_level_2.gif";
       elseif(($variazione>=-5) && ($variazione<5))  $img="templates/$option[template]/images/icon_level_3.gif";
        elseif(($variazione>=5) && ($variazione<15)) $img="templates/$option[template]/images/icon_level_4.gif";
        elseif($variazione>=15)                      $img="templates/$option[template]/images/icon_level_5.gif";
      if($variazione>0) $variazione="+".$variazione;
      $variazione.=" %";
	  $alt_img=str_replace("%HITS%",$prec,$string['searched_words_last_m']);
	  $alt_img.="\n".str_replace("%VARIAZIONE%",$variazione,$string['searched_words_last_v']);
  	  $return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\" width=\"16\"><span class=\"tabletextA\"><img src=\"$img\" title=\"$alt_img\"></span></td>";
	  }
	  else
	  $return.="<td bgcolor=$style[table_bgcolor] nowrap=\"1\" width=\"16\"><span class=\"tabletextA\"><img src=\"templates/$option[template]/images/icon_level_new.gif\"></span></td>";
    endif;
	
	$return.="</tr>";
    $i++;
    if($i>100) break;
    }
  if($mode==0)
    $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"4\" nowrap></td></tr>";	
    else
	$return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"3\" nowrap></td></tr>";
  $return.="</table>";
  }
  else
  {
  // NESSUN RISULTATO
  if($mode==1)
    $return.=info_box($string['information'],$error['searched_words']);
    else
    {
    $tmp=str_replace("%MESE%",formatmount($sel_mese),$error['searched_words_2']);
	$tmp=str_replace("%ANNO%",$sel_anno,$tmp);
    $return.=info_box($string['information'],$tmp);
	}
  }
if($modulo[4]==2) 
  {
  if($mode==0) $new_mode1=1; else $new_mode1=0;
  if($mode==0)
    {
    $return.="<br><center>";
    $return.="<FORM action='./admin.php?action=searched_words&mode=$mode' method='POST' name=form1>";
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
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=searched_words&mode=1\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[searched_words_query_vis_glob]</a></span></td></tr>";
    }
	else
	{
	$return.="<br><table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
	$return.="<tr><td><span class=\"testo\"><a href=\"admin.php?action=searched_words&mode=0\"><img src=templates/$option[template]/images/icon_change.gif border=\"0\" align=\"absmiddle\" hspace=\"1\" vspace=\"1\"> $string[searched_words_query_vis_mens]</a></span></td></tr>";
	}
  $return.="</table></center>";
  }  

// RESTITUISCO OUTPUT
return($return);
}

?>