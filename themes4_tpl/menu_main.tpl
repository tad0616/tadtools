<{if $auto_mainmenu}>
    <{php}>
        global $xoopsDB;

        //製作主選單
        $sql = "select name,dirname from ".$xoopsDB->prefix("modules")." where isactive='1' and hasmain='1' and weight!=0 order by weight";
        $result = $xoopsDB->query($sql);
        $option="";
        while(list($name,$dirname)=$xoopsDB->fetchRow($result)){
            $option.= "\t\t\t<li><a class=\"dropdown-item\" href=\"".XOOPS_URL."/modules/{$dirname}\"><i class=\"fa fa-th-list\"></i> {$name}</a></li>\n";
        }
        echo "
        <li class=\"nav-item dropdown\">
            <a class=\"nav-link dropdown-toggle\" href=\"index.php\" $menu_target>".THEME_MODULE0."</a>
            <ul class=\"dropdown-menu\">
                $option
            </ul>
        </li>
        ";
    <{/php}>
<{/if}>
