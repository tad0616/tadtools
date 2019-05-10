<?php

use XoopsModules\Tadtools\Utility;

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

function xoops_module_install_tadtools(&$module)
{
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/file');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/image');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tadtools/image/.thumbs');

    return true;
}
