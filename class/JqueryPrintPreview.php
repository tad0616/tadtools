<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class JqueryPrintPreview
{
    public $name;

    public function __construct($name = 'a.print-preview')
    {
        $this->name = $name;
    }

    public function render($mode = 'assign')
    {
        global $xoTheme;

        if ($xoTheme and 'assign' === $mode) {
            $xoTheme->addScript(XOOPS_URL . '/modules/tadtools/jquery-print-preview/jquery.print-preview.js');
            $xoTheme->addScript('', null, "
                (function(\$){
                    \$(document).ready(function(){
                    \$('{$this->name}').printPreview();
                    });
                })(jQuery);
                ");
            $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/jquery-print-preview/css/print-preview.css');
        } else {
            $jquery = Utility::get_jquery();

            $print_preview = "
            {$jquery}
            <link rel='stylesheet' href='" . XOOPS_URL . "/modules/tadtools/jquery-print-preview/css/print-preview.css' type='text/css' media='screen'>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/jquery-print-preview/jquery.print-preview.js'></script>
            <script>
              \$('{$this->name}').printPreview();
            </script>
            ";

            return $print_preview;
        }
    }
}

/*
use XoopsModules\Tadtools\JqueryPrintPreview;
$JqueryPrintPreview=new JqueryPrintPreview('a.print-preview');
$JqueryPrintPreview->render();

//布景樣板要有<{$module_css|default:''}>
$xoopsTpl->assign("module_css", '<link rel="stylesheet" href="' . XOOPS_URL . '/modules/tad_web/plugins/news/print.css" type="text/css" media="print">');

//print.css 內容
@import url('http://class.tn.edu.tw/modules/tadtools/bootstrap3/css/bootstrap.css');
#tad_sf_menu , #head_bg , #web_side_block, #tad_web_footer, #adm_bar, .sweet-overlay, .sweet-alert, #goog-gt-tt{
display: none;
}
 */
