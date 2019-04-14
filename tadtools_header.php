<?php
if (!defined('XOOPS_ROOT_PATH')) {
    require_once dirname(dirname(__DIR__)) . '/mainfile.php';
} else {
    require_once XOOPS_ROOT_PATH . '/mainfile.php';
}

if (!defined('TADTOOLS_PATH')) {
    define('TADTOOLS_PATH', XOOPS_ROOT_PATH . '/modules/tadtools');
}

if (!defined('TADTOOLS_URL')) {
    define('TADTOOLS_URL', XOOPS_URL . '/modules/tadtools');
}

global $xoopsConfig;
require_once TADTOOLS_PATH . "/language/{$xoopsConfig['language']}/main.php";

//取得TadTools的$XoopsModuleConfig
if (!function_exists('TadToolsXoopsModuleConfig')) {
    function TadToolsXoopsModuleConfig()
    {
        $moduleHandler = xoops_getHandler('module');
        $xoopsModule = $moduleHandler->getByDirname('tadtools');
        if (is_object($xoopsModule)) {
            $configHandler = xoops_getHandler('config');
            $xoopsModuleConfig = $configHandler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

            return $xoopsModuleConfig;
        }

        return false;
    }
}
