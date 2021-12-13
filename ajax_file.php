<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");

use Xmf\Request;
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
