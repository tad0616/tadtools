<?php
/*
$TadUpFiles->set_var("permission", true); //要使用權限控管時才需要

//加入上傳檔案MIME types篩選
//新增ext2mime函數，可將副檔名轉換為MIME types，提供給$file_handle->allowed使用
//$allow = "doc;docx;pdf"，利用分號;區分允許上傳的檔案類型
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false,$return_col,$allow);

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

//單一檔案圖檔真實路徑：
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

class TadUpFiles
{
    public $TadUpFilesTblName;
    public $TadUpFilesDir;
    public $TadUpFilesUrl;
    public $TadUpFilesImgDir;
    public $TadUpFilesImgUrl;
    public $TadUpFilesThumbDir;
    public $TadUpFilesThumbUrl;
    public $col_name;
    public $col_sn;
    public $sort;
    public $subdir;
    public $prefix;
    public $hash;
    public $filename;
    public $file_dir   = "/file";
    public $image_dir  = "/image";
    public $thumbs_dir = "/image/.thumbs";
    public $permission = false;

    public $thumb_width    = '120px';
    public $thumb_height   = '70px';
    public $thumb_bg_color = 'transparent';
    public $thumb_position = 'center center';
    public $thumb_repeat   = 'no-repeat';
    public $thumb_size     = 'contain';
    public $showFancyBox   = true;
    public $download_url   = "";
    public $files_sn;
    public $filename_size = '15px';

    public $show_tip = true;

    public $auto_charset;
    public $mime_type_check;

    public function __construct($prefix = "", $subdir = "", $file = "/file", $image = "/image", $thumbs = "/image/.thumbs")
    {
        global $xoopsDB, $xoopsModule;
        if (!empty($prefix)) {
            $this->set_prefix($prefix);
        }

        if (!empty($subdir)) {
            $this->set_dir('subdir', $subdir);
        }

        $this->set_dir('file', $file);
        $this->set_dir('image', $image);
        $this->set_dir('thumbs', $thumbs);

        $this->TadUpFilesTblName = $xoopsDB->prefix("{$this->prefix}_files_center");

        $modhandler            = xoops_getHandler('module');
//        $xoopsModule           = $modhandler->getByDirname("tadtools");
        $config_handler        = xoops_getHandler('config');
        $xoopsModuleConfig     = $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
        $this->auto_charset    = $xoopsModuleConfig['auto_charset'];
        $this->mime_type_check = $xoopsModuleConfig['mime_type_check'];

    }

    //設定路徑
    public function set_path()
    {
        $this->TadUpFilesDir      = XOOPS_ROOT_PATH . "/uploads/{$this->prefix}{$this->subdir}{$this->file_dir}";
        $this->TadUpFilesUrl      = XOOPS_URL . "/uploads/{$this->prefix}{$this->subdir}{$this->file_dir}";
        $this->TadUpFilesImgDir   = XOOPS_ROOT_PATH . "/uploads/{$this->prefix}{$this->subdir}{$this->image_dir}";
        $this->TadUpFilesImgUrl   = XOOPS_URL . "/uploads/{$this->prefix}{$this->subdir}{$this->image_dir}";
        $this->TadUpFilesThumbDir = XOOPS_ROOT_PATH . "/uploads/{$this->prefix}{$this->subdir}{$this->thumbs_dir}";
        $this->TadUpFilesThumbUrl = XOOPS_URL . "/uploads/{$this->prefix}{$this->subdir}{$this->thumbs_dir}";
    }

    //取得路徑
    public function get_path($type = "", $kind = "")
    {
        if ($type == "file") {
            if ($kind == "dir") {
                $path = $this->TadUpFilesDir;
            } elseif ($kind == "url") {
                $path = $this->TadUpFilesUrl;
            } else {
                $path['dir'] = $this->TadUpFilesDir;
                $path['url'] = $this->TadUpFilesUrl;
            }
        } elseif ($type == "image") {
            if ($kind == "dir") {
                $path = $this->TadUpFilesImgDir;
            } elseif ($kind == "url") {
                $path = $this->TadUpFilesImgUrl;
            } else {
                $path['dir'] = $this->TadUpFilesImgDir;
                $path['url'] = $this->TadUpFilesImgUrl;
            }
        } elseif ($type == "thumb") {
            if ($kind == "dir") {
                $path = $this->TadUpFilesThumbDir;
            } elseif ($kind == "url") {
                $path = $this->TadUpFilesThumbUrl;
            } else {
                $path['dir'] = $this->TadUpFilesThumbDir;
                $path['url'] = $this->TadUpFilesThumbUrl;
            }
        } else {
            $path['file']['dir']  = $this->TadUpFilesDir;
            $path['file']['url']  = $this->TadUpFilesUrl;
            $path['image']['dir'] = $this->TadUpFilesImgDir;
            $path['image']['url'] = $this->TadUpFilesImgUrl;
            $path['thumb']['dir'] = $this->TadUpFilesThumbDir;
            $path['thumb']['url'] = $this->TadUpFilesThumbUrl;
        }

        return $path;
    }

    //設定縮圖背景
    public function set_thumb($width = "", $height = "", $bg_color = "", $position = "", $repeat = "", $size = "")
    {
        if (!empty($width)) {
            $this->thumb_width = $width;
        }

        if (!empty($height)) {
            $this->thumb_height = $height;
        }

        if (!empty($bg_color)) {
            $this->thumb_bg_color = $bg_color;
        }

        if (!empty($position)) {
            $this->thumb_position = $position;
        }

        if (!empty($repeat)) {
            $this->thumb_repeat = $repeat;
        }

        if (!empty($size)) {
            $this->thumb_size = $size;
        }

    }

    public function set_prefix($prefix = "")
    {
        $this->prefix = $prefix;
        $this->set_path();
    }

    public function set_filename($filename = "")
    {
        $this->filename = $filename;
    }

    //設定目錄
    public function set_dir($type, $dir = "")
    {
        if ($type == "subdir") {
            $this->subdir = $dir;
        } elseif ($type == "file") {
            $this->file_dir = $dir;
        } elseif ($type == "image") {
            $this->image_dir = $dir;
        } elseif ($type == "thumbs") {
            $this->thumbs_dir = $dir;
        }
        $this->set_path();
    }

    public function set_var($name = "", $val = "")
    {
        $this->$name = $val;
    }

    public function set_col($col_name = "", $col_sn = "", $sort = "")
    {
        $this->col_name = $col_name;
        $this->col_sn   = $col_sn;
        $this->sort     = $sort;
    }

    public function set_files_sn($files_sn = "")
    {
        $this->files_sn = $files_sn;
    }

    //是否套用fancybox
    public function set_fancybox($show = true)
    {
        $this->showFancyBox = $show;
    }

    //自己設定檔案下載路徑
    public function set_download_url($url = "")
    {
        $this->download_url = $url;
    }

    //是否加密
    public function set_hash($hash = false)
    {
        $this->hash = $hash;
    }

    //上傳元件
    public function upform($show_edit = false, $upname = 'upfile', $maxlength = "", $show_list_del_file = true, $only_type = "", $thumb = true, $id = '')
    {
        global $xoopsDB;
        $maxlength_code = empty($maxlength) ? "" : "maxlength='{$maxlength}'";
        $accept         = ($only_type) ? "accept='{$only_type}'" : "";
        $list_del_file  = ($show_list_del_file) ? $this->list_del_file($show_edit, $thumb) : "";
        $jquery         = get_jquery(true);
        $id             = empty($id) ? $upname : $id;

        $multiple = ($maxlength == 1) ? '' : "$maxlength_code multiple='multiple'";

        $permission = "";
        if ($this->permission) {

            $groups = $this->get_groups();

            $permission = _TUF_PERMISSION_NOTE;
            foreach ($groups as $groupid => $name) {
                $permission .= "<label><input type='checkbox' name='dl_group[new][]' value='{$groupid}'>{$name}</label> \n";
            }
        }

        $main = "
            $jquery
            <input type='file' name='{$upname}[]' id='{$id}' $multiple $accept class='form-control' style='height: initial;'>
            $permission
            {$list_del_file}
            ";

        return $main;
    }

    private function get_groups()
    {
        global $xoopsDB;
        $sql    = "select groupid,name from `" . $xoopsDB->prefix("groups") . "` where group_type!='Anonymous' order by groupid";
        $result = $xoopsDB->query($sql) or web_error($sql);

        $permission = _TUF_PERMISSION_NOTE;
        $groups     = array();
        while (list($groupid, $name) = $xoopsDB->fetchRow($result)) {
            $groups[$groupid] = $name;
        }
        return $groups;
    }

    //列出可刪除檔案，$show_edit=true(full),false(thumb),'list','none'
    public function list_del_file($show_edit = false, $thumb = true, $files_sn_arr = array(), $show_filename = true, $show_tip = null)
    {
        global $xoopsDB, $xoopsUser;

        if (!is_null($show_tip)) {
            $this->show_tip = $show_tip;
        }

        // 權限設定
        if ($this->permission) {
            $groups = $this->get_groups();
        }

        $all_file = "";
        if (!empty($files_sn_arr)) {
            $all_files_sn = implode("','", $files_sn_arr);
            $sql          = "select * from `{$this->TadUpFilesTblName}`  where `files_sn` in('$all_files_sn') order by sort";

        } else {
            $sql = "select * from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' order by sort";
        }
        // die($sql);
        $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        $i      = 0;
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            // $fileidname = str_replace('.', '', $file_name);
            $file_name = $this->hash ? $hash_filename : $file_name;
            if ($thumb) {
                if ($kind == "file") {
                    $fext = pathinfo($file_name, PATHINFO_EXTENSION);
                    // die(TADTOOLS_PATH . "/images/mimetype/{$fext}.png");
                    if (file_exists(TADTOOLS_PATH . "/images/mimetype/{$fext}.png")) {
                        $thumb_pic = TADTOOLS_URL . "/images/mimetype/{$fext}.png";
                    } else {
                        $thumb_pic = TADTOOLS_URL . "/multiple-file-upload/downloads.png";
                    }
                    $thumb_tool = "
                    <div class='row'>
                        <div class='col-sm-3 text-left'>
                        </div>
                        <div class='col-sm-6 text-center'>
                            <a href=\"javascript:remove_file('{$files_sn}');\" style='font-size: 12px;' class='text-danger'>
                                <i class=\"fa fa-trash\"></i> " . _TAD_DEL . "
                            </a></div>
                        <div class='col-sm-3 text-right'>
                        </div>
                    </div>";

                    //有編輯框
                    $thumb_style = "<div style='text-align: center;'><img src='{$thumb_pic}' alt='{$file_name}'></div>";
                    //無編輯框
                    $thumb_style2 = "<a class='thumbnail' style='display:inline-block; width:{$this->thumb_width};height:{$this->thumb_height};overflow:hidden;background-color: transparent; background-image:url({$thumb_pic});background-position:{$this->thumb_position};background-repeat:{$this->thumb_repeat};background-size:{$this->thumb_size}; margin-bottom: 4px;' title='{$description}'></a>";
                } else {
                    $thumb_pic = "{$this->TadUpFilesThumbUrl}/{$file_name}";

                    $thumb_tool = "
                    <table class='table'>
                        <tr>
                        <td class='text-right'>
                            <a href=\"javascript:rotate('left','{$files_sn}','{$this->prefix}{$this->subdir}','{$this->image_dir}','{$this->thumbs_dir}','{$file_name}','{$file_type}')\" id='left90'><i class=\"fa fa-undo text-success\" title='" . TADTOOLS_ROTATE_LEFT . "'></i></a>
                        </td>
                        <td class='text-center'>
                            <a href=\"javascript:remove_file('{$files_sn}');\" style='font-size: 12px;' class='text-danger'>
                                <i class=\"fa fa-times text-danger\" title=\"" . _TAD_DEL . "\"></i>
                            </a>
                        </td>
                        <td class='text-left'>
                            <a href=\"javascript:rotate('right','{$files_sn}','{$this->prefix}{$this->subdir}','{$this->image_dir}','{$this->thumbs_dir}','{$file_name}','{$file_type}')\" id='right90'><i class=\"fa fa-repeat text-info\" title='" . TADTOOLS_ROTATE_RIGHT . "'></i></a>
                        </td>
                        </tr>
                    </table>";

                    $thumb_style = "<a name='{$files_sn}' id='thumb{$files_sn}' href='{$this->TadUpFilesImgUrl}/{$file_name}' style='display: block; width: 120px; height: 80px; overflow: hidden; background-color: {$this->thumb_bg_color}; background-image: url({$thumb_pic}),url(" . TADTOOLS_URL . "/images/transparent.png); background-position: center center; background-repeat: no-repeat; background-size: contain; border: 1px solid gray; margin: 0px auto;' title='{$description}' class='fancybox_demo' rel='demo'></a>";

                    $thumb_style2 = "<a class='thumbnail' style='display:inline-block; width:{$this->thumb_width};height:{$this->thumb_height};overflow:hidden;background-color:{$this->thumb_bg_color};background-image:url({$thumb_pic});background-position:{$this->thumb_position};background-repeat:{$this->thumb_repeat};background-size:{$this->thumb_size}; margin-bottom: 4px;' title='{$description}'></a>";
                }
                $img_class = "img-thumbnail";
                // $img_class = ($this->bootstrap == '3') ? "img-thumbnail" : "img-polaroid";

                $w  = "width:130px; word-break: break-word;";
                $w2 = "width:{$this->thumb_width}; float:left; margin-right:10px;";
            } else {
                $thumb_tool = "<a href=\"javascript:remove_file('{$files_sn}');\" style='font-size: 12px;' class='text-danger'>
                                <i class=\"fa fa-trash\"></i> " . _TAD_DEL . "</a></div>";
                $thumb_style  = "";
                $thumb_style2 = "";
                $thumb_pic    = "";
                $w            = "";
                $w2           = "list-style-position: outside;";
            }
            $filename_label = "";
            if ($show_edit === true or $show_edit == "full") {
                // 權限設定
                if ($this->permission) {
                    $sql               = "select gperm_groupid from `" . $xoopsDB->prefix("group_permission") . "` where gperm_name='dl_group' and gperm_itemid='{$files_sn}' order by gperm_groupid";
                    $result            = $xoopsDB->query($sql) or web_error($sql);
                    $gperm_groupid_arr = array();
                    while (list($gperm_groupid) = $xoopsDB->fetchRow($result)) {
                        $gperm_groupid_arr[] = $gperm_groupid;
                    }
                    $permission = _TUF_PERMISSION_NOTE;
                    foreach ($groups as $groupid => $name) {
                        $checked = in_array($groupid, $gperm_groupid_arr) ? 'checked' : '';
                        $permission .= "<label><input type='checkbox' name='dl_group[$files_sn][]' value='{$groupid}' {$checked}>{$name}</label> \n";
                    }
                }

                if ($show_filename) {
                    $filename_label = "
                    <label class='checkbox' style='margin:5px 0px;'>
                    {$original_filename}
                    </label>
                   ";
                }
                $all_file .= "
                <tr id='fdtr_{$files_sn}'>
                    <td style='{$w}'>
                            {$thumb_style}
                            {$thumb_tool}
                    </td>
                    <td>
                    {$filename_label}
                    <textarea name='save_description[$files_sn]' rows=1 size=2 class='form-control'>{$description}</textarea>
                    $permission
                    </td>
                </tr>";
            } elseif ($show_edit == "list") {
                //無編輯框，無圖示
                $file_url = ($kind == "file") ? "{$this->TadUpFilesUrl}/{$file_name}" : "{$this->TadUpFilesImgUrl}/{$file_name}";
                $all_file .= "
                <li id='fdtr_{$files_sn}'>
                    <a name='{$files_sn}' target='_blank'>
                        <input type='checkbox' name='del_file[]' value='{$files_sn}' onClick=\"remove_file('{$files_sn}');\">
                        {$original_filename}
                    </a>
                </li>
                ";
            } else {
                //無編輯框，有圖示水平排列

                if ($show_filename) {
                    $filename_label = "
                    <label class='checkbox-inline' style='width:{$this->thumb_width}; height: 100px;font-size: 12px;word-wrap: break-word;'>
                    <!--input type='checkbox' name='del_file[]' value='{$files_sn}'-->
                    {$original_filename}
                    </label>
                    ";
                }
                $all_file .= "
                <li style='list-style-type:none;{$w2}' id='fdtr_{$files_sn}'>
                    {$thumb_style2}
                    {$thumb_tool}
                    {$filename_label}
                </li>
                ";

            }
            $i++;
        }

        if (empty($all_file)) {
            return;
        }

        include_once XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php";
        $fancybox      = new fancybox(".fancybox_demo", 640, 480);
        $fancybox_code = $fancybox->render(false, null, false);

        $files = "
        $fancybox_code
        <link href=\"" . XOOPS_URL . "/modules/tadtools/css/font-awesome/css/font-awesome.css\" rel=\"stylesheet\">
        <script type='text/javascript'>
            $(document).ready(function(){
                $('#list_del_file_sort_{$this->col_name}').sortable({ opacity: 0.6, cursor: 'move', update: function() {
                    var order = $(this).sortable('serialize');
                    $.post('" . XOOPS_URL . "/modules/tadtools/save_sort.php',order+'&col_name={$this->col_name}&col_sn={$this->col_sn}&tbl_name=" . $this->TadUpFilesTblName . "', function(theResponse){
                        $('#df_save_msg').html(theResponse);
                    });
                    }
                });
            });

            function rotate(op,files_sn,subdir,image_dir,thumbs_dir,filename,type){
                $.post('" . XOOPS_URL . "/modules/tadtools/imagerotate.php', {op: op, files_sn:files_sn , subdir: subdir , image_dir: image_dir , thumbs_dir: thumbs_dir , filename:filename ,type:type}, function(data){
                $('#thumb' + files_sn).css('background-image', 'url(\''+data+'?timestamp=' + new Date().getTime()+'\')' ).css('border', '1px solid red' );
                });
            }

            function remove_file(files_sn){
                var sure = window.confirm('" . _TAD_DEL_CONFIRM . "');
                if (!sure){
                    return;
                } else{
                    $.post('" . XOOPS_URL . "/modules/tadtools/ajax_file.php', {op: 'remove_file', mod_name: '{$this->prefix}', files_sn: files_sn}, function(data){
                        if(data=='1'){
                            $('#fdtr_' + files_sn).html('<li>已刪除</li>');
                            $('#fdtr_' + files_sn).remove();
                        }else{
                            $('#fdtr_' + files_sn).html('<li>刪敗刪除：'+data+'</li>');
                        }
                    });
                }

            }
        </script>";

        $del_alert = ($show_edit == "list") ? TADTOOLS_CHECKBOX_TO_DEL : "";
        $sort_able = ($this->show_tip and $i > 1) ? "<div class='alert alert-info' id='df_save_msg'>{$del_alert}" . _TAD_SORTABLE . "</div>" : "";

        if ($show_edit === true or $show_edit == "full") {
            $files .= "
            {$sort_able}
                <table class='table table-striped table-hover' style='width:100%; margin-top:10px;'>
                    <tbody id='list_del_file_sort_{$this->col_name}' >
                        $all_file
                    </tbody>
                </table>
              ";
        } elseif ($show_edit == "list") {
            $files .= "
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/rounded-list.css' />
            <div style='height:30px;'></div>
            <div class='row' style='margin-top:10px;'>
                <div class='col-sm-12'>
                <ol class='rectangle-list' style=\"counter-reset: li; list-style: none; *list-style: decimal; font: " . $this->filename_size . " 'trebuchet MS', 'lucida sans'; padding: 0; text-shadow: 0 1px 0 rgba(255,255,255,.5);\" id='list_del_file_sort_{$this->col_name}'>
                    {$all_file}
                </ol>
                </div>
            </div>
            {$sort_able}";
        } else {
            $files .= "
                <div style='height:30px;'></div>
                <div class='row' style='margin-top:10px;'>
                    <div class='col-sm-12'>
                        <ul class='thumbnails' id='list_del_file_sort_{$this->col_name}'>
                            {$all_file}
                        </ul>
                    </div>
                </div>
                {$sort_able}
                ";
        }

        return $files;
    }

    //上傳圖檔，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_file($upname = 'upfile', $main_width = "1920", $thumb_width = "240", $files_sn = "", $desc = null, $safe_name = false, $hash = false, $return_col = "file_name", $allow = "")
    {
        global $xoopsDB, $xoopsUser;
        if ($hash) {
            $this->set_hash($hash);
        }

        if (empty($main_width)) {
            $main_width = "1920";
        }

        if (empty($thumb_width)) {
            $thumb_width = "240";
        }
        //新增限制檔案類型
        if (!empty($allow)) {
            $allow     = explode(';', $allow);
            $allow_arr = array();
            foreach ($allow as $key => $value) {
                $mime_arr = $this->ext2mime($value);
                foreach ($mime_arr as $k => $v) {
                    $allow_arr[] = $v;
                }
            }
        }
        //die(var_dump($_FILES[$upname]));
        //引入上傳物件
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/upload/class.upload.php";

        //取消上傳時間限制
        set_time_limit(0);
        //設置上傳大小
        ini_set('memory_limit', '180M');

        // 更新權限
        if ($this->permission) {
            $modhandler  = xoops_gethandler('module');
            $xoopsModule = $modhandler->getByDirname($this->prefix);
            $mod_id      = $xoopsModule->mid();
        }

        //儲存檔案描述
        if (!empty($_POST['save_description'])) {
            foreach ($_POST['save_description'] as $save_files_sn => $files_desc) {
                $this->update_col_val($save_files_sn, 'description', $files_desc);
                // 順便更新權限
                if ($this->permission) {
                    $sql = "delete from `" . $xoopsDB->prefix("group_permission") . "` where `gperm_itemid`='{$save_files_sn}' and `gperm_name`='dl_group'";
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

                    foreach ($_POST['dl_group'][$save_files_sn] as $groupid) {
                        $gperm_groupid = (int) $groupid;
                        $sql           = "insert into `" . $xoopsDB->prefix("group_permission") . "`  (`gperm_groupid`,`gperm_itemid`,`gperm_modid`,`gperm_name`) values('{$gperm_groupid}', '{$save_files_sn}', '{$mod_id}', 'dl_group')";
                        $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                    }
                }
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
        $all_files_sn = array();
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

                $file_handle->file_safe_name = false;
                if ($this->mime_type_check != 1) {
                    $file_handle->mime_check = false;
                }
                $file_handle->file_overwrite    = true;
                $file_handle->no_script         = false;
                $file_handle->file_new_name_ext = $ext;
                $hash_name                      = md5(rand(0, 1000) . $file['name']);
                if ($this->hash) {
                    $new_filename = $hash_name;
                } else {
                    $new_filename = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
                }

                if ($this->filename != '') {
                    $new_filename = $this->filename . "-" . $this->sort;
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
                $path   = ($kind == "img") ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;
                $readme = ($this->hash) ? "{$path}/{$hash_name}_info.txt" : "";

                //die($path);
                //新增限制檔案類型
                if (!empty($allow)) {
                    $file_handle->allowed = $allow_arr;
                }
                $file_handle->process($path);
                $file_handle->auto_create_dir = true;

                $upload_date = date("Y-m-d H:i:s");
                $uid         = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

                //若是圖片才製作小縮圖
                if ($kind == "img") {
                    $file_handle->file_safe_name = false;
                    if ($this->mime_type_check != 1) {
                        $file_handle->mime_check = false;
                    }
                    $file_handle->file_overwrite     = true;
                    $file_handle->file_new_name_ext  = $ext;
                    $file_handle->file_new_name_body = $new_filename;

                    if ($file_handle->image_src_x > $thumb_width) {
                        $file_handle->image_resize  = true;
                        $file_handle->image_x       = $thumb_width;
                        $file_handle->image_ratio_y = true;
                    }
                    //新增限制檔案類型
                    if (!empty($allow)) {
                        $file_handle->allowed = $allow_arr;
                    }
                    $file_handle->process($this->TadUpFilesThumbDir);
                    $file_handle->auto_create_dir = true;
                }

                //上傳檔案
                if ($file_handle->processed) {
                    $file_handle->clean();

                    if ($this->hash) {
                        $fp = fopen($readme, 'w');
                        fwrite($fp, $file['name']);
                        fclose($fp);
                    }

                    $file_name = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $file['name'];

                    if ($this->filename != '') {
                        $file_name = $this->filename . "-" . $this->sort . ".{$ext}";
                    }

                    $description = is_null($desc) ? $file['name'] : $desc;

                    chmod("{$path}/{$file_name}", 0755);
                    if ($kind == "img") {
                        chmod("{$this->TadUpFilesThumbDir}/{$file_name}", 0755);
                    }

                    $hash_name = ($this->hash) ? "{$hash_name}.{$ext}" : "";

                    if (empty($files_sn)) {
                        $sql = "replace into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}',0,'{$file['name']}','{$this->subdir}','{$hash_name}','{$upload_date}','{$uid}','{$tag}')";

                        $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                        //取得最後新增資料的流水編號
                        $insert_files_sn = $xoopsDB->getInsertId();

                        // 加入權限
                        if ($this->permission) {
                            foreach ($_POST['dl_group']['new'] as $groupid) {
                                $gperm_groupid = (int) $groupid;
                                $sql           = "insert into `" . $xoopsDB->prefix("group_permission") . "`  (`gperm_groupid`,`gperm_itemid`,`gperm_modid`,`gperm_name`) values('{$gperm_groupid}', '{$insert_files_sn}', '{$mod_id}', 'dl_group')";
                                $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                            }
                        }

                    } else {
                        $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}','{$upload_date}','{$uid}','{$tag}')";

                        $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                    }

                    $all_files_sn[] = $insert_files_sn;

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

    //解決 basename 抓不到中文檔名的問題
    protected function get_basename($filename)
    {
        $filename = preg_replace('/^.+[\\\\\\/]/', '', $filename);
        $filename = rtrim($filename, '/');

        return $filename;
    }

    //複製、匯入單一檔案，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function import_one_file($from = "", $new_filename = "", $main_width = "1920", $thumb_width = "240", $files_sn = "", $desc = "", $safe_name = false, $hash = false, $link = false)
    {
        global $xoopsDB, $xoopsUser;

        if (empty($main_width)) {
            $main_width = "1920";
        }

        if (empty($thumb_width)) {
            $thumb_width = "240";
        }

        if ($hash) {
            $this->set_hash($hash);
        }

        // die($from);
        $filename = $this->get_basename($from);
        $type     = $this->mime_content_type($filename);
        $size     = filesize($from);
        // die($filename);
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

        // die($new_filename);
        $readme    = "";
        $hash_name = md5(rand(0, 1000) . $filename);
        if ($this->hash) {
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
        $uid         = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

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

            if ($link) {
                $copy_or_link = symlink($from, $path . "/" . $hash_filename);
            } else {
                $copy_or_link = copy($from, $path . "/" . $hash_filename);
            }
            if ($copy_or_link) {
                $description  = (empty($files_sn) and empty($desc)) ? $filename : $desc;
                $this->col_sn = (int) $this->col_sn;
                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    // die("1-{$sql}");
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    // die("2-{$sql}");
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                }
                $this->sort = "";
                //echo "copy \"$from\" to  \"$path/$hash_filename\" OK!<br>";
            } else {
                //die("copy \"$from\" to  \"$path/$hash_filename\" fail!");
            }

            //複製檔案
            $this->thumbnail($from, $new_thumb, $type, $thumb_width);
        } else {
            if ($link) {
                $copy_or_link = symlink($from, $path . "/" . $hash_filename);
            } else {
                $copy_or_link = copy($from, $path . "/" . $hash_filename);
            }
            if ($copy_or_link) {
                $filename = auto_charset($filename);
                // die($filename);
                $description = (empty($files_sn) or empty($desc)) ? $filename : $desc;

                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    // die("3-{$sql}");
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$tag}')";
                    // die("4-{$sql}");
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                }

                $this->sort = "";
            }
        }

        //die('new_thumb:'.$new_thumb);

        return $files_sn;
    }

    //檔案格式
    protected function mime_content_type($filename)
    {

        $mime_types = array(
            'txt'  => 'text/plain',
            'htm'  => 'text/html',
            'html' => 'text/html',
            'php'  => 'text/html',
            'css'  => 'text/css',
            'csv'  => 'text/comma-separated-values',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'swf'  => 'application/x-shockwave-flash',
            'flv'  => 'video/x-flv',

            // images
            'png'  => 'image/png',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif'  => 'image/tiff',
            'svg'  => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'exe'  => 'application/x-msdownload',
            'msi'  => 'application/x-msdownload',
            'cab'  => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3'  => 'audio/mpeg',
            'qt'   => 'video/quicktime',
            'mov'  => 'video/quicktime',

            // adobe
            'pdf'  => 'application/pdf',
            'psd'  => 'image/vnd.adobe.photoshop',
            'ai'   => 'application/postscript',
            'eps'  => 'application/postscript',
            'ps'   => 'application/postscript',

            // ms office
            'doc'  => 'application/msword',
            'rtf'  => 'application/rtf',
            'xls'  => 'application/vnd.ms-excel',
            'ppt'  => 'application/vnd.ms-powerpoint',

            // open office
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.', $filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo    = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);

            return $mimetype;
        } else {
            return 'application/octet-stream';
        }
    }

    //做縮圖
    protected function thumbnail($filename = "", $thumb_name = "", $type = "image/jpeg", $width = "120")
    {

        ini_set('memory_limit', '50M');
        // Get new sizes
        list($old_width, $old_height) = getimagesize($filename);
        if ($old_width > $width) {
            $percent = ($old_width > $old_height) ? round($width / $old_width, 2) : round($width / $old_height, 2);

            $newwidth  = ($old_width > $old_height) ? $width : $old_width * $percent;
            $newheight = ($old_width > $old_height) ? $old_height * $percent : $width;

            // Load
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            if ($type == "image/jpeg" or $type == "image/jpg" or $type == "image/pjpg" or $type == "image/pjpeg") {
                $source = imagecreatefromjpeg($filename);
                $type   = "image/jpeg";
            } elseif ($type == "image/png") {
                $source = imagecreatefrompng($filename);
                $type   = "image/png";
            } elseif ($type == "image/gif") {
                $source = imagecreatefromgif($filename);
                $type   = "image/gif";
            }

            // Resize
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);
            //ob_start();
            //header("Content-type: $type");
            if ($type == "image/jpeg") {
                imagejpeg($thumb, $thumb_name);
            } elseif ($type == "image/png") {
                imagepng($thumb, $thumb_name);
            } elseif ($type == "image/gif") {
                imagegif($thumb, $thumb_name);
            }
            imagedestroy($thumb);

            //ob_end_clean();
            return;
            exit;
        } else {
            copy($filename, $thumb_name);

            return;
            exit;
        }

        return;
        exit;
    }

    //上傳單一檔案，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_one_file($name = "", $tmp_name = "", $type = "", $size = "", $main_width = "1280", $thumb_width = "120", $files_sn = "", $desc = "", $safe_name = false, $hash = false, $allow = "")
    {
        global $xoopsDB, $xoopsUser;

        if (empty($main_width)) {
            $main_width = "1280";
        }

        if (empty($thumb_width)) {
            $thumb_width = "120";
        }

        if ($hash) {
            $this->set_hash($hash);
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

            $file_handle->file_safe_name = false;
            if ($this->mime_type_check != 1) {
                $file_handle->mime_check = false;
            }

            $file_handle->file_overwrite    = true;
            $file_handle->file_new_name_ext = $ext;
            if ($this->hash) {
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

            $readme = ($this->hash) ? "{$path}/{$hash_name}_info.txt" : "";

            //die($path);
            $file_handle->process($path);
            $file_handle->auto_create_dir = true;

            $tag         = '';
            $upload_date = date("Y-m-d H:i:s");
            $uid         = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

            //若是圖片才製作小縮圖
            if ($kind == "img") {
                $file_handle->file_safe_name = false;
                if ($this->mime_type_check != 1) {
                    $file_handle->mime_check = false;
                }
                $file_handle->file_overwrite    = true;
                $file_handle->file_new_name_ext = $ext;
                if ($this->hash) {
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

                if ($this->hash) {
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
                if ($this->hash) {
                    $db_hash_name = "{$hash_name}.{$ext}";
                } else {
                    $db_hash_name = '';
                }
                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$db_hash_name}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$db_hash_name}','{$upload_date}','{$uid}','{$tag}')";
                    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
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

    //自動編號
    public function auto_sort()
    {
        global $xoopsDB, $xoopsUser;

        $sql = "select max(sort) from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";

        $result    = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        list($max) = $xoopsDB->fetchRow($result);

        return ++$max;
    }

    //更新某個欄位值
    protected function update_col_val($files_sn = "", $col = "", $val = "")
    {
        global $xoopsDB, $xoopsUser;

        $myts = MyTextSanitizer::getInstance();
        $col  = $myts->addSlashes($col);
        $val  = $myts->addSlashes($val);

        $sql = "update `{$this->TadUpFilesTblName}`  set `$col`='{$val}' where `files_sn`='{$files_sn}'";
        $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
    }

    //刪除實體檔案
    public function del_files($files_sn = "")
    {
        global $xoopsDB, $xoopsUser;

        $modhandler  = xoops_gethandler('module');
        $xoopsModule = $modhandler->getByDirname($this->prefix);
        $mod_id      = $xoopsModule->mid();
        $isAdmin     = is_object($xoopsUser) ? $xoopsUser->isAdmin($mod_id) : false;

        if (!empty($files_sn)) {
            $del_what = "`files_sn`='{$files_sn}'";
        } elseif (!empty($this->col_name) and !empty($this->col_sn)) {
            $and_sort = (empty($this->sort)) ? "" : "and `sort`='{$this->sort}'";
            $del_what = "`col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort";
        }

        if (empty($del_what)) {
            return false;
        }

        $sql    = "select * from `{$this->TadUpFilesTblName}`  where $del_what";
        $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);

        $my_uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

        while ($all = $xoopsDB->fetchArray($result)) {
            foreach ($all as $k => $v) {
                $$k = $v;
            }
            if ($isAdmin or $uid == $my_uid) {
                $this->set_col($col_name, $col_sn, $sort);
                $del_sql = "delete  from `{$this->TadUpFilesTblName}`  where files_sn='{$files_sn}'";
                $xoopsDB->queryF($del_sql) or web_error($del_sql);

                if (!empty($hash_filename)) {
                    $file_name = $hash_filename;
                }

                if ($kind == "img") {
                    unlink("{$this->TadUpFilesImgDir}/{$file_name}");
                    unlink("{$this->TadUpFilesThumbDir}/{$file_name}");
                } else {
                    unlink("{$this->TadUpFilesDir}/{$file_name}");
                }

                $f = explode('.', $hash_filename);
                if (file_exists("{$this->TadUpFilesDir}/{$f[0]}_info.txt")) {
                    unlink("{$this->TadUpFilesDir}/{$f[0]}_info.txt");
                }

                $tmp_dir = XOOPS_ROOT_PATH . "/uploads/{$this->prefix}/tmp/{$files_sn}";
                $this->delete_directory($tmp_dir);
            }
        }
        return true;
    }

    //改檔名
    public function rename_file($files_sn = "", $new_name = "")
    {

        if (empty($files_sn)) {
            return;
        }

        $file = $this->get_file($files_sn);

        if ($file[$files_sn]['kind'] == "img") {
            //die('asss');
            $file = $this->get_pic_file("images", "dir", $files_sn);

            rename($file, $this->TadUpFilesImgDir . "/{$new_name}");

            $file = $this->get_pic_file("thumb", "dir", $files_sn);
            rename($file, $this->TadUpFilesThumbDir . "/{$new_name}");
        } else {
            $file = $this->get_pic_file("file", "dir", $files_sn);
            rename($file, $this->TadUpFilesDir . "/{$new_name}");
        }
        $this->update_col_val($files_sn, 'file_name', $new_name);
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

        if ($hash) {
            $this->set_hash($hash);
        }

        if (empty($files_sn) and !empty($this->files_sn)) {
            $files_sn = $this->files_sn;
        }
        if (is_array($files_sn)) {
            $where = "where `files_sn` in('" . implode("','", $files_sn) . "')";
        } else {

            $where = ($files_sn) ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort $andLimit";
        }

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";

        $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            //修改於 2018/09/11
            // if ($os_charset != _CHARSET) {
            //     $file_name = iconv($os_charset, _CHARSET, $file_name);
            // }

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
            $http   = 'http://';
            if (!empty($_SERVER['HTTPS'])) {
                $http = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
            }
            $full_dl_url = empty($this->download_url) ? "{$http}{$_SERVER["HTTP_HOST"]}{$link_path}?op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";

            if ($kind == "img") {
                $fancyboxset = "fancybox_{$this->col_name}";
                $rel         = "rel='f{$this->col_name}'";

                $file_name = $this->hash ? $hash_filename : $file_name;
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

                $files[$files_sn]['tb_link']            = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$files_sn]['tb_path']            = $thumb_pic;
                $files[$files_sn]['tb_url']             = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'>{$description}</a>";
                $files[$files_sn]['original_file_path'] = $this->TadUpFilesImgUrl . "/{$file_name}";
                $files[$files_sn]['physical_file_path'] = $this->TadUpFilesImgDir . "/{$file_name}";
            } else {
                $files[$files_sn]['link']               = "<a href='{$dl_url}#{$original_filename}' target='{$target}'>{$show_file_name}</a>";
                $files[$files_sn]['path']               = "{$dl_url}#{$original_filename}";
                $files[$files_sn]['original_file_path'] = $this->TadUpFilesUrl . "/{$file_name}";
                $files[$files_sn]['physical_file_path'] = $this->TadUpFilesDir . "/{$file_name}";
            }
            $files[$files_sn]['original_filename'] = $original_filename;
            $files[$files_sn]['full_dl_url']       = $full_dl_url;
            $files[$files_sn]['show_file_name']    = $show_file_name;
            $files[$files_sn]['text_link']         = "{$show_file_name} : {$full_dl_url}";
            $files[$files_sn]['html_link']         = "{$show_file_name} : <a href='{$full_dl_url}'>{$full_dl_url}</a>";
        }

        return $files;
    }

    //取得smarty用的檔案陣列
    public function get_file_for_smarty($files_sn = "", $limit = null, $path = null)
    {
        global $xoopsDB, $xoopsUser;

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
        // die($sql);
        $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        $i      = 0;
        $files  = array();
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            if ($os_charset != _CHARSET) {
                $file_name = iconv($os_charset, _CHARSET, $file_name);
            }

            $files[$i]['files_sn']          = $files_sn;
            $files[$i]['kind']              = $kind;
            $files[$i]['sort']              = $sort;
            $files[$i]['file_name']         = $file_name;
            $files[$i]['file_type']         = $file_type;
            $files[$i]['file_size']         = $file_size;
            $files[$i]['counter']           = $counter;
            $files[$i]['description']       = $description;
            $files[$i]['original_filename'] = $original_filename;

            $dl_url = empty($this->download_url) ? "{$link_path}?op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";

            if ($kind == "img") {

                $pic_name  = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                $files[$i]['link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='{$pic_name}' alt='{$description}' title='{$description}' rel='lytebox'></a>";
                $files[$i]['path'] = $pic_name;
                $files[$i]['url']  = "<a href='{$dl_url}' title='{$description}' target='_blank'>{$description}</a>";

                $files[$i]['tb_link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$i]['tb_path'] = $thumb_pic;
                $files[$i]['tb_url']  = "<a href='{$dl_url}' title='{$description}' rel='lytebox'>{$description}</a>";
            } elseif (strtolower(substr($file_name, -3)) == "swf") {
                $pic_name  = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                $files[$i]['link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='{$pic_name}' alt='{$description}' title='{$description}' rel='lytebox'></a>";
                $files[$i]['path'] = $pic_name;
                $files[$i]['url']  = "<a href='{$dl_url}' title='{$description}' target='_blank'>{$description}</a>";

                $files[$i]['tb_link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$i]['tb_path'] = $thumb_pic;
                $files[$i]['tb_url']  = "<a href='{$dl_url}' title='{$description}' rel='lytebox'>{$description}</a>";

            } else {
                $files[$i]['link'] = "<a href='{$dl_url}#{$original_filename}'>{$original_filename}</a>";
                $files[$i]['path'] = "{$dl_url}#{$original_filename}";
            }
            $i++;
        }

        return $files;
    }

    //取得單一圖片 $kind=images（大圖）,thumb（小圖）,file（檔案）$kind="url","dir"
    public function get_pic_file($showkind = "images", $show_kind = "url", $files_sn = "", $hash = false)
    {
        global $xoopsDB, $xoopsUser;
        if ((empty($this->col_sn) or empty($this->col_name)) and empty($files_sn)) {
            return;
        }
        if ($hash) {
            $this->set_hash($hash);
        }

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : "";

        $where = $files_sn ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort limit 0,1";

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";
        // die($sql);
        $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        $files  = array();
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }
            $file_name = $this->hash ? $hash_filename : $file_name;
            if ($showkind == "thumb") {
                $path  = ($show_kind == "dir") ? $this->TadUpFilesThumbDir : $this->TadUpFilesThumbUrl;
                $files = (file_exists("{$this->TadUpFilesThumbDir}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            } elseif ($showkind == "file") {
                $path  = ($show_kind == "dir") ? $this->TadUpFilesDir : $this->TadUpFilesUrl;
                $files = (file_exists("{$this->TadUpFilesDir}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            } else {
                $path  = ($show_kind == "dir") ? $this->TadUpFilesImgDir : $this->TadUpFilesImgUrl;
                $files = (file_exists("{$this->TadUpFilesImgDir}/{$file_name}")) ? "{$path}/{$file_name}" : "";
            }
        }
        // die(var_dump($files));
        return $files;
    }

    //取得檔案數
    public function get_file_amount()
    {
        global $xoopsDB;

        $sql = "select count(*) from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";

        $result       = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        list($amount) = $xoopsDB->fetchRow($result);

        return $amount;
    }

    //取得附檔或附圖 $show_mode=filename , small,playSpeed=3000 or 0
    public function show_files($upname = "", $thumb = true, $show_mode = "", $show_description = false, $show_dl = false, $limit = null, $path = null, $hash = false, $playSpeed = 0, $desc_as_name = false, $keyword = '', $only_keyword = false, $target = '_self')
    {
        global $xoTheme;

        $all_files = "";
        if ($xoTheme) {
            if ($show_mode == "small") {
                $xoTheme->addStylesheet('modules/tadtools/css/iconize.css');
            } elseif ($show_mode == "filename") {
                $xoTheme->addStylesheet('modules/tadtools/css/rounded-list.css');
            }
        } else {
            if ($show_mode == "small") {
                $all_files = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/iconize.css">';
            } elseif ($show_mode == "filename") {
                $all_files = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/rounded-list.css">';
            }
        }

        if ($hash) {
            $this->set_hash($hash);
        }

        $playSpeed = empty($playSpeed) ? 0 : $playSpeed;
        $autoPlay  = empty($playSpeed) ? false : true;

        if ($this->showFancyBox) {
            if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php")) {
                redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
            }
            include_once XOOPS_ROOT_PATH . "/modules/tadtools/fancybox.php";
            $fancybox = new fancybox(".fancybox_{$this->col_name}", 640, 480);
            $all_files .= ($show_mode == "file_text_url" or $show_mode == "file_url") ? '' : $fancybox->render(false, null, $autoPlay, $playSpeed);
        }

        $file_arr = array();
        $file_arr = $this->get_file(null, $limit, $path, $hash, $desc_as_name, $keyword, $only_keyword, $target);

        if (empty($file_arr)) {
            return;
        }

        if ($file_arr) {
            $i = 1;

            if ($show_mode == "file_url") {
                $all_files .= "<ul>";
            } elseif ($show_mode == "file_text_url" or $show_mode == "small") {
                $all_files .= "";
            } elseif ($show_mode == "filename") {
                $all_files .= "<ol class='rectangle-list' style=\"counter-reset: li; list-style: none; *list-style: decimal; font: " . $this->filename_size . " 'trebuchet MS', 'lucida sans'; padding: 0; text-shadow: 0 1px 0 rgba(255,255,255,.5);\">";
            } else {
                $all_files .= "<ul>";
            }

            foreach ($file_arr as $files_sn => $file_info) {

                if ($show_mode == "filename") {
                    if ($file_info['kind'] == "file") {
                        $all_files .= "<li>{$file_info['link']}</li>";
                    } else {
                        if (strpos($file_info['tag'], '360') !== false) {
                            $linkto = TADTOOLS_URL . "/360.php?photo={$file_info['path']}";
                            $all_files .= "<li><a href='{$linkto}' class='fancybox_{$this->col_name}' data-fancybox-type='iframe'>{$file_info['original_filename']}</a></li>";
                        } else {
                            $all_files .= "<li>{$file_info['url']}</li>";
                        }
                    }
                } elseif ($show_mode == "file_url") {
                    $all_files .= "<li>{$file_info['html_link']}</li>";
                } elseif ($show_mode == "file_text_url") {
                    $all_files .= "{$file_info['text_link']},";
                } else {
                    $linkto      = $file_info['path'];
                    $description = empty($file_info['description']) ? $file_info['original_filename'] : $file_info['description'];
                    if ($file_info['kind'] == "file") {
                        $fext      = pathinfo($file_info['path'], PATHINFO_EXTENSION);
                        $thumb_pic = TADTOOLS_URL . "/images/mimetype/{$fext}.png";
                        //$fext=strtolower(substr($file_info['path'], -3));
                        if ($fext == "mp4" or $fext == "flv" or $fext == "3gp" or $fext == "mp3") {
                            // $thumb_pic = TADTOOLS_URL . "/images/video.png";
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
                            // $thumb_pic   = TADTOOLS_URL . "/multiple-file-upload/downloads.png";
                            $fancyboxset = $rel = "";
                        }
                        $thumb_css = "background-color: tranparent;";
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
                        $thumb_css     = "background-color: #cfcfcf; background-size: contain;border-radius: 5px;";
                    }

                    //下載次數顯示
                    $show_dl_txt = ($show_dl) ? "<span class='label label-info'>{$file_info['counter']}</span>" : "";

                    //描述顯示
                    $show_description_txt = ($show_description) ? "<div style='font-weight: normal; font-size: 11px; word-break: break-all; line-height: 1.2; margin: 4px auto 4px 0px; text-align: left;'>{$i}) {$description} {$show_dl_txt}</div>" : "{$show_dl_txt}";

                    $all_files .= ($show_mode == "small") ? "<a href='{$linkto}' data-toggle='tooltip' data-placement='top' title='{$description}' class='iconize {$fancyboxset}' {$rel}>&nbsp;</a> " : "
                    <li style='width:120px;height:180px;float:left;list-style:none;'>
                    <a href='{$linkto}' class='thumbnail {$fancyboxset}' {$rel} style=\"display:inline-block; width: 120px; height: 120px; overflow: hidden; {$thumb_css} background-image: url('{$thumb_pic}');background-repeat: no-repeat;background-position: center center; margin-bottom: 4px;\">&nbsp;</a>{$show_description_txt}
                    </li>";
                }

                $i++;
            }

            if ($show_mode == "file_url") {
                $all_files .= "</ul>";
            } elseif ($show_mode == "file_text_url" or $show_mode == "small") {
                $all_files .= "";
            } elseif ($show_mode == "filename") {
                $all_files .= "</ol><div style='clear:both;'></div>";
            } else {
                $all_files .= "</ul><div style='clear:both;'></div>";
            }

        } else {
            $all_files = "";
        }

        return $all_files;
    }

    //下載並新增計數器
    public function add_file_counter($files_sn = "", $hash = false, $force = false, $path = "")
    {
        global $xoopsDB, $xoopsUser;

        // 權限設定
        if ($this->permission) {
            $sql               = "select gperm_groupid from `" . $xoopsDB->prefix("group_permission") . "` where gperm_name='dl_group' and gperm_itemid='{$files_sn}' order by gperm_groupid";
            $result            = $xoopsDB->query($sql) or web_error($sql);
            $gperm_groupid_arr = array();
            while (list($gperm_groupid) = $xoopsDB->fetchRow($result)) {
                $gperm_groupid_arr[] = $gperm_groupid;
            }

            if (!empty($gperm_groupid_arr)) {
                //取得目前使用者的群組編號
                if ($xoopsUser) {
                    $groups = $xoopsUser->getGroups();
                } else {
                    $groups = XOOPS_GROUP_ANONYMOUS;
                }

                if (!array_intersect($groups, $gperm_groupid_arr)) {
                    redirect_header($_SERVER['HTTP_REFERER'], 3, _TAD_PERMISSION_DENIED);
                }
            }

        }

        $file = $this->get_one_file($files_sn);
        $this->set_dir('subdir', $file['sub_dir']);
        if ($hash) {
            $this->set_hash($hash);
        }

        $file_type     = $file['file_type'];
        $file_size     = $file['file_size'];
        $real_filename = $file['original_filename'];
        $dl_name       = ($this->hash) ? $file['hash_filename'] : $file['file_name'];
        // die($dl_name);
        $sql = "update `{$this->TadUpFilesTblName}` set `counter`=`counter`+1 where `files_sn`='{$files_sn}'";
        $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

        if ($file['kind'] == "img") {
            $file_saved    = "{$this->TadUpFilesImgUrl}/{$dl_name}";
            $file_hd_saved = "{$this->TadUpFilesImgDir}/{$dl_name}";
        } else {
            $file_saved    = "{$this->TadUpFilesUrl}/{$dl_name}";
            $file_hd_saved = "{$this->TadUpFilesDir}/{$dl_name}";
        }
        //die($file_hd_saved);

        $os_charset = (PATH_SEPARATOR == ':') ? "UTF-8" : "Big5";

        $mimetype = $file_type;
        if (function_exists('mb_http_output')) {
            mb_http_output('pass');
        }

        if ($force) {
            if ($os_charset != _CHARSET) {
                $file_display  = iconv($os_charset, _CHARSET, $real_filename);
                $file_hd_saved = iconv($os_charset, _CHARSET, $file_hd_saved);
            } else {
                $file_display = $real_filename;
            }

            header('Expires: 0');
            header('Content-Type: ' . $mimetype);
            //header('Content-Type: application/octet-stream');
            if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $HTTP_USER_AGENT)) {
                header('Content-Disposition: inline; filename="' . $file_display . '"');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
            } else {
                header('Content-Disposition: attachment; filename="' . $file_display . '"');
                header('Pragma: no-cache');
            }
            //header("Content-Type: application/force-download");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($file_hd_saved));

            ob_clean();
            $handle = fopen($file_hd_saved, "rb");

            set_time_limit(0);
            while (!feof($handle)) {
                echo fread($handle, 4096);
                flush();
            }
            fclose($handle);

            die;
        } else {
            if ($os_charset != _CHARSET) {
                //若網站和主機編碼不同，則將 $file_display (真實檔名) 轉為主機編碼，以便等一下建立檔案
                $file_display  = iconv(_CHARSET, $os_charset, $real_filename);
                $file_hd_saved = iconv(_CHARSET, $os_charset, $file_hd_saved);
            } else {
                $file_display = $real_filename;
            }

            mk_dir(XOOPS_ROOT_PATH . "/uploads/{$this->prefix}");
            mk_dir(XOOPS_ROOT_PATH . "/uploads/{$this->prefix}/tmp");
            $tmp_dir = XOOPS_ROOT_PATH . "/uploads/{$this->prefix}/tmp/{$file['files_sn']}";
            $tmp_url = XOOPS_URL . "/uploads/{$this->prefix}/tmp/{$file['files_sn']}";
            mk_dir($tmp_dir);
            $tmp_file     = $tmp_dir . "/" . $file_display;
            $tmp_file_url = $tmp_url . "/" . $file_display;

            //die("$file_hd_saved,$tmp_file");
            if (!file_exists($tmp_file)) {
                copy($file_hd_saved, $tmp_file);
            }

            if ($this->auto_charset != 0) {
                $tmp_file_url = auto_charset($tmp_file_url);
            }

            if (!empty($path)) {
                if (substr($path, -1) == "/") {
                    $path = substr($path, 0, -1);
                }
                if (!is_dir($path)) {
                    mk_dir($path);
                }
                rename($tmp_file, $path . "/" . $file_display);
            } else {
                header("location:{$tmp_file_url}");
            }
            exit;
        }
    }

    //取得單一檔案資料
    public function get_one_file($files_sn = "")
    {
        global $xoopsDB, $xoopsUser;

        $sql = "select * from `{$this->TadUpFilesTblName}`  where `files_sn`='{$files_sn}'";

        $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
        $all    = $xoopsDB->fetchArray($result);
        // die(var_export($all));
        return $all;
    }

    protected function filesize2bytes($str)
    {
        $bytes = 0;

        $bytes_array = array(
            'B' => 1,
            'K' => 1024,
            'M' => 1024 * 1024,
            'G' => 1024 * 1024 * 1024,
            'T' => 1024 * 1024 * 1024 * 1024,
            'P' => 1024 * 1024 * 1024 * 1024 * 1024,
        );

        $bytes = (float) $str;

        if (preg_match('#([KMGTP]?)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) {
            $bytes *= $bytes_array[$matches[1]];
        }

        $bytes = (int) round($bytes, 2);

        return $bytes;
    }

    protected function delete_directory($dirname)
    {
        if (is_dir($dirname)) {
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle) {
            return false;
        }

        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname . "/" . $file)) {
                    unlink($dirname . "/" . $file);
                } else {
                    delete_directory($dirname . '/' . $file);
                }

            }
        }
        closedir($dir_handle);
        rmdir($dirname);

        return true;
    }

    protected function ext2mime($ext)
    {

        // I made this array by joining all the following lists + .php extension which is missing in all of them.
        // please contribute to this list to make it as accurate and complete as possible.
        // https://gist.github.com/plasticbrain/3887245
        // http://pastie.org/5668002
        // http://pastebin.com/iuTy6K6d
        // total: 1223 extensions as of 16 November 2015
        $all_mimes = array(
            '3dm'          => array('x-world/x-3dmf'),
            '3dmf'         => array('x-world/x-3dmf'),
            '3dml'         => array('text/vnd.in3d.3dml'),
            '3ds'          => array('image/x-3ds'),
            '3g2'          => array('video/3gpp2'),
            '3gp'          => array('video/3gpp'),
            '7z'           => array('application/x-7z-compressed'),
            'a'            => array('application/octet-stream'),
            'aab'          => array('application/x-authorware-bin'),
            'aac'          => array('audio/x-aac'),
            'aam'          => array('application/x-authorware-map'),
            'aas'          => array('application/x-authorware-seg'),
            'abc'          => array('text/vnd.abc'),
            'abw'          => array('application/x-abiword'),
            'ac'           => array('application/pkix-attr-cert'),
            'acc'          => array('application/vnd.americandynamics.acc'),
            'ace'          => array('application/x-ace-compressed'),
            'acgi'         => array('text/html'),
            'acu'          => array('application/vnd.acucobol'),
            'acutc'        => array('application/vnd.acucorp'),
            'adp'          => array('audio/adpcm'),
            'aep'          => array('application/vnd.audiograph'),
            'afl'          => array('video/animaflex'),
            'afm'          => array('application/x-font-type1'),
            'afp'          => array('application/vnd.ibm.modcap'),
            'ahead'        => array('application/vnd.ahead.space'),
            'ai'           => array('application/postscript'),
            'aif'          => array('audio/aiff', 'audio/x-aiff'),
            'aifc'         => array('audio/aiff', 'audio/x-aiff'),
            'aiff'         => array('audio/aiff', 'audio/x-aiff'),
            'aim'          => array('application/x-aim'),
            'aip'          => array('text/x-audiosoft-intra'),
            'air'          => array('application/vnd.adobe.air-application-installer-package+zip'),
            'ait'          => array('application/vnd.dvb.ait'),
            'ami'          => array('application/vnd.amiga.ami'),
            'ani'          => array('application/x-navi-animation'),
            'aos'          => array('application/x-nokia-9000-communicator-add-on-software'),
            'apk'          => array('application/vnd.android.package-archive'),
            'appcache'     => array('text/cache-manifest'),
            'application'  => array('application/x-ms-application'),
            'apr'          => array('application/vnd.lotus-approach'),
            'aps'          => array('application/mime'),
            'arc'          => array('application/x-freearc'),
            'arj'          => array('application/arj', 'application/octet-stream'),
            'art'          => array('image/x-jg'),
            'asc'          => array('application/pgp-signature'),
            'asf'          => array('video/x-ms-asf'),
            'asm'          => array('text/x-asm'),
            'aso'          => array('application/vnd.accpac.simply.aso'),
            'asp'          => array('text/asp'),
            'asx'          => array('application/x-mplayer2', 'video/x-ms-asf', 'video/x-ms-asf-plugin'),
            'atc'          => array('application/vnd.acucorp'),
            'atom'         => array('application/atom+xml'),
            'atomcat'      => array('application/atomcat+xml'),
            'atomsvc'      => array('application/atomsvc+xml'),
            'atx'          => array('application/vnd.antix.game-component'),
            'au'           => array('audio/basic'),
            'avi'          => array('application/x-troff-msvideo', 'video/avi', 'video/msvideo', 'video/x-msvideo'),
            'avs'          => array('video/avs-video'),
            'aw'           => array('application/applixware'),
            'azf'          => array('application/vnd.airzip.filesecure.azf'),
            'azs'          => array('application/vnd.airzip.filesecure.azs'),
            'azw'          => array('application/vnd.amazon.ebook'),
            'bat'          => array('application/x-msdownload'),
            'bcpio'        => array('application/x-bcpio'),
            'bdf'          => array('application/x-font-bdf'),
            'bdm'          => array('application/vnd.syncml.dm+wbxml'),
            'bed'          => array('application/vnd.realvnc.bed'),
            'bh2'          => array('application/vnd.fujitsu.oasysprs'),
            'bin'          => array('application/mac-binary', 'application/macbinary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'),
            'blb'          => array('application/x-blorb'),
            'blorb'        => array('application/x-blorb'),
            'bm'           => array('image/bmp'),
            'bmi'          => array('application/vnd.bmi'),
            'bmp'          => array('image/bmp', 'image/x-windows-bmp'),
            'boo'          => array('application/book'),
            'book'         => array('application/vnd.framemaker'),
            'box'          => array('application/vnd.previewsystems.box'),
            'boz'          => array('application/x-bzip2'),
            'bpk'          => array('application/octet-stream'),
            'bsh'          => array('application/x-bsh'),
            'btif'         => array('image/prs.btif'),
            'buffer'       => array('application/octet-stream'),
            'bz'           => array('application/x-bzip'),
            'bz2'          => array('application/x-bzip2'),
            'c'            => array('text/x-c'),
            'c++'          => array('text/plain'),
            'c11amc'       => array('application/vnd.cluetrust.cartomobile-config'),
            'c11amz'       => array('application/vnd.cluetrust.cartomobile-config-pkg'),
            'c4d'          => array('application/vnd.clonk.c4group'),
            'c4f'          => array('application/vnd.clonk.c4group'),
            'c4g'          => array('application/vnd.clonk.c4group'),
            'c4p'          => array('application/vnd.clonk.c4group'),
            'c4u'          => array('application/vnd.clonk.c4group'),
            'cab'          => array('application/vnd.ms-cab-compressed'),
            'caf'          => array('audio/x-caf'),
            'cap'          => array('application/vnd.tcpdump.pcap'),
            'car'          => array('application/vnd.curl.car'),
            'cat'          => array('application/vnd.ms-pki.seccat'),
            'cb7'          => array('application/x-cbr'),
            'cba'          => array('application/x-cbr'),
            'cbr'          => array('application/x-cbr'),
            'cbt'          => array('application/x-cbr'),
            'cbz'          => array('application/x-cbr'),
            'cc'           => array('text/plain', 'text/x-c'),
            'ccad'         => array('application/clariscad'),
            'cco'          => array('application/x-cocoa'),
            'cct'          => array('application/x-director'),
            'ccxml'        => array('application/ccxml+xml'),
            'cdbcmsg'      => array('application/vnd.contact.cmsg'),
            'cdf'          => array('application/cdf', 'application/x-cdf', 'application/x-netcdf'),
            'cdkey'        => array('application/vnd.mediastation.cdkey'),
            'cdmia'        => array('application/cdmi-capability'),
            'cdmic'        => array('application/cdmi-container'),
            'cdmid'        => array('application/cdmi-domain'),
            'cdmio'        => array('application/cdmi-object'),
            'cdmiq'        => array('application/cdmi-queue'),
            'cdx'          => array('chemical/x-cdx'),
            'cdxml'        => array('application/vnd.chemdraw+xml'),
            'cdy'          => array('application/vnd.cinderella'),
            'cer'          => array('application/pkix-cert', 'application/x-x509-ca-cert'),
            'cfs'          => array('application/x-cfs-compressed'),
            'cgm'          => array('image/cgm'),
            'cha'          => array('application/x-chat'),
            'chat'         => array('application/x-chat'),
            'chm'          => array('application/vnd.ms-htmlhelp'),
            'chrt'         => array('application/vnd.kde.kchart'),
            'cif'          => array('chemical/x-cif'),
            'cii'          => array('application/vnd.anser-web-certificate-issue-initiation'),
            'cil'          => array('application/vnd.ms-artgalry'),
            'cla'          => array('application/vnd.claymore'),
            'class'        => array('application/java', 'application/java-byte-code', 'application/x-java-class'),
            'clkk'         => array('application/vnd.crick.clicker.keyboard'),
            'clkp'         => array('application/vnd.crick.clicker.palette'),
            'clkt'         => array('application/vnd.crick.clicker.template'),
            'clkw'         => array('application/vnd.crick.clicker.wordbank'),
            'clkx'         => array('application/vnd.crick.clicker'),
            'clp'          => array('application/x-msclip'),
            'cmc'          => array('application/vnd.cosmocaller'),
            'cmdf'         => array('chemical/x-cmdf'),
            'cml'          => array('chemical/x-cml'),
            'cmp'          => array('application/vnd.yellowriver-custom-menu'),
            'cmx'          => array('image/x-cmx'),
            'cod'          => array('application/vnd.rim.cod'),
            'com'          => array('application/octet-stream', 'text/plain'),
            'conf'         => array('text/plain'),
            'cpio'         => array('application/x-cpio'),
            'cpp'          => array('text/x-c'),
            'cpt'          => array('application/x-compactpro', 'application/x-cpt'),
            'crd'          => array('application/x-mscardfile'),
            'crl'          => array('application/pkcs-crl', 'application/pkix-crl'),
            'crt'          => array('application/pkix-cert', 'application/x-x509-ca-cert', 'application/x-x509-user-cert'),
            'crx'          => array('application/x-chrome-extension'),
            'cryptonote'   => array('application/vnd.rig.cryptonote'),
            'csh'          => array('application/x-csh', 'text/x-script.csh'),
            'csml'         => array('chemical/x-csml'),
            'csp'          => array('application/vnd.commonspace'),
            'css'          => array('application/x-pointplus', 'text/css'),
            'cst'          => array('application/x-director'),
            'csv'          => array('text/csv'),
            'cu'           => array('application/cu-seeme'),
            'curl'         => array('text/vnd.curl'),
            'cww'          => array('application/prs.cww'),
            'cxt'          => array('application/x-director'),
            'cxx'          => array('text/x-c'),
            'dae'          => array('model/vnd.collada+xml'),
            'daf'          => array('application/vnd.mobius.daf'),
            'dart'         => array('application/vnd.dart'),
            'dataless'     => array('application/vnd.fdsn.seed'),
            'davmount'     => array('application/davmount+xml'),
            'dbk'          => array('application/docbook+xml'),
            'dcr'          => array('application/x-director'),
            'dcurl'        => array('text/vnd.curl.dcurl'),
            'dd2'          => array('application/vnd.oma.dd2+xml'),
            'ddd'          => array('application/vnd.fujixerox.ddd'),
            'deb'          => array('application/x-debian-package'),
            'deepv'        => array('application/x-deepv'),
            'def'          => array('text/plain'),
            'deploy'       => array('application/octet-stream'),
            'der'          => array('application/x-x509-ca-cert'),
            'dfac'         => array('application/vnd.dreamfactory'),
            'dgc'          => array('application/x-dgc-compressed'),
            'dic'          => array('text/x-c'),
            'dif'          => array('video/x-dv'),
            'diff'         => array('text/plain'),
            'dir'          => array('application/x-director'),
            'dis'          => array('application/vnd.mobius.dis'),
            'dist'         => array('application/octet-stream'),
            'distz'        => array('application/octet-stream'),
            'djv'          => array('image/vnd.djvu'),
            'djvu'         => array('image/vnd.djvu'),
            'dl'           => array('video/dl', 'video/x-dl'),
            'dll'          => array('application/x-msdownload'),
            'dmg'          => array('application/x-apple-diskimage'),
            'dmp'          => array('application/vnd.tcpdump.pcap'),
            'dms'          => array('application/octet-stream'),
            'dna'          => array('application/vnd.dna'),
            'doc'          => array('application/msword'),
            'docm'         => array('application/vnd.ms-word.document.macroenabled.12'),
            'docx'         => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            'dot'          => array('application/msword'),
            'dotm'         => array('application/vnd.ms-word.template.macroenabled.12'),
            'dotx'         => array('application/vnd.openxmlformats-officedocument.wordprocessingml.template'),
            'dp'           => array('application/vnd.osgi.dp'),
            'dpg'          => array('application/vnd.dpgraph'),
            'dra'          => array('audio/vnd.dra'),
            'drw'          => array('application/drafting'),
            'dsc'          => array('text/prs.lines.tag'),
            'dssc'         => array('application/dssc+der'),
            'dtb'          => array('application/x-dtbook+xml'),
            'dtd'          => array('application/xml-dtd'),
            'dts'          => array('audio/vnd.dts'),
            'dtshd'        => array('audio/vnd.dts.hd'),
            'dump'         => array('application/octet-stream'),
            'dv'           => array('video/x-dv'),
            'dvb'          => array('video/vnd.dvb.file'),
            'dvi'          => array('application/x-dvi'),
            'dwf'          => array('drawing/x-dwf (old)', 'model/vnd.dwf'),
            'dwg'          => array('application/acad', 'image/vnd.dwg', 'image/x-dwg'),
            'dxf'          => array('image/vnd.dxf'),
            'dxp'          => array('application/vnd.spotfire.dxp'),
            'dxr'          => array('application/x-director'),
            'ecelp4800'    => array('audio/vnd.nuera.ecelp4800'),
            'ecelp7470'    => array('audio/vnd.nuera.ecelp7470'),
            'ecelp9600'    => array('audio/vnd.nuera.ecelp9600'),
            'ecma'         => array('application/ecmascript'),
            'edm'          => array('application/vnd.novadigm.edm'),
            'edx'          => array('application/vnd.novadigm.edx'),
            'efif'         => array('application/vnd.picsel'),
            'ei6'          => array('application/vnd.pg.osasli'),
            'el'           => array('text/x-script.elisp'),
            'elc'          => array('application/x-bytecode.elisp (compiled elisp)', 'application/x-elc'),
            'emf'          => array('application/x-msmetafile'),
            'eml'          => array('message/rfc822'),
            'emma'         => array('application/emma+xml'),
            'emz'          => array('application/x-msmetafile'),
            'env'          => array('application/x-envoy'),
            'eol'          => array('audio/vnd.digital-winds'),
            'eot'          => array('application/vnd.ms-fontobject'),
            'eps'          => array('application/postscript'),
            'epub'         => array('application/epub+zip'),
            'es'           => array('application/x-esrehber'),
            'es3'          => array('application/vnd.eszigno3+xml'),
            'esa'          => array('application/vnd.osgi.subsystem'),
            'esf'          => array('application/vnd.epson.esf'),
            'et3'          => array('application/vnd.eszigno3+xml'),
            'etx'          => array('text/x-setext'),
            'eva'          => array('application/x-eva'),
            'event-stream' => array('text/event-stream'),
            'evy'          => array('application/envoy', 'application/x-envoy'),
            'exe'          => array('application/x-msdownload'),
            'exi'          => array('application/exi'),
            'ext'          => array('application/vnd.novadigm.ext'),
            'ez'           => array('application/andrew-inset'),
            'ez2'          => array('application/vnd.ezpix-album'),
            'ez3'          => array('application/vnd.ezpix-package'),
            'f'            => array('text/plain', 'text/x-fortran'),
            'f4v'          => array('video/x-f4v'),
            'f77'          => array('text/x-fortran'),
            'f90'          => array('text/plain', 'text/x-fortran'),
            'fbs'          => array('image/vnd.fastbidsheet'),
            'fcdt'         => array('application/vnd.adobe.formscentral.fcdt'),
            'fcs'          => array('application/vnd.isac.fcs'),
            'fdf'          => array('application/vnd.fdf'),
            'fe_launch'    => array('application/vnd.denovo.fcselayout-link'),
            'fg5'          => array('application/vnd.fujitsu.oasysgp'),
            'fgd'          => array('application/x-director'),
            'fh'           => array('image/x-freehand'),
            'fh4'          => array('image/x-freehand'),
            'fh5'          => array('image/x-freehand'),
            'fh7'          => array('image/x-freehand'),
            'fhc'          => array('image/x-freehand'),
            'fif'          => array('application/fractals', 'image/fif'),
            'fig'          => array('application/x-xfig'),
            'flac'         => array('audio/flac'),
            'fli'          => array('video/fli', 'video/x-fli'),
            'flo'          => array('application/vnd.micrografx.flo'),
            'flv'          => array('video/x-flv'),
            'flw'          => array('application/vnd.kde.kivio'),
            'flx'          => array('text/vnd.fmi.flexstor'),
            'fly'          => array('text/vnd.fly'),
            'fm'           => array('application/vnd.framemaker'),
            'fmf'          => array('video/x-atomic3d-feature'),
            'fnc'          => array('application/vnd.frogans.fnc'),
            'for'          => array('text/plain', 'text/x-fortran'),
            'fpx'          => array('image/vnd.fpx', 'image/vnd.net-fpx'),
            'frame'        => array('application/vnd.framemaker'),
            'frl'          => array('application/freeloader'),
            'fsc'          => array('application/vnd.fsc.weblaunch'),
            'fst'          => array('image/vnd.fst'),
            'ftc'          => array('application/vnd.fluxtime.clip'),
            'fti'          => array('application/vnd.anser-web-funds-transfer-initiation'),
            'funk'         => array('audio/make'),
            'fvt'          => array('video/vnd.fvt'),
            'fxp'          => array('application/vnd.adobe.fxp'),
            'fxpl'         => array('application/vnd.adobe.fxp'),
            'fzs'          => array('application/vnd.fuzzysheet'),
            'g'            => array('text/plain'),
            'g2w'          => array('application/vnd.geoplan'),
            'g3'           => array('image/g3fax'),
            'g3w'          => array('application/vnd.geospace'),
            'gac'          => array('application/vnd.groove-account'),
            'gam'          => array('application/x-tads'),
            'gbr'          => array('application/rpki-ghostbusters'),
            'gca'          => array('application/x-gca-compressed'),
            'gdl'          => array('model/vnd.gdl'),
            'geo'          => array('application/vnd.dynageo'),
            'gex'          => array('application/vnd.geometry-explorer'),
            'ggb'          => array('application/vnd.geogebra.file'),
            'ggt'          => array('application/vnd.geogebra.tool'),
            'ghf'          => array('application/vnd.groove-help'),
            'gif'          => array('image/gif'),
            'gim'          => array('application/vnd.groove-identity-message'),
            'gl'           => array('video/gl', 'video/x-gl'),
            'gml'          => array('application/gml+xml'),
            'gmx'          => array('application/vnd.gmx'),
            'gnumeric'     => array('application/x-gnumeric'),
            'gph'          => array('application/vnd.flographit'),
            'gpx'          => array('application/gpx+xml'),
            'gqf'          => array('application/vnd.grafeq'),
            'gqs'          => array('application/vnd.grafeq'),
            'gram'         => array('application/srgs'),
            'gramps'       => array('application/x-gramps-xml'),
            'gre'          => array('application/vnd.geometry-explorer'),
            'grv'          => array('application/vnd.groove-injector'),
            'grxml'        => array('application/srgs+xml'),
            'gsd'          => array('audio/x-gsm'),
            'gsf'          => array('application/x-font-ghostscript'),
            'gsm'          => array('audio/x-gsm'),
            'gsp'          => array('application/x-gsp'),
            'gss'          => array('application/x-gss'),
            'gtar'         => array('application/x-gtar'),
            'gtm'          => array('application/vnd.groove-tool-message'),
            'gtw'          => array('model/vnd.gtw'),
            'gv'           => array('text/vnd.graphviz'),
            'gxf'          => array('application/gxf'),
            'gxt'          => array('application/vnd.geonext'),
            'gz'           => array('application/x-compressed', 'application/x-gzip'),
            'gzip'         => array('application/x-gzip', 'multipart/x-gzip'),
            'h'            => array('text/plain', 'text/x-h'),
            'h261'         => array('video/h261'),
            'h263'         => array('video/h263'),
            'h264'         => array('video/h264'),
            'hal'          => array('application/vnd.hal+xml'),
            'hbci'         => array('application/vnd.hbci'),
            'hdf'          => array('application/x-hdf'),
            'help'         => array('application/x-helpfile'),
            'hgl'          => array('application/vnd.hp-hpgl'),
            'hh'           => array('text/plain', 'text/x-h'),
            'hlb'          => array('text/x-script'),
            'hlp'          => array('application/hlp', 'application/x-helpfile', 'application/x-winhelp'),
            'hpg'          => array('application/vnd.hp-hpgl'),
            'hpgl'         => array('application/vnd.hp-hpgl'),
            'hpid'         => array('application/vnd.hp-hpid'),
            'hps'          => array('application/vnd.hp-hps'),
            'hqx'          => array('application/binhex', 'application/binhex4', 'application/mac-binhex', 'application/mac-binhex40', 'application/x-binhex40', 'application/x-mac-binhex40'),
            'hta'          => array('application/hta'),
            'htc'          => array('text/x-component'),
            'htke'         => array('application/vnd.kenameaapp'),
            'htm'          => array('text/html'),
            'html'         => array('text/html'),
            'htmls'        => array('text/html'),
            'htt'          => array('text/webviewhtml'),
            'htx'          => array('text/html'),
            'hvd'          => array('application/vnd.yamaha.hv-dic'),
            'hvp'          => array('application/vnd.yamaha.hv-voice'),
            'hvs'          => array('application/vnd.yamaha.hv-script'),
            'i2g'          => array('application/vnd.intergeo'),
            'icc'          => array('application/vnd.iccprofile'),
            'ice'          => array('x-conference/x-cooltalk'),
            'icm'          => array('application/vnd.iccprofile'),
            'ico'          => array('image/x-icon'),
            'ics'          => array('text/calendar'),
            'idc'          => array('text/plain'),
            'ief'          => array('image/ief'),
            'iefs'         => array('image/ief'),
            'ifb'          => array('text/calendar'),
            'ifm'          => array('application/vnd.shana.informed.formdata'),
            'iges'         => array('application/iges', 'model/iges'),
            'igl'          => array('application/vnd.igloader'),
            'igm'          => array('application/vnd.insors.igm'),
            'igs'          => array('application/iges', 'model/iges'),
            'igx'          => array('application/vnd.micrografx.igx'),
            'iif'          => array('application/vnd.shana.informed.interchange'),
            'ima'          => array('application/x-ima'),
            'imap'         => array('application/x-httpd-imap'),
            'imp'          => array('application/vnd.accpac.simply.imp'),
            'ims'          => array('application/vnd.ms-ims'),
            'in'           => array('text/plain'),
            'inf'          => array('application/inf'),
            'ink'          => array('application/inkml+xml'),
            'inkml'        => array('application/inkml+xml'),
            'ins'          => array('application/x-internett-signup'),
            'install'      => array('application/x-install-instructions'),
            'iota'         => array('application/vnd.astraea-software.iota'),
            'ip'           => array('application/x-ip2'),
            'ipfix'        => array('application/ipfix'),
            'ipk'          => array('application/vnd.shana.informed.package'),
            'irm'          => array('application/vnd.ibm.rights-management'),
            'irp'          => array('application/vnd.irepository.package+xml'),
            'iso'          => array('application/x-iso9660-image'),
            'isu'          => array('video/x-isvideo'),
            'it'           => array('audio/it'),
            'itp'          => array('application/vnd.shana.informed.formtemplate'),
            'iv'           => array('application/x-inventor'),
            'ivp'          => array('application/vnd.immervision-ivp'),
            'ivr'          => array('i-world/i-vrml'),
            'ivu'          => array('application/vnd.immervision-ivu'),
            'ivy'          => array('application/x-livescreen'),
            'jad'          => array('text/vnd.sun.j2me.app-descriptor'),
            'jam'          => array('application/vnd.jam'),
            'jar'          => array('application/java-archive'),
            'jav'          => array('text/plain', 'text/x-java-source'),
            'java'         => array('text/plain', 'text/x-java-source'),
            'jcm'          => array('application/x-java-commerce'),
            'jfif'         => array('image/jpeg', 'image/pjpeg'),
            'jfif-tbnl'    => array('image/jpeg'),
            'jisp'         => array('application/vnd.jisp'),
            'jlt'          => array('application/vnd.hp-jlyt'),
            'jnlp'         => array('application/x-java-jnlp-file'),
            'joda'         => array('application/vnd.joost.joda-archive'),
            'jpe'          => array('image/jpeg', 'image/pjpeg'),
            'jpeg'         => array('image/jpeg', 'image/pjpeg'),
            'jpg'          => array('image/jpeg', 'image/pjpeg'),
            'jpgm'         => array('video/jpm'),
            'jpgv'         => array('video/jpeg'),
            'jpm'          => array('video/jpm'),
            'jps'          => array('image/x-jps'),
            'js'           => array('application/javascript'),
            'json'         => array('application/json', 'text/plain'),
            'jsonml'       => array('application/jsonml+json'),
            'jut'          => array('image/jutvision'),
            'kar'          => array('audio/midi', 'music/x-karaoke'),
            'karbon'       => array('application/vnd.kde.karbon'),
            'kfo'          => array('application/vnd.kde.kformula'),
            'kia'          => array('application/vnd.kidspiration'),
            'kil'          => array('application/x-killustrator'),
            'kml'          => array('application/vnd.google-earth.kml+xml'),
            'kmz'          => array('application/vnd.google-earth.kmz'),
            'kne'          => array('application/vnd.kinar'),
            'knp'          => array('application/vnd.kinar'),
            'kon'          => array('application/vnd.kde.kontour'),
            'kpr'          => array('application/vnd.kde.kpresenter'),
            'kpt'          => array('application/vnd.kde.kpresenter'),
            'kpxx'         => array('application/vnd.ds-keypoint'),
            'ksh'          => array('application/x-ksh', 'text/x-script.ksh'),
            'ksp'          => array('application/vnd.kde.kspread'),
            'ktr'          => array('application/vnd.kahootz'),
            'ktx'          => array('image/ktx'),
            'ktz'          => array('application/vnd.kahootz'),
            'kwd'          => array('application/vnd.kde.kword'),
            'kwt'          => array('application/vnd.kde.kword'),
            'la'           => array('audio/nspaudio', 'audio/x-nspaudio'),
            'lam'          => array('audio/x-liveaudio'),
            'lasxml'       => array('application/vnd.las.las+xml'),
            'latex'        => array('application/x-latex'),
            'lbd'          => array('application/vnd.llamagraphics.life-balance.desktop'),
            'lbe'          => array('application/vnd.llamagraphics.life-balance.exchange+xml'),
            'les'          => array('application/vnd.hhe.lesson-player'),
            'lha'          => array('application/lha', 'application/octet-stream', 'application/x-lha'),
            'lhx'          => array('application/octet-stream'),
            'link66'       => array('application/vnd.route66.link66+xml'),
            'list'         => array('text/plain'),
            'list3820'     => array('application/vnd.ibm.modcap'),
            'listafp'      => array('application/vnd.ibm.modcap'),
            'lma'          => array('audio/nspaudio', 'audio/x-nspaudio'),
            'lnk'          => array('application/x-ms-shortcut'),
            'log'          => array('text/plain'),
            'lostxml'      => array('application/lost+xml'),
            'lrf'          => array('application/octet-stream'),
            'lrm'          => array('application/vnd.ms-lrm'),
            'lsp'          => array('application/x-lisp', 'text/x-script.lisp'),
            'lst'          => array('text/plain'),
            'lsx'          => array('text/x-la-asf'),
            'ltf'          => array('application/vnd.frogans.ltf'),
            'ltx'          => array('application/x-latex'),
            'lua'          => array('text/x-lua'),
            'luac'         => array('application/x-lua-bytecode'),
            'lvp'          => array('audio/vnd.lucent.voice'),
            'lwp'          => array('application/vnd.lotus-wordpro'),
            'lzh'          => array('application/octet-stream', 'application/x-lzh'),
            'lzx'          => array('application/lzx', 'application/octet-stream', 'application/x-lzx'),
            'm'            => array('text/plain', 'text/x-m'),
            'm13'          => array('application/x-msmediaview'),
            'm14'          => array('application/x-msmediaview'),
            'm1v'          => array('video/mpeg'),
            'm21'          => array('application/mp21'),
            'm2a'          => array('audio/mpeg'),
            'm2v'          => array('video/mpeg'),
            'm3a'          => array('audio/mpeg'),
            'm3u'          => array('audio/x-mpegurl'),
            'm3u8'         => array('application/x-mpegURL'),
            'm4a'          => array('audio/mp4'),
            'm4p'          => array('application/mp4'),
            'm4u'          => array('video/vnd.mpegurl'),
            'm4v'          => array('video/x-m4v'),
            'ma'           => array('application/mathematica'),
            'mads'         => array('application/mads+xml'),
            'mag'          => array('application/vnd.ecowin.chart'),
            'maker'        => array('application/vnd.framemaker'),
            'man'          => array('text/troff'),
            'manifest'     => array('text/cache-manifest'),
            'map'          => array('application/x-navimap'),
            'mar'          => array('application/octet-stream'),
            'markdown'     => array('text/x-markdown'),
            'mathml'       => array('application/mathml+xml'),
            'mb'           => array('application/mathematica'),
            'mbd'          => array('application/mbedlet'),
            'mbk'          => array('application/vnd.mobius.mbk'),
            'mbox'         => array('application/mbox'),
            'mc'           => array('application/x-magic-cap-package-1.0'),
            'mc1'          => array('application/vnd.medcalcdata'),
            'mcd'          => array('application/mcad', 'application/x-mathcad'),
            'mcf'          => array('image/vasa', 'text/mcf'),
            'mcp'          => array('application/netmc'),
            'mcurl'        => array('text/vnd.curl.mcurl'),
            'md'           => array('text/x-markdown'),
            'mdb'          => array('application/x-msaccess'),
            'mdi'          => array('image/vnd.ms-modi'),
            'me'           => array('text/troff'),
            'mesh'         => array('model/mesh'),
            'meta4'        => array('application/metalink4+xml'),
            'metalink'     => array('application/metalink+xml'),
            'mets'         => array('application/mets+xml'),
            'mfm'          => array('application/vnd.mfmp'),
            'mft'          => array('application/rpki-manifest'),
            'mgp'          => array('application/vnd.osgeo.mapguide.package'),
            'mgz'          => array('application/vnd.proteus.magazine'),
            'mht'          => array('message/rfc822'),
            'mhtml'        => array('message/rfc822'),
            'mid'          => array('application/x-midi', 'audio/midi', 'audio/x-mid', 'audio/x-midi', 'music/crescendo', 'x-music/x-midi'),
            'midi'         => array('application/x-midi', 'audio/midi', 'audio/x-mid', 'audio/x-midi', 'music/crescendo', 'x-music/x-midi'),
            'mie'          => array('application/x-mie'),
            'mif'          => array('application/x-frame', 'application/x-mif'),
            'mime'         => array('message/rfc822', 'www/mime'),
            'mj2'          => array('video/mj2'),
            'mjf'          => array('audio/x-vnd.audioexplosion.mjuicemediafile'),
            'mjp2'         => array('video/mj2'),
            'mjpg'         => array('video/x-motion-jpeg'),
            'mk3d'         => array('video/x-matroska'),
            'mka'          => array('audio/x-matroska'),
            'mkd'          => array('text/x-markdown'),
            'mks'          => array('video/x-matroska'),
            'mkv'          => array('video/x-matroska'),
            'mlp'          => array('application/vnd.dolby.mlp'),
            'mm'           => array('application/base64', 'application/x-meme'),
            'mmd'          => array('application/vnd.chipnuts.karaoke-mmd'),
            'mme'          => array('application/base64'),
            'mmf'          => array('application/vnd.smaf'),
            'mmr'          => array('image/vnd.fujixerox.edmics-mmr'),
            'mng'          => array('video/x-mng'),
            'mny'          => array('application/x-msmoney'),
            'mobi'         => array('application/x-mobipocket-ebook'),
            'mod'          => array('audio/mod', 'audio/x-mod'),
            'mods'         => array('application/mods+xml'),
            'moov'         => array('video/quicktime'),
            'mov'          => array('video/quicktime'),
            'movie'        => array('video/x-sgi-movie'),
            'mp2'          => array('audio/mpeg', 'audio/x-mpeg', 'video/mpeg', 'video/x-mpeg', 'video/x-mpeq2a'),
            'mp21'         => array('application/mp21'),
            'mp2a'         => array('audio/mpeg'),
            'mp3'          => array('audio/mpeg3', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg'),
            'mp4'          => array('video/mp4'),
            'mp4a'         => array('audio/mp4'),
            'mp4s'         => array('application/mp4'),
            'mp4v'         => array('video/mp4'),
            'mpa'          => array('audio/mpeg', 'video/mpeg'),
            'mpc'          => array('application/vnd.mophun.certificate'),
            'mpe'          => array('video/mpeg'),
            'mpeg'         => array('video/mpeg'),
            'mpg'          => array('audio/mpeg', 'video/mpeg'),
            'mpg4'         => array('video/mp4'),
            'mpga'         => array('audio/mpeg'),
            'mpkg'         => array('application/vnd.apple.installer+xml'),
            'mpm'          => array('application/vnd.blueice.multipass'),
            'mpn'          => array('application/vnd.mophun.application'),
            'mpp'          => array('application/vnd.ms-project'),
            'mpt'          => array('application/vnd.ms-project'),
            'mpv'          => array('application/x-project'),
            'mpx'          => array('application/x-project'),
            'mpy'          => array('application/vnd.ibm.minipay'),
            'mqy'          => array('application/vnd.mobius.mqy'),
            'mrc'          => array('application/marc'),
            'mrcx'         => array('application/marcxml+xml'),
            'ms'           => array('text/troff'),
            'mscml'        => array('application/mediaservercontrol+xml'),
            'mseed'        => array('application/vnd.fdsn.mseed'),
            'mseq'         => array('application/vnd.mseq'),
            'msf'          => array('application/vnd.epson.msf'),
            'msh'          => array('model/mesh'),
            'msi'          => array('application/x-msdownload'),
            'msl'          => array('application/vnd.mobius.msl'),
            'msty'         => array('application/vnd.muvee.style'),
            'mts'          => array('model/vnd.mts'),
            'mus'          => array('application/vnd.musician'),
            'musicxml'     => array('application/vnd.recordare.musicxml+xml'),
            'mv'           => array('video/x-sgi-movie'),
            'mvb'          => array('application/x-msmediaview'),
            'mwf'          => array('application/vnd.mfer'),
            'mxf'          => array('application/mxf'),
            'mxl'          => array('application/vnd.recordare.musicxml'),
            'mxml'         => array('application/xv+xml'),
            'mxs'          => array('application/vnd.triscape.mxs'),
            'mxu'          => array('video/vnd.mpegurl'),
            'my'           => array('audio/make'),
            'mzz'          => array('application/x-vnd.audioexplosion.mzz'),
            'n-gage'       => array('application/vnd.nokia.n-gage.symbian.install'),
            'n3'           => array('text/n3'),
            'nap'          => array('image/naplps'),
            'naplps'       => array('image/naplps'),
            'nb'           => array('application/mathematica'),
            'nbp'          => array('application/vnd.wolfram.player'),
            'nc'           => array('application/x-netcdf'),
            'ncm'          => array('application/vnd.nokia.configuration-message'),
            'ncx'          => array('application/x-dtbncx+xml'),
            'nfo'          => array('text/x-nfo'),
            'ngdat'        => array('application/vnd.nokia.n-gage.data'),
            'nif'          => array('image/x-niff'),
            'niff'         => array('image/x-niff'),
            'nitf'         => array('application/vnd.nitf'),
            'nix'          => array('application/x-mix-transfer'),
            'nlu'          => array('application/vnd.neurolanguage.nlu'),
            'nml'          => array('application/vnd.enliven'),
            'nnd'          => array('application/vnd.noblenet-directory'),
            'nns'          => array('application/vnd.noblenet-sealer'),
            'nnw'          => array('application/vnd.noblenet-web'),
            'npx'          => array('image/vnd.net-fpx'),
            'nsc'          => array('application/x-conference'),
            'nsf'          => array('application/vnd.lotus-notes'),
            'ntf'          => array('application/vnd.nitf'),
            'nvd'          => array('application/x-navidoc'),
            'nws'          => array('message/rfc822'),
            'nzb'          => array('application/x-nzb'),
            'o'            => array('application/octet-stream'),
            'oa2'          => array('application/vnd.fujitsu.oasys2'),
            'oa3'          => array('application/vnd.fujitsu.oasys3'),
            'oas'          => array('application/vnd.fujitsu.oasys'),
            'obd'          => array('application/x-msbinder'),
            'obj'          => array('application/x-tgif'),
            'oda'          => array('application/oda'),
            'odb'          => array('application/vnd.oasis.opendocument.database'),
            'odc'          => array('application/vnd.oasis.opendocument.chart'),
            'odf'          => array('application/vnd.oasis.opendocument.formula'),
            'odft'         => array('application/vnd.oasis.opendocument.formula-template'),
            'odg'          => array('application/vnd.oasis.opendocument.graphics'),
            'odi'          => array('application/vnd.oasis.opendocument.image'),
            'odm'          => array('application/vnd.oasis.opendocument.text-master'),
            'odp'          => array('application/vnd.oasis.opendocument.presentation'),
            'ods'          => array('application/vnd.oasis.opendocument.spreadsheet'),
            'odt'          => array('application/vnd.oasis.opendocument.text'),
            'oga'          => array('audio/ogg'),
            'ogg'          => array('audio/ogg'),
            'ogv'          => array('video/ogg'),
            'ogx'          => array('application/ogg'),
            'omc'          => array('application/x-omc'),
            'omcd'         => array('application/x-omcdatamaker'),
            'omcr'         => array('application/x-omcregerator'),
            'omdoc'        => array('application/omdoc+xml'),
            'onepkg'       => array('application/onenote'),
            'onetmp'       => array('application/onenote'),
            'onetoc'       => array('application/onenote'),
            'onetoc2'      => array('application/onenote'),
            'opf'          => array('application/oebps-package+xml'),
            'opml'         => array('text/x-opml'),
            'oprc'         => array('application/vnd.palm'),
            'org'          => array('application/vnd.lotus-organizer'),
            'osf'          => array('application/vnd.yamaha.openscoreformat'),
            'osfpvg'       => array('application/vnd.yamaha.openscoreformat.osfpvg+xml'),
            'otc'          => array('application/vnd.oasis.opendocument.chart-template'),
            'otf'          => array('font/opentype'),
            'otg'          => array('application/vnd.oasis.opendocument.graphics-template'),
            'oth'          => array('application/vnd.oasis.opendocument.text-web'),
            'oti'          => array('application/vnd.oasis.opendocument.image-template'),
            'otm'          => array('application/vnd.oasis.opendocument.text-master'),
            'otp'          => array('application/vnd.oasis.opendocument.presentation-template'),
            'ots'          => array('application/vnd.oasis.opendocument.spreadsheet-template'),
            'ott'          => array('application/vnd.oasis.opendocument.text-template'),
            'oxps'         => array('application/oxps'),
            'oxt'          => array('application/vnd.openofficeorg.extension'),
            'p'            => array('text/x-pascal'),
            'p10'          => array('application/pkcs10', 'application/x-pkcs10'),
            'p12'          => array('application/pkcs-12', 'application/x-pkcs12'),
            'p7a'          => array('application/x-pkcs7-signature'),
            'p7b'          => array('application/x-pkcs7-certificates'),
            'p7c'          => array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
            'p7m'          => array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
            'p7r'          => array('application/x-pkcs7-certreqresp'),
            'p7s'          => array('application/pkcs7-signature'),
            'p8'           => array('application/pkcs8'),
            'part'         => array('application/pro_eng'),
            'pas'          => array('text/x-pascal'),
            'paw'          => array('application/vnd.pawaafile'),
            'pbd'          => array('application/vnd.powerbuilder6'),
            'pbm'          => array('image/x-portable-bitmap'),
            'pcap'         => array('application/vnd.tcpdump.pcap'),
            'pcf'          => array('application/x-font-pcf'),
            'pcl'          => array('application/vnd.hp-pcl', 'application/x-pcl'),
            'pclxl'        => array('application/vnd.hp-pclxl'),
            'pct'          => array('image/x-pict'),
            'pcurl'        => array('application/vnd.curl.pcurl'),
            'pcx'          => array('image/x-pcx'),
            'pdb'          => array('application/vnd.palm'),
            'pdf'          => array('application/pdf'),
            'pfa'          => array('application/x-font-type1'),
            'pfb'          => array('application/x-font-type1'),
            'pfm'          => array('application/x-font-type1'),
            'pfr'          => array('application/font-tdpfr'),
            'pfunk'        => array('audio/make'),
            'pfx'          => array('application/x-pkcs12'),
            'pgm'          => array('image/x-portable-graymap'),
            'pgn'          => array('application/x-chess-pgn'),
            'pgp'          => array('application/pgp-encrypted'),
            'php'          => array('text/x-php'),
            'pic'          => array('image/x-pict'),
            'pict'         => array('image/pict'),
            'pkg'          => array('application/octet-stream'),
            'pki'          => array('application/pkixcmp'),
            'pkipath'      => array('application/pkix-pkipath'),
            'pko'          => array('application/vnd.ms-pki.pko'),
            'pl'           => array('text/plain', 'text/x-script.perl'),
            'plb'          => array('application/vnd.3gpp.pic-bw-large'),
            'plc'          => array('application/vnd.mobius.plc'),
            'plf'          => array('application/vnd.pocketlearn'),
            'pls'          => array('application/pls+xml'),
            'plx'          => array('application/x-pixclscript'),
            'pm'           => array('image/x-xpixmap', 'text/x-script.perl-module'),
            'pm4'          => array('application/x-pagemaker'),
            'pm5'          => array('application/x-pagemaker'),
            'pml'          => array('application/vnd.ctc-posml'),
            'png'          => array('image/png'),
            'pnm'          => array('application/x-portable-anymap', 'image/x-portable-anymap'),
            'portpkg'      => array('application/vnd.macports.portpkg'),
            'pot'          => array('application/mspowerpoint', 'application/vnd.ms-powerpoint'),
            'potm'         => array('application/vnd.ms-powerpoint.template.macroenabled.12'),
            'potx'         => array('application/vnd.openxmlformats-officedocument.presentationml.template'),
            'pov'          => array('model/x-pov'),
            'ppa'          => array('application/vnd.ms-powerpoint'),
            'ppam'         => array('application/vnd.ms-powerpoint.addin.macroenabled.12'),
            'ppd'          => array('application/vnd.cups-ppd'),
            'ppm'          => array('image/x-portable-pixmap'),
            'pps'          => array('application/mspowerpoint', 'application/vnd.ms-powerpoint'),
            'ppsm'         => array('application/vnd.ms-powerpoint.slideshow.macroenabled.12'),
            'ppsx'         => array('application/vnd.openxmlformats-officedocument.presentationml.slideshow'),
            'ppt'          => array('application/mspowerpoint', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/x-mspowerpoint'),
            'pptm'         => array('application/vnd.ms-powerpoint.presentation.macroenabled.12'),
            'pptx'         => array('application/vnd.openxmlformats-officedocument.presentationml.presentation'),
            'ppz'          => array('application/mspowerpoint'),
            'pqa'          => array('application/vnd.palm'),
            'prc'          => array('application/x-mobipocket-ebook'),
            'pre'          => array('application/vnd.lotus-freelance'),
            'prf'          => array('application/pics-rules'),
            'prt'          => array('application/pro_eng'),
            'ps'           => array('application/postscript'),
            'psb'          => array('application/vnd.3gpp.pic-bw-small'),
            'psd'          => array('image/vnd.adobe.photoshop'),
            'psf'          => array('application/x-font-linux-psf'),
            'pskcxml'      => array('application/pskc+xml'),
            'ptid'         => array('application/vnd.pvi.ptid1'),
            'pub'          => array('application/x-mspublisher'),
            'pvb'          => array('application/vnd.3gpp.pic-bw-var'),
            'pvu'          => array('paleovu/x-pv'),
            'pwn'          => array('application/vnd.3m.post-it-notes'),
            'pwz'          => array('application/vnd.ms-powerpoint'),
            'py'           => array('text/x-script.phyton'),
            'pya'          => array('audio/vnd.ms-playready.media.pya'),
            'pyc'          => array('applicaiton/x-bytecode.python'),
            'pyo'          => array('application/x-python-code'),
            'pyv'          => array('video/vnd.ms-playready.media.pyv'),
            'qam'          => array('application/vnd.epson.quickanime'),
            'qbo'          => array('application/vnd.intu.qbo'),
            'qcp'          => array('audio/vnd.qcelp'),
            'qd3'          => array('x-world/x-3dmf'),
            'qd3d'         => array('x-world/x-3dmf'),
            'qfx'          => array('application/vnd.intu.qfx'),
            'qif'          => array('image/x-quicktime'),
            'qps'          => array('application/vnd.publishare-delta-tree'),
            'qt'           => array('video/quicktime'),
            'qtc'          => array('video/x-qtc'),
            'qti'          => array('image/x-quicktime'),
            'qtif'         => array('image/x-quicktime'),
            'qwd'          => array('application/vnd.quark.quarkxpress'),
            'qwt'          => array('application/vnd.quark.quarkxpress'),
            'qxb'          => array('application/vnd.quark.quarkxpress'),
            'qxd'          => array('application/vnd.quark.quarkxpress'),
            'qxl'          => array('application/vnd.quark.quarkxpress'),
            'qxt'          => array('application/vnd.quark.quarkxpress'),
            'ra'           => array('audio/x-pn-realaudio', 'audio/x-pn-realaudio-plugin', 'audio/x-realaudio'),
            'ram'          => array('audio/x-pn-realaudio'),
            'rar'          => array('application/x-rar-compressed'),
            'ras'          => array('application/x-cmu-raster', 'image/cmu-raster', 'image/x-cmu-raster'),
            'rast'         => array('image/cmu-raster'),
            'rcprofile'    => array('application/vnd.ipunplugged.rcprofile'),
            'rdf'          => array('application/rdf+xml'),
            'rdz'          => array('application/vnd.data-vision.rdz'),
            'rep'          => array('application/vnd.businessobjects'),
            'res'          => array('application/x-dtbresource+xml'),
            'rexx'         => array('text/x-script.rexx'),
            'rf'           => array('image/vnd.rn-realflash'),
            'rgb'          => array('image/x-rgb'),
            'rif'          => array('application/reginfo+xml'),
            'rip'          => array('audio/vnd.rip'),
            'ris'          => array('application/x-research-info-systems'),
            'rl'           => array('application/resource-lists+xml'),
            'rlc'          => array('image/vnd.fujixerox.edmics-rlc'),
            'rld'          => array('application/resource-lists-diff+xml'),
            'rm'           => array('application/vnd.rn-realmedia', 'audio/x-pn-realaudio'),
            'rmi'          => array('audio/midi'),
            'rmm'          => array('audio/x-pn-realaudio'),
            'rmp'          => array('audio/x-pn-realaudio', 'audio/x-pn-realaudio-plugin'),
            'rms'          => array('application/vnd.jcp.javame.midlet-rms'),
            'rmvb'         => array('application/vnd.rn-realmedia-vbr'),
            'rnc'          => array('application/relax-ng-compact-syntax'),
            'rng'          => array('application/ringing-tones', 'application/vnd.nokia.ringing-tone'),
            'rnx'          => array('application/vnd.rn-realplayer'),
            'roa'          => array('application/rpki-roa'),
            'roff'         => array('text/troff'),
            'rp'           => array('image/vnd.rn-realpix'),
            'rp9'          => array('application/vnd.cloanto.rp9'),
            'rpm'          => array('audio/x-pn-realaudio-plugin'),
            'rpss'         => array('application/vnd.nokia.radio-presets'),
            'rpst'         => array('application/vnd.nokia.radio-preset'),
            'rq'           => array('application/sparql-query'),
            'rs'           => array('application/rls-services+xml'),
            'rsd'          => array('application/rsd+xml'),
            'rss'          => array('application/rss+xml'),
            'rt'           => array('text/richtext', 'text/vnd.rn-realtext'),
            'rtf'          => array('application/rtf', 'application/x-rtf', 'text/richtext'),
            'rtx'          => array('application/rtf', 'text/richtext'),
            'rv'           => array('video/vnd.rn-realvideo'),
            's'            => array('text/x-asm'),
            's3m'          => array('audio/s3m'),
            'saf'          => array('application/vnd.yamaha.smaf-audio'),
            'saveme'       => array('aapplication/octet-stream'),
            'sbk'          => array('application/x-tbook'),
            'sbml'         => array('application/sbml+xml'),
            'sc'           => array('application/vnd.ibm.secure-container'),
            'scd'          => array('application/x-msschedule'),
            'scm'          => array('application/x-lotusscreencam', 'text/x-script.guile', 'text/x-script.scheme', 'video/x-scm'),
            'scq'          => array('application/scvp-cv-request'),
            'scs'          => array('application/scvp-cv-response'),
            'scurl'        => array('text/vnd.curl.scurl'),
            'sda'          => array('application/vnd.stardivision.draw'),
            'sdc'          => array('application/vnd.stardivision.calc'),
            'sdd'          => array('application/vnd.stardivision.impress'),
            'sdkd'         => array('application/vnd.solent.sdkm+xml'),
            'sdkm'         => array('application/vnd.solent.sdkm+xml'),
            'sdml'         => array('text/plain'),
            'sdp'          => array('application/sdp', 'application/x-sdp'),
            'sdr'          => array('application/sounder'),
            'sdw'          => array('application/vnd.stardivision.writer'),
            'sea'          => array('application/sea', 'application/x-sea'),
            'see'          => array('application/vnd.seemail'),
            'seed'         => array('application/vnd.fdsn.seed'),
            'sema'         => array('application/vnd.sema'),
            'semd'         => array('application/vnd.semd'),
            'semf'         => array('application/vnd.semf'),
            'ser'          => array('application/java-serialized-object'),
            'set'          => array('application/set'),
            'setpay'       => array('application/set-payment-initiation'),
            'setreg'       => array('application/set-registration-initiation'),
            'sfd-hdstx'    => array('application/vnd.hydrostatix.sof-data'),
            'sfs'          => array('application/vnd.spotfire.sfs'),
            'sfv'          => array('text/x-sfv'),
            'sgi'          => array('image/sgi'),
            'sgl'          => array('application/vnd.stardivision.writer-global'),
            'sgm'          => array('text/sgml', 'text/x-sgml'),
            'sgml'         => array('text/sgml', 'text/x-sgml'),
            'sh'           => array('application/x-bsh', 'application/x-sh', 'application/x-shar', 'text/x-script.sh'),
            'shar'         => array('application/x-bsh', 'application/x-shar'),
            'shf'          => array('application/shf+xml'),
            'shtml'        => array('text/html', 'text/x-server-parsed-html'),
            'si'           => array('text/vnd.wap.si'),
            'sic'          => array('application/vnd.wap.sic'),
            'sid'          => array('image/x-mrsid-image'),
            'sig'          => array('application/pgp-signature'),
            'sil'          => array('audio/silk'),
            'silo'         => array('model/mesh'),
            'sis'          => array('application/vnd.symbian.install'),
            'sisx'         => array('application/vnd.symbian.install'),
            'sit'          => array('application/x-sit', 'application/x-stuffit'),
            'sitx'         => array('application/x-stuffitx'),
            'skd'          => array('application/vnd.koan'),
            'skm'          => array('application/vnd.koan'),
            'skp'          => array('application/vnd.koan'),
            'skt'          => array('application/vnd.koan'),
            'sl'           => array('application/x-seelogo'),
            'slc'          => array('application/vnd.wap.slc'),
            'sldm'         => array('application/vnd.ms-powerpoint.slide.macroenabled.12'),
            'sldx'         => array('application/vnd.openxmlformats-officedocument.presentationml.slide'),
            'slt'          => array('application/vnd.epson.salt'),
            'sm'           => array('application/vnd.stepmania.stepchart'),
            'smf'          => array('application/vnd.stardivision.math'),
            'smi'          => array('application/smil+xml'),
            'smil'         => array('application/smil+xml'),
            'smv'          => array('video/x-smv'),
            'smzip'        => array('application/vnd.stepmania.package'),
            'snd'          => array('audio/basic', 'audio/x-adpcm'),
            'snf'          => array('application/x-font-snf'),
            'so'           => array('application/octet-stream'),
            'sol'          => array('application/solids'),
            'spc'          => array('application/x-pkcs7-certificates', 'text/x-speech'),
            'spf'          => array('application/vnd.yamaha.smaf-phrase'),
            'spl'          => array('application/x-futuresplash'),
            'spot'         => array('text/vnd.in3d.spot'),
            'spp'          => array('application/scvp-vp-response'),
            'spq'          => array('application/scvp-vp-request'),
            'spr'          => array('application/x-sprite'),
            'sprite'       => array('application/x-sprite'),
            'spx'          => array('audio/ogg'),
            'sql'          => array('application/x-sql'),
            'src'          => array('application/x-wais-source'),
            'srt'          => array('application/x-subrip'),
            'sru'          => array('application/sru+xml'),
            'srx'          => array('application/sparql-results+xml'),
            'ssdl'         => array('application/ssdl+xml'),
            'sse'          => array('application/vnd.kodak-descriptor'),
            'ssf'          => array('application/vnd.epson.ssf'),
            'ssi'          => array('text/x-server-parsed-html'),
            'ssm'          => array('application/streamingmedia'),
            'ssml'         => array('application/ssml+xml'),
            'sst'          => array('application/vnd.ms-pki.certstore'),
            'st'           => array('application/vnd.sailingtracker.track'),
            'stc'          => array('application/vnd.sun.xml.calc.template'),
            'std'          => array('application/vnd.sun.xml.draw.template'),
            'step'         => array('application/step'),
            'stf'          => array('application/vnd.wt.stf'),
            'sti'          => array('application/vnd.sun.xml.impress.template'),
            'stk'          => array('application/hyperstudio'),
            'stl'          => array('application/sla', 'application/vnd.ms-pki.stl', 'application/x-navistyle'),
            'stp'          => array('application/step'),
            'str'          => array('application/vnd.pg.format'),
            'stw'          => array('application/vnd.sun.xml.writer.template'),
            'sub'          => array('text/vnd.dvb.subtitle'),
            'sus'          => array('application/vnd.sus-calendar'),
            'susp'         => array('application/vnd.sus-calendar'),
            'sv4cpio'      => array('application/x-sv4cpio'),
            'sv4crc'       => array('application/x-sv4crc'),
            'svc'          => array('application/vnd.dvb.service'),
            'svd'          => array('application/vnd.svd'),
            'svf'          => array('image/vnd.dwg', 'image/x-dwg'),
            'svg'          => array('image/svg+xml'),
            'svgz'         => array('image/svg+xml'),
            'svr'          => array('application/x-world', 'x-world/x-svr'),
            'swa'          => array('application/x-director'),
            'swf'          => array('application/x-shockwave-flash'),
            'swi'          => array('application/vnd.aristanetworks.swi'),
            'sxc'          => array('application/vnd.sun.xml.calc'),
            'sxd'          => array('application/vnd.sun.xml.draw'),
            'sxg'          => array('application/vnd.sun.xml.writer.global'),
            'sxi'          => array('application/vnd.sun.xml.impress'),
            'sxm'          => array('application/vnd.sun.xml.math'),
            'sxw'          => array('application/vnd.sun.xml.writer'),
            't'            => array('text/troff'),
            't3'           => array('application/x-t3vm-image'),
            'taglet'       => array('application/vnd.mynfc'),
            'talk'         => array('text/x-speech'),
            'tao'          => array('application/vnd.tao.intent-module-archive'),
            'tar'          => array('application/x-tar'),
            'tbk'          => array('application/toolbook', 'application/x-tbook'),
            'tcap'         => array('application/vnd.3gpp2.tcap'),
            'tcl'          => array('application/x-tcl', 'text/x-script.tcl'),
            'tcsh'         => array('text/x-script.tcsh'),
            'teacher'      => array('application/vnd.smart.teacher'),
            'tei'          => array('application/tei+xml'),
            'teicorpus'    => array('application/tei+xml'),
            'tex'          => array('application/x-tex'),
            'texi'         => array('application/x-texinfo'),
            'texinfo'      => array('application/x-texinfo'),
            'text'         => array('application/plain', 'text/plain'),
            'tfi'          => array('application/thraud+xml'),
            'tfm'          => array('application/x-tex-tfm'),
            'tga'          => array('image/x-tga'),
            'tgz'          => array('application/gnutar', 'application/x-compressed'),
            'thmx'         => array('application/vnd.ms-officetheme'),
            'tif'          => array('image/tiff', 'image/x-tiff'),
            'tiff'         => array('image/tiff', 'image/x-tiff'),
            'tmo'          => array('application/vnd.tmobile-livetv'),
            'torrent'      => array('application/x-bittorrent'),
            'tpl'          => array('application/vnd.groove-tool-template'),
            'tpt'          => array('application/vnd.trid.tpt'),
            'tr'           => array('text/troff'),
            'tra'          => array('application/vnd.trueapp'),
            'trm'          => array('application/x-msterminal'),
            'ts'           => array('video/MP2T'),
            'tsd'          => array('application/timestamped-data'),
            'tsi'          => array('audio/tsp-audio'),
            'tsp'          => array('application/dsptype', 'audio/tsplayer'),
            'tsv'          => array('text/tab-separated-values'),
            'ttc'          => array('application/x-font-ttf'),
            'ttf'          => array('application/x-font-ttf'),
            'ttl'          => array('text/turtle'),
            'turbot'       => array('image/florian'),
            'twd'          => array('application/vnd.simtech-mindmapper'),
            'twds'         => array('application/vnd.simtech-mindmapper'),
            'txd'          => array('application/vnd.genomatix.tuxedo'),
            'txf'          => array('application/vnd.mobius.txf'),
            'txt'          => array('text/plain'),
            'u32'          => array('application/x-authorware-bin'),
            'udeb'         => array('application/x-debian-package'),
            'ufd'          => array('application/vnd.ufdl'),
            'ufdl'         => array('application/vnd.ufdl'),
            'uil'          => array('text/x-uil'),
            'ulx'          => array('application/x-glulx'),
            'umj'          => array('application/vnd.umajin'),
            'uni'          => array('text/uri-list'),
            'unis'         => array('text/uri-list'),
            'unityweb'     => array('application/vnd.unity'),
            'unv'          => array('application/i-deas'),
            'uoml'         => array('application/vnd.uoml+xml'),
            'uri'          => array('text/uri-list'),
            'uris'         => array('text/uri-list'),
            'urls'         => array('text/uri-list'),
            'ustar'        => array('application/x-ustar', 'multipart/x-ustar'),
            'utz'          => array('application/vnd.uiq.theme'),
            'uu'           => array('application/octet-stream', 'text/x-uuencode'),
            'uue'          => array('text/x-uuencode'),
            'uva'          => array('audio/vnd.dece.audio'),
            'uvd'          => array('application/vnd.dece.data'),
            'uvf'          => array('application/vnd.dece.data'),
            'uvg'          => array('image/vnd.dece.graphic'),
            'uvh'          => array('video/vnd.dece.hd'),
            'uvi'          => array('image/vnd.dece.graphic'),
            'uvm'          => array('video/vnd.dece.mobile'),
            'uvp'          => array('video/vnd.dece.pd'),
            'uvs'          => array('video/vnd.dece.sd'),
            'uvt'          => array('application/vnd.dece.ttml+xml'),
            'uvu'          => array('video/vnd.uvvu.mp4'),
            'uvv'          => array('video/vnd.dece.video'),
            'uvva'         => array('audio/vnd.dece.audio'),
            'uvvd'         => array('application/vnd.dece.data'),
            'uvvf'         => array('application/vnd.dece.data'),
            'uvvg'         => array('image/vnd.dece.graphic'),
            'uvvh'         => array('video/vnd.dece.hd'),
            'uvvi'         => array('image/vnd.dece.graphic'),
            'uvvm'         => array('video/vnd.dece.mobile'),
            'uvvp'         => array('video/vnd.dece.pd'),
            'uvvs'         => array('video/vnd.dece.sd'),
            'uvvt'         => array('application/vnd.dece.ttml+xml'),
            'uvvu'         => array('video/vnd.uvvu.mp4'),
            'uvvv'         => array('video/vnd.dece.video'),
            'uvvx'         => array('application/vnd.dece.unspecified'),
            'uvvz'         => array('application/vnd.dece.zip'),
            'uvx'          => array('application/vnd.dece.unspecified'),
            'uvz'          => array('application/vnd.dece.zip'),
            'vcard'        => array('text/vcard'),
            'vcd'          => array('application/x-cdlink'),
            'vcf'          => array('text/x-vcard'),
            'vcg'          => array('application/vnd.groove-vcard'),
            'vcs'          => array('text/x-vcalendar'),
            'vcx'          => array('application/vnd.vcx'),
            'vda'          => array('application/vda'),
            'vdo'          => array('video/vdo'),
            'vew'          => array('application/groupwise'),
            'vis'          => array('application/vnd.visionary'),
            'viv'          => array('video/vivo', 'video/vnd.vivo'),
            'vivo'         => array('video/vivo', 'video/vnd.vivo'),
            'vmd'          => array('application/vocaltec-media-desc'),
            'vmf'          => array('application/vocaltec-media-file'),
            'vob'          => array('video/x-ms-vob'),
            'voc'          => array('audio/voc', 'audio/x-voc'),
            'vor'          => array('application/vnd.stardivision.writer'),
            'vos'          => array('video/vosaic'),
            'vox'          => array('application/x-authorware-bin'),
            'vqe'          => array('audio/x-twinvq-plugin'),
            'vqf'          => array('audio/x-twinvq'),
            'vql'          => array('audio/x-twinvq-plugin'),
            'vrml'         => array('application/x-vrml', 'model/vrml', 'x-world/x-vrml'),
            'vrt'          => array('x-world/x-vrt'),
            'vsd'          => array('application/vnd.visio'),
            'vsf'          => array('application/vnd.vsf'),
            'vss'          => array('application/vnd.visio'),
            'vst'          => array('application/vnd.visio'),
            'vsw'          => array('application/vnd.visio'),
            'vtt'          => array('text/vtt'),
            'vtu'          => array('model/vnd.vtu'),
            'vxml'         => array('application/voicexml+xml'),
            'w3d'          => array('application/x-director'),
            'w60'          => array('application/wordperfect6.0'),
            'w61'          => array('application/wordperfect6.1'),
            'w6w'          => array('application/msword'),
            'wad'          => array('application/x-doom'),
            'wav'          => array('audio/wav', 'audio/x-wav'),
            'wax'          => array('audio/x-ms-wax'),
            'wb1'          => array('application/x-qpro'),
            'wbmp'         => array('image/vnd.wap.wbmp'),
            'wbs'          => array('application/vnd.criticaltools.wbs+xml'),
            'wbxml'        => array('application/vnd.wap.wbxml'),
            'wcm'          => array('application/vnd.ms-works'),
            'wdb'          => array('application/vnd.ms-works'),
            'wdp'          => array('image/vnd.ms-photo'),
            'web'          => array('application/vnd.xara'),
            'weba'         => array('audio/webm'),
            'webapp'       => array('application/x-web-app-manifest+json'),
            'webm'         => array('video/webm'),
            'webp'         => array('image/webp'),
            'wg'           => array('application/vnd.pmi.widget'),
            'wgt'          => array('application/widget'),
            'wiz'          => array('application/msword'),
            'wk1'          => array('application/x-123'),
            'wks'          => array('application/vnd.ms-works'),
            'wm'           => array('video/x-ms-wm'),
            'wma'          => array('audio/x-ms-wma'),
            'wmd'          => array('application/x-ms-wmd'),
            'wmf'          => array('application/x-msmetafile'),
            'wml'          => array('text/vnd.wap.wml'),
            'wmlc'         => array('application/vnd.wap.wmlc'),
            'wmls'         => array('text/vnd.wap.wmlscript'),
            'wmlsc'        => array('application/vnd.wap.wmlscriptc'),
            'wmv'          => array('video/x-ms-wmv'),
            'wmx'          => array('video/x-ms-wmx'),
            'wmz'          => array('application/x-msmetafile'),
            'woff'         => array('application/x-font-woff'),
            'word'         => array('application/msword'),
            'wp'           => array('application/wordperfect'),
            'wp5'          => array('application/wordperfect', 'application/wordperfect6.0'),
            'wp6'          => array('application/wordperfect'),
            'wpd'          => array('application/wordperfect', 'application/x-wpwin'),
            'wpl'          => array('application/vnd.ms-wpl'),
            'wps'          => array('application/vnd.ms-works'),
            'wq1'          => array('application/x-lotus'),
            'wqd'          => array('application/vnd.wqd'),
            'wri'          => array('application/mswrite', 'application/x-wri'),
            'wrl'          => array('application/x-world', 'model/vrml', 'x-world/x-vrml'),
            'wrz'          => array('model/vrml', 'x-world/x-vrml'),
            'wsc'          => array('text/scriplet'),
            'wsdl'         => array('application/wsdl+xml'),
            'wspolicy'     => array('application/wspolicy+xml'),
            'wsrc'         => array('application/x-wais-source'),
            'wtb'          => array('application/vnd.webturbo'),
            'wtk'          => array('application/x-wintalk'),
            'wvx'          => array('video/x-ms-wvx'),
            'x-png'        => array('image/png'),
            'x32'          => array('application/x-authorware-bin'),
            'x3d'          => array('model/x3d+xml'),
            'x3db'         => array('model/x3d+binary'),
            'x3dbz'        => array('model/x3d+binary'),
            'x3dv'         => array('model/x3d+vrml'),
            'x3dvz'        => array('model/x3d+vrml'),
            'x3dz'         => array('model/x3d+xml'),
            'xaml'         => array('application/xaml+xml'),
            'xap'          => array('application/x-silverlight-app'),
            'xar'          => array('application/vnd.xara'),
            'xbap'         => array('application/x-ms-xbap'),
            'xbd'          => array('application/vnd.fujixerox.docuworks.binder'),
            'xbm'          => array('image/x-xbitmap', 'image/x-xbm', 'image/xbm'),
            'xdf'          => array('application/xcap-diff+xml'),
            'xdm'          => array('application/vnd.syncml.dm+xml'),
            'xdp'          => array('application/vnd.adobe.xdp+xml'),
            'xdr'          => array('video/x-amt-demorun'),
            'xdssc'        => array('application/dssc+xml'),
            'xdw'          => array('application/vnd.fujixerox.docuworks'),
            'xenc'         => array('application/xenc+xml'),
            'xer'          => array('application/patch-ops-error+xml'),
            'xfdf'         => array('application/vnd.adobe.xfdf'),
            'xfdl'         => array('application/vnd.xfdl'),
            'xgz'          => array('xgl/drawing'),
            'xht'          => array('application/xhtml+xml'),
            'xhtml'        => array('application/xhtml+xml'),
            'xhvml'        => array('application/xv+xml'),
            'xif'          => array('image/vnd.xiff'),
            'xl'           => array('application/excel'),
            'xla'          => array('application/excel', 'application/x-excel', 'application/x-msexcel'),
            'xlam'         => array('application/vnd.ms-excel.addin.macroenabled.12'),
            'xlb'          => array('application/excel', 'application/vnd.ms-excel', 'application/x-excel'),
            'xlc'          => array('application/excel', 'application/vnd.ms-excel', 'application/x-excel'),
            'xld'          => array('application/excel', 'application/x-excel'),
            'xlf'          => array('application/x-xliff+xml'),
            'xlk'          => array('application/excel', 'application/x-excel'),
            'xll'          => array('application/excel', 'application/vnd.ms-excel', 'application/x-excel'),
            'xlm'          => array('application/excel', 'application/vnd.ms-excel', 'application/x-excel'),
            'xls'          => array('application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel'),
            'xlsb'         => array('application/vnd.ms-excel.sheet.binary.macroenabled.12'),
            'xlsm'         => array('application/vnd.ms-excel.sheet.macroenabled.12'),
            'xlsx'         => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
            'xlt'          => array('application/excel', 'application/x-excel'),
            'xltm'         => array('application/vnd.ms-excel.template.macroenabled.12'),
            'xltx'         => array('application/vnd.openxmlformats-officedocument.spreadsheetml.template'),
            'xlv'          => array('application/excel', 'application/x-excel'),
            'xlw'          => array('application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel'),
            'xm'           => array('audio/xm'),
            'xml'          => array('application/xml', 'text/xml'),
            'xmz'          => array('xgl/movie'),
            'xo'           => array('application/vnd.olpc-sugar'),
            'xop'          => array('application/xop+xml'),
            'xpdl'         => array('application/xml'),
            'xpi'          => array('application/x-xpinstall'),
            'xpix'         => array('application/x-vnd.ls-xpix'),
            'xpl'          => array('application/xproc+xml'),
            'xpm'          => array('image/x-xpixmap', 'image/xpm'),
            'xpr'          => array('application/vnd.is-xpr'),
            'xps'          => array('application/vnd.ms-xpsdocument'),
            'xpw'          => array('application/vnd.intercon.formnet'),
            'xpx'          => array('application/vnd.intercon.formnet'),
            'xsl'          => array('application/xml'),
            'xslt'         => array('application/xslt+xml'),
            'xsm'          => array('application/vnd.syncml+xml'),
            'xspf'         => array('application/xspf+xml'),
            'xsr'          => array('video/x-amt-showrun'),
            'xul'          => array('application/vnd.mozilla.xul+xml'),
            'xvm'          => array('application/xv+xml'),
            'xvml'         => array('application/xv+xml'),
            'xwd'          => array('image/x-xwd', 'image/x-xwindowdump'),
            'xyz'          => array('chemical/x-xyz'),
            'xz'           => array('application/x-xz'),
            'yang'         => array('application/yang'),
            'yin'          => array('application/yin+xml'),
            'z'            => array('application/x-compress', 'application/x-compressed'),
            'z1'           => array('application/x-zmachine'),
            'z2'           => array('application/x-zmachine'),
            'z3'           => array('application/x-zmachine'),
            'z4'           => array('application/x-zmachine'),
            'z5'           => array('application/x-zmachine'),
            'z6'           => array('application/x-zmachine'),
            'z7'           => array('application/x-zmachine'),
            'z8'           => array('application/x-zmachine'),
            'zaz'          => array('application/vnd.zzazz.deck+xml'),
            'zip'          => array('application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'),
            'zir'          => array('application/vnd.zul'),
            'zirz'         => array('application/vnd.zul'),
            'zmm'          => array('application/vnd.handheld-entertainment+xml'),
            'zoo'          => array('application/octet-stream'),
            'zsh'          => array('text/x-script.zsh'),
            '123'          => array('application/vnd.lotus-1-2-3'),
        );

        foreach ($all_mimes as $key => $value) {
            if ($ext == $key) {
                return $value; //array
            }
        }
        return array();
    }

}
