<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class JqueryPin
{
    public $show_jquery;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法
    public function render($name = '', $minWidth = 940)
    {
        global $xoTheme;
        if (empty($minWidth)) {
            $minWidth = 940;
        }

        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/jquery.pin/jquery.pin.js');

            $xoTheme->addScript('', null, "
                (function(\$){
                \$(document).ready(function(){
                    \$('{$name}').pin({
                    minWidth: {$minWidth}
                    });
                });
                })(jQuery);
            ");
        } else {
            $main = "
            {$jquery}
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery.pin/jquery.pin.js}>'></script>
            <script type='text/javascript'>
                $(document).ready(function(){
                $('{$name}').pin({
                    minWidth: {$minWidth}
                });
                });
            </script>
            ";

            return $main;
        }
    }
}

/*
use XoopsModules\Tadtools\JqueryPin;
$JqueryPin=new JqueryPin();
$JqueryPin->render('.edit_dropdown');
 */
