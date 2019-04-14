<?php
include_once 'tadtools_header.php';
include_once 'jquery.php';
include_once 'include/beforeheader.php';
get_bootstrap();

//路徑導覽，需搭配 get_模組_cate_path($分類編號);
if (!function_exists('tad_breadcrumb')) {
    function tad_breadcrumb($cate_sn = '0', $cate_path_array = [], $url_page = 'index.php', $page_cate_name = 'csn', $cate_title_name = 'title', $last = '')
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
        </ul>
    ";

        return $main;
    }
}

if (!function_exists('setup_meta')) {
    function setup_meta($title = '', $content = '', $image = '')
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
}

//解決 basename 抓不到中文檔名的問題
if (!function_exists('get_basename')) {
    function get_basename($filename)
    {
        $filename = preg_replace('/^.+[\\\\\\/]/', '', $filename);
        $filename = rtrim($filename, '/');

        return $filename;
    }
}

if (!function_exists('html5')) {
    function html5($content = '', $ui = false, $bootstrap = true, $bootstrap_version = 3, $use_jquery = true, $container = 'container')
    {
        $jquery = '';
        if ($use_jquery) {
            $jquery = get_jquery($ui, true);
        }

        $bootstrap_link = $bootstrap ? "<link rel='stylesheet' type='text/css' media='all' href='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/css/bootstrap.css' />" : '';

        $main = "<!DOCTYPE html>\n";
        $main .= "<html lang='zh-TW'>\n";
        $main .= "<head>\n";
        $main .= "  <meta charset='utf-8'>\n";
        $main .= "  <title></title>\n";
        $main .= "  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
        $main .= "  $bootstrap_link\n";
        $main .= "  {$jquery}\n";
        $main .= "</head>\n";
        $main .= "<body>\n";
        $main .= "    <div class='$container'>\n";
        $main .= "        <div class='row'>\n";
        $main .= "            <div class='col-sm-12'>\n";
        $main .= "                {$content}\n";
        $main .= "            </div>\n";
        $main .= "        </div>\n";
        $main .= "    </div>\n";
        $main .= "</body>\n";
        $main .= "</html>\n";

        return $main;
    }
}

//自訂錯誤訊息
if (!function_exists('web_error')) {
    function web_error($sql, $file = '', $line = '')
    {
        global $xoopsDB, $xoopsModule, $xoopsUser;
        $isAdmin = ($xoopsUser and $xoopsModule) ? $xoopsUser->isAdmin($xoopsModule->mid()) : false;

        $in_admin = (false !== mb_strpos($_SERVER['PHP_SELF'], '/admin/')) ? true : false;
        $main = '<h1>' . _TAD_OOPS_SOMETHING_WRONG . '</h1>';

        if ($isAdmin or $in_admin) {
            $main .= "<div class='well'>{$sql}</div>";
        }

        $show_position = ($file) ? "<br>{$file}:{$line}" : '';
        $main .= "<div class='alert alert-danger'>" . $xoopsDB->error() . $show_position . "</div><div class='text-center'><a href='javascript:history.go(-1);' class='btn btn-primary'>" . _TAD_BACK_PAGE . '</a></div>';

        die(html5($main));
    }
}

//載入 bootstrap，目前僅後台用得到
function get_bootstrap($mode = '')
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
                    // $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/bootstrap3/css/bootstrap.css');
                    // $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
                    // $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/' . $tt_bootstrap_color . '/bootstrap.min.css');
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
if (!function_exists('get_xoops_url')) {
    function get_xoops_url()
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
}

//自動取得實體位置
if (!function_exists('get_xoops_path')) {
    function get_xoops_path()
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
}

//自動轉連結
if (!function_exists('autolink')) {
    function autolink(&$text, $target = '_blank', $nofollow = true)
    {
        // grab anything that looks like a URL...
        $urls = _autolink_find_URLS($text);
        if (!empty($urls)) {
            // i.e. there were some URLS found in the text
            array_walk($urls, '_autolink_create_html_tags', ['target' => $target, 'nofollow' => $nofollow]);
            $text = strtr($text, $urls);
        }

        return $text;
    }

    function _autolink_find_URLS($text)
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

    function _autolink_create_html_tags(&$value, $key, $other = null)
    {
        $target = $nofollow = null;
        if (is_array($other)) {
            $target = ($other['target'] ? " target=\"$other[target]\"" : null);
            // see: http://www.google.com/googleblog/2005/01/preventing-comment-spam.html
            $nofollow = ($other['nofollow'] ? ' rel="nofollow"' : null);
        }
        $value = "<a href=\"$key\"$target$nofollow>$key</a>";
    }
}

//推文工具
if (!function_exists('push_url')) {
    function push_url($enable = 1, $css = 'width:auto;margin:10px;float:right;')
    {
        global $xoopsConfig;
        if (!$enable) {
            return;
        }
        $jquery = get_jquery();
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
}

//facebook的留言
if (!function_exists('facebook_comments')) {
    function facebook_comments($facebook_comments_width = 600, $modules = '', $page = '', $col_name = '', $col_sn = '')
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
}

//產生QR Code
if (!function_exists('mk_qrcode')) {
    function mk_qrcode($url)
    {
        $imgurl = mk_qrcode_name($url);
        mk_dir(XOOPS_ROOT_PATH . '/uploads/qrcode');
        if (!file_exists(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif")) {
            include_once 'qrcode/qrcode.php';
            $url = chk_qrcode_url($url);
            $a = new QR("{$_SERVER['HTTP_HOST']}{$url}");
            //die(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif");
            file_put_contents(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif", $a->image(2));
        }
    }
}

//產生QR Code檔案的名稱
if (!function_exists('mk_qrcode_name')) {
    function mk_qrcode_name($url = '')
    {
        $url = chk_qrcode_url($url);
        $imgurl = str_replace(XOOPS_URL, '', $url);
        $imgurl = str_replace('modules/', '', $imgurl);
        $imgurl = str_replace('/', '_', $imgurl);
        $imgurl = str_replace('.', '_', $imgurl);
        $imgurl = str_replace('?', '_', $imgurl);
        $imgurl = str_replace('&', '_', $imgurl);
        $imgurl = str_replace('=', '_', $imgurl);

        return $imgurl;
    }
}

if (!function_exists('chk_qrcode_url')) {
    function chk_qrcode_url($url)
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
}

//單選回復原始資料函數
if (!function_exists('chk')) {
    function chk($DBV = null, $NEED_V = '', $defaul = '', $return = "checked='checked'")
    {
        if ($DBV == $NEED_V) {
            return $return;
        } elseif (empty($DBV) && '1' == $defaul) {
            return $return;
        }

        return '';
    }
}

//複選回復原始資料函數
if (!function_exists('chk2')) {
    function chk2($default_array = '', $NEED_V = '', $default = 0)
    {
        if (in_array($NEED_V, $default_array, true)) {
            return 'checked';
        } elseif (empty($default_array) && '1' == $default) {
            return 'checked';
        }

        return '';
    }
}

//細部權限判斷
if (!function_exists('power_chk')) {
    function power_chk($perm_name = '', $sn = '')
    {
        global $xoopsUser, $xoopsModule;
        if (!$xoopsModule) {
            return;
        }

        // echo var_export($perm_name);
        // echo var_export($sn);

        //取得目前使用者的群組編號
        if ($xoopsUser) {
            $groups = $xoopsUser->getGroups();
        } else {
            $groups = XOOPS_GROUP_ANONYMOUS;
        }
        // echo var_export($groups);
        //取得模組編號
        $module_id = $xoopsModule->mid();
        if (empty($perm_name)) {
            $perm_name = $xoopsModule->dirname();
        }
        // echo var_export($module_id);
        //取得群組權限功能
        $gperm_handler = xoops_getHandler('groupperm');

        //權限項目編號
        $perm_itemid = (int) $sn;
        // echo var_export($perm_itemid);
        //依據該群組是否對該權限項目有使用權之判斷 ，做不同之處理
        if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id)) {
            // die('true');
            return true;
        }
        // die('false');
        return false;
    }
}

//把字串換成群組
if (!function_exists('txt_to_group_name')) {
    function txt_to_group_name($enable_group = '', $default_txt = '', $syb = '<br />')
    {
        $groups_array = get_all_groups();
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
}

//取得所有群組
if (!function_exists('get_all_groups')) {
    function get_all_groups()
    {
        global $xoopsDB;
        $sql = 'select groupid,name from ' . $xoopsDB->prefix('groups') . '';
        $result = $xoopsDB->query($sql);
        while (list($groupid, $name) = $xoopsDB->fetchRow($result)) {
            $data[$groupid] = $name;
        }

        return $data;
    }
}

//輸出為UTF8
if (!function_exists('to_utf8')) {
    function to_utf8($buffer = '')
    {
        if (_CHARSET === 'UTF-8') {
            return $buffer;
        }
        $buffer = (!function_exists('mb_convert_encoding')) ? iconv('Big5', 'UTF-8', $buffer) : mb_convert_encoding($buffer, 'UTF-8', 'Big5');

        return $buffer;
    }
}

//判斷字串是否為utf8
if (!function_exists('is_utf8')) {
    function is_utf8($str)
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
}

//轉換編碼 （_CHARSET 在後面時，$OS2Web 為 true，預設）
if (!function_exists('auto_charset')) {
    function auto_charset($str = '', $OS_or_Web = 'web')
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
}

//亂數字串
if (!function_exists('randStr')) {
    function randStr($len = 6, $format = 'ALL')
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
}

//建立目錄
if (!function_exists('mk_dir')) {
    function mk_dir($dir = '')
    {
        //若無目錄名稱秀出警告訊息
        if (empty($dir)) {
            redirect_header('index.php', 3, _TAD_NO_DIRNAME);
        }

        //若目錄不存在的話建立目錄
        if (!is_dir($dir)) {
            umask(000);
            //若建立失敗秀出警告訊息
            if (!mkdir($dir, 0777) && !is_dir($dir)) {
                redirect_header('index.php', 3, sprintf(_TAD_MKDIR_ERROR, $dir));
            }
        }
    }
}

//刪除整個目錄
if (!function_exists('rrmdir')) {
    function rrmdir($path)
    {
        return is_file($path) ?
        @unlink($path) :
        array_map('rrmdir', glob($path . '/*')) == @rmdir($path)
        ;
    }
}
//取得分頁工具
if (!function_exists('getPageBar')) {
    function getPageBar($sql = '', $show_num = 20, $page_list = 10, $to_page = '', $url_other = '', $bootstrap = '3')
    {
        global $xoopsDB;
        //die('PHP_SELF:'.$_SERVER['PHP_SELF']);
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

        $navbar = new PageBar($total, $show_num, $page_list);

        if (!empty($to_page)) {
            $navbar->set_to_page($to_page);
        }

        if (!empty($url_other)) {
            $navbar->set_url_other($url_other);
        }

        if ('3' == $bootstrap or '4' == $bootstrap) {
            $mybar = $navbar->makeBootStrap3Bar('', $bootstrap);
            $main['bar'] = "
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='text-center'>
                            <nav>
                                <ul class='pagination justify-content-center'>
                                {$mybar['left']}
                                {$mybar['center']}
                                {$mybar['right']}
                                </ul>
                            </nav>
                        </div>
                    </div>
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
}

//分頁物件
if (!class_exists('PageBar')) {
    class PageBar
    {
        // 目前所在頁碼
        public $current;
        // 所有的資料數量 (rows)
        public $total;
        // 每頁顯示幾筆資料
        public $limit = 10;
        // 目前在第幾層的頁數選項？
        public $pCurrent;
        // 總共分成幾頁？
        public $pTotal;
        // 每一層最多有幾個頁數選項可供選擇，如：3 = {[1][2][3]}
        public $pLimit;
        public $prev;
        public $next;
        public $prev2;
        public $next2;
        public $prev_layer = ' ';
        public $next_layer = ' ';
        public $first;
        public $last;
        public $first2;
        public $last2;
        public $bottons = [];
        // 要使用的 URL 頁數參數名？
        public $url_page = 'g2p';
        // 會使用到的 URL 變數名，給 process_query() 過濾用的。
        public $used_query = [];
        // 目前頁數顏色
        public $act_color = '#990000';
        public $query_str; // 存放 URL 參數列
        //指定頁面
        public $to_page;
        //其他連結參數
        public $url_other;

        public function __construct($total, $limit, $page_limit)
        {
            $limit = (int) $limit;
            //die(var_export($limit));
            $mydirname = basename(__DIR__);
            $this->prev = "<img src='" . TADTOOLS_URL . "/images/1leftarrow.png' alt='" . _TAD_BACK_PAGE . "' align='absmiddle' hspace=3>";
            $this->next = "<img src='" . TADTOOLS_URL . "/images/1rightarrow.png' alt='" . _TAD_NEXT_PAGE . "' align='absmiddle' hspace=3>";
            $this->first = "<img src='" . TADTOOLS_URL . "/images/2leftarrow.png' alt='" . _TAD_FIRST_PAGE . "' align='absmiddle' hspace=3>";
            $this->last = "<img src='" . TADTOOLS_URL . "/images/2rightarrow.png' alt='" . _TAD_LAST_PAGE . "' align='absmiddle' hspace=3>";
            $this->prev2 = "<img src='" . TADTOOLS_URL . "/images/1leftarrow_g.png' alt='" . _TAD_BACK_PAGE . "' align='absmiddle' hspace=3>";
            $this->next2 = "<img src='" . TADTOOLS_URL . "/images/1rightarrow_g.png' alt='" . _TAD_NEXT_PAGE . "' align='absmiddle' hspace=3>";
            $this->first2 = "<img src='" . TADTOOLS_URL . "/images/2leftarrow_g.png' alt='" . _TAD_FIRST_PAGE . "' align='absmiddle' hspace=3>";
            $this->last2 = "<img src='" . TADTOOLS_URL . "/images/2rightarrow_g.png' alt='" . _TAD_LAST_PAGE . "' align='absmiddle' hspace=3>";
            $this->to_page = $_SERVER['PHP_SELF'];
            $this->limit = $limit;
            $this->total = $total;
            $this->pLimit = $page_limit;
        }

        public function init()
        {
            $this->used_query = [$this->url_page];
            $this->query_str = $this->processQuery($this->used_query);
            $this->glue = ('' == $this->query_str) ? '?' : '&';

            $this->current = (isset($_GET[$this->url_page])) ? (int) $_GET[$this->url_page] : 1;
            if ($this->current < 1) {
                $this->current = 1;
            }

            $this->pTotal = ceil($this->total / $this->limit);
            $this->pCurrent = ceil($this->current / $this->pLimit);
        }

        //初始設定
        public function set($active_color = 'none', $buttons = 'none')
        {
            if ('none' !== $active_color) {
                $this->act_color = $active_color;
            }

            if ('none' !== $buttons) {
                $this->buttons = $buttons;
                $this->prev = $this->buttons['prev'];
                $this->next = $this->buttons['next'];
                $this->prev_layer = $this->buttons['prev_layer'];
                $this->next_layer = $this->buttons['next_layer'];
                $this->first = $this->buttons['first'];
                $this->last = $this->buttons['last'];
                $this->prev2 = $this->buttons['prev'];
                $this->next2 = $this->buttons['next'];
                $this->first2 = $this->buttons['first'];
                $this->last2 = $this->buttons['last'];
            }
        }

        // 處理 URL 的參數，過濾會使用到的變數名稱
        public function processQuery($used_query)
        {
            // 將 URL 字串分離成二維陣列
            $QUERY_STRING = htmlspecialchars($_SERVER['QUERY_STRING']);
            $vars = explode('&', $QUERY_STRING);
            //die(var_export($vars));
            for ($i = 0; $i < count($vars); $i++) {
                if ('amp;g2p' === mb_substr($vars[$i], 0, 7)) {
                    continue;
                }

                //echo substr($vars[$i],0,7)."<br>";
                $var[$i] = explode('=', $vars[$i]);
            }

            // 過濾要使用的 URL 變數名稱
            for ($i = 0; $i < count($var); $i++) {
                for ($j = 0; $j < count($used_query); $j++) {
                    if (isset($var[$i][0]) && $var[$i][0] == $used_query[$j]) {
                        $var[$i] = [];
                    }
                }
            }

            $vars = [];
            // 合併變數名與變數值
            for ($i = 0; $i < count($var); $i++) {
                $vars[$i] = implode('=', $var[$i]);
            }

            // 合併為一完整的 URL 字串
            $processed_query = '';
            for ($i = 0; $i < count($vars); $i++) {
                $glue = ('' == $processed_query) ? '?' : '&';
                // 開頭第一個是 '?' 其餘的才是 '&'
                if ('' != $vars[$i]) {
                    $processed_query .= $glue . $vars[$i];
                }
            }

            return $processed_query;
        }

        // 製作 sql 的 query 字串 (LIMIT)
        public function sqlQuery()
        {
            $row_start = ($this->current * $this->limit) - $this->limit;
            $sql_query = " LIMIT {$row_start}, {$this->limit}";

            return $sql_query;
        }

        public function set_to_page($page = '')
        {
            $this->to_page = $page;
        }

        public function set_url_other($other = '')
        {
            $this->url_other = $other;
        }

        // 製作 bar
        public function makeBar($url_page = 'none')
        {
            if ('none' !== $url_page) {
                $this->url_page = $url_page;
            }
            $this->init();

            // 取得目前時間
            $loadtime = $this->url_other;

            // 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
            $i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

            $bar_center = '';
            while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)) {
                if ($i == $this->current) {
                    $bar_center = "{$bar_center}<span color='{$this->act_color}' style='border:1px solid #660000;background-color:#660000;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>&nbsp;{$i}&nbsp;</span>";
                } else {
                    $bar_center .= " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'  style='border:1px solid silver;background-color:white;color:#666666;text-align:center;padding:3px;margin:1px;line-height:100%;'>&nbsp;{$i}&nbsp;</a> ";
                }
                $i++;
            }
            $bar_center = $bar_center . '';

            // 往前跳一頁
            if ($this->current <= 1) {
                //$bar_left=$bar_first="";
                $bar_left = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->prev2}</span>";
                $bar_first = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->first2}</span>";
            } else {
                $i = $this->current - 1;
                $bar_left = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_BACK_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->prev}</a> ";
                $bar_first = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='" . _TAD_FIRST_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->first}</a> ";
            }

            // 往後跳一頁
            if ($this->current >= $this->pTotal) {
                //$bar_right=$bar_last="";
                $bar_right = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->next2}</span>";
                $bar_last = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->last2}</span>";
            } else {
                $i = $this->current + 1;
                $bar_right = "<a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_NEXT_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->next}</a> ";
                $bar_last = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='" . _TAD_LAST_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->last}</a> ";
            }

            // 往前跳一整個頁框(層)
            if (($this->current - $this->pLimit) < 1) {
                $bar_l = " {$this->prev_layer} ";
            } else {
                $i = $this->current - $this->pLimit;
                $bar_l = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . sprintf($this->pLimit, _TAD_GO_BACK_PAGE) . "' style=''>{$this->prev_layer}</a> ";
            }

            //往後跳一整個頁框(層)
            if (($this->current + $this->pLimit) > $this->pTotal) {
                $bar_r = " {$this->next_layer} ";
            } else {
                $i = $this->current + $this->pLimit;
                $bar_r = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . sprintf($this->pLimit, _TAD_GO_NEXT_PAGE) . "' style=''>{$this->next_layer}</a> ";
            }

            $page_bar['center'] = $bar_center;
            $page_bar['left'] = $bar_first . $bar_l . $bar_left;
            $page_bar['right'] = $bar_right . $bar_r . $bar_last;
            $page_bar['current'] = $this->current;
            $page_bar['total'] = $this->pTotal;
            $page_bar['sql'] = $this->sqlQuery();

            return $page_bar;
        }

        // 製作 bar
        public function makeBootStrap3Bar($url_page = 'none', $bootstrap = 3)
        {
            if ('none' !== $url_page and '' != $url_page) {
                $this->url_page = $url_page;
            }
            $this->init();

            // 取得目前時間
            $loadtime = $this->url_other;

            // 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
            $i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

            $bar_center = '';
            while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)) {
                if ($i == $this->current) {
                    $bar_center = "
                        {$bar_center}
                        <li class='page-item active'>
                            <a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'>{$i}<span class='sr-only'>(current)</span></a>
                        </li>";
                } else {
                    $bar_center .= "
                        <li class='page-item'>
                            <a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'>{$i}</a>
                        </li>";
                }
                $i++;
            }
            $bar_center = $bar_center . '';

            // 往前跳一頁
            if ($this->current <= 1) {
                //$bar_left=$bar_first="";
                $bar_left = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&lsaquo;</a></li>";
                $bar_first = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&laquo;</a></li>";
            } else {
                $i = $this->current - 1;
                $bar_left = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_BACK_PAGE . "'>&lsaquo;</a></li>";
                $bar_first = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='" . _TAD_FIRST_PAGE . "' >&laquo;</a></li>";
            }

            // 往後跳一頁
            if ($this->current >= $this->pTotal) {
                //$bar_right=$bar_last="";
                $bar_right = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&rsaquo;</a></li>";
                $bar_last = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&raquo;</a></li>";
            } else {
                $i = $this->current + 1;
                $bar_right = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_NEXT_PAGE . "'>&rsaquo;</a></li>";
                $bar_last = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='" . _TAD_LAST_PAGE . "' >&raquo;</a></li>";
            }

            // 往前跳一整個頁框(層)
            if (($this->current - $this->pLimit) < 1) {
                $bar_l = '';
            } else {
                $i = $this->current - $this->pLimit;
                $bar_l = '';
            }

            //往後跳一整個頁框(層)
            if (($this->current + $this->pLimit) > $this->pTotal) {
                $bar_r = '';
            } else {
                $i = $this->current + $this->pLimit;
                $bar_r = '';
            }

            $page_bar['center'] = $bar_center;
            $page_bar['left'] = $bar_first . $bar_l . $bar_left;
            $page_bar['right'] = $bar_right . $bar_r . $bar_last;
            $page_bar['current'] = $this->current;
            $page_bar['total'] = $this->pTotal;
            $page_bar['sql'] = $this->sqlQuery();

            return $page_bar;
        }
    }
}

if (!function_exists('toolbar_bootstrap')) {
    function toolbar_bootstrap($interface_menu = [])
    {
        global $xoopsUser, $xoopsModule;

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

        if (empty($interface_menu)) {
            return;
        }

        make_menu_json($interface_menu, $moduleName);

        get_jquery();

        $options = "<li><a href='index.php' title='" . _TAD_HOME . "'><i class='fa fa-home'></i></a></li>";
        if (is_array($interface_menu)) {
            $basename = basename($_SERVER['SCRIPT_NAME']);
            if (1 == count($interface_menu) and 'index.php' === mb_substr($_SERVER['REQUEST_URI'], -9)) {
                return;
            }

            foreach ($interface_menu as $title => $url) {
                if ('admin/index.php' === mb_substr($url, -15) or 'admin/main.php' === mb_substr($url, -14)) {
                    continue;
                }

                $urlPath = (empty($moduleName) or 'http://' === mb_substr($url, 0, 7)) ? $url : XOOPS_URL . "/modules/{$moduleName}/{$url}";
                // $urlPath = $url;
                // $baseurl = basename($url);
                //if($baseurl=="index.php" and !preg_match("/admin/", $url))continue;
                // die($_SERVER['PHP_SELF']);
                if (false !== mb_strpos($_SERVER['REQUEST_URI'], $url)) {
                    $active = "class='current'";
                } elseif (false !== mb_strpos($_SERVER['SCRIPT_NAME'], $url)) {
                    $active = "class='current'";
                } else {
                    $active = '';
                }
                // $active = strpos($_SERVER['SCRIPT_NAME'], $url) !== false ? "class='current'" : "";
                $options .= "
                  <li {$active}><a href='{$urlPath}'>{$title}</a></li>
                ";
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

        <div class='row'>
          <div class='col-sm-12'>
            <nav class='toolbar_bootstrap_nav'>
              <ul>
                $options
              </ul>
            </nav>
          </div>
        </div>";

        return $main;
    }
}

if (!function_exists('make_menu_json')) {
    function make_menu_json($interface_menu = [], $moduleName = '')
    {
        $json = json_encode($interface_menu);
        $filename = XOOPS_ROOT_PATH . "/uploads/menu_{$moduleName}.txt";
        file_put_contents($filename, $json);
    }
}
