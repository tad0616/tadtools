<?php
class dtree extends \XoopsModules\Tadtools\Dtree
{
}
/*
$home['sn']=$home_sn;
$home['title']=$home_title;
$home['url']=$home_url;

$sql = "select csn,of_csn,title from ".$xoopsDB->prefix("tad_gallery_cate")." order by sort";
$result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
while(list($csn,$of_csn,$title)=$xoopsDB->fetchRow($result)){
$title_arr[$csn]=$title;
$cate_arr[$csn]=$of_csn;
$url_arr[$csn]="cate.php?csn={$csn}";
}

use XoopsModules\Tadtools\Dtree;
$Dtree=new Dtree("album_tree","",$title_arr,$cate_arr,$url_arr);
$dtree_code=$Dtree->render("11pt",true);
$xoopsTpl->assign('dtree_code',$dtree_code);

 */
