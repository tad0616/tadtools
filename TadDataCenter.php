<?php
class TadDataCenter extends \XoopsModules\Tadtools\TadDataCenter
{
}

/*

//單一表單
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$form=$TadDataCenter->getForm($mode, $form_tag, $name, $type, $value, $options, $attr, $sort);

//批次表單
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->assignBatchForm($form_tag, $data_arr = array(), $type = '')

//儲存資料：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveData();
或
$TadDataCenter->saveCustomData($data_arr = array());

//取得資料陣列：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$data=$TadDataCenter->getData($name,$sort=0);
$xoopsTpl->assign('TDC', $data);
<{$TDC.data_name.0}>

//刪除資料：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->delData($name,$sort);

//-------------------------------------------------------------------------

//後台自訂問卷界面
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$xoopsTpl->assign('CustomSetupForm', $TadDataCenter->getCustomSetupForm($action));
<{$CustomSetupForm}>

//顯示問卷
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$xoopsTpl->assign('CustomForm', $TadDataCenter->getCustomForm($use_form = true, $use_submit = false, $action = '', $lw = 3, $rw = 9));
<{$CustomForm}>

//後台自訂問卷設定儲存
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveCustomSetupForm();

//前台自訂問卷答案儲存
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveData();

//自訂表單填答列表（表格）
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$getCustomAns=$TadDataCenter->getCustomAns();

//自訂表單題目
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$CustomSetup      = $TadDataCenter->getCustomSetup();

//自訂表單填答陣列
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$getCustomAnsArr=$TadDataCenter->getCustomAnsArr();

資料表：
CREATE TABLE `模組名稱_data_center` (
`mid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '模組編號',
`col_name` varchar(100) NOT NULL DEFAULT '' COMMENT '欄位名稱',
`col_sn` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '欄位編號',
`data_name` varchar(100) NOT NULL DEFAULT '' COMMENT '資料名稱',
`data_value` text NOT NULL COMMENT '儲存值',
`data_sort` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`col_id` varchar(100) NOT NULL COMMENT '辨識字串',
`update_time` datetime NOT NULL COMMENT '更新時間',
PRIMARY KEY (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 */
