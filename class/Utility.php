<?php

namespace XoopsModules\Tadtools;

use Xmf\Request;

// use XoopsModules\Tadtools\PageBar;

/*
Utility Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Utility
 */
class Utility
{

    //建構函數
    public function __construct()
    {
        //建構函數
        self::get_jquery();
        self::get_bootstrap();
    }

    // XOOPS表單安全檢查
    public static function xoops_security_check()
    {
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header($_SERVER['PHP_SELF'], 3, $error);
        }
    }

    //除錯工具
    public static function dd($array = [])
    {
        header("Content-Type: application/json; charset=utf-8");
        die(json_encode($array, 256));
    }

    public static function add_migrate($mode = "")
    {
        global $xoTheme;
        self::get_jquery();
        $ver = self::get_version('xoops');
        if ($mode == "return") {
            if ($ver >= 20509) {
                return "<script src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-migrate-3.0.0.min.js'></script>";
            } else {
                return "<script src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-migrate-1.4.1.min.js'></script>";
            }
        } else {
            if ($ver >= 20509) {
                $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
            } else {
                $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
            }
        }
    }

    //版本判斷
    public static function get_version($type = 'xoops', $ver = '')
    {
        global $xoopsDB;
        if (empty($ver) and empty($type)) {
            return;
        }
        switch ($type) {
            case 'xoops':
                if (empty($ver)) {
                    $ver = XOOPS_VERSION;
                }
                $version = explode('.', str_replace('XOOPS ', '', $ver));
                break;

            case 'php':
                if (empty($ver)) {
                    $ver = PHP_VERSION;
                }

                $version = explode('.', $ver);
                break;

            default:
                if (empty($ver)) {
                    $sql = "select version from `" . $xoopsDB->prefix("modules") . "` where dirname='{$type}'";
                    $result = $xoopsDB->query($sql) or self::web_error($sql, __FILE__, __LINE__);
                    list($ver) = $xoopsDB->fetchRow($result);
                    for ($i = 0; $i < strlen($ver); $i++) {
                        $version[] = substr($ver, $i, 1);
                    }
                } else {
                    $v = explode('.', $ver);
                    $version[] = $v[0];
                    for ($i = 0; $i < strlen($v[1]); $i++) {
                        $version[] = substr($v[1], $i, 1);
                    }

                }
                break;
        }

        $Version = (int) $version[0] * 10000 + (int) $version[1] * 100 + (int) $version[2];
        return $Version;

    }

    //建立目錄
    public static function mk_dir($dir = '')
    {
        //若無目錄名稱秀出警告訊息
        if (empty($dir)) {
            return;
        }

        //若目錄不存在的話建立目錄
        if (!is_dir($dir)) {
            umask(000);
            //若建立失敗秀出警告訊息
            if (!mkdir($dir, 0777) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
            return $dir;
        }
    }

    //刪除目錄
    public static function delete_directory($dirname)
    {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            if ('.' !== $file && '..' !== $file) {
                if (!is_dir($dirname . '/' . $file)) {
                    unlink($dirname . '/' . $file);
                } else {
                    self::delete_directory($dirname . '/' . $file);
                }
            }
        }
        closedir($dir_handle);
        rmdir($dirname);

        return true;
    }

    //拷貝目錄
    public static function full_copy($source = '', $target = '')
    {
        if (is_dir($source)) {
            if (!self::mk_dir($target) && !is_dir($target)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $target));
            }
            $d = dir($source);
            while (false !== ($entry = $d->read())) {
                if ('.' === $entry || '..' === $entry) {
                    continue;
                }

                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    self::full_copy($Entry, $target . '/' . $entry);
                    continue;
                }
                copy($Entry, $target . '/' . $entry);
            }
            $d->close();
        } else {
            if (\file_exists($source)) {
                copy($source, $target);
            }
        }
    }

    public static function rename_win($oldfile, $newfile)
    {
        if (!rename($oldfile, $newfile)) {
            if (copy($oldfile, $newfile)) {
                unlink($oldfile);

                return true;
            }

            return false;
        }

        return true;
    }

    //路徑導覽，需搭配 get_模組_cate_path($分類編號);
    public static function tad_breadcrumb($cate_sn = '0', $cate_path_array = [], $url_page = 'index.php', $page_cate_name = 'csn', $cate_title_name = 'title', $last = '')
    {
        $item = '';
        if (is_array($cate_path_array)) {
            foreach ($cate_path_array as $path_cate_sn => $cate) {
                $url = ($cate_sn == $path_cate_sn) ? "<a href='{$url_page}?{$page_cate_name}={$path_cate_sn}'>{$cate[$cate_title_name]}</a>" : "<a href='{$url_page}?{$page_cate_name}={$path_cate_sn}'>{$cate[$cate_title_name]}</a>";
                $active = ($cate_sn == $path_cate_sn) ? 'active' : '';
                $item .= "<li class='breadcrumb-item {$active}'>{$url}</li>";
            }
        }
        if ($last) {
            $item .= "<li class='breadcrumb-item'>{$last}</li>";
        }

        $main = "
        <ul class='breadcrumb'>
            $item
        </ul>";

        return $main;
    }

    public static function setup_meta($title = '', $content = '', $image = '')
    {
        global $xoTheme, $xoopsTpl;
        if (is_object($xoTheme)) {
            $xoTheme->addMeta('meta', 'keywords', $title);
            $xoTheme->addMeta('meta', 'description', strip_tags($content));
        } else {
            $xoopsTpl->assign('xoops_meta_keywords', 'keywords', $title);
            $xoopsTpl->assign('xoops_meta_description', strip_tags($content));
        }

        $xoopsTpl->assign('fb_title', $title);
        $xoopsTpl->assign('fb_description', strip_tags($content));
        $xoopsTpl->assign('fb_image', $image);
        $xoopsTpl->assign('xoops_pagetitle', $title);
    }

    //解決 basename 抓不到中文檔名的問題
    public static function get_basename($filename)
    {
        $filename = preg_replace('/^.+[\\\\\\/]/', '', $filename);
        $filename = rtrim($filename, '/');

        return $filename;
    }

    public static function html5($content = '', $ui = false, $bootstrap = true, $bootstrap_version = 3, $use_jquery = true, $container = 'container', $title = 'XOOPS', $head_code = '')
    {
        $jquery = '';
        if ($use_jquery) {
            $jquery = self::get_jquery($ui, true);
        }

        $bootstrap_link = $bootstrap ? "<link rel='stylesheet' type='text/css' media='all' href='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/css/bootstrap.css' />" : '';

        $main = "<!DOCTYPE html>\n";
        $main .= "<html lang='zh-TW'>\n";
        $main .= "<head>\n";
        $main .= "  <meta charset='utf-8'>\n";
        $main .= "  <title>{$title}</title>\n";
        $main .= "  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
        $main .= "  $bootstrap_link\n";
        $main .= "  {$jquery}\n";
        $main .= "  {$head_code}\n";
        $main .= "</head>\n";
        $main .= "<body>\n";
        $main .= "    <div class='$container'>\n";
        $main .= "        {$content}\n";
        $main .= "    </div>\n";
        $main .= "</body>\n";
        $main .= "</html>\n";

        return $main;
    }

    //自訂錯誤訊息
    public static function web_error($sql, $file = '', $line = '', $force = false)
    {
        global $xoopsDB, $xoopsModule, $xoopsUser;
        xoops_loadLanguage('main', 'tadtools');
        $isAdmin = ($xoopsUser and $xoopsModule) ? $xoopsUser->isAdmin($xoopsModule->mid()) : false;

        $in_admin = (false !== mb_strpos($_SERVER['PHP_SELF'], '/admin/')) ? true : false;
        $main = '<h1>' . _TAD_OOPS_SOMETHING_WRONG . '</h1>';

        if ($isAdmin or $in_admin or $force) {
            $main .= "<div class='well'>{$sql}</div>";
        }

        $show_position = ($file) ? "<br>{$file}:{$line}" : '';
        $main .= "<div class='alert alert-danger'>" . $xoopsDB->error() . $show_position . "</div><div class='text-center'><a href='javascript:history.go(-1);' class='btn btn-primary'>" . _TAD_BACK_PAGE . '</a></div>';

        die(self::html5($main));
    }

    //載入 bootstrap，目前僅後台用得到
    public static function get_bootstrap($mode = '')
    {
        global $xoopsConfig, $xoopsDB, $xoTheme, $xoopsTpl;

        $in_admin = (false !== mb_strpos($_SERVER['PHP_SELF'], '/admin/')) ? true : false;

        $theme_set = $xoopsConfig['theme_set'];

        $sql = 'select `tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` from `' . $xoopsDB->prefix('tadtools_setup') . "`  where `tt_theme`='{$theme_set}'";

        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error() . '<br>' . __FILE__ . ':' . __LINE__);

        list($tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind) = $xoopsDB->fetchRow($result);

        $_SESSION['theme_kind'] = $tt_theme_kind;
        $_SESSION[$theme_set]['bootstrap_version'] = $tt_theme_kind;
        $_SESSION['bootstrap'] = 'bootstrap4' === $tt_theme_kind ? '4' : '3';

        if ($in_admin) {
            if ($xoopsTpl) {
                $xoopsTpl->assign('bootstrap_version', $_SESSION['bootstrap']);
            }
            //die($tt_bootstrap_color);
            if ($xoTheme) {
                if ('bootstrap3' === $tt_bootstrap_color) {
                    // $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
                    // $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
                } elseif ('bootstrap4' === $tt_bootstrap_color) {
                    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap4/css/bootstrap.css');
                    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm4.css');
                } else {
                    $c = explode('/', $tt_bootstrap_color);
                    if ('bootstrap4' === $c[0]) {
                        $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap4/css/bootstrap.css');
                        $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm4.css');
                        $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/' . $tt_bootstrap_color . '/bootstrap.min.css');
                    } elseif ('bootstrap3' === $c[0]) {
                        $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
                        $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
                        $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/' . $tt_bootstrap_color . '/bootstrap.min.css');
                    }
                }
                $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/fix-bootstrap.css');
                $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/font-awesome/css/font-awesome.css');
            }
        } elseif ('return' === $mode) {
            if ('bootstrap4' === $tt_theme_kind) {
                $main = "
                <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/bootstrap4/css/bootstrap.css'>";
            } else {
                $main = "
                <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/bootstrap3/css/bootstrap.css'>";
            }
            $main .= "<link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/font-awesome/css/font-awesome.css'>";

            return $main;
        }
    }

    //自動取得網址
    public static function get_xoops_url()
    {
        $http = ($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $port = 80 == $_SERVER['SERVER_PORT'] ? '' : ":{$_SERVER['SERVER_PORT']}";
        if (!isset($_SESSION['ez_url'])) {
            $u = parse_url($http . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI']);
            if (!empty($u['path']) and preg_match('/\/modules/', $u['path'])) {
                $XMUrl = explode('/modules', $u['path']);
            } elseif (!empty($u['path']) and preg_match('/\/themes/', $u['path'])) {
                $XMUrl = explode('/themes', $u['path']);
            } elseif (!empty($u['path']) and preg_match('/\/upgrade/', $u['path'])) {
                $XMUrl = explode('/upgrade', $u['path']);
            } elseif (!empty($u['path']) and preg_match('/\/include/', $u['path'])) {
                $XMUrl = explode('/include', $u['path']);
            } elseif (!empty($u['path']) and preg_match('/.php/', $u['path'])) {
                $XMUrl[0] = dirname($u['path']);
            } elseif (!empty($u['path'])) {
                $XMUrl[0] = $u['path'];
            } else {
                $XMUrl[0] = '';
            }

            $my_url = str_replace('\\', '/', $XMUrl['0']);
            if ('/' === mb_substr($my_url, -1)) {
                $my_url = mb_substr($my_url, 0, -1);
            }

            $_SESSION['ez_url'] = "{$u['scheme']}://{$u['host']}{$port}{$my_url}";
        }

        return $_SESSION['ez_url'];
    }

    //自動取得實體位置
    public static function get_xoops_path()
    {
        if (preg_match('/\/modules/', $_SERVER['SCRIPT_FILENAME'])) {
            $XMPath = explode('/modules', $_SERVER['SCRIPT_FILENAME']);
            $root_path = $XMPath[0];
        } elseif (preg_match('/\/themes/', $_SERVER['SCRIPT_FILENAME'])) {
            $XMPath = explode('/themes', $_SERVER['SCRIPT_FILENAME']);
            $root_path = $XMPath[0];
        } else {
            $root_path = dirname($_SERVER['SCRIPT_FILENAME']);
        }

        return $root_path;
    }

    public static function auto_link($text)
    {
        $pattern = '/(((http[s]?:\/\/(.+(:.+)?@)?)|(www\.))[a-z0-9](([-a-z0-9]+\.)*\.[a-z]{2,})?\/?[a-z0-9.,_\/~#&=:;%+!?-]+)/is';
        $text = preg_replace($pattern, ' <a href="$1" target="_blank">$1</a>', $text);
        // fix URLs without protocols
        $text = preg_replace('/href="www/', 'href="http://www', $text);
        return $text;
    }

    //自動轉連結
    public static function autolink(&$text, $target = '_blank', $nofollow = true)
    {
        // grab anything that looks like a URL...
        $urls = self::_autolink_find_URLS($text);
        if (!empty($urls)) {
            // i.e. there were some URLS found in the text
            array_walk($urls, '_autolink_create_html_tags', ['target' => $target, 'nofollow' => $nofollow]);
            $text = strtr($text, $urls);
        }
        // self::dd($text);
        return $text;
    }

    public static function _autolink_find_URLS($text)
    {
        // build the patterns
        $scheme = '(http:\/\/|https:\/\/)';
        $www = 'www\.';
        $ip = '\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}';
        $subdomain = '[-a-z0-9_]+\.';
        $name = '[a-z][-a-z0-9]+\.';
        $tld = '[a-z]+(\.[a-z]{2,2})?';
        $the_rest = '\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}';
        $pattern = "$scheme?(?(1)($ip|($subdomain)?$name$tld)|($www$name$tld))$the_rest";

        $pattern = '/' . $pattern . '/is';
        $c = preg_match_all($pattern, $text, $m);
        unset($text, $scheme, $www, $ip, $subdomain, $name, $tld, $the_rest, $pattern);
        if ($c) {
            return (array_flip($m[0]));
        }

        return ([]);
    }

    public static function _autolink_create_html_tags($value, $key, $other = null)
    {
        $target = $nofollow = null;
        if (is_array($other)) {
            $target = ($other['target'] ? " target=\"$other[target]\"" : null);
            $nofollow = ($other['nofollow'] ? ' rel="nofollow"' : null);
        }
        $value = "<a href=\"$key\"$target$nofollow>$key</a>";
    }

    //推文工具
    public static function push_url($enable = 1, $css = 'width:auto;margin:10px;float:right;')
    {
        global $xoopsConfig;
        if (!$enable) {
            return;
        }
        $jquery = self::get_jquery();
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

        $main = "
        <link rel='stylesheet' href='" . XOOPS_URL . "/modules/tadtools/social-likes/social-likes_birman.css'>
        $jquery
        <script src='" . XOOPS_URL . "/modules/tadtools/social-likes/social-likes.min.js'></script>
        <script type='text/javascript'>
        $().ready(function() {
            $('.social-likes').socialLikes({
                url: '{$protocol}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}',
                title: '{$xoopsConfig['sitename']}',
                counters: true,
                singleTitle: 'Share it!'
            });
        });
        </script>
        <ul class='social-likes'>
            <li class='facebook' title='Share link on Facebook'>Facebook</li>
            <li class='twitter' title='Share link on Twitter'>Twitter</li>
            <li class='plusone' title='Share link on Google+'>Google+</li>
            <div class='pinterest' title='Share image on Pinterest' data-media=''>Pinterest</div>
        </ul>
        ";

        return $main;
    }

//facebook的留言
    public static function facebook_comments($facebook_comments_width = 600, $modules = '', $page = '', $col_name = '', $col_sn = '')
    {
        if (empty($facebook_comments_width)) {
            return;
        }

        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $url = (empty($page) and empty($col_name) and empty($col_sn)) ? "{$protocol}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}" : XOOPS_URL . "/modules/{$modules}/{$page}?{$col_name}={$col_sn}";

        $main = "
        <div id=\"fb-root\"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = \"//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.9&appId=1825513194361728\";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div class='fb-comments' data-href='{$url}' data-width='100%' data-numposts='10' data-colorscheme='light' data-order-by='reverse_time'></div>

    ";

        return $main;
    }

    //產生QR Code
    public static function mk_qrcode($url)
    {
        $imgurl = self::mk_qrcode_name($url);
        self::mk_dir(XOOPS_ROOT_PATH . '/uploads/qrcode');
        if (!file_exists(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif")) {
            include_once 'qrcode/qrcode.php';
            $url = chk_qrcode_url($url);
            $a = new \QR("{$_SERVER['HTTP_HOST']}{$url}");
            //die(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif");
            file_put_contents(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif", $a->image(2));
        }
    }

    //產生QR Code檔案的名稱
    public static function mk_qrcode_name($url = '')
    {
        $url = self::chk_qrcode_url($url);
        $imgurl = str_replace(XOOPS_URL, '', $url);
        $imgurl = str_replace('modules/', '', $imgurl);
        $imgurl = str_replace('/', '_', $imgurl);
        $imgurl = str_replace('.', '_', $imgurl);
        $imgurl = str_replace('?', '_', $imgurl);
        $imgurl = str_replace('&', '_', $imgurl);
        $imgurl = str_replace('=', '_', $imgurl);

        return $imgurl;
    }

    public static function chk_qrcode_url($url)
    {
        $var = explode('?', $url);
        if (empty($var[1])) {
            return $url;
        }

        $vars = explode('&', $var[1]);
        foreach ($vars as $v) {
            list($key, $val) = explode('=', $v);
            if ('loadtime' === $key) {
                continue;
            }

            $all[$key] = $val;
        }

        $var2 = '?';
        foreach ($all as $key => $val) {
            $varall[] = "{$key}={$val}";
        }

        $var2 = implode('&', $varall);
        $url = "{$var[0]}?{$var2}";

        return $url;
    }

    //單選回復原始資料函數
    public static function chk($DBV = null, $NEED_V = '', $defaul = '', $return = "checked='checked'")
    {
        if ($DBV == $NEED_V) {
            return $return;
        } elseif (empty($DBV) && '1' == $defaul) {
            return $return;
        }

        return '';
    }

    //複選回復原始資料函數
    public static function chk2($default_array = '', $NEED_V = '', $default = 0)
    {
        if (in_array($NEED_V, $default_array)) {
            return 'checked';
        } elseif (empty($default_array) && '1' == $default) {
            return 'checked';
        }

        return '';
    }

    //細部權限判斷
    public static function power_chk($perm_name = '', $perm_itemid = '', $module_id = '', $trueifadmin = true)
    {
        global $xoopsUser, $xoopsModule;
        if (!$xoopsModule) {
            return;
        }

        //取得目前使用者的群組編號
        if (!isset($_SESSION['groups']) or $_SESSION['groups'] === '') {
            $_SESSION['groups'] = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        }

        //取得模組編號
        if (empty($module_id)) {
            $module_id = $xoopsModule->mid();
        }
        if (empty($perm_name)) {
            $perm_name = $xoopsModule->dirname();
        };
        //取得群組權限功能
        $gperm_handler = xoops_getHandler('groupperm');

        //權限項目編號
        $perm_itemid = (int) $perm_itemid;
        //依據該群組是否對該權限項目有使用權之判斷 ，做不同之處理
        if ($gperm_handler->checkRight($perm_name, $perm_itemid, $_SESSION['groups'], $module_id, $trueifadmin)) {
            return true;
        }

        return false;
    }

    //把字串換成群組
    public static function txt_to_group_name($enable_group = '', $default_txt = '', $syb = '<br>')
    {
        $groups_array = self::get_all_groups();
        if (empty($enable_group)) {
            $g_txt_all = $default_txt;
        } else {
            $gs = explode(',', $enable_group);
            $g_txt = [];
            foreach ($gs as $gid) {
                $g_txt[] = $groups_array[$gid];
            }
            $g_txt_all = implode($syb, $g_txt);
        }

        return $g_txt_all;
    }

    //取得所有群組
    public static function get_all_groups()
    {
        global $xoopsDB;
        $sql = 'select groupid,name from ' . $xoopsDB->prefix('groups') . '';
        $result = $xoopsDB->query($sql);
        while (list($groupid, $name) = $xoopsDB->fetchRow($result)) {
            $data[$groupid] = $name;
        }

        return $data;
    }

    //輸出為UTF8
    public static function to_utf8($buffer = '')
    {
        if (_CHARSET === 'UTF-8') {
            return $buffer;
        }
        $buffer = (!function_exists('mb_convert_encoding')) ? iconv('Big5', 'UTF-8', $buffer) : mb_convert_encoding($buffer, 'UTF-8', 'Big5');

        return $buffer;
    }

    //判斷字串是否為utf8
    public static function is_utf8($str)
    {
        $i = 0;
        $len = mb_strlen($str);

        for ($i = 0; $i < $len; $i++) {
            $sbit = ord(mb_substr($str, $i, 1));
            if ($sbit < 128) {
                //本字節為英文字符，不與理會
            } elseif ($sbit > 191 && $sbit < 224) {
                //第一字節為落於192~223的utf8的中文字(表示該中文為由2個字節所組成utf8中文字)，找下一個中文字
                $i++;
            } elseif ($sbit > 223 && $sbit < 240) {
                //第一字節為落於223~239的utf8的中文字(表示該中文為由3個字節所組成的utf8中文字)，找下一個中文字
                $i += 2;
            } elseif ($sbit > 239 && $sbit < 248) {
                //第一字節為落於240~247的utf8的中文字(表示該中文為由4個字節所組成的utf8中文字)，找下一個中文字
                $i += 3;
            } else {
                //第一字節為非的utf8的中文字
                return 0;
            }
        }
        //檢查完整個字串都沒問體，代表這個字串是utf8中文字
        return 1;
    }

    //轉換編碼 （_CHARSET 在後面時，$OS2Web 為 true，預設）
    public static function auto_charset($str = '', $OS_or_Web = 'web')
    {
        $os_charset = (PATH_SEPARATOR === ':') ? 'UTF-8' : 'Big5';
        if (_CHARSET != $os_charset) {
            $new_str = 'web' === $OS_or_Web ? iconv($os_charset, _CHARSET, $str) : iconv(_CHARSET, $os_charset, $str);
        }
        if (empty($new_str)) {
            $new_str = $str;
        }

        return $new_str;
    }

    //亂數字串
    public static function randStr($len = 6, $format = 'ALL')
    {
        switch ($format) {
            case 'ALL':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
            case 'CHAR':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'NUMBER':
                $chars = '0123456789';
                break;
            default:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        // die('seed=' . $seed);
        mt_srand($seed);
        $password = '';
        while (mb_strlen($password) < $len) {
            $password .= mb_substr($chars, (mt_rand() % mb_strlen($chars)), 1);
        }

        return $password;
    }

    //刪除整個目錄
    public static function rrmdir($path)
    {
        return is_file($path) ?
        @unlink($path) :
        array_map('rrmdir', glob($path . '/*')) == @rmdir($path)
        ;
    }

    //取得分頁工具
    public static function getPageBar($sql = '', $show_num = 20, $page_list = 10, $to_page = '', $url_other = '', $bootstrap = '3')
    {
        global $xoopsDB;
        if (empty($show_num)) {
            $show_num = 20;
        }

        if (empty($page_list)) {
            $page_list = 10;
        }

        if (empty($bootstrap)) {
            $bootstrap = $_SESSION['bootstrap'];
        }

        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 10, $xoopsDB->error() . '<br>' . __FILE__ . ':' . __LINE__ . "<br>$sql");
        $total = $xoopsDB->getRowsNum($result);

        $navbar = new \XoopsModules\Tadtools\PageBar($total, $show_num, $page_list);

        if (!empty($to_page)) {
            $navbar->set_to_page($to_page);
        }

        if (!empty($url_other)) {
            $navbar->set_url_other($url_other);
        }

        if ('3' == $bootstrap or '4' == $bootstrap) {
            $mybar = $navbar->makeBootStrapBar('', $bootstrap);
            $main['bar'] = "
                <div class='text-center'>
                    <nav>
                        <ul class='pagination justify-content-center'>
                        {$mybar['left']}
                        {$mybar['center']}
                        {$mybar['right']}
                        </ul>
                    </nav>
                </div>
                ";
        } else {
            $mybar = $navbar->makeBar();
            $main['bar'] = "<div style='text-align:center;margin:4px;'>{$mybar['left']}{$mybar['center']}{$mybar['right']}<div style='zoom:1;clear:both;'></div></div>";
        }

        $main['sql'] = $sql . $mybar['sql'];
        $main['total'] = $total;

        return $main;
    }

    public static function toolbar_bootstrap($interface_menu = [], $force = false)
    {
        global $xoopsUser, $xoopsModule, $xoopsModuleConfig;

        xoops_loadLanguage('main', 'tadtools');
        $op = Request::getString('op');

        if ($xoopsModule) {
            $module_id = $xoopsModule->mid();
            $mod_name = $xoopsModule->name();
            $moduleName = $xoopsModule->dirname();
        } else {
            $mod_name = $moduleName = '';
        }

        if ($xoopsUser) {
            $isAdmin = $xoopsUser->isAdmin($module_id);
        } else {
            $isAdmin = false;
        }

        if (empty($interface_menu) and !$force) {
            return;
        }

        self::make_menu_json($interface_menu, $moduleName);

        self::get_jquery();

        $options = "<li><a href='index.php' title='" . _TAD_HOME . "'><i class='fa fa-home'></i></a></li>";
        if (is_array($interface_menu)) {
            $basename = basename($_SERVER['SCRIPT_NAME']);
            if (1 == count($interface_menu) and 'index.php' === mb_substr($_SERVER['REQUEST_URI'], -9)) {
                return;
            }

            foreach ($interface_menu as $title => $url) {
                if (strpos($url, 'admin/index.php') !== false or strpos($url, 'admin/main.php') !== false) {
                    continue;
                }

                $urlPath = (empty($moduleName) or 'http' === mb_substr($url, 0, 4)) ? $url : XOOPS_URL . "/modules/{$moduleName}/{$url}";

                if (!empty($op) and false !== strpos($url, "?op=") and false !== strpos($url, "{$basename}?op={$op}")) {
                    $active = "class='current' title='{$_SERVER['SCRIPT_NAME']}?op={$op}=={$url}'";
                } elseif (!isset($op) and false !== strpos($_SERVER['SCRIPT_NAME'], $url)) {
                    $active = "class='current' title='hi'";
                } else {
                    $active = '';
                }
                $options .= "<li {$active}><a href='{$urlPath}'>{$title}</a></li>";
            }

            if ($isAdmin and $module_id) {
                $options .= "<li {$active}><a href='admin/index.php' title='" . sprintf(_TAD_ADMIN, $mod_name) . "'><i class='fa fa-wrench'></i></a></li>";
                $options .= "<li {$active}><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&op=showmod&mod={$module_id}' title='" . sprintf(_TAD_CONFIG, $mod_name) . "'><i class='fa fa-edit'></i></a></li>";
                $options .= "<li {$active}><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module={$moduleName}' title='" . sprintf(_TAD_UPDATE, $mod_name) . "'><i class='fa fa-refresh'></i></a></li>";
                $options .= "<li {$active}><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen={$module_id}&selmod=-2&selgrp=-1&selvis=-1' title='" . sprintf(_TAD_BLOCKS, $mod_name) . "'><i class='fa fa-th'></i></a></li>";
            }
        } else {
            return;
        }

        $main = "
        <style>
            .toolbar_bootstrap_nav {
                position: relative;
                margin: 20px 0;
            }
            .toolbar_bootstrap_nav ul {
                margin: 0;
                padding: 0;
            }
            .toolbar_bootstrap_nav li {
                margin: 0 5px 10px 0;
                padding: 0;
                list-style: none;
                display: inline-block;
            }
            .toolbar_bootstrap_nav a {
                padding: 3px 12px;
                text-decoration: none;
                color: #999;
                line-height: 100%;
            }
            .toolbar_bootstrap_nav a:hover {
                color: #000;
            }
            .toolbar_bootstrap_nav .current a {
                background: #999;
                color: #fff;
                border-radius: 5px;
            }
        </style>

        <nav class='toolbar_bootstrap_nav'>
            <ul>
            $options
            </ul>
        </nav>";

        return $main;
    }

    public static function make_menu_json($interface_menu = [], $moduleName = '')
    {
        $json = json_encode($interface_menu);
        $filename = XOOPS_ROOT_PATH . "/uploads/menu_{$moduleName}.txt";
        file_put_contents($filename, $json);
    }

    public static function TadToolsXoopsModuleConfig()
    {
        $modhandler = xoops_getHandler('module');
        $TadToolsModule = $modhandler->getByDirname('tadtools');
        if (is_object($TadToolsModule)) {
            $config_handler = xoops_getHandler('config');
            $TadToolsModuleConfig = $config_handler->getConfigsByCat(0, $TadToolsModule->getVar('mid'));

            return $TadToolsModuleConfig;
        }

        return false;
    }

    public static function get_jquery($ui = false, $mode = '', $theme = 'base')
    {
        global $xoTheme;
        if (!isset($xoTheme) or 'return' === $mode) {
            $jqueryui_path = '';
            if ($ui) {
                $jqueryui_path = "
                <link href='" . XOOPS_URL . "/modules/tadtools/jquery/themes/{$theme}/jquery.ui.all.css' rel='stylesheet' type='text/css'>
                <script src='" . XOOPS_URL . "/modules/tadtools/jquery/ui/jquery-ui.js'></script>
                <script src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery.ui.touch-punch.min.js'></script>";
            }
            $ver = self::get_version('xoops');
            if ($ver >= 20509) {
                $jquery_path = "
                <script type='text/javascript'>
                if(typeof jQuery == 'undefined') {
                document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-3.2.1.js'><\/script>\");
                // document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-migrate-3.0.0.min.js'><\/script>\");
                // document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery.jgrowl.js'><\/script>\");
                }
                </script>
                $jqueryui_path
                ";
            } else {
                $jquery_path = "
                <script type='text/javascript'>
                if(typeof jQuery == 'undefined') {
                document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-3.2.1.js'><\/script>\");
                // document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-migrate-1.4.1.min.js'><\/script>\");
                // document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery.jgrowl.js'><\/script>\");
                }
                </script>
                $jqueryui_path
                ";
            }

            return $jquery_path;
        } else {
            $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

            if ($ui) {
                $xoTheme->addStylesheet("modules/tadtools/jquery/themes/{$theme}/jquery.ui.all.css");
                $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
                $xoTheme->addScript('modules/tadtools/jquery/jquery.ui.touch-punch.min.js');
            }
        }
    }

    public static function mobile_device_detect($iphone = true, $ipad = true, $android = true, $opera = true, $blackberry = true, $palm = true, $windows = true, $mobileredirect = false, $desktopredirect = false)
    {
        // This code is from http://detectmobilebrowsers.mobi/ - please do not republish it without due credit and hyperlink to http://detectmobilebrowsers.mobi/ really, i'd prefer it if it wasn't republished in full as that way it's main source is it's homepage and it's always kept up to date
        $mobile_browser = false; // set mobile browser as false till we can prove otherwise
        $user_agent = $_SERVER['HTTP_USER_AGENT']; // get the user agent value - this should be cleaned to ensure no nefarious input gets executed
        $accept = $_SERVER['HTTP_ACCEPT']; // get the content accept value - this should be cleaned to ensure no nefarious input gets executed

        switch (true) {
            // using a switch against the following statements which could return true is more efficient than the previous method of using if statements

            case (preg_match('/ipad/i', $user_agent)): // we find the word ipad in the user agent
                $mobile_browser = $ipad; // mobile browser is either true or false depending on the setting of ipad when calling the function
                $status = 'Apple iPad';
                if ('http' === mb_substr($ipad, 0, 4)) { // does the value of ipad resemble a url
                    $mobileredirect = $ipad; // set the mobile redirect url to the url value stored in the ipad value
                } // ends the if for ipad being a url
                break; // break out and skip the rest if we've had a match on the ipad // this goes before the iphone to catch it else it would return on the iphone instead
            case (preg_match('/ipod/i', $user_agent) || preg_match('/iphone/i', $user_agent)): // we find the words iphone or ipod in the user agent
                $mobile_browser = $iphone; // mobile browser is either true or false depending on the setting of iphone when calling the function
                $status = 'Apple';
                if ('http' === mb_substr($iphone, 0, 4)) { // does the value of iphone resemble a url
                    $mobileredirect = $iphone; // set the mobile redirect url to the url value stored in the iphone value
                } // ends the if for iphone being a url
                break; // break out and skip the rest if we've had a match on the iphone or ipod
            case (preg_match('/android/i', $user_agent)): // we find android in the user agent
                $mobile_browser = $android; // mobile browser is either true or false depending on the setting of android when calling the function
                $status = 'Android';
                if ('http' === mb_substr($android, 0, 4)) { // does the value of android resemble a url
                    $mobileredirect = $android; // set the mobile redirect url to the url value stored in the android value
                } // ends the if for android being a url
                break; // break out and skip the rest if we've had a match on android
            case (preg_match('/opera mini/i', $user_agent)): // we find opera mini in the user agent
                $mobile_browser = $opera; // mobile browser is either true or false depending on the setting of opera when calling the function
                $status = 'Opera';
                if ('http' === mb_substr($opera, 0, 4)) { // does the value of opera resemble a rul
                    $mobileredirect = $opera; // set the mobile redirect url to the url value stored in the opera value
                } // ends the if for opera being a url
                break; // break out and skip the rest if we've had a match on opera
            case (preg_match('/blackberry/i', $user_agent)): // we find blackberry in the user agent
                $mobile_browser = $blackberry; // mobile browser is either true or false depending on the setting of blackberry when calling the function
                $status = 'Blackberry';
                if ('http' === mb_substr($blackberry, 0, 4)) { // does the value of blackberry resemble a rul
                    $mobileredirect = $blackberry; // set the mobile redirect url to the url value stored in the blackberry value
                } // ends the if for blackberry being a url
                break; // break out and skip the rest if we've had a match on blackberry
            case (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i', $user_agent)): // we find palm os in the user agent - the i at the end makes it case insensitive
                $mobile_browser = $palm; // mobile browser is either true or false depending on the setting of palm when calling the function
                $status = 'Palm';
                if ('http' === mb_substr($palm, 0, 4)) { // does the value of palm resemble a rul
                    $mobileredirect = $palm; // set the mobile redirect url to the url value stored in the palm value
                } // ends the if for palm being a url
                break; // break out and skip the rest if we've had a match on palm os
            case (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i', $user_agent)): // we find windows mobile in the user agent - the i at the end makes it case insensitive
                $mobile_browser = $windows; // mobile browser is either true or false depending on the setting of windows when calling the function
                $status = 'Windows Smartphone';
                if ('http' === mb_substr($windows, 0, 4)) { // does the value of windows resemble a rul
                    $mobileredirect = $windows; // set the mobile redirect url to the url value stored in the windows value
                } // ends the if for windows being a url
                break; // break out and skip the rest if we've had a match on windows
            case (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i', $user_agent)): // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive
                $mobile_browser = true; // set mobile browser to true
                $status = 'Mobile matched on piped preg_match';
                break; // break out and skip the rest if we've preg_match on the user agent returned true
            case ((mb_strpos($accept, 'text/vnd.wap.wml') > 0) || (mb_strpos($accept, 'application/vnd.wap.xhtml+xml') > 0)): // is the device showing signs of support for text/vnd.wap.wml or application/vnd.wap.xhtml+xml
                $mobile_browser = true; // set mobile browser to true
                $status = 'Mobile matched on content accept header';
                break; // break out and skip the rest if we've had a match on the content accept headers
            case (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])): // is the device giving us a HTTP_X_WAP_PROFILE or HTTP_PROFILE header - only mobile devices would do this
                $mobile_browser = true; // set mobile browser to true
                $status = 'Mobile matched on profile headers being set';
                break; // break out and skip the final step if we've had a return true on the mobile specfic headers
            case (in_array(mb_strtolower(mb_substr($user_agent, 0, 4)), [
                    '1207' => '1207', '3gso' => '3gso', '4thp' => '4thp', '501i' => '501i', '502i' => '502i', '503i' => '503i', '504i' => '504i', '505i' => '505i', '506i' => '506i', '6310' => '6310', '6590' => '6590', '770s' => '770s', '802s' => '802s', 'a wa' => 'a wa', 'acer' => 'acer', 'acs-' => 'acs-', 'airn' => 'airn', 'alav' => 'alav', 'asus' => 'asus', 'attw' => 'attw', 'au-m' => 'au-m', 'aur ' => 'aur ', 'aus ' => 'aus ', 'abac' => 'abac', 'acoo' => 'acoo', 'aiko' => 'aiko', 'alco' => 'alco', 'alca' => 'alca', 'amoi' => 'amoi', 'anex' => 'anex', 'anny' => 'anny', 'anyw' => 'anyw', 'aptu' => 'aptu', 'arch' => 'arch', 'argo' => 'argo', 'bell' => 'bell', 'bird' => 'bird', 'bw-n' => 'bw-n', 'bw-u' => 'bw-u', 'beck' => 'beck', 'benq' => 'benq', 'bilb' => 'bilb', 'blac' => 'blac', 'c55/' => 'c55/', 'cdm-' => 'cdm-', 'chtm' => 'chtm', 'capi' => 'capi', 'cond' => 'cond', 'craw' => 'craw', 'dall' => 'dall', 'dbte' => 'dbte', 'dc-s' => 'dc-s', 'dica' => 'dica', 'ds-d' => 'ds-d', 'ds12' => 'ds12', 'dait' => 'dait', 'devi' => 'devi', 'dmob' => 'dmob', 'doco' => 'doco', 'dopo' => 'dopo', 'el49' => 'el49', 'erk0' => 'erk0', 'esl8' => 'esl8', 'ez40' => 'ez40', 'ez60' => 'ez60', 'ez70' => 'ez70', 'ezos' => 'ezos', 'ezze' => 'ezze', 'elai' => 'elai', 'emul' => 'emul', 'eric' => 'eric', 'ezwa' => 'ezwa', 'fake' => 'fake', 'fly-' => 'fly-', 'fly_' => 'fly_', 'g-mo' => 'g-mo', 'g1 u' => 'g1 u', 'g560' => 'g560', 'gf-5' => 'gf-5', 'grun' => 'grun', 'gene' => 'gene', 'go.w' => 'go.w', 'good' => 'good', 'grad' => 'grad', 'hcit' => 'hcit', 'hd-m' => 'hd-m', 'hd-p' => 'hd-p', 'hd-t' => 'hd-t', 'hei-' => 'hei-', 'hp i' => 'hp i', 'hpip' => 'hpip', 'hs-c' => 'hs-c', 'htc ' => 'htc ', 'htc-' => 'htc-', 'htca' => 'htca', 'htcg' => 'htcg', 'htcp' => 'htcp', 'htcs' => 'htcs', 'htct' => 'htct', 'htc_' => 'htc_', 'haie' => 'haie', 'hita' => 'hita', 'huaw' => 'huaw', 'hutc' => 'hutc', 'i-20' => 'i-20', 'i-go' => 'i-go', 'i-ma' => 'i-ma', 'i230' => 'i230', 'iac' => 'iac', 'iac-' => 'iac-', 'iac/' => 'iac/', 'ig01' => 'ig01', 'im1k' => 'im1k', 'inno' => 'inno', 'iris' => 'iris', 'jata' => 'jata', 'java' => 'java', 'kddi' => 'kddi', 'kgt' => 'kgt', 'kgt/' => 'kgt/', 'kpt ' => 'kpt ', 'kwc-' => 'kwc-', 'klon' => 'klon', 'lexi' => 'lexi', 'lg g' => 'lg g', 'lg-a' => 'lg-a', 'lg-b' => 'lg-b', 'lg-c' => 'lg-c', 'lg-d' => 'lg-d', 'lg-f' => 'lg-f', 'lg-g' => 'lg-g', 'lg-k' => 'lg-k', 'lg-l' => 'lg-l', 'lg-m' => 'lg-m', 'lg-o' => 'lg-o', 'lg-p' => 'lg-p', 'lg-s' => 'lg-s', 'lg-t' => 'lg-t', 'lg-u' => 'lg-u', 'lg-w' => 'lg-w', 'lg/k' => 'lg/k', 'lg/l' => 'lg/l', 'lg/u' => 'lg/u', 'lg50' => 'lg50', 'lg54' => 'lg54', 'lge-' => 'lge-', 'lge/' => 'lge/', 'lynx' => 'lynx', 'leno' => 'leno', 'm1-w' => 'm1-w', 'm3ga' => 'm3ga', 'm50/' => 'm50/', 'maui' => 'maui', 'mc01' => 'mc01', 'mc21' => 'mc21', 'mcca' => 'mcca', 'medi' => 'medi', 'meri' => 'meri', 'mio8' => 'mio8', 'mioa' => 'mioa', 'mo01' => 'mo01', 'mo02' => 'mo02', 'mode' => 'mode', 'modo' => 'modo', 'mot ' => 'mot ', 'mot-' => 'mot-', 'mt50' => 'mt50', 'mtp1' => 'mtp1', 'mtv ' => 'mtv ', 'mate' => 'mate', 'maxo' => 'maxo', 'merc' => 'merc', 'mits' => 'mits', 'mobi' => 'mobi', 'motv' => 'motv', 'mozz' => 'mozz', 'n100' => 'n100', 'n101' => 'n101', 'n102' => 'n102', 'n202' => 'n202', 'n203' => 'n203', 'n300' => 'n300', 'n302' => 'n302', 'n500' => 'n500', 'n502' => 'n502', 'n505' => 'n505', 'n700' => 'n700', 'n701' => 'n701', 'n710' => 'n710', 'nec-' => 'nec-', 'nem-' => 'nem-', 'newg' => 'newg', 'neon' => 'neon', 'netf' => 'netf', 'noki' => 'noki', 'nzph' => 'nzph', 'o2 x' => 'o2 x', 'o2-x' => 'o2-x', 'opwv' => 'opwv', 'owg1' => 'owg1', 'opti' => 'opti', 'oran' => 'oran', 'p800' => 'p800', 'pand' => 'pand', 'pg-1' => 'pg-1', 'pg-2' => 'pg-2', 'pg-3' => 'pg-3', 'pg-6' => 'pg-6', 'pg-8' => 'pg-8', 'pg-c' => 'pg-c', 'pg13' => 'pg13', 'phil' => 'phil', 'pn-2' => 'pn-2', 'pt-g' => 'pt-g', 'palm' => 'palm', 'pana' => 'pana', 'pire' => 'pire', 'pock' => 'pock', 'pose' => 'pose', 'psio' => 'psio', 'qa-a' => 'qa-a', 'qc-2' => 'qc-2', 'qc-3' => 'qc-3', 'qc-5' => 'qc-5', 'qc-7' => 'qc-7', 'qc07' => 'qc07', 'qc12' => 'qc12', 'qc21' => 'qc21', 'qc32' => 'qc32', 'qc60' => 'qc60', 'qci-' => 'qci-', 'qwap' => 'qwap', 'qtek' => 'qtek', 'r380' => 'r380', 'r600' => 'r600', 'raks' => 'raks', 'rim9' => 'rim9', 'rove' => 'rove', 's55/' => 's55/', 'sage' => 'sage', 'sams' => 'sams', 'sc01' => 'sc01', 'sch-' => 'sch-', 'scp-' => 'scp-', 'sdk/' => 'sdk/', 'se47' => 'se47', 'sec-' => 'sec-', 'sec0' => 'sec0', 'sec1' => 'sec1', 'semc' => 'semc', 'sgh-' => 'sgh-', 'shar' => 'shar', 'sie-' => 'sie-', 'sk-0' => 'sk-0', 'sl45' => 'sl45', 'slid' => 'slid', 'smb3' => 'smb3', 'smt5' => 'smt5', 'sp01' => 'sp01', 'sph-' => 'sph-', 'spv ' => 'spv ', 'spv-' => 'spv-', 'sy01' => 'sy01', 'samm' => 'samm', 'sany' => 'sany', 'sava' => 'sava', 'scoo' => 'scoo', 'send' => 'send', 'siem' => 'siem', 'smar' => 'smar', 'smit' => 'smit', 'soft' => 'soft', 'sony' => 'sony', 't-mo' => 't-mo', 't218' => 't218', 't250' => 't250', 't600' => 't600', 't610' => 't610', 't618' => 't618', 'tcl-' => 'tcl-', 'tdg-' => 'tdg-', 'telm' => 'telm', 'tim-' => 'tim-', 'ts70' => 'ts70', 'tsm-' => 'tsm-', 'tsm3' => 'tsm3', 'tsm5' => 'tsm5', 'tx-9' => 'tx-9', 'tagt' => 'tagt', 'talk' => 'talk', 'teli' => 'teli', 'topl' => 'topl', 'hiba' => 'hiba', 'up.b' => 'up.b', 'upg1' => 'upg1', 'utst' => 'utst', 'v400' => 'v400', 'v750' => 'v750', 'veri' => 'veri', 'vk-v' => 'vk-v', 'vk40' => 'vk40', 'vk50' => 'vk50', 'vk52' => 'vk52', 'vk53' => 'vk53', 'vm40' => 'vm40', 'vx98' => 'vx98', 'virg' => 'virg', 'vite' => 'vite', 'voda' => 'voda', 'vulc' => 'vulc', 'w3c ' => 'w3c ', 'w3c-' => 'w3c-', 'wapj' => 'wapj', 'wapp' => 'wapp', 'wapu' => 'wapu', 'wapm' => 'wapm', 'wig ' => 'wig ', 'wapi' => 'wapi', 'wapr' => 'wapr', 'wapv' => 'wapv', 'wapy' => 'wapy', 'wapa' => 'wapa', 'waps' => 'waps', 'wapt' => 'wapt', 'winc' => 'winc', 'winw' => 'winw', 'wonu' => 'wonu', 'x700' => 'x700', 'xda2' => 'xda2', 'xdag' => 'xdag', 'yas-' => 'yas-', 'your' => 'your', 'zte-' => 'zte-', 'zeto' => 'zeto', 'acs-' => 'acs-', 'alav' => 'alav', 'alca' => 'alca', 'amoi' => 'amoi', 'aste' => 'aste', 'audi' => 'audi', 'avan' => 'avan', 'benq' => 'benq', 'bird' => 'bird', 'blac' => 'blac', 'blaz' => 'blaz', 'brew' => 'brew', 'brvw' => 'brvw', 'bumb' => 'bumb', 'ccwa' => 'ccwa', 'cell' => 'cell', 'cldc' => 'cldc', 'cmd-' => 'cmd-', 'dang' => 'dang', 'doco' => 'doco', 'eml2' => 'eml2', 'eric' => 'eric', 'fetc' => 'fetc', 'hipt' => 'hipt', 'http' => 'http', 'ibro' => 'ibro', 'idea' => 'idea', 'ikom' => 'ikom', 'inno' => 'inno', 'ipaq' => 'ipaq', 'jbro' => 'jbro', 'jemu' => 'jemu', 'java' => 'java', 'jigs' => 'jigs', 'kddi' => 'kddi', 'keji' => 'keji', 'kyoc' => 'kyoc', 'kyok' => 'kyok', 'leno' => 'leno', 'lg-c' => 'lg-c', 'lg-d' => 'lg-d', 'lg-g' => 'lg-g', 'lge-' => 'lge-', 'libw' => 'libw', 'm-cr' => 'm-cr', 'maui' => 'maui', 'maxo' => 'maxo', 'midp' => 'midp', 'mits' => 'mits', 'mmef' => 'mmef', 'mobi' => 'mobi', 'mot-' => 'mot-', 'moto' => 'moto', 'mwbp' => 'mwbp', 'mywa' => 'mywa', 'nec-' => 'nec-', 'newt' => 'newt', 'nok6' => 'nok6', 'noki' => 'noki', 'o2im' => 'o2im', 'opwv' => 'opwv', 'palm' => 'palm', 'pana' => 'pana', 'pant' => 'pant', 'pdxg' => 'pdxg', 'phil' => 'phil', 'play' => 'play', 'pluc' => 'pluc', 'port' => 'port', 'prox' => 'prox', 'qtek' => 'qtek', 'qwap' => 'qwap', 'rozo' => 'rozo', 'sage' => 'sage', 'sama' => 'sama', 'sams' => 'sams', 'sany' => 'sany', 'sch-' => 'sch-', 'sec-' => 'sec-', 'send' => 'send', 'seri' => 'seri', 'sgh-' => 'sgh-', 'shar' => 'shar', 'sie-' => 'sie-', 'siem' => 'siem', 'smal' => 'smal', 'smar' => 'smar', 'sony' => 'sony', 'sph-' => 'sph-', 'symb' => 'symb', 't-mo' => 't-mo', 'teli' => 'teli', 'tim-' => 'tim-', 'tosh' => 'tosh', 'treo' => 'treo', 'tsm-' => 'tsm-', 'upg1' => 'upg1', 'upsi' => 'upsi', 'vk-v' => 'vk-v', 'voda' => 'voda', 'vx52' => 'vx52', 'vx53' => 'vx53', 'vx60' => 'vx60', 'vx61' => 'vx61', 'vx70' => 'vx70', 'vx80' => 'vx80', 'vx81' => 'vx81', 'vx83' => 'vx83', 'vx85' => 'vx85', 'wap-' => 'wap-', 'wapa' => 'wapa', 'wapi' => 'wapi', 'wapp' => 'wapp', 'wapr' => 'wapr', 'webc' => 'webc', 'whit' => 'whit', 'winw' => 'winw', 'wmlb' => 'wmlb', 'xda-' => 'xda-',
                ], true)): // check against a list of trimmed user agents to see if we find a match
                $mobile_browser = true; // set mobile browser to true
                $status = 'Mobile matched on in_array';
                break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it
            default:
                $mobile_browser = false; // set mobile browser to false
                $status = 'Desktop / full capability browser';
                break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it
        } // ends the switch

        // tell adaptation services (transcoders and proxies) to not alter the content based on user agent as it's already being managed by this script, some of them suck though and will disregard this....
        // header('Cache-Control: no-transform'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
        // header('Vary: User-Agent, Accept'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies

        // if redirect (either the value of the mobile or desktop redirect depending on the value of $mobile_browser) is true redirect else we return the status of $mobile_browser
        if ($redirect = (true == $mobile_browser) ? $mobileredirect : $desktopredirect) {
            header('Location: ' . $redirect); // redirect to the right url for this device
            exit;
        }
        // a couple of folkas have asked about the status - that's there to help you debug and understand what the script is doing
        if ('' == $mobile_browser) {
            return $mobile_browser; // will return either true or false
        }

        return [$mobile_browser, $status]; // is a mobile so we are returning an array ['0'] is true ['1'] is the $status value
    } // ends function mobile_device_detect

}
