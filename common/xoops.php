<?php
//後台的選單
if (!function_exists('admin_toolbar')) {
    //xoops_version.php記得加上 $modversion['system_menu'] = 1; （for 2.5）
    function admin_toolbar($n = "0")
    {
        $version = floatval(substr(XOOPS_VERSION, 6, 3));
        if ($version < 2.5) {
            include_once XOOPS_ROOT_PATH . "/Frameworks/art/functions.php";
            include_once XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php";
            loadModuleAdminMenu($n);
        }
    }
}

//$moduleName用於當該工具列是整合到佈景，而非模組的時候使用。
//首頁的連結工具
if (!function_exists('toolbar')) {
    //$interface_menu[工具列名稱]="網址";
    //$interface_logo[工具列名稱]="圖檔名稱";（圖檔一律放到模組的images下）
    function toolbar($interface_menu = array(), $interface_logo = array(), $id = "id='menu'", $li = "", $moduleName = "")
    {
        global $xoopsUser, $xoopsModule;

        if ($xoopsModule) {
            $module_id  = $xoopsModule->mid();
            $mod_name   = $xoopsModule->name();
            $moduleName = $xoopsModule->dirname();
        } else {
            $mod_name = $moduleName = "";
        }

        if ($xoopsUser) {
            $isAdmin = $xoopsUser->isAdmin($module_id);
        } else {
            $isAdmin = false;
        }

        if (empty($interface_menu)) {
            return;
        }

        make_menu_json($interface_menu, $moduleName);
        $td = "";

        if (is_array($interface_menu)) {

            $basename = basename($_SERVER['SCRIPT_NAME']);

            if (sizeof($interface_menu) == 1 and substr($_SERVER['REQUEST_URI'], -9) == "index.php") {
                return;
            }

            foreach ($interface_menu as $title => $url) {
                $urlPath = (empty($moduleName) or substr($url, 0, 7) == "http://") ? $url : XOOPS_URL . "/modules/{$moduleName}/{$url}";
                $baseurl = basename($url);

                $li_class = preg_match("/^{$basename}/", $baseurl) ? $li : "";
                $selected = preg_match("/^{$basename}/", $baseurl) ? "selected" : "";
                $td .= "<li $li_class><a href='{$urlPath}' class='$selected'>{$title}</a></li>\n";
            }
        } else {
            return;
        }

        $cssCode = "";
        if (empty($moduleName)) {
            $id      = "id='toolbar'";
            $cssCode = "<style type='text/css'>
        #toolbar{
          margin:10px 0px 10px;
        }
        #toolbar ul li{
          list-style:none outside;
          float:left;
          padding:3px 0px;
          margin:2px 0px;
        }
        #toolbar a:link, #toolbar a:visited {
            font-size: 11px;
            padding: 3px 10px 2px 10px;
            color: #707070;
            background-color: #FBFBFB;
            text-decoration: none;
            border: 1px solid #E0E0E0;
            margin:0px 2px;
        }
         #toolbar a:hover, #toolbar a.selected {
            color: #000000;
            background-color: #FFFFCC;
            border: 1px solid #505050;
          }
        </style>";
        }

        $main = "
    $cssCode
    <div $id>
    <ul>
    {$td}
    </ul>
    </div>
    <div style='clear:both;'></div>
    ";
        return $main;
    }
}

if (!function_exists('toolbar_bootstrap')) {
    function toolbar_bootstrap($interface_menu = array())
    {
        global $xoopsUser, $xoopsModule;

        if ($xoopsModule) {
            $module_id  = $xoopsModule->mid();
            $mod_name   = $xoopsModule->name();
            $moduleName = $xoopsModule->dirname();
        } else {
            $mod_name = $moduleName = "";
        }

        if ($xoopsUser) {
            $isAdmin = $xoopsUser->isAdmin($module_id);
        } else {
            $isAdmin = false;
        }

        if (empty($interface_menu)) {
            return;
        }

        make_menu_json($interface_menu, $moduleName);

        $jquery = get_jquery();

        $row    = ($_SESSION['bootstrap'] == '3') ? 'row' : 'row-fluid';
        $col    = ($_SESSION['bootstrap'] == '3') ? 'col-md-12' : 'span12';
        $home   = ($_SESSION['bootstrap'] == '3') ? 'fa fa-home' : 'icon-home';
        $wrench = ($_SESSION['bootstrap'] == '3') ? 'fa fa-wrench' : 'icon-wrench';
        $edit   = ($_SESSION['bootstrap'] == '3') ? 'fa fa-edit' : 'icon-edit';
        $th     = ($_SESSION['bootstrap'] == '3') ? 'fa fa-th' : 'icon-th';

        $options = "<li><a href='index.php' title='" . _TAD_HOME . "'><i class='{$home}'></i></a></li>";
        if (is_array($interface_menu)) {

            $basename = basename($_SERVER['SCRIPT_NAME']);
            if (sizeof($interface_menu) == 1 and substr($_SERVER['REQUEST_URI'], -9) == "index.php") {
                return;
            }

            foreach ($interface_menu as $title => $url) {
                if (substr($url, -15) == "admin/index.php" or substr($url, -14) == "admin/main.php") {
                    continue;
                }

                $urlPath = (empty($moduleName) or substr($url, 0, 7) == "http://") ? $url : XOOPS_URL . "/modules/{$moduleName}/{$url}";
                $baseurl = basename($url);
                //if($baseurl=="index.php" and !preg_match("/admin/", $url))continue;
                $active = strpos($_SERVER['SCRIPT_NAME'], $url) !== false ? "class='current'" : "";
                $options .= "
          <li {$active}><a href='{$urlPath}'>{$title}</a></li>
        ";
            }

            if ($isAdmin and $module_id) {
                $options .= "<li {$active}><a href='admin/index.php' title='" . sprintf(_TAD_ADMIN, $mod_name) . "'><i class='{$wrench}'></i></a></li>";
                $options .= "<li {$active}><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=preferences&op=showmod&mod={$module_id}' title='" . sprintf(_TAD_CONFIG, $mod_name) . "'><i class='{$edit}'></i></a></li>";
                $options .= "<li {$active}><a href='" . XOOPS_URL . "/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen={$module_id}&selmod=-2&selgrp=-1&selvis=-1' title='" . sprintf(_TAD_BLOCKS, $mod_name) . "'><i class='{$th}'></i></a></li>";
            }
        } else {
            return;
        }

        $main = "
    <style>
    .toolbar_bootstrap_nav {
      position: relative;
      margin: 20px 0;
    }
    .toolbar_bootstrap_nav ul {
      margin: 0;
      padding: 0;
    }
    .toolbar_bootstrap_nav li {
      margin: 0 5px 10px 0;
      padding: 0;
      list-style: none;
      display: inline-block;
    }
    .toolbar_bootstrap_nav a {
      padding: 3px 12px;
      text-decoration: none;
      color: #999;
      line-height: 100%;
    }
    .toolbar_bootstrap_nav a:hover {
      color: #000;
    }
    .toolbar_bootstrap_nav .current a {
      background: #999;
      color: #fff;
      border-radius: 5px;
    }

    </style>

    <div class='{$row}'>
      <div class='{$col}'>
        <nav class='toolbar_bootstrap_nav'>
          <ul>
            $options
          </ul>
        </nav>
      </div>
    </div>";
        return $main;
    }
}

if (!function_exists('make_menu_json')) {
    function make_menu_json($interface_menu = array(), $moduleName = "")
    {
        $json     = json_encode($interface_menu);
        $filename = XOOPS_ROOT_PATH . "/uploads/menu_{$moduleName}.txt";
        file_put_contents($filename, $json);
    }
}
