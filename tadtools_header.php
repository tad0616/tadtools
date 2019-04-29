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

xoops_loadLanguage('main', 'tadtools');
