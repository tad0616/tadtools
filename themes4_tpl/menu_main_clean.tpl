<{if $auto_mainmenu}>
  <{php}>
    global $xoopsDB;

    //製作主選單
    $sql = "select name,dirname from ".$xoopsDB->prefix("modules")." where isactive='1' and hasmain='1' and weight!=0 order by weight";
    $result = $xoopsDB->query($sql);
    $option="";
    while(list($name,$dirname)=$xoopsDB->fetchRow($result)){
      $option.= "\t\t\t<li class=\"nav-item\"><a href=\"".XOOPS_URL."/modules/{$dirname}\"><span class=\"fa fa-th-list\"></span> {$name}</a></li>\n";
    }

    echo "
    <li class="nav-item">
      <a href=\"index.php\" $menu_target>".THEME_MODULE0."</a>
      <ul>
        $option
      </ul>
    </li>
    ";
  <{/php}>
<{/if}>