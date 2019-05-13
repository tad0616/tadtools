<?php
namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class StickyTableHeaders
{
    public $show_jquery;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法
    public function render($name = '', $fixedOffset = '')
    {
        global $xoTheme;
        $showFixedOffset = empty($fixedOffset) ? '' : "{fixedOffset:$fixedOffset}";
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/stickytableheaders/jquery.stickytableheaders.js');

            $xoTheme->addScript('', null, "
                \$(document).ready(function(){
                \$('{$name}').stickyTableHeaders($showFixedOffset);
                });
            ");
        } else {
            $main = "
            {$jquery}

            <script src='" . XOOPS_URL . "/modules/tadtools/stickytableheaders/jquery.stickytableheaders.js'></script>
            <script type='text/javascript'>
                $(document).ready(function(){
                $('{$name}').stickyTableHeaders($showFixedOffset);
                });
            </script>
            ";

            return $main;
        }
    }
}

/*
use XoopsModules\Tadtools\StickyTableHeaders;
$StickyTableHeaders=new StickyTableHeaders();
$StickyTableHeaders->render('#my_table');
表格需有 <thead>及<tbody>
 */
