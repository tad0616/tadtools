<?php
//此檔案是給 ck.php 用的，勿刪
include_once "../../mainfile.php";
include_once "upload/class.upload.php";

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$type            = system_CleanVars($_REQUEST, 'type', '', 'string');
$CKEditorFuncNum = system_CleanVars($_REQUEST, 'CKEditorFuncNum', '', 'sn');

$mdir     = $_SESSION['xoops_mod_name'];
$path     = XOOPS_ROOT_PATH . "/uploads/{$mdir}/{$type}/";
$url      = XOOPS_URL . "/uploads/{$mdir}/{$type}/";
$type_arr = array('image', 'file', 'flash');

//判斷是否是非法調用
if (empty($_CKEditorFuncNum)) {
    mkhtml(1, "", "error");
}

$fn = $_CKEditorFuncNum;

if (!in_array($type, $type_arr)) {
    mkhtml(1, "", "error");
}

$foo = new Upload($_FILES['upload']);
if ($foo->uploaded) {
    // save uploaded image with no changes
    $foo->Process($path);
    if ($foo->processed) {
        // die($foo->file_dst_name);
        chmod($path . $_FILES['upload']['name'], 0777);
        $msg = $url . $_FILES['upload']['name'];
        mkhtml($fn, $msg);
    } else {
        $msg = 'error : ' . $foo->error;
        mkhtml($fn, "", $msg);
    }
}

function mkhtml($fn, $fileurl, $message)
{
    $str = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $fn . ', \'' . $fileurl . '\', \'' . $message . '\');</script>';
    exit($str);
}
