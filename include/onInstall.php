<?php

use XoopsModules\Tadtools\Utility;

include dirname(__DIR__) . '/preloads/autoloader.php';

function xoops_module_install_tadtools(&$module)
{

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools/file");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools/image");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools/image/.thumbs");

    return true;
}
