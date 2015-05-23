<?php
//後台的選單
//$adminmenu[0]['title'] = _MI_PRICE_ADMENU1;
//$adminmenu[0]['link'] = "admin/index.php";
if(!function_exists('admin_toolbar')){
  function admin_toolbar($n=""){
    global $xoopsModuleConfig;
    include_once XOOPS_ROOT_PATH."/admin/menu.php";
    $td="<li><a href='".XOOPS_URL."'>回前台</a></li>";
    if(is_array($adminmenu)){
      foreach($adminmenu as $n => $item){
        $td.="<li><a href='".XOOPS_URL."/{$item['link']}'>{$item['title']}</a></li>";
      }
      if(!empty($xoopsModuleConfig)){
        $td.="<li><a href='".XOOPS_URL."/common/setup.php'>偏好設定</a></li>";
      }
    }else{
      return;
    }

    $main="
    <div id='menu'>
    <ul>{$td}
    </ul>
    </div>
    ";
    return $main;
  }
}

//首頁的連結工具
if(!function_exists('toolbar')){
  //$interface_menu[工具列名稱]="網址";
  //$interface_logo[工具列名稱]="圖檔名稱";（圖檔一律放到模組的images下）
  function toolbar($interface_menu=array(),$interface_logo=array(),$id="id='menu'",$li=""){
    if(empty($interface_menu))return;
    $td="";

    if(is_array($interface_menu)){
      foreach($interface_menu as $title => $url){
        $td.="<li $li><a href='".XOOPS_URL."/{$url}'>{$title}</a></li>";
      }
    }else{
      return;
    }

    $main="
    <div $id>
    <ul>{$td}
    </ul>
    </div>
    ";
    return $main;
  }
}
