<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/jquery_pin.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH."/modules/tadtools/jquery_pin.php";
$jquery_pin=new jquery_pin();
$jquery_pin_code=$jquery_pin->render('.edit_dropdown');
$xoopsTpl->assign('jquery_pin_code',$jquery_pin_code);
 */
require_once __DIR__ . '/tadtools_header.php';
require_once __DIR__ . '/jquery.php';

class jquery_pin
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

        $jquery = $this->show_jquery ? get_jquery() : '';

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
      <script type='text/javascript' src='" . TADTOOLS_URL . "/jquery.pin/jquery.pin.js}>'></script>
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
