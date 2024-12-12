<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

use Xmf\Request;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_themes\Tools;

require_once __DIR__ . '/tadtools_header.php';

$op = Request::getString('op');
$mod_name = Request::getString('mod_name');
$table = Request::getString('table');
$sort_col = Request::getString('sort_col');
$primary_key = Request::getString('primary_key');
$files_sn = Request::getInt('files_sn');
$sort_arr = Request::getArray('sort_arr');
$db_prefix = Request::getString('db_prefix');

// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;

switch ($op) {
    case 'remove_json':
        Tools::del_theme_json();
        header("location:" . XOOPS_URL);
        exit;

    case 'remove_file':
        $TadUpFiles = new TadUpFiles($mod_name);
        $TadUpFiles->set_db_prefix($db_prefix);
        if ($TadUpFiles->del_files($files_sn)) {
            echo '1';
        }
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
        $sql = 'UPDATE ' . $xoopsDB->prefix("{$dirname}_data_center") . " SET `data_sort`=`data_sort`+1000 WHERE `data_name`='dcq' AND `col_name`=? AND `col_sn`=?";
        Utility::query($sql, 'si', [$col_name, $col_sn]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')' . $sql);

        $sort = 0;
        foreach ($col_ids as $col_id) {
            $sql = 'UPDATE ' . $xoopsDB->prefix("{$dirname}_data_center") . ' SET `data_sort`=? WHERE `col_id`=? and `col_name`=? and `col_sn`=?';
            Utility::query($sql, 'issi', [$sort, $col_id, $col_name, $col_sn]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')' . $sql);
            $sort++;
        }
        echo _TAD_SORTED . '(' . date('Y-m-d H:i:s') . ')';
        exit;

    case 'del_dcq_ans':
        $data_name_arr = explode('|', $data_name);
        foreach ($data_name_arr as $data_name) {
            $sql = 'DELETE FROM `' . $xoopsDB->prefix("{$dirname}_data_center") . "` WHERE `data_name`=? AND `col_name`=? AND `col_sn`=?";
            Utility::query($sql, 'ssi', [$data_name, $col_name, $col_sn]) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);
        }
        header("location:{$_SERVER['HTTP_REFERER']}");
        exit;

    case 'del_dcq_col':
        $col_id = Request::getString('col_id');

        $sql = 'DELETE FROM `' . $xoopsDB->prefix("{$dirname}_data_center") . "` WHERE `col_id`=?";
        Utility::query($sql, 's', [$col_id]) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);

        $sql = 'DELETE FROM `' . $xoopsDB->prefix("{$dirname}_data_center") . "` WHERE `data_name`=?";
        Utility::query($sql, 's', [$col_name . '_' . $col_sn . '_dcq_' . $col_id]) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);

        header("location:{$_SERVER['HTTP_REFERER']}");
        exit;

    case 'saveCustomSetupFormVal':
        $TadDataCenter = new TadDataCenter($dirname);
        $TadDataCenter->set_col($col_name, $col_sn);
        $TadDataCenter->saveData();
        // header("location:{$_SERVER['HTTP_REFERER']}");
        // exit;
}
