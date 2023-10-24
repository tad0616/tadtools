<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

use Xmf\Request;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;

require_once __DIR__ . '/tadtools_header.php';

$op = Request::getString('op');
$mod_name = Request::getString('mod_name');
$table = Request::getString('table');
$sort_col = Request::getString('sort_col');
$primary_key = Request::getString('primary_key');
$files_sn = Request::getInt('files_sn');
$sort_arr = Request::getArray('sort_arr');
$db_prefix = Request::getString('db_prefix');
header('HTTP/1.1 200 OK');

switch ($op) {
    case 'remove_file':
        $TadUpFiles = new TadUpFiles($mod_name);
        $TadUpFiles->set_db_prefix($db_prefix);
        if ($TadUpFiles->del_files($files_sn)) {
            echo '1';
        }
        exit;

    case 'save_sort':
        save_sort($table, $sort_col, $primary_key, $sort_arr);
        exit;
    default:
        # code...
        break;
}

$dcq_op = Request::getString('dcq_op');
$dirname = Request::getString('dirname');
$col_name = Request::getString('col_name');
$col_sn = Request::getInt('col_sn');
$data_name = Request::getString('data_name');
switch ($dcq_op) {
    case 'save_dcq_sort':
        $col_ids = Request::getArray('col_ids');
        $sql = 'update ' . $xoopsDB->prefix("{$dirname}_data_center") . " set `data_sort`=`data_sort`+1000 where `data_name`='dcq' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";
        $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')' . $sql);

        $sort = 0;
        foreach ($col_ids as $col_id) {
            $sql = 'update ' . $xoopsDB->prefix("{$dirname}_data_center") . " set `data_sort`='{$sort}' where col_id='{$col_id}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";
            $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')' . $sql);
            $sort++;
        }
        echo _TAD_SORTED . '(' . date('Y-m-d H:i:s') . ')';
        exit;

    case 'del_dcq_ans':
        $data_name_arr = explode('|', $data_name);
        foreach ($data_name_arr as $data_name) {
            $sql = 'delete from ' . $xoopsDB->prefix("{$dirname}_data_center") . " where `data_name`='{$data_name}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";
            $xoopsDB->queryF($sql) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);
        }
        header("location:{$_SERVER['HTTP_REFERER']}");
        exit;

    case 'del_dcq_col':
        $col_id = Request::getString('col_id');

        $sql = 'delete from ' . $xoopsDB->prefix("{$dirname}_data_center") . " where `col_id`='{$col_id}'";
        $xoopsDB->queryF($sql) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);
        $sql = 'delete from ' . $xoopsDB->prefix("{$dirname}_data_center") . " where `data_name`='{$col_name}_{$col_sn}_dcq_{$col_id}'";
        $xoopsDB->queryF($sql) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);
        header("location:{$_SERVER['HTTP_REFERER']}");
        exit;

    case 'saveCustomSetupFormVal':
        $TadDataCenter = new TadDataCenter($dirname);
        $TadDataCenter->set_col($col_name, $col_sn);
        $TadDataCenter->saveData();
        // header("location:{$_SERVER['HTTP_REFERER']}");
        // exit;
}

function save_sort($table, $sort_col, $primary_key, $sort_arr = [])
{
    global $xoopsDB;
    $sort = 1;
    foreach ($sort_arr as $sn) {
        $sql = "update `" . $xoopsDB->prefix($table) . "` set `{$sort_col}`='{$sort}' where `{$primary_key}`='{$sn}'";
        $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL . " (" . date("Y-m-d H:i:s") . ")" . $sql);
        $sort++;
    }
    echo _TAD_SORTED . "(" . date("Y-m-d H:i:s") . ")";
}
