<?php
use XoopsModules\Tadtools\Utility;
include_once '../../../../mainfile.php';
if (isAdmin()) {
    $v = (int) $_GET['v'];
    set_debug($v);
    header('location:' . $_SERVER['HTTP_REFERER']);
}

//設定除錯模式
function set_debug($v = 1)
{
    global $xoopsDB;
    $sql = 'UPDATE `' . $xoopsDB->prefix('config') . '` SET `conf_value`=? WHERE `conf_title`=?';
    Utility::query($sql, 'is', [$v, '_MD_AM_DEBUGMODE']);
}

//判斷是否為管理員
function isAdmin()
{
    global $xoopsUser, $xoopsModule;
    $isAdmin = false;
    if ($xoopsUser) {
        $isAdmin = $xoopsUser->isAdmin(1);
    }

    return $isAdmin;
}
