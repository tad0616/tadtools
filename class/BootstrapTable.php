<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class BootstrapTable
{
    public $name;

    public function __construct($name = "#demoTab")
    {
        $this->name = $name;

    }

    public static function render()
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

        } else {
            $bootstrap_table = "
            {$jquery}
            <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . TADTOOLS_URL . "/bootstrap-table/bootstrap-table.min.css'>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/bootstrap-table.min.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/locale/bootstrap-table-" . _LANGCODE . ".min.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js'></script>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js'></script>
            ";

        }
        return $bootstrap_table;

    }
}

/*
use XoopsModules\Tadtools\BootstrapTable;

$BootstrapTable=BootstrapTable::render();

<table> 可加入 data-toggle="table" data-pagination="true" data-search="true"  data-url="資料來源.json" data-mobile-responsive="true"
<tr> 可加入  data-sortable="true"  data-field="欄位名稱"

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
