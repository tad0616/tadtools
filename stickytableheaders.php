<?php
/*
用來將任何元素，釘在畫面頂端
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/stickytableheaders.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/stickytableheaders.php";
$stickytableheaders=new stickytableheaders();
$stickytableheaders_code=$stickytableheaders->render('#my_table');
$xoopsTpl->assign('stickytableheaders_code',$stickytableheaders_code);
表格需有 <thead>及<tbody>

 */
include_once "tadtools_header.php";
include_once "jquery.php";

class stickytableheaders
{
    public $show_jquery;

    //建構函數
    public function stickytableheaders($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法
    public function render($name = "", $fixedOffset = "")
    {
        global $xoTheme;
        $showFixedOffset = empty($fixedOffset) ? "" : "{fixedOffset:$fixedOffset}";
        $jquery          = $this->show_jquery ? get_jquery() : "";

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/StickyTableHeaders/jquery.stickytableheaders.js');

            $xoTheme->addScript('', null, "
        \$(document).ready(function(){
          \$('{$name}').stickyTableHeaders($showFixedOffset);
        });
      ");
        } else {
            $main = "
      {$jquery}

      <script src='" . TADTOOLS_URL . "/StickyTableHeaders/jquery.stickytableheaders.js'></script>
      <script type='text/javascript'>
        $(document).ready(function(){
          $('{$name}').stickyTableHeaders($showFixedOffset);
        });
      </script>
      ";

            return $main;
        }
    }

}
