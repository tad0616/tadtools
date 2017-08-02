<?php
/*

//上傳表單（enctype='multipart/form-data'）
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn); //若 $show_list_del_file ==true 時一定要有
$upform=$TadUpFiles->upform($show_edit,$upname,$maxlength,$show_list_del_file,$only_type,$thumb);

//儲存：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//儲存單一檔案：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_one_file($_FILES['upfile']['name'],$_FILES['upfile']['tmp_name'],$_FILES['upfile']['type'],$_FILES['upfile']['size'],$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//複製匯入單一檔案：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->import_one_file($from="",$new_filename="",$main_width="1280",$thumb_width="120",$files_sn="" ,$desc="" ,$safe_name=false ,$hash=false);

//顯示可刪除列表
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->set_thumb($thumb_width="120px",$thumb_height="70px",$thumb_bg_color="#000");
$list_del_file=$TadUpFiles->list_del_file($show_edit=false,$mode);

//顯示：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
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
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
//$TadUpFiles->set_col($col_name,$col_sn,$sort); //若要整個刪除
$TadUpFiles->del_files($files_sn);

//單一檔案真實路徑：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_pic_file($showkind[,$kind='url',$files_sn]); //thumb 小圖, images 大圖（default）, file 檔案

//改檔名
$TadUpFiles->rename_file($files_sn,$new_name);

檔案數量：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn);
$TadUpFiles->get_file_amount();

//取得檔案資訊
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_file($files_sn="",$limit=NULL,$path,$hash);

//取得檔案資訊 for smarty
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_file_for_smarty($files_sn="",$limit=NULL,$path,$hash);

//onUpdate.php 須加入
if (chk_fc_tag()) {
go_fc_tag();
}

//新增檔案欄位
function chk_fc_tag()
{
global $xoopsDB;
$sql    = "select count(`tag`) from " . $xoopsDB->prefix("tad_web_files_center");
$result = $xoopsDB->query($sql);
if (empty($result)) {
return true;
}

return false;
}

function go_fc_tag()
{
global $xoopsDB;
$sql = "ALTER TABLE " . $xoopsDB->prefix("tad_web_files_center") . "
ADD `upload_date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '上傳時間',
ADD `uid` mediumint(8) unsigned NOT NULL default 0 COMMENT '上傳者',
ADD `tag` varchar(255) NOT NULL default '' COMMENT '註記'
";
$xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin", 30, $xoopsDB->error());
}

 */
require_once "TadUpFiles.php";

class TadUpFiles2 extends TadUpFiles
{

    //上傳圖檔，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_file($upname = 'upfile', $main_width = "1280", $thumb_width = "120", $files_sn = "", $desc = null, $safe_name = false, $hash = false, $return_col = "file_name")
    {
        global $xoopsDB, $xoopsUser;

        if (empty($main_width)) {
            $main_width = "1920";
        }

        if (empty($thumb_width)) {
            $thumb_width = "240";
        }

        //die(var_dump($_FILES[$upname]));
        //引入上傳物件
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/upload/class.upload.php";

        //取消上傳時間限制
        set_time_limit(0);
        //設置上傳大小
        ini_set('memory_limit', '180M');

        //儲存檔案描述
        if (!empty($_POST['save_description'])) {
            foreach ($_POST['save_description'] as $save_files_sn => $files_desc) {
                $this->update_col_val($save_files_sn, 'description', $files_desc);
            }
        }
        //die(var_export($_POST['del_file']));
        //刪除勾選檔案
        if (!empty($_POST['del_file'])) {
            foreach ($_POST['del_file'] as $del_files_sn) {
                $this->del_files($del_files_sn);
            }
        }

        $files = array();
        foreach ($_FILES[$upname] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files)) {
                    $files[$i] = array();
                }
                $files[$i][$k] = $v;
            }
        }

        // die(var_dump($files));
        $all_files_sn = '';
        foreach ($files as $file) {

            $tag = '';
            if (function_exists('exif_read_data')) {
                $exif       = exif_read_data($file['tmp_name'], 0, true);
                $creat_date = $exif['IFD0']['DateTime'];
                $Model360   = array('LG-R105', 'RICOH THETA S');
                if (in_array($exif['IFD0']['Model'], $Model360)) {
                    $tag         = '360';
                    $thumb_width = $thumb_width * 2;
                    $main_width  = 0;
                }
            }

            //先刪除舊檔
            if (!empty($files_sn)) {
                $this->del_files($files_sn);
            }

            //自動排序
            if (empty($this->sort)) {
                $this->sort = $this->auto_sort();
            }

            //取得檔案
            $file_handle = new upload($file, "zh_TW");

            if ($file_handle->uploaded) {
                //取得副檔名
                $file_ext = $file_handle->file_src_name_ext;
                $ext      = strtolower($file_ext);

                //判斷檔案種類
                if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
                    $kind = "img";
                } else {
                    $kind = "file";
                }

                $file_handle->file_safe_name    = false;
                $file_handle->file_overwrite    = true;
                $file_handle->no_script         = false;
                $file_handle->file_new_name_ext = $ext;

                $hash_name = md5(rand(0, 1000) . $file['name']);

                if ($hash) {
                    $new_filename = $hash_name;
                } else {
                    $new_filename = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
                }

                //die($new_filename);
                $os_charset = (PATH_SEPARATOR == ':') ? "UTF-8" : "Big5";

                if ($os_charset != _CHARSET) {
                    $new_filename = iconv(_CHARSET, $os_charset, $new_filename);
                }
                $file_handle->file_new_name_body = $new_filename;

                //若是圖片才縮圖
                if ($kind == "img" and !empty($main_width)) {
                    if ($file_handle->image_src_x > $main_width) {
                        $file_handle->image_resize  = true;
                        $file_handle->image_x       = $main_width;
                        $file_handle->image_ratio_y = true;
                    }
                }
                $path = ($kind == "img") ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;

                $readme = ($hash) ? "{$path}/{$hash_name}_info.txt" : "";

                //die($path);
                $file_handle->process($path);
                $file_handle->auto_create_dir = true;

                $upload_date = date("Y-m-d H:i:s");
                $uid         = isset($xoopsUser) ? $xoopsUser->uid : 0;

                //若是圖片才製作小縮圖
                if ($kind == "img") {

                    $file_handle->file_safe_name    = false;
                    $file_handle->file_overwrite    = true;
                    $file_handle->file_new_name_ext = $ext;

                    $file_handle->file_new_name_body = $new_filename;

                    if ($file_handle->image_src_x > $thumb_width) {
                        $file_handle->image_resize  = true;
                        $file_handle->image_x       = $thumb_width;
                        $file_handle->image_ratio_y = true;
                    }
                    $file_handle->process($this->TadUpFilesThumbDir);
                    $file_handle->auto_create_dir = true;

                }

                //上傳檔案
                if ($file_handle->processed) {
                    $file_handle->clean();

                    if ($hash) {
                        $fp = fopen($readme, 'w');
                        fwrite($fp, $file['name']);
                        fclose($fp);
                    }

                    $file_name   = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $file['name'];
                    $description = is_null($desc) ? $file['name'] : $desc;

                    chmod("{$path}/{$file_name}", 0755);
                    if ($kind == "img") {
                        chmod("{$this->TadUpFilesThumbDir}/{$file_name}", 0755);
                    }

                    $hash_name = ($hash) ? "{$hash_name}.{$ext}" : "";

                    if (empty($files_sn)) {

                        $sql = "replace into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}',0,'{$file['name']}','{$this->subdir}','{$hash_name}','{$upload_date}','{$uid}','{$tag}')";

                        $xoopsDB->queryF($sql) or web_error($sql);
                        //取得最後新增資料的流水編號
                        $insert_files_sn = $xoopsDB->getInsertId();
                    } else {
                        $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}','{$upload_date}','{$uid}','{$tag}')";

                        $xoopsDB->queryF($sql) or web_error($sql);
                    }

                    // if ($return_col == "files_sn") {
                    $all_files_sn[] = $insert_files_sn;
                    // }
                } else {
                    redirect_header($_SERVER['PHP_SELF'], 3, "Error:" . $file_handle->error);
                }
            }
            $this->sort = "";
        }

        // die(var_dump($all_files_sn));
        if ($return_col == "files_sn") {
            return $all_files_sn;
        } else {
            return $file_name;
        }
    }

    //複製、匯入單一檔案，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function import_one_file($from = "", $new_filename = "", $main_width = "1280", $thumb_width = "120", $files_sn = "", $desc = "", $safe_name = false, $hash = false)
    {
        global $xoopsDB, $xoopsUser;

        if (empty($main_width)) {
            $main_width = "1280";
        }

        if (empty($thumb_width)) {
            $thumb_width = "120";
        }

        //die($from);
        $filename = $this->get_basename($from);

        $type = $this->mime_content_type($filename);
        $size = filesize($from);

        //取消上傳時間限制
        set_time_limit(0);
        //設置上傳大小
        ini_set('memory_limit', '1024M');

        //先刪除舊檔
        if (!empty($files_sn)) {
            $this->del_files($files_sn);
        }

        //自動排序
        if (empty($this->sort)) {
            $this->sort = $this->auto_sort();
        }

        //取得副檔名
        $extarr = explode('.', $filename);
        foreach ($extarr as $val) {
            $ext = strtolower($val);
        }

        //判斷檔案種類
        if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
            $kind = "img";
        } else {
            $kind = "file";
        }

        $path         = ($kind == "img") ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;
        $new_filename = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $filename;

        $readme    = "";
        $hash_name = md5(rand(0, 1000) . $filename);
        if ($hash) {
            $hash_filename = $hash_name . '.' . $ext;
            $readme        = "{$path}/{$hash_name}_info.txt";
            $fp            = fopen($readme, 'w');
            fwrite($fp, $filename);
            fclose($fp);
        } else {
            $hash_filename = $new_filename;
        }

        $tag         = '';
        $upload_date = date("Y-m-d H:i:s");
        $uid         = isset($xoopsUser) ? $xoopsUser->uid : 0;

        //若是圖片才縮圖
        if ($kind == "img" and !empty($main_width)) {

            $filename  = auto_charset($filename);
            $new_thumb = $this->TadUpFilesThumbDir . "/" . $hash_filename;
            if (file_exists($path . "/" . $hash_filename)) {
                unlink($path . "/" . $hash_filename);
            }

            if (function_exists('exif_read_data')) {
                $exif       = exif_read_data($filename, 0, true);
                $creat_date = $exif['IFD0']['DateTime'];
                $Model360   = array('LG-R105', 'RICOH THETA S');
                if (in_array($exif['IFD0']['Model'], $Model360)) {
                    $tag = '360';
                }
            }

            if (copy($from, $path . "/" . $hash_filename)) {
                $description = (empty($files_sn) and empty($desc)) ? $filename : $desc;

                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql);
                }
                $this->sort = "";
                //echo "copy \"$from\" to  \"$path/$hash_filename\" OK!<br>";
            } else {
                //die("copy \"$from\" to  \"$path/$hash_filename\" fail!");
            }

            //複製檔案
            $this->thumbnail($from, $new_thumb, $type, $thumb_width);
        } else {
            if (copy($from, $path . "/" . $hash_filename)) {

                $filename    = auto_charset($filename);
                $description = (empty($files_sn) or empty($desc)) ? $filename : $desc;

                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql);
                }

                $this->sort = "";
            }
        }

        //die('new_thumb:'.$new_thumb);

        return $files_sn;
    }

    //上傳單一檔案，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_one_file($name = "", $tmp_name = "", $type = "", $size = "", $main_width = "1280", $thumb_width = "120", $files_sn = "", $desc = "", $safe_name = false, $hash = false)
    {
        global $xoopsDB, $xoopsUser;

        if (empty($main_width)) {
            $main_width = "1280";
        }

        if (empty($thumb_width)) {
            $thumb_width = "120";
        }

        //die(var_dump($_FILES[$upname]));
        //引入上傳物件
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/upload/class.upload.php";

        //取消上傳時間限制
        set_time_limit(0);
        //設置上傳大小
        ini_set('memory_limit', '80M');

        //先刪除舊檔
        if (!empty($files_sn)) {
            $this->del_files($files_sn);
        }

        //自動排序
        if (empty($this->sort)) {
            $this->sort = $this->auto_sort();
        }

        $file['name']     = $name;
        $file['tmp_name'] = $tmp_name;
        $file['type']     = $type;
        $file['size']     = $size;

        //取得檔案
        $file_handle = new upload($file, "zh_TW");

        if ($file_handle->uploaded) {
            //取得副檔名
            $ext = strtolower($file_handle->file_src_name_ext);
            //判斷檔案種類
            if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
                $kind = "img";
            } else {
                $kind = "file";
            }

            $hash_name = md5(rand(0, 1000) . $name);

            $file_handle->file_safe_name    = false;
            $file_handle->file_overwrite    = true;
            $file_handle->file_new_name_ext = $ext;
            if ($hash) {
                $file_handle->file_new_name_body = $hash_name;
            } else {
                $file_handle->file_new_name_body = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
            }
            //若是圖片才縮圖
            if ($kind == "img" and !empty($main_width)) {
                if ($file_handle->image_src_x > $main_width) {
                    $file_handle->image_resize  = true;
                    $file_handle->image_x       = $main_width;
                    $file_handle->image_ratio_y = true;
                }
            }
            $path = ($kind == "img") ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;

            $readme = ($hash) ? "{$path}/{$hash_name}_info.txt" : "";

            //die($path);
            $file_handle->process($path);
            $file_handle->auto_create_dir = true;

            $tag         = '';
            $upload_date = date("Y-m-d H:i:s");
            $uid         = isset($xoopsUser) ? $xoopsUser->uid : 0;

            //若是圖片才製作小縮圖
            if ($kind == "img") {
                $file_handle->file_safe_name    = false;
                $file_handle->file_overwrite    = true;
                $file_handle->file_new_name_ext = $ext;
                if ($hash) {
                    $file_handle->file_new_name_body = $hash_name;
                } else {
                    $file_handle->file_new_name_body = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
                }
                if ($file_handle->image_src_x > $thumb_width) {
                    $file_handle->image_resize  = true;
                    $file_handle->image_x       = $thumb_width;
                    $file_handle->image_ratio_y = true;
                }
                $file_handle->process($this->TadUpFilesThumbDir);
                $file_handle->auto_create_dir = true;

                if (function_exists('exif_read_data')) {
                    $exif       = exif_read_data($file['tmp_name'], 0, true);
                    $creat_date = $exif['IFD0']['DateTime'];
                    $Model360   = array('LG-R105', 'RICOH THETA S');
                    if (in_array($exif['IFD0']['Model'], $Model360)) {
                        $tag = '360';
                    }
                }
            }

            //上傳檔案
            if ($file_handle->processed) {
                $file_handle->clean();

                if ($hash) {
                    $fp = fopen($readme, 'w');
                    fwrite($fp, $name);
                    fclose($fp);
                }

                $file_name = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $name;

                chmod("{$path}/{$file_name}", 0755);
                if ($kind == "img") {
                    chmod("{$this->TadUpFilesThumbDir}/{$file_name}", 0755);
                }

                $description = (empty($files_sn) or empty($desc)) ? $file['name'] : $desc;

                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql);
                }
                //die($sql);
            } else {
                redirect_header($_SERVER['PHP_SELF'], 3, "Error:" . $file_handle->error);
            }
        }
        $this->sort = "";

        if (!is_null($desc)) {
            $this->update_col_val($files_sn, 'description', $desc);
        }

        return $files_sn;
    }

    //取得檔案
    public function get_file($files_sn = "", $limit = null, $path = null, $hash = false, $desc_as_name = false, $keyword = '', $only_keyword = false, $target = "_self")
    {
        global $xoopsDB, $xoopsUser;
        $files      = array();
        $os_charset = (PATH_SEPARATOR == ':') ? "UTF-8" : "Big5";

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : "";

        $andLimit = (!empty($limit)) ? "limit 0 , {$limit}" : "";

        $link_path = is_null($path) ? $_SERVER['PHP_SELF'] : $path;

        if (empty($files_sn) and !empty($this->files_sn)) {
            $files_sn = $this->files_sn;
        }
        if (is_array($files_sn)) {
            $where = "where `files_sn` in('" . implode("','", $files_sn) . "')";
        } else {

            $where = ($files_sn) ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort $andLimit";
        }

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";

        $result = $xoopsDB->queryF($sql) or web_error($sql);
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            if ($os_charset != _CHARSET) {
                $file_name = iconv($os_charset, _CHARSET, $file_name);
            }

            $show_file_name = ($desc_as_name and !empty($description)) ? $description : $original_filename;
            if (!empty($keyword)) {
                if (strrpos($show_file_name, $keyword) !== false) {
                    $show_file_name = str_replace($keyword, "<span class='keyword'>{$keyword}</span>", $show_file_name);
                } elseif ($only_keyword) {
                    continue;
                }
            }
            $files[$files_sn]['show_file_name'] = $show_file_name;

            $files[$files_sn]['kind']              = $kind;
            $files[$files_sn]['sort']              = $sort;
            $files[$files_sn]['file_name']         = $file_name;
            $files[$files_sn]['file_type']         = $file_type;
            $files[$files_sn]['file_size']         = $file_size;
            $files[$files_sn]['counter']           = $counter;
            $files[$files_sn]['description']       = $description;
            $files[$files_sn]['original_filename'] = $original_filename;
            $files[$files_sn]['hash_filename']     = $hash_filename;
            $files[$files_sn]['upload_date']       = $upload_date;
            $files[$files_sn]['uid']               = $uid;
            $files[$files_sn]['tag']               = $tag;

            $dl_url = empty($this->download_url) ? "{$link_path}?op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";

            if ($kind == "img") {

                $file_name = ($hash) ? $hash_filename : $file_name;
                $pic_name  = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                if (strpos($tag, '360') !== false) {
                    $fancyboxset = "fancybox_{$this->col_name} $tag";
                    $rel         = "data-fancybox-type='iframe'";
                } else {
                    $fancyboxset = "fancybox_{$this->col_name} $tag";
                    $rel         = "rel='f{$this->col_name}'";
                }

                $files[$files_sn]['link'] = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'><img src='{$pic_name}' alt='{$description}' title='{$description}'></a>";
                $files[$files_sn]['path'] = $pic_name;
                $files[$files_sn]['url']  = "<a href='{$pic_name}' title='{$description}' {$rel} class='{$fancyboxset}'>{$show_file_name}</a>";

                $files[$files_sn]['tb_link'] = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$files_sn]['tb_path'] = $thumb_pic;
                $files[$files_sn]['tb_url']  = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'>{$description}</a>";
            } else {
                $files[$files_sn]['link']               = "<a href='{$dl_url}#{$original_filename}' target='{$target}'>{$show_file_name}</a>";
                $files[$files_sn]['path']               = "{$dl_url}#{$original_filename}";
                $files[$files_sn]['original_file_path'] = $this->TadUpFilesUrl . "/{$file_name}";
                $files[$files_sn]['physical_file_path'] = $this->TadUpFilesDir . "/{$file_name}";
            }
        }

        return $files;
    }

    //取得附檔或附圖 $show_mode=filename , small,playSpeed=3000 or 0
    public function show_files($upname = "", $thumb = true, $show_mode = "", $show_description = false, $show_dl = false, $limit = null, $path = null, $hash = false, $playSpeed = 5000, $desc_as_name = false, $keyword = '', $only_keyword = false, $target = '_self')
    {

        if ($show_mode == "small") {
            $all_files = "<link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/iconize.css' />";
        } elseif ($show_mode == "filename") {
            $all_files = "<link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/rounded-list.css' />";
        } else {
            $all_files = "";
        }

        $autoPlay  = empty($playSpeed) ? false : true;
        $playSpeed = empty($playSpeed) ? 0 : $playSpeed;

        if ($this->showFancyBox) {
            if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php")) {
                redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
            }
            include_once XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php";
            $fancybox = new fancybox(".fancybox_{$this->col_name}", '80%', '80%');
            $all_files .= $fancybox->render(false, null, 0, $playSpeed);
        }

        $file_arr = "";
        $file_arr = $this->get_file(null, $limit, $path, $hash, $desc_as_name, $keyword, $only_keyword, $target);

        if (empty($file_arr)) {
            return;
        }

        if ($file_arr) {
            $i = 1;
            if ($show_mode != "filename" and $show_mode != "small") {
                $all_files .= "<ul>";
            } elseif ($show_mode == "filename") {
                $all_files .= "<ol class='rectangle-list' style=\"counter-reset: li; list-style: none; *list-style: decimal; font: 15px 'trebuchet MS', 'lucida sans'; padding: 0; text-shadow: 0 1px 0 rgba(255,255,255,.5);\">";
            }
            foreach ($file_arr as $files_sn => $file_info) {

                if ($show_mode == "filename") {
                    if ($file_info['kind'] == "file") {
                        $all_files .= "<li>{$file_info['link']}</li>";
                    } else {
                        $all_files .= "<li>{$file_info['url']}</li>";
                    }
                } else {
                    $linkto      = $file_info['path'];
                    $description = empty($file_info['description']) ? $file_info['original_filename'] : $file_info['description'];
                    if ($file_info['kind'] == "file") {
                        $fext = pathinfo($file_info['path'], PATHINFO_EXTENSION);
                        //$fext=strtolower(substr($file_info['path'], -3));
                        if ($fext == "mp4" or $fext == "flv" or $fext == "3gp" or $fext == "mp3") {
                            $thumb_pic = TADTOOLS_URL . "/images/video.png";
                            if ($this->showFancyBox) {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel         = "data-fancybox-type='iframe'";
                            } else {
                                $fancyboxset = $rel = "";
                            }
                            $linkto = TADTOOLS_URL . "/video.php?file_name={$file_info['original_file_path']}";
                        } elseif ($fext == "jpg" or $fext == "gif" or $fext == "png" or $fext == "jpeg") {
                            if (strpos($file_info['tag'], '360') !== false) {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel         = "data-fancybox-type='iframe'";
                                $linkto      = TADTOOLS_URL . "/360.php?photo={$file_info['path']}";
                            } else {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel         = "rel='f{$this->col_name}'";
                            }
                        } else {
                            $thumb_pic   = TADTOOLS_URL . "/multiple-file-upload/downloads.png";
                            $fancyboxset = $rel = "";
                        }
                    } else {
                        $thumb_pic = ($thumb) ? $file_info['tb_path'] : $file_info['path'];
                        if ($this->showFancyBox) {
                            if (strpos($file_info['tag'], '360') !== false) {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel         = "data-fancybox-type='iframe'";
                                $linkto      = TADTOOLS_URL . "/360.php?photo={$file_info['path']}";
                            } else {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel         = "rel='f{$this->col_name}'";
                            }
                        } else {
                            $fancyboxset = $rel = "";
                        }
                        //將附檔強制轉小寫
                        $thumb_pic_ext = strtolower(substr($thumb_pic, -3));
                        $thumb_pic     = substr($thumb_pic, 0, -3) . $thumb_pic_ext;
                        $linkto_ext    = strtolower(substr($linkto, -3));
                        $linkto        = substr($linkto, 0, -3) . $linkto_ext;
                    }

                    //下載次數顯示
                    $show_dl_txt = ($show_dl) ? "<span class='label label-info'>{$file_info['counter']}</span>" : "";

                    //描述顯示
                    $show_description_txt = ($show_description) ? "<div style='font-weight: normal; font-size: 11px; word-break: break-all; line-height: 1.2; margin: 4px auto 4px 0px; text-align: left;'>{$i}) {$description} {$show_dl_txt}</div>" : "{$show_dl_txt}";

                    $all_files .= ($show_mode == "small") ? "<a href='{$linkto}' class='iconize {$fancyboxset}' {$rel}  title='{$description}'></a> " : "
                      <li style='width:120px;height:120px;float:left;list-style:none;'>
                        <a href='{$linkto}' class='thumbnail {$fancyboxset}' {$rel} style=\"width: 110px; height: 70px; overflow: hidden; background-color: #000000;  background-image: url('{$thumb_pic}'); background-repeat: no-repeat; background-position: center center; background-size: contain; margin-bottom: 4px;\" title='{$description}'></a>{$show_description_txt}
                      </li>";
                }

                $i++;
            }
            if ($show_mode != "filename" and $show_mode != "small") {
                $all_files .= "</ul>";
            } elseif ($show_mode == "filename") {
                $all_files .= "</ol>";
            }

        } else {
            $all_files = "";
        }

        $all_files .= "<div style='clear:both;'></div>";

        return $all_files;
    }

}
