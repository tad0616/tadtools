<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
require_once __DIR__ . '/tadtools_header.php';

// 關閉除錯訊息
$xoopsLogger->activated = false;

$db_prefix = Request::getString('db_prefix');
$col_name = Request::getString('col_name');
$col_sn = Request::getInt('col_sn');
$fdtr = Request::getArray('fdtr');

$sql = 'UPDATE `' . $xoopsDB->prefix($db_prefix . '_files_center') . '` SET `sort`=`sort` + ? WHERE `col_name` = ? AND `col_sn` = ?';
Utility::query($sql, 'isi', [100, $col_name, $col_sn]) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');

$sort = 1;
foreach ($fdtr as $files_sn) {
    $sql = 'UPDATE `' . $xoopsDB->prefix($db_prefix . '_files_center') . '` SET `sort` = ? WHERE `files_sn` = ?';
    Utility::query($sql, 'ii', [$sort, $files_sn]) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');
    $sort++;
}

echo _TAD_SORTED . ' (' . date('Y-m-d H:i:s') . ')';
