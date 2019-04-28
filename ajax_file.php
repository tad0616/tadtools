<?php
use XoopsModules\Tadtools\TadUpFiles;

require_once __DIR__ . '/tadtools_header.php';

require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$mod_name = system_CleanVars($_REQUEST, 'mod_name', '', 'string');
$files_sn = system_CleanVars($_REQUEST, 'files_sn', 0, 'int');

switch ($op) {
    case 'remove_file':
        $TadUpFiles = new TadUpFiles($mod_name);
        if ($TadUpFiles->del_files($files_sn)) {
            echo '1';
        }
        break;
    default:
        # code...
        break;
}
