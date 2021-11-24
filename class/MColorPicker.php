<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class MColorPicker
{
    public $name;

    public function __construct($name = '.color', $show_jquery = true)
    {
        $this->name = $name;
        $this->show_jquery = $show_jquery;
    }

    public function render($show_picker = 'pic')
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/mColorPicker/javascripts/mColorPicker.js');

            $xoTheme->addScript('', null, "
                \$('{$this->name}').mColorPicker({
                    imageFolder: '" . XOOPS_URL . "/modules/tadtools/mColorPicker/images/',
                    showPicker: '$show_picker'
                });
            ");
        } else {
            $mColorPicker = "
            {$jquery}
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/mColorPicker/javascripts/mColorPicker.js'></script>
            <script>
                \$('{$this->name}').mColorPicker({
                    imageFolder: '" . XOOPS_URL . "/modules/tadtools/mColorPicker/images/',
                    showPicker: '$show_picker'
                });
            </script>
            ";

            return $mColorPicker;
        }
    }
}

/*
use XoopsModules\Tadtools\MColorPicker;

$MColorPicker=new MColorPicker('.color');
$MColorPicker->render();

//data-hex='true' 一定要有
<input type='text' name='color' class='color' value='{$act['color']}' data-text='hidden' data-hex='true' style='height:20px;width:20px;'>

 */
