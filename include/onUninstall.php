<?php

use XoopsModules\Tadtools\Utility;

function xoops_module_uninstall_tadtools(&$module)
{
    global $xoopsDB;

    $date = date("Ymd");

    rename(XOOPS_ROOT_PATH . "/uploads/tadtools", XOOPS_ROOT_PATH . "/uploads/tadtools_bak_{$date}");

    return true;
}
