<?php
if (!defined('XOOPS_ROOT_PATH')) {
    include_once '../../mainfile.php';
} else {
    include_once XOOPS_ROOT_PATH . '/mainfile.php';
}

if (!defined('TADTOOLS_PATH')) {
    define('TADTOOLS_PATH', XOOPS_ROOT_PATH . '/modules/tadtools');
}

if (!defined('TADTOOLS_URL')) {
    define('TADTOOLS_URL', XOOPS_URL . '/modules/tadtools');
}

global $xoopsConfig;
include_once TADTOOLS_PATH . "/language/{$xoopsConfig['language']}/main.php";
