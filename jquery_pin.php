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
    if(empty($minWidth))$minWidth=940;
    $jquery=$this->show_jquery?get_jquery():"";

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


    <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/flexslider2/reset.css' />
    <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/flexslider2/flexslider.css' />
    $jquery
    <script language='javascript' type='text/javascript' src='".TADTOOLS_URL."/flexslider2/jquery.flexslider.js'></script>


    <script type='text/javascript'>
     $(document).ready( function(){
        $('.flexslider').flexslider({
          animation: 'slide'
        });
      });
    </script>
    <!-- Place somewhere in the <body> of your page -->
    <div class='flexslider'>
      <ul class='slides'>
        $all
      </ul>
    </div>

    ";
    return $main;
  }

}
?>
