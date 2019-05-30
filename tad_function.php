<?php
use XoopsModules\Tadtools\Utility;

// print_r(get_declared_classes());
require_once __DIR__ . '/include/beforeheader.php';
// 相容舊檔，還是需要
require_once __DIR__ . '/tadtools_header.php';

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

Utility::get_bootstrap();

if (!function_exists('get_jquery')) {
    function get_jquery($ui = false, $mode = '', $theme = 'base')
    {
        return Utility::get_jquery($ui, $mode, $theme);
    }
}

//建立目錄
if (!function_exists('mk_dir')) {
    function mk_dir($dir = '')
    {
        return Utility::mk_dir($dir);
    }
}

//刪除目錄
if (!function_exists('delete_directory')) {
    function delete_directory($dirname)
    {
        return Utility::delete_directory($dirname);
    }
}

//拷貝目錄
if (!function_exists('full_copy')) {
    function full_copy($source = '', $target = '')
    {
        return Utility::full_copy($source, $target);
    }
}

if (!function_exists('rename_win')) {
    function rename_win($oldfile, $newfile)
    {
        return Utility::rename_win($oldfile, $newfile);
    }
}

//路徑導覽，需搭配 get_模組_cate_path($分類編號);
if (!function_exists('tad_breadcrumb')) {
    function tad_breadcrumb($cate_sn = '0', $cate_path_array = [], $url_page = 'index.php', $page_cate_name = 'csn', $cate_title_name = 'title', $last = '')
    {
        return Utility::tad_breadcrumb($cate_sn, $cate_path_array, $url_page, $page_cate_name, $cate_title_name, $last);
    }
}

if (!function_exists('setup_meta')) {
    function setup_meta($title = '', $content = '', $image = '')
    {
        Utility::setup_meta($title, $content, $image);
    }
}

//解決 basename 抓不到中文檔名的問題
if (!function_exists('get_basename')) {
    function get_basename($filename)
    {
        return Utility::get_basename($filename);
    }
}

if (!function_exists('html5')) {
    function html5($content = '', $ui = false, $bootstrap = true, $bootstrap_version = 3, $use_jquery = true, $container = 'container')
    {
        return Utility::html5($content, $ui, $bootstrap, $bootstrap_version, $use_jquery, $container);
    }
}

//自訂錯誤訊息
if (!function_exists('web_error')) {
    function web_error($sql, $file = '', $line = '')
    {
        Utility::web_error($sql, $file, $line);
    }
}

//載入 bootstrap，目前僅後台用得到
function get_bootstrap($mode = '')
{
    return Utility::get_bootstrap($mode);
}

//自動取得網址
if (!function_exists('get_xoops_url')) {
    function get_xoops_url()
    {
        return Utility::get_xoops_url();
    }
}

//自動取得實體位置
if (!function_exists('get_xoops_path')) {
    function get_xoops_path()
    {
        return Utility::get_xoops_path();
    }
}

//自動轉連結
if (!function_exists('autolink')) {
    function autolink($text, $target = '_blank', $nofollow = true)
    {
        return Utility::autolink($text, $target, $nofollow);
    }
}

//推文工具
if (!function_exists('push_url')) {
    function push_url($enable = 1, $css = 'width:auto;margin:10px;float:right;')
    {
        return Utility::push_url($enable, $css);
    }
}

//facebook的留言
if (!function_exists('facebook_comments')) {
    function facebook_comments($facebook_comments_width = 600, $modules = '', $page = '', $col_name = '', $col_sn = '')
    {
        return Utility::facebook_comments($facebook_comments_width, $modules, $page, $col_name, $col_sn);
    }
}

//產生QR Code
if (!function_exists('mk_qrcode')) {
    function mk_qrcode($url)
    {
        return Utility::mk_qrcode($url);
    }
}

//產生QR Code檔案的名稱
if (!function_exists('mk_qrcode_name')) {
    function mk_qrcode_name($url = '')
    {
        return Utility::mk_qrcode_name($url);
    }
}

if (!function_exists('chk_qrcode_url')) {
    function chk_qrcode_url($url)
    {
        return Utility::chk_qrcode_url($url);
    }
}

//單選回復原始資料函數
if (!function_exists('chk')) {
    function chk($DBV = null, $NEED_V = '', $defaul = '', $return = "checked='checked'")
    {
        return Utility::chk($DBV, $NEED_V, $defaul, $return);
    }
}

//複選回復原始資料函數
if (!function_exists('chk2')) {
    function chk2($default_array = '', $NEED_V = '', $default = 0)
    {
        return Utility::chk2($default_array, $NEED_V, $default);
    }
}

//細部權限判斷
if (!function_exists('power_chk')) {
    function power_chk($perm_name = '', $sn = '')
    {
        return Utility::power_chk($perm_name, $sn);
    }
}

//把字串換成群組
if (!function_exists('txt_to_group_name')) {
    function txt_to_group_name($enable_group = '', $default_txt = '', $syb = '<br />')
    {
        return Utility::txt_to_group_name($enable_group, $default_txt, $syb);
    }
}

//取得所有群組
if (!function_exists('get_all_groups')) {
    function get_all_groups()
    {
        return Utility::get_all_groups();
    }
}

//輸出為UTF8
if (!function_exists('to_utf8')) {
    function to_utf8($buffer = '')
    {
        return Utility::to_utf8($buffer);
    }
}

//判斷字串是否為utf8
if (!function_exists('is_utf8')) {
    function is_utf8($str)
    {
        return Utility::is_utf8($str);
    }
}

//轉換編碼 （_CHARSET 在後面時，$OS2Web 為 true，預設）
if (!function_exists('auto_charset')) {
    function auto_charset($str = '', $OS_or_Web = 'web')
    {
        return Utility::auto_charset($str, $OS_or_Web);
    }
}

//亂數字串
if (!function_exists('randStr')) {
    function randStr($len = 6, $format = 'ALL')
    {
        return Utility::randStr($len, $format);
    }
}

//建立目錄
if (!function_exists('mk_dir')) {
    function mk_dir($dir = '')
    {
        return Utility::mk_dir($dir);
    }
}

//刪除整個目錄
if (!function_exists('rrmdir')) {
    function rrmdir($path)
    {
        return Utility::rrmdir($path);
    }
}
//取得分頁工具
if (!function_exists('getPageBar')) {
    function getPageBar($sql = '', $show_num = 20, $page_list = 10, $to_page = '', $url_other = '', $bootstrap = '3')
    {
        return Utility::getPageBar($sql, $show_num, $page_list, $to_page, $url_other, $bootstrap);
    }
}

if (!function_exists('toolbar_bootstrap')) {
    function toolbar_bootstrap($interface_menu = [])
    {
        return Utility::toolbar_bootstrap($interface_menu);
    }
}

if (!function_exists('make_menu_json')) {
    function make_menu_json($interface_menu = [], $moduleName = '')
    {
        return Utility::make_menu_json($interface_menu, $moduleName);
    }
}
