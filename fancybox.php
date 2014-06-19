<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/fancybox.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
include_once XOOPS_ROOT_PATH."/modules/tadtools/fancybox.php";
$fancybox=new fancybox('.edit_dropdown');
$fancybox_code=$fancybox->render();
$xoopsTpl->assign('fancybox_code',$fancybox_code);
加在連結中：class="edit_dropdown" rel="group"（圖） data-fancybox-type="iframe"（HTML）
*/
include_once "tadtools_header.php";


class fancybox{
  var $name;
  var $width;
  var $height;

  //建構函數
  function fancybox($name="",$width='90%',$height='100%'){
    //$this->name=randStr();
    $this->name=$name;
    $this->width=$width;
    $this->height=$height;
  }

  //產生語法
  function render($reload=true){


    $reload_code=$reload?",
        afterClose  :function () {
          window.location.reload();
        }":"";


    $fancybox="
    <script type='text/javascript' src='".TADTOOLS_URL."/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
    <script type='text/javascript' language='javascript' src='".TADTOOLS_URL."/fancyBox/source/jquery.fancybox.js?v=2.1.4'></script>
    <link rel='stylesheet' href='".TADTOOLS_URL."/fancyBox/source/jquery.fancybox.css?v=2.1.4' type='text/css' media='screen' />
    <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5' />
    <script type='text/javascript' src='".TADTOOLS_URL."/fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>
    <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7' />
    <script type='text/javascript' src='".TADTOOLS_URL."/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'></script>
    <script type='text/javascript' src='".TADTOOLS_URL."/fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.5'></script>
    <script type='text/javascript'>
    $(document).ready(function(){
      $('{$this->name}').fancybox({
        fitToView : true,
        width   : '{$this->width}',
        height    : '{$this->height}',
        autoSize  : true,
        closeClick  : false,
        openEffect  : 'none',
        closeEffect : 'none'
        {$reload_code}
      });
    });
    </script>
    ";
    return $fancybox;
  }
}
?>
