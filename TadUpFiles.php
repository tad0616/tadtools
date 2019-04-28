<?php
class TadUpFiles extends \XoopsModules\Tadtools\TadUpFiles
{
}

// declare (strict_types = 1);

use XoopsModules\Tadtools\Utility;
/*
$TadUpFiles->set_var("permission", true); //要使用權限控管時才需要

//加入上傳檔案MIME types篩選
//新增ext2mime函數，可將副檔名轉換為MIME types，提供給$file_handle->allowed使用
//$allow = "doc;docx;pdf"，利用分號;區分允許上傳的檔案類型
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false,$return_col,$allow);

//上傳表單（enctype='multipart/form-data'）
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn); //若 $show_list_del_file ==true 時一定要有
$upform=$TadUpFiles->upform($show_edit,$upname,$maxlength,$show_list_del_file,$only_type,$thumb);

//儲存：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//儲存單一檔案：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_one_file($_FILES['upfile']['name'],$_FILES['upfile']['tmp_name'],$_FILES['upfile']['type'],$_FILES['upfile']['size'],$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//複製匯入單一檔案：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->import_one_file($from="",$new_filename="",$main_width="1280",$thumb_width="120",$files_sn="" ,$desc="" ,$safe_name=false ,$hash=false);

//顯示可刪除列表
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->set_thumb($thumb_width="120px",$thumb_height="70px",$thumb_bg_color="#000");
$list_del_file=$TadUpFiles->list_del_file($show_edit=false,$mode);

//顯示：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$show_files=$TadUpFiles->show_files($upname,true,NULL,false,false,NULL,NULL,false);
//上傳表單name, 是否縮圖, 顯示模式 (filename、small), 顯示描述, 顯示下載次數, 數量限制, 自訂路徑, 加密, 自動播放時間(0 or 3000)
//show_files($upname="",$thumb=true,$show_mode="",$show_description=false,$show_dl=false,$limit=NULL,$path=NULL,$hash=false,$playSpeed=5000)

//下載檔案
case "tufdl":
$files_sn=isset($_GET['files_sn'])?intval($_GET['files_sn']):"";
$TadUpFiles->add_file_counter($files_sn,$hash=false,$force=false);
exit;
break;

//刪除：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
//$TadUpFiles->set_col($col_name,$col_sn,$sort); //若要整個刪除
$TadUpFiles->del_files($files_sn);

//單一檔案圖檔真實路徑：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_pic_file($showkind[,$kind='url',$files_sn]); //thumb 小圖, images 大圖（default）, file 檔案

//改檔名
$TadUpFiles->rename_file($files_sn,$new_name);

檔案數量：
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn);
$TadUpFiles->get_file_amount();

//取得檔案資訊
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_file($files_sn="",$limit=NULL,$path,$hash);

//取得檔案資訊 for smarty
require_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_file_for_smarty($files_sn="",$limit=NULL,$path,$hash);

'files_sn' => '116',
'kind' => 'img',
'sort' => '1',
'file_name' => '158.gif',
'file_type' => 'image/gif',
'file_size' => '145',
'counter' => '0',
'description' => '158.gif',
'original_filename' => '158.gif',
'link' => '<a href="/x25/modules/tad_themes/admin/main.php?op=tufdl&files_sn=116" title="158.gif" rel="lytebox"><img src="http://localhost/x25/uploads/tad_themes/school2013/bg/158.gif" alt="158.gif" title="158.gif" rel="lytebox"></a>',
'path' => 'http://localhost/x25/uploads/tad_themes/school2013/bg/158.gif',
'url' => '<a href="/x25/modules/tad_themes/admin/main.php?op=tufdl&files_sn=116" title="158.gif" target="_blank">158.gif</a>',
'tb_link' => '<a href="/x25/modules/tad_themes/admin/main.php?op=tufdl&files_sn=116" title="158.gif" rel="lytebox"><img src="http://localhost/x25/uploads/tad_themes/school2013/bg/thumbs/158.gif" alt="158.gif" title="158.gif"></a>',
'tb_path' => 'http://localhost/x25/uploads/tad_themes/school2013/bg/thumbs/158.gif',
'tb_url' => '<a href="/x25/modules/tad_themes/admin/main.php?op=tufdl&files_sn=116" title="158.gif" rel="lytebox">158.gif</a>',
'original_file_path' => 'http://localhost/x25/uploads/tadnews/file/nsn_20_5.mp4'

種類：img,file
資料表：
CREATE TABLE `模組名稱_files_center` (
`files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
`col_name` varchar(255) NOT NULL default '' COMMENT '欄位名稱',
`col_sn` smallint(5) unsigned NOT NULL default 0 COMMENT '欄位編號',
`sort` smallint(5) unsigned NOT NULL default 0 COMMENT '排序',
`kind` enum('img','file') NOT NULL default 'img' COMMENT '檔案種類',
`file_name` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
`file_type` varchar(255) NOT NULL default '' COMMENT '檔案類型',
`file_size` int(10) unsigned NOT NULL default 0 COMMENT '檔案大小',
`description` text NOT NULL COMMENT '檔案說明',
`counter` mediumint(8) unsigned NOT NULL default 0 COMMENT '下載人次',
`original_filename` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
`hash_filename` varchar(255) NOT NULL default '' COMMENT '加密檔案名稱',
`sub_dir` varchar(255) NOT NULL default '' COMMENT '檔案子路徑',
PRIMARY KEY (`files_sn`)
) ENGINE=MyISAM;
 */
