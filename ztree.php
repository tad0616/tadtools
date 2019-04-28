<?php

class ztree extends \XoopsModules\Tadtools\Ztree
{
}

/*

$path     = get_tad_link_cate_path($show_cate_sn);
$path_arr = array_keys($path);
$sql      = "select cate_sn,of_cate_sn,cate_title from " . $xoopsDB->prefix("tad_link_cate") . " order by cate_sort";
$result   = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());

$count  = tad_link_cate_count();
$data[] = "{ id:0, pId:0, name:'All', url:'index.php', target:'_self', open:true}";
while (list($cate_sn, $of_cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
$font_style      = $show_cate_sn == $cate_sn ? ", font:{'background-color':'yellow', 'color':'black'}" : '';
$open            = in_array($cate_sn, $path_arr) ? 'true' : 'false';
$display_counter = empty($count[$cate_sn]) ? "" : " ({$count[$cate_sn]})";
$data[]          = "{ id:{$cate_sn}, pId:{$of_cate_sn}, name:'{$cate_title}{$display_counter}', url:'index.php?cate_sn={$cate_sn}', target:'_self', open:{$open} {$font_style}}";
}
$json = implode(',', $data);

use XoopsModules\Tadtools\Ztree;

$ztree      = new Ztree("link_tree", $json, "save_drag.php", "save_sort.php", "of_cate_sn", "cate_sn");
$ztree_code = $ztree->render();
$xoopsTpl->assign('ztree_code', $ztree_code);

 */
