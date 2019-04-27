<?php
class jeditable extends \XoopsModules\Tadtools\Jeditable
{
}

/*
use XoopsModules\Tadtools\Jeditable;
$file="save.php";
$jeditable = new Jeditable();
$jeditable->setTextCol("#candidate_note",$file,'140px','12px',"{'vote_sn':$vote_sn,'candidate_id':'$candidate_id','op' : 'save'}","編輯備註");
$jeditable->setTextAreaCol("#id",$file,'140px','12px',"{'sn':$sn,'op' : 'save'}","點擊編輯");
$jeditable->setSelectCol("#id",$file,"{'boy':'男生' , 'girl':'女生' , 'selected':'girl'}","{'sn' : $sn , 'op' : 'save'}","點擊編輯");
$jeditable->render();

<?php
include "header.php";
$sql="update ".$xoopsDB->prefix("vote_candidate")." set `candidate_note`='{$_POST['value']}' where vote_sn='{$_POST['vote_sn']}' and candidate_id='{$_POST['candidate_id']}'";
$xoopsDB->queryF($sql);
echo $_POST['value'];
?>

 */
