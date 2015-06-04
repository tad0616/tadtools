<?php
include_once "tadtools_header.php";

//取得jquery路徑，$mode="google"、"none"、"local","link","none"
//$theme=ui-lightness , base

if (!function_exists('get_jquery')) {
    function get_jquery($ui = false, $mode = "local", $theme = 'base')
    {
        global $xoTheme;
        //$xoopsModuleConfig=TadToolsXoopsModuleConfig();
        if ($xoTheme) {
            $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
            $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate.min.js');
            if ($ui) {
                $xoTheme->addStylesheet("modules/tadtools/jquery/themes/{$theme}/jquery.ui.all.css");
                $xoTheme->addScript('modules/tadtools/jquery/ui/jquery-ui.js');
            }
            $xoTheme->addScript('modules/tadtools/jquery/jquery.jgrowl.js');
            /*
        $xoTheme->addScript('', null, '
        (function($){
        $(document).ready(function(){
        $.jGrowl("'.$_SESSION['redirect_message'].'", {position:"center"});
        });
        })(jQuery);
        ');
         */
        } else {

            $jqueryui_path = "";
            if ($ui) {

                $jqueryui_path = "
        <link href='" . TADTOOLS_URL . "/jquery/themes/{$theme}/jquery.ui.all.css' rel='stylesheet' type='text/css'>
        <script src='" . TADTOOLS_URL . "/jquery/ui/jquery-ui.js'></script>";
            }

            $jquery_path = "
      <script type='text/javascript'>
        if(typeof jQuery == 'undefined') {
        document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery-1.11.1.min.js'><\/script>\");
        document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery-migrate.min.js'><\/script>\");
        document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery.jgrowl.js'><\/script>\");
        }
      </script>
      $jqueryui_path
      ";
            return $jquery_path;
        }
    }
}
