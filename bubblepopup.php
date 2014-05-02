<?php
include_once "tadtools_header.php";
include_once "jquery.php";


class bubblepopup{
  var $code=array();
  var $show_jquery;
  var $show_all;

  //建構函數
  function bubblepopup($show_jquery=true,$show_all=true){
    $this->show_jquery=$show_jquery;
    $this->show_all=$show_all;
  }

  //新增提示
  function add_tip($id="",$content="",$position="top",$align="left",$theme='all-black',$style="color:'#FFFFFF'"){
    $this->code[]="
     $('{$id}').CreateBubblePopup({
        position : '{$position}',
        align  : '{$align}',
        innerHtml: '{$content}',
        innerHtmlStyle: {{$style}},
        themeName:  '{$theme}',
        themePath:  '".TADTOOLS_URL."/jQueryBubblePopup/jquerybubblepopup-theme'
      });
    ";
  }


  //產生路徑工具
  function render(){
    $jquery=($this->show_jquery)?get_jquery(true):"";

    $all_code=implode("\n",$this->code);

    if(!$this->show_all){
      return $all_code;
    }

    $main="
    $jquery
    <link href='".TADTOOLS_URL."/jQueryBubblePopup/jquery.bubblepopup.v2.3.1.css' rel='stylesheet' type='text/css' />
    <script src='".TADTOOLS_URL."/jQueryBubblePopup/jquery.bubblepopup.v2.3.1.min.js' type='text/javascript'></script>

    <script type='text/javascript'>
    $(document).ready(function()  {
      $all_code
    });

    </script>";


    return $main;
  }

  //產生
  function render2($all_code=""){
    $jquery=($this->show_jquery)?get_jquery(true):"";

    $main="
    $jquery
    <link href='".TADTOOLS_URL."/jQueryBubblePopup/jquery.bubblepopup.v2.3.1.css' rel='stylesheet' type='text/css' />
    <script src='".TADTOOLS_URL."/jQueryBubblePopup/jquery.bubblepopup.v2.3.1.min.js' type='text/javascript'></script>

    <script type='text/javascript'>
    $(document).ready(function()  {
      $all_code
    });

    </script>";


    return $main;
  }
}
?>
