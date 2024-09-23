<?php
namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class DataList
{
    //建構函數
    public function __construct()
    {
    }

    //產生語法
    public static function render($maxHeight = '200')
    {
        global $xoTheme;

        Utility::get_jquery(true);

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/datalist/datalist.js');
            $xoTheme->addScript('', null, "
            \$(document).ready(function() {
                var maxHeight = '{$maxHeight}px';
                var openOnClick = true;
                \$('input[list]').datalist(maxHeight, openOnClick);
            });
            ");
        } else {
            $datalist = "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/datalist/datalist.js'></script>
            <script type=\"text/javascript\">
                $(document).ready(function() {
                    var maxHeight = '{$maxHeight}px';
                    var openOnClick = true;
                    $('input[list]').datalist(maxHeight, openOnClick);
                });
            </script>";

            return $datalist;
        }
    }
}

/*
use XoopsModules\Tadtools\DataList;
$DataList=new DataList();
$DataList->render();
or
DataList::render();

<input type="text" name="theme_config_name" class="form-control" placeholder="<{$smarty.const._MA_TADTHEMES_CONFIG_NAME}>" list="theme_config_list">

<datalist id="theme_config_list">
<{foreach from=$theme_config_list key=k item=title}>
<option value="<{$title|default:''}>">
<{/foreach}>
</datalist>
 */
