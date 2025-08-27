<?php

use XoopsModules\Tadtools\Tools;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_login\Tools as TadLoginTools;

class TadtoolsCorePreload extends XoopsPreloadItem
{
    // to add PSR-4 autoloader

    public static function eventCoreIncludeCommonAuthSuccess()
    {
        global $xoopsConfig, $xoopsTpl, $xoopsDB;
        $_SESSION['xoops_version'] = Utility::get_version('xoops');

        if (!isset($_SESSION['bootstrap'])) {
            $theme_name      = isset($_SESSION['xoopsUserTheme']) ? $_SESSION['xoopsUserTheme'] : $xoopsConfig['theme_set'];
            $theme_json_file = XOOPS_VAR_PATH . "/data/{$theme_name}_setup.json";

            if (file_exists($theme_json_file)) {
                $theme_config = json_decode(file_get_contents($theme_json_file), true);
            } else {
                $theme_config = Tools::import_theme_json($theme_name);
            }
            $_SESSION['bootstrap'] = strpos($theme_config['theme_kind'], 'bootstrap') !== false ? substr($theme_config['theme_kind'], -1) : 5;

            $WebID = isset($_REQUEST['WebID']) ? (int) $_REQUEST['WebID'] : 0;
            if (!empty($WebID) and false !== mb_strpos($_SERVER['PHP_SELF'], 'modules/tad_web') and false !== mb_strpos($_SERVER['REQUEST_URI'], '?WebID=')) {
                $_SESSION['bootstrap'] = 5;
            }
        }

        if ($xoopsTpl) {
            $xoopsTpl->assign('bootstrap', $_SESSION['bootstrap']);
        }
    }

    public static function eventCoreHeaderAddmeta($args)
    {
        global $xoopsConfig, $xoopsTpl, $xoopsDB, $xoTheme, $xoopsUser;

        // $ng_web = [];
        // if (!isset($_SESSION['have_ng_web']) || !empty($_SESSION['have_ng_web'])) {
        //     $json = "/var/www/xoops_data/all_web_modules.json";
        //     if (file_exists($json)) {
        //         $all_web_modules = json_decode(file_get_contents($json), true);
        //         $server          = explode('.', $_SERVER['SERVER_NAME']);
        //         foreach ($all_web_modules as $key => $value) {
        //             if (strpos($key, $server[1] . '_') !== false) {
        //                 $my_modules[$key] = $value;
        //                 foreach ($value as $data) {
        //                     if ($data['dirname'] == 'system' && $data['version'] != '20107') {
        //                         list($domain, $sub) = explode('_', $key);
        //                         $ng_web[]           = "{$sub}.{$domain}.tn.edu.tw";
        //                     }
        //                 }
        //             }
        //         }

        //         $_SESSION['have_ng_web'] = count($ng_web);

        //     }
        // }
        // $xoopsTpl->assign('ng_web', $ng_web);

        $theme_id           = 0;
        $theme_name         = isset($_SESSION['xoopsUserTheme']) ? $_SESSION['xoopsUserTheme'] : $xoopsConfig['theme_set'];
        $use_default_config = false;

        /****檢查是否開放註冊****/
        $sql                  = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . "` WHERE `conf_name` = 'allow_register'";
        $result               = $xoopsDB->query($sql);
        list($allow_register) = $xoopsDB->fetchRow($result);
        $xoopsTpl->assign('allow_register', $allow_register);

        /****檢查是否有廣播檔（會放到左區塊最上方）****/
        if (file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/broadcast.php")) {
            $all_broadcast = file_get_contents(XOOPS_URL . "/modules/tadtools/broadcast.php");
            $xoopsTpl->assign('all_broadcast', json_decode($all_broadcast, true));
        }

        // themes_common/meta.tpl 會用到
        $http = 'https://';
        if (!empty($_SERVER['HTTPS'])) {
            $http = ($_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        }
        $url = $http . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $xoopsTpl->assign('now_url', $url);

        $theme_name      = isset($_SESSION['xoopsUserTheme']) ? $_SESSION['xoopsUserTheme'] : $xoopsConfig['theme_set'];
        $theme_json_file = XOOPS_VAR_PATH . "/data/{$theme_name}_setup.json";
        if (file_exists($theme_json_file)) {
            $theme_config = json_decode(file_get_contents($theme_json_file), true);
        } else {
            $theme_config = Tools::import_theme_json($theme_name);
        }
        Utility::test($theme_config, 'theme_config', 'dd');
        foreach ($theme_config as $key => $value) {
            $xoopsTpl->assign($key, $value);
        }

        $WebID = isset($_REQUEST['WebID']) ? (int) $_REQUEST['WebID'] : 0;
        if (!empty($WebID) and false !== mb_strpos($_SERVER['PHP_SELF'], 'modules/tad_web') and false !== mb_strpos($_SERVER['REQUEST_URI'], '?WebID=')) {
            $_SESSION['bootstrap'] = 5;
        } else {
            $_SESSION['bootstrap'] = strpos($theme_config['theme_kind'], 'bootstrap') !== false ? substr($theme_config['theme_kind'], -1) : 5;
        }
        $xoopsTpl->assign('bootstrap', $_SESSION['bootstrap']);

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
            $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.5.2.js');
            // }
            $xoTheme->addStylesheet('modules/tadtools/jquery/themes/base/jquery.ui.all.css');
            // $xoTheme->addScript('modules/tadtools/jquery/ui/jquery-ui.js');
            $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');

            $xoTheme->addStylesheet('modules/tadtools/colorbox/colorbox.css');
            $xoTheme->addStylesheet('modules/tadtools/css/xoops.css');
            $xoTheme->addScript('modules/tadtools/colorbox/jquery.colorbox.js');
            $xoTheme->addStylesheet('modules/tadtools/css/fontawesome6/css/all.min.css');
            // $xoTheme->addStylesheet('media/font-awesome/css/font-awesome.min.css');
        }

        //製作主選單
        $main_menu = [];
        $i         = 0;
        $sql       = 'SELECT `mid`, `name`, `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive` = 1 AND `hasmain` = 1 AND `weight` != 0 ORDER BY `weight`';
        $result    = $xoopsDB->query($sql);

        while (list($mid, $name, $dirname) = $xoopsDB->fetchRow($result)) {
            $main_menu[$i]['id']     = $mid;
            $main_menu[$i]['title']  = $name;
            $main_menu[$i]['url']    = XOOPS_URL . "/modules/{$dirname}/";
            $main_menu[$i]['target'] = '_self';
            $main_menu[$i]['icon']   = 'fa-th-list';
            $main_menu[$i]['img']    = '';
            $i++;
        }
        $xoopsTpl->assign('main_menu_var', $main_menu);
        Utility::test($main_menu, 'main_menu', 'dd');

        //製作管理選單
        $moduleHandler   = xoops_getHandler('module');
        $TadBlocksModule = $moduleHandler->getByDirname("tad_blocks");
        $TadBlocksMid    = ($TadBlocksModule) ? $TadBlocksModule->mid() : 0;
        $TadThemesModule = $moduleHandler->getByDirname("tad_themes");
        $TadThemesMid    = ($TadThemesModule) ? $TadThemesModule->mid() : 0;

        $sql         = 'SELECT `conf_value` FROM `' . $xoopsDB->prefix('config') . "` WHERE `conf_title` = '_MD_AM_DEBUGMODE'";
        $result      = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
        list($debug) = $xoopsDB->fetchRow($result);
        if ($debug == 0) {
            $debug = 1;
        } else {
            $debug = 0;
        }
        $xoopsTpl->assign('debug', $debug);

        xoops_loadLanguage('main', 'tadtools');

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
        $uid                     = $xoopsUser ? $xoopsUser->uid() : 0;
        $sql                     = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('priv_msgs') . "` WHERE `to_userid` = $uid AND `read_msg`=0 GROUP BY `to_userid`";
        $result                  = $xoopsDB->query($sql);
        list($xoops_inbox_count) = $xoopsDB->fetchRow($result);

        if ($xoops_inbox_count) {
            $user_menu[] = ['title' => sprintf(_TAD_TF_USER_NEWMSG, $xoops_inbox_count), 'url' => XOOPS_URL . '/viewpmsg.php', 'icon' => 'fa-envelope', 'target' => '_self'];
        } else {
            $user_menu[] = ['title' => _TAD_TF_USER_MSG, 'url' => XOOPS_URL . '/viewpmsg.php', 'icon' => 'fa-envelope', 'target' => '_self'];
        }
        $user_menu[] = ['title' => _TAD_TF_USER_NOTICE, 'url' => XOOPS_URL . '/notifications.php', 'icon' => 'fa-bell', 'target' => '_self'];
        $user_menu[] = ['title' => _TAD_TF_USER_PROFILE, 'url' => XOOPS_URL . '/user.php', 'icon' => 'fa-user', 'target' => '_self'];
        $user_menu[] = ['title' => _TAD_TF_USER_EXIT, 'url' => XOOPS_URL . '/user.php?op=logout', 'icon' => 'fa-share', 'target' => '_self'];

        $xoopsTpl->assign('user_menu_var', $user_menu);

        // 自訂選單
        $my_menu  = Tools::get_theme_menu_items(0, $theme_config['menu_var_kind']);
        $i        = sizeof($my_menu);
        $mod_menu = Tools::get_module_menu_item($i, $theme_config['menu_var_kind']);
        if (!empty($mod_menu)) {
            if (empty($my_menu)) {
                $my_menu = array();
            }

            $my_menu = array_merge($my_menu, $mod_menu);
        }
        $xoopsTpl->assign('menu_var', $my_menu);
        Utility::test($my_menu, 'my_menu', 'dd');

        // navbar.tpl 會用到
        if ($xoopsUser && $xoopsUser->isAdmin()) {
            if (file_exists(XOOPS_VAR_PATH . "/data/install_chk.php")) {
                $xoopsTpl->assign('install_chk', true);
                unlink(XOOPS_VAR_PATH . "/data/install_chk.php");
            }
        }

        // menu_login.tpl 會用到
        if (!$xoopsUser) {
            if ($theme_config['openid_login'] == '1' || $theme_config['openid_login'] == '2') {
                $configHandler = xoops_gethandler('config');

                $TadLoginXoopsModule = $moduleHandler->getByDirname("tad_login");
                $TnLoginXoopsModule  = $moduleHandler->getByDirname("tn_login");

                if (isset($TadLoginXoopsModule) && $TadLoginXoopsModule->isactive()) {
                    require_once XOOPS_ROOT_PATH . "/modules/tad_login/language/{$xoopsConfig['language']}/county.php";

                    $modConfig = $configHandler->getConfigsByCat(0, $TadLoginXoopsModule->getVar('mid'));

                    $tad_login['line']   = in_array('line', $modConfig['auth_method']) ? Tools::tad_login('line', 'return') : '';
                    $tad_login['google'] = in_array('google', $modConfig['auth_method']) ? Tools::tad_login('google', 'return') : '';

                    $auth_method = $modConfig['auth_method'];
                    $i           = 0;

                    if ($_SESSION['xoops_version'] < 20511 && !class_exists('XoopsModules\Tad_login\Tools')) {
                        require_once XOOPS_ROOT_PATH . "/modules/tad_login/oidc.php";
                    } else {
                        $all_oidc  = TadLoginTools::$all_oidc;
                        $all_oidc2 = TadLoginTools::$all_oidc2;
                    }
                    $oidc_array  = array_keys($all_oidc);
                    $oidc_array2 = array_keys($all_oidc2);
                    foreach ($auth_method as $method) {
                        $method_const = "_" . strtoupper($method);

                        if ($method == "google") {
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
                            $tlogin[$i]['img']  = XOOPS_URL . "/modules/tad_login/images/oidc/" . $all_oidc[$method]['tail'] . ".png";
                            $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant('_' . strtoupper($all_oidc[$method]['tail'])) . _TADLOGIN_OIDC);
                        } elseif (isset($oidc_array2) && is_array($oidc_array2) && in_array($method, $oidc_array2)) {
                            $tlogin[$i]['img']  = XOOPS_URL . "/modules/tad_login/images/{$method}.png";
                            $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant('_' . strtoupper($all_oidc2[$method]['tail'])) . _TADLOGIN_LDAP);
                        } else {
                            $tlogin[$i]['img']  = XOOPS_URL . "/modules/tad_login/images/{$method}.png";
                            $tlogin[$i]['text'] = sprintf(_TAD_LOGIN_BY, constant($method_const) . ' OpenID ');
                        }

                        $i++;
                    }
                    $xoopsTpl->assign('tlogin', $tlogin);
                } elseif (isset($TnLoginXoopsModule) && $TnLoginXoopsModule->isactive()) {
                    require_once XOOPS_ROOT_PATH . "/modules/tn_login/function.php";
                    $tlogin[0]['link']     = XOOPS_URL . "/modules/tn_login/index.php";
                    $tlogin[0]['img']      = XOOPS_URL . "/modules/tn_login/images/login_logo.png";
                    $tlogin[0]['text']     = '由南資 OpenID 認證登入';
                    $tlogin[0]['tn_login'] = true;

                    $xoopsTpl->assign('tlogin', $tlogin);
                }
            }
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
            $sql                                                                    = 'SELECT `tt_theme`,`tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` FROM `' . $xoopsDB->prefix('tadtools_setup') . "` WHERE `tt_theme` = '$theme_set'";
            $result                                                                 = $xoopsDB->query($sql);
            list($tt_theme, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind) = $xoopsDB->fetchRow($result);
            if (empty($tt_theme_kind)) {
                if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_set}/config.php")) {
                    require_once XOOPS_ROOT_PATH . "/themes/{$theme_set}/config.php";
                    if (isset($theme_kind)) {
                        $tt_theme_kind      = $theme_kind;
                        $tt_use_bootstrap   = 'html' === $theme_kind ? 1 : 0;
                        $tt_bootstrap_color = 'bootstrap3';
                        if (empty($tt_theme)) {
                            $sql = 'INSERT INTO `' . $xoopsDB->prefix('tadtools_setup') . '` (`tt_theme`,`tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind`) VALUES(?, ?, ?, ?)';
                            Utility::query($sql, 'ssss', [$theme_set, $tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind]);
                        } else {
                            $sql = 'UPDATE `' . $xoopsDB->prefix('tadtools_setup') . '` SET `tt_use_bootstrap`=?, `tt_bootstrap_color`=?, `tt_theme_kind`=? WHERE `tt_theme`=?';
                            Utility::query($sql, 'ssss', [$tt_use_bootstrap, $tt_bootstrap_color, $tt_theme_kind, $theme_set]);
                        }
                    }
                } else {
                    $tt_theme_kind      = 'html';
                    $tt_use_bootstrap   = 1;
                    $tt_bootstrap_color = 'bootstrap5';
                }
            }
            $_SESSION['theme_kind']                    = $tt_theme_kind;
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
