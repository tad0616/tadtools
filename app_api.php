<?php
use Xmf\Request;

require_once __DIR__ . '/tadtools_header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');

// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;
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

    $sql = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . '` WHERE `conf_name`=?';
    $result = Utility::query($sql, 's', ['meta_description']);

    list($meta_description) = $xoopsDB->fetchRow($result);
    $web['meta_description'] = $meta_description;

    $sql = 'SELECT `file_name`, `sub_dir` FROM `' . $xoopsDB->prefix('tad_themes_files_center') . '` WHERE `col_name` = ? AND `col_sn` != ? AND sub_dir LIKE ? ORDER BY `sort`';
    $result = Utility::query($sql, 'sis', ['slide', 0, '/' . $xoopsConfig['theme_set'] . '%']);

    while (list($file_name, $sub_dir) = $xoopsDB->fetchRow($result)) {
        $web['slide'][] = XOOPS_URL . '/uploads/tad_themes' . $sub_dir . '/' . $file_name;
    }

    return $web;
}

//網站有使用的模組
function web_modules()
{
    global $xoopsConfig, $xoopsDB;

    $sql = 'SELECT `name`, `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive` = ? ORDER BY `weight`';
    $result = Utility::query($sql, 's', [1]) or die($sql);
    while ($mod = $xoopsDB->fetchArray($result)) {
        $modules[] = $mod;
    }

    return $modules;
}
