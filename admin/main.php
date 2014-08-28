<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2010-11-16
// $Id: $
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include "../../../include/cp_header.php";
include_once "../tad_function.php";
$xoopsOption['template_main'] = "tadtools_adm_index_tpl.html";
xoops_cp_header();

/*-----------function區--------------*/
function tadtools_setup(){
  global $xoopsModule,$xoopsConfig,$xoopsTpl,$xoopsDB;

  $use_bootstrap=$bootstrap_color="";

  $sql="select * from `".$xoopsDB->prefix("tadtools_setup")."`";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  //$tt_theme,$tt_use_bootstrap,$tt_bootstrap_color
  while(list($tt_sn,$tt_theme,$tt_use_bootstrap,$tt_bootstrap_color)=$xoopsDB->fetchRow($result)){
    $use_bootstrap[$tt_theme]=$tt_use_bootstrap;
    $bootstrap_color[$tt_theme]=$tt_bootstrap_color;
  }

  $version=_MA_TT_VERSION.$xoopsModule->getVar("version");

  $i=0;
  $themes="";
  foreach($xoopsConfig['theme_set_allowed'] as $theme){
    $color=$xoopsConfig['theme_set']==$theme?"style='background-color:#990000'":"";

    $themes[$i]['color']=$color;
    $themes[$i]['theme_name']=$theme;

    if(file_exists(XOOPS_ROOT_PATH."/themes/{$theme}/config.php")){
      $sql = "INSERT INTO `".$xoopsDB->prefix("tadtools_setup")."` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color`) values('{$theme}', '0', 'bootstrap' ) ON DUPLICATE KEY UPDATE `tt_use_bootstrap` = '0',`tt_bootstrap_color`='bootstrap'";

      $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

      $themes[$i]['use_bootstrap']='0';
      $themes[$i]['bootstrap_color']=$bootstrap_color[$theme];
      $themes[$i]['tad_theme']='1';
    }else{
      $themes[$i]['use_bootstrap']=$use_bootstrap[$theme]===""?1:$use_bootstrap[$theme];
      $themes[$i]['bootstrap_color']=$bootstrap_color[$theme];
      $themes[$i]['tad_theme']='0';
    }


    $i++;
  }

  $xoopsTpl->assign( "themes" , $themes) ;
  $xoopsTpl->assign( "version" , $version) ;
}



function save(){
  global $xoopsDB;
  foreach($_POST['tt_use_bootstrap'] as $tt_theme=>$tt_use_bootstrap){
    $sql = "INSERT INTO `".$xoopsDB->prefix("tadtools_setup")."` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color`) values('{$tt_theme}', '{$tt_use_bootstrap}', '{$_POST['tt_bootstrap_color'][$tt_theme]}' ) ON DUPLICATE KEY UPDATE `tt_use_bootstrap` = '{$tt_use_bootstrap}',`tt_bootstrap_color`='{$_POST['tt_bootstrap_color'][$tt_theme]}'";
//die($sql);
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  }
}
/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];

switch($op){

  case "save":
  save();
  header("location:{$_SERVER['PHP_SELF']}");
	break;


	default:
	tadtools_setup();
	break;
}


/*-----------秀出結果區--------------*/
admin_toolbar(0);

xoops_cp_footer();

?>
