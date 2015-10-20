<?php
include_once "tadtools_header.php";

class FooTable
{

    //建構函數
    public function FooTable()
    {

    }

    //產生語法
    public function render($selector = 'table')
    {
        global $xoTheme;
        $jquery = get_jquery();

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/footable-bootstrap/css/footable.bootstrap.min.css');
            $xoTheme->addScript('modules/tadtools/footable-bootstrap/js/footable.min.js');

            $xoTheme->addScript('', null, "
            \$(document).ready(function(){
              \$('{$selector}').footable();
            });
            ");
        } else {

            $FooTable = "
            <link href='" . TADTOOLS_URL . "/footable-bootstrap/css/footable.bootstrap.min.css' rel='stylesheet' type='text/css' />

            <script src='" . TADTOOLS_URL . "/footable-bootstrap/js/footable.min.js' type='text/javascript'></script>
            <script type='text/javascript'>
              $(document).ready(function(){
                $('{$selector}').footable();
              });
            </script>
            ";
            return $FooTable;
        }
    }
}

/*
if(file_exists(XOOPS_ROOT_PATH."/modules/tadtools/FooTable_bootstrap.php")){
include_once XOOPS_ROOT_PATH."/modules/tadtools/FooTable_bootstrap.php";

$FooTable = new FooTable();
$FooTableJS=$FooTable->render();
$xoopsTpl->assign('FooTableJS' , $FooTableJS);
}
把 $FooTableJS 加到表格前

表格先設個id，如id=" phone_table"，並且在表格標題列用<thead>包起來。
在表格標題<th>中，看哪些欄位要隱藏的，加上以下註記，xs(480) sm(768) md(992) lg(1200)分別代表個種不同螢幕尺寸，若有md，表示螢幕小於992就將該欄位隱藏之意。all則是不管螢幕一律隱藏（記住一個原則，註記越多，越早隱藏）
data-breakpoints="xs sm md lg"
若是bootstrap2請自行將xs改為x-small，sm改為small，md改為medium，lg改為lagre即可。
假如沒有標題列，請在第一列的<td>中加入data-title屬性，以做成標題。
表格排序只要在<table>中加入 data-sorting="true" 即可
可在<th>用data-type來指定欄位類型，預設為text，還可指定為number或date
內容過濾只要在<table>中加入 data-filtering="true" 即可
 */
