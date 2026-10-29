<?php
use Xmf\Request;
use XoopsModules\Tadtools\ErrorLog;

$xoopsOption['template_main'] = 'tadtools_adm_error_log.tpl';
require_once __DIR__ . '/header.php';

/*-----------function區--------------*/
function show_error_log($error_id = '')
{
    global $xoopsTpl;

    $invalid_id = '' !== $error_id && !ErrorLog::isValidId($error_id);
    $records    = $invalid_id ? [] : ErrorLog::search($error_id, 50);

    foreach ($records as &$record) {
        $record['trace_text'] = implode("\n", array_map('strval', (array) ($record['trace'] ?? [])));
    }
    unset($record);

    $xoopsTpl->assign('error_id', $error_id);
    $xoopsTpl->assign('invalid_id', $invalid_id);
    $xoopsTpl->assign('records', $records);
    $xoopsTpl->assign('log_path', ErrorLog::path());
    // 偵測 XOOPS 核心 logger 是否已套用 tadtools 修改（有 writeTadtoolsErrorLog 方法才算）
    $xoopsTpl->assign('logger_patched', class_exists('XoopsLogger') && method_exists('XoopsLogger', 'writeTadtoolsErrorLog'));
    $xoopsTpl->assign('token_html', $GLOBALS['xoopsSecurity']->getTokenHTML());
}

/*-----------執行動作判斷區----------*/
$op       = Request::getString('op');
$error_id = strtolower(trim(Request::getString('error_id')));

switch ($op) {
    case 'clear':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($_SERVER['PHP_SELF'], 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        ErrorLog::clear();
        redirect_header($_SERVER['PHP_SELF'], 2, _MA_TT_ERRLOG_CLEARED);
        break;

    default:
        show_error_log($error_id);
        break;
}

/*-----------秀出結果區--------------*/
require_once __DIR__ . '/footer.php';
