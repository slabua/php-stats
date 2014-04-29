<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

function trend() {
global $db,$option,$style,$string,$varie,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['trend_title'];
//
$return="";
$day_prevision=0;
// HO AVUTO PROBLEMI CON POW PERCIO' IN ALCUNI CASI L'HO ESCLUSO
// VEDO SE CI SONO 31 GIORNI PER LA PREVISIONE
$righe_totali=@mysql_result(sql_query("SELECT COUNT(1) AS num FROM $option[prefix]_daily"), 0, "num");
if($righe_totali>2) 
  {
  $oggi=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d"),date("Y")));
  $result=sql_query("SELECT * FROM $option[prefix]_daily ORDER BY data ASC LIMIT 0,1");
  while($row=@mysql_fetch_array($result)) 
    {
    list($anno_y,$mese_y,$giorno_y)=explode("-","$row[0]");
    $data=explode("-",$row[0]);
    $tmp=str_replace("%mount%", formatmount($data[1]),$varie['date_format']);
    $tmp=str_replace("%day%",$data[2],$tmp);
    $tmp=str_replace("%year%",$data[0],$tmp);
    $started=$tmp;
    }
  list($anno_t,$mese_t,$giorno_t)=explode("-","$oggi");
  $trascorsi=(mktime(0,0,0,$mese_t,$giorno_t,$anno_t)-mktime (0,0,0,$mese_y,$giorno_y,$anno_y))/86400;
  $actual_day=date("Y-m-d");
  $startime_set=mktime (0,0,0,$mese_y,$giorno_y,$anno_y);
  $endtime_set=mktime (0,0,0,$mese_t,$giorno_t,$anno_t);

  // CASO GIORNI TRASCORSI >31 MEDIA MATEMATICA VALORI GIORNI PRECEDENTI E REGRESSIONE LINEARE
  if($trascorsi>31) 
    {
    $day_prevision=31;
    for($i=0;$i<$trascorsi;$i++) 
	  {
      $hits_vari_giorni[$i]=0;
      $visite_vari_giorni[$i]=0; 
	  }
    $limite_giorni=90;
    $result=sql_query("SELECT * FROM $option[prefix]_daily");
    $num_valori_totali=@mysql_numrows($result);
    if(($num_valori_totali<$trascorsi)|($num_valori_totali<90)) $limite_giorni=$num_valori_totali;
    // IL CALCOLO SE POSSIBILE VIENE FATTO SULLA BASE DEGLI ULTIMI 90 VALORI UTILI
    $limite_inferiore=$num_valori_totali-$limite_giorni;
    if($limite_inferiore<0) $limite_inferiore=0;
    $result=sql_query("SELECT * FROM $option[prefix]_daily ORDER BY data ASC LIMIT $limite_inferiore,1");
    while($row=@mysql_fetch_array($result)) 
	  {
      list($anno_y,$mese_y,$giorno_y)=explode("-","$row[0]");
      $data=explode("-",$row[0]);
      $tmp=str_replace("%mount%", formatmount($data[1]),$varie['date_format']);
      $tmp=str_replace("%day%",$data[2],$tmp);
      $tmp=str_replace("%year%",$data[0],$tmp);
      $point_start_day=$tmp; 
	  }
    for($i=0;$i<=6;$i++)
	  {
      $somma_hits_totali[$i]=0;
      $somma_visite_totali[$i]=0;
      $numero_settimane_hits[$i]=0;
      $numero_settimane_visite[$i]=0; 
      $tabella_valori_giorni_hits[$i]=0;
      $tabella_valori_giorni_visite[$i]=0; }
      $result=sql_query("SELECT * FROM $option[prefix]_daily ORDER BY data ASC LIMIT $limite_inferiore,$limite_giorni");
      while($row=@mysql_fetch_array($result)) 
	    {
	    list($anno_y,$mese_y,$giorno_y)=explode("-","$row[0]");
	    $rif_day="$anno_y-$mese_y-$giorno_y";
	    if($actual_day!=$rif_day)
		  {
	      $point_day=$trascorsi-((mktime(0,0,0,$mese_t,$giorno_t,$anno_t)-mktime (0,0,0,$mese_y,$giorno_y,$anno_y))/86400);
	      if($row[1]=="") $hits_vari_giorni[$point_day]=0; else $hits_vari_giorni[$point_day]=$row[1];
	      if($row[2]=="") $visite_vari_giorni[$point_day]=0; else $visite_vari_giorni[$point_day]=$row[2];
	      $giorno_settimana=date("w", mktime(0,0,0,$mese_y,$giorno_y,$anno_y));
	      $tabella_valori_giorni_hits[$giorno_settimana]+=$hits_vari_giorni[$point_day];
	      $tabella_valori_giorni_visite[$giorno_settimana]+=$visite_vari_giorni[$point_day];
	      $numero_settimane_hits[$giorno_settimana]++; //FORNISCE IL NUMERO DI SETTIMANE
	      $numero_settimane_visite[$giorno_settimana]++; //FORNISCE IL NUMERO DI SETTIMANE
	      }
	    }
	    // Da qui in poi non usero' array_sum e le varie funzioni sulle array per compatibilita' con php<4.0.4
	    // Sommatoria valori Y
	    $sigma_y_hits=0;
	    $sigma_y_visite=0;
	    for($i=0;$i<$trascorsi;$i++) 
		  {
	      $sigma_y_hits+=$hits_vari_giorni[$i];
	      $sigma_y_visite+=$visite_vari_giorni[$i];
		  }
	    // Sommatoria valori X
	    $sigma_x=0;
	    for($i=1;$i<=$trascorsi;$i++) 
	      $sigma_x+=$i;
	    // Sommatoria valori X^2
	    $sigma_x2=0;
	    for($i=1;$i<=$trascorsi;$i++) 
		  $sigma_x2+=pow($i,2);
	    // Sommatoria valori X^3
	    $sigma_x3=0;
	    for($i=1;$i<=$trascorsi;$i++)
	      $sigma_x3+=pow($i,3);
	    // Sommatoria valori X^4
	    $sigma_x4=0;
	    for($i=1;$i<=$trascorsi;$i++)
	      $sigma_x4+=pow($i,4);
	    // Sommatoria valori X^5
	    $sigma_x5=0;
	    for($i=1;$i<=$trascorsi;$i++) 
	      $sigma_x5+=pow($i,5);
	    // Sommatoria valori X^6
	    $sigma_x6=0;
	    for($i=1;$i<=$trascorsi;$i++)
	      $sigma_x6+=pow($i,6);
	    // Sommatoria valori X^7
	    $sigma_x7=0;
	    for($i=1;$i<=$trascorsi;$i++)
	      $sigma_x7+=pow($i,7);
	    // Sommatoria valori X^8
	    $sigma_x8=0;
	    for ($i=1;$i<=$trascorsi;$i++)
	      $sigma_x8+=pow($i,8);
	    // Sommatoria valori Y^2
	    $sigma_y2_hits=0;
	    $sigma_y2_visite=0;
	    for($i=0;$i<$trascorsi;$i++)
		  {
	      $sigma_y2_hits+=$hits_vari_giorni[$i]*$hits_vari_giorni[$i];
	      $sigma_y2_visite+=$visite_vari_giorni[$i]*$visite_vari_giorni[$i];
	      // $sigma_y2_hits+=pow($hits_vari_giorni[$i], 2);
	      // $sigma_y2_visite+=pow($visite_vari_giorni[$i], 2);
	      }
	    // Sommatoria valori X*Y
	    $sigma_xy_hits=0;
	    $sigma_xy_visite=0;
	    for($i=0;$i<$trascorsi;$i++) 
		  {
	      $sigma_xy_hits+=($hits_vari_giorni[$i]*($i+1));
	      $sigma_xy_visite+=($visite_vari_giorni[$i]*($i+1)); 
		  }
		// Sommatoria valori X^2*Y
		$sigma_x2y_hits=0;
		$sigma_x2y_visite=0;
		for($i=0;$i<$trascorsi;$i++) 
		  {
		  $sigma_x2y_hits+=(pow(($i+1),2)*$hits_vari_giorni[$i]);
		  $sigma_x2y_visite+=(pow(($i+1),2)*$visite_vari_giorni[$i]); 
 		  }
		// Sommatoria valori X^3*Y
		$sigma_x3y_hits=0;
		$sigma_x3y_visite=0;
		for($i=0;$i<$trascorsi;$i++) 
		  {
		  $sigma_x3y_hits+=(pow(($i+1),3)*$hits_vari_giorni[$i]);
		  $sigma_x3y_visite+=(pow(($i+1),3)*$visite_vari_giorni[$i]); 
  		  }
		// Sommatoria valori X^4*Y
		$sigma_x4y_hits=0;
		$sigma_x4y_visite=0;
		for($i=0;$i<$trascorsi;$i++) 
		  {
		  $sigma_x4y_hits+=(pow(($i+1),4)*$hits_vari_giorni[$i]);
		  $sigma_x4y_visite+=(pow(($i+1),4)*$visite_vari_giorni[$i]); 
		  }
		// CALCOLO RETTA REGRESSIONE LINEARE Y=A+BX
		$a_hits_rl=(($sigma_y_hits*$sigma_x2)-($sigma_x*$sigma_xy_hits))/(($trascorsi*$sigma_x2)-($sigma_x*$sigma_x));
		$a_visite_rl=(($sigma_y_visite*$sigma_x2)-($sigma_x*$sigma_xy_visite))/(($trascorsi*$sigma_x2)-($sigma_x*$sigma_x));
		$b_hits_rl=(($trascorsi*$sigma_xy_hits)-($sigma_x*$sigma_y_hits))/(($trascorsi*$sigma_x2)-($sigma_x*$sigma_x));
		$b_visite_rl=(($trascorsi*$sigma_xy_visite)-($sigma_x*$sigma_y_visite))/(($trascorsi*$sigma_x2)-($sigma_x*$sigma_x));
		// CALCOLO PARABOLA POLINOMIALE Y=C2*X^2+C1*X+C0
		$matrice[1][1]=$trascorsi;
		$matrice[1][2]=$sigma_x;
		$matrice[1][3]=$sigma_x2;
		$matrice[2][1]=$sigma_x;
		$matrice[2][2]=$sigma_x2;
		$matrice[2][3]=$sigma_x3;
		$matrice[3][1]=$sigma_x2;
		$matrice[3][2]=$sigma_x3;
		$matrice[3][3]=$sigma_x4;
		$coeff_hits[1]=-$sigma_y_hits;
		$coeff_hits[2]=-$sigma_xy_hits;
		$coeff_hits[3]=-$sigma_x2y_hits;
		$coeff_visite[1]=-$sigma_y_visite;
		$coeff_visite[2]=-$sigma_xy_visite;
		$coeff_visite[3]=-$sigma_x2y_visite;
		$rango=3;
		for($q=1;$q<=$rango;$q++) 
		  {
		  $max=0;
		  for($s=$q;$s<=$rango;$s++) 
		    {
            if(abs($matrice[$s][$q])>$max) 
			  {
		      $max=abs($matrice[$s][$q]);
		      $point=$s;
			  } 
			}
		  if($point!=$q) 
		    {
		    for($k=1;$k<=$rango;$k++)
			  {
		      $tmp_matrix=$matrice[$point][$k];
		      $matrice[$point][$k]=$matrice[$q][$k];
		      $matrice[$q][$k]=$tmp_matrix; 
		      } 
		    $tmp_coeff=$coeff_hits[$point];
		    $coeff_hits[$point]=$coeff_hits[$q];
		    $coeff_hits[$q]=$tmp_coeff;
		    $tmp_coeff=$coeff_visite[$point];
		    $coeff_visite[$point]=$coeff_visite[$q];
		    $coeff_visite[$q]=$tmp_coeff;
		    }
		  $rif=$q+1;
		  if($q!=$rango) 
		    {
		    for ($j=$rif;$j<=$rango;$j++) 
			  { 
			  $m[$j]=-($matrice[$j][$q]/$matrice[$q][$q]); 
			  }
		    for($j=$rif;$j<=$rango;$j++) 
			  {
		      for($t=1;$t<=$rango;$t++) 
			    {
		        $matrice[$j][$t]=($m[$j]*$matrice[$q][$t])+$matrice[$j][$t];
		        }
			  }
		    for($j=$rif;$j<=$rango;$j++)
			  {
		      $coeff_hits[$j]=($m[$j]*$coeff_hits[$q])+$coeff_hits[$j];
		      $coeff_visite[$j]=($m[$j]*$coeff_visite[$q])+$coeff_visite[$j];
              }
			}
		  }
		for($f=$rango;$f>=1;$f--)
		  {
		  $ausil_hits=0;
		  $ausil_visite=0;
		  if($f!=$rango)
		    {
		    for($g=$f+1;$g<=$rango;$g++) 
			  {
		      $ausil_hits=$matrice[$f][$g]*$sol_hits[$g]+$ausil_hits;
		      $ausil_visite=$matrice[$f][$g]*$sol_visite[$g]+$ausil_visite;
			  }
			}
		  $sol_hits[$f]=((-$coeff_hits[$f])-$ausil_hits)/$matrice[$f][$f];
		  $sol_visite[$f]=((-$coeff_visite[$f])-$ausil_visite)/$matrice[$f][$f]; 
		  }
		$c0_hits_rp=$sol_hits[1];
		$c0_visite_rp=$sol_visite[1];
		$c1_hits_rp=$sol_hits[2];
		$c1_visite_rp=$sol_visite[2];
		$c2_hits_rp=$sol_hits[3];
		$c2_visite_rp=$sol_visite[3];
		// PREVISIONI PROSSIMI 31 GIORNI MEDIA TRA RETTA DI REGRESSIONE LINEARE E POLINOMIALE di SECONDO
		for($i=0;$i<31;$i++) 
		  {
		  $prev_hits[$i]=(($a_hits_rl+$b_hits_rl*($i+$trascorsi))+($c2_hits_rp*pow(($i+$trascorsi), 2)+$c1_hits_rp*($i+$trascorsi)+$c0_hits_rp))/2;
		  $prev_visite[$i]=(($a_visite_rl+$b_visite_rl*($i+$trascorsi))+($c2_visite_rp*pow(($i+$trascorsi), 2)+$c1_visite_rp*($i+$trascorsi)+$c0_visite_rp))/2;
		  }
		}
	  if($day_prevision==0) $return.=info_box($string['warning'],$string['trend_nodaily']); 
        else 
		{
		// PREVISIONE STATISTICA
		if($day_prevision==1) 
		  {
		  $previsione_hits[1]=$media_hits;
		  $previsione_visite[1]=$media_visite;
		  $giorni_di_previsione=1; 
		  }
		if($day_prevision==7) 
		  {
		  $giorni_di_previsione=7;
		  for($i=1;$i<=7;$i++) 
		    {
		    $previsione_hits[$i]=$media_hits[$i-1];
		    $previsione_visite[$i]=$media_visite[$i-1];
		    }
		  }
		if($day_prevision==31) 
		  {
		  $giorni_di_previsione=31;
		  for ($i=1;$i<=31;$i++) 
		    {
		    $previsione_hits[$i]=$prev_hits[$i-1];
		    $previsione_visite[$i]=$prev_visite[$i-1];
		    }
		  }
		$return.="<span class=\"pagetitle\">$string[trend_title]<br><br></span>";
		$return.="<table border=\"0\" $style[table_header] width=\"60%\"><tr>";
		$return.=draw_table_title($string['trend_day']);
		$return.=draw_table_title($string['trend_hits']);
		$return.=draw_table_title($string['trend_visits']);
		$return.="</tr>";
		for($i=1;$i<=$giorni_di_previsione;$i++) 
		  {
		  $giorno=date("Y-m-d",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")+$i,date("Y")));
		  $giorno_settimana=date("w",mktime(date("G")-$option['timezone'],date("i"),0,date("m"),date("d")+$i,date("Y")));
		  $data=explode("-",$giorno);
		  $tmp=str_replace("%mount%", formatmount($data[1]),$varie['date_format']);
		  $tmp=str_replace("%day%",$data[2],$tmp);
		  $tmp=str_replace("%year%",$data[0],$tmp);
		  $giorno=$tmp;
		  $return.="<tr onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
 		  $return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$giorno</td>";
if($day_prevision==31) 
      {
      //$hits=round(($previsione_hits[$i]+$media_hits[$giorno_settimana])/2, 0);
      //$visite=round(($previsione_visite[$i]+$media_visite[$giorno_settimana])/2, 0);
	  $hits=round(($previsione_hits[$i]),0);
      $visite=round(($previsione_visite[$i]),0);
      }
      else
      {
	  $hits=round($previsione_hits[$i],0);
      $visite=round($previsione_visite[$i],0);
      }
	if($hits<0) $hits=0;
      if($visite<0) $visite=0;
      if(($visite==0)&($hits>0)) $visite=1;
      if($visite>$hits) $hits=$visite;
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$hits</td>";
	$return.="<td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$visite</td>";
	$return.= "</tr>";
    }
$return.="</table>";
    } 
  }
  else
  $return.=info_box($string['information'],$string['trend_nodaily']);
return($return);
}
?>