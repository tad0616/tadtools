<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

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
    // 取得佈景預設設定值
    public static function def_config($TadThemesMid, $theme_name)
    {
        global $aggreg, $xoopsConfig, $xoopsTpl;

        $configHandler = xoops_getHandler('config');
        $def_config = $configHandler->getConfigsByCat(0, $TadThemesMid);

        $def_config['TadThemesMid'] = $TadThemesMid;

        /**** 取得左右區塊數 ****/
        $def_config['left_count'] = $aggreg ? count($aggreg->blocks['canvas_left']) : 0;
        $def_config['right_count'] = $aggreg ? count($aggreg->blocks['canvas_right']) : 0;
        $def_config['xoops_showlblock'] = empty($def_config['left_count']) ? false : true;
        $def_config['xoops_showrblock'] = empty($def_config['right_count']) ? false : true;
        /**** 取得 Tad Themes 偏好設定****/

        /**** 取得佈景設定的各個預設值 ****/
        require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
        require_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/main.php";

        $xoopsTpl->assign('config_tabs', $config_tabs);
        foreach ($config_enable as $k => $v) {
            $def_config[$k] = $v['default'];
        }
        $def_config['theme_change'] = $theme_change;
        $def_config['theme_kind'] = $theme_kind;
        $def_config['theme_kind_arr'] = explode(',', $theme_kind_arr);
        $def_config['menu_var_kind'] = $_SESSION['menu_var_kind'] = $menu_var_kind;
        $def_config['theme_color'] = $theme_color;
        $def_config['theme_set_allowed'] = $theme_set_allowed;

        /**** 產生 Smarty 的設定檔（以取得 bootstrap 版本） ****/
        $bootstrap = (strpos($theme_kind, 'bootstrap') !== false) ? substr($theme_kind, -1) : '4';
        $xoopsTpl->assign('bootstrap', $bootstrap);

        /**** 模擬偏好設定預設值（避免沒裝 tad_theme 無法取得資料庫資料） ****/
        $def_config['bg_img'] = !empty($def_config['bg_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/bg/{$def_config['bg_img']}" : "";
        $def_config['logo_img'] = !empty($def_config['logo_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/logo/{$def_config['logo_img']}" : "";
        $def_config['navlogo_img'] = !empty($def_config['navlogo_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/navlogo/{$def_config['navlogo_img']}" : "";
        $def_config['navbar_img'] = !empty($def_config['navbar_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/nav_bg/{$def_config['navbar_img']}" : "";
        $def_config['bt_bg_img'] = !empty($def_config['bt_bg_img']) ? XOOPS_URL . "/themes/{$theme_name}/images/bt_bg/{$def_config['bt_bg_img']}" : "";

        return $def_config;
    }

    public static function import_theme_json($theme_name)
    {
        global $xoopsDB;

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

        $array_type = ['custom_zone', 'array', 'checkbox'];
        $block_position = ['leftBlock', 'rightBlock', 'centerBlock', 'centerLeftBlock', 'centerRightBlock', 'centerBottomBlock', 'centerBottomLeftBlock', 'centerBottomRightBlock', 'footerCenterBlock', 'footerLeftBlock', 'footerRightBlock'];
        $block_config = ['block_config', 'bt_text', 'bt_text_padding', 'bt_text_size', 'bt_bg_color', 'bt_bg_img', 'bt_bg_repeat', 'bt_radius', 'block_style', 'block_title_style', 'block_content_style'];

        $TadDataCenter = new TadDataCenter('tad_themes');

        $json_theme_config_arr = [];
        $json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        if (file_exists($json_file)) {
            \unlink($json_file);
        }

        // 若 tad_themes 有內容，則存入 $json_theme_config_arr
        $sql = 'select * from ' . $xoopsDB->prefix('tad_themes') . " where `theme_name`='{$theme_name}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $theme_arr = $xoopsDB->fetchArray($result);
        foreach ($theme_arr as $k => $v) {
            $json_theme_config_arr[$k] = $v;
        }

        // 若 TadDataCenter 有內容，則存入 $json_theme_config_arr
        $TadDataCenter->set_col('theme_id', $theme_arr['theme_id']);
        $tdc = $TadDataCenter->getData();
        foreach ($tdc as $k => $v) {
            $json_theme_config_arr['TDC'][$k] = $v[0];
        }

        // 若 tad_themes_config2 有內容，則存入 $json_theme_config_arr
        $sql = 'select * from ' . $xoopsDB->prefix('tad_themes_config2') . " where `theme_id`='{$theme_arr['theme_id']}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while ($config2 = $xoopsDB->fetchArray($result)) {
            $json_theme_config_arr[$config2['name']] = in_array($config2['type'], $array_type)?\json_decode($config2['value'], true) : $config2['value'];
        }

        // 若 tad_themes_blocks 有內容，則存入 $json_theme_config_arr
        $sql = 'select * from ' . $xoopsDB->prefix('tad_themes_blocks') . " where `theme_id`='{$theme_arr['theme_id']}'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while ($block = $xoopsDB->fetchArray($result)) {

            foreach ($block_config as $item) {
                foreach ($block_position as $position) {
                    $json_theme_config_arr[$item][$position] = $block[$item];
                }
            }
        }

        // 若有儲存風格檔，則以風格檔的設定值為主，否則以主題檔的設定值為主
        if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php")) {
            include XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php";
        } elseif (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
            include XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
        }

        $json_theme_config_arr['theme_kind'] = $theme_kind;

        if (!empty($config_enable)) {
            foreach ($config_enable as $config_item => $val_arr) {
                if (in_array($config_item, $block_config)) {
                    foreach ($block_position as $position) {
                        $json_theme_config_arr[$config_item][$position] = isset($config_enable[$config_item][$position]) ? $config_enable[$config_item][$position]['default'] : $val_arr['default'];
                    }
                } else {
                    $json_theme_config_arr[$config_item] = $val_arr['default'];
                }

            }
        }

        // 額外設定部份，若有儲存風格檔，則以風格檔的設定值為主，否則以主題檔的設定值為主
        $config2_files = ['config2_base', 'config2_bg', 'config2_top', 'config2_logo', 'config2_nav', 'config2_slide', 'config2_middle', 'config2_content', 'config2_block', 'config2_footer', 'config2_bottom', 'config2'];
        foreach ($config2_files as $config2_file) {

            if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php")) {
                $json_theme_config_arr['config2'][] = $config2_file;
                include XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php";
            } elseif (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
                $json_theme_config_arr['config2'][] = $config2_file;
                include XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";
            }

            if (!empty($theme_config)) {
                // Utility::dd($theme_config);
                foreach ($theme_config as $k => $config) {
                    if (!isset($json_theme_config_arr[$config['name']])) {
                        $json_theme_config_arr[$config['name']] = $config['default'];
                    }

                    if ($config['type'] == "bg_file") {
                        $json_theme_config_arr[$config['name'] . '_repeat'] = $config['repeat'];
                        $json_theme_config_arr[$config['name'] . '_position'] = $config['position'];
                        $json_theme_config_arr[$config['name'] . '_size'] = $config['size'];

                    } elseif ($config['type'] == 'custom_zone') {
                        $json_theme_config_arr[$config['name']] = \json_decode($config['default'], true);
                        $json_theme_config_arr[$config['name'] . '_bid'] = $config['bid'];
                        $json_theme_config_arr[$config['name'] . '_content'] = $config['content'];
                        $json_theme_config_arr[$config['name'] . '_html_content'] = $config['html_content'];
                        $json_theme_config_arr[$config['name'] . '_html_content_desc'] = isset($config['html_content_desc']) ? $config['html_content_desc'] : '';
                        $json_theme_config_arr[$config['name'] . '_fa_content'] = $config['fa_content'];
                        $json_theme_config_arr[$config['name'] . '_fa_content_desc'] = isset($config['fa_content_desc']) ? $config['fa_content_desc'] : '';
                        $json_theme_config_arr[$config['name'] . '_menu_content'] = $config['menu_content'];
                        $json_theme_config_arr[$config['name'] . '_menu_content_desc'] = isset($config['menu_content_desc']) ? $config['menu_content_desc'] : '';

                    } elseif ($config['type'] == "padding_margin") {
                        $json_theme_config_arr[$config['name'] . '_mt'] = $config['mt'];
                        $json_theme_config_arr[$config['name'] . '_mb'] = $config['mb'];
                    }
                }
            }
        }

        // Utility::dd($json_theme_config_arr);
        file_put_contents($json_file, json_encode($json_theme_config_arr, 256));
    }

    // 匯入或套用設定檔
    public static function copy_default_file($theme_name)
    {
        $source = XOOPS_ROOT_PATH . "/themes/{$theme_name}/images";
        $target = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}";
        Utility::mk_dir($target);
        Utility::full_copy($source, $target);
    }

    public static function theme_config($theme_name)
    {
        $json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        if (!file_exists($json_file)) {
            self::import_theme_json($theme_name);
        }

        $theme_config = json_decode(file_get_contents($json_file), true);

        $theme_config['use_slide'] = $theme_config['slide_width'] > 0 ? 1 : 0;
        /**** Tad Themes 的設定值****/
        if (file_exists(XOOPS_ROOT_PATH . "/modules/tad_themes/xoops_version.php")) {
            $file_col = ['bg_img' => 'bg', 'logo_img' => 'logo', 'navlogo_img' => 'navlogo', 'navbar_img' => 'nav_bg'];
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

    //取得選單選項
    public static function get_theme_menu_items($id = "", $other_menu = true)
    {
        global $xoopsDB, $xoopsUser;
        //取得目前使用者的所屬群組
        if ($xoopsUser) {
            $User_Groups = $xoopsUser->getGroups();
        } else {
            $User_Groups = array(3);
        }

        $my_menu = array();
        $i = 0;
        if (strpos($_SESSION['menu_var_kind'], 'all') !== false or strpos($_SESSION['menu_var_kind'], 'my_menu') !== false) {

            $sql = "select `menuid`, `itemname`, `itemurl`, `target`, `icon`, `link_cate_name`, `link_cate_sn`, `read_group` from " . $xoopsDB->prefix("tad_themes_menu") . " where of_level='{$id}' and status='1' order by position";
            $result = $xoopsDB->query($sql) or die($sql);
            $moduleHandler = xoops_getHandler('module');
            if ($result) {
                while (list($menuid, $itemname, $itemurl, $target, $icon, $link_cate_name, $link_cate_sn, $read_group) = $xoopsDB->fetchRow($result)) {
                    if (empty($read_group)) {
                        $read_group = '1,2,3';
                    }
                    $read_group_array = explode(',', $read_group);
                    if (array_intersect($User_Groups, $read_group_array)) {
                        if (!empty($link_cate_name)) {

                            switch ($link_cate_name) {

                                case "tadnews_page_cate":
                                    $TadNewsModule = $moduleHandler->getByDirname("tadnews");
                                    if (!$TadNewsModule) {
                                        continue 2;
                                    }
                                    break;
                            }
                            $custom_menu = self::get_custom_menu_items($link_cate_name, $link_cate_sn);
                            $sub_menu = self::get_theme_menu_items($menuid, false);
                            $my_menu[$i]['submenu'] = array_merge($custom_menu, $sub_menu);
                        } else {
                            $my_menu[$i]['submenu'] = self::get_theme_menu_items($menuid, false);
                        }

                        $my_menu[$i]['id'] = $menuid;
                        $my_menu[$i]['title'] = $itemname;
                        $my_menu[$i]['url'] = ($itemurl == '' or $itemurl == '#') ? '' : $itemurl;
                        $my_menu[$i]['target'] = $target;
                        $my_menu[$i]['icon'] = str_replace('icon-', 'fa-', $icon);
                        $my_menu[$i]['img'] = '';
                        $my_menu[$i]['read_group'] = explode(',', $read_group);
                        $i++;
                    }
                }
            }
        }

        if ($other_menu) {
            $user_menu = array();
            if (strpos($_SESSION['menu_var_kind'], 'all') !== false or strpos($_SESSION['menu_var_kind'], 'user') !== false) {
                $user_menu = self::get_user_menu_item($i);
            }

            if (is_array($user_menu)) {
                $all_menu = array_merge($my_menu, $user_menu);
            } else {
                $all_menu = $my_menu;
            }
        } else {
            $all_menu = $my_menu;
        }

        return $all_menu;
    }

    //取得其他模組單元的選單
    public static function get_custom_menu_items($link_cate_name, $link_cate_sn)
    {
        global $xoopsDB;
        $i = 0;
        $sub_menu = array();

        switch ($link_cate_name) {

            case "tadnews_page_cate":
                $sql = "select nsn, news_title from " . $xoopsDB->prefix("tad_news") . " where ncsn='{$link_cate_sn}' order by `page_sort`";
                $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                $ncsn_arr = "";
                while (list($nsn, $news_title) = $xoopsDB->fetchRow($result)) {
                    $sub_menu[$link_cate_name . $i]['id'] = $i;
                    $sub_menu[$link_cate_name . $i]['title'] = $news_title;
                    $sub_menu[$link_cate_name . $i]['url'] = XOOPS_URL . "/modules/tadnews/page.php?ncsn={$link_cate_sn}&nsn={$nsn}";
                    $sub_menu[$link_cate_name . $i]['target'] = "_self";
                    $sub_menu[$link_cate_name . $i]['icon'] = '';
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
        $u = parse_url($_SERVER['REQUEST_URI']);
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
                    $my_menu[$i]['id'] = $i;
                    $my_menu[$i]['title'] = $title;
                    $my_menu[$i]['target'] = "_self";
                    $my_menu[$i]['icon'] = !empty($interface_icon[$title]['icon']) ? $interface_icon[$title]['icon'] : $interface_icon[$title];
                    $my_menu[$i]['img'] = ($interface_menu_img[$title]) ? XOOPS_URL . "/modules/{$dir}/images/{$interface_menu_img[$title]}" : '';

                    if (is_array($url)) {
                        $my_menu[$i]['url'] = 'index.php';
                        $sub_menu = [];
                        $j = 0;
                        foreach ($url as $title2 => $url2) {
                            if ($title2 == 'icon') {
                                continue;
                            }
                            $sub_menu[$j]['id'] = $j;
                            $sub_menu[$j]['title'] = $title2;
                            $sub_menu[$j]['url'] = strpos($url2, 'http') === false ? XOOPS_URL . "/modules/{$dir}/{$url2}" : $url2;
                            $sub_menu[$j]['target'] = "_self";
                            $sub_menu[$j]['icon'] = $interface_icon[$title][$title2];
                            $sub_menu[$j]['submenu'] = '';
                            $j++;
                        }
                        $my_menu[$i]['submenu'] = $sub_menu;
                    } else {
                        $my_menu[$i]['url'] = strpos($url, 'http') === false ? XOOPS_URL . "/modules/{$dir}/{$url}" : $url;
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
            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_MYMENU;
            $my_menu[$i]['url'] = "#";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "";
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
            $sql = "select conf_value from " . $xoopsDB->prefix("config") . " where conf_title ='_MD_AM_DEBUGMODE'";
            $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
            list($debug) = $xoopsDB->fetchRow($result);
            if ($debug == 0) {
                $debug = 1;
            } else {
                $debug = 0;
            }

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_USER_ADMIN;
            $my_menu[$i]['url'] = XOOPS_URL . "/admin.php";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-th-large";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_SYSTEM_CONFIG;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/system/admin.php?fct=preferences&op=show&confcat_id=1";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-cog";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_SYSTEM_MODADM;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/tad_adm/admin/main.php";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-wrench";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_SYSTEM_DBADM;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/tad_adm/pma.php?server=" . XOOPS_DB_HOST . "&db=" . XOOPS_DB_NAME;
            $my_menu[$i]['target'] = "_blank";
            $my_menu[$i]['icon'] = "fa-database";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_THEME_ADMIN;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/tad_themes/admin/main.php";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-list-alt";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = ($debug == 1) ? _TAD_TF_THEME_DEBUG : _TAD_TF_THEME_UNDEBUG;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/tadtools/themes_common/tools/debug.php?op=debug&v={$debug}";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-warning";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_USER_BLOCK;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=-1&selmod=-2&selgrp=-1&selvis=1";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-cubes";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = _TAD_TF_USER_TAD_BLOCK;
            $my_menu[$i]['url'] = XOOPS_URL . "/modules/tad_blocks/blocks.php";
            $my_menu[$i]['target'] = "_self";
            $my_menu[$i]['icon'] = "fa-th";
            $my_menu[$i]['submenu'] = "";
            $i++;

            $my_menu[$i]['id'] = $i;
            $my_menu[$i]['title'] = 'separator';
            $my_menu[$i]['url'] = '';
            $my_menu[$i]['target'] = "";
            $my_menu[$i]['icon'] = "";
            $my_menu[$i]['submenu'] = "";
            $i++;
        }

        $pmcount = $_SESSION['xoops_inbox_count'];
        $my_menu[$i]['id'] = $i;
        $my_menu[$i]['title'] = !empty($pmcount) ? sprintf(_TAD_TF_USER_NEWMSG, $pmcount) : _TAD_TF_USER_MSG;
        $my_menu[$i]['url'] = XOOPS_URL . "/viewpmsg.php";
        $my_menu[$i]['target'] = "_self";
        $my_menu[$i]['icon'] = "fa-envelope";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id'] = $i;
        $my_menu[$i]['title'] = _TAD_TF_USER_NOTICE;
        $my_menu[$i]['url'] = XOOPS_URL . "/notifications.php";
        $my_menu[$i]['target'] = "_self";
        $my_menu[$i]['icon'] = "fa-bell";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id'] = $i;
        $my_menu[$i]['title'] = _TAD_TF_THEME_ADMIN;
        $my_menu[$i]['url'] = XOOPS_URL . "/modules/tad_themes/admin/main.php";
        $my_menu[$i]['target'] = "_self";
        $my_menu[$i]['icon'] = "fa-list-alt";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id'] = $i;
        $my_menu[$i]['title'] = _TAD_TF_USER_PROFILE;
        $my_menu[$i]['url'] = XOOPS_URL . "/user.php";
        $my_menu[$i]['target'] = "_self";
        $my_menu[$i]['icon'] = "fa-user";
        $my_menu[$i]['submenu'] = "";
        $i++;

        $my_menu[$i]['id'] = $i;
        $my_menu[$i]['title'] = _TAD_TF_USER_EXIT;
        $my_menu[$i]['url'] = XOOPS_URL . "/user.php?op=logout";
        $my_menu[$i]['target'] = "_self";
        $my_menu[$i]['icon'] = "fa-share";
        $my_menu[$i]['submenu'] = "";

        return $my_menu;
    }

    // 滑動圖設定
    public static function get_theme_slide_items($theme_name)
    {
        global $xoopsDB;
        $sql = "select a.* from " . $xoopsDB->prefix("tad_themes_files_center") . " as a left join " . $xoopsDB->prefix("tad_themes") . " as b on a.col_sn=b.theme_id  where a.`col_name`='slide' and b.`theme_name`='{$theme_name}'";

        $result = $xoopsDB->query($sql);

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
                    $target = "target='_blank'";
                } else {
                    $description = str_replace("[url]{$url}[/url]", "", $description);
                    $target = "";
                }

                $slider_var[$i]['files_sn'] = $files_sn;
                $slider_var[$i]['sort'] = $sort;
                $slider_var[$i]['file_name'] = $file_name;
                $slider_var[$i]['description'] = $description;
                $slider_var[$i]['text_description'] = strip_tags($description);
                $slider_var[$i]['original_filename'] = $original_filename;
                $slider_var[$i]['sub_dir'] = $sub_dir;
                $slider_var[$i]['file_url'] = XOOPS_URL . "/uploads/tad_themes{$sub_dir}/{$file_name}";
                $slider_var[$i]['file_thumb_url'] = XOOPS_URL . "/uploads/tad_themes{$sub_dir}/thumbs/{$file_name}";
                $slider_var[$i]['slide_url'] = $url;
                $slider_var[$i]['slide_target'] = $target;
                $i++;
            }
        }
        return $slider_var;

    }
}
