<?php
use Xmf\Request;

require_once __DIR__ . '/tadtools_header.php';

$tbl_name = Request::getString('tbl_name');
$col_name = Request::getString('col_name');
$col_sn = Request::getInt('col_sn');
$fdtr = Request::getArray('fdtr');

$sql = 'update `' . $tbl_name . "` set `sort`=`sort`+100 where `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";
$xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');

$sort = 1;
foreach ($fdtr as $files_sn) {
    $sql = 'update `' . $tbl_name . "` set `sort`='{$sort}' where `files_sn`='{$files_sn}'";
    $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');
    $sort++;
}

echo _TAD_SORTED . ' (' . date('Y-m-d H:i:s') . ')';
