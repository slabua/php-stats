<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

function esclusioni() {
global $php_stats_esclusion,$string,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['esclude_title'];
// Titolo
$return="<span class=\"pagetitle\">$phpstats_title<br><br></span>";
//
if($php_stats_esclusion==1) 
  {
  $status=$string['esclude_status_on'];
  $click_value=$string['esclude_inc'];
  $php_stats_esclusion=0;
  }
  else
  {
  $status=$string['esclude_status_of'];
  $click_value=$string['esclude_esc'];
  $php_stats_esclusion=1;
  }
$body =$status;
$body.="<form action=\"admin.php?action=esclusioni&opzioni=change\" method=\"post\">";
$body.="<input type=\"hidden\" name=\"option_new\" value=\"$php_stats_esclusion\">";
$body.="<input type=\"Submit\" value=\"$click_value\">";
$body.="</form>";
$return.=info_box($string['esclude_subtitle'],$body);
return($return);
}
?>