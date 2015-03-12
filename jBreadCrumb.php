<?php
include_once "tadtools_header.php";
include_once "jquery.php";


class jBreadCrumb{
  var $path;
  var $show_jquery;

	//建構函數
	function jBreadCrumb($path=array(),$show_jquery=true){
    $this->path=$path;
    $this->show_jquery=$show_jquery;
	}

  //設定路徑工具
  function setPath($path=array()){
    $this->path=$path;
  }

	//產生路徑工具
	function render(){
    global $xoTheme;
    if(is_array($this->path)){
      $opt="";
      foreach($this->path as $title=>$url){
        if(empty($title))continue;
        $opt.="<li><a href='$url'>$title</a></li>\n";
      }
    }
    $jquery=($this->show_jquery)?get_jquery():"";


    if($xoTheme){
      $xoTheme->addStylesheet('modules/tadtools/jBreadCrumb/Styles/BreadCrumb.css');
      $xoTheme->addScript('modules/tadtools/jBreadCrumb/js/jquery.easing.1.3.js');
      $xoTheme->addScript('modules/tadtools/jBreadCrumb/js/jquery.jBreadCrumb.1.1.js');

      $xoTheme->addScript('', null, "
        (function(\$){
          \$(document).ready(function(){
            \$('#breadCrumb').jBreadCrumb();
          });
        })(jQuery);
      ");
      $main="";
    }else{
      $main="
      <link rel='stylesheet' href='".TADTOOLS_URL."/jBreadCrumb/Styles/BreadCrumb.css' type='text/css'>
      $jquery
      <script src='".TADTOOLS_URL."/jBreadCrumb/js/jquery.easing.1.3.js' type='text/javascript' language='JavaScript'></script>
      <script src='".TADTOOLS_URL."/jBreadCrumb/js/jquery.jBreadCrumb.1.1.js' type='text/javascript' language='JavaScript'></script>
      <script type='text/javascript'>
       $(document).ready(function()
       {
          $('#breadCrumb').jBreadCrumb();
       })
      </script>
      ";
    }

    $main.="
    <div id='breadCrumb' class='breadCrumb module'>
     <ul>
       $opt
     </ul>
    </div>";
    return $main;
  }
}
?>
