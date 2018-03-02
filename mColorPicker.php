<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/mColorPicker.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/mColorPicker.php";
$mColorPicker=new mColorPicker('.color');
$mColorPicker_code=$mColorPicker->render();
$xoopsTpl->assign('mColorPicker_code',$mColorPicker_code);

//data-hex='true' 一定要有
<input type='text' name='color' class='color' value='{$act['color']}' data-text='hidden' data-hex='true' style='height:20px;width:20px;' />

 */
include_once "tadtools_header.php";
include_once "jquery.php";

class mColorPicker
{
    public $name;

    //
    public function __construct($name = ".color", $show_jquery = true)
    {
        $this->name        = $name;
        $this->show_jquery = $show_jquery;
    }

    //
    public function render()
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? get_jquery() : "";

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/mColorPicker/javascripts/mColorPicker.js');

            $xoTheme->addScript('', null, "
        \$('{$this->name}').mColorPicker({
          imageFolder: '" . TADTOOLS_URL . "/mColorPicker/images/'
        });
      ");
        } else {
            $mColorPicker = "
      {$jquery}
      <script type='text/javascript' src='" . TADTOOLS_URL . "/mColorPicker/javascripts/mColorPicker.js'></script>
      <script>
        \$('{$this->name}').mColorPicker({
          imageFolder: '" . TADTOOLS_URL . "/mColorPicker/images/'
        });
      </script>
      ";

            return $mColorPicker;
        }
    }
}
