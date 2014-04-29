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

// SECURITY ISSUES
if(!defined('IN_PHPSTATS')) die("Php-Stats internal file.");

////////////////////////////////////////////////
// Preparazione varibili HTML per il template //
////////////////////////////////////////////////
$option['nomesito']=stripcslashes($option['nomesito']);
if(isset($option['autorefresh'])) $option['autorefresh']=$option['autorefresh']*60; else $option['autorefresh']=600;
$meta="<META NAME='ROBOTS' CONTENT='NONE'>";
$phpstats_title="Php-Stats $option[phpstats_ver] - $phpstats_title";
if($refresh) 
  $meta.="\n<META HTTP-EQUIV=\"refresh\" CONTENT=\"5;URL=$url\">"; // Refresh pagina breve
  else 
  if(!in_array($trad_action,$norefresh_action)) // Alcune pagine sono escluse dal refresh
	$meta.="\n<META HTTP-EQUIV=\"refresh\" CONTENT=\"$option[autorefresh];URL=".$option['script_url']."/admin.php"."?"."$QUERY_STRING\">";
if($update_msg) $meta.="\n".$update_msg;
$generation_time=str_replace("%TOTALTIME%",round($end_time-$start_time,3),$varie['page_time']);
$server_time=str_replace("%SERVER_TIME%",date($varie['time_format']),$varie['server_time']);

$script="\n";
$script.='/****************************************************'."\n";
$script.='*	(c) Ger Versluis 2000 version simple 4 April 2002 *'."\n";
$script.='*	You may use this script on non commercial sites.  *'."\n";
$script.='*	For info write to menus@burmees.nl		          *'."\n";
$script.='*	You may remove all comments for faster loading	  *'."\n";
$script.='*****************************************************/'."\n";

$menuCounter=2;
if($modulo[1]>0) $menuCounter++; // Sistemi
if(($modulo[5]>0) ||($modulo[6])) $menuCounter++; // Statistiche
if($modulo[4]>0) $menuCounter++; // Motori
if(($modulo[6]) || ($modulo[7]) || ($modulo[8]) || ($modulo[9]) || ($modulo[10]) || ($modulo[2])) $menuCounter++; // Varie

$script.='var NoOffFirstLineMenus='.$menuCounter.';'."\n";
$script.='var LowBgColor="#666699";'."\n";
$script.='var HighBgColor="#8F90B7";'."\n";
$script.='var FontLowColor="white";'."\n";
$script.='var FontHighColor="white";'."\n";
$script.='var BorderColor="black";'."\n";
$script.='var BorderWidth=1;'."\n";
$script.='var BorderBtwnElmnts=1;'."\n";
$script.='var FontFamily="verdana,comic sans ms,technical,arial";	'."\n";
$script.='var FontSize=8;'."\n";
$script.='var FontBold=0;'."\n";
$script.='var FontItalic=0;'."\n";
$script.='var MenuTextCentered="center";'."\n";
$script.='var MenuCentered="center";'."\n";
$script.='var MenuVerticalCentered="top";'."\n";
$script.='var ChildOverlap=0.1;'."\n";
$script.='var ChildVerticalOverlap=0.1;'."\n";
$script.='var StartTop=65;'."\n";
$script.='var StartLeft=0;'."\n";
$script.='var VerCorrect=0;'."\n";
$script.='var HorCorrect=0;'."\n";
$script.='var LeftPaddng=3;'."\n";
$script.='var TopPaddng=2;'."\n";
$script.='var FirstLineHorizontal=1;'."\n";
$script.='var MenuFramesVertical=1;'."\n";
$script.='var DissapearDelay=1000;'."\n";
$script.='var TakeOverBgColor=0.1;'."\n";
$script.='var FirstLineFrame="navig";'."\n";
$script.='var SecLineFrame="space";'."\n";
$script.='var DocTargetFrame="space";'."\n";
$script.='var TargetLoc="";'."\n";
$script.='var UnfoldsOnClick=0;'."\n";
$script.='var BaseHref="";'."\n";
$script.='var Arrws=[BaseHref+"",5,10,BaseHref+"",10,5];'."\n";
$script.='var MenuUsesFrames=0;'."\n";
$script.='var PartOfWindow=.8;'."\n";
$script.='var MenuSlide="";'."\n";
$script.='var MenuSlide="progid:DXImageTransform.Microsoft.GradientWipe(duration=.3, wipeStyle=1)";'."\n";
$script.='var MenuShadow="";'."\n";
$script.='var MenuShadow="progid:DXImageTransform.Microsoft.DropShadow(color=#888888, offX=1, offY=1, positive=1)";'."\n";
$script.='var MenuOpacity="";'."\n";
$script.='var MenuOpacity="progid:DXImageTransform.Microsoft.Alpha(opacity=90)";'."";
$script.='function BeforeStart(){return}'."\n";
$script.='function AfterBuild(){return}'."\n";
$script.='function BeforeFirstOpen(){return}'."\n";
$script.='function AfterCloseAll(){return}'."\n";

//////////////
// Generale //
//////////////
$menuCounter=1;
if($modulo[3]>0) $menuCounter=$menuCounter+3;
if($modulo[4]>0) $menuCounter++;
if($modulo[0]) $menuCounter++;

$menuIndex=1;
$menuChild=1;
$script.='Menu'.$menuChild.'=new Array("'.$admin_menu['menu_general'].'","","",'.$menuCounter.',20,120);'."\n";
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['main'].'","admin.php?action=main","",0,20,120);'."\n";
$menuIndex++;
if($modulo[3]>0) 
  {
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['pages'].'","admin.php?action=pages","",0,20,120);'."\n";
  $menuIndex++;
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['time_pages'].'","admin.php?action=time_pages","",0,20,120);'."\n";
  $menuIndex++;
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['percorsi'].'","admin.php?action=percorsi","",0,20,120);'."\n";
  $menuIndex++;
  }
if($modulo[4]>0)
  {
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['referer'].'","admin.php?action=referer","",0,20,120);'."\n";
  $menuIndex++;
  }
if($modulo[0]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['details'].'","admin.php?action=details","",0,20,120);'."\n"; $menuIndex++;}
$script.=''."\n";

/////////////
// Sistemi //
/////////////
if($modulo[1]>0) 
  {
  $menuCounter=3;
  $menuChild++;
  $menuIndex=1;
  $script.='Menu'.$menuChild.'=new Array("'.$admin_menu['menu_sistems'].'","","",'.$menuCounter.',20,120);'."\n";
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['os_browser'].'","admin.php?action=os_browser","",0,20,120);'."\n";
  $menuIndex++;
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['reso'].'","admin.php?action=reso","",0,20,120);'."\n";
  $menuIndex++;
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['systems'].'","admin.php?action=systems","",0,20,120);'."\n";
  $menuIndex++;
  $script.=''."\n";
  }

///////////////////////
// Motori Di Ricerca //
///////////////////////
if($modulo[4]>0)
  {
  $menuCounter=3;
  $menuChild++;
  $menuIndex=1;
  $script.='Menu'.$menuChild.'=new Array("'.$admin_menu['menu_engines'].'","","",'.$menuCounter.',20,120);'."\n";
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['engines'].'","admin.php?action=engines","",0,20,120);'."\n";
  $menuIndex++;
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['query'].'","admin.php?action=query","",0,20,120);'."\n";
  $menuIndex++;
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['searched_words'].'","admin.php?action=searched_words","",0,20,120);'."\n";
  $menuIndex++;
  }


/////////////////
// Statistiche //
/////////////////
$menuCounter=0;
if($modulo[5]>0) $menuCounter++;
if($modulo[6]) $menuCounter=$menuCounter+5;
if(($modulo[5]>0) or ($modulo[6])) {
$menuIndex=1;
$menuChild++;

$script.='Menu'.$menuChild.'=new Array("'.$admin_menu['menu_stats'].'","","",'.$menuCounter.',20,120);'."\n";
if($modulo[5]>0) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['hourly'].'","admin.php?action=hourly","",0,20,120);'."\n";
$menuIndex++;}
  if($modulo[6]) {
					$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['daily'].'","admin.php?action=daily","",0,20,120);'."\n";
					$menuIndex++;
					$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['weekly'].'","admin.php?action=weekly","",0,20,120);'."\n";
					$menuIndex++;
					$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['monthly'].'","admin.php?action=monthly","",0,20,120);'."\n";
					$menuIndex++;
					$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['compare'].'","admin.php?action=compare","",0,20,120);'."\n";
					$menuIndex++;
					$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['calendar'].'","admin.php?action=calendar","",0,20,120);'."\n";
					$menuIndex++;
  }
}


///////////
// Varie //
///////////
$menuCounter=0;

if($modulo[7]) $menuCounter++;
if($modulo[8]) $menuCounter++;
if($modulo[9]) $menuCounter++;
if($modulo[10]) $menuCounter++;
if($modulo[6]) $menuCounter++;
if($modulo[2]) $menuCounter++;

if(($modulo[10]) or  ($modulo[9]) or ($modulo[7]) or ($modulo[8]) or ($modulo[6]) or ($modulo[2]))
  {
  $menuChild=$menuChild + 1;
  $menuIndex=1;
  $script.='Menu'.$menuChild.'=new Array("'.$admin_menu['menu_others'].'","","",'.$menuCounter.',20,120);'."\n";
  if($modulo[10]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['ip'].'","admin.php?action=ip","",0,20,120);'."\n";
  $menuIndex++;}
  if($modulo[7]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['country'].'","admin.php?action=country","",0,20,120);'."\n";
  $menuIndex++;}
  if($modulo[2]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['lang'].'","admin.php?action=bw_lang","",0,20,120);'."\n";
  $menuIndex++;}
  if($modulo[8]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['downloads'].'","admin.php?action=downloads","",0,20,120);'."\n";
  $menuIndex++;}
  if($modulo[9]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['clicks'].'","admin.php?action=clicks","",0,20,120);'."\n";
  $menuIndex++;}
  if($modulo[6]) {$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['trend'].'","admin.php?action=trend","",0,20,120);'."\n";
    $menuIndex++;}

  $script.=''."\n";
  }

/////////////
// OPTIONS //
/////////////

$menuChild=$menuChild+1;
$menuIndex=1;

$menuCounter=6;

if($modulo[8]) $menuCounter++;
if($modulo[9]) $menuCounter++;
if($option['logerrors']) $menuCounter++;

$script.='Menu'.$menuChild.'=new Array("'.$admin_menu['menu_options'].'","","",'.$menuCounter.',20,120);'."\n";
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['options'].'","admin.php?action=preferenze","",0,20,120);'."\n";
$menuIndex++;
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['esclusioni'].'","admin.php?action=esclusioni","",0,20,120);'."\n";
$menuIndex++;
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['optimize_tables'].'","admin.php?action=optimize_tables","",0,20,120);'."\n";
$menuIndex++;
if($modulo[8])
  {
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['downadmin'].'","admin.php?action=downadmin","",0,20,120);'."\n";
  $menuIndex++;
  }
if($modulo[9])
  {
  $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['clicksadmin'].'","admin.php?action=clicksadmin","",0,20,120);'."\n";
  $menuIndex++;
  }
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['backup'].'","admin.php?action=backup","",0,20,120);'."\n";
$menuIndex++;
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['reset'].'","admin.php?action=resett","",0,20,120);'."\n";
$menuIndex++;
if($option['logerrors'])
   {
   $script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['errorlogviewer'].'","admin.php?action=viewerrorlog","",0,20,120);'."\n";
   $menuIndex++;
   }
$script.='	Menu'.$menuChild.'_'.$menuIndex.'=new Array("'.$admin_menu['status'].'","admin.php?action='.$admin_menu['status_rev'].'","",0,20,120);'."\n";
$script.="\n";

//END OPTIONS
$menu_script=$script;

//////////////////////////////////
// Generazione HTML da template //
//////////////////////////////////
eval("\$template=\"".gettemplate("$template_path/admin.tpl")."\";");
?>
