<?php
include_once "../../../../mainfile.php";
if (isAdmin()) {
    $v = (int)$_GET['v'];
    set_debug($v);
    header("location:" . $_SERVER["HTTP_REFERER"]);
}

//設定除錯模式
function set_debug($v = 1)
{
    global $xoopsDB;
    $sql = "update  " . $xoopsDB->prefix("config") . " set conf_value='$v' where conf_title ='_MD_AM_DEBUGMODE'";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
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
