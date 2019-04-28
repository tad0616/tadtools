<?php

class FooTable extends \XoopsModules\Tadtools\FooTable
{
}

/*

use XoopsModules\Tadtools\FooTable;

$FooTable = new FooTable('.footable');
$FooTable->render();

把 $FooTableJS 加到表格前
table 需加上 class='footable' 以及 <thead></thead>
要加入擴展符號的格子在  th 加上  data-class='expand'
要藏起來的格子在  th 加上  data-hide='phone,tablet' 或 data-hide='phone'
加入排序 th 加上 data-sort-initial="true" （忽略排序  data-sort-ignore="true"） 資料類型  data-type="numeric"
資料過濾 search:<input id="filter" type="text">
<table data-filter="#filter" class="footable">
 */
