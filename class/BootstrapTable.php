<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class BootstrapTable
{
    public $name;

    public function __construct($name = "#bootstrapTable")
    {
        $this->name = $name;

    }

    public static function render($editable = true, $fixed = true, $sticky = true)
    {
        global $xoTheme;
        $jquery = Utility::get_jquery();
        $bootstrap_table = '';
        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/bootstrap-table/bootstrap-table.min.css');
            $xoTheme->addScript('modules/tadtools/bootstrap-table/bootstrap-table.min.js');
            $xoTheme->addScript('modules/tadtools/bootstrap-table/locale/bootstrap-table-' . _LANGCODE . '.min.js');
            $xoTheme->addScript('modules/tadtools/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js');
            $xoTheme->addScript('modules/tadtools/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js');

            if ($sticky) {
                $xoTheme->addStylesheet('modules/tadtools/bootstrap-table/extensions/sticky-header/bootstrap-table-sticky-header.css');
                $xoTheme->addScript('modules/tadtools/bootstrap-table/extensions/sticky-header/bootstrap-table-sticky-header.min.js');
            }

            if ($fixed) {
                $xoTheme->addStylesheet('modules/tadtools/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css');
                $xoTheme->addScript('modules/tadtools/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js');
            }

            if ($editable) {
                $xoTheme->addScript('modules/tadtools/bootstrap-table/extensions/editable/bootstrap-table-editable.min.js');
            }

        } else {
            $bootstrap_table = "
            {$jquery}
            <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . TADTOOLS_URL . "/bootstrap-table/bootstrap-table.min.css'>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/bootstrap-table.min.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/locale/bootstrap-table-" . _LANGCODE . ".min.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js'></script>
            ";

            if ($sticky) {
                $bootstrap_table .= "<link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . TADTOOLS_URL . "/bootstrap-table/extensions/sticky-header/bootstrap-table-sticky-header.css'>
                <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/sticky-header/bootstrap-table-sticky-header.min.js'></script>";
            }
            if ($fixed) {
                $bootstrap_table .= "<link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . TADTOOLS_URL . "/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css'>
                <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js'></script>";
            }
            if ($editable) {
                $bootstrap_table .= "<script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/editable/bootstrap-table-editable.min.js'></script>";
            }

        }
        return $bootstrap_table;

    }
}

/*
use XoopsModules\Tadtools\BootstrapTable;

$BootstrapTable=BootstrapTable::render();

<table> 可加入 data-toggle="table" data-pagination="true" data-search="true" data-mobile-responsive="true" data-url="資料來源.json"
data-url="../ajax.php?op=get_all_school&county=<{$county}>" (資料來源)
點擊編輯會用到：
data-id-field="SchoolCode"
data-editable-url="../ajax.php"
data-editable-params="{op:'update_school'}"
凍結欄位
data-fixed-columns="true"
data-fixed-number="2"
<tr> 可加入  data-sortable="true"  data-field="欄位名稱"
要有<thead>，不要有<tbody>
資料來源.json
{
"total": 200,
"rows": [
{
"id": 0,
"name": "Item 0",
"price": "$0"
},
{
"id": 1,
"name": "Item 1",
"price": "$1"
},
{
"id": 2,
"name": "Item 2",
"price": "$2"
}
]
}

https://bootstrap-table-docs3.wenzhixin.net.cn/documentation/
 */
