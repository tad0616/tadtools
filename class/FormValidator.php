<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class FormValidator
{
    public $show_jquery;
    public $id;

    //建構函數
    public function __construct($id = '', $show_jquery = true)
    {
        Utility::get_jquery(true);
        $this->show_jquery = $show_jquery;
        $this->id = $id;
    }

    //產生路徑工具
    public function render($Position = 'topRight')
    {
        global $xoTheme;

        Utility::get_jquery();

        $LANGCODE = str_replace('-', '_', _LANGCODE);

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/formValidator/css/validationEngine.jquery.css');
            $xoTheme->addScript("modules/tadtools/formValidator/js/languages/jquery.validationEngine-{$LANGCODE}.js");
            $xoTheme->addScript('modules/tadtools/formValidator/js/jquery.validationEngine.js');

            $xoTheme->addScript('', null, "
                (function(\$){
                    \$(document).ready(function(){
                        \$('{$this->id}').validationEngine({
                            promptPosition: '$Position', //選項有：topLeft, topRight, bottomLeft,  centerRight, bottomRight
                        });
                    });
                })(jQuery);
            ");
        } else {
            $main = "
            <link rel='stylesheet' href='" . XOOPS_URL . "/modules/tadtools/formValidator/css/validationEngine.jquery.css' type='text/css' media='screen' charset='utf-8' />

            $jquery
            <script src='" . XOOPS_URL . "/modules/tadtools/formValidator/js/languages/jquery.validationEngine-{$LANGCODE}.js' type='text/javascript'></script>
            <script src='" . XOOPS_URL . "/modules/tadtools/formValidator/js/jquery.validationEngine.js' type='text/javascript'></script>
            <script type='text/javascript'>
            $().ready(function() {
                $('{$this->id}').validationEngine({
                    promptPosition: '$Position', //選項有：topLeft, topRight, bottomLeft,  centerRight, bottomRight
                });
            });
            </script>";

            return $main;
        }
    }
}

/*
use XoopsModules\Tadtools\FormValidator;
$FormValidator= new FormValidator("#myForm",false);
$FormValidator->render('topLeft');
 */
