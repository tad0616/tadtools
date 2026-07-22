<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
require_once __DIR__ . '/tadtools_header.php';
if (!$xoopsUser) {
    http_response_code(401);
    exit;
}

// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;

// 僅允許登入者執行排序操作
if (empty($xoopsUser)) {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

$db_prefix = Request::getString('db_prefix');
$col_name  = Request::getString('col_name');
$col_sn    = Request::getInt('col_sn');
$fdtr      = Request::getArray('fdtr');

// 僅允許安全的 db_prefix（小寫英數與底線），避免注入資料表名稱
$db_prefix = Utility::check_string(strtolower($db_prefix));
$col_name  = Utility::check_string($col_name);

// 組出完整資料表名稱並確認存在
$filesTable = $xoopsDB->prefix($db_prefix . '_files_center');
$checkSql   = "SELECT 1 FROM `{$filesTable}` LIMIT 1";
if ($xoopsDB->queryF($checkSql) === false) {
    http_response_code(400);
    echo 'Invalid table';
    exit;
}

$sql = 'UPDATE `' . $filesTable . '` SET `sort`=`sort` + ? WHERE `col_name` = ? AND `col_sn` = ?';
Utility::query($sql, 'isi', [100, $col_name, $col_sn]) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');

$sort = 1;
foreach ($fdtr as $files_sn) {
    $sql = 'UPDATE `' . $filesTable . '` SET `sort` = ? WHERE `files_sn` = ?';
    Utility::query($sql, 'ii', [$sort, $files_sn]) or die(_TAD_SORT_FAIL . ' (' . $sql . ')');
    $sort++;
}

echo _TAD_SORTED . ' (' . date('Y-m-d H:i:s') . ')';
