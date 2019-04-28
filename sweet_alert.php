<?php

class sweet_alert extends \XoopsModules\Tadtools\SweetAlert
    {
}
/*

function del_table(mssn){
var sure = window.confirm('"._TAD_DEL_CONFIRM."');
if (!sure)  return;
location.href="ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=" + mssn;
}

轉換為

use XoopsModules\Tadtools\SweetAlert;

$SweetAlert=new SweetAlert();
$SweetAlert->render("del_table","ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=",'mssn');

 */
