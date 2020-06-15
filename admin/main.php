<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
$xoopsOption['template_main'] = 'tadtools_adm_index.tpl'; //設定樣板檔（必）
require_once __DIR__ . '/header.php'; //引入預設檔頭（必）

/*-----------function區--------------*/
function tadtools_setup()
{
    global $xoopsModule, $xoopsConfig, $xoopsTpl, $xoopsDB;

    $use_bootstrap = $bootstrap_color = $tt_theme_kind_arr = [];

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tadtools_setup') . '`';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    //$tt_theme,$tt_use_bootstrap,$tt_bootstrap_color
    while (list($tt_theme, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind) = $xoopsDB->fetchRow($result)) {
        // $setup[$tt_theme]=array();
        $use_bootstrap[$tt_theme] = $tt_use_bootstrap;
        $bootstrap_color[$tt_theme] = $tt_bootstrap_color;
        $tt_theme_kind_arr[$tt_theme] = $tt_theme_kind;
    }
    // die(var_export($tt_theme_kind_arr));

    $version = _MA_TT_VERSION . $xoopsModule->getVar('version');

    $i = 0;
    $themes = [];
    foreach ($xoopsConfig['theme_set_allowed'] as $theme) {

        $color = $xoopsConfig['theme_set'] == $theme ? "style='background-color:#E2EDAD'" : '';

        $themes[$i]['color'] = $color;
        $themes[$i]['theme_name'] = $theme;

        if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme}/config.php")) {
            $theme_kind = '';
            require_once XOOPS_ROOT_PATH . "/themes/{$theme}/config.php";
            if (!empty($theme_kind)) {
                if (empty($tt_theme_kind_arr[$theme]) or 0 === $theme_change) {
                    $sql = 'update `' . $xoopsDB->prefix('tadtools_setup') . "` set `tt_theme_kind`='{$theme_kind}' where `tt_theme`='{$theme}'";
                    //die($sql);
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

                    $themes[$i]['theme_kind'] = $theme_kind;
                    $themes[$i]['use_bootstrap'] = '0';
                    $themes[$i]['tad_theme'] = '1';
                    $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($theme_kind, $theme_color);
                } else {
                    $themes[$i]['theme_kind'] = $tt_theme_kind_arr[$theme];
                    $themes[$i]['use_bootstrap'] = $bootstrap_color[$theme];
                    $themes[$i]['tad_theme'] = '1';
                    $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($tt_theme_kind_arr[$theme], $bootstrap_color[$theme]);
                }
            } else {
                $themes[$i]['theme_kind'] = 'html';
                $themes[$i]['use_bootstrap'] = '' === $use_bootstrap[$theme] ? 1 : $use_bootstrap[$theme];
                $themes[$i]['tad_theme'] = '0';
                $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($theme_kind, $theme_color);
            }
        } else {
            $theme_kind = search_bootstrap(XOOPS_ROOT_PATH . "/themes/{$theme}");
            $themes[$i]['theme_kind'] = $theme_kind;
            $themes[$i]['use_bootstrap'] = '' === $use_bootstrap[$theme] ? 1 : $use_bootstrap[$theme];
            $themes[$i]['tad_theme'] = '0';
            $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($theme_kind);
        }
        $themes[$i]['bootstrap_color'] = basename($bootstrap_color[$theme]);
        // var_export($themes[$i]);
        $i++;
    }

    $xoopsTpl->assign('themes', $themes);
    $xoopsTpl->assign('version', $version);

}

function search_bootstrap($path = '')
{
    $allfile = directory_list($path);
    $file_str = json_encode($allfile);
    if (false !== mb_strpos($file_str, 'glyphicons')) {
        return 'bootstrap3';
    } elseif (false !== mb_strpos($file_str, 'bootstrap')) {
        return 'bootstrap';
    }

    return 'html';
}

function mk_bootstrap_menu($theme_kind = '', $theme_color = '')
{
    if (empty($theme_kind)) {
        $theme_kind = 'bootstrap3';
    }
    $theme_array3 = mk_bootstrap_menu_options($theme_kind, 'light');
    $theme_array4 = mk_bootstrap_menu_options($theme_kind, 'dark');
    $theme_array = array_merge($theme_array3, $theme_array4);

    return $theme_array;
}

function mk_bootstrap_menu_options($theme_kind = '', $mode = 'light')
{
    if (empty($theme_kind)) {
        $theme_kind = 'bootstrap3';
    }

    $dir = XOOPS_ROOT_PATH . "/modules/tadtools/{$theme_kind}/themes/{$mode}/";
    $theme_array[$theme_kind]['kind'] = $theme_kind;
    $theme_array[$theme_kind]['theme_path'] = (string) ($theme_kind);
    $theme_array[$theme_kind]['theme'] = $theme_kind;
    $theme_array[$theme_kind]['color'] = _TT_COLOR_DEFAULT;
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if ('.' === $file or '..' === $file or 'dir' !== filetype($dir . $file)) {
                    continue;
                }

                $theme_array[$file]['kind'] = $theme_kind;
                $theme_array[$file]['theme_path'] = "{$theme_kind}/themes/{$mode}/{$file}";
                $theme_array[$file]['theme'] = $file;
                $theme_array[$file]['color'] = ('dark' === $mode) ? _TT_COLOR_DARK : _TT_COLOR_NORMAL;
            }
            closedir($dh);
        }
    }

    return $theme_array;
}

//列出目錄檔案
function directory_list($directory_base_path = '')
{
    $myts = \MyTextSanitizer::getInstance();

    $directory_base_path = $myts->addSlashes($directory_base_path);

    $directory_base_path = rtrim($directory_base_path, '/') . '/';

    $result_list = [];

    $allfile = glob($directory_base_path . '*');

    foreach ($allfile as $filename) {
        $filename = $myts->addSlashes($filename);
        $basefilename = str_replace($directory_base_path, '', $filename);

        if (is_dir($filename)) {
            $result_list[$basefilename] = directory_list($filename);
        } else {
            $ext = mb_strtolower(array_pop(explode('.', $filename)));
            $len = mb_strlen($ext);
            if ($len > 0 and $len <= 4) {
                $result_list[] = $basefilename;
            } else {
                $result_list[$basefilename] = directory_list($filename);
            }
        }
    }

    return $result_list;
}

function save()
{
    global $xoopsDB;

    $myts = \MyTextSanitizer::getInstance();
    $tt_use_bootstrap = Request::getArray('tt_use_bootstrap');
    $tt_bootstrap_color = Request::getArray('tt_bootstrap_color');
    $tt_theme_kind = Request::getArray('tt_theme_kind');

    foreach ($tt_use_bootstrap as $tt_theme => $tt_use_bootstrap) {
        $tt_bootstrap_color = $myts->addSlashes($tt_bootstrap_color[$tt_theme]);
        $tt_theme_kind = $myts->addSlashes($tt_theme_kind[$tt_theme]);

        $sql = 'replace into `' . $xoopsDB->prefix('tadtools_setup') . "` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color` , `tt_theme_kind`) values('{$tt_theme}', '{$tt_use_bootstrap}', '{$tt_bootstrap_color}', '{$tt_theme_kind}')";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }
}
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');

switch ($op) {
    case 'save':
        save();
        header("location:{$_SERVER['PHP_SELF']}");
        exit;

    default:
        tadtools_setup();
        break;
}

/*-----------秀出結果區--------------*/
require_once __DIR__ . '/footer.php';
