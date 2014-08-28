<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/colorbox.php")){
  redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/colorbox.php";
$colorbox=new colorbox('.iframe');
$colorbox_code=$colorbox->render();
$xoopsTpl->assign('colorbox_code',$colorbox_code);
*/
include_once "tadtools_header.php";
include_once "jquery.php";


class colorbox{
  var $name;
  var $width;
  var $height;

  //建構函數
  function colorbox($name=".iframe",$width='80%',$height='90%',$show_jquery=true){
    $this->name=$name;
    $this->width=$width;
    $this->height=$height;
    $this->show_jquery = $show_jquery;
  }

  //產生語法
  function render(){
    $data="";
    $jquery=$this->show_jquery?get_jquery():"";

    $colorbox="
    <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='".TADTOOLS_URL."/colorbox/colorbox.css' />
    {$jquery}
    <script type='text/javascript' src='".TADTOOLS_URL."/colorbox/jquery.colorbox.js'></script>
    <script>
      $(document).ready(function(){
        $('".$this->name."').colorbox({iframe:true, width:'".$this->width."', height:'".$this->height."'});
      });
    </script>

    ";
    return $colorbox;
  }
}

/*
$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
$('a.gallery').colorbox({rel:'gal'});
$('a#login').colorbox();
$.colorbox({href:"thankyou.html"});
$.colorbox({html:"<h1>Welcome</h1>"});
$("a.gallery").colorbox({rel: 'gal', title: function(){
  var url = $(this).attr('href');
  return '<a href="' + url + '" target="_blank">Open In New Window</a>';
}});
 */
?>
