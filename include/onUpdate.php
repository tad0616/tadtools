<?php

use XoopsModules\Tadtools\Update;
use XoopsModules\Tadtools\Utility;

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tadtools\Update')) {
    include dirname(__DIR__) . '/preloads/autoloader.php';
}

function xoops_module_update_tadtools(&$module, $old_version)
{
    global $xoopsDB;

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/file');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/image');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/image/.thumbs');

    if (!Update::chk_chk1()) {
        Update::go_update1();
    }

    if (!Update::chk_chk2()) {
        Update::go_update2();
    }

    if (Update::chk_chk3()) {
        Update::go_update3();
    }

    if (Update::chk_chk4()) {
        Update::go_update4();
    }

    if (Update::chk_chk5()) {
        Update::go_update5();
    }

    Update::go_update6();

    if (Update::chk_chk7()) {
        Update::go_update7();
    }

    if (Update::chk_chk8()) {
        Update::go_update8();
    }

    Update::chk_tadtools_block();

    return true;
}
