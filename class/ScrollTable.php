<?php
namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class ScrollTable
{
    public $show_jquery;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法
    public function render($name = '', $fixedCols = '1', $headerRows = '1', $max_height = 500, $add_height = 12)
    {
        global $xoTheme;

        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/ScrollTable/superTables.css');
            $xoTheme->addScript('modules/tadtools/ScrollTable/superTables.js');
            $xoTheme->addScript('modules/tadtools/ScrollTable/jquery.superTable.js');

            $xoTheme->addScript('', null, "
                (function(\$){
                    \$(document).ready(function(){
                        var height = \$('{$name}').height();
                        if(height > $max_height){
                            height = $max_height;
                        }else{
                            height=height+$add_height;
                        }
                        \$('{$name}').toSuperTable({ width: '100%', height: height+'px', fixedCols: $fixedCols , headerRows: $headerRows });
                    });
                })(jQuery);
            ");
        } else {
            $main = "
            {$jquery}
            <link href='" . XOOPS_URL . "/modules/tadtools/ScrollTable/superTables.css' rel='stylesheet' type='text/css'>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/ScrollTable/superTables.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/ScrollTable/jquery.superTable.js'></script>
            <script type='text/javascript'>
                $(document).ready(function(){
                    var height = $('{$name}').height();
                    if(height > $max_height){
                        height = $max_height;
                    }else{
                        height=height+$add_height;
                    }
                    $('{$name}').toSuperTable({ width: '100%', height: height+'px', fixedCols: $fixedCols , headerRows: $headerRows });
                });
            </script>
            ";

            return $main;
        }
    }
}

/*
use XoopsModules\Tadtools\ScrollTable;
$ScrollTable=new ScrollTable();
$ScrollTable->render('#table',1,1,500,12);
 */
