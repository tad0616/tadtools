<?php
use Xmf\Request;

require_once __DIR__ . '/tadtools_header.php';

$tbl_name = Request::getString('tbl_name');
$col_name = Request::getString('col_name');
$col_sn = Request::getInt('col_sn');
$fdtr = Request::getArray('fdtr');

$sql = 'UPDATE `' . $tbl_name . '` SET `sort`=`sort` + ? WHERE `col_name` = ? AND `col_sn` = ?';
Utility::query($sql, 'isi', [100, $col_name, $col_sn]) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');

$sort = 1;
foreach ($fdtr as $files_sn) {
    $sql = 'UPDATE `' . $tbl_name . '` SET `sort` = ? WHERE `files_sn` = ?';
    Utility::query($sql, 'ii', [$sort, $files_sn]) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');
    $sort++;
}

echo _TAD_SORTED . ' (' . date('Y-m-d H:i:s') . ')';
