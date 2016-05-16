<?php
include_once "tadtools_header.php";
include_once "jquery.php";

class bubblepopup
{
    public $code = array();
    public $show_jquery;
    public $show_all;

    //建構函數
    public function __construct($show_jquery = true, $show_all = true)
    {
        $this->show_jquery = $show_jquery;
        $this->show_all    = $show_all;
    }

    //新增提示
    public function add_tip($id = "", $content = "", $position = "top", $align = "left", $theme = 'all-black', $style = "color:'#FFFFFF'")
    {
        $this->code[] = "
      \$('{$id}').qtip({
        content:'$content'
      });
    ";
    }

    //產生路徑工具
    public function render()
    {
        global $xoTheme;
        $jquery = ($this->show_jquery) ? get_jquery(true) : "";

        $all_code = implode("\n", $this->code);

        if (!$this->show_all) {
            return $all_code;
        }

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/jquery.qtip/jquery.qtip.css');
            $xoTheme->addScript('modules/tadtools/jquery.qtip/jquery.qtip.js');
            $xoTheme->addScript('modules/tadtools/jquery.qtip/imagesloaded.pkg.min.js');

            $xoTheme->addScript('', null, "
        (function(\$){
          \$(document).ready(function(){
            {$all_code}
          });
        })(jQuery);
      ");
        } else {
            $main = "
      $jquery
      <link href='" . TADTOOLS_URL . "/jquery.qtip/jquery.qtip.css' rel='stylesheet' type='text/css' />
      <script src='" . TADTOOLS_URL . "/jquery.qtip/jquery.qtip.js' type='text/javascript'></script>
      <script src='" . TADTOOLS_URL . "/jquery.qtip/imagesloaded.pkg.min.js' type='text/javascript'></script>

      <script type='text/javascript'>
       $all_code
      </script>";

            return $main;
        }
    }

}
