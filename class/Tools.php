<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools as TadLoginTools;

/*
Update Class Definition

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
 * Class Update
 */
class Tools
{
    public static function tad_login($kind = '', $mode = '')
    {
        if (!isset($_SESSION['xoops_version'])) {
            $_SESSION['xoops_version'] = Utility::get_version('xoops');
        }

        if (!class_exists('XoopsModules\Tad_login\Tools')) {
            require_once XOOPS_ROOT_PATH . "/modules/tad_login/function.php";
            if ($kind == 'line') {
                return line_login($mode);
            } elseif ($kind == 'google') {
                return google_login($mode);
            }
        } else {
            if ($kind == 'line') {
                return TadLoginTools::line_login($mode);
            } elseif ($kind == 'google') {
                return TadLoginTools::google_login($mode);
            }
        }
    }

    // 取得佈景預設設定值
    public static function def_config($theme_name, $TadThemesMid = 0)
    {
        global $aggreg, $xoopsConfig, $xoopsTpl;
        /**** 取得佈景設定的各個預設值 ****/
        if (\file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
            $def_config                 = Utility::getXoopsModuleConfig('tad_themes');
            $def_config['TadThemesMid'] = $TadThemesMid;

            /**** 取得左右區塊數 ****/
            $def_config['left_count']       = $aggreg ? count($aggreg->blocks['canvas_left']) : 0;
            $def_config['right_count']      = $aggreg ? count($aggreg->blocks['canvas_right']) : 0;
            $def_config['xoops_showlblock'] = empty($def_config['left_count']) ? false : true;
            $def_config['xoops_showrblock'] = empty($def_config['right_count']) ? false : true;
            /**** 取得 Tad Themes 偏好設定****/
            require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
            require_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/main.php";

            if ($xoopsTpl) {
                $xoopsTpl->assign('config_tabs', $config_tabs);
            }

            foreach ($config_enable as $k => $v) {
                $def_config[$k] = $v['default'];
            }
            $def_config['theme_change']      = $theme_change;
            $def_config['theme_kind']        = $theme_kind;
            $def_config['theme_kind_arr']    = explode(',', $theme_kind_arr);
            $def_config['menu_var_kind']     = $menu_var_kind;
            $def_config['theme_color']       = $theme_color;
            $def_config['theme_set_allowed'] = $xoopsConfig['theme_set_allowed'];

            /**** 產生 Smarty 的設定檔（以取得 bootstrap 版本） ****/
            $bootstrap = (strpos($theme_kind, 'bootstrap') !== false) ? substr($theme_kind, -1) : '4';
            if ($xoopsTpl) {
                $xoopsTpl->assign('bootstrap', $bootstrap);
            }

            /**** 模擬偏好設定預設值（避免沒裝 tad_theme 無法取得資料庫資料） ****/
            $def_config['bg_img']      = !empty($def_config['bg_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/bg/{$def_config['bg_img']}" : "";
            $def_config['logo_img']    = !empty($def_config['logo_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/logo/{$def_config['logo_img']}" : "";
            $def_config['navlogo_img'] = !empty($def_config['navlogo_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/navlogo/{$def_config['navlogo_img']}" : "";
            $def_config['navbar_img']  = !empty($def_config['navbar_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/nav_bg/{$def_config['navbar_img']}" : "";
            $def_config['bt_bg_img']   = !empty($def_config['bt_bg_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/bt_bg/{$def_config['bt_bg_img']}" : "";
        } else {
            $def_config['theme_kind'] = 'xoops';
        }
        return $def_config;
    }

    public static function import_theme_json($theme_name, $def_config = [])
    {
        global $xoopsDB;

        // $theme_json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        $theme_json_file = XOOPS_VAR_PATH . "/data/{$theme_name}_setup.json";

        $json_theme_config_arr = [];
        if (empty($def_config)) {
            $json_theme_config_arr = $def_config = self::def_config($theme_name);
        }

        $file_as_def = false;

        // 檢查資料表是否存在
        $sql    = "SHOW TABLES LIKE '" . $xoopsDB->prefix('tad_themes') . "'";
        $result = Utility::query($sql);
        if ($result && $result->num_rows > 0) {
            // 若 tad_themes 有內容，則存入 $json_theme_config_arr
            $sql    = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes') . "` WHERE `theme_name` = '$theme_name'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            $theme_arr = $xoopsDB->fetchArray($result);

            if (!empty($theme_arr)) {
                foreach ($theme_arr as $k => $v) {
                    if ($k == 'bg_img') {
                        $v = !empty($v) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bg/{$v}" : "";
                    } elseif ($k == 'logo_img') {
                        $v = !empty($v) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/logo/{$v}" : "";
                    } elseif ($k == 'navlogo_img') {
                        $v = !empty($v) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/navlogo/{$v}" : "";
                    } elseif ($k == 'navbar_img') {
                        $v = !empty($v) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/nav_bg/{$v}" : "";
                    } elseif ($k == 'slide_width') {
                        $json_theme_config_arr['use_slide'] = !empty($v) ? 1 : 0;
                    }

                    $json_theme_config_arr[$k] = $def_config[$k] = $v;
                }
            }
        }

        // 僅支援 tad themes 佈景才需要的設定
        if (!empty($def_config['theme_kind']) and $def_config['theme_kind'] != 'xoops') {
            // return 'bootstrap4';

            /****設定各個區域的底色****/
            $left_block   = $left_block2   = $center_block_content   = $right_block   = $right_block2   = "";
            $center_block = "background-color: {$def_config['cb_color']};";

            /****設定各個區域的寬度****/
            if ($def_config['theme_kind'] != 'html') {
                $theme_width = 12;
            }

            //TYPE1:二欄式（左右區域皆在左邊）
            if ($def_config['theme_type'] == 'theme_type_1') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showlblock'] and !$def_config['xoops_showrblock']) {
                        $center_width = $theme_width;
                    } else {
                        $center_width         = $theme_width - $def_config['lb_width'] - 50;
                        $center_content_width = $center_width - 15;
                    }

                    $left_block .= "width:{$def_config['lb_width']}px;";
                    $center_block .= "float:right; width:{$center_width}px;";
                    $center_block_content = "width:{$center_content_width}px;";
                    $right_block .= " width:{$def_config['rb_width']}px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                    if ($def_config['lb_width'] == 'auto') {
                        $def_config['lb_width'] = 12 - $def_config['cb_width'];
                    }
                } else {
                    $center_width = $theme_width - $def_config['lb_width'];
                }

                //TYPE2:二欄式（左右區域皆在右邊）
            } elseif ($def_config['theme_type'] == 'theme_type_2') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showlblock'] and !$def_config['xoops_showrblock']) {
                        $center_width = $theme_width;
                    } else {
                        $center_width = $theme_width - $def_config['rb_width'] - 50;
                    }

                    $left_block .= "width:{$def_config['lb_width']}px;";
                    $center_block .= "float:left;  width:{$center_width}px; padding-left: 15px;";
                    $center_block_content = $center_block;
                    $right_block .= "width:{$def_config['rb_width']}px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                    if ($def_config['rb_width'] == 'auto') {
                        $def_config['rb_width'] = 12 - $def_config['cb_width'];
                    }
                } else {
                    $center_width = $theme_width - $def_config['rb_width'];
                }

                //TYPE3:二欄式（左區域在左邊，右區域在下方）
            } elseif ($def_config['theme_type'] == 'theme_type_3') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showlblock']) {
                        $center_width = $theme_width;
                    } else {
                        $center_width         = $theme_width - $def_config['lb_width'] - 60;
                        $center_content_width = $center_width - 15;
                    }
                    $left_block .= "float:left; width:{$def_config['lb_width']}px;";
                    $center_block .= "float:right;  width:{$center_width}px;";
                    $center_block_content = "width:{$center_content_width}px;";
                    $right_block .= "float:none;  width:{$theme_width}px; clear:both;";
                    $right_block2 .= "float:left; padding-left: 15px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                    if ($def_config['lb_width'] == 'auto') {
                        $def_config['lb_width'] = 12 - $def_config['cb_width'];
                    }
                    $def_config['rb_width'] = "12";
                } else {
                    $def_config['rb_width'] = "12";
                    $center_width           = $theme_width - $def_config['lb_width'];
                }

                //TYPE4:二欄式（左區域在右邊，右區域在下方）
            } elseif ($def_config['theme_type'] == 'theme_type_4') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showrblock']) {
                        $center_width = $theme_width;
                    } else {
                        $center_width = $theme_width - $def_config['lb_width'] - 60;
                    }
                    $left_block .= "float:right; width: {$def_config['lb_width']}px;";
                    $center_block .= "float:left; width: {$center_width}px; padding-left: 10px;";
                    $center_block_content = $center_block;
                    $right_block .= "float:none; width:{$theme_width}px; clear:both;";
                    $right_block2 .= "float:left; padding-left: 15px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                    if ($def_config['lb_width'] == 'auto') {
                        $def_config['lb_width'] = 12 - $def_config['cb_width'];
                    }
                    $def_config['rb_width'] = "12";
                } else {
                    $def_config['rb_width'] = "12";
                    $center_width           = $theme_width - $def_config['lb_width'];
                }

                //TYPE5:三欄式標準配置
            } elseif ($def_config['theme_type'] == 'theme_type_5') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showlblock'] and !$def_config['xoops_showrblock']) {
                        $center_width = $theme_width;
                    } elseif (!$def_config['xoops_showlblock']) {
                    } elseif (!$def_config['xoops_showrblock']) {
                        $center_width = $theme_width - $def_config['lb_width'] - 20;
                    } else {
                        $center_width = $theme_width - $def_config['lb_width'] - $def_config['rb_width'] - 50;
                    }

                    $left_block .= "float:left;  width:{$def_config['lb_width']}px;";
                    $center_block .= "float:left;  width:{$center_width}px;";
                    $right_block .= "float:right;  width:{$def_config['rb_width']}px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                } else {
                    $center_width = $theme_width - $def_config['lb_width'] - $def_config['rb_width'];
                }

                //TYPE6:三欄式（左右區域皆在左邊）
            } elseif ($def_config['theme_type'] == 'theme_type_6') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showlblock'] and !$def_config['xoops_showrblock']) {
                        $center_width = $theme_width;
                    } elseif (!$def_config['xoops_showlblock']) {
                        $center_width = $theme_width - $def_config['rb_width'] - 20;
                    } elseif (!$def_config['xoops_showrblock']) {
                        $center_width = $theme_width - $def_config['lb_width'] - 20;
                    } else {
                        $center_width = $theme_width - $def_config['lb_width'] - $def_config['rb_width'] - 50;
                    }
                    $center_content_width = $center_width - 50;
                    $left_block .= "float:left;  width:{$def_config['lb_width']}px;";
                    $center_block .= "float:right;  width:{$center_width}px;";
                    $center_block_content = "width:{$center_content_width}px;";
                    $right_block .= "float:left;  width:{$def_config['rb_width']}px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                } else {
                    $center_width = $theme_width - $def_config['lb_width'] - $def_config['rb_width'];
                }

                //TYPE7:三欄式（左右區域皆在右邊）
            } elseif ($def_config['theme_type'] == 'theme_type_7') {
                if ($def_config['theme_kind'] == "html") {
                    if (!$def_config['xoops_showlblock'] and !$def_config['xoops_showrblock']) {
                        $center_width = $theme_width;
                    } elseif (!$def_config['xoops_showlblock']) {
                        $center_width = $theme_width - $def_config['rb_width'] - 20;
                    } elseif (!$def_config['xoops_showrblock']) {
                        $center_width = $theme_width - $def_config['lb_width'] - 20;
                    } else {
                        $center_width = $theme_width - $def_config['lb_width'] - $def_config['rb_width'] - 50;
                    }
                    $left_block .= "float:right;  width:{$def_config['lb_width']}px;";
                    $center_block .= "float:left;  width:{$center_width}px; padding-left: 15px;";
                    $right_block .= "float:right;  width:{$def_config['rb_width']}px;";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $center_width = $def_config['cb_width'];
                } else {
                    $center_width = $theme_width - $def_config['lb_width'] - $def_config['rb_width'];
                }

                //TYPE8:單欄式（左區域在上方，右區域在下方）
            } elseif ($def_config['theme_type'] == 'theme_type_8') {
                if ($def_config['theme_kind'] == "html") {
                    $center_width = $def_config['lb_width'] = $def_config['rb_width'] = $theme_width - 30;
                    $left_block .= "float:none;  width:{$def_config['lb_width']}px; padding-left: 10px;";
                    $center_block .= "float:none;  width:{$center_width}px; padding-left: 10px;";
                    $right_block .= "float:none;  width:{$def_config['rb_width']}px; padding-left: 10px;";
                    $center_block_content = "";
                } elseif ($def_config['theme_kind'] == "bootstrap4" || $def_config['theme_kind'] == "bootstrap5") {
                    $def_config['lb_width'] = $center_width = $def_config['rb_width'] = "12";
                } else {
                    $def_config['lb_width'] = $center_width = $def_config['rb_width'] = "12";
                }
            }

            $json_theme_config_arr['content_zone']         = "background-color:{$def_config['base_color']};";
            $json_theme_config_arr['left_block']           = $left_block;
            $json_theme_config_arr['center_block']         = $center_block;
            $json_theme_config_arr['center_block_content'] = $center_block_content;
            $json_theme_config_arr['right_block']          = $right_block;
            $json_theme_config_arr['left_block2']          = $left_block2;
            $json_theme_config_arr['right_block2']         = $right_block2;

            $json_theme_config_arr['lb_width']     = $def_config['lb_width'];
            $json_theme_config_arr['cb_width']     = $def_config['cb_width'];
            $json_theme_config_arr['rb_width']     = $def_config['rb_width'];
            $json_theme_config_arr['center_width'] = $center_width;

            /****設定Logo圖位置****/
            $logo_place = "";
            if (!empty($def_config['logo_top'])) {
                $logo_place .= "top:{$def_config['logo_top']}%;";
            }

            if (!empty($def_config['logo_bottom'])) {
                $logo_place .= "bottom:{$def_config['logo_bottom']}%;";
            }

            if ($def_config['logo_center'] == '1') {
                $logo_place .= "margin-left: auto; margin-right: auto; left: 0; right: 0;";
            } else {

                if (!empty($def_config['logo_left'])) {
                    $logo_place .= "left:{$def_config['logo_left']}%;";
                } elseif (!empty($def_config['logo_right'])) {
                    $logo_place .= "right:{$def_config['logo_right']}%;";
                }

            }
            $json_theme_config_arr['logo_place'] = $logo_place;

            list($navbar_bg_top_rgb['r'], $navbar_bg_top_rgb['g'], $navbar_bg_top_rgb['b'])          = sscanf($def_config['navbar_bg_top'], "#%02x%02x%02x");
            $json_theme_config_arr['navbar_bg_top_rgb']                                              = $navbar_bg_top_rgb;
            list($navbar_bg_bottom_rgb['r'], $navbar_bg_bottom_rgb['g'], $navbar_bg_bottom_rgb['b']) = sscanf($def_config['navbar_bg_bottom'], "#%02x%02x%02x");
            $json_theme_config_arr['navbar_bg_bottom_rgb']                                           = $navbar_bg_bottom_rgb;

            /****若有logo.png或logo.gif時導覽工具列以圖替代網站標題文字****/
            if ($def_config['navlogo_img']) {
                $json_theme_config_arr['navbar_logo_img'] = $def_config['navlogo_img'];
            }

            /****區塊標題設定****/
            $db = [];
            if (isset($json_theme_config_arr['theme_id'])) {
                $sql    = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_blocks') . '` WHERE `theme_id` = ' . $json_theme_config_arr['theme_id'];
                $result = $xoopsDB->query($sql);
                while (false !== ($all = $xoopsDB->fetchArray($result))) {
                    $block_position      = $all['block_position'];
                    $all['bt_bg_img']    = $all['bt_bg_img'] ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$all['bt_bg_img']}" : '';
                    $db[$block_position] = $all;
                }
            }

            $block_position                          = ['leftBlock', 'rightBlock', 'centerBlock', 'centerLeftBlock', 'centerRightBlock', 'centerBottomBlock', 'centerBottomLeftBlock', 'centerBottomRightBlock', 'footerCenterBlock', 'footerLeftBlock', 'footerRightBlock'];
            $json_theme_config_arr['block_position'] = $def_config['block_position'];
            $use_default_config                      = $json_theme_config_arr['use_default_config']                      = false;
            $i                                       = 0;
            $positions                               = [];
            foreach ($block_position as $position) {
                $positions[$i]['block_position']      = $position;
                $positions[$i]['block_config']        = $use_default_config ? $def_config['block_config'][$position] : $db[$position]['block_config'];
                $positions[$i]['bt_text']             = $use_default_config ? $def_config['bt_text'][$position] : $db[$position]['bt_text'];
                $positions[$i]['bt_text_padding']     = $use_default_config ? $def_config['bt_text_padding'][$position] : $db[$position]['bt_text_padding'];
                $positions[$i]['bt_text_size']        = $use_default_config ? $def_config['bt_text_size'][$position] : $db[$position]['bt_text_size'];
                $positions[$i]['bt_bg_color']         = $use_default_config ? $def_config['bt_bg_color'][$position] : $db[$position]['bt_bg_color'];
                $positions[$i]['bt_bg_img']           = $use_default_config ? $def_config['bt_bg_img'][$position] : $db[$position]['bt_bg_img'];
                $positions[$i]['bt_bg_repeat']        = $use_default_config ? $def_config['bt_bg_repeat'][$position] : $db[$position]['bt_bg_repeat'];
                $positions[$i]['bt_radius']           = $use_default_config ? $def_config['bt_radius'][$position] : $db[$position]['bt_radius'];
                $positions[$i]['block_style']         = $use_default_config ? $def_config['block_style'][$position] : $db[$position]['block_style'];
                $positions[$i]['block_title_style']   = $use_default_config ? $def_config['block_title_style'][$position] : $db[$position]['block_title_style'];
                $positions[$i]['block_content_style'] = $use_default_config ? $def_config['block_content_style'][$position] : $db[$position]['block_content_style'];

                $json_theme_config_arr[$position] = $positions[$i];
                $i++;
            }
            $json_theme_config_arr['positions'] = $positions;

            if (!file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}")) {
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg/thumbs");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide/thumbs");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo/thumbs");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg/thumbs");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg/thumbs");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2");
                Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2/thumbs");
                self::copy_default_file($theme_name);
            }

            $array_type     = ['custom_zone', 'array', 'checkbox'];
            $block_position = ['leftBlock', 'rightBlock', 'centerBlock', 'centerLeftBlock', 'centerRightBlock', 'centerBottomBlock', 'centerBottomLeftBlock', 'centerBottomRightBlock', 'footerCenterBlock', 'footerLeftBlock', 'footerRightBlock'];
            $block_config   = ['block_config', 'bt_text', 'bt_text_padding', 'bt_text_size', 'bt_bg_color', 'bt_bg_img', 'bt_bg_repeat', 'bt_radius', 'block_style', 'block_title_style', 'block_content_style'];

            $TadDataCenter = new TadDataCenter('tad_themes');

            if (empty($json_theme_config_arr['theme_id'])) {
                $file_as_def = true;
            }

            // 若 TadDataCenter 有內容，則存入 $json_theme_config_arr
            $TadDataCenter->set_col('theme_id', $theme_arr['theme_id']);
            $data = $TadDataCenter->getData();
            foreach ($data as $var_name => $var_val) {
                if ($var_name == 'navbar_font_size' and $var_val[0] > 10) {
                    $var_val[0] = round($var_val[0] / 100, 2);
                }

                $json_theme_config_arr[$var_name] = $var_val[0];
            }

            // 若 tad_themes_config2 有內容，則存入 $json_theme_config_arr
            $sql    = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` WHERE `theme_id`=' . (int) $theme_arr['theme_id'];
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            while ($config2 = $xoopsDB->fetchArray($result)) {
                if (in_array($config2['type'], $array_type)) {
                    $json_theme_config_arr[$config2['name']] = \json_decode($config2['value'], true);
                } elseif (preg_match('/^\s*({|\[).*?(}|\])\s*$/', $config2['value']) === 1) {
                    $json_theme_config_arr[$config2['name']]          = $config2['value'];
                    $json_theme_config_arr[$config2['name'] . '_arr'] = \json_decode($config2['value'], true);
                } elseif ($config2['type'] == "checkbox") {
                    if (!empty($config2['value']) && !is_array($config2['value'])) {
                        $json_theme_config_arr[$config2['name']] = json_decode($config2['value'], true);
                    }
                } elseif ($config2['type'] == "file" or $config2['type'] == "bg_file") {
                    $json_theme_config_arr[$config2['name']] = !empty($config2['value']) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/config2/{$config2['value']}" : '';
                } else {
                    $json_theme_config_arr[$config2['name']] = $config2['value'];
                }
            }

            if ($file_as_def) {
                // 若有儲存風格檔，則以風格檔的設定值為主，否則以主題檔的設定值為主，否則以資料庫為主
                if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php")) {
                    include XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php";
                } elseif (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
                    include XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
                }

                // $json_theme_config_arr['theme_kind'] =  $def_config['theme_kind'];

                if (!empty($config_enable)) {
                    foreach ($config_enable as $config_item => $val_arr) {
                        if (in_array($config_item, $block_config)) {
                            foreach ($block_position as $position) {
                                if ($db_as_def) {
                                    $json_theme_config_arr[$config_item][$position] = isset($json_theme_config_arr[$config_item][$position]) ? $json_theme_config_arr[$config_item][$position]['default'] : $val_arr['default'];
                                } elseif (is_array($json_theme_config_arr[$config_item])) {
                                    $json_theme_config_arr[$config_item][$position] = isset($config_enable[$config_item][$position]) ? $config_enable[$config_item][$position]['default'] : $val_arr['default'];
                                }
                            }
                        } else {
                            $json_theme_config_arr[$config_item] = $db_as_def ? $json_theme_config_arr[$config_item] : $val_arr['default'];
                        }

                    }
                }
                // echo "2=>{$json_theme_config_arr['bg_color']}<br>";

                // 額外設定部份，若有儲存風格檔，則以風格檔的設定值為主，否則以主題檔的設定值為主
                $config2_files = ['config2_base', 'config2_bg', 'config2_top', 'config2_logo', 'config2_nav', 'config2_slide', 'config2_middle', 'config2_content', 'config2_block', 'config2_footer', 'config2_bottom', 'config2'];
                foreach ($config2_files as $config2_file) {

                    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
                        $theme_config = [];
                        require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";

                        foreach ($theme_config as $k => $config) {
                            $config2_name = $config['name'];
                            $value        = $$config2_name;

                            if ($config['type'] == "array") {
                                $value = str_replace("{XOOPS_URL}", XOOPS_URL, $value);
                                $value = json_decode($value, true);
                            } elseif ($config['type'] == "checkbox") {
                                if (!empty($value) && !is_array($value)) {
                                    $value = json_decode($value, true);
                                }
                            } elseif ($config['type'] == "file" or $config['type'] == "bg_file") {
                                $value = !empty($value) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/config2/{$value}" : '';
                            }

                            $json_theme_config_arr[$config2_name] = $value;

                            $json_theme_config_arr[$k]['value'] = $json_theme_config_arr[$k]['default'] = $value;

                            if ($config['type'] == "bg_file") {
                                $json_theme_config_arr[$k]['repeat']   = ${$config2_name . '_repeat'};
                                $json_theme_config_arr[$k]['position'] = ${$config2_name . '_position'};
                                $json_theme_config_arr[$k]['size']     = ${$config2_name . '_size'};
                            } elseif ($config['type'] == 'custom_zone') {
                                $json_theme_config_arr[$k]['deault']            = isset(${$config2_name}) ? ${$config2_name} : '';
                                $json_theme_config_arr[$k]['block']             = isset(${$config2_name . '_block'}) ? ['hi' => 'tad'] : [];
                                $json_theme_config_arr[$k]['content']           = isset(${$config2_name . '_content'}) ? ${$config2_name . '_content'} : '';
                                $json_theme_config_arr[$k]['html_content']      = isset(${$config2_name . '_html_content'}) ? ${$config2_name . '_html_content'} : '';
                                $json_theme_config_arr[$k]['html_content_desc'] = isset($config['html_content_desc']) ? $config['html_content_desc'] : '';
                                $json_theme_config_arr[$k]['fa_content']        = isset(${$config2_name . '_fa_content'}) ? ${$config2_name . '_fa_content'} : '';
                                $json_theme_config_arr[$k]['fa_content_desc']   = isset($config['fa_content_desc']) ? $config['fa_content_desc'] : '';
                                $json_theme_config_arr[$k]['menu_content']      = isset(${$config2_name . '_menu_content'}) ? ${$config2_name . '_menu_content'} : '';
                                $json_theme_config_arr[$k]['menu_content_desc'] = isset($config['menu_content_desc']) ? $config['menu_content_desc'] : '';

                            } elseif ($config['type'] == "padding_margin") {
                                $json_theme_config_arr[$k]['mt'] = ${$config2_name . '_mt'};
                                $json_theme_config_arr[$k]['mb'] = ${$config2_name . '_mb'};
                            }
                        }
                        $json_theme_config_arr['config2'] = $config2;
                    }

                }
            }

            // 滑動圖
            $slider_var                          = self::get_theme_slide_items($theme_name);
            $json_theme_config_arr['slider_var'] = $slider_var;

        } else {
            $json_theme_config_arr['theme_kind'] = 'xoops';
        }

        if (!file_put_contents($theme_json_file, json_encode($json_theme_config_arr, 256))) {
            throw new \Exception(sprintf(_TAD_MKFILE_ERROR, $theme_json_file));
        }
        return $json_theme_config_arr;
    }

    // 匯入或套用設定檔
    public static function copy_default_file($theme_name)
    {
        $source = XOOPS_ROOT_PATH . "/themes/{$theme_name}/images";
        $target = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}";
        Utility::mk_dir($target);
        Utility::full_copy($source, $target);
    }

    public static function theme_config($theme_name, $def_config = [])
    {
        // $theme_json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        $theme_json_file = XOOPS_VAR_PATH . "/data/{$theme_name}_setup.json";

        if (!file_exists($theme_json_file)) {
            self::import_theme_json($theme_name, $def_config);
        }

        $theme_config = json_decode(file_get_contents($theme_json_file), true);

        $theme_config['use_slide'] = (int) $theme_config['slide_width'] > 0 ? 1 : 0;

        /**** Tad Themes 的設定值****/
        if (file_exists(XOOPS_ROOT_PATH . "/modules/tad_themes/xoops_version.php")) {
            $file_col  = ['bg_img' => 'bg', 'logo_img' => 'logo', 'navlogo_img' => 'navlogo', 'navbar_img' => 'nav_bg'];
            $file_cols = array_keys($file_col);
            if (!empty($theme_config) and !empty($theme_config['theme_width'])) {
                foreach ($theme_config as $k => $v) {
                    $$k = $v;
                    if (in_array($k, $file_cols) and $v != '') {
                        $theme_config[$k] = XOOPS_URL . "/uploads/tad_themes/{$theme_name}/{$file_col[$k]}/{$v}";
                    } elseif (!empty($v) && !is_array($v) && substr($v, 0, 1) == '{' && substr($v, -1) == '}') {
                        $theme_config[$k . '_arr'] = json_decode($v, true);
                    }
                }
            }

            if (empty($theme_config['theme_id'])) {
                $theme_config['use_default_config'] = true;
            }

        } else {
            $theme_config['use_default_config'] = true;
        }

        return $theme_config;
    }

    public static function theme_type($id = "", $other_menu = true)
    {
    }

    public static function get_theme_menu_items($id = "", $menu_var_kind = 'my_menu')
    {
        global $xoopsDB, $xoopsUser;

        // 使用靜態快取來儲存菜單項目
        static $menu_cache = [];
        $cache_key         = $id . '_' . $menu_var_kind;

        if (isset($menu_cache[$cache_key])) {
            return $menu_cache[$cache_key];
        }

        // 獲取使用者群組
        $User_Groups = $xoopsUser ? $xoopsUser->getGroups() : [3];

        // 如果不是所需的菜單類型，直接返回空數組
        if (strpos($menu_var_kind, 'all') === false && strpos($menu_var_kind, 'my_menu') === false) {
            return [];
        }

        // 預先獲取所有子菜單項目
        $all_menu_items = [];
        $moduleHandler  = xoops_getHandler('module');

        $sql = 'SELECT `menuid`, `itemname`, `itemurl`, `target`, `icon`, `link_cate_name`,
                `link_cate_sn`, `read_group`, `of_level`
                FROM `' . $xoopsDB->prefix('tad_themes_menu') . '`
                WHERE `status` = 1
                ORDER BY `of_level`, `position`';

        $result = $xoopsDB->query($sql);

        if (!$result) {
            return [];
        }

        // 建立菜單項目的層次結構
        $menu_hierarchy = [];
        while ($row = $xoopsDB->fetchArray($result)) {
            $of_level = $row['of_level'];
            if (!isset($menu_hierarchy[$of_level])) {
                $menu_hierarchy[$of_level] = [];
            }
            $menu_hierarchy[$of_level][] = $row;
        }

        // 遞迴構建菜單
        $my_menu = self::buildMenuTree($id, $menu_hierarchy, $User_Groups, $moduleHandler);

        // 儲存到快取
        $menu_cache[$cache_key] = $my_menu;

        return $my_menu;
    }

    private static function buildMenuTree($parent_id, &$menu_hierarchy, $User_Groups, $moduleHandler)
    {
        if (!isset($menu_hierarchy[$parent_id])) {
            return [];
        }

        $menu = [];
        foreach ($menu_hierarchy[$parent_id] as $item) {
            // 檢查讀取權限
            $read_group       = empty($item['read_group']) ? '1,2,3' : $item['read_group'];
            $read_group_array = explode(',', $read_group);

            if (!array_intersect($User_Groups, $read_group_array)) {
                continue;
            }

            // 處理特殊類別
            if (!empty($item['link_cate_name'])) {
                if ($item['link_cate_name'] === 'tadnews_page_cate') {
                    $TadNewsModule = $moduleHandler->getByDirname('tadnews');
                    if (!$TadNewsModule) {
                        continue;
                    }
                }
                $custom_menu = self::get_custom_menu_items($item['link_cate_name'], $item['link_cate_sn']);
                $sub_menu    = self::buildMenuTree($item['menuid'], $menu_hierarchy, $User_Groups, $moduleHandler);
                $submenu     = array_merge($custom_menu, $sub_menu);
            } else {
                $submenu = self::buildMenuTree($item['menuid'], $menu_hierarchy, $User_Groups, $moduleHandler);
            }

            $menu[] = [
                'id' => $item['menuid'],
                'title' => $item['itemname'],
                'url' => ($item['itemurl'] == '' || $item['itemurl'] == '#') ? '' : $item['itemurl'],
                'target' => $item['target'],
                'icon' => str_replace(['icon-'], ['fa-'], $item['icon']),
                'img' => '',
                'read_group' => $read_group_array,
                'submenu' => $submenu,
            ];
        }

        return $menu;
    }

    //取得其他模組單元的選單
    public static function get_custom_menu_items($link_cate_name, $link_cate_sn)
    {
        global $xoopsDB;
        $i        = 0;
        $sub_menu = [];

        switch ($link_cate_name) {

            case "tadnews_page_cate":
                $link_cate_sn = (int) $link_cate_sn;
                $sql          = 'SELECT `nsn`, `news_title` FROM `' . $xoopsDB->prefix('tad_news') . "` WHERE `ncsn` = '$link_cate_sn' ORDER BY `page_sort`";
                $result       = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

                while (list($nsn, $news_title) = $xoopsDB->fetchRow($result)) {
                    $sub_menu[$link_cate_name . $i]['id']      = $i;
                    $sub_menu[$link_cate_name . $i]['title']   = $news_title;
                    $sub_menu[$link_cate_name . $i]['url']     = XOOPS_URL . "/modules/tadnews/page.php?ncsn={$link_cate_sn}&nsn={$nsn}";
                    $sub_menu[$link_cate_name . $i]['target']  = "_self";
                    $sub_menu[$link_cate_name . $i]['icon']    = '';
                    $sub_menu[$link_cate_name . $i]['submenu'] = "";
                    $i++;
                }
                break;
        }

        return $sub_menu;
    }

    //取得模組選單
    public static function get_module_menu_item($i)
    {
        global $xoopsModuleConfig;
        $dir = '';
        $u   = parse_url($_SERVER['REQUEST_URI']);
        if (!empty($u['path']) and strpos($u['path'], '/modules/') !== false) {
            preg_match_all('/\/modules\/(.*)\//', $u['path'], $all);
            $dir = $all[1][0];
        }
        if (empty($dir)) {
            return;
        }

        if (file_exists(XOOPS_ROOT_PATH . "/modules/{$dir}/interface_menu.php")) {
            if (!isset($xoopsModuleConfig['tootbar_in_navbar']) or $xoopsModuleConfig['tootbar_in_navbar'] == 1) {
                require XOOPS_ROOT_PATH . "/modules/{$dir}/interface_menu.php";
                foreach ($interface_menu as $title => $url) {
                    $my_menu[$i]['id']     = $i;
                    $my_menu[$i]['title']  = $title;
                    $my_menu[$i]['target'] = "_self";
                    $my_menu[$i]['icon']   = isset($interface_icon) ? $interface_icon[$title] : '';
                    $my_menu[$i]['img']    = isset($interface_menu_img) ? XOOPS_URL . "/modules/{$dir}/images/{$interface_menu_img[$title]}" : '';

                    if (is_array($url)) {
                        $my_menu[$i]['url'] = 'index.php';
                        $sub_menu           = [];
                        $j                  = 0;
                        foreach ($url as $title2 => $url2) {
                            if ($title2 == 'icon') {
                                continue;
                            }
                            $sub_menu[$j]['id']      = $j;
                            $sub_menu[$j]['title']   = $title2;
                            $sub_menu[$j]['url']     = strpos($url2, 'http') === false ? XOOPS_URL . "/modules/{$dir}/{$url2}" : $url2;
                            $sub_menu[$j]['target']  = "_self";
                            $sub_menu[$j]['icon']    = isset($interface_icon) ? $interface_icon[$title][$title2] : '';
                            $sub_menu[$j]['submenu'] = '';
                            $j++;
                        }
                        $my_menu[$i]['submenu'] = $sub_menu;
                    } else {
                        $my_menu[$i]['url']     = strpos($url, 'http') === false ? XOOPS_URL . "/modules/{$dir}/{$url}" : $url;
                        $my_menu[$i]['submenu'] = "";
                    }
                    $i++;
                }
            }
        } else {
            return;
        }
        return $my_menu;
    }

    //取得使用者選單
    public static function get_user_menu_item($i)
    {
        global $xoopsUser;
        if ($xoopsUser) {
            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_MYMENU;
            $my_menu[$i]['url']     = "#";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "";
            $my_menu[$i]['submenu'] = self::get_user_submenu_item();
        } else {
            return;
        }

        return $my_menu;
    }

    //取得使用者選單子項目
    public static function get_user_submenu_item()
    {
        global $xoopsDB, $xoopsUser;
        $i = 0;
        if ($xoopsUser && $xoopsUser->isAdmin(1)) {
            $sql    = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . "` WHERE `conf_title` = '_MD_AM_DEBUGMODE'";
            $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());

            list($debug) = $xoopsDB->fetchRow($result);
            if ($debug == 0) {
                $debug = 1;
            } else {
                $debug = 0;
            }

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_USER_ADMIN;
            $my_menu[$i]['url']     = XOOPS_URL . "/admin.php";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-th-large";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_SYSTEM_CONFIG;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/system/admin.php?fct=preferences&op=show&confcat_id=1";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-cog";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_SYSTEM_MODADM;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/tad_adm/admin/main.php";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-wrench";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_SYSTEM_DBADM;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/tad_adm/pma.php?server=" . XOOPS_DB_HOST . "&db=" . XOOPS_DB_NAME;
            $my_menu[$i]['target']  = "_blank";
            $my_menu[$i]['icon']    = "fa-database";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_THEME_ADMIN;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/tad_themes/admin/main.php";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-list-alt";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = ($debug == 1) ? _TAD_TF_THEME_DEBUG : _TAD_TF_THEME_UNDEBUG;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/tadtools/themes_common/tools/debug.php?op=debug&v={$debug}";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-warning";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_USER_BLOCK;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=-1&selmod=-2&selgrp=-1&selvis=1";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-cubes";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = _TAD_TF_USER_TAD_BLOCK;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/tad_blocks/blocks.php";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = "fa-th";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = 'separator';
            $my_menu[$i]['url']     = '';
            $my_menu[$i]['target']  = "";
            $my_menu[$i]['icon']    = "";
            $my_menu[$i]['submenu'] = "";
            $i++;
        }

        $pmcount                = isset($_SESSION['xoops_inbox_count']) ? $_SESSION['xoops_inbox_count'] : 0;
        $my_menu[$i]['id']      = $i;
        $my_menu[$i]['title']   = !empty($pmcount) ? sprintf(_TAD_TF_USER_NEWMSG, $pmcount) : _TAD_TF_USER_MSG;
        $my_menu[$i]['url']     = XOOPS_URL . "/viewpmsg.php";
        $my_menu[$i]['target']  = "_self";
        $my_menu[$i]['icon']    = "fa-envelope";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id']      = $i;
        $my_menu[$i]['title']   = _TAD_TF_USER_NOTICE;
        $my_menu[$i]['url']     = XOOPS_URL . "/notifications.php";
        $my_menu[$i]['target']  = "_self";
        $my_menu[$i]['icon']    = "fa-bell";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id']      = $i;
        $my_menu[$i]['title']   = _TAD_TF_THEME_ADMIN;
        $my_menu[$i]['url']     = XOOPS_URL . "/modules/tad_themes/admin/main.php";
        $my_menu[$i]['target']  = "_self";
        $my_menu[$i]['icon']    = "fa-list-alt";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id']      = $i;
        $my_menu[$i]['title']   = _TAD_TF_USER_PROFILE;
        $my_menu[$i]['url']     = XOOPS_URL . "/user.php";
        $my_menu[$i]['target']  = "_self";
        $my_menu[$i]['icon']    = "fa-user";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id']      = $i;
        $my_menu[$i]['title']   = _TAD_TF_USER_EXIT;
        $my_menu[$i]['url']     = XOOPS_URL . "/user.php?op=logout";
        $my_menu[$i]['target']  = "_self";
        $my_menu[$i]['icon']    = "fa-share";
        $my_menu[$i]['submenu'] = "";

        return $my_menu;
    }

    // 滑動圖設定
    public static function get_theme_slide_items($theme_name)
    {
        global $xoopsDB;
        $sql = 'SELECT a.* FROM `' . $xoopsDB->prefix('tad_themes_files_center') . '` AS a
        LEFT JOIN `' . $xoopsDB->prefix('tad_themes') . "` AS b ON a.`col_sn` = b.`theme_id`
        WHERE a.`col_name` = 'slide' AND b.`theme_name` = '{$theme_name}'";
        $result     = $xoopsDB->query($sql);
        $slider_var = [];
        if ($result) {
            $i = 0;
            while (false !== ($data = $xoopsDB->fetchArray($result))) {
                foreach ($data as $k => $v) {
                    $$k = $v;
                }
                //`files_sn`, `col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir`

                preg_match_all("/\](.*)\[/", $description, $matches);
                $url = isset($matches[1][0]) ? $matches[1][0] : '';
                if (empty($url)) {
                    $url = XOOPS_URL;
                }

                if (strpos($description, 'url_blank') !== false) {
                    $description = str_replace("[url_blank]{$url}[/url_blank]", "", $description);
                    $target      = "target='_blank'";
                } else {
                    $description = str_replace("[url]{$url}[/url]", "", $description);
                    $target      = "";
                }

                $slider_var[$i]['files_sn']          = $files_sn;
                $slider_var[$i]['sort']              = $sort;
                $slider_var[$i]['file_name']         = $file_name;
                $slider_var[$i]['description']       = $description;
                $slider_var[$i]['text_description']  = strip_tags($description);
                $slider_var[$i]['original_filename'] = $original_filename;
                $slider_var[$i]['sub_dir']           = $sub_dir;
                $slider_var[$i]['file_url']          = XOOPS_URL . "/uploads/tad_themes{$sub_dir}/{$file_name}";
                $slider_var[$i]['file_thumb_url']    = XOOPS_URL . "/uploads/tad_themes{$sub_dir}/thumbs/{$file_name}";
                $slider_var[$i]['slide_url']         = $url;
                $slider_var[$i]['slide_target']      = $target;
                $i++;
            }
        }
        return $slider_var;

    }
}
