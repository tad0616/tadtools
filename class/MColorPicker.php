<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class MColorPicker
{
    public $name;
    public $show_jquery;

    public function __construct($name = '.color', $show_jquery = true)
    {
        $this->name        = $name;
        $this->show_jquery = $show_jquery;
    }

    // bootstrap,bootstrap-sm,bootstrap5,bootstrap5-sm,pic
    public function render($show_picker = 'bootstrap')
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/mColorPicker/javascripts/mColorPicker.js');
            $xoTheme->addScript('modules/tadtools/mColorPicker/javascripts/contrastRatio.js');

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
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/mColorPicker/javascripts/contrastRatio.js'></script>
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

$MColorPicker=new MColorPicker('.color-picker');
$MColorPicker->render('bootstrap');

//data-hex='true' 一定要有
<input type='text' name='color' class='color' value='{$act['color']}' data-text='hidden' data-hex='true' style='height:20px;width:20px;'>

<!-- 導覽列顏色 -->
<input type="text" id="navbar_bg" class="color-picker"
onchange="ContrastRatio('navbar_contrast', 'navbar_text', 'navbar_bg');">
<span>導覽列對比度: <span id="navbar_contrast"></span></span>

<!-- 頁尾顏色 -->
<input type="text" id="footer_bg" class="color-picker"
onchange="ContrastRatio('footer_contrast', 'footer_text', 'footer_bg');">
<span>頁尾對比度: <span id="footer_contrast"></span></span>

<script>
$(document).ready(function() {
// 設置顏色對的關聯關係，用於在顏色選擇器內部移動時更新對比度
if (typeof setupContrastRatioPairs === 'function') {
setupContrastRatioPairs([
{display: 'navbar_contrast', color1: 'navbar_text'},
{display: 'footer_contrast', color1: 'footer_text'}
]);

// 確保頁面完全加載後再計算對比度
setTimeout(function() {
if (typeof updateAllContrastRatios === 'function') {
updateAllContrastRatios();
}
}, 100);
}
});
</script>
 */
