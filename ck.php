<?php
require_once __DIR__ . '/tadtools_header.php';

class CKEditor extends \XoopsModules\Tadtools\CkEditor
{
}

/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/ck.php")){
redirect_header("http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/ck.php";
$fck=new CKEditor("tadnews","news_content",$news_content);
$fck->setHeight(350);
$editor=$fck->render();
 */
