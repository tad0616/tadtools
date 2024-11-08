<?php
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Tools;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools as TadLoginTools;

class TadtoolsCorePreload extends XoopsPreloadItem
{
    // to add PSR-4 autoloader

    public static function eventCoreHeaderAddmeta($args)
    {
        global $xoopsConfig, $xoopsTpl, $xoopsDB, $xoTheme, $xoopsUser;
        $theme_id = 0;
        $theme_name = isset($_SESSION['xoopsUserTheme']) ? $_SESSION['xoopsUserTheme'] : $xoopsConfig['theme_set'];
        $use_default_config = false;

        /****檢查除錯模式****/
        $sql = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . '` WHERE `conf_title` = ?';
        $result = Utility::query($sql, 's', ['_MD_AM_DEBUGMODE']);

        list($debug) = $xoopsDB->fetchRow($result);
        if ($debug == 0) {
            $debug = 1;
        } else {
            $debug = 0;
        }
        $xoopsTpl->assign('debug', $debug);

        /****是否使用搜尋****/
        $xoopsTpl->assign('use_search', 1);

        // themes_common/meta.tpl 會用到
        $http = 'https://';
        if (!empty($_SERVER['HTTPS'])) {
            $http = ($_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        }
        $url = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $xoopsTpl->assign('now_url', $url);

        $moduleHandler = xoops_getHandler('module');
        $TadThemesModule = $moduleHandler->getByDirname("tad_themes");
        $TadThemesMid = ($TadThemesModule) ? $TadThemesModule->mid() : 0;

        // 取得佈景預設的設定值以及偏好設定
        $def_config = Tools::def_config($theme_name, $TadThemesMid);
        foreach ($def_config as $key => $value) {
            $xoopsTpl->assign($key, $value);
        }

        // 僅支援 tad themes 佈景才需要的設定
        if (!empty($def_config['theme_kind']) and $def_config['theme_kind'] != 'xoops') {
            // 取得佈景管理的自訂設定值
            $theme_config = Tools::theme_config($theme_name, $def_config);
            if (!empty($theme_config) and !empty($theme_config['theme_width'])) {
                foreach ($theme_config as $k => $v) {
                    $$k = $v;
                    $xoopsTpl->assign($k, $v);
                }
            }

            // Utility::dd($theme_config);
            // $_SESSION['bootstrap'] = strpos($theme_kind, 'bootstrap') !== false ? substr($theme_kind, -1) : 5;
            // Utility::dd($_SESSION['bootstrap']);
            /****設定各個區域的底色****/
            $left_block = $left_block2 = $center_block_content = $right_block = $right_block2 = "";
            $center_block = "background-color: {$cb_color};";

            /****設定各個區域的寬度****/

            if ($theme_kind == 'mix') {
                $theme_width = 12;
            }

            //TYPE1:二欄式（左右區域皆在左邊）
            if ($theme_type == 'theme_type_1') {
                if ($theme_kind == "html") {
                    if (!$xoops_showlblock and !$xoops_showrblock) {
                        $center_width = $theme_width;
                    } else {
                        $center_width = $theme_width - $lb_width - 50;
                        $center_content_width = $center_width - 15;
                    }

                    $left_block .= "width:{$lb_width}px;";
                    $center_block .= "float:right; width:{$center_width}px;";
                    $center_block_content = "width:{$center_content_width}px;";
                    $right_block .= " width:{$rb_width}px;";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                    if ($lb_width == 'auto') {
                        $lb_width = 12 - $cb_width;
                    }
                } else {
                    $center_width = $theme_width - $lb_width;
                }

                //TYPE2:二欄式（左右區域皆在右邊）
            } elseif ($theme_type == 'theme_type_2') {
                if ($theme_kind == "html") {
                    if (!$xoops_showlblock and !$xoops_showrblock) {
                        $center_width = $theme_width;
                    } else {
                        $center_width = $theme_width - $rb_width - 50;
                    }

                    $left_block .= "width:{$lb_width}px;";
                    $center_block .= "float:left;  width:{$center_width}px; padding-left: 15px;";
                    $center_block_content = $center_block;
                    $right_block .= "width:{$rb_width}px;";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                    if ($rb_width == 'auto') {
                        $rb_width = 12 - $cb_width;
                    }
                } else {
                    $center_width = $theme_width - $rb_width;
                }

                //TYPE3:二欄式（左區域在左邊，右區域在下方）
            } elseif ($theme_type == 'theme_type_3') {
                if ($theme_kind == "html") {
                    if (!$xoops_showlblock) {
                        $center_width = $theme_width;
                    } else {
                        $center_width = $theme_width - $lb_width - 60;
                        $center_content_width = $center_width - 15;
                    }
                    $left_block .= "float:left; width:{$lb_width}px;";
                    $center_block .= "float:right;  width:{$center_width}px;";
                    $center_block_content = "width:{$center_content_width}px;";
                    $right_block .= "float:none;  width:{$theme_width}px; clear:both;";
                    $left_block2 = "";
                    $right_block2 .= "float:left; padding-left: 15px;";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                    if ($lb_width == 'auto') {
                        $lb_width = 12 - $cb_width;
                    }
                    $rb_width = "12";
                } else {
                    $rb_width = "12";
                    $center_width = $theme_width - $lb_width;
                }

                //TYPE4:二欄式（左區域在右邊，右區域在下方）
            } elseif ($theme_type == 'theme_type_4') {
                if ($theme_kind == "html") {
                    if (!$xoops_showrblock) {
                        $center_width = $theme_width;
                    } else {
                        $center_width = $theme_width - $lb_width - 60;
                    }
                    $left_block .= "float:right; width: {$lb_width}px;";
                    $center_block .= "float:left; width: {$center_width}px; padding-left: 10px;";
                    $center_block_content = $center_block;
                    $right_block .= "float:none; width:{$theme_width}px; clear:both;";
                    $left_block2 = "";
                    $right_block2 .= "float:left; padding-left: 15px;";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                    if ($lb_width == 'auto') {
                        $lb_width = 12 - $cb_width;
                    }
                    $rb_width = "12";
                } else {
                    $rb_width = "12";
                    $center_width = $theme_width - $lb_width;
                }

                //TYPE5:三欄式標準配置
            } elseif ($theme_type == 'theme_type_5') {
                if ($theme_kind == "html") {
                    if (!$xoops_showlblock and !$xoops_showrblock) {
                        $center_width = $theme_width;
                    } elseif (!$xoops_showlblock) {
                        //$center_width=$theme_width - $rb_width - 20;
                    } elseif (!$xoops_showrblock) {
                        $center_width = $theme_width - $lb_width - 20;
                    } else {
                        $center_width = $theme_width - $lb_width - $rb_width - 50;
                    }

                    $left_block .= "float:left;  width:{$lb_width}px;";
                    $center_block .= "float:left;  width:{$center_width}px;";
                    $right_block .= "float:right;  width:{$rb_width}px;";
                    $left_block2 = $right_block2 = $center_block_content = "";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                } else {
                    $center_width = $theme_width - $lb_width - $rb_width;
                }

                //TYPE6:三欄式（左右區域皆在左邊）
            } elseif ($theme_type == 'theme_type_6') {
                if ($theme_kind == "html") {
                    if (!$xoops_showlblock and !$xoops_showrblock) {
                        $center_width = $theme_width;
                    } elseif (!$xoops_showlblock) {
                        $center_width = $theme_width - $rb_width - 20;
                    } elseif (!$xoops_showrblock) {
                        $center_width = $theme_width - $lb_width - 20;
                    } else {
                        $center_width = $theme_width - $lb_width - $rb_width - 50;
                    }
                    $center_content_width = $center_width - 50;
                    $left_block .= "float:left;  width:{$lb_width}px;";
                    $center_block .= "float:right;  width:{$center_width}px;";
                    $center_block_content = "width:{$center_content_width}px;";
                    $right_block .= "float:left;  width:{$rb_width}px;";
                    $left_block2 = $right_block2 = "";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                } else {
                    $center_width = $theme_width - $lb_width - $rb_width;
                }

                //TYPE7:三欄式（左右區域皆在右邊）
            } elseif ($theme_type == 'theme_type_7') {
                if ($theme_kind == "html") {
                    if (!$xoops_showlblock and !$xoops_showrblock) {
                        $center_width = $theme_width;
                    } elseif (!$xoops_showlblock) {
                        $center_width = $theme_width - $rb_width - 20;
                    } elseif (!$xoops_showrblock) {
                        $center_width = $theme_width - $lb_width - 20;
                    } else {
                        $center_width = $theme_width - $lb_width - $rb_width - 50;
                    }
                    $left_block .= "float:right;  width:{$lb_width}px;";
                    $center_block .= "float:left;  width:{$center_width}px; padding-left: 15px;";
                    $right_block .= "float:right;  width:{$rb_width}px;";
                    $left_block2 = $right_block2 = $center_block_content = "";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $center_width = $cb_width;
                } else {
                    $center_width = $theme_width - $lb_width - $rb_width;
                }

                //TYPE8:單欄式（左區域在上方，右區域在下方）
            } elseif ($theme_type == 'theme_type_8') {
                if ($theme_kind == "html") {
                    $center_width = $lb_width = $rb_width = $theme_width - 30;
                    $left_block .= "float:none;  width:{$lb_width}px; padding-left: 10px;";
                    $center_block .= "float:none;  width:{$center_width}px; padding-left: 10px;";
                    $right_block .= "float:none;  width:{$rb_width}px; padding-left: 10px;";
                    $left_block2 .= "";
                    $right_block2 .= "";
                    $center_block_content = "";
                } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
                    $lb_width = $center_width = $rb_width = "12";
                } else {
                    $lb_width = $center_width = $rb_width = "12";
                }
            }

            $xoopsTpl->assign('base_color', $base_color);
            $xoopsTpl->assign('content_zone', "background-color:{$base_color};");
            $xoopsTpl->assign('leftBlocks', $left_block);
            $xoopsTpl->assign('centerBlocks', $center_block);
            $xoopsTpl->assign('centerBlocksContent', $center_block_content);
            $xoopsTpl->assign('rightBlocks', $right_block);
            $xoopsTpl->assign('leftBlocks2', $left_block2);
            $xoopsTpl->assign('rightBlocks2', $right_block2);

            $xoopsTpl->assign('lb_width', $lb_width);
            $xoopsTpl->assign('cb_width', $cb_width);
            $xoopsTpl->assign('rb_width', $rb_width);
            $xoopsTpl->assign('center_width', $center_width);

            /****設定Logo圖位置****/
            $logo_place = "";
            if (!empty($logo_top)) {
                $logo_place .= "top:{$logo_top}%;";
            }

            if (!empty($logo_bottom)) {
                $logo_place .= "bottom:{$logo_bottom}%;";
            }

            if ($logo_center == '1') {
                $logo_place .= "margin-left: auto; margin-right: auto; left: 0; right: 0;";
            } else {

                if (!empty($logo_left)) {
                    $logo_place .= "left:{$logo_left}%;";
                } elseif (!empty($logo_right)) {
                    $logo_place .= "right:{$logo_right}%;";
                }

            }
            $xoopsTpl->assign('logo_place', $logo_place);

            /****導覽工具列、區塊標題CSS設定****/
            $xoopsTpl->assign('navbar_pos', $navbar_pos);
            $xoopsTpl->assign('navbar_bg_top', $navbar_bg_top);
            $xoopsTpl->assign('navbar_bg_bottom', $navbar_bg_bottom);
            $xoopsTpl->assign('navbar_hover', $navbar_hover);

            list($navbar_bg_top_rgb['r'], $navbar_bg_top_rgb['g'], $navbar_bg_top_rgb['b']) = sscanf($navbar_bg_top, "#%02x%02x%02x");
            $xoopsTpl->assign('navbar_bg_top_rgb', $navbar_bg_top_rgb);
            list($navbar_bg_bottom_rgb['r'], $navbar_bg_bottom_rgb['g'], $navbar_bg_bottom_rgb['b']) = sscanf($navbar_bg_bottom, "#%02x%02x%02x");
            $xoopsTpl->assign('navbar_bg_bottom_rgb', $navbar_bg_bottom_rgb);

            /****若有logo.png或logo.gif時導覽工具列以圖替代網站標題文字****/
            //if ($navlogo_img) {
            //    $xoopsTpl->assign('navbar_logo_img', $navlogo_img);
            //}

            /****區塊標題設定****/
            if ($TadThemesMid) {
                $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_blocks') . '` WHERE `theme_id` = ?';
                $result = Utility::query($sql, 'i', [$theme_id]);
                //`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`
                while (false !== ($all = $xoopsDB->fetchArray($result))) {
                    $block_position = $all['block_position'];
                    $all['bt_bg_img'] = $all['bt_bg_img'] ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$all['bt_bg_img']}" : '';
                    $db[$block_position] = $all;
                }

            }

            $block_position = ['leftBlock', 'rightBlock', 'centerBlock', 'centerLeftBlock', 'centerRightBlock', 'centerBottomBlock', 'centerBottomLeftBlock', 'centerBottomRightBlock', 'footerCenterBlock', 'footerLeftBlock', 'footerRightBlock'];
            $xoopsTpl->assign('block_position', $block_position);
            $i = 0;
            $positions = array();
            foreach ($block_position as $position) {
                $positions[$i]['block_position'] = $position;
                $positions[$i]['block_config'] = $use_default_config ? $block_config[$position] : $db[$position]['block_config'];
                $positions[$i]['bt_text'] = $use_default_config ? $bt_text[$position] : $db[$position]['bt_text'];
                $positions[$i]['bt_text_padding'] = $use_default_config ? $bt_text_padding[$position] : $db[$position]['bt_text_padding'];
                $positions[$i]['bt_text_size'] = $use_default_config ? $bt_text_size[$position] : $db[$position]['bt_text_size'];
                $positions[$i]['bt_bg_color'] = $use_default_config ? $bt_bg_color[$position] : $db[$position]['bt_bg_color'];
                $positions[$i]['bt_bg_img'] = $use_default_config ? $bt_bg_img[$position] : $db[$position]['bt_bg_img'];
                $positions[$i]['bt_bg_repeat'] = $use_default_config ? $bt_bg_repeat[$position] : $db[$position]['bt_bg_repeat'];
                $positions[$i]['bt_radius'] = $use_default_config ? $bt_radius[$position] : $db[$position]['bt_radius'];
                $positions[$i]['block_style'] = $use_default_config ? $block_style[$position] : $db[$position]['block_style'];
                $positions[$i]['block_title_style'] = $use_default_config ? $block_title_style[$position] : $db[$position]['block_title_style'];
                $positions[$i]['block_content_style'] = $use_default_config ? $block_content_style[$position] : $db[$position]['block_content_style'];

                $xoopsTpl->assign($position, $positions[$i]);
                $i++;
            }
            $xoopsTpl->assign('positions', $positions);

            /**** 佈景額外設定 ****/

            //額外佈景設定
            $config2 = [];
            $config2_files = ['config2_base', 'config2_bg', 'config2_top', 'config2_logo', 'config2_nav', 'config2_slide', 'config2_middle', 'config2_content', 'config2_block', 'config2_footer', 'config2_bottom', 'config2'];
            $xoopsTpl->assign('config2_files', $config2_files);

            // if ($TadThemesMid) {
            //     $config2_json_file = XOOPS_VAR_PATH . "/data/tad_themes_config2_{$theme_id}.json";
            //     if (file_exists($config2_json_file)) {
            //         $json_content = file_get_contents($config2_json_file);
            //         $config2 = json_decode($json_content, true);
            //     } else {
            //     $sql = 'SELECT `name`, `type`, `value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` WHERE `theme_id`=?';
            //     $result = Utility::query($sql, 'i', [$theme_id]);
            //         while (list($name, $type, $value) = $xoopsDB->fetchRow($result)) {
            //             $config2[$name] = $value;
            //         }

            //         $json_content = json_encode($config2, 256);
            //         file_put_contents($config2_json_file, $json_content);
            //     }
            // }

            /**** 依序讀取佈景額外設定檔 ****/
            /**** $config 是來自 config2_xxx.php 中的設定（一律先讀取佈景檔，非風格檔，這樣才能讀到最新架構） ****/
            /**** $config2 是來自 tad_themes_config2_xxx.json （或資料庫中） 中的設定 ****/

            // $bids = [];
            foreach ($config2_files as $config2_file) {

                if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
                    $theme_config = [];
                    require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";

                    foreach ($theme_config as $k => $config) {
                        $config2_name = $config['name'];
                        $theme_config[$k]['value'] = $$config2_name;

                        if ($config['type'] == "bg_file") {
                            $theme_config[$k]['repeat'] = ${$config2_name . '_repeat'};
                            $theme_config[$k]['position'] = ${$config2_name . '_position'};
                            $theme_config[$k]['size'] = ${$config2_name . '_size'};

                        } elseif ($config['type'] == 'custom_zone') {
                            $theme_config[$k]['deault'] = isset(${$config2_name}) ? ${$config2_name} : '';
                            $theme_config[$k]['bid'] = isset(${$config2_name . '_bid'}) ? ${$config2_name . '_bid'} : '';
                            $theme_config[$k]['content'] = isset(${$config2_name . '_content'}) ? ${$config2_name . '_content'} : '';
                            $theme_config[$k]['html_content'] = isset(${$config2_name . '_html_content'}) ? ${$config2_name . '_html_content'} : '';
                            $theme_config[$k]['html_content_desc'] = isset($config['html_content_desc']) ? $config['html_content_desc'] : '';
                            $theme_config[$k]['fa_content'] = isset(${$config2_name . '_fa_content'}) ? ${$config2_name . '_fa_content'} : '';
                            $theme_config[$k]['fa_content_desc'] = isset($config['fa_content_desc']) ? $config['fa_content_desc'] : '';
                            $theme_config[$k]['menu_content'] = isset(${$config2_name . '_menu_content'}) ? ${$config2_name . '_menu_content'} : '';
                            $theme_config[$k]['menu_content_desc'] = isset($config['menu_content_desc']) ? $config['menu_content_desc'] : '';

                        } elseif ($config['type'] == "padding_margin") {
                            $theme_config[$k]['mt'] = ${$config2_name . '_mt'};
                            $theme_config[$k]['mb'] = ${$config2_name . '_mb'};
                        }
                    }
                    $config2[$config2_file] = $theme_config;
                }
            }
            Utility::test($config2, 'config2', 'dd');
            $xoopsTpl->assign('config2', $config2);

            // $xoopsTpl->assign('bids', $bids);

            /****佈景 TadDataCenter 設定****/
            $TadDataCenter = new TadDataCenter('tad_themes');
            $TadDataCenter->set_col('theme_id', $theme_id);
            $data = $TadDataCenter->getData();
            foreach ($data as $var_name => $var_val) {
                if ($var_name == 'navbar_font_size' and $var_val[0] > 10) {
                    $var_val[0] = round($var_val[0] / 100, 2);
                }

                $xoopsTpl->assign($var_name, $var_val[0]);
            }

            /****檢查是否開放註冊****/
            $sql = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . '` WHERE `conf_name` = ?';
            $result = Utility::query($sql, 's', ['allow_register']);
            list($allow_register) = $xoopsDB->fetchRow($result);
            $xoopsTpl->assign('allow_register', $allow_register);

            /****檢查是否有廣播檔（會放到左區塊最上方）****/
            if (file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/broadcast.php")) {
                $all_broadcast = file_get_contents(XOOPS_URL . "/modules/tadtools/broadcast.php");
                $xoopsTpl->assign('all_broadcast', json_decode($all_broadcast, true));
            }

            if ($xoTheme) {
                if (!isset($_SESSION['xoops_version'])) {
                    $_SESSION['xoops_version'] = Utility::get_version('xoops');
                }
                $xoopsTpl->assign('xoops_version', $_SESSION['xoops_version']);
                $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

                // $ver = intval(str_replace('.', '', substr(XOOPS_VERSION, 6, 5)));

                // if ($_SESSION['xoops_version'] < 20509) {
                //     $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
                // } else {
                $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
                // }
                $xoTheme->addStylesheet('modules/tadtools/jquery/themes/base/jquery.ui.all.css');
                // $xoTheme->addScript('modules/tadtools/jquery/ui/jquery-ui.js');
                $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');

                $xoTheme->addStylesheet('modules/tadtools/colorbox/colorbox.css');
                $xoTheme->addStylesheet('modules/tadtools/css/xoops.css');
                $xoTheme->addScript('modules/tadtools/colorbox/jquery.colorbox.js');
                $xoTheme->addStylesheet('modules/tadtools/css/fontawesome6/css/all.min.css');
                $xoTheme->addStylesheet('media/font-awesome/css/font-awesome.min.css');

            }

            //製作主選單
            $main_menu = [];
            $i = 0;
            $sql = 'SELECT `mid`, `name`, `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive` = 1 AND `hasmain` = 1 AND `weight` != 0 ORDER BY `weight`';
            $result = Utility::query($sql);

            while (list($mid, $name, $dirname) = $xoopsDB->fetchRow($result)) {
                $main_menu[$i]['id'] = $mid;
                $main_menu[$i]['title'] = $name;
                $main_menu[$i]['url'] = XOOPS_URL . "/modules/{$dirname}/";
                $main_menu[$i]['target'] = '_self';
                $main_menu[$i]['icon'] = 'fa-th-list';
                $main_menu[$i]['img'] = '';
                $i++;
            }
            $xoopsTpl->assign('main_menu_var', $main_menu);

            //製作管理選單
            $TadBlocksModule = $moduleHandler->getByDirname("tad_blocks");
            $TadBlocksMid = ($TadBlocksModule) ? $TadBlocksModule->mid() : 0;

            $sql = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . '` WHERE `conf_title` = ?';
            $result = Utility::query($sql, 's', ['_MD_AM_DEBUGMODE']) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
            list($debug) = $xoopsDB->fetchRow($result);
            if ($debug == 0) {
                $debug = 1;
            } else {
                $debug = 0;
            }

            $admin_menu[] = ['title' => _TAD_TF_USER_ADMIN, 'url' => XOOPS_URL . '/admin.php', 'icon' => 'fa-lock', 'target' => '_self'];
            $admin_menu[] = ['title' => _TAD_TF_SYSTEM_CONFIG, 'url' => XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=show&confcat_id=1', 'icon' => 'fa-cog', 'target' => '_blank'];
            $admin_menu[] = ['title' => _TAD_TF_SYSTEM_MODADM, 'url' => XOOPS_URL . '/modules/tad_adm/admin/main.php', 'icon' => 'fa-wrench', 'target' => '_blank'];
            $admin_menu[] = ['title' => _TAD_TF_SYSTEM_DBADM, 'url' => XOOPS_URL . '/modules/tad_adm/pma.php?server=' . XOOPS_DB_HOST . '&db=' . XOOPS_DB_NAME, 'icon' => 'fa-database', 'target' => '_blank'];
            if ($TadThemesMid) {
                $admin_menu[] = ['title' => _TAD_TF_THEME_ADMIN, 'url' => XOOPS_URL . '/modules/tad_themes/admin/main.php', 'icon' => 'fa-list-alt', 'target' => '_blank'];
            }
            if ($debug == '1') {
                $admin_menu[] = ['title' => _TAD_TF_THEME_DEBUG, 'url' => XOOPS_URL . "/modules/tadtools/themes_common/tools/debug.php?op=debug&v={$debug}", 'icon' => 'fa-warning', 'target' => '_self'];
            } else {
                $admin_menu[] = ['title' => _TAD_TF_THEME_UNDEBUG, 'url' => XOOPS_URL . "/modules/tadtools/themes_common/tools/debug.php?op=debug&v={$debug}", 'icon' => 'fa-warning', 'target' => '_self'];

            }
            $admin_menu[] = ['title' => _TAD_TF_USER_BLOCK, 'url' => XOOPS_URL . '/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=-1&selmod=-2&selgrp=-1&selvis=1', 'icon' => 'fa-th', 'target' => '_blank'];
            if ($TadBlocksMid) {
                $admin_menu[] = ['title' => _TAD_TF_USER_TAD_BLOCK, 'url' => XOOPS_URL . '/modules/tad_blocks/blocks.php', 'icon' => 'fa-cubes', 'target' => '_blank'];
            } else {
                $admin_menu[] = ['title' => _TAD_TF_USER_TAD_BLOCK, 'url' => XOOPS_URL . '/modules/tad_adm/admin/main.php#modTab2', 'icon' => 'fa-cubes', 'target' => '_blank'];
            }

            $xoopsTpl->assign('admin_menu_var', $admin_menu);

            //製作使用者選單
            $uid = $xoopsUser ? $xoopsUser->uid() : 0;
            $sql = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('priv_msgs') . '` WHERE `to_userid` = ? AND `read_msg`=0 GROUP BY `to_userid`';
            $result = Utility::query($sql, 'i', [$uid]);
            list($xoops_inbox_count) = $xoopsDB->fetchRow($result);

            if ($xoops_inbox_count) {
                $user_menu[] = ['title' => sprintf(_TAD_TF_USER_NEWMSG, $xoops_inbox_count), 'url' => XOOPS_URL . '/viewpmsg.php', 'icon' => 'fa-envelope', 'target' => '_self'];
            } else {
                $user_menu[] = ['title' => _TAD_TF_USER_MSG, 'url' => XOOPS_URL . '/viewpmsg.php', 'icon' => 'fa-envelope-o', 'target' => '_self'];
            }
            $user_menu[] = ['title' => _TAD_TF_USER_NOTICE, 'url' => XOOPS_URL . '/notifications.php', 'icon' => 'fa-bell', 'target' => '_self'];
            $user_menu[] = ['title' => _TAD_TF_USER_PROFILE, 'url' => XOOPS_URL . '/user.php', 'icon' => 'fa-user', 'target' => '_self'];
            $user_menu[] = ['title' => _TAD_TF_USER_EXIT, 'url' => XOOPS_URL . '/user.php?op=logout', 'icon' => 'fa-share', 'target' => '_self'];

            $xoopsTpl->assign('user_menu_var', $user_menu);

            // 自訂選單
            $my_menu = Tools::get_theme_menu_items(0);
            $i = sizeof($my_menu);
            $mod_menu = Tools::get_module_menu_item($i);
            if (!empty($mod_menu)) {
                if (empty($my_menu)) {
                    $my_menu = array();
                }

                $my_menu = array_merge($my_menu, $mod_menu);
            }
            $xoopsTpl->assign('menu_var', $my_menu);

            // 滑動圖
            $slider_var = Tools::get_theme_slide_items($theme_name);
            $xoopsTpl->assign('slider_var', $slider_var);

            // navbar.tpl 會用到
            if ($xoopsUser && $xoopsUser->isAdmin()) {
                if (file_exists(XOOPS_VAR_PATH . "/data/install_chk.php")) {
                    $xoopsTpl->assign('install_chk', true);
                    unlink(XOOPS_VAR_PATH . "/data/install_chk.php");
                }
            }

            // menu_login.tpl 會用到
            if (!$xoopsUser) {
                if ($def_config['openid_login'] == '1' || $def_config['openid_login'] == '2') {
                    $configHandler = xoops_gethandler('config');

                    $TadLoginXoopsModule = $moduleHandler->getByDirname("tad_login");
                    $TnLoginXoopsModule = $moduleHandler->getByDirname("tn_login");

                    if ($TadLoginXoopsModule) {
                        require_once XOOPS_ROOT_PATH . "/modules/tad_login/language/{$xoopsConfig['language']}/county.php";

                        $modConfig = $configHandler->getConfigsByCat(0, $TadLoginXoopsModule->getVar('mid'));

                        if (in_array('facebook', $modConfig['auth_method'])) {
                            $tad_login['facebook'] = TadLoginTools::facebook_login('return');
                        } else {
                            $tad_login['facebook'] = '';
                        }

                        if (in_array('line', $modConfig['auth_method'])) {
                            $tad_login['line'] = TadLoginTools::line_login('return');
                        } else {
                            $tad_login['line'] = '';
                        }

                        if (in_array('google', $modConfig['auth_method'])) {
                            $tad_login['google'] = TadLoginTools::google_login('return');
                        } else {
                            $tad_login['google'] = '';
                        }

                        $auth_method = $modConfig['auth_method'];
                        $i = 0;
                        $oidc_array = array_keys(TadLoginTools::$all_oidc);
                        $oidc_array2 = array_keys(TadLoginTools::$all_oidc2);
                        foreach ($auth_method as $method) {
                            $method_const = "_" . strtoupper($method);

                            if ($method == "facebook") {
                                $tlogin[$i]['link'] = $tad_login['facebook'];
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant($method_const));
                            } elseif ($method == "google") {
                                $tlogin[$i]['link'] = $tad_login['google'];
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant($method_const));
                            } elseif ($method == "line") {
                                $tlogin[$i]['link'] = $tad_login['line'];
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant($method_const));
                            } else {
                                $tlogin[$i]['link'] = XOOPS_URL . "/modules/tad_login/index.php?login&op={$method}";
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant($method_const));
                            }

                            if (isset($oidc_array) && is_array($oidc_array) && in_array($method, $oidc_array)) {
                                $tlogin[$i]['img'] = XOOPS_URL . "/modules/tad_login/images/oidc/" . TadLoginTools::$all_oidc[$method]['tail'] . ".png";
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant('_' . strtoupper(TadLoginTools::$all_oidc[$method]['tail'])) . _TADLOGIN_OIDC);

                            } elseif (isset($oidc_array2) && is_array($oidc_array2) && in_array($method, $oidc_array2)) {
                                $tlogin[$i]['img'] = XOOPS_URL . "/modules/tad_login/images/{$method}.png";
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant('_' . strtoupper(TadLoginTools::$all_oidc2[$method]['tail'])) . _TADLOGIN_LDAP);

                            } else {
                                $tlogin[$i]['img'] = XOOPS_URL . "/modules/tad_login/images/{$method}.png";
                                $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant($method_const) . ' OpenID ');
                            }

                            $i++;
                        }
                        $xoopsTpl->assign('tlogin', $tlogin);
                    } elseif ($TnLoginXoopsModule) {
                        require_once XOOPS_ROOT_PATH . "/modules/tn_login/function.php";
                        $tlogin[0]['link'] = XOOPS_URL . "/modules/tn_login/index.php";
                        $tlogin[0]['img'] = XOOPS_URL . "/modules/tn_login/images/login_logo.png";
                        $tlogin[0]['text'] = '由南資 OpenID 認證登入';
                        $tlogin[0]['tn_login'] = true;

                        $xoopsTpl->assign('tlogin', $tlogin);
                    }
                }
            }
        }

    }

    public static function eventCoreIncludeCommonAuthSuccess()
    {
        global $xoopsConfig;
        $_SESSION['xoops_version'] = Utility::get_version('xoops');

        $theme_name = isset($_SESSION['xoopsUserTheme']) ? $_SESSION['xoopsUserTheme'] : $xoopsConfig['theme_set'];
        $json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        if (file_exists($json_file)) {
            $theme_config = json_decode(file_get_contents($json_file), true);
            $_SESSION['bootstrap'] = strpos($theme_config['theme_kind'], 'bootstrap') !== false ? substr($theme_config['theme_kind'], -1) : 5;
        } else {
            $theme_kind = Tools::import_theme_json($theme_name);
            $_SESSION['bootstrap'] = strpos($theme_kind, 'bootstrap') !== false ? substr($theme_kind, -1) : 5;
        }
    }

    public static function eventCoreFooterStart($args)
    {
        global $xoopsConfig, $xoopsDB, $xoTheme, $xoopsTpl;

        if (!isset($xoTheme)) {
            $xoTheme = $GLOBALS['xoTheme'];
        }

        $theme_set = isset($_SESSION['xoopsUserTheme']) ? $_SESSION['xoopsUserTheme'] : $xoopsConfig['theme_set'];

        if (!isset($_SESSION['old_theme_set'])) {
            $_SESSION['old_theme_set'] = $theme_set;
        }

        $_SESSION['old_theme_set'] = $theme_set;

        if (isset($_SESSION['theme_kind'])) {

        } else {
            $sql = 'SELECT `tt_theme`,`tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` FROM `' . $xoopsDB->prefix('tadtools_setup') . '` WHERE `tt_theme` = ?';
            $result = Utility::query($sql, 's', [$theme_set]);
            list($tt_theme, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind) = $xoopsDB->fetchRow($result);

            if (empty($tt_theme_kind)) {
                if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_set}/config.php")) {
                    require_once XOOPS_ROOT_PATH . "/themes/{$theme_set}/config.php";
                    if (isset($theme_kind)) {
                        $tt_theme_kind = $theme_kind;
                        $tt_use_bootstrap = 'html' === $theme_kind ? 1 : 0;
                        $tt_bootstrap_color = 'bootstrap3';
                        if (empty($tt_theme)) {
                            $sql = 'INSERT INTO `' . $xoopsDB->prefix('tadtools_setup') . '` (`tt_theme`,`tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind`) VALUES(?, ?, ?)';
                            Utility::query($sql, 'ssss', [$theme_set, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind]);
                        } else {
                            $sql = 'UPDATE `' . $xoopsDB->prefix('tadtools_setup') . '` SET `tt_use_bootstrap`=?, `tt_bootstrap_color`=?, `tt_theme_kind`=? WHERE `tt_theme`=?';
                            Utility::query($sql, 'ssss', [$tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind, $theme_set]);
                        }
                    }
                } else {
                    $tt_theme_kind = 'html';
                    $tt_use_bootstrap = 1;
                    $tt_bootstrap_color = 'bootstrap5';
                }
            }
            $_SESSION['theme_kind'] = $tt_theme_kind;
            $_SESSION[$theme_set]['bootstrap_version'] = $tt_theme_kind;
        }

        if ($xoopsTpl) {
            $xoopsTpl->assign('bootstrap_version', $_SESSION['bootstrap']);
        }

        if ($xoTheme and isset($tt_use_bootstrap) and $tt_use_bootstrap == 1) {
            if (strpos($tt_bootstrap_color, '/') === false) {
                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/$tt_bootstrap_color/css/bootstrap.css");
            } else {
                $c = explode('/', $tt_bootstrap_color);

                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/{$c[0]}/css/bootstrap.css");
                $xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/{$tt_bootstrap_color}/bootstrap.min.css");
            }
        }
    }

    // to add PSR-4 autoloader

    /**
     * @param $args
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        require __DIR__ . '/autoloader.php';
    }
}
