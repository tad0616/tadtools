<{php}>
global $xoopsDB, $xoopsTpl, $xoopsModule, $xoTheme;

if ($xoTheme) {
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

    $ver = intval(str_replace('.', '', substr(XOOPS_VERSION, 6, 5)));

    if ($ver >= 259) {
        $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
    } else {
        $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
    }

    $xoTheme->addStylesheet("modules/tadtools/jquery/themes/base/jquery.ui.all.css");
    $xoTheme->addScript('modules/tadtools/jquery/ui/jquery-ui.js');
}

$my_menu  = get_theme_menu_items(0);
$i        = sizeof($my_menu);
$mod_menu = get_module_menu_item($i);
if (!empty($mod_menu)) {
    if (empty($my_menu)) {
        $my_menu = array();
    }

    $my_menu = array_merge($my_menu, $mod_menu);
}
//die(var_dump($mod_menu));

$xoopsTpl->assign('menu_var', $my_menu);

//取得選單選項
function get_theme_menu_items($id = "", $other_menu = true)
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;
    //取得目前使用者的所屬群組
    if ($xoopsUser) {
        $User_Groups = $xoopsUser->getGroups();
    } else {
        $User_Groups = array(3);
    }
    $my_menu = array();
    if (strpos($_SESSION['menu_var_kind'], 'all') !== false or strpos($_SESSION['menu_var_kind'], 'my_menu') !== false) {

        $sql    = "select `menuid`, `itemname`, `itemurl`, `target`, `icon`, `link_cate_name`, `link_cate_sn`, `read_group` from " . $xoopsDB->prefix("tad_themes_menu") . " where of_level='{$id}' and status='1' order by position";
        $result = $xoopsDB->query($sql);

        $modhandler = xoops_gethandler('module');
        if ($result) {
            $i = 0;
            while (list($menuid, $itemname, $itemurl, $target, $icon, $link_cate_name, $link_cate_sn, $read_group) = $xoopsDB->fetchRow($result)) {
                if(empty($read_group)){
                    $read_group='1,2,3';
                }
                $read_group_array = explode(',', $read_group);
                if (array_intersect($User_Groups, $read_group_array)) {
                    if (!empty($link_cate_name)) {

                        switch ($link_cate_name) {

                            case "tadnews_page_cate":
                                $TadNewsModule = $modhandler->getByDirname("tadnews");
                                if (!$TadNewsModule) {
                                    continue;
                                }
                                break;
                        }
                        $custom_menu            = get_custom_menu_items($link_cate_name, $link_cate_sn);
                        $sub_menu               = get_theme_menu_items($menuid, false);
                        $my_menu[$i]['submenu'] = array_merge($custom_menu, $sub_menu);
                    } else {
                        $my_menu[$i]['submenu'] = get_theme_menu_items($menuid, false);
                    }

                    $my_menu[$i]['id']         = $menuid;
                    $my_menu[$i]['title']      = $itemname;
                    $my_menu[$i]['url']        = ($itemurl=='' or $itemurl=='#')?'index.php':$itemurl;
                    $my_menu[$i]['target']     = $target;
                    $my_menu[$i]['icon']       = str_replace('icon-', 'fa-', $icon);
                    $my_menu[$i]['img']        = '';
                    $my_menu[$i]['read_group'] = explode(',', $read_group);
                    $i++;
                }
            }
        }
    }

    if ($other_menu) {
        $user_menu = array();
        if (strpos($_SESSION['menu_var_kind'], 'all') !== false or strpos($_SESSION['menu_var_kind'], 'user') !== false) {
            $user_menu = get_user_menu_item($i);
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
function get_custom_menu_items($link_cate_name, $link_cate_sn)
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;
    $i        = 0;
    $sub_menu = array();

    switch ($link_cate_name) {

        case "tadnews_page_cate":
            $sql      = "select nsn, news_title from " . $xoopsDB->prefix("tad_news") . " where ncsn='{$link_cate_sn}' order by `page_sort`";
            $result   = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, _LINE__);
            $ncsn_arr = "";
            while (list($nsn, $news_title) = $xoopsDB->fetchRow($result)) {
                $sub_menu[$link_cate_name . $i]['id']      = $i;
                $sub_menu[$link_cate_name . $i]['title']   = $news_title;
                $sub_menu[$link_cate_name . $i]['url']     = XOOPS_URL . "/modules/tadnews/page.php?nsn={$nsn}";
                $sub_menu[$link_cate_name . $i]['target']  = "_self";
                $sub_menu[$link_cate_name . $i]['icon']    = 'fa-angle-right';
                $sub_menu[$link_cate_name . $i]['submenu'] = "";
                $i++;
            }
            break;
    }

    return $sub_menu;
}

//取得模組選單
function get_module_menu_item($i)
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;
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
        include_once XOOPS_ROOT_PATH . "/modules/{$dir}/interface_menu.php";
        global $interface_menu, $interface_menu_img, $isAdmin, $module_id, $interface_icon;

        foreach ($interface_menu as $title => $url) {
            $my_menu[$i]['id']      = $i;
            $my_menu[$i]['title']   = $title;
            $my_menu[$i]['url']     = XOOPS_URL . "/modules/{$dir}/{$url}";
            $my_menu[$i]['target']  = "_self";
            $my_menu[$i]['icon']    = $interface_icon[$title];
            $my_menu[$i]['img']     = ($interface_menu_img[$title]) ? XOOPS_URL . "/modules/{$dir}/images/{$interface_menu_img[$title]}" : '';
            $my_menu[$i]['submenu'] = "";
            $i++;
        }
    } else {
        return;
    }

    return $my_menu;
}

//判斷是否為管理員
function isWebAdmin()
{
    global $xoopsUser, $xoopsModule;
    $isWebAdmin = false;
    if ($xoopsUser) {
        $isWebAdmin = $xoopsUser->isAdmin(1);
    }
    return $isWebAdmin;
}

//取得使用者選單
function get_user_menu_item($i)
{
    global $xoopsUser;
    if ($xoopsUser) {
        $my_menu[$i]['id']      = $i;
        $my_menu[$i]['title']   = _TAD_TF_MYMENU;
        $my_menu[$i]['url']     = "#";
        $my_menu[$i]['target']  = "_self";
        $my_menu[$i]['icon']    = "";
        $my_menu[$i]['submenu'] = get_user_submenu_item();
    } else {
        return;
    }

    return $my_menu;
}

//取得使用者選單子項目
function get_user_submenu_item()
{
    global $xoopsDB;
    $i = 0;
    if (isWebAdmin()) {
        $sql         = "select conf_value from " . $xoopsDB->prefix("config") . " where conf_title ='_MD_AM_DEBUGMODE'";
        $result      = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
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
        $my_menu[$i]['url']     = XOOPS_URL . "/modules/tad_adm/pma.php";
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

    $pmcount                = $_SESSION['xoops_inbox_count'];
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
<{/php}>