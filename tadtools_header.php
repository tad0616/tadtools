<?php
if(!defined('XOOPS_ROOT_PATH')){
  include_once "../../mainfile.php";
}else{
  include_once XOOPS_ROOT_PATH."/mainfile.php";
}

include_once "common/xoops.php";
if(!defined("TADTOOLS_PATH"))define("TADTOOLS_PATH",XOOPS_ROOT_PATH."/modules/tadtools");
if(!defined("TADTOOLS_URL"))define("TADTOOLS_URL",XOOPS_URL."/modules/tadtools");

global $xoopsConfig;
include_once TADTOOLS_PATH."/language/{$xoopsConfig['language']}/main.php";

//取得TadTools的$XoopsModuleConfig
if(!function_exists('TadToolsXoopsModuleConfig')){
  function TadToolsXoopsModuleConfig(){
    $modhandler = xoops_gethandler('module');
    $xoopsModule = $modhandler->getByDirname("tadtools");
    if(is_object($xoopsModule)){
      $config_handler = xoops_gethandler('config');
      $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

      return $xoopsModuleConfig;
    }

    return false;
  }
}
