<?php
include_once "tadtools_header.php";

//取得jquery路徑，$mode="return"
//$theme=ui-lightness , base

if (!function_exists('get_jquery')) {
    function get_jquery($ui = false, $mode = "", $theme = 'base')
    {
        global $xoTheme;
        //$xoopsModuleConfig=TadToolsXoopsModuleConfig();
        if (!isset($xoTheme) or $mode == "return") {
            $jqueryui_path = "";
            if ($ui) {

                $jqueryui_path = "
                <link href='" . TADTOOLS_URL . "/jquery/themes/{$theme}/jquery.ui.all.css' rel='stylesheet' type='text/css'>
                <script src='" . TADTOOLS_URL . "/jquery/ui/jquery-ui.js'></script>";
            }

            $ver = (int)str_replace('.', '', substr(XOOPS_VERSION, 6, 5));
            if ($ver >= 259) {
                $jquery_path = "
                  <script type='text/javascript'>
                    if(typeof jQuery == 'undefined') {
                    document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery-3.2.1.js'><\/script>\");
                    document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery-migrate-3.0.0.min.js'><\/script>\");
                    document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery.jgrowl.js'><\/script>\");
                    }
                  </script>
                  $jqueryui_path
                  ";
            } else {
                $jquery_path = "
                  <script type='text/javascript'>
                    if(typeof jQuery == 'undefined') {
                    document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery-3.2.1.js'><\/script>\");
                    document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery-migrate-1.4.1.min.js'><\/script>\");
                    document.write(\"<script type='text/javascript' src='" . TADTOOLS_URL . "/jquery/jquery.jgrowl.js'><\/script>\");
                    }
                  </script>
                  $jqueryui_path
                  ";
            }
            return $jquery_path;
        } else {

            $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');

            $ver = (int)str_replace('.', '', substr(XOOPS_VERSION, 6, 5));

            if ($ver >= 259) {
                $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
            } else {
                $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
            }

            if ($ui) {
                $xoTheme->addStylesheet("modules/tadtools/jquery/themes/{$theme}/jquery.ui.all.css");
                $xoTheme->addScript('modules/tadtools/jquery/ui/jquery-ui.js');
            }
        }
    }
}
