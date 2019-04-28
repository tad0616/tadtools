<?php
use XoopsModules\Tadtools\Utility;
// require_once __DIR__ . '/tadtools_header.php';

//取得jquery路徑，$mode="return"
//$theme=ui-lightness , base

if (!function_exists('get_jquery')) {
    function get_jquery($ui = false, $mode = '', $theme = 'base')
    {
        Utility::get_jquery($ui, $mode, $theme);
    }
}
