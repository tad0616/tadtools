<?php
include_once "tadtools_header.php";
include_once "jquery.php";


class formValidator{
  var $show_jquery;
  var $id;

  //建構函數
  function formValidator($id="",$show_jquery=true){
    $this->show_jquery=$show_jquery;
    $this->id=$id;
  }


  //產生路徑工具
  function render($Position="topRight"){
    $jquery=($this->show_jquery)?get_jquery():"";

    $LANGCODE=str_replace("-","_",_LANGCODE);

    $main="
    <link rel='stylesheet' href='".TADTOOLS_URL."/formValidator/css/validationEngine.jquery.css' type='text/css' media='screen' charset='utf-8' />

    $jquery
    <script src='".TADTOOLS_URL."/formValidator/js/languages/jquery.validationEngine-{$LANGCODE}.js' type='text/javascript'></script>
    <script src='".TADTOOLS_URL."/formValidator/js/jquery.validationEngine.js' type='text/javascript'></script>
    <script type='text/javascript'>
    $().ready(function() {
        $('{$this->id}').validationEngine({
            inlineValidation: true,
            success :  false,
            promptPosition: '$Position', //選項有：topLeft, topRight, bottomLeft,  centerRight, bottomRight
            failure : function() {}
        });
    });
    </script>";


    return $main;
  }

}


// include_once XOOPS_ROOT_PATH."/modules/tadtools/formValidator.php";
// $formValidator= new formValidator("#myForm",false);
// $formValidator_code=$formValidator->render('topLeft');
?>
