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

$main_menu  = get_theme_main_menu_items();
$xoopsTpl->assign('main_menu_var', $main_menu);

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

        $read_group=[];
        $sql = "select gperm_groupid from ".$xoopsDB->prefix("group_permission")." where gperm_modid='1' and gperm_name='module_read' and gperm_itemid='$mid' order by gperm_groupid";
        $result2 = $xoopsDB->queryF($sql);
        while(list($gperm_groupid)=$xoopsDB->fetchRow($result2)){
            $read_group[]=$gperm_groupid;
        }

        $main_menu[$i]['id']         = $mid;
        $main_menu[$i]['title']      = $name;
        $main_menu[$i]['url']        = XOOPS_URL."/modules/{$dirname}/";
        $main_menu[$i]['target']     = '_self';
        $main_menu[$i]['icon']       = '';
        $main_menu[$i]['img']        = '';
        $main_menu[$i]['read_group'] = explode(',', $read_group);
        $i++;
    }


    return $main_menu;
}

<{/php}>
