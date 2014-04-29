<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

if(isset($_GET['analizzati'])) $analizzati=addslashes($_GET['analizzati']); else $analizzati=0;
   if(isset($_GET['rimossi'])) $rimossi=addslashes($_GET['rimossi']); else $rimossi=0;
if(isset($_GET['oldrimossi'])) $oldrimossi=addslashes($_GET['oldrimossi']); else $oldrimossi=0;
     if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;

function refresh(){
global $option,$error,$style,$string,$modulo,$refresh,$url,$start,$analizzati,$rimossi,$oldrimossi,$phpstats_title;
$phpstats_title=$string['refr_title'];

// Inizializzo le variabili necessarie
$rimossi=0;
$num_refers=100; // Referer analizzati alla volta
$date=time();
$body="";

// Per evitare il timeout dello script. NOTA: Non ha effetto se php è in safe-mode.
@set_time_limit(1200);

$result=sql_query("SELECT * FROM $option[prefix]_referer LIMIT $start,$num_refers");
while($row=@mysql_fetch_array($result))
  {
  $refer=addslashes(stripslashes($row[0]));
  $analizzati++;
  list($nome_motore,$query)=getengine($refer);
  if(($nome_motore!="") AND ($query!=""))
    {
    $result2=sql_query("DELETE FROM $option[prefix]_referer WHERE data='".addslashes($row[0])."'");
    if(mysql_affected_rows()<1)
      {
      $body.="$string[refr_err] ".formaturl($row[0], "", 50, 20, -25)."<br>";
      }
      else
      {
      $rimossi++;
	  if($modulo[4]==2)
	    {
		$mese=date("Y-m",$row[2]); // determino il mese in base al time() del referer
	    $result2=sql_query("UPDATE $option[prefix]_query SET visits=visits+$row[1] WHERE data='$query' AND engine='$nome_motore' AND mese='$mese'");
	    }
		else
        $result2=sql_query("UPDATE $option[prefix]_query SET visits=visits+$row[1] WHERE data='$query' AND engine='$nome_motore'");
      if(mysql_affected_rows()<1)
        {
		if($modulo[4]==2)
          $result3=sql_query("INSERT INTO $option[prefix]_query VALUES('$query','$nome_motore','$row[1]',$date,'$mese')");		  
		  else		
          $result3=sql_query("INSERT INTO $option[prefix]_query VALUES('$query','$nome_motore','$row[1]',$date,'')");
        }
      }
    }
  //$result2=sql_query("UPDATE $option[prefix]_referer SET data='$refer' WHERE data='$row[0]'");
  }
$tmp=$string['refr_summary'];
$tmp=str_replace("%analizzati%",$analizzati,$tmp);
$tmp=str_replace("%rimossi%",$rimossi+$oldrimossi,$tmp);  
$body.=$tmp;
$start_tmp=$start+$num_refers-$rimossi;
$result2=sql_query("SELECT * FROM $option[prefix]_referer LIMIT $start_tmp,$num_refers");
// $righe=@mysql_result(sql_query("SELECT COUNT(1) AS num FROM $option[prefix]_referer"), 0, "num");
// if($analizzati>=$righe) {
if(mysql_num_rows($result2)<=0) {
  $body.="<br><br>".$string['refr_end'];
  }
  else
  {
  $refresh=1;
  $oldrimossi=$oldrimossi+$rimossi;
  $url="admin.php?action=refresh&start=".($start+$num_refers-$rimossi)."&analizzati=$analizzati&rimossi=$rimossi&oldrimossi=$oldrimossi";
  $tmp=str_replace("%HOWMANY%",$num_refers,$string['refr_next']);
  $tmp=str_replace("%URL%",$url,$tmp);
  $body.="<br><br>".$tmp;
  }
$return=info_box($string['refr_title'],$body);
return($return);
}
?>
