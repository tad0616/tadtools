<{php}>
use XoopsModules\Tadtools\Utility;

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
;
$xoopsTpl->assign('main_menu_var', get_theme_main_menu_items());
$xoopsTpl->assign('admin_menu_var', get_theme_admin_menu_items());
$xoopsTpl->assign('user_menu_var', get_theme_user_menu_items());

//取得選單選項
function get_theme_main_menu_items()
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;

    $main_menu=[];
    $i=0;
    //製作主選單
    $sql = "select `mid`, `name`, `dirname` from ".$xoopsDB->prefix("modules")." where isactive='1' and hasmain='1' and weight!=0 order by weight";
    $result = $xoopsDB->queryF($sql);
    while(list($mid,$name,$dirname)=$xoopsDB->fetchRow($result)){
        $main_menu[$i]['id']         = $mid;
        $main_menu[$i]['title']      = $name;
        $main_menu[$i]['url']        = XOOPS_URL."/modules/{$dirname}/";
        $main_menu[$i]['target']     = '_self';
        $main_menu[$i]['icon']       = 'fa-th-list';
        $main_menu[$i]['img']        = '';
        $i++;
    }


    return $main_menu;
}


//取得管理選單選項
function get_theme_admin_menu_items()
{
    global $xoopsDB;

    $moduleHandler = xoops_getHandler('module');
    $TadThemesModule = $moduleHandler->getByDirname("tad_themes");
    $TadThemesMid = ($TadThemesModule) ? $TadThemesModule->getVar('mid') : 0;


    $sql         = "select conf_value from " . $xoopsDB->prefix("config") . " where conf_title ='_MD_AM_DEBUGMODE'";
    $result      = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
    list($debug) = $xoopsDB->fetchRow($result);
    if ($debug == 0) {
        $debug = 1;
    } else {
        $debug = 0;
    }


    $admin_menu[]=['title'=>_TAD_TF_USER_ADMIN, 'url'=>XOOPS_URL.'/admin.php', 'icon'=>'fa-lock', 'target'=> '_self'];
    $admin_menu[]=['title'=>_TAD_TF_SYSTEM_CONFIG, 'url'=>XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=show&confcat_id=1', 'icon'=>'fa-cog', 'target'=> '_blank'];
    $admin_menu[]=['title'=>_TAD_TF_SYSTEM_MODADM, 'url'=>XOOPS_URL.'/modules/tad_adm/admin/main.php', 'icon'=>'fa-wrench', 'target'=> '_blank'];
    $admin_menu[]=['title'=>_TAD_TF_SYSTEM_DBADM, 'url'=>XOOPS_URL.'/modules/tad_adm/pma.php', 'icon'=>'fa-database', 'target'=> '_blank'];
    if($TadThemesMid){
        $admin_menu[]=['title'=>_TAD_TF_THEME_ADMIN, 'url'=>XOOPS_URL.'/modules/tad_themes/admin/main.php', 'icon'=>'fa-list-alt', 'target'=> '_blank'];
    }
    if($debug=='1'){
        $admin_menu[]=['title'=>_TAD_TF_THEME_DEBUG, 'url'=>XOOPS_URL."/modules/tadtools/themes_common/tools/debug.php?op=debug&v={$debug}", 'icon'=>'fa-warning', 'target'=> '_self'];
    }else{
        $admin_menu[]=['title'=>_TAD_TF_THEME_UNDEBUG, 'url'=>XOOPS_URL."/modules/tadtools/themes_common/tools/debug.php?op=debug&v={$debug}", 'icon'=>'fa-warning', 'target'=> '_self'];

    }
    $admin_menu[]=['title'=>_TAD_TF_USER_BLOCK, 'url'=>XOOPS_URL.'/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=-1&selmod=-2&selgrp=-1&selvis=1', 'icon'=>'fa-th', 'target'=> '_blank'];
    $admin_menu[]=['title'=>_TAD_TF_USER_TAD_BLOCK, 'url'=>XOOPS_URL.'/modules/tad_blocks/blocks.php', 'icon'=>'fa-cubes', 'target'=> '_blank'];

    return $admin_menu;
}

//取得用戶選單選項
function get_theme_user_menu_items()
{
    global $xoopsDB,$xoopsUser;

    $uid = $xoopsUser? $xoopsUser->uid():0;
    $sql         = "select count(*) from " . $xoopsDB->prefix("priv_msgs") . " where `to_userid` ='$uid' and `read_msg`=0 group by `to_userid`";
    $result      = $xoopsDB->queryF($sql);
    list($xoops_inbox_count) = $xoopsDB->fetchRow($result);

    if($xoops_inbox_count){
        $user_menu[]=['title'=>sprintf(_TAD_TF_USER_NEWMSG, $xoops_inbox_count), 'url'=>XOOPS_URL.'/viewpmsg.php', 'icon'=>'fa-envelope', 'target'=> '_self'];
    }else{
        $user_menu[]=['title'=>_TAD_TF_USER_MSG, 'url'=>XOOPS_URL.'/viewpmsg.php', 'icon'=>'fa-envelope-o', 'target'=> '_self'];
    }
    $user_menu[]=['title'=>_TAD_TF_USER_NOTICE, 'url'=>XOOPS_URL.'/notifications.php', 'icon'=>'fa-bell', 'target'=> '_self'];
    $user_menu[]=['title'=>_TAD_TF_USER_PROFILE, 'url'=>XOOPS_URL.'/user.php', 'icon'=>'fa-user',  'target'=> '_self'];
    $user_menu[]=['title'=>_TAD_TF_USER_EXIT, 'url'=>XOOPS_URL.'/user.php?op=logout', 'icon'=>'fa-share', 'target'=> '_self'];

    return $user_menu;
}
<{/php}>
