<?php   ////////////////////////////////////////////////
        //   ___ _  _ ___     ___ _____ _ _____ ___   //
        //  | _ \ || | _ \___/ __|_   _/_\_   _/ __|  //
        //  |  _/ __ |  _/___\__ \ | |/ _ \| | \__ \  //
        //  |_| |_||_|_|0.1.8|___/ |_/_/ \_\_| |___/  //
        //                                            //
      ///////////////////////////////////////////////////
      //   Author: Roberto Valsania (Webmaster76)      //
      //    Staff: Matrix, Viewsource, PaoDJ, Fabry    //
      // Homepage: www.php-stats.com,                  //
      //           www.php-stats.it,                   //
	  //           www.php-stat.com                    //              
      ///////////////////////////////////////////////////

                  if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
             if(isset($_GET['id'])) $id=$_GET['id']; else $id="";
if(isset($_SERVER['HTTP_REFERER'])) $HTTP_REFERER=$_SERVER['HTTP_REFERER'];
 if(isset($_SERVER['REMOTE_ADDR'])) $ip=$_SERVER['REMOTE_ADDR'];

define('IN_PHPSTATS', true);
include("config.php");
include("inc/main_func.inc.php");
$get="";
if($option['prefix']=="") $option['prefix']="php_stats";
// Connessione a MySQL e selezione database
db_connect();
// Leggo le variabili di configurazione
$result=sql_query("SELECT name,value FROM $option[prefix]_config");
while($row=@mysql_fetch_array($result))
  $option[$row[0]]=$row[1];
$modulo=explode("|",$option['moduli']);  
// Inclusione lingua
include("lang/$option[language]/main_lang.inc");

// Statistiche attive?
if($option['stats_disabled']) die($string['click_stats_disabled']);

// Controllo la validità dell'id (Per evitare SQL injection!)
if(!ereg('(^[0-9]*[0-9]$)',$id)) die("$error[click_errs_id]");
if($id!="")
  {
  $result=sql_query("SELECT url FROM $option[prefix]_clicks WHERE id='$id' LIMIT 1");
  if(mysql_affected_rows()>0)
    list($get)=@mysql_fetch_row($result);
    else
    echo"<br><br><center>$error[click_noid]</center>";
  }
if($get!="")
  {
  $get=str_replace(" ","%20",$get);

    header("location: $get");
    sql_query("UPDATE $option[prefix]_clicks SET clicks=clicks+1 WHERE id='$id'");


//--> INIZIO codice mio

$actual_tot=sql_query("SELECT tot FROM $option[prefix]_clicks WHERE id='$id'");
$is_amico=sql_query("SELECT count(*) FROM $option[prefix]_clicks WHERE id='$id' AND nome LIKE 'amici%'");

$result2=sql_query("SELECT last_ip FROM $option[prefix]_clicks WHERE id='$id'"); 
if(mysql_affected_rows()>0)  { $row2=@mysql_fetch_row($result2); $last_visitor=$row2[0]; } 

  if($last_visitor!=$ip)
	 sql_query("UPDATE $option[prefix]_clicks SET last_ip='$ip', clicks=clicks+1 WHERE id='$id'");

sql_query("UPDATE $option[prefix]_clicks SET tot=tot+1 WHERE id='$id'");


// $result3=sql_query("SELECT count(*) FROM $option[prefix]_clicks WHERE id='$id' AND nome LIKE 'amici%'");
// if(mysql_affected_rows()>0)  { $row3=@mysql_fetch_row($result3); $is_amico=$row3[0]; }
 
if(!$is_amico)
{
	$result3=sql_query("SELECT tot FROM $option[prefix]_clicks WHERE id='$id'");
	if(mysql_affected_rows()>0)  { $row3=@mysql_fetch_row($result3); $real_tot=$row3[0]; }

//	$real_tot=sql_query("SELECT tot FROM $option[prefix]_clicks WHERE id='$id'");
	sql_query("UPDATE $option[prefix]_clicks SET clicks='$real_tot' WHERE id='$id'");
}

//--> FINE codice mio


  if($modulo[0]):	
  // INSERISCO NEI DETTAGLI IL CLICK
  $result=sql_query("SELECT visitor_id FROM $option[prefix]_cache WHERE user_id='$ip' LIMIT 1");
  if(@mysql_num_rows($result)>0)
    {
    list($visitor_id)=@mysql_fetch_row($result);
    $date=time()-$option['timezone']*3600;
    $loaded="clk|$id";
    sql_query("INSERT INTO $option[prefix]_details VALUES ('$visitor_id','$ip','','','','$date','','$loaded','','','')");
    }
  endif;		
  }
?>
