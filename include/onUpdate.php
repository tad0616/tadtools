<?php

use XoopsModules\Tadtools\Utility;

function xoops_module_update_tadtools(&$module, $old_version)
{
    global $xoopsDB;

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/file');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/image');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/image/.thumbs');

    if (!Utility::chk_chk1()) {
        Utility::go_update1();
    }

    if (!Utility::chk_chk2()) {
        Utility::go_update2();
    }

    if (Utility::chk_chk3()) {
        Utility::go_update3();
    }

    if (Utility::chk_chk4()) {
        Utility::go_update4();
    }

    if (Utility::chk_chk5()) {
        Utility::go_update5();
    }

    Utility::go_update6();

    if (Utility::chk_chk7()) {
        Utility::go_update7();
    }

    if (Utility::chk_chk8()) {
        Utility::go_update8();
    }

    /*

    $old_fckeditor=XOOPS_ROOT_PATH."/modules/tadtools/fckeditor";
    if(is_dir($old_fckeditor)){
    Utility::delete_directory($old_fckeditor);
    }
     */
    Utility::chk_tadtools_block();

    return true;
}
