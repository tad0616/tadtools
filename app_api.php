<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

require_once __DIR__ . '/tadtools_header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');

header("Content-Type: application/json; charset=utf-8");
switch ($op) {

    case 'web_info':
        die(json_encode(web_info(), 256));

    case 'web_modules':
        die(json_encode(web_modules(), 256));
}

//網站基本資料
function web_info()
{
    global $xoopsConfig, $xoopsDB;

    $web['sitename'] = $xoopsConfig['sitename'];
    $web['slogan'] = $xoopsConfig['slogan'];
    $web['adminmail'] = $xoopsConfig['adminmail'];

    $sql = 'SELECT `conf_value` FROM ' . $xoopsDB->prefix('config') . " WHERE conf_name='meta_description'";
    $result = $xoopsDB->query($sql);
    list($meta_description) = $xoopsDB->fetchRow($result);
    $web['meta_description'] = $meta_description;

    $sql = 'SELECT `file_name`, `sub_dir` FROM ' . $xoopsDB->prefix('tad_themes_files_center') . " WHERE `col_name` = 'slide' and `col_sn`!=0 and sub_dir like '/{$xoopsConfig['theme_set']}%' ORDER BY `sort`";
    $result = $xoopsDB->query($sql);
    while (list($file_name, $sub_dir) = $xoopsDB->fetchRow($result)) {
        $web['slide'][] = XOOPS_URL . '/uploads/tad_themes' . $sub_dir . '/' . $file_name;
    }

    return $web;
}

//網站有使用的模組
function web_modules()
{
    global $xoopsConfig, $xoopsDB;

    $sql = 'SELECT `name`,`dirname` FROM ' . $xoopsDB->prefix('modules') . " WHERE `isactive`='1' order by `weight`";
    $result = $xoopsDB->query($sql) or die($sql);
    while ($mod = $xoopsDB->fetchArray($result)) {
        $modules[] = $mod;
    }

    return $modules;
}
