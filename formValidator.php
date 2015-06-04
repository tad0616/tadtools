<?php
include_once "tadtools_header.php";
include_once "jquery.php";

class formValidator
{
    public $show_jquery;
    public $id;

    //建構函數
    public function formValidator($id = "", $show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
        $this->id          = $id;
    }

    //產生路徑工具
    public function render($Position = "topRight")
    {
        global $xoTheme;
        $jquery = ($this->show_jquery) ? get_jquery() : "";

        $LANGCODE = str_replace("-", "_", _LANGCODE);

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/formValidator/css/validationEngine.jquery.css');
            $xoTheme->addScript("modules/tadtools/formValidator/js/languages/jquery.validationEngine-{$LANGCODE}.js");
            $xoTheme->addScript('modules/tadtools/formValidator/js/jquery.validationEngine.js');

            $xoTheme->addScript('', null, "
        (function(\$){
          \$(document).ready(function(){
            \$('{$this->id}').validationEngine({
              inlineValidation: true,
              success :  false,
              promptPosition: '$Position', //選項有：topLeft, topRight, bottomLeft,  centerRight, bottomRight
              failure : function() {}
            });
          });
        })(jQuery);
      ");
        } else {

            $main = "
      <link rel='stylesheet' href='" . TADTOOLS_URL . "/formValidator/css/validationEngine.jquery.css' type='text/css' media='screen' charset='utf-8' />

      $jquery
      <script src='" . TADTOOLS_URL . "/formValidator/js/languages/jquery.validationEngine-{$LANGCODE}.js' type='text/javascript'></script>
      <script src='" . TADTOOLS_URL . "/formValidator/js/jquery.validationEngine.js' type='text/javascript'></script>
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

}

// include_once XOOPS_ROOT_PATH."/modules/tadtools/formValidator.php";
// $formValidator= new formValidator("#myForm",false);
// $formValidator_code=$formValidator->render('topLeft');
