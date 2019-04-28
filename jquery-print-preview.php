<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/jquery.print-preview.php")){
redirect_header("index.php",3, _TAD_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH."/modules/tadtools/jquery.print-preview.php";
$print_preview=new print_preview('a.print-preview');
$print_preview_code=$print_preview->render();
//$xoopsTpl->assign('print_preview_code',$print_preview_code);
//布景樣板要有<{$module_css}>
$xoopsTpl->assign("module_css", '<link rel="stylesheet" href="' . XOOPS_URL . '/modules/tad_web/plugins/news/print.css" type="text/css" media="print">');

//print.css 內容
//@import url('http://class.tn.edu.tw/modules/tadtools/bootstrap3/css/bootstrap.css');
//#tad_sf_menu , #head_bg , #web_side_block, #tad_web_footer, #adm_bar, .sweet-overlay, .sweet-alert, #goog-gt-tt{
//  display: none;
//}
 */
require_once __DIR__ . '/tadtools_header.php';
require_once __DIR__ . '/jquery.php';

class print_preview
{
    public $name;

    public function __construct($name = 'a.print-preview')
    {
        $this->name = $name;
        $this->show_jquery = $show_jquery;
    }

    public function render($mode = 'assign')
    {
        global $xoTheme;

        if ($xoTheme and 'assign' === $mode) {
            $xoTheme->addScript('modules/tadtools/jquery-print-preview/jquery.print-preview.js');

            $xoTheme->addScript('', null, "
              (function(\$){
                \$(document).ready(function(){
                  \$('{$this->name}').printPreview();
                });
              })(jQuery);
            ");
            $xoTheme->addStylesheet('modules/tadtools/jquery-print-preview/css/print-preview.css');
        } else {
            $jquery = get_jquery();

            $print_preview = "
            {$jquery}
            <link rel='stylesheet' href='" . TADTOOLS_URL . "/jquery-print-preview/css/print-preview.css' type='text/css' media='screen'>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/jquery-print-preview/jquery.print-preview.js'></script>
            <script>
              \$('{$this->name}').printPreview();
            </script>
            ";

            return $print_preview;
        }
    }
}
