<?php
// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

if(isset($_GET['start'])) $start=addslashes($_GET['start']); else $start=0;
 if(isset($_GET['mode'])) $mode=addslashes($_GET['mode']); else $mode="?";
   if(isset($_GET['id'])) $id=addslashes($_GET['id']); else $id="?";

function downadmin() {
global $mode,$id,$string,$error,$style,$pref,$varie,$option,$refresh,$url,$start,$phpstats_title;
// Titolo pagina (riportata anche nell'admin)
$phpstats_title=$string['down_admin_title'];
$return="";
switch ($mode) {
  case 'edit':
    $result=sql_query("SELECT * FROM $option[prefix]_downloads WHERE id='$id'");
    if(mysql_affected_rows()<1)
      {
      $return.=info_box($string['error'],$error['down_noid']);
      }
      else
      {
      list($id,$nome,$url,$data,$downloads)=@mysql_fetch_array($result);
      $title=str_replace("%id%",$id,$string['down_title_edit']);
      $return.="<br><br><form action=\"admin.php?action=downadmin&mode=apply&id=$id\" method=\"post\">";
      $return.="<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
      $return.="<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\">$title</span></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor]><center><span class=\"tabletextA\">$string[down_name]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option[down_name]\" value=\"$nome\" size=\"30\" maxlength=\"50\"></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor]><center><span class=\"tabletextA\">$string[down_url]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option[down_url]\" value=\"$url\" size=\"80\" maxlength=\"255\"></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"2\"><center><br><input type=\"Submit\" value=\"$string[down_salva]\"></center><br></td></tr>";
      $return.="</form></table>";
      }
  break;

  case 'delete':
    if($id!="")
      {
      sql_query("DELETE FROM $option[prefix]_downloads WHERE id='$id'");
      if(mysql_affected_rows()>0)
        {
        $return.=info_box($string['information'],$string['down_delete_ok']);
        $refresh=1;
        $url="$option[script_url]/admin.php?action=downadmin";
        }
        else
        {
        $tmp=str_replace("%id%",$id,$error['down_no_delete']);
        $return.=info_box($string['error'],$tmp);
        }
      }
      else
      {
      $return.="<br><br><center>$error[down_noid]</center><br><br>";
      }
  break;

  case 'new':
    $flag=1;
    if($option['down_url']=="") { $errore=$error['down_url']; $flag=0; }
    if($flag==1)
      {
      $data=time();
      $result=sql_query("INSERT INTO $option[prefix]_downloads VALUES('','$option[down_name]','$option[down_url]','$data','0')");
      if(mysql_affected_rows()>0)
        {
        $last_id=mysql_insert_id();
        $result=sql_query("SELECT * FROM $option[prefix]_downloads WHERE id='$last_id'");
        list($id,$nome,$url,$data,$downloads)=@mysql_fetch_array($result);
        $js_confirm_msg=str_replace("%id%","$id",$string['click_js_confirm']);
        $return.=info_box($string['information'],$string['down_new_ok'],"90%");
        $return.="<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
        $return.="<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\">$string[down_title_summary]</span></td></tr>";
        $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\" width=\"150\"><span class=\"tabletextA\">$string[down_id]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$id</span></td></tr>";
        $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_name]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$nome</span></td></tr>";
        $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_url]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$url</span></td></tr>";
        $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_status]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]>".checkfile($url)."</td></tr>";
        $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_date]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"testo\">".formatdate($data)." - ".formattime($data)."</td></tr>";
        $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\" colspan=\"2\"><span class=\"testo\"><a href=\"$option[script_url]/admin.php?action=downadmin&mode=edit&id=$id\">$string[down_edit]</a>&nbsp&nbsp<a href=\"$option[script_url]/admin.php?action=downadmin&mode=delete&id=$id\" onclick=\"return confirmLink(this,'$js_confirm_msg')\">$string[down_del]</a>&nbsp</span></td></tr>";
        $return.="</table>";
        }
        else
        $return.=info_box($string['error'],$error['down_no_update']);
      }
      else
      {
      $errore.="<br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
      $return.=info_box($string['error'],$errore);
      }
  break;

  case 'apply':
  $flag=1;
  if($option['down_url']=="") { $errore=$error['down_url']; $flag=0; }
  if($flag==1)
    {
    $result=sql_query("UPDATE $option[prefix]_downloads SET nome='$option[down_name]', url='$option[down_url]' WHERE id='$id'");
    if(mysql_affected_rows()>0)
      {
      $result=sql_query("SELECT * FROM $option[prefix]_downloads WHERE id='$id'");
      list($id,$nome,$url,$data,$downloads)=@mysql_fetch_array($result);
      $js_confirm_msg=str_replace("%id%","$id",$string['click_js_confirm']);
      $return.=info_box($string['information'],$string['down_edit_ok'],"90%");
      $return.="<br><br><table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
      $return.="<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\">$string[down_title_summary]</span></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\" width=\"150\"><span class=\"tabletextA\">$string[down_id]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$id</span></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_name]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$nome</span></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_url]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$url</span></td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_status]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]>".checkfile($url)."</td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\"><span class=\"tabletextA\">$string[down_date]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><span class=\"testo\">".formatdate($data)." - ".formattime($data)."</td></tr>";
      $return.="<tr><td bgcolor=$style[table_bgcolor] align=\"right\" colspan=\"2\"><span class=\"testo\"><a href=\"$option[script_url]/admin.php?action=downadmin&mode=edit&id=$id\">$string[down_edit]</a>&nbsp&nbsp<a href=\"$option[script_url]/admin.php?action=downadmin&mode=delete&id=$id\" onclick=\"return confirmLink(this,'$js_confirm_msg')\">$string[down_del]</a>&nbsp</span></td></tr>";
      $return.="</table>";
      }
      else
      $return.=info_box($string['warning'],$error['down_no_update']);
    }
    else
    {
      $errore.="<br><br><a href=\"javascript:history.back();\"><-- $pref[back]</a>";
      $return.=info_box($string['error'],$errore);
    }
  break;

  default:
    $rec_pag=10; // risultati visualizzayi per pagina
    $max_hits=0;
    $query_tot=sql_query("SELECT id FROM $option[prefix]_downloads");
    $num_totale=@mysql_numrows($query_tot);
    $numero_pagine=ceil($num_totale/$rec_pag);
    $pagina_corrente= ceil(($start/$rec_pag)+1);
    $total_hits=0;
	while($row=@mysql_fetch_array($query_tot))
      {
      if($row[0]>$max_hits) $max_hits=$row[0];
      $total_hits+=$row[0];
      }
    $result=sql_query("SELECT * FROM $option[prefix]_downloads ORDER BY id ASC LIMIT $start,$rec_pag");
    if(mysql_affected_rows()>0)
      {
      $return.="<span class=\"pagetitle\">$phpstats_title<br></span>";
      if($numero_pagine>1)
        {
        $tmp=str_replace("%current%",$pagina_corrente,$varie['pag_x_y']);
        $tmp=str_replace("%total%",$numero_pagine,$tmp);
        $return.="<div align=\"right\"><span class=\"testo\">$tmp&nbsp;&nbsp;</span></div>";
        }
      $return.="<br><table border=\"0\" $style[table_header] width=\"100%\">";
      $return.="<tr><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_id]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_name]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap><span class=\"tabletitle\"><center>$string[down_elenco_url]</center></span></td><td bgcolor=$style[table_title_bgcolor] nowrap></td><td bgcolor=$style[table_title_bgcolor] nowrap></td></tr>";
      while($row=@mysql_fetch_array($result))
        {
        $js_confirm_msg=str_replace("%id%","$row[0]",$string['down_js_confirm']);
        $return.="<tr bgcolor=\"#B3C0D7\" onmouseover=\"setPointer(this, '$style[table_hitlight]', '$style[table_bgcolor]')\" onmouseout=\"setPointer(this, '$style[table_bgcolor]', '$style[table_bgcolor]')\">";
        $return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[0]</span></td>";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">$row[1]</span></td>";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\">".formaturl($row[2], "", 55, 22, -25)."</span></td>";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><a href=\"$option[script_url]/admin.php?action=downadmin&mode=edit&id=$row[0]\">$string[down_edit]</a></span></td>";
		$return.="<td bgcolor=$style[table_bgcolor]><span class=\"tabletextA\"><a href=\"$option[script_url]/admin.php?action=downadmin&mode=delete&id=$row[0]\" onclick=\"return confirmLink(this,'$js_confirm_msg')\">$string[down_del]</a></span></td>";
		$return.="</tr>";
		}
	  $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";	
      if($numero_pagine>1)
        {
        $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"6\" height=\"20\" nowrap>".pag_bar("admin.php?action=downadmin",$pagina_corrente,$numero_pagine,$rec_pag)."</td></tr>";
        $return.="<tr><td height=\"1\" bgcolor=$style[table_title_bgcolor] colspan=\"6\" nowrap></td></tr>";
        }
      $return.="</table>";
      }
    $return.="<br><br><form action=\"admin.php?action=downadmin&mode=new\" method=\"post\">";
    $return.="<table border=\"0\" $style[table_header] width=\"90%\" align=\"center\" >";
    $return.="<tr><td bgcolor=$style[table_title_bgcolor] colspan=\"2\"><span class=\"tabletitle\">$string[down_title_new]</span></td></tr>";
    $return.="<tr><td bgcolor=$style[table_bgcolor]><center><span class=\"tabletextA\">$string[down_name]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option[down_name]\" value=\"\" size=\"30\" maxlength=\"50\"></td></tr>";
    $return.="<tr><td bgcolor=$style[table_bgcolor]><center><span class=\"tabletextA\">$string[down_url]</span>&nbsp</td><td bgcolor=$style[table_bgcolor]><input type=\"text\" name=\"option[down_url]\" value=\"\" size=\"80\" maxlength=\"255\"></td></tr>";
    $return.="<tr><td bgcolor=$style[table_bgcolor] colspan=\"2\"><center><input type=\"Submit\" value=\"$string[down_salva]\"></center></td></tr>";
    $return.="</form></table>";
  break;
}
return($return);
}
?>