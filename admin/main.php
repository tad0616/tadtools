<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tadtools_adm_index_tpl.html";
include_once "header.php";
include_once "../tad_function.php";

/*-----------function區--------------*/
function tadtools_setup()
{
    global $xoopsModule, $xoopsConfig, $xoopsTpl, $xoopsDB;

    $use_bootstrap = $bootstrap_color = "";

    $sql    = "select * from `" . $xoopsDB->prefix("tadtools_setup") . "`";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<hr>" . $sql);
    //$tt_theme,$tt_use_bootstrap,$tt_bootstrap_color
    while (list($tt_theme, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind) = $xoopsDB->fetchRow($result)) {
        $use_bootstrap[$tt_theme]     = $tt_use_bootstrap;
        $bootstrap_color[$tt_theme]   = $tt_bootstrap_color;
        $tt_theme_kind_arr[$tt_theme] = $tt_theme_kind;
    }
    //die(var_export($tt_theme_kind_arr));

    $version = _MA_TT_VERSION . $xoopsModule->getVar("version");

    $i      = 0;
    $themes = "";
    foreach ($xoopsConfig['theme_set_allowed'] as $theme) {
        $color = $xoopsConfig['theme_set'] == $theme ? "style='background-color:#E2EDAD'" : "";

        $themes[$i]['color']      = $color;
        $themes[$i]['theme_name'] = $theme;

        if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme}/config.php")) {
            $theme_kind = "";
            include_once XOOPS_ROOT_PATH . "/themes/{$theme}/config.php";
            if (!empty($theme_kind)) {
                if (empty($tt_theme_kind_arr[$theme])) {
                    $sql = "replace into `" . $xoopsDB->prefix("tadtools_setup") . "` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color` , `tt_theme_kind`) values('{$theme}', '0', '{$theme_kind}', '{$theme_kind}')";
                    //die($sql);
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<hr>" . $sql);

                    $themes[$i]['theme_kind']      = $theme_kind;
                    $themes[$i]['use_bootstrap']   = '0';
                    $themes[$i]['tad_theme']       = '1';
                    $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($theme_kind);
                } else {
                    $themes[$i]['theme_kind']      = $tt_theme_kind_arr[$theme];
                    $themes[$i]['use_bootstrap']   = $bootstrap_color[$theme];
                    $themes[$i]['tad_theme']       = '1';
                    $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($tt_theme_kind_arr[$theme]);
                }
            } else {
                $themes[$i]['theme_kind']      = "html";
                $themes[$i]['use_bootstrap']   = $use_bootstrap[$theme] === "" ? 1 : $use_bootstrap[$theme];
                $themes[$i]['tad_theme']       = '0';
                $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($theme_kind);
            }
        } else {
            $theme_kind                    = search_bootstrap(XOOPS_ROOT_PATH . "/themes/{$theme}");
            $themes[$i]['theme_kind']      = $theme_kind;
            $themes[$i]['use_bootstrap']   = $use_bootstrap[$theme] === "" ? 1 : $use_bootstrap[$theme];
            $themes[$i]['tad_theme']       = '0';
            $themes[$i]['bootstrap_theme'] = mk_bootstrap_menu($theme_kind);
        }
        $themes[$i]['bootstrap_color'] = basename($bootstrap_color[$theme]);

        $i++;
    }

    $xoopsTpl->assign("themes", $themes);
    $xoopsTpl->assign("version", $version);
}

function search_bootstrap($path = "")
{
    $allfile  = directory_list($path);
    $file_str = json_encode($allfile);
    if (strpos($file_str, "glyphicons") !== false) {
        return "bootstrap3";
    } elseif (strpos($file_str, "bootstrap") !== false) {
        return "bootstrap";
    } else {
        return "html";
    }
}

function mk_bootstrap_menu($theme_kind = "")
{

    if ($theme_kind == "html" or $theme_kind == "mix") {
        $theme_array1 = mk_bootstrap_menu_options('bootstrap', "light");
        $theme_array2 = mk_bootstrap_menu_options('bootstrap', "dark");
        $theme_array3 = mk_bootstrap_menu_options('bootstrap3', "light");
        $theme_array4 = mk_bootstrap_menu_options('bootstrap3', "dark");
        $theme_array  = array_merge($theme_array1, $theme_array2, $theme_array3, $theme_array4);
    } else {
        $theme_array1 = mk_bootstrap_menu_options($theme_kind, "light");
        $theme_array2 = mk_bootstrap_menu_options($theme_kind, "dark");
        $theme_array  = array_merge($theme_array1, $theme_array2);
    }
    return $theme_array;
}

function mk_bootstrap_menu_options($theme_kind = "", $mode = "light")
{
    if (empty($theme_kind)) {
        $theme_kind = "bootstrap";
    }

    $dir                                    = XOOPS_ROOT_PATH . "/modules/tadtools/{$theme_kind}/themes/{$mode}/";
    $theme_array[$theme_kind]['kind']       = $theme_kind;
    $theme_array[$theme_kind]['theme_path'] = "{$theme_kind}";
    $theme_array[$theme_kind]['theme']      = $theme_kind;
    $theme_array[$theme_kind]['color']      = _TT_COLOR_DEFAULT;
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' or $file == '..' or filetype($dir . $file) != 'dir') {
                    continue;
                }

                $theme_array[$file]['kind']       = $theme_kind;
                $theme_array[$file]['theme_path'] = "{$theme_kind}/themes/{$mode}/{$file}";
                $theme_array[$file]['theme']      = $file;
                $theme_array[$file]['color']      = ($mode == 'dark') ? _TT_COLOR_DARK : _TT_COLOR_NORMAL;
            }
            closedir($dh);
        }
    }
    return $theme_array;
}

//列出目錄檔案
function directory_list($directory_base_path = "")
{

    $myts = &MyTextSanitizer::getInstance();

    $directory_base_path = $myts->addSlashes($directory_base_path);

    $directory_base_path = rtrim($directory_base_path, "/") . "/";

    $result_list = array();

    $allfile = glob($directory_base_path . "*");

    foreach ($allfile as $filename) {
        $filename     = $myts->addSlashes($filename);
        $basefilename = str_replace($directory_base_path, '', $filename);

        if (is_dir($filename)) {
            $result_list[$basefilename] = directory_list($filename);
        } else {

            $ext = strtolower(array_pop(explode('.', $filename)));
            $len = strlen($ext);
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
    foreach ($_POST['tt_use_bootstrap'] as $tt_theme => $tt_use_bootstrap) {
        $sql = "replace into `" . $xoopsDB->prefix("tadtools_setup") . "` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color` , `tt_theme_kind`) values('{$tt_theme}', '{$tt_use_bootstrap}', '{$_POST['tt_bootstrap_color'][$tt_theme]}', '{$_POST['tt_theme_kind'][$tt_theme]}')";
        $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<hr>" . $sql);
    }
}
/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');

switch ($op) {

    case "save":
        save();
        header("location:{$_SERVER['PHP_SELF']}");
        exit;
        break;

    default:
        tadtools_setup();
        break;
}

/*-----------秀出結果區--------------*/
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm.css');
include_once 'footer.php';
