<?php
class TadtoolsCorePreload extends XoopsPreloadItem{

  function eventCoreHeaderStart($args) {
    global $xoopsConfig,$xoopsDB,$xoTheme,$xoopsTpl,$xoopsUser;


    $theme_set=$xoopsConfig['theme_set'];

    $_SESSION['now_theme_set']=$theme_set;


    if(!isset($_SESSION['old_theme_set'])){
      $_SESSION['old_theme_set']=$theme_set;
    }

    if(!isset($_SESSION['bootstrap']) or ($_SESSION['old_theme_set']!=$theme_set)){
      $_SESSION['old_theme_set']=$theme_set;
      $sql="select `tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` from `".$xoopsDB->prefix("tadtools_setup")."`  where `tt_theme`='{$theme_set}'";
      $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
      list($tt_use_bootstrap,$tt_bootstrap_color,$tt_theme_kind)=$xoopsDB->fetchRow($result);

      $_SESSION['theme_kind']=$tt_theme_kind;
      if(strpos($tt_bootstrap_color, 'bootstrap3')!==false){
        $_SESSION[$theme_set]['bootstrap_version']='bootstrap3';
        $_SESSION['bootstrap']='3';
      }else{
        $_SESSION[$theme_set]['bootstrap_version']='bootstrap';
        $_SESSION['bootstrap']='2';
      }

      if($xoopsTpl){
        $xoopsTpl->assign( "bootstrap_version" , $_SESSION['bootstrap']) ;
      }

      if($xoTheme and $tt_use_bootstrap){
        if($tt_bootstrap_color=="bootstrap3"){
          $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap3/css/bootstrap.css');
        }elseif($tt_bootstrap_color=="bootstrap"){
          $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap.css');
          $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap-responsive.css');
        }else{
          $c=explode('/',$tt_bootstrap_color);
          if($c[0]=="bootstrap3"){
            $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/'.$tt_bootstrap_color.'/bootstrap.min.css');
          }elseif($c[0]=="bootstrap"){
            $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap.css');
            $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/bootstrap/css/bootstrap-responsive.css');
            $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/'.$tt_bootstrap_color.'/bootstrap.min.css');
          }

        }
        $xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/css/fix-bootstrap.css');
      }
    }

  }


}
