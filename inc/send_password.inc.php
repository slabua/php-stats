<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");
if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else $mode="send";

function send_password() {
global $db,$option,$style,$string,$varie,$modulo,$mode,$key,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['mail_sent_title'];
$return="";
if($mode=="send")
  {
  $user_pass_new=get_random(7);
  $user_pass_key=get_random(30);
  $site=explode("\n",$option['server_url']);
  $site_url=$site[0];
  $activation_link="$option[script_url]/admin.php?action=send_password&mode=activate&key=$user_pass_key";
  eval ("\$mail_messaggio=\"".gettemplate("lang/$option[language]/send_password.tpl")."\";");
  $intestazioni ="From: Php-Stats at $site[0]<$option[user_mail]>\n";
  $intestazioni.="X-Sender: <$option[user_mail]>\n";
  $intestazioni.="X-Mailer: PHP-STATS\n"; // mailer
  $intestazioni.="X-Priority: 1\n"; // Messaggio urgente!
  $intestazioni.="Return-Path: <$option[user_mail]>\n";  // Indirizzo di ritorno per errori
  $ok=@mail($option['user_mail'],$string['mail_subject'],$mail_messaggio,$intestazioni);
  if($ok==False)
    $ok=@mail($option['user_mail'],$string['mail_subject'],$mail_messaggio);
  if($ok!=False)
    {
    // Aggiorno pass e key di attivazione nel database
    sql_query("UPDATE $option[prefix]_config SET value='$user_pass_new' WHERE name='user_pass_new'");
    sql_query("UPDATE $option[prefix]_config SET value='$user_pass_key' WHERE name='user_pass_key'");
    $return.=info_box($string['mail_sent_title'],$string['mail_sent']);
    }
    else
	{
    $body="<img src=\"templates/$option[template]/images/icon_warning.gif\" align=\"middle\"><span class=\"tabletextB\">&nbsp;$string[mail_error]</span>";
	$return.=info_box($string['error'],$body);
	}
  }
if($mode=="activate")
  {
  $key=trim($key);
  if(($key==$option['user_pass_key']) && ($option['user_pass_key']!="") && (strlen($key)==30))
    {
    sql_query("UPDATE $option[prefix]_config SET value='$option[user_pass_new]' WHERE name='admin_pass'");
    $return.=info_box($string[new_pass_activ_title],$string[new_pass_activ]);
    }
    else
    {
	$body="<img src=\"templates/$option[template]/images/icon_warning.gif\" align=\"middle\"><span class=\"tabletextB\">&nbsp;$string[new_pass_error]</span>";
	$return.=info_box($string['error'],$body);
	}
  }
return($return);
}
?>
