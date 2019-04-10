<?php
function xoops_module_install_tadtools(&$module)
{

    tadtools_mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools");
    tadtools_mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools/file");
    tadtools_mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools/image");
    tadtools_mk_dir(XOOPS_ROOT_PATH . "/uploads/tadtools/image/.thumbs");

    return true;
}

//建立目錄
function tadtools_mk_dir($dir = "")
{
    //若無目錄名稱秀出警告訊息
    if (empty($dir)) {
        return;
    }

    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}
