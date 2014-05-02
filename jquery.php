<?php
include_once "tadtools_header.php";

//取得jquery路徑，$mode="google"、"none"、"local","link","none"
//$theme=ui-lightness , base
if(!function_exists('get_jquery')){
  function get_jquery($ui=false,$mode="local",$theme='base'){
    $xoopsModuleConfig=TadToolsXoopsModuleConfig();
    //die("jquery_mode:{$xoopsModuleConfig['jquery_mode']}");

    switch($xoopsModuleConfig['jquery_mode']){
      case "none":
      $jquery_path="";
      break;

      case "google":
      $jquery_ui=$ui_css="";
      if($ui){
        $jquery_ui="
        <link href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/themes/{$theme}/jquery.ui.all.css' rel='stylesheet' type='text/css'>
        <script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js'></script>";
      }

      $jquery_path="
      <script type='text/javascript'>
        if(typeof jQuery == 'undefined') {
          document.write(\"<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'><\/script>\");
        }
      </script>
      $jquery_ui
      ";
      break;


      case "local":
      default:
      $jqueryui_path="";
      if($ui){
        /*
        $jqueryui_path="
        if(typeof jQuery.ui == 'undefined'){
        document.write(\"<link href='".TADTOOLS_URL."/jquery/themes/{$theme}/jquery.ui.all.css' rel='stylesheet' type='text/css'><script src='".TADTOOLS_URL."/jquery/ui/jquery-ui.js'><\/script>\");
        }";
        */
        $jqueryui_path="
        <link href='".TADTOOLS_URL."/jquery/themes/{$theme}/jquery.ui.all.css' rel='stylesheet' type='text/css'>
        <script src='".TADTOOLS_URL."/jquery/ui/jquery-ui.js'></script>";
      }

      $jquery_path="
      <script type='text/javascript'>
        if(typeof jQuery == 'undefined') {
        document.write(\"<script type='text/javascript' src='".TADTOOLS_URL."/jquery/jquery.js'><\/script>\");
        }
      </script>
      $jqueryui_path
      ";

      break;



    }

    return $jquery_path;
  }
}


?>
