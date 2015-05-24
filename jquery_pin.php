<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/jquery_pin.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
include_once XOOPS_ROOT_PATH."/modules/tadtools/jquery_pin.php";
$jquery_pin=new jquery_pin('.edit_dropdown');
$jquery_pin_code=$jquery_pin->render();
$xoopsTpl->assign('jquery_pin_code',$jquery_pin_code);
*/
include_once "tadtools_header.php";
include_once "jquery.php";

class jquery_pin{
  var $show_jquery;

  //建構函數
  function jquery_pin($show_jquery=true){
    $this->show_jquery = $show_jquery;
  }

  //產生語法
  function render($name="",$minWidth=940){
    global $xoTheme;
    if(empty($minWidth))$minWidth=940;
    $jquery=$this->show_jquery?get_jquery():"";

    if($xoTheme){
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
    }else{
      $main="
      {$jquery}
      <script type='text/javascript' src='".TADTOOLS_URL."/jquery.pin/jquery.pin.js}>'></script>
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
