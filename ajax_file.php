<?php

$xoopsOrigin = '';
require_once __DIR__ . '/tadtools_header.php';

$originScheme = parse_url(XOOPS_URL, PHP_URL_SCHEME);
$originHost   = parse_url(XOOPS_URL, PHP_URL_HOST);
$originPort   = parse_url(XOOPS_URL, PHP_URL_PORT);
if ($originScheme && $originHost) {
    $xoopsOrigin = $originScheme . '://' . $originHost . ($originPort ? ':' . $originPort : '');
}
$httpOrigin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($httpOrigin !== '' && $xoopsOrigin !== '' && strcasecmp($httpOrigin, $xoopsOrigin) === 0) {
    header("Access-Control-Allow-Origin: {$httpOrigin}");
    header('Vary: Origin');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Methods, Content-Type');
}

use Xmf\Request;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

$op          = Request::getString('op');
$mod_name    = Request::getString('mod_name');
$table       = Request::getString('table');
$sort_col    = Request::getString('sort_col');
$primary_key = Request::getString('primary_key');
$files_sn    = Request::getInt('files_sn');
$sort_arr    = Request::getArray('sort_arr');
$db_prefix   = Request::getString('db_prefix');
$thumbs_dir  = Request::getString('thumbs_dir');
$allow_guest = Request::getInt('allow_guest', 0);

// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;

switch ($op) {
    case 'remove_json':
        Utility::del_theme_json();
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if (strpos($referer, XOOPS_URL) === 0) {
            // header("location:{$referer}");
            redirect_header($referer, 3, "已重取佈景設定！");
        } else {
            // header("location:" . XOOPS_URL);
            redirect_header(XOOPS_URL, 3, "已重取佈景設定！");
        }
        exit;

    case 'remove_file':
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $mod_name) || ($db_prefix !== '' && !preg_match('/^[a-zA-Z0-9_-]+$/', $db_prefix))) {
            http_response_code(400);
            die('Invalid module');
        }
        $TadUpFiles = new TadUpFiles($mod_name);
        if ($db_prefix !== '') {
            $TadUpFiles->set_db_prefix($db_prefix);
        }
        $has_session_acl = !empty($_SESSION['tadupfiles_acl'][$TadUpFiles->TadUpFilesTblName][$files_sn]);
        $has_guest_acl   = !empty($_SESSION['tadupfiles_guest_acl'][$TadUpFiles->TadUpFilesTblName][$files_sn]);
        if ($allow_guest && $has_guest_acl) {
            $TadUpFiles->set_var('allow_guest', 1);
        }
        $force_del = $has_session_acl;
        $result    = $TadUpFiles->del_files($files_sn, '', $force_del, $thumbs_dir);
        if (is_int($result)) {
            echo '1';
        } else {
            die($result);
        }
        exit;

    default:
        # code...
        break;
}

$dcq_op    = Request::getString('dcq_op');
$col_name  = Request::getString('col_name');
$col_sn    = Request::getInt('col_sn');
$data_name = Request::getString('data_name');
$dirname   = Request::getString('dirname');

// 盡早驗證，不要等到 switch 之後
if ($dirname !== '' && !preg_match('/^[a-zA-Z0-9_]+$/', $dirname)) {
    die('Invalid dirname');
}

if ($dcq_op !== '') {
    if ($dirname === '') {
        http_response_code(400);
        die('Invalid dirname');
    }
    $isModAdmin = false;
    if (is_object($xoopsUser)) {
        if ($xoopsUser->isAdmin()) {
            $isModAdmin = true;
        } else {
            $modhandler = xoops_getHandler('module');
            $targetMod  = $modhandler->getByDirname($dirname);
            if (is_object($targetMod) && $xoopsUser->isAdmin($targetMod->mid())) {
                $isModAdmin = true;
            }
        }
    }
}

switch ($dcq_op) {
    case 'save_dcq_sort':
        if (!$isModAdmin && empty($_SESSION['tdc_setup_acl'][$dirname]["{$col_name}:{$col_sn}"])) {
            http_response_code(403);
            die('Forbidden');
        }
        $col_ids = Request::getArray('col_ids');
        $sql     = 'UPDATE ' . $xoopsDB->prefix("{$dirname}_data_center") . " SET `data_sort`=`data_sort`+1000 WHERE `data_name`='dcq' AND `col_name`=? AND `col_sn`=?";
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
        if (!$isModAdmin && empty($_SESSION['tdc_ans_del_acl'][$dirname][$col_name])) {
            http_response_code(403);
            die('Forbidden');
        }
        $data_name_arr = explode('|', $data_name);
        foreach ($data_name_arr as $data_name) {
            $sql = 'DELETE FROM `' . $xoopsDB->prefix("{$dirname}_data_center") . "` WHERE `data_name`=? AND `col_name`=? AND `col_sn`=?";
            Utility::query($sql, 'ssi', [$data_name, $col_name, $col_sn]) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if (strpos($referer, XOOPS_URL) === 0) {
            header("location:{$referer}");
        } else {
            header("location:" . XOOPS_URL);
        }
        exit;

    case 'del_dcq_col':
        if (!$isModAdmin && empty($_SESSION['tdc_setup_acl'][$dirname]["{$col_name}:{$col_sn}"])) {
            http_response_code(403);
            die('Forbidden');
        }
        $col_id = Request::getString('col_id');

        $sql = 'DELETE FROM `' . $xoopsDB->prefix("{$dirname}_data_center") . "` WHERE `col_id`=? AND `col_name`=? AND `col_sn`=?";
        Utility::query($sql, 'ssi', [$col_id, $col_name, $col_sn]) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);

        $sql = 'DELETE FROM `' . $xoopsDB->prefix("{$dirname}_data_center") . "` WHERE `data_name`=?";
        Utility::query($sql, 's', [$col_name . '_' . $col_sn . '_dcq_' . $col_id]) or die(' (' . date('Y-m-d H:i:s') . ')' . $sql);

        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if (strpos($referer, XOOPS_URL) === 0) {
            header("location:{$referer}");
        } else {
            header("location:" . XOOPS_URL);
        }
        exit;

    case 'saveCustomSetupFormVal':
        if (!is_object($xoopsUser) && empty($_SESSION['tdc_form_acl'][$dirname]["{$col_name}:{$col_sn}"])) {
            http_response_code(403);
            die('Forbidden');
        }
        $TadDataCenter = new TadDataCenter($dirname);
        $TadDataCenter->set_col($col_name, $col_sn);
        $TadDataCenter->saveData();
}
