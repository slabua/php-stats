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

// Per ragioni di sicurezza i file inclusi avranno un controllo di provenienza
define('IN_PHPSTATS', true);

// inclusione delle principali funzioni esterne
if(!@include("config.php")) die("<b>ERRORE</b>: File config.php non accessibile.");
if(!@include("inc/main_func.inc.php")) die("<b>ERRORE</b>: File main_func.inc.php non accessibile.");
if($option['out_compress']) ob_start("ob_gzhandler");
if($option['prefix']=="") $option['prefix']="php_stats";

// Connessione a MySQL e selezione database
db_connect();

$tabelle=array("clicks","config","counters","daily","details","domains","downloads","hourly","ip","langs","pages","query","referer","systems","cache");

$page ="<html>";
$page.="\n<head>";
$page.="\n<title>Php-Stats 0.1.8 - Check Tables Utility</title>";
$page.="\n</head>";
$page.="\n<body>";
$page.="\n<center>";
$page.="\n<h3>Php-Stats 0.1.8 - Check Tables Utility</h3>";
$page.="\n<table border=\"0\">";
foreach($tabelle as $table)
  {
  $page.=checktable($option['prefix']."_".$table);
  }
$page.="\n</table>";
$page.="\n</center>";
$page.="\n</body>";
$page.="\n</html>";
echo"$page";

function checktable($table) {

$return="";
$result=sql_query("CHECK TABLE $table");
while($row=@mysql_fetch_array($result))
  {
  if($row[2]=='error')
    {
	if($row[3]=="The handler for the table doesn't support check/repair") 
	  {
      $row[2]='status';
      $row[3]="N/A";
	  $errorcode='This table does not support check/repair';
	  }  
	else
	  {
	  $errorcode=$row[3];
	  $row[2]='status';
	  $row[3]='error';
	  }
	$error=1;
    $return.="\n<tr>";
	$return.="\n\t<td>$row[0]</td>";
    $return.="\n\t<td>$row[1]</td>";
    $return.="\n\t<td>$row[2]</td>";
    $return.="\n\t<td bgcolor='red'>$row[3]</td>";		
    $return.="\n</tr>";
	$return.="\n<tr>\n\t<td colspan=4 align='center'>Error: $errorcode</td>\n</tr>";
	}
  elseif($row[2]=='warning')
    {
	$errorcode=$row[3];
	$row[2]='status';
	$row[3]='warning';
	$error=1;
    $return.="\n<tr>";
	$return.="\n\t<td>$row[0]</td>";
    $return.="\n\t<td>$row[1]</td>";
    $return.="\n\t<td>$row[2]</td>";
    $return.="\n\t<td bgcolor='yellow'>$row[3]</td>";		
    $return.="\n</tr>";
	$return.="\n<tr>\n\t<td colspan=4 align='center'>Warning: $errorcode</td>\n</tr>";
    }	
  else
	{
	$error=0;
    $return.="\n<tr>";
	$return.="\n\t<td>$row[0]</td>";
    $return.="\n\t<td>$row[1]</td>";
    $return.="\n\t<td>$row[2]</td>";
    $return.="\n\t<td bgcolor='green'>$row[3]</td>";		
    $return.="\n</tr>";
	}
  }
if($error==1) 
  {
  $result2=sql_query("REPAIR TABLE $table");
  while($row2=@mysql_fetch_array($result2)) 
    {
    if($row2[3]!='OK')
      $return.="\n<tr>\n\t<td colspan=4 align='center' bgcolor='red'>REPAIR FAILED</td>\n</tr>";
      else
      $return.="\n<tr>\n\t<td colspan=4 align='center' bgcolor='green'>RIPAIRED</td>\n</tr>";
    }
  } 
return($return);  
}
?>