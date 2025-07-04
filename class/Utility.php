<?php
namespace XoopsModules\Tadtools;

require XOOPS_ROOT_PATH . '/modules/tadtools/vendor/autoload.php';
use phpseclib3\Net\SSH2;
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

    public static function test($var, $v = 1, $mode = 'dd', $key = 'test', $force = false)
    {
        global $xoopsUser, $xoopsModuleConfig, $xoopsLogger;

        if (isset($xoopsModuleConfig['test_mode']) && $xoopsModuleConfig['test_mode'] && $xoopsUser && !$xoopsUser->isAdmin()) {
            return;
        }

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
    public static function linkify($value, $protocols = ['http', 'mail'], array $attributes = [])
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

        $links = [];

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
        $xoopsLogger->activated = false;

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
                if (!empty($version[2]) && strpos($version[2], 'Beta') !== false) {
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
                    $sql    = 'SELECT `version` FROM `' . $xoopsDB->prefix('modules') . "` WHERE `dirname` = '$dirname'";
                    $result = $xoopsDB->query($sql) or self::web_error($sql, __FILE__, __LINE__);

                    list($ver) = $xoopsDB->fetchRow($result);
                    if (!empty($ver) && strpos($ver, '-') === false) {
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
                        if ($ver) {
                            list($version, $version_status) = explode('-', $ver);
                            $version                        = explode('.', $version);
                        } else {
                            $version = [];
                        }

                    }
                } else {
                    if (strpos($ver, '-') === false) {
                        if (strpos($ver, '.') !== false) {
                            $v         = explode('.', $ver);
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
                        $version                        = explode('.', $version);
                    }

                }
                break;
        }

        $version[0]  = isset($version[0]) ? $version[0] : 0;
        $version[1]  = isset($version[1]) ? $version[1] : 0;
        $version[2]  = isset($version[2]) ? $version[2] : 0;
        $int_version = (int) $version[0] * 10000 + (int) $version[1] * 100 + (int) $version[2];
        return $int_version;

    }

    public static function get_theme_version($dirname)
    {
        $handle  = @fopen(XOOPS_ROOT_PATH . "/themes/{$dirname}/theme.ini", "r");
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

        $dir      = \str_replace([XOOPS_ROOT_PATH, XOOPS_VAR_PATH], '', $dir);
        $dir_path = explode('/', $dir);
        $mk_dir   = strpos($source_dir, XOOPS_VAR_PATH) !== false ? XOOPS_VAR_PATH : XOOPS_ROOT_PATH;

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
        $files = array_diff(scandir($source), ['.', '..']);
        foreach ($files as $file) {
            $sourceFile = $source . DIRECTORY_SEPARATOR . $file;
            $destFile   = $dest . DIRECTORY_SEPARATOR . $file;

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
                $url    = ($cate_sn == $path_cate_sn) ? "<a href='{$url_page}?{$page_cate_name}={$path_cate_sn}'>{$cate[$cate_title_name]}</a>" : "<a href='{$url_page}?{$page_cate_name}={$path_cate_sn}'>{$cate[$cate_title_name]}</a>";
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
        global $xoopsLogger;
        error_reporting(0);
        header('HTTP/1.1 200 OK');
        $xoopsLogger->activated = false;
        $jquery                 = '';
        if ($use_jquery) {
            $jquery = self::get_jquery($ui, 'return');
        }

        if (empty($bootstrap_version)) {
            $bootstrap_version = $_SESSION['bootstrap'];
        }

        $bootstrap_link = $bootstrap ? "<link rel='stylesheet' type='text/css' media='all' href='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/css/bootstrap.css' />
        <script src='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/js/popper.min.js' crossorigin='anonymous'></script>
        <script src='" . XOOPS_URL . "/modules/tadtools/bootstrap{$bootstrap_version}/js/bootstrap.js'></script>" : '';
        $font_awesome_link = $font_awesome ? " <link href=\"" . XOOPS_URL . "/modules/tadtools/css/fontawesome6/css/all.min.css\" rel=\"stylesheet\" media=\"all\">" : '';
        $prism_link        = '';
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

        // 僅在需要時獲取呼叫者信息
        $backtrace  = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $callerInfo = isset($backtrace[0]) ? $backtrace[0]['file'] . ' on line ' . $backtrace[0]['line'] : '';
        $isAdmin    = ($xoopsUser and $xoopsModule) ? $xoopsUser->isAdmin($xoopsModule->mid()) : false;
        $in_admin   = (false !== mb_strpos($_SERVER['PHP_SELF'], '/admin/')) ? true : false;
        $show_sql   = ($isAdmin or $in_admin or $force) ? "<div style=\"margin-top:4px;border:1px solid pink;padding:4px;border-radius:5px;\">$sql</div>" : '';

        throw new \Exception($xoopsDB->error() . ($callerInfo ? " in {$callerInfo}{$show_sql}" : ''));

    }

    //載入 bootstrap，目前僅後台用得到
    public static function get_bootstrap($mode = '')
    {
        global $xoopsConfig, $xoopsDB, $xoTheme, $xoopsTpl;

        $in_admin = (false !== mb_strpos($_SERVER['PHP_SELF'], '/admin/')) ? true : false;

        $theme_set = $xoopsConfig['theme_set'];

        $sql    = 'SELECT `tt_theme_kind` FROM `' . $xoopsDB->prefix('tadtools_setup') . "` WHERE `tt_theme` = '$theme_set'";
        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error() . '<br>' . __FILE__ . ':' . __LINE__);

        list($tt_theme_kind) = $xoopsDB->fetchRow($result);

        $_SESSION['theme_kind']                    = $tt_theme_kind;
        $_SESSION[$theme_set]['bootstrap_version'] = $tt_theme_kind;

        if (strpos((string) isset($tt_theme_kind) ?: '', 'bootstrap') !== false) {
            $_SESSION['bootstrap'] = substr($tt_theme_kind, -1);
        } else {
            $_SESSION['bootstrap'] = '5';
        }

        if ($in_admin) {
            if ($xoopsTpl) {
                $xoopsTpl->assign('bootstrap_version', $_SESSION['bootstrap']);
            }

            if ($xoTheme) {
                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/bootstrap{$_SESSION['bootstrap']}/css/bootstrap.css");
                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css");
            }
        } elseif ('return' === $mode) {
            $main = "
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/bootstrap{$_SESSION['bootstrap']}/css/bootstrap.css'>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css'>";

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
            $XMPath    = explode('/modules', $_SERVER['SCRIPT_FILENAME']);
            $root_path = $XMPath[0];
        } elseif (preg_match('/\/themes/', $_SERVER['SCRIPT_FILENAME'])) {
            $XMPath    = explode('/themes', $_SERVER['SCRIPT_FILENAME']);
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
        $scheme    = '(http:\/\/|https:\/\/)';
        $www       = 'www\.';
        $ip        = '\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}';
        $subdomain = '[-a-z0-9_]+\.';
        $name      = '[a-z][-a-z0-9]+\.';
        $tld       = '[a-z]+(\.[a-z]{2,2})?';
        $the_rest  = '\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}';
        $pattern   = "$scheme?(?(1)($ip|($subdomain)?$name$tld)|($www$name$tld))$the_rest";

        $pattern = '/' . $pattern . '/is';
        $c       = preg_match_all($pattern, $text, $m);
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
            $target   = ($other['target'] ? " target=\"$other[target]\"" : null);
            $nofollow = ($other['nofollow'] ? ' rel="nofollow"' : null);
        }
        $value = "<a href=\"$key\"$target$nofollow>$key</a>";
    }

    //推文工具
    public static function push_url($enable = 1)
    {
        global $xoopsModuleConfig;
        if ($enable) {
            if (!isset($xoopsModuleConfig['facebook_app_id'])) {
                $xoopsTadtoolsConfig = self::TadToolsXoopsModuleConfig();
                $facebookAppId       = $xoopsTadtoolsConfig['facebook_app_id'];
            } else {
                $facebookAppId = $xoopsModuleConfig['facebook_app_id'];
            }

            $GLOBALS['xoTheme']->addStylesheet('modules/tadtools/css/fontawesome6/css/all.min.css');
            $GLOBALS['xoTheme']->addStylesheet('modules/tadtools/social-likes/social-likes.css');

            $main = "
            <div class='share-buttons'>
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
            $a   = new \QR("{$_SERVER['HTTP_HOST']}{$url}");
            //die(XOOPS_ROOT_PATH."/uploads/qrcode/{$imgurl}.gif");
            file_put_contents(XOOPS_ROOT_PATH . "/uploads/qrcode/{$imgurl}.gif", $a->image(2));
        }
    }

    //產生QR Code檔案的名稱
    private static function mk_qrcode_name($url = '')
    {
        $url    = self::chk_qrcode_url($url);
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
        $url  = "{$var[0]}?{$var2}";

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
            $modhandler  = xoops_gethandler('module');
            $xoopsModule = $modhandler->getByDirname($mod_name);
        }

        //取得目前使用者的群組編號
        $groups = $xoopsUser ? $xoopsUser->getGroups() : [XOOPS_GROUP_ANONYMOUS];

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
        if ($gperm_handler->checkRight($perm_name, $perm_itemid, $groups, $module_id, $trueifadmin)) {
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
            $gs    = explode(',', $groupid_txt);
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
        $sql    = 'SELECT `groupid`,`name` FROM `' . $xoopsDB->prefix('groups') . '`';
        $result = $xoopsDB->query($sql);
        while (list($groupid, $name) = $xoopsDB->fetchRow($result)) {
            $data[$groupid] = $name;
        }

        return $data;
    }

    // 建立群組
    public static function mk_group($name = "")
    {
        global $xoopsDB;
        $sql    = 'SELECT `groupid` FROM `' . $xoopsDB->prefix('groups') . '` WHERE `name`=?';
        $result = Utility::query($sql, 's', [$name]) or Utility::web_error($sql, __FILE__, __LINE__, true);

        list($group_id) = $xoopsDB->fetchRow($result);

        if (empty($group_id)) {
            $sql = 'INSERT INTO `' . $xoopsDB->prefix('groups') . '` (`name`) VALUES(?)';
            Utility::query($sql, 's', [$name]) or Utility::web_error($sql, __FILE__, __LINE__, true);

            //取得最後新增資料的流水編號
            $group_id = $xoopsDB->getInsertId();
        }
        return $group_id;
    }

    //根據名稱找群組編號
    public static function group_id_from_name($name = "")
    {
        global $xoopsDB;
        $sql           = "select `groupid` from `" . $xoopsDB->prefix("groups") . "` where `name`='{$name}'";
        $result        = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($groupid) = $xoopsDB->fetchRow($result);
        return $groupid;
    }

    // 將某人加入群組
    public static function add_user_to_group($uid, $group_id)
    {
        global $xoopsDB;
        $sql = "replace into " . $xoopsDB->prefix("groups_users_link") . " (`groupid`,`uid`) values('$group_id','$uid')";
        $xoopsDB->queryF($sql) or die($sql);
    }

    // 將某人移出群組
    public static function del_user_from_group($uid, $group_id)
    {
        global $xoopsDB;
        $sql = "delete from " . $xoopsDB->prefix("groups_users_link") . " where `groupid`='$group_id' and `uid`='$uid'";
        $xoopsDB->queryF($sql) or die($sql);
    }

    // uid 轉姓名
    public static function get_name_by_uid($uid)
    {
        $uid_name = \XoopsUser::getUnameFromId($uid, 1);
        if (empty($uid_name)) {
            $uid_name = \XoopsUser::getUnameFromId($uid, 0);
        }

        return $uid_name;
    }

    // 產生 token
    public static function token_form($mode = 'assign')
    {
        global $xoopsTpl;
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token      = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        if ($mode == 'assign') {
            $xoopsTpl->assign("token_form", $token_form);
        } else {
            return $token_form;
        }
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
        $i   = 0;
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
        $total  = $xoopsDB->getRowsNum($result);

        $navbar = new \XoopsModules\Tadtools\PageBar($total, $show_num, $page_list, $order_sql);

        if (!empty($to_page)) {
            $navbar->set_to_page($to_page);
        }

        if (!empty($url_other)) {
            $navbar->set_url_other($url_other);
        }

        if ($total > 0) {
            if ('gmail' == $bootstrap) {
                $mybar       = $navbar->makeBootStrapBar($g2p_name);
                $main['bar'] = "
                <nav class='my-0'>
                    <ul class='pagination justify-content-end justify-content-right align-items-center flex-wrap'>
                    <li>{$mybar['start']}-{$mybar['end']}則（共 {$total} 則）</li>
                    {$mybar['bar_left']}
                    {$mybar['bar_right']}
                    </ul>
                </nav>
                ";
            } else {
                $mybar       = $navbar->makeBootStrapBar($g2p_name);
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
            }
        } else {
            $main['bar'] = '';
        }

        $main['sql']   = $sql . $mybar['sql'];
        $main['total'] = $total;

        return $main;
    }

    public static function toolbar_bootstrap($interface_menu = [], $force = false, $interface_icon = [])
    {
        global $xoTheme, $xoopsUser, $xoopsModule;

        if (is_object($xoTheme)) {
            $xoTheme->addStylesheet('modules/tadtools/css/xoops.css?t=20250304');
        }
        xoops_loadLanguage('main', 'tadtools');
        $op = Request::getString('op');

        if ($xoopsModule) {
            $module_id  = $xoopsModule->mid();
            $mod_name   = $xoopsModule->name();
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

        self::get_jquery();

        $options = !in_array('index.php', $interface_menu) ? "<li><a href='index.php' title='" . _TAD_HOME . "'><i class=\"fa fa-home\" aria-hidden=\"true\"></i>" : '';

        if (is_array($interface_menu)) {
            $basename = basename($_SERVER['SCRIPT_NAME']);
            foreach ($interface_menu as $title => $url) {
                $urlPath = (empty($moduleName) or 'http' === mb_substr($url, 0, 4)) ? $url : XOOPS_URL . "/modules/{$moduleName}/{$url}";

                $current = '';
                if (strpos($url, 'admin/index.php') !== false or strpos($url, 'admin/main.php') !== false) {
                    continue;
                } else {
                    $target = substr($url, 0, 4) == 'http' ? "target='_blank'" : '';

                    if (!empty($op) and false !== strpos($url, "?op=") and false !== strpos($url, "{$basename}?op={$op}")) {
                        $current = "class='current' title='$title'";
                    } elseif (false !== strpos($_SERVER['SCRIPT_NAME'], $url) && empty($op)) {
                        $current = "class='current' title='$title'";
                    }
                    $icon = isset($interface_icon[$title]) ? "<i class='fa {$interface_icon[$title]}'></i> " : '';

                    $options .= "<li {$current}><a href='{$urlPath}' $target>{$icon}{$title}</a></li>";
                }
            }

            if ($isAdmin and $module_id) {
                $options .= "<li><a href='admin/index.php' title='" . sprintf(_TAD_ADMIN, $mod_name) . "'><i class='fa fa-wrench'></i></a></li>";
                $options .= "<li><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&op=showmod&mod={$module_id}' title='" . sprintf(_TAD_CONFIG, $mod_name) . "'><i class='fa fa-edit'></i></a></li>";
                $options .= "<li><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module={$moduleName}' title='" . sprintf(_TAD_UPDATE, $mod_name) . "'><i class='fa fa-refresh'></i></a></li>";
                $options .= "<li><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen={$module_id}&selmod=-2&selgrp=-1&selvis=-1' title='" . sprintf(_TAD_BLOCKS, $mod_name) . "'><i class='fa fa-th'></i></a></li>";
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

    public static function getXoopsModuleConfig($module)
    {
        $modhandler = xoops_getHandler('module');
        $Module     = $modhandler->getByDirname($module);
        if (is_object($Module)) {
            $config_handler = xoops_getHandler('config');
            $ModuleConfig   = $config_handler->getConfigsByCat(0, $Module->getVar('mid'));
            return $ModuleConfig;
        }

        return false;
    }

    public static function TadToolsXoopsModuleConfig()
    {
        return self::getXoopsModuleConfig('tadtools');
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
        $file_contents = '';
        $timeout       = 5;
        // 使用 cURL 作为首选方法
        if (function_exists('curl_init')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

            $file_contents = curl_exec($ch);
            if (curl_errno($ch)) {
                $file_contents = '';
            }

            curl_close($ch);
        }
        // 使用 file_get_contents 作为备选方法
        elseif (function_exists('file_get_contents')) {
            $context = stream_context_create([
                'http' => [
                    'timeout' => $timeout,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $file_contents = @file_get_contents($url, false, $context);
        }
        // 使用 fopen 作为最后的备选方法
        else {
            $context = stream_context_create([
                'http' => [
                    'timeout' => $timeout,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $handle = @fopen($url, 'rb', false, $context);
            if ($handle) {
                $file_contents = stream_get_contents($handle);
                fclose($handle);
            }
        }

        return $file_contents;
    }

    //複製檔案
    public static function copyemz($file1, $file2)
    {
        $contentx   = self::vita_get_url_content($file1);
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
    public static function generateThumbnail($imagePath, $imagethumbPath = '', $width = '', $height = '', $angle = 0)
    {
        global $xoopsModuleConfig;
        $image_max_width = isset($xoopsModuleConfig['image_max_width']) ? (int) $xoopsModuleConfig['image_max_width'] : 1920;

        // 判斷是否為網路圖片
        $isRemoteImage = filter_var($imagePath, FILTER_VALIDATE_URL);

        if ($isRemoteImage) {
            // 如果是網路圖片，先下載到臨時檔案
            $tempFile     = tempnam(sys_get_temp_dir(), 'thumbnail_');
            $imageContent = self::vita_get_url_content($imagePath);

            if ($imageContent === false) {
                return "無法下載圖片：{$imagePath}";
            }

            file_put_contents($tempFile, $imageContent);
            $imagePath = $tempFile;
        }

        // 檢查文件是否存在
        if (!file_exists($imagePath)) {
            return "{$imagePath} 不存在";
        }

        $width  = $width ? $width : $image_max_width;
        $height = $height ? $height : $width;

        // 獲取圖片信息，包括類型、尺寸等
        $imageInfo = @getimagesize($imagePath);

        if ($imageInfo === false) {
            return "無法讀取圖片信息";
        }

        // Utility::dd($imageInfo);
        if (0 !== $angle) {
            $h            = $imageInfo[1];
            $w            = $imageInfo[0];
            $imageInfo[0] = $h;
            $imageInfo[1] = $w;
        }

        if ($imageInfo[0] >= $width || $imageInfo[1] >= $height) {
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
                // 只有在支援 WebP 時才處理
                case IMAGETYPE_WEBP:
                    if (function_exists('imagecreatefromwebp')) {
                        $image = imagecreatefromwebp($imagePath);
                    } else {
                        return "WebP 格式不支援";
                    }
                    break;
                default:
                    return "{$imageType} 不支援";
            }

            if (0 !== $angle) {
                $image = imagerotate($image, $angle, 0);
            }

            // 計算縮圖尺寸
            $originalWidth  = imagesx($image);
            $originalHeight = imagesy($image);

            if ($originalWidth > $width && $originalHeight > $height) {
                $scale = min($width / $originalWidth, $height / $originalHeight);
            } else {
                $scale = 1;
            }

            $newWidth  = $originalWidth * $scale;
            $newHeight = $originalHeight * $scale;

            // 創建一個新的圖片，並將原始圖片縮放到新尺寸
            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            // 處理透明背景
            if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_WEBP) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
            }

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
                    if (function_exists('imagewebp')) {
                        imagewebp($newImage, $imagethumbPath, 90);
                    } else {
                        return "WebP 格式儲存不支援";
                    }
                    break;
            }

            // 釋放圖片資源
            imagedestroy($image);
            imagedestroy($newImage);
        } else {
            \copy($imagePath, $imagethumbPath);
        }

        // 如果是臨時下載的網路圖片，刪除臨時檔案
        if ($isRemoteImage) {
            @unlink($imagePath);
        }

        return true;
    }

    //儲存權限
    public static function save_perm($groups, $itemid, $perm_name)
    {
        global $xoopsModule;
        $module_id    = $xoopsModule->mid();
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

    //判斷某人在哪些類別中有xxx的權利
    public static function get_gperm_cate_arr($gperm_name = '', $dirname = '')
    {
        global $xoopsDB, $xoopsUser, $xoopsModule;
        $ok_cate_arr = [];
        if (!$xoopsModule) {
            $modhandler  = xoops_gethandler('module');
            $xoopsModule = $modhandler->getByDirname($dirname);
        }

        if (!empty($xoopsUser)) {
            $module_id = $xoopsModule->getVar('mid');
            if ($xoopsUser->isAdmin($module_id)) {
                $ok_cate_arr[] = 0;
            }
            $user_array   = $xoopsUser->getGroups();
            $user_groupid = implode(',', $user_array);
        } else {
            $user_array   = [3];
            $user_groupid = 3;
        }
        $sql    = 'SELECT `gperm_itemid` FROM `' . $xoopsDB->prefix('group_permission') . "` WHERE `gperm_modid`='$module_id' AND `gperm_name`='$gperm_name' AND `gperm_groupid` IN ($user_groupid)";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($gperm_itemid) = $xoopsDB->fetchRow($result)) {
            $ok_cate_arr[] = $gperm_itemid;
        }

        return $ok_cate_arr;
    }

    //取回權限的函數
    public static function get_perm($itemid, $gperm_name)
    {
        global $xoopsModule, $xoopsDB;
        $itemid    = (int) $itemid;
        $module_id = $xoopsModule->mid();
        $sql       = "SELECT `gperm_groupid` FROM `" . $xoopsDB->prefix("group_permission") . "` WHERE `gperm_modid` = '$module_id' AND `gperm_itemid`='$itemid' AND `gperm_name`='$gperm_name'";
        $result    = $xoopsDB->query($sql) or self::web_error($sql, __FILE__, __LINE__);

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
        $sql       = "DELETE FROM `" . $xoopsDB->prefix("group_permission") . "` WHERE `gperm_modid` = '$module_id' AND `gperm_itemid`='$itemid' AND `gperm_name`='$gperm_name'";
        $xoopsDB->queryF($sql) or self::web_error($sql, __FILE__, __LINE__);

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

        $prism_setup = ($line_numbers) ? 'class="line-numbers"' : '';
        $xoopsTpl->assign('prism_setup', $prism_setup);

    }

    /**
     * 建立參數引用陣列
     *
     * @param array $params
     * @return array
     */
    private static function createReferenceArray(array $params)
    {
        $references = [];
        foreach ($params as $key => $value) {
            $references[$key] = &$params[$key];
        }
        return $references;
    }

    /**
     * 判斷是否為查詢語句
     *
     * @param string $sql
     * @return bool
     */
    private static function isSelectQuery($sql)
    {
        $selectPatterns = [
            'SELECT',
            'SHOW',
            'DESCRIBE',
            'EXPLAIN',
            'PRAGMA',
        ];

        $trimmedSql = trim($sql);
        foreach ($selectPatterns as $pattern) {
            if (stripos($trimmedSql, $pattern) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * 記錄調試信息
     *
     * @param string $sql
     * @param string $types
     * @param array $params
     * @param string $callerInfo
     */
    private static function logDebugInfo($sql, $types, $params, $callerInfo)
    {
        $logMessage = sprintf(
            "SQL Debug Info:\nQuery: %s\nTypes: %s\nParams: %s\nCaller: %s",
            $sql,
            $types,
            print_r($params, true),
            $callerInfo
        );
        error_log($logMessage);
    }

    /**
     * 參數化資料庫查詢
     *
     * @param string $sql SQL查詢語句
     * @param string $types 參數類型
     * @param array $params 參數陣列
     * @param bool $throwExceptions 是否拋出異常
     * @param bool $debug 是否開啟調試模式
     * @return mixed 查詢結果或布林值
     * @throws Exception
     */
    public static function query($sql, $types = '', array $params = [], $throwExceptions = true, $debug = false)
    {
        global $xoopsDB;

        // 僅在需要時獲取呼叫者信息
        $callerInfo = '';
        if ($debug || $throwExceptions) {
            $backtrace  = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
            $callerInfo = isset($backtrace[0]) ? $backtrace[0]['file'] . ' on line ' . $backtrace[0]['line'] : '';
        }

        $stmt = null;
        try {
            // 基本驗證
            if (!is_string($sql) || empty($sql)) {
                throw new \Exception(_INVALID_SQL_QUERY);
            }

            // 檢查參數數量
            $placeholderCount = substr_count($sql, '?');
            if ($placeholderCount !== count($params)) {
                throw new \Exception(sprintf(_NUMBER_PARAMETER_NOT_MATCH,
                    $placeholderCount,
                    count($params)
                ));
            }

            // 檢查類型字串長度
            if (strlen($types) !== count($params)) {
                throw new \Exception(sprintf(_TYPES_LENGTH_NOT_MATCH,
                    count($params),
                    strlen($types)
                ));
            }

            // 準備語句
            $stmt = $xoopsDB->conn->prepare($sql);
            if (!$stmt) {
                throw new \Exception(_SQL_PREPARE_FAILED . $xoopsDB->conn->error);
            }

            // 綁定參數
            if (!empty($params)) {
                // 創建參數陣列
                $bindParams = array_merge([$types], self::createReferenceArray($params));

                // 綁定參數
                if (!@call_user_func_array([$stmt, 'bind_param'], $bindParams)) {
                    throw new \Exception(_PARAMETER_BINDING_FAILED . $stmt->error);
                }
            }

            // Debug 日誌
            if ($debug) {
                self::logDebugInfo($sql, $types, $params, $callerInfo);
            }

            // 執行查詢
            if (!$stmt->execute()) {
                throw new \Exception(_SQL_EXECUTION_FAILED . $stmt->error);
            }

            // 處理查詢結果
            $isSelect = self::isSelectQuery($sql);
            if ($isSelect) {
                $result = $stmt->get_result();
                if ($result === false) {
                    throw new \Exception(_FAILED_TO_GET_RESULT . $stmt->error);
                }
                return $result;
            }

            return true;

        } catch (\Exception $e) {
            if ($debug) {
                error_log(_DATABASE_ERROR . $e->getMessage() . ($callerInfo ? " in $callerInfo" : ''));
            }

            if ($throwExceptions) {
                throw new \Exception($e->getMessage() . ($callerInfo ? " in $callerInfo" : ''));
            }

            return false;

        } finally {
            // 釋放資源
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    // /**
    //  * 參數化資料庫查詢
    //  *
    //  * @param string $sql The SQL query to execute
    //  * @param string $types The types of the parameters
    //  * @param array $params The parameters to bind
    //  * @param bool $throwExceptions Whether to throw exceptions or return false on error
    //  * @param bool $debug Whether to enable debug mode
    //  * @return mixed The query result or boolean indicating success/failure
    //  * @throws Exception
    //  */
    // public static function query($sql, $types = '', array $params = array(), $throwExceptions = true, $debug = true)
    // {
    //     global $xoopsDB;

    //     $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
    //     $callerInfo = $backtrace['file'] . ' on line ' . $backtrace['line'];

    //     try {
    //         // 驗證參數
    //         $placeholderCount = substr_count($sql, '?');
    //         if ($placeholderCount !== count($params)) {
    //             throw new \Exception(sprintf(_NUMBER_PARAMETER_NOT_MATCH, count($params), $placeholderCount));
    //         }

    //         if (strlen($types) !== count($params)) {
    //             throw new \Exception(sprintf(_TYPES_LENGTH_NOT_MATCH, strlen($types), count($params)));
    //         }

    //         $stmt = $xoopsDB->conn->prepare($sql);
    //         if ($stmt === false) {
    //             throw new \Exception(_SQL_PREPARE_FAILED . $xoopsDB->conn->error);
    //         }

    //         if (!empty($params)) {
    //             $bindParams = array($types);
    //             foreach ($params as $i => $param) {
    //                 $bindParams[] = &$params[$i];
    //             }

    //             if ($debug) {
    //                 error_log("Debug: SQL = " . $sql);
    //                 error_log("Debug: Types = " . $types);
    //                 error_log("Debug: Params = " . print_r($params, true));
    //                 error_log("Debug: BindParams = " . print_r($bindParams, true));
    //             }

    //             // 使用 Reflection 來檢查 bind_param 方法
    //             $method = new \ReflectionMethod('mysqli_stmt', 'bind_param');
    //             $paramCount = $method->getNumberOfParameters();
    //             if ($debug) {
    //                 error_log("Debug: bind_param expects {$paramCount} parameters");
    //                 error_log("Debug: We are providing " . count($bindParams) . " parameters");
    //             }

    //             if (!call_user_func_array(array($stmt, 'bind_param'), $bindParams)) {
    //                 throw new \Exception(_PARAMETER_BINDING_FAILED . $stmt->error);
    //             }
    //         }

    //         if (!$stmt->execute()) {
    //             throw new \Exception(_SQL_EXECUTION_FAILED . $stmt->error);
    //         }

    //         if (stripos(trim($sql), 'SELECT') === 0 || stripos(trim($sql), 'SHOW') === 0 || stripos(trim($sql), 'DESCRIBE') === 0 || stripos(trim($sql), 'EXPLAIN') === 0 || stripos(trim($sql), 'PRAGMA') === 0) {
    //             $result = $stmt->get_result();
    //             if ($result === false) {
    //                 throw new \Exception(_FAILED_TO_GET_RESULT . $stmt->error);
    //             }
    //             return $result;
    //         }
    //         return true;

    //     } catch (\Exception $e) {
    //         if ($throwExceptions) {
    //             throw new \Exception($e->getMessage() . " in $callerInfo");
    //         }
    //         error_log("Database query error: " . $e->getMessage() . " in $callerInfo");
    //         return false;
    //     } finally {
    //         if (isset($stmt) && $stmt instanceof \mysqli_stmt) {
    //             $stmt->close();
    //         }
    //     }
    // }

    // private static function getDefaultValue($type)
    // {
    //     switch ($type) {
    //         case 'i':
    //             return 0;
    //         case 'd':
    //             return 0.0;
    //         case 's':
    //         default:
    //             return '';
    //     }
    // }

    //製作logo圖
    public static function mkTitlePic($save_path = '/uploads/', $filename = 'logo', $title = '', $size = 24, $border_size = 2, $color = '#00a3a8', $border_color = '#FFFFFF', $font_file_sn = 0, $shadow_color = '#000000', $shadow_x = 1, $shadow_y = 1, $shadow_size = 3, $margin_top = 0, $margin_bottom = 0, $echo = true, $pic_width = 0, $pic_height = 0)
    {
        $TadUpFontFiles = new TadUpFiles('tad_themes', '/fonts');
        $TadUpFontFiles->set_col('logo_fonts', 0);
        $font = $TadUpFontFiles->get_file($font_file_sn);

        //找字數
        if (function_exists('mb_strlen')) {
            $n = mb_strlen($title);
        } else {
            $n = strlen($title) / 3;
        }

        if (empty($size)) {
            return;
        }

        $width  = $pic_width ? $pic_width : $size * 1.4 * $n;
        $height = $pic_height ? $pic_height : $size * 2 + $margin_top + $margin_bottom;

        $x                                                      = 2;
        $y                                                      = $size * 1.5;
        list($color_r, $color_g, $color_b)                      = sscanf($color, '#%02x%02x%02x');
        list($border_color_r, $border_color_g, $border_color_b) = sscanf($border_color, '#%02x%02x%02x');
        list($shadow_color_r, $shadow_color_g, $shadow_color_b) = sscanf($shadow_color, '#%02x%02x%02x');

        header('Content-type: image/png');
        $im = imagecreatetruecolor($width, $height);
        imagesavealpha($im, true);

        $trans_colour = imagecolorallocatealpha($im, 255, 255, 255, 127);
        imagefill($im, 0, 0, $trans_colour);

        $text_color        = imagecolorallocate($im, $color_r, $color_g, $color_b);
        $text_border_color = imagecolorallocatealpha($im, $border_color_r, $border_color_g, $border_color_b, 50);
        $text_shadow_color = imagecolorallocatealpha($im, $shadow_color_r, $shadow_color_g, $shadow_color_b, 50);

        $gd = gd_info();
        if ($gd['JIS-mapped Japanese Font Support']) {
            $title = iconv('UTF-8', 'shift_jis', $title);
        }
        // die('shadow_size='.$shadow_size);
        // if ($shadow_size > 0) {
        $sx = $shadow_x > 0 ? $shadow_x + $border_size : $shadow_x - $border_size;
        $sy = $shadow_y > 0 ? $shadow_y + $border_size : $shadow_y - $border_size;

        self::imagettftextblur($im, $size, 0, $x + $sx, $y + $sy + $margin_top, $text_shadow_color, $font[$font_file_sn]['physical_file_path'], $title, $shadow_size);
        // }

        imagettftext($im, $size, 0, $x, $y + $margin_top, $text_color, $font[$font_file_sn]['physical_file_path'], $title);

        if ('transparent' !== $border_color) {
            self::imagettftextoutline($im, $size, 0, $x, $y + $margin_top, $text_color, $text_border_color, $font[$font_file_sn]['physical_file_path'], $title, $border_size);
        }

        Utility::mk_dir(XOOPS_ROOT_PATH . $save_path);
        imagepng($im, XOOPS_ROOT_PATH . "{$save_path}/{$filename}.png");
        imagedestroy($im);

        if ($echo) {
            header("location: ajax.php?op=echo&val=" . XOOPS_URL . "{$save_path}/{$filename}.png?date=" . time());
            return XOOPS_URL . "{$save_path}/{$filename}.png";
        }
        return $filename;
    }

    private static function imagettftextoutline(&$im, $size, $angle, $x, $y, &$col, &$outlinecol, $fontfile, $text, $width)
    {
        // For every X pixel to the left and the right
        for ($xc = $x - abs($width); $xc <= $x + abs($width); $xc++) {
            // For every Y pixel to the top and the bottom
            for ($yc = $y - abs($width); $yc <= $y + abs($width); $yc++) {
                // Draw the text in the outline color
                $text1 = imagettftext($im, $size, $angle, $xc, $yc, $outlinecol, $fontfile, $text);
            }
        }
        // Draw the main text
        $text2 = imagettftext($im, $size, $angle, $x, $y, $col, $fontfile, $text);
    }

    private static function imagettftextblur(&$im, $size, $angle, $x, $y, $color, $fontfile, $text, $blur_intensity = 0, $blur_filter = IMG_FILTER_GAUSSIAN_BLUR)
    {
        $blur_intensity = (int) $blur_intensity;
        // $blur_intensity needs to be an integer greater than zero; if it is not we
        // treat this function call identically to imagettftext
        if (is_int($blur_intensity) && $blur_intensity > 0) {
            // $return_array will be returned once all calculations are complete
            $return_array = [
                imagesx($im), // lower left, x coordinate
                -1, // lower left, y coordinate
                -1, // lower right, x coordinate
                -1, // lower right, y coordinate
                -1, // upper right, x coordinate
                imagesy($im), // upper right, y coordinate
                imagesx($im), // upper left, x coordinate
                imagesy($im), // upper left, y coordinate
            ];
            // $temporary_image is a GD image that is the same size as our
            // original GD image
            $temporary_image = imagecreatetruecolor(
                imagesx($im),
                imagesy($im)
            );
            // fill $temporary_image with a black background
            imagefill(
                $temporary_image,
                0,
                0,
                imagecolorallocate($temporary_image, 0x00, 0x00, 0x00)
            );
            // add white text to $temporary_image with the function call's
            // parameters
            imagettftext(
                $temporary_image,
                $size,
                $angle,
                $x,
                $y,
                imagecolorallocate($temporary_image, 0xFF, 0xFF, 0xFF),
                $fontfile,
                $text
            );
            // execute the blur filters
            for ($blur = 1; $blur <= $blur_intensity; $blur++) {
                imagefilter($temporary_image, $blur_filter);
            }
            // set $color_opacity based on $color's transparency
            $color_opacity = imagecolorsforindex($im, $color)['alpha'];
            $color_opacity = (127 - $color_opacity) / 127;
            // loop through each pixel in $temporary_image
            for ($_x = 0; $_x < imagesx($temporary_image); $_x++) {
                for ($_y = 0; $_y < imagesy($temporary_image); $_y++) {
                    // $visibility is the grayscale of the current pixel multiplied
                    // by $color_opacity
                    $visibility = (imagecolorat(
                        $temporary_image,
                        $_x,
                        $_y
                    ) & 0xFF) / 255 * $color_opacity;
                    // if the current pixel would not be invisible then add it to
                    // $im
                    if ($visibility > 0) {
                        // we know we are on an affected pixel so ensure
                        // $return_array is updated accordingly
                        $return_array[0] = min($return_array[0], $_x);
                        $return_array[1] = max($return_array[1], $_y);
                        $return_array[2] = max($return_array[2], $_x);
                        $return_array[3] = max($return_array[3], $_y);
                        $return_array[4] = max($return_array[4], $_x);
                        $return_array[5] = min($return_array[5], $_y);
                        $return_array[6] = min($return_array[6], $_x);
                        $return_array[7] = min($return_array[7], $_y);
                        // set the current pixel in $im
                        imagesetpixel(
                            $im,
                            $_x,
                            $_y,
                            imagecolorallocatealpha(
                                $im,
                                ($color >> 16) & 0xFF,
                                ($color >> 8) & 0xFF,
                                $color & 0xFF,
                                (1 - $visibility) * 127
                            )
                        );
                    }
                }
            }
            // destroy our $temporary_image
            imagedestroy($temporary_image);
            return $return_array;
        } else {
            return imagettftext(
                $im,
                $size,
                $angle,
                $x,
                $y,
                $color,
                $fontfile,
                $text
            );
        }
    }

    //登入SSH
    public static function ssh_login($ssh_host, $ssh_port, $ssh_id, $ssh_passwd)
    {
        // 建立 SSH 連線
        $ssh = new SSH2($ssh_host, $ssh_port);

        // 嘗試登入
        if (!$ssh->login($ssh_id, $ssh_passwd)) {
            exit('Login Failed:' . $ssh->getLastError());
        } else {
            return $ssh;
        }
    }

}
