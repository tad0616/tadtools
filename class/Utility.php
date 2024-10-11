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
    public static $fonts = [
        '851DianJiWenZiTi' => '851電機文字',
        'Bakudai' => '莫大毛筆字體',
        'BoTa' => '波塔',
        'BpmfGenRyuMin-B' => '源流注音明體-粗體',
        'BpmfGenRyuMin-R' => '源流注音明體',
        'BpmfGenSekiGothic-B' => '源石注音黑體-粗體',
        'BpmfGenSekiGothic-R' => '源石注音黑體',
        'BpmfGenSenRounded-B' => '源泉注音圓體-粗體',
        'BpmfGenSenRounded-R' => '源泉注音圓體',
        'BpmfGenWanMin-R' => '源雲注音明體',
        'BpmfGenYoGothic-B' => '源樣注音黑體-粗體',
        'BpmfGenYoGothic-R' => '源樣注音黑體',
        'BpmfGenYoMin-B' => '源樣注音明體-粗體',
        'BpmfGenYoMin-R' => '源樣注音明體',
        'BpmfZihiKaiStd-Regular' => '字嗨注音標楷',
        'BpmfZihiSans-Bold' => '字嗨注音黑體-粗體',
        'BpmfZihiSans-Regular' => '字嗨注音黑體',
        'BpmfZihiSerif-Bold' => '字嗨注音宋體-粗體',
        'BpmfZihiSerif-Regular' => '字嗨注音宋體',
        'Chalk' => '粉筆體',
        'ChaoJiXi' => '超級細ゴシック體',
        'CorpRound' => '公司LOGO圓體',
        'Crayon' => '黑板粉筆體',
        'Cubic' => '俐方體11號',
        'Doudouziti' => '豆豆體',
        'HanWangFangSongMedium' => '王漢宗中仿宋',
        'HanWangHeiHeavy' => '王漢宗特黑體',
        'HanWangHeiLight' => '王漢宗細黑體',
        'HanWangKaiMediumChuIn' => '王漢宗中楷注音',
        'HanWangKanTan' => '王漢宗勘亭流',
        'HanWangLiSuMedium' => '王漢宗中隸書',
        'HanWangMingBlack' => '王漢宗超明體',
        'HanWangWeBe' => '王漢宗魏碑體',
        'HanWangYenHeavy' => '王漢宗特圓體',
        'HanWangYenLight' => '王漢宗細圓體',
        'HanWangZonYi' => '王漢宗綜藝體',
        'HanZiBiShunZiTi' => '漢字筆順體原版',
        'HengShanMaoBiCaoShu' => '衡山毛筆草書',
        'I-Ngaan' => '刻石錄顏體',
        'I-PenCrane-B' => '刻石錄鋼筆鶴體',
        'Iansui' => '芫荽體',
        'JasonHandwriting1' => '清松手寫體1',
        'JasonHandwriting2' => '清松手寫體2',
        'JasonHandwriting3' => '清松手寫體3',
        'JasonHandwriting4' => '清松手寫體4',
        'JfOpenhuninn' => 'jf open 粉圓體',
        'KaiseiTokumin' => '解星 B',
        'KingnamMaiyuan' => '荊南麥圓體',
        'Kurewa' => '苦累蛙圓體',
        'Mamelon' => 'Mamelon字體',
        'MamelonHi' => 'Mamelon新版字體',
        'MasaFont' => '正風毛筆字體（衡山毛筆行書）',
        'NaikaiFont' => '內海字體',
        'NishikiTeki' => '馬克筆手寫',
        'PangPangZhuRouTi' => '胖胖豬肉體',
        'PoSuiLingHaoZi' => '破碎零號字',
        'PopGothicCjkJp' => '大波浪圓體',
        'QianTuMaKeShouXieTi' => '千圖馬克手寫體',
        'Qiang' => '黒薔薇',
        'QingLiuShu' => '青柳隷書',
        'SuiFengTi ' => '隨峰體',
        'SweiFistLegCJKjp' => '獅尾詠腿黑體',
        'SweiSpringSugarCJKtc' => '獅尾四季春',
        'SweiToothpasteCJKtc' => '獅尾牙膏圓體',
        'TanugoTangGuoShouXieTiBold' => '糖果手寫粗體',
        'TanugoTangGuoShouXieTiRegular' => '糖果手寫體',
        'Tanukimagic' => 'たぬき油性マジック',
        'UzuraZiTi' => '鵪鶉字體',
        'WuXinShouXieTi' => '無心手寫體',
        'XianErTi' => '賢二體',
        'XinYiGuanHeiTi' => '字體圈欣意冠黑體',
        'YOzShouXieTi' => 'YOz手寫體',
        'YingZhuiXingShu' => '英椎行書',
        'YouZi' => '佑字',
        'YuanYingHeiTi' => '源影黑體',
        'ZhaiZaiJiaFenTiaoTian' => '宅在家粉條甜',
        'ZhaiZaiJiaMaiKeBi' => '宅在家麥克筆',
        'ZhaiZaiJiaZiDongBi' => '宅在家自動筆',
        'ZuoZuoMuZiTi' => '佐佐木字體',
    ];

    //建構函數
    public function __construct()
    {
        //建構函數
        self::get_jquery();
        self::get_bootstrap();
    }

    public static function test($var, $v = 1, $mode = 'dd', $key = 'test')
    {
        global $xoopsUser, $xoopsModuleConfig, $xoopsLogger;

        if (isset($xoopsModuleConfig['test_mode']) && $xoopsModuleConfig['test_mode'] && $xoopsUser && !$xoopsUser->isAdmin()) {
            return;
        }

        // error_reporting(0);
        // $xoopsLogger->activated = false;

        if (isset($_GET[$key]) && $_GET[$key] == $v) {
            if ($mode == 'die') {
                die($var);
            } elseif ($mode == 'echo') {
                echo "<div>$var</div>";
            } elseif ($mode == 'var_dump') {
                echo "<pre>" . var_dump($var) . "</pre>";
            } elseif ($mode == 'var_export') {
                echo "<pre>" . var_export($var) . "</pre>";
            } else {
                self::dd($var);
            }
        }
    }

    // 在中文和英文之間自動加入空格
    public static function insert_spacing($str)
    {
        $str = preg_replace('/([\x{4e00}-\x{9fa5}\x{3002}\x{ff1b}\x{ff0c}\x{ff1a}\x{201c}\x{201d}\x{ff08}\x{ff09}\x{3001}\x{ff1f}\x{300a}\x{300b}]+)([A-Za-z0-9]+)/u', '${1} ${2}', $str);
        $str = preg_replace('/([A-Za-z0-9]+)([\x{4e00}-\x{9fa5}\x{3002}\x{ff1b}\x{ff0c}\x{ff1a}\x{201c}\x{201d}\x{ff08}\x{ff09}\x{3001}\x{ff1f}\x{300a}\x{300b}]+)/u', '${1} ${2}', $str);
        return $str;
    }

    // 將網址轉為連結
    public static function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
    {
        $TadToolsXoopsModuleConfig = self::TadToolsXoopsModuleConfig();

        if (!$TadToolsXoopsModuleConfig['linkify']) {
            return $value;
        }

        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
        }

        $links = array();

        if ($TadToolsXoopsModuleConfig['insert_spacing']) {
            $value = self::insert_spacing($value);
        }

        // Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {return '<' . array_push($links, $match[1]) . '>';}, $value);

        // Extract text links for each protocol
        foreach ((array) $protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':$value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                        if ($match[1]) {
                            $protocol = $match[1];
                        }
                        $link = $match[2] ?: $match[3];return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" target=\"_blank\">$protocol://$link</a>") . '>';
                    }, $value);
                    break;
                // case 'mail':$value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) {return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';}, $value);
                //     break;
                // case 'twitter':$value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) {return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\">{$match[0]}</a>") . '>';}, $value);
                //     break;
                default:$value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';}, $value);
                    break;
            }
        }

        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {return $links[$match[1] - 1];}, $value);
    }

    // XOOPS表單安全檢查
    public static function xoops_security_check($file = '', $line = '')
    {
        $where = $file ? "( $file $line )" : "";
        if ($_SERVER['SERVER_ADDR'] != '127.0.0.1' && !$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header($_SERVER['PHP_SELF'], 3, $error . $where);
        }
    }

    //除錯工具
    public static function dd($array = [])
    {
        global $xoopsLogger;
        error_reporting(0);
        $xoopsLogger->activated = false;
        header('HTTP/1.1 200 OK');
        header("Content-Type: application/json; charset=utf-8");
        die(json_encode($array, 256));
    }

    public static function add_migrate($mode = "")
    {
        // global $xoTheme;
        // self::get_jquery();
        // // $ver = self::get_version('xoops');
        // if ($mode == "return") {
        //     if ($_SESSION['xoops_version'] < 20509) {
        //         return "<script src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-migrate-1.4.1.min.js'></script>";
        //     } else {
        //         return "<script src='" . XOOPS_URL . "/modules/tadtools/jquery/jquery-migrate-3.0.0.min.js'></script>";
        //     }
        // } else {
        //     if ($_SESSION['xoops_version'] < 20509) {
        //         $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
        //     } else {
        //         $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
        //     }
        // }
    }

    //版本判斷
    public static function get_version($type = 'xoops', $ver = '', $dirname = '')
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
                if (strpos($version[2], 'Beta') !== false) {
                    $version[2] = intval($version[2]) - 1;
                }
                break;

            case 'php':
                if (empty($ver)) {
                    $ver = PHP_VERSION;
                }
                $version = explode('.', $ver);
                break;

            case 'theme':
                if (empty($ver)) {
                    $ver = self::get_theme_version($dirname);
                }
                $version = explode('.', $ver);
                break;

            case 'adm_tpl':
                if (empty($ver)) {
                    $ver = file_get_contents(XOOPS_ROOT_PATH . "/modules/system/themes/{$dirname}/version.txt");
                }
                $version = explode('.', $ver);
                break;

            default:
                if (empty($ver)) {
                    $sql = 'SELECT `version` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `dirname` = ?';
                    $result = Utility::query($sql, 's', [$dirname]) or self::web_error($sql, __FILE__, __LINE__);

                    list($ver) = $xoopsDB->fetchRow($result);
                    if (strpos($ver, '-') === false) {
                        if (strpos($ver, '.') !== false) {
                            for ($i = 0; $i < strlen($ver); $i++) {
                                $version[] = substr($ver, $i, 1);
                            }
                        } else {

                            for ($i = 0; $i < strlen($ver); $i++) {
                                $version[] = substr($ver, $i, 1);
                            }
                        }
                    } else {
                        list($version, $version_status) = explode('-', $ver);
                        $version = explode('.', $version);
                    }
                } else {
                    if (strpos($ver, '-') === false) {
                        if (strpos($ver, '.') !== false) {
                            $v = explode('.', $ver);
                            $version[] = $v[0];
                            for ($i = 0; $i < strlen($v[1]); $i++) {
                                $version[] = substr($v[1], $i, 1);
                            }
                        } else {

                            for ($i = 0; $i < strlen($ver); $i++) {
                                $version[] = substr($ver, $i, 1);
                            }
                        }
                    } else {
                        list($version, $version_status) = explode('-', $ver);
                        $version = explode('.', $version);
                    }

                }
                break;
        }

        $int_version = (int) $version[0] * 10000 + (int) $version[1] * 100 + (int) $version[2];
        return $int_version;

    }

    public static function get_theme_version($dirname)
    {
        $handle = @fopen(XOOPS_ROOT_PATH . "/themes/{$dirname}/theme.ini", "r");
        $version = '';
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $ini = explode("=", $buffer);
                if (trim($ini[0]) == "Version") {
                    $version = str_replace("\"", "", trim($ini[1]));
                    break;
                }
            }
            fclose($handle);
        }

        // 2.4
        return $version;

    }

    // 格式化版本
    public static function version_format($type = 'xoops', $ver = '', $my_xoops_version = '')
    {
        if (empty($ver) and empty($type)) {
            return;
        }

        if (empty($my_xoops_version)) {
            $my_xoops_version = self::get_version('xoops');
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
                $v[0] = (int) substr($ver, 0, -4);
                $v[1] = (int) substr($ver, -4, -2);
                $v[2] = (int) substr($ver, -2);

                if ($my_xoops_version <= 20510) {
                    $version = $v[0] . '.' . $v[1] . $v[2];
                } else {
                    $version = implode('.', $v);
                }

        }

        return $version;

    }

    //建立目錄
    public static function mk_dir($dir = '')
    {
        //若無目錄名稱秀出警告訊息
        if (empty($dir)) {
            return;
        }
        $source_dir = $dir;

        $dir = \str_replace([XOOPS_ROOT_PATH, XOOPS_VAR_PATH], '', $dir);
        $dir_path = explode('/', $dir);
        $mk_dir = strpos($source_dir, XOOPS_VAR_PATH) !== false ? XOOPS_VAR_PATH : XOOPS_ROOT_PATH;

        foreach ($dir_path as $i => $sub_dir) {
            $mk_dir .= $i > 0 ? "/{$sub_dir}" : $sub_dir;

            //若目錄不存在的話建立目錄
            if ($mk_dir != '' && !is_dir($mk_dir)) {
                umask(000);
                //若建立失敗秀出警告訊息
                if (!mkdir($mk_dir, 0777) && !is_dir($mk_dir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $mk_dir));
                }
            }
        }
        return $source_dir;
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

        return rmdir($dirname);
    }

    //拷貝目錄
    public static function full_copy($source = '', $dest = '', $overwrite = true)
    {

        // 檢查來源資料夾是否存在
        if (!is_dir($source)) {
            return false;
        }

        // 確保目標資料夾存在,否則創建它
        if (!is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        // 遍歷來源資料夾中的所有檔案和資料夾
        $files = array_diff(scandir($source), array('.', '..'));
        foreach ($files as $file) {
            $sourceFile = $source . DIRECTORY_SEPARATOR . $file;
            $destFile = $dest . DIRECTORY_SEPARATOR . $file;

            // 如果是資料夾,則遞歸複製
            if (is_dir($sourceFile)) {
                self::full_copy($sourceFile, $destFile, $overwrite);
            } else {
                // 如果是檔案,則複製檔案
                if ($overwrite || !file_exists($destFile)) {
                    copy($sourceFile, $destFile);
                }
            }
        }

        return true;

        // if (is_dir($source)) {
        //     if (!self::mk_dir($target) && !is_dir($target)) {
        //         throw new \RuntimeException(sprintf('Directory "%s" was not created', $target));
        //     }
        //     $d = dir($source);
        //     while (false !== ($entry = $d->read())) {
        //         if ('.' === $entry || '..' === $entry) {
        //             continue;
        //         }

        //         $Entry = $source . '/' . $entry;
        //         if (is_dir($Entry)) {
        //             self::full_copy($Entry, $target . '/' . $entry);
        //             continue;
        //         }
        //         copy($Entry, $target . '/' . $entry);
        //     }
        //     $d->close();
        // } else {
        //     if (\file_exists($source)) {
        //         copy($source, $target);
        //     }
        // }
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
        global $xoTheme;
        if (is_object($xoTheme)) {
            $xoTheme->addStylesheet('modules/tadtools/css/xoops.css');
        }
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
        <nav aria-label='breadcrumb'>
        <ol class='breadcrumb'>
            $item
        </ol>
        </nav>";

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

    public static function html5($content = '', $ui = false, $bootstrap = true, $bootstrap_version = '', $use_jquery = true, $container = 'container', $title = 'XOOPS', $head_code = '', $font_awesome = true, $prism = true)
    {
        $jquery = '';
        if ($use_jquery) {
            $jquery = self::get_jquery($ui, 'return');
        }

        if (empty($bootstrap_version)) {
            $bootstrap_version = $_SESSION['bootstrap'];
        }

        $bootstrap_link = $bootstrap ? "<link rel='stylesheet' type='text/css' media='all' href='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/css/bootstrap.css' />
        <script src='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/js/popper.min.js' crossorigin='anonymous'></script>
        <script src='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/js/bootstrap.js'></script>" : '';
        $font_awesome_link = $font_awesome ? " <link href=\"" . XOOPS_URL . "/modules/tadtools/css/font-awesome/css/font-awesome.css\" rel=\"stylesheet\" media=\"all\">" : '';
        $prism_link = '';
        if ($prism) {
            $prism_link = Utility::prism('return');
        }

        $main = "<!DOCTYPE html>\n";
        $main .= "<html lang='zh-TW'>\n";
        $main .= "<head>\n";
        $main .= "  <meta charset='utf-8'>\n";
        $main .= "  <title>{$title}</title>\n";
        $main .= "  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
        $main .= "  {$jquery}\n";
        $main .= "  $bootstrap_link\n";
        $main .= "  $font_awesome_link\n";
        $main .= "  $prism_link\n";
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
            $main .= "<div class='code'>{$sql}</div>";
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

        $sql = 'SELECT `tt_theme_kind` FROM `' . $xoopsDB->prefix('tadtools_setup') . '` WHERE `tt_theme` = ?';
        $result = Utility::query($sql, 's', [$theme_set]) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error() . '<br>' . __FILE__ . ':' . __LINE__);

        list($tt_theme_kind) = $xoopsDB->fetchRow($result);

        $_SESSION['theme_kind'] = $tt_theme_kind;
        $_SESSION[$theme_set]['bootstrap_version'] = $tt_theme_kind;

        if (strpos((string) isset($tt_theme_kind) ?: '', 'bootstrap') !== false) {
            $_SESSION['bootstrap'] = substr($tt_theme_kind, -1);
        } else {
            $_SESSION['bootstrap'] = '5';
        }

        if ($_COOKIE['bootstrap'] != $_SESSION['bootstrap']) {
            setcookie("bootstrap", $_SESSION['bootstrap']);
        }

        if ($in_admin) {
            if ($xoopsTpl) {
                $xoopsTpl->assign('bootstrap_version', $_SESSION['bootstrap']);
            }

            if ($xoTheme) {
                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/bootstrap{$_SESSION['bootstrap']}/css/bootstrap.css");
                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css");
                // $xoTheme->addStylesheet('modules/tadtools/css/fix-bootstrap.css');
                $xoTheme->addStylesheet('modules/tadtools/css/font-awesome/css/font-awesome.css');
            }
        } elseif ('return' === $mode) {
            $main = "
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/bootstrap{$_SESSION['bootstrap']}/css/bootstrap.css'>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css'>
            // <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/fix-bootstrap.css'>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/font-awesome/css/font-awesome.css'>";

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
        $text = self::autolink($text);
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
        return $text;
    }

    private static function _autolink_find_URLS($text)
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

    private static function _autolink_create_html_tags($value, $key, $other = null)
    {
        $target = $nofollow = null;
        if (is_array($other)) {
            $target = ($other['target'] ? " target=\"$other[target]\"" : null);
            $nofollow = ($other['nofollow'] ? ' rel="nofollow"' : null);
        }
        $value = "<a href=\"$key\"$target$nofollow>$key</a>";
    }

    //推文工具
    public static function push_url($enable = 1)
    {
        global $xoopsModuleConfig, $xoTheme;
        if ($enable) {
            if (!isset($xoopsModuleConfig['facebook_app_id'])) {
                $xoopsTadtoolsConfig = self::TadToolsXoopsModuleConfig();
                $facebookAppId = $xoopsTadtoolsConfig['facebook_app_id'];
            } else {
                $facebookAppId = $xoopsModuleConfig['facebook_app_id'];
            }

            // $xoTheme->addStylesheet('modules/tadtools/css/font-awesome/css/font-awesome652.all.min.css');
            $xoTheme->addStylesheet('modules/tadtools/social-likes/social-likes.css');

            $main = "
            <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css\">
            <div class=\"share-buttons\">
                <button onclick=\"share('facebook')\" class=\"facebook\"><i class=\"fa-brands fa-facebook-f\"></i></button>
                <button onclick=\"share('x')\" class=\"x\"><i class=\"fa-brands fa-x-twitter\"></i></button>
                <button onclick=\"share('messenger', '$facebookAppId')\" class=\"messenger\"><i class=\"fa-brands fa-facebook-messenger\"></i></button>
                <button onclick=\"share('pinterest')\" class=\"pinterest\"><i class=\"fa-brands fa-pinterest-p\"></i></button>
                <button onclick=\"share('line')\" class=\"line\"><i class=\"fa-brands fa-line\"></i></button>
            </div>
            <script src='" . XOOPS_URL . "/modules/tadtools/social-likes/social-likes.min.js'></script>
            ";
            return $main;
        }
    }

    //產生QR Code
    public static function mk_qrcode($url)
    {
        $imgurl = self::mk_qrcode_name($url);
        self::mk_dir(XOOPS_ROOT_PATH . '/uploads/qrcode');
        if (!file_exists(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif")) {
            include_once 'qrcode/qrcode.php';
            $url = self::chk_qrcode_url($url);
            $a = new \QR("{$_SERVER['HTTP_HOST']}{$url}");
            //die(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif");
            file_put_contents(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif", $a->image(2));
        }
    }

    //產生QR Code檔案的名稱
    private static function mk_qrcode_name($url = '')
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

    private static function chk_qrcode_url($url)
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
    public static function chk2($default_array = [], $NEED_V = '', $default = 0)
    {
        if (in_array($NEED_V, $default_array)) {
            return 'checked';
        } elseif (empty($default_array) && '1' == $default) {
            return 'checked';
        }

        return '';
    }

    //細部權限判斷
    public static function power_chk($perm_name = '', $perm_itemid = '', $module_id = '', $trueifadmin = true, $mod_name = '')
    {
        global $xoopsUser, $xoopsModule;

        if (!$xoopsModule) {
            $modhandler = xoops_gethandler('module');
            $xoopsModule = $modhandler->getByDirname($mod_name);
        }

        //取得目前使用者的群組編號
        if (!isset($_SESSION['groups']) or $_SESSION['groups'] === '') {
            $_SESSION['groups'] = $xoopsUser ? $xoopsUser->getGroups() : [XOOPS_GROUP_ANONYMOUS];
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
    public static function txt_to_group_name($groupid_txt = '', $default_txt = '', $syb = '<br>')
    {
        $groups_array = self::get_all_groups();
        if (empty($groupid_txt)) {
            $g_txt_all = $default_txt;
        } else {
            $gs = explode(',', $groupid_txt);
            $g_txt = [];
            foreach ($gs as $gid) {
                $g_txt[] = isset($groups_array[$gid]) ? $groups_array[$gid] : '';
            }
            $g_txt_all = implode($syb, $g_txt);
        }

        return $g_txt_all;
    }

    //取得所有群組陣列
    public static function get_all_groups()
    {
        global $xoopsDB;
        $sql = 'SELECT `groupid`,`name` FROM `' . $xoopsDB->prefix('groups') . '`';
        $result = Utility::query($sql);
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

    // 亂數字串生成
    public static function randStr($len = 6, $format = 'ALL')
    {
        // 根據格式選擇字符集
        switch ($format) {
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

        // 從字符集中隨機選擇字符生成字串
        $password = '';
        $charsLen = mb_strlen($chars);

        for ($i = 0; $i < $len; $i++) {
            $password .= mb_substr($chars, random_int(0, $charsLen - 1), 1);
        }

        return $password;
    }

    //刪除整個目錄
    public static function rrmdir($path)
    {
        return is_file($path) ? @unlink($path) : array_map('rrmdir', glob($path . '/*')) == @rmdir($path);
    }

    //取得分頁工具
    public static function getPageBar($sql = '', $show_num = 20, $page_list = 10, $to_page = '', $url_other = '', $bootstrap = '', $g2p_name = 'g2p', $order_sql = '')
    {
        global $xoopsDB;
        if (empty($show_num)) {
            $show_num = 20;
        }

        if (empty($page_list)) {
            $page_list = 10;
        }

        if (empty($bootstrap)) {
            $bootstrap = isset($_SESSION['bootstrap']) ? $_SESSION['bootstrap'] : self::get_bootstrap();
        }

        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 10, $xoopsDB->error() . '<br>' . __FILE__ . ':' . __LINE__ . "<br>$sql");
        $total = $xoopsDB->getRowsNum($result);

        $navbar = new \XoopsModules\Tadtools\PageBar($total, $show_num, $page_list, $order_sql);

        if (!empty($to_page)) {
            $navbar->set_to_page($to_page);
        }

        if (!empty($url_other)) {
            $navbar->set_url_other($url_other);
        }

        if ('gmail' == $bootstrap) {
            $mybar = $navbar->makeBootStrapBar($g2p_name);
            $main['bar'] = "
                <nav class='my-0'>
                    <ul class='pagination justify-content-end justify-content-right align-items-center flex-wrap'>
                    <li>{$mybar['start']}-{$mybar['end']}則（共 {$total} 則）</li>
                    {$mybar['bar_left']}
                    {$mybar['bar_right']}
                    </ul>
                </nav>
                ";
        } elseif ('3' == $bootstrap or '4' == $bootstrap or '5' == $bootstrap) {
            $mybar = $navbar->makeBootStrapBar($g2p_name);
            $main['bar'] = "
                <div class='text-center'>
                    <nav>
                        <ul class='pagination justify-content-center flex-wrap'>
                        {$mybar['left']}
                        {$mybar['center']}
                        {$mybar['right']}
                        </ul>
                    </nav>
                </div>
                ";
        } else {
            $mybar = $navbar->makeBar($g2p_name);
            $main['bar'] = "<div style='text-align:center;margin:4px;'>{$mybar['left']}{$mybar['center']}{$mybar['right']}<div style='zoom:1;clear:both;'></div></div>";
        }

        $main['sql'] = $sql . $mybar['sql'];
        $main['total'] = $total;

        return $main;
    }

    public static function toolbar_bootstrap($interface_menu = [], $force = false, $interface_icon = [])
    {
        global $xoTheme, $xoopsUser, $xoopsModule;

        if (is_object($xoTheme)) {
            $xoTheme->addStylesheet('modules/tadtools/css/xoops.css');
        }
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

        // self::make_menu_json($interface_menu, $moduleName);

        self::get_jquery();

        $options = !in_array('index.php', $interface_menu) ? "<li><a href='index.php' title='" . _TAD_HOME . "'>&#xf015;" : '';

        if (is_array($interface_menu)) {
            $basename = basename($_SERVER['SCRIPT_NAME']);
            if (1 == count($interface_menu) and 'index.php' === mb_substr($_SERVER['REQUEST_URI'], -9)) {
                return;
            }

            foreach ($interface_menu as $title => $url) {
                $urlPath = (empty($moduleName) or 'http' === mb_substr($url, 0, 4)) ? $url : XOOPS_URL . "/modules/{$moduleName}/{$url}";

                if (strpos($url, 'admin/index.php') !== false or strpos($url, 'admin/main.php') !== false) {
                    continue;
                    // } elseif ($url == 'index.php') {
                    //     $options = "<li class='current'><a href='{$urlPath}'>&#xf015; {$title}</a></li>";
                } else {
                    $target = substr($url, 0, 4) == 'http' ? "target='_blank'" : '';

                    if (!empty($op) and false !== strpos($url, "?op=") and false !== strpos($url, "{$basename}?op={$op}")) {
                        $active = "class='current' title='{$_SERVER['SCRIPT_NAME']}?op={$op}=={$url}'";
                    } elseif (false !== strpos($_SERVER['SCRIPT_NAME'], $url)) {
                        $active = "class='current' title='$title'";
                    } else {
                        $active = '';
                    }
                    $icon = isset($interface_icon[$title]) ? "<i class='fa {$interface_icon[$title]}'></i> " : '';
                    $options .= "<li {$active}><a href='{$urlPath}' $target>{$icon}{$title}</a></li>";
                }
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
            // $ver = self::get_version('xoops');
            // Utility::dd($ver);
            $jquery_path = "
                <script type='text/javascript'>
                if(typeof jQuery == 'undefined') {
                document.write(\"<script type='text/javascript' src='" . XOOPS_URL . "/browse.php?Frameworks/jquery/jquery.js'><\/script>\");
                }
                </script>
                $jqueryui_path
                ";

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

    //遠端取得資料
    public static function vita_get_url_content($url)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            $timeout = 5;

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        } elseif (function_exists('file_get_contents')) {
            $file_contents = file_get_contents($url, false, stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]));
        }

        return $file_contents;
    }

    //複製檔案
    public static function copyemz($file1, $file2)
    {
        $contentx = self::vita_get_url_content($file1);
        $openedfile = fopen($file2, 'wb');
        fwrite($openedfile, $contentx);
        fclose($openedfile);
        if (false === $contentx) {
            $status = false;
        } else {
            $status = true;
        }

        return $status;
    }

    // 產生縮圖
    public static function generateThumbnail($imagePath, $imagethumbPath = '', $width = '', $height = '')
    {
        global $xoopsModuleConfig;

        // 檢查文件是否存在
        if (!file_exists($imagePath)) {
            return "{$imagePath} 不存在";
        }

        $width = $width ? $width : (int) $xoopsModuleConfig['image_max_width'];
        $height = $height ? $height : $width;

        // 獲取圖片信息，包括類型、尺寸等
        $imageInfo = getimagesize($imagePath);
        if ($imageInfo[0] > $width || $imageInfo[1] > $height) {

            $imageType = $imageInfo[2];

            // 根據不同的圖片類型，使用不同的函數讀取圖片
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($imagePath);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($imagePath);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($imagePath);
                    break;
                case IMAGETYPE_WEBP:
                    $image = imagecreatefromwebp($imagePath);
                    break;
                default:
                    return "{$imageType} 不支援";
            }

            // 計算縮圖尺寸
            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);
            $scale = min($width / $originalWidth, $height / $originalHeight);
            $newWidth = $originalWidth * $scale;
            $newHeight = $originalHeight * $scale;

            // 創建一個新的圖片，並將原始圖片縮放到新尺寸
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            if (empty($imagethumbPath)) {
                $imagethumbPath = $imagePath;
            }
            // 根據不同的圖片類型，使用不同的函數保存縮圖
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    imagejpeg($newImage, $imagethumbPath, 90);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($newImage, $imagethumbPath);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($newImage, $imagethumbPath);
                    break;
                case IMAGETYPE_WEBP:
                    imagewebp($newImage, $imagethumbPath, 90);
                    break;
            }

            // 釋放圖片資源
            imagedestroy($image);
            imagedestroy($newImage);
        }
        return true;
    }

    //儲存權限
    public static function save_perm($groups, $itemid, $perm_name)
    {
        global $xoopsModule;
        $module_id = $xoopsModule->mid();
        $gpermHandler = xoops_getHandler('groupperm');

        // First, if the permissions are already there, delete them
        $gpermHandler->deleteByModule($module_id, $perm_name, $itemid);

        // Save the new permissions
        if ($groups && \is_array($groups)) {
            if (count($groups) > 0) {
                foreach ($groups as $group_id) {
                    $gpermHandler->addRight($perm_name, $itemid, $group_id, $module_id);
                }
            }
        }
    }

    //取回權限的函數
    public static function get_perm($itemid, $gperm_name)
    {
        global $xoopsModule, $xoopsDB;
        $module_id = $xoopsModule->mid();
        $sql = "SELECT `gperm_groupid` FROM `" . $xoopsDB->prefix("group_permission") . "` WHERE `gperm_modid` = ? AND `gperm_itemid`=? AND `gperm_name`=?";
        $result = Utility::query($sql, 'iis', [$module_id, $itemid, $gperm_name]) or self::web_error($sql, __FILE__, __LINE__);

        while (false !== ($row = $xoopsDB->fetchArray($result))) {
            $data[] = $row['gperm_groupid'];
        }

        return $data;
    }

    //刪除權限的函數
    public static function del_perm($itemid, $gperm_name)
    {
        global $xoopsModule, $xoopsDB;
        $module_id = $xoopsModule->mid();
        $sql = "DELETE FROM `" . $xoopsDB->prefix("group_permission") . "` WHERE `gperm_modid` = ? AND `gperm_itemid`=? AND `gperm_name`=?";
        Utility::query($sql, 'iis', [$module_id, $itemid, $gperm_name]) or self::web_error($sql, __FILE__, __LINE__);

    }

    // 高亮度語法
    public static function prism($mode = '', $line_numbers = false)
    {
        global $xoTheme, $xoopsTpl;
        if ($mode == 'return' || !$xoTheme) {
            return "
            <link type='text/css' rel='stylesheet' href='" . XOOPS_URL . "/modules/tadtools/prism/prism.css'>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/prism/prism.js'></script>
            ";
        } else {
            $xoTheme->addStylesheet('modules/tadtools/prism/prism.css');
            $xoTheme->addScript('modules/tadtools/prism/prism.js');
        }

        if ($line_numbers) {
            $xoopsTpl->assign('prism_setup', 'class="line-numbers"');
        }

    }

    /**
     * 參數化資料庫查詢
     *
     * @param string $sql The SQL query to execute
     * @param string $types The types of the parameters
     * @param array $params The parameters to bind
     * @param bool $throwExceptions Whether to throw exceptions or return false on error
     * @param bool $debug Whether to enable debug mode
     * @return mixed The query result or boolean indicating success/failure
     * @throws Exception
     */
    public static function query($sql, $types = '', array $params = array(), $throwExceptions = true, $debug = true)
    {
        global $xoopsDB;

        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $callerInfo = $backtrace['file'] . ' on line ' . $backtrace['line'];

        try {
            // 驗證參數
            $placeholderCount = substr_count($sql, '?');
            if ($placeholderCount !== count($params)) {
                throw new \Exception("Number of parameters (" . count($params) . ") doesn't match the number of placeholders ({$placeholderCount}) in SQL.");
            }

            if (strlen($types) !== count($params)) {
                throw new \Exception("Length of types string (" . strlen($types) . ") doesn't match the number of parameters (" . count($params) . ").");
            }

            $stmt = $xoopsDB->conn->prepare($sql);
            if ($stmt === false) {
                throw new \Exception("SQL prepare failed: " . $xoopsDB->conn->error);
            }

            if (!empty($params)) {
                $bindParams = array($types);
                foreach ($params as $i => $param) {
                    $bindParams[] = &$params[$i];
                }

                if ($debug) {
                    error_log("Debug: SQL = " . $sql);
                    error_log("Debug: Types = " . $types);
                    error_log("Debug: Params = " . print_r($params, true));
                    error_log("Debug: BindParams = " . print_r($bindParams, true));
                }

                // 使用 Reflection 來檢查 bind_param 方法
                $method = new \ReflectionMethod('mysqli_stmt', 'bind_param');
                $paramCount = $method->getNumberOfParameters();
                if ($debug) {
                    error_log("Debug: bind_param expects {$paramCount} parameters");
                    error_log("Debug: We are providing " . count($bindParams) . " parameters");
                }

                if (!call_user_func_array(array($stmt, 'bind_param'), $bindParams)) {
                    throw new \Exception("Parameter binding failed: " . $stmt->error);
                }
            }

            if (!$stmt->execute()) {
                throw new \Exception("SQL execution failed: " . $stmt->error);
            }

            if (stripos(trim($sql), 'SELECT') === 0 || stripos(trim($sql), 'SHOW') === 0 || stripos(trim($sql), 'DESCRIBE') === 0 || stripos(trim($sql), 'EXPLAIN') === 0 || stripos(trim($sql), 'PRAGMA') === 0) {
                $result = $stmt->get_result();
                if ($result === false) {
                    throw new \Exception("Failed to get result: " . $stmt->error);
                }
                return $result;
            }

            return true;
        } catch (\Exception $e) {
            if ($throwExceptions) {
                throw new \Exception($e->getMessage() . " in $callerInfo");
            }
            error_log("Database query error: " . $e->getMessage() . " in $callerInfo");
            return false;
        } finally {
            if (isset($stmt) && $stmt instanceof \mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    private static function getDefaultValue($type)
    {
        switch ($type) {
            case 'i':
                return 0;
            case 'd':
                return 0.0;
            case 's':
            default:
                return '';
        }
    }
}
