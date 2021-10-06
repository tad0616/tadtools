<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class FooTableBootStrap
{
    public $selector = '.footable';

    //建構函數
    public function __construct($selector = '.footable')
    {
        $this->selector = $selector;
    }

    //產生語法
    public function render($need_jquery = true)
    {
        global $xoTheme;

        $jquery = $need_jquery ? Utility::get_jquery() : '';
        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/FooTableBootStrap/css/footable.bootstrap.css');
            $xoTheme->addScript('modules/tadtools/FooTableBootStrap/js/footable.js');

            $xoTheme->addScript('', null, "
              (function(\$){
                \$(document).ready(function(){
                  \$('{$this->selector}').footable();
                });
              })(jQuery);
            ");
        } else {
            $FooTable = "
            <link href='" . XOOPS_URL . "/modules/tadtools/FooTableBootStrap/css/footable.bootstrap.css' rel='stylesheet' type='text/css' >
            $jquery
            <script src='" . XOOPS_URL . "/modules/tadtools/FooTableBootStrap/js/footable.js' type='text/javascript'></script>
            <script type='text/javascript'>
              $(function() {
                $('{$this->selector}').footable();
              });
            </script>
            ";

            return $FooTable;
        }
    }
}

/*

use XoopsModules\Tadtools\FooTableBootStrap;

$FooTable = new FooTableBootStrap('.footable');
$FooTable->render();

把 $FooTableJS 加到表格前
table 需加上 class="footable" 以及 <thead></thead>

要加入擴展符號的格子在  th 加上  data-class="expand"
要藏起來的格子在  th 加上  data-hide="phone,tablet" 或 data-hide="phone"
加入排序 th 加上 data-sort-initial="true" （忽略排序  data-sort-ignore="true"） 資料類型  data-type="numeric"
資料過濾 search:<input id="filter" type="text">
<table data-filter="#filter" class="footable">

<table class="table">
<thead>
<tr>
<th data-breakpoints="xs">ID</th>
<th>First Name</th>
<th>Last Name</th>
<th data-breakpoints="xs">Job Title</th>
<th data-breakpoints="xs sm">Started On</th>
<th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th>
</tr>
</thead>
 */
