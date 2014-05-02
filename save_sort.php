<?php
include_once "tadtools_header.php";

$sql="update `".$_REQUEST['tbl_name']."` set `sort`=`sort`+100 where `col_name`='{$_REQUEST['col_name']}' and `col_sn`='{$_REQUEST['col_sn']}'";
$xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL." (".$sql.")");

$sort = 1;
foreach ($_POST['fdtr'] as $files_sn) {
  $sql="update `".$_REQUEST['tbl_name']."` set `sort`='{$sort}' where `files_sn`='{$files_sn}'";
  $xoopsDB->queryF($sql) or die(_TAD_SORT_FAIL." (".$sql.")");
  $sort++;
}

echo _TAD_SORTED." (".date("Y-m-d H:i:s").")";
?>