<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class BubblePopup
{
    public $code = [];
    public $show_jquery;
    public $show_all;

    //建構函數
    public function __construct($show_jquery = true, $show_all = true)
    {
        $this->show_jquery = $show_jquery;
        $this->show_all = $show_all;
    }

    //新增提示
    public function add_tip($selector = '', $content = '', $my = 'Bottom Left', $at = 'Top Right', $theme = 'qtip-bootstrap qtip-shadow qtip-rounded', $style = "color:'#FFFFFF'")
    {
        $this->code[] = "
        $('{$selector}').qtip({
            content: '$content',
            position: { my: '$my', at: '$at' },
            style: '$theme'
        });
        ";
    }

    //產生路徑工具
    public function render()
    {
        global $xoTheme;
        Utility::get_jquery(true);

        $all_code = implode("\n", $this->code);

        if (!$this->show_all) {
            return $all_code;
        }

        if ($xoTheme) {
            // die('aaaaa');
            $xoTheme->addStylesheet('modules/tadtools/jquery.qtip_2/jquery.qtip.css');
            $xoTheme->addScript('modules/tadtools/jquery.qtip_2/jquery.qtip.min.js');
            $xoTheme->addScript('modules/tadtools/jquery.qtip_2/imagesloaded.pkg.min.js');

            $xoTheme->addScript('', null, "
                \$(document).ready(function(){
                    {$all_code}
                });
          ");
        } else {
            // die('bbbbb');
            $main = "$jquery
            <link href='" . XOOPS_URL . "/modules/tadtools/jquery.qtip_2/jquery.qtip.css' rel='stylesheet' type='text/css' >
            <script src='" . XOOPS_URL . "/modules/tadtools/jquery.qtip_2/jquery.qtip.min.js' type='text/javascript'></script>
            <script src='" . XOOPS_URL . "/modules/tadtools/jquery.qtip_2/imagesloaded.pkg.min.js' type='text/javascript'></script>

            <script type='text/javascript'>
                $all_code
            </script>";

            return $main;
        }
    }
}

/*
use XoopsModules\Tadtools\BubblePopup;
$BubblePopup = new BubblePopup();
$BubblePopup->add_tip($id = "", $content = "", $position = "top", $align = "left", $theme = 'all-black', $style = "color:'#FFFFFF'");
$BubblePopup->render();
 */
