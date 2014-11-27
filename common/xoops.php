<?php
//後台的選單
if(!function_exists('admin_toolbar')){
  //xoops_version.php記得加上 $modversion['system_menu'] = 1; （for 2.5）
  function admin_toolbar($n="0"){
    $version=floatval(substr(XOOPS_VERSION,6,3));
    if($version < 2.5){
      include_once XOOPS_ROOT_PATH."/Frameworks/art/functions.php";
      include_once XOOPS_ROOT_PATH."/Frameworks/art/functions.admin.php";
      loadModuleAdminMenu($n);
    }
  }
}

//$moduleName用於當該工具列是整合到佈景，而非模組的時候使用。
//首頁的連結工具
if(!function_exists('toolbar')){
  //$interface_menu[工具列名稱]="網址";
  //$interface_logo[工具列名稱]="圖檔名稱";（圖檔一律放到模組的images下）
  function toolbar($interface_menu=array(),$interface_logo=array(),$id="id='menu'",$li="",$moduleName=""){
    if(empty($interface_menu))return;
    $td="";

    if(is_array($interface_menu)){
      $basename=basename($_SERVER['SCRIPT_NAME']);

      if(sizeof($interface_menu)==1 and substr($_SERVER['REQUEST_URI'],-9)=="index.php")return;

      foreach($interface_menu as $title => $url){
        $urlPath=(empty($moduleName) or substr($url,0,7)=="http://")?$url:XOOPS_URL."/modules/{$moduleName}/{$url}";
        $baseurl=basename($url);

        $li_class=preg_match("/^{$basename}/",$baseurl)?$li:"";
        $selected=preg_match("/^{$basename}/",$baseurl)?"selected":"";
        $td.="<li $li_class><a href='{$urlPath}' class='$selected'>{$title}</a></li>\n";
      }
    }else{
      return;
    }

    $cssCode="";
    if(empty($moduleName)){
      $id="id='toolbar'";
      $cssCode="<style type='text/css'>
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

    $main="
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


if(!function_exists('toolbar_bootstrap')){
  function toolbar_bootstrap($interface_menu=array()){
    global $xoopsUser,$xoopsModule;

    if ($xoopsUser) {
      $module_id = $xoopsModule->getVar('mid');
      $isAdmin=$xoopsUser->isAdmin($module_id);
      $mod_name=$xoopsModule->getVar('name');
    }else{
      $isAdmin=false;
      $mod_name="";
    }

    if(empty($interface_menu))return;
    $jquery=get_jquery();

    $options="<li {$active}><a href='index.php' title='"._TAD_HOME."'><i class='icon-home'></i></a></li>";
    if(is_array($interface_menu)){

      $basename=basename($_SERVER['SCRIPT_NAME']);
      if(sizeof($interface_menu)==1 and substr($_SERVER['REQUEST_URI'],-9)=="index.php")return;

      foreach($interface_menu as $title => $url){
        if(substr($url,-15)=="admin/index.php" or substr($url,-14)=="admin/main.php")continue;

        $urlPath=(empty($moduleName) or substr($url,0,7)=="http://")?$url:XOOPS_URL."/modules/{$moduleName}/{$url}";
        $baseurl=basename($url);
        //if($baseurl=="index.php" and !preg_match("/admin/", $url))continue;
        $active=strpos($_SERVER['SCRIPT_NAME'], $url)!==false?"class='selected'":"";
        $options.="
          <li {$active}><a href='{$urlPath}'>{$title}</a></li>
        ";
      }

      if($isAdmin and $module_id){
        $options.="<li {$active}><a href='admin/index.php' title='".sprintf(_TAD_ADMIN,$mod_name)."'><i class='icon-wrench'></i></a></li>";
        $options.="<li {$active}><a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences&op=showmod&mod={$module_id}' title='".sprintf(_TAD_CONFIG,$mod_name)."'><i class='icon-edit'></i></a></li>";
        $options.="<li {$active}><a href='".XOOPS_URL."/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen={$module_id}&selmod=-2&selgrp=-1&selvis=-1' title='".sprintf(_TAD_BLOCKS,$mod_name)."'><i class='icon-th'></i></a></li>";
      }
    }else{
      return;
    }


    $main="
    <style>
    /* styles for desktop */
    .tinynav { display: none }

    /* styles for mobile */
    @media screen and (max-width: 600px) {
      .tinynav { display: block }
      #toolbar_bootstrap { display: none }
    }

    #toolbar_bootstrap {
      padding: 6px 0 6px 6px;
      list-style: none;
      float: left;
      width: 100%;
      text-align: left;
      background: rgb(240,240,240);
      background: rgba(123,123,123,.1);
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
    }

    #toolbar_bootstrap li {
      display: block;
      float: left;
      margin-right: 2px;
      color: #000;
    }

    #toolbar_bootstrap a,
    #toolbar_bootstrap a:hover {
      padding: 0 15px;
      line-height: 24px;
      display: block;
      float: left;
      text-decoration: none;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      border: 0;
      color: gray;
    }

    #toolbar_bootstrap a:hover {
      color: #fff;
      background: rgb(140,140,140);
      background: rgba(0,0,0,.5);
    }

    #toolbar_bootstrap .selected a,
    #toolbar_bootstrap .selected a:hover {
      background: #4d4d4d;
      background: rgb(190,190,190);
      background: rgba(0,0,0,.2);
      color: #fff;
    }
    </style>

    $jquery
    <script src='".XOOPS_URL."/modules/tadtools/TinyNav/tinynav.min.js'></script>
    <script>
    $(function () {
      $('#toolbar_bootstrap').tinyNav({
        active: 'selected', // String: Set the 'active' class
        header: '', // String: Specify text for 'header' and show header instead of the active item
        indent: '- ', // String: Specify text for indenting sub-items
        label: '' // String: Sets the <label> text for the <select> (if not set, no label will be added)
      });
    });
    </script>

    <div class='row-fluid'>
      <ul id='toolbar_bootstrap' class='span12'>
        $options
      </ul>
    </div>";
    return $main;
  }
}



?>
