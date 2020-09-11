<?php

namespace XoopsModules\Tadtools;

use Xmf\Request;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\Utility;

// declare (strict_types = 1);
/*
$TadUpFiles->set_var("permission", true); //要使用權限控管時才需要

//加入上傳檔案MIME types篩選
//新增ext2mime函數，可將副檔名轉換為MIME types，提供給$file_handle->allowed使用
//$allow = "doc;docx;pdf"，利用分號;區分允許上傳的檔案類型
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false,$return_col,$allow,$deny);

//上傳表單（enctype='multipart/form-data'）
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_var('require', true);  //必填
$TadUpFiles->set_var("show_tip", false); //不顯示提示
$TadUpFiles->set_col($col_name,$col_sn); //若 $show_list_del_file ==true 時一定要有
$upform=$TadUpFiles->upform($show_edit,$upname,$maxlength,$show_list_del_file,$only_type,$thumb);

//儲存：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//儲存單一檔案：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_one_file($_FILES['upfile']['name'],$_FILES['upfile']['tmp_name'],$_FILES['upfile']['type'],$_FILES['upfile']['size'],$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//複製匯入單一檔案：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->import_one_file($from="",$new_filename="",$main_width="1280",$thumb_width="120",$files_sn="" ,$desc="" ,$safe_name=false ,$hash=false);

//顯示可刪除列表
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->set_thumb($thumb_width="120px",$thumb_height="70px",$thumb_bg_color="#000");
$list_del_file=$TadUpFiles->list_del_file($show_edit=false,$mode);

//顯示：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="/file",$image="/image",$thumbs="/image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$show_files=$TadUpFiles->show_files($upname,true,NULL,false,false,NULL,NULL,false);
//上傳表單name, 是否縮圖, 顯示模式 (small,filename,file_text_url,file_url,app), 顯示描述, 顯示下載次數, 數量限制, 自訂路徑, 加密, 自動播放時間(0 or 3000)
//show_files($upname="",$thumb=true,$show_mode="",$show_description=false,$show_dl=false,$limit=NULL,$path=NULL,$hash=false,$playSpeed=5000)

//下載檔案
case "tufdl":
$files_sn=isset($_GET['files_sn'])?intval($_GET['files_sn']):"";
$TadUpFiles->add_file_counter($files_sn,$hash=false,$force=false);
exit;
break;

//刪除：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
//$TadUpFiles->set_col($col_name,$col_sn,$sort); //若要整個刪除
$TadUpFiles->del_files($files_sn);

//單一檔案圖檔真實路徑：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_pic_file($showkind[,$kind='url',$files_sn]); //thumb 小圖, images 大圖（default）, file 檔案

//改檔名
$TadUpFiles->rename_file($files_sn,$new_name);

檔案數量：
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn);
$TadUpFiles->get_file_amount();

//取得檔案資訊
use XoopsModules\Tadtools\TadUpFiles;
$TadUpFiles=new TadUpFiles("模組名稱");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->get_file($files_sn="",$limit=NULL,$path,$hash);

//取得檔案資訊 for smarty
use XoopsModules\Tadtools\TadUpFiles;
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
`upload_date` datetime NOT NULL COMMENT '上傳時間',
`uid` mediumint(8) unsigned NOT NULL default 0 COMMENT '上傳者',
`tag` varchar(255) NOT NULL default '' COMMENT '註記',
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
    public $dir;
    public $db_prefix;
    public $hash;
    public $filename;
    public $file_dir = '/file';
    public $image_dir = '/image';
    public $thumbs_dir = '/image/.thumbs';
    public $permission = false;

    public $thumb_width = '120px';
    public $thumb_height = '70px';
    public $thumb_bg_color = 'transparent';
    public $thumb_position = 'center center';
    public $thumb_repeat = 'no-repeat';
    public $thumb_size = 'contain';
    public $show_width = '120px';
    public $show_height = '120px';
    public $background_size = 'contain';

    public $showFancyBox = true;
    public $download_url = '';
    public $files_sn;
    public $filename_size = '1em';

    public $show_tip = true;

    public $auto_charset;
    public $other_css;
    public $thumb_css;

    public $tag = '';
    public $require = '';

    public function __construct($dir = '', $subdir = '', $file = '/file', $image = '/image', $thumbs = '/image/.thumbs')
    {
        global $xoopsDB;
        if (!empty($dir)) {
            $this->set_prefix($dir);
        }

        if (!empty($subdir)) {
            $this->set_dir('subdir', $subdir);
        }

        if (empty($this->db_prefix)) {
            $this->set_db_prefix($dir);
        }

        $this->set_dir('file', $file);
        $this->set_dir('image', $image);
        $this->set_dir('thumbs', $thumbs);

        $modhandler = xoops_getHandler('module');
        $TadToolsModule = $modhandler->getByDirname('tadtools');
        $config_handler = xoops_getHandler('config');
        $TadToolsModuleConfig = $config_handler->getConfigsByCat(0, $TadToolsModule->mid());
        $this->auto_charset = $TadToolsModuleConfig['auto_charset'];
    }

    //設定路徑
    public function set_path()
    {
        $this->TadUpFilesDir = XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$this->subdir}{$this->file_dir}";
        $this->TadUpFilesUrl = XOOPS_URL . "/uploads/{$this->dir}{$this->subdir}{$this->file_dir}";
        $this->TadUpFilesImgDir = XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$this->subdir}{$this->image_dir}";
        $this->TadUpFilesImgUrl = XOOPS_URL . "/uploads/{$this->dir}{$this->subdir}{$this->image_dir}";
        $this->TadUpFilesThumbDir = XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$this->subdir}{$this->thumbs_dir}";
        $this->TadUpFilesThumbUrl = XOOPS_URL . "/uploads/{$this->dir}{$this->subdir}{$this->thumbs_dir}";
    }

    //取得路徑
    public function get_path($type = '', $kind = '')
    {
        if ($type === 'file') {
            if ($kind === 'dir') {
                $path = $this->TadUpFilesDir;
            } elseif ($kind === 'url') {
                $path = $this->TadUpFilesUrl;
            } else {
                $path['dir'] = $this->TadUpFilesDir;
                $path['url'] = $this->TadUpFilesUrl;
            }
        } elseif ($type === 'image') {
            if ($kind === 'dir') {
                $path = $this->TadUpFilesImgDir;
            } elseif ($kind === 'url') {
                $path = $this->TadUpFilesImgUrl;
            } else {
                $path['dir'] = $this->TadUpFilesImgDir;
                $path['url'] = $this->TadUpFilesImgUrl;
            }
        } elseif ($type === 'thumb') {
            if ($kind === 'dir') {
                $path = $this->TadUpFilesThumbDir;
            } elseif ($kind === 'url') {
                $path = $this->TadUpFilesThumbUrl;
            } else {
                $path['dir'] = $this->TadUpFilesThumbDir;
                $path['url'] = $this->TadUpFilesThumbUrl;
            }
        } else {
            $path['file']['dir'] = $this->TadUpFilesDir;
            $path['file']['url'] = $this->TadUpFilesUrl;
            $path['image']['dir'] = $this->TadUpFilesImgDir;
            $path['image']['url'] = $this->TadUpFilesImgUrl;
            $path['thumb']['dir'] = $this->TadUpFilesThumbDir;
            $path['thumb']['url'] = $this->TadUpFilesThumbUrl;
        }

        return $path;
    }

    //設定縮圖背景
    public function set_thumb($width = '', $height = '', $bg_color = '', $position = '', $repeat = '', $size = '')
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

    public function set_prefix($dir = '')
    {
        $this->dir = $dir;
        $this->set_path();
    }

    public function set_db_prefix($db_prefix = '')
    {
        global $xoopsDB;
        $this->db_prefix = $db_prefix;
        $this->TadUpFilesTblName = $xoopsDB->prefix("{$db_prefix}_files_center");
    }

    public function set_filename($filename = '')
    {
        $this->filename = $filename;
    }

    //設定目錄
    public function set_dir($type, $dir = '')
    {
        if ($type === 'subdir') {
            $this->subdir = $dir;
        } elseif ($type === 'file') {
            $this->file_dir = $dir;
        } elseif ($type === 'image') {
            $this->image_dir = $dir;
        } elseif ($type === 'thumbs') {
            $this->thumbs_dir = $dir;
        }
        $this->set_path();
    }

    public function set_var($name = '', $val = '')
    {
        $this->$name = $val;
    }

    public function set_col($col_name = '', $col_sn = '', $sort = '')
    {
        $this->col_name = $col_name;
        $this->col_sn = $col_sn;
        $this->sort = $sort;
    }

    public function set_files_sn($files_sn = '')
    {
        $this->files_sn = $files_sn;
    }

    //是否套用fancybox
    public function set_fancybox($show = true)
    {
        $this->showFancyBox = $show;
    }

    //自己設定檔案下載路徑
    public function set_download_url($url = '')
    {
        $this->download_url = $url;
    }

    //是否加密
    public function set_hash($hash = false)
    {
        $this->hash = $hash;
    }

    //上傳元件
    public function upform($show_edit = false, $upname = 'upfile', $maxlength = '', $show_list_del_file = true, $only_type = '', $thumb = true, $id = '', $show_filename = true)
    {
        global $xoopsDB;
        $maxlength_code = empty($maxlength) ? '' : "maxlength='{$maxlength}'";
        $accept = ($only_type) ? "accept='{$only_type}'" : '';
        $list_del_file = ($show_list_del_file) ? $this->list_del_file($show_edit, $thumb, null, $show_filename) : '';
        $jquery = Utility::get_jquery(true);
        $id = empty($id) ? $upname : $id;

        $multiple = ($maxlength == 1) ? '' : "$maxlength_code multiple='multiple'";

        $permission = '';
        if ($this->permission) {
            $groups = $this->get_groups();

            $permission = _TUF_PERMISSION_NOTE;
            foreach ($groups as $groupid => $name) {
                $permission .= "<label><input type='checkbox' name='dl_group[new][]' value='{$groupid}'>{$name}</label> \n";
            }
        }

        $require = ($this->require) ? 'validate[required]' : '';

        $main = "
            $jquery
            <input type='file' name='{$upname}[]' id='{$id}' $multiple $accept class='form-control $require' style='height: initial;'>
            $permission
            {$list_del_file}
            ";

        return $main;
    }

    private function get_groups()
    {
        global $xoopsDB;
        $sql = 'select groupid,name from `' . $xoopsDB->prefix('groups') . "` where group_type!='Anonymous' order by groupid";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $permission = _TUF_PERMISSION_NOTE;
        $groups = [];
        while (list($groupid, $name) = $xoopsDB->fetchRow($result)) {
            $groups[$groupid] = $name;
        }

        return $groups;
    }

    //列出可刪除檔案，$show_edit=true(full),false(thumb),'list','none'
    public function list_del_file($show_edit = false, $thumb = true, $files_sn_arr = [], $show_filename = true, $show_tip = null)
    {
        global $xoopsDB, $xoopsUser, $xoTheme;

        if ($show_tip !== null) {
            $this->show_tip = $show_tip;
        }

        if ($show_edit == 'list') {
            if ($xoTheme) {
                $xoTheme->addStylesheet('modules/tadtools/css/rounded-list.css');
            } else {
                $files = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/rounded-list.css">';
            }
        }

        // 權限設定
        if ($this->permission) {
            $groups = $this->get_groups();
        }

        $all_file = '';
        $and_tag = $this->tag ? "and `tag`='{$this->tag}'" : '';
        if (!empty($files_sn_arr)) {
            $all_files_sn = implode("','", $files_sn_arr);
            $sql = "select * from `{$this->TadUpFilesTblName}`  where `files_sn` in('$all_files_sn') order by sort";
        } else {
            $sql = "select * from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_tag order by sort";
        }
        // die($sql);
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $i = 0;

        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            //以uid取得使用者名稱
            $uid_name = \XoopsUser::getUnameFromId($uid, 1);
            if (empty($uid_name)) {
                $uid_name = \XoopsUser::getUnameFromId($uid, 0);
            }

            // $fileidname = str_replace('.', '', $file_name);
            $file_name = $this->hash ? $hash_filename : $file_name;
            if ($thumb) {
                if ($kind === 'file') {
                    $fext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    if (file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/images/mimetype/{$fext}.png")) {
                        $thumb_pic = XOOPS_URL . "/modules/tadtools/images/mimetype/{$fext}.png";
                    } else {
                        $thumb_pic = XOOPS_URL . '/modules/tadtools/multiple-file-upload/downloads.png';
                    }
                    $thumb_tool = "
                    <div class='row'>
                        <div class='col-sm-3 text-left'>
                        </div>
                        <div class='col-sm-6 text-center'>
                            <a href=\"javascript:remove_file('{$files_sn}');\" style='font-size: 0.8rem;' class='text-danger' data-toggle=\"tooltip\" title=\"" . sprintf(_TM_FILE_DEL_BY, $uid_name, $uid_name) . "\">
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
                            <a href=\"javascript:rotate_img('left','{$files_sn}','{$this->dir}{$this->subdir}','{$this->image_dir}','{$this->thumbs_dir}','{$file_name}','{$file_type}')\" id='left90'><i class=\"fa fa-undo text-success\" title='" . TADTOOLS_ROTATE_LEFT . "'></i></a>
                        </td>
                        <td class='text-center'>
                            <a href=\"javascript:remove_file('{$files_sn}');\" style='font-size: 0.8rem;' class='text-danger'>
                                <i class=\"fa fa-times text-danger\" title=\"" . _TAD_DEL . "\"></i>
                            </a>
                        </td>
                        <td class='text-left'>
                            <a href=\"javascript:rotate_img('right','{$files_sn}','{$this->dir}{$this->subdir}','{$this->image_dir}','{$this->thumbs_dir}','{$file_name}','{$file_type}')\" id='right90'><i class=\"fa fa-repeat text-info\" title='" . TADTOOLS_ROTATE_RIGHT . "'></i></a>
                        </td>
                        </tr>
                    </table>";

                    $thumb_style = "<a name='{$files_sn}' id='thumb{$files_sn}' href='{$this->TadUpFilesImgUrl}/{$file_name}' style='display: block; width: 120px; height: 80px; overflow: hidden; background-color: {$this->thumb_bg_color}; background-image: url({$thumb_pic}),url(" . XOOPS_URL . "/modules/tadtools/images/transparent.png); background-position: center center; background-repeat: no-repeat; background-size: contain; border: 1px solid gray; margin: 0px auto;' title='{$description}' class='fancybox_demo' rel='demo'></a>";

                    $thumb_style2 = "<a class='thumbnail' id='thumb{$files_sn}' style='display:inline-block; width:{$this->thumb_width};height:{$this->thumb_height};overflow:hidden;background-color:{$this->thumb_bg_color};background-image:url({$thumb_pic});background-position:{$this->thumb_position};background-repeat:{$this->thumb_repeat};background-size:{$this->thumb_size}; margin-bottom: 4px;' title='{$description}'></a>";
                }
                $img_class = 'img-thumbnail';
                // $img_class = ($this->bootstrap == '3') ? "img-thumbnail" : "img-polaroid";

                $w = 'width:130px; word-break: break-word;';
                $w2 = "width:{$this->thumb_width}; float:left; margin-right:10px;";
            } else {
                $thumb_tool = "<a href=\"javascript:remove_file('{$files_sn}');\" style='font-size: 0.8rem;' class='text-danger'>
                                <i class=\"fa fa-trash\"></i> " . _TAD_DEL . '</a></div>';
                $thumb_style = '';
                $thumb_style2 = '';
                $thumb_pic = '';
                $w = '';
                $w2 = 'list-style-position: outside;';
            }

            $filename_label = '';

            if ($show_edit === true or $show_edit === 'full') {
                // 權限設定
                if ($this->permission) {
                    $sql = 'select gperm_groupid from `' . $xoopsDB->prefix('group_permission') . "` where gperm_name='dl_group' and gperm_itemid='{$files_sn}' order by gperm_groupid";
                    $result2 = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    $gperm_groupid_arr = [];
                    while (list($gperm_groupid) = $xoopsDB->fetchRow($result2)) {
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
            } elseif ($show_edit === 'list') {
                //無編輯框，無圖示
                $file_href = ($kind === 'file') ? "href='{$this->TadUpFilesUrl}/{$file_name}'" : "href='{$this->TadUpFilesImgUrl}/{$file_name}' class='fancybox_demo' rel='demo'";
                $all_file .= "
                <li id='fdtr_{$files_sn}'>
                    <span name='{$files_sn}'>
                        <i class='fa fa-times-circle' aria-hidden='true' onClick=\"remove_file('{$files_sn}');\" style='color: red;'></i>
                        <a $file_href>{$original_filename}</a>
                    </span>
                </li>
                ";
            } else {
                //無編輯框，有圖示水平排列

                if ($show_filename) {
                    $filename_label = "
                    <label class='checkbox-inline' style='width:{$this->thumb_width}; height: 100px;font-size: 0.8em;word-wrap: break-word;'>
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

        // die($all_file);
        if (empty($all_file)) {
            return;
        }

        $fancybox = new FancyBox('.fancybox_demo', 640, 480);
        $fancybox->render(false, null, false);

        $files = "
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

            function rotate_img(op, files_sn, subdir, image_dir, thumbs_dir, filename, type){
                $.post('" . XOOPS_URL . "/modules/tadtools/imagerotate.php', {op: op, files_sn:files_sn , subdir: subdir , image_dir: image_dir , thumbs_dir: thumbs_dir , filename:filename ,type:type}, function(data){
                    $('#thumb' + files_sn).css('background-image', 'url(\''+data+'?timestamp=' + new Date().getTime()+'\')' ).css('border', '1px solid red' );
                    console.log(data+'?timestamp=' + new Date().getTime());
                });
            }

            function remove_file(files_sn){
                var sure = window.confirm('" . _TAD_DEL_CONFIRM . "');
                if (!sure){
                    return;
                } else{
                    $.post('" . XOOPS_URL . "/modules/tadtools/ajax_file.php', {op: 'remove_file', mod_name: '{$this->dir}', db_prefix: '{$this->db_prefix}', files_sn: files_sn}, function(data){
                        if(data=='1'){
                            $('#fdtr_' + files_sn).html('<li>已刪除</li>');
                            $('#fdtr_' + files_sn).remove();
                        }else{
                            $('#fdtr_' + files_sn).html('<li>刪除失敗：'+data+'</li>');
                        }
                    });
                }

            }
        </script>";

        $del_alert = ($show_edit === 'list') ? TADTOOLS_CHECKBOX_TO_DEL : '';
        $sort_able = ($this->show_tip and $i > 1) ? "<div class='alert alert-info' id='df_save_msg'>{$del_alert}" . _TAD_SORTABLE . '</div>' : '';

        if ($show_edit === true or $show_edit === 'full') {
            $files .= "
            {$sort_able}
                <table class='table table-striped table-hover' style='width:100%; margin-top:10px;'>
                    <tbody id='list_del_file_sort_{$this->col_name}' >
                        $all_file
                    </tbody>
                </table>
            ";
        } elseif ($show_edit === 'list') {
            $files .= "
            <div style='margin-top:10px;'>
                <ol class='rectangle-list' style=\"counter-reset: li; list-style: none; *list-style: decimal; font: " . $this->filename_size . " 'trebuchet MS', 'lucida sans'; padding: 0; text-shadow: 0 1px 0 rgba(255,255,255,.5);\" id='list_del_file_sort_{$this->col_name}'>
                    {$all_file}
                </ol>
            </div>
            {$sort_able}";
        } else {
            $files .= "
                <div style='margin-top:10px;'>
                    <ul class='thumbnails' id='list_del_file_sort_{$this->col_name}'>
                        {$all_file}
                    </ul>
                </div>
                {$sort_able}
                ";
        }

        return $files;
    }

    //上傳圖檔，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_file($upname = 'upfile', $main_width = '1920', $thumb_width = '240', $files_sn = '', $desc = null, $safe_name = false, $hash = false, $return_col = 'file_name', $allow = '', $deny = '')
    {
        global $xoopsDB, $xoopsUser;
        if ($hash) {
            $this->set_hash($hash);
        }

        if (empty($main_width)) {
            $main_width = '1920';
        }

        if (empty($thumb_width)) {
            $thumb_width = '240';
        }
        //新增限制允許檔案類型
        if (!empty($allow)) {
            $allow = explode(';', $allow);
            $allow_arr = [];
            foreach ($allow as $key => $value) {
                $mime_arr = $this->ext2mime($value);
                foreach ($mime_arr as $k => $v) {
                    $allow_arr[] = $v;
                }
            }
        }

        //新增限制不允許檔案類型
        if (!empty($deny)) {
            $deny = explode(';', $deny);
            $deny_arr = [];
            foreach ($deny as $key => $value) {
                $mime_arr = $this->ext2mime($value);
                foreach ($mime_arr as $k => $v) {
                    $deny_arr[] = $v;
                }
            }
        }
        // die(var_dump($deny_arr));

        //引入上傳物件
        include_once XOOPS_ROOT_PATH . '/modules/tadtools/upload/class.upload.php';

        //取消上傳時間限制
        set_time_limit(0);
        //設置上傳大小
        ini_set('memory_limit', '180M');

        // 更新權限
        if ($this->permission) {
            $modhandler = xoops_getHandler('module');
            $theModule = $modhandler->getByDirname($this->dir);
            $mod_id = $theModule->mid();
        }

        //儲存檔案描述
        $save_description = Request::getArray('save_description');
        $dl_group = Request::getArray('dl_group');

        if (!empty($save_description)) {
            foreach ($save_description as $save_files_sn => $files_desc) {
                $this->update_col_val($save_files_sn, 'description', $files_desc);
                // 順便更新權限
                if ($this->permission) {
                    $sql = 'delete from `' . $xoopsDB->prefix('group_permission') . "` where `gperm_itemid`='{$save_files_sn}' and `gperm_name`='dl_group'";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

                    foreach ($dl_group[$save_files_sn] as $groupid) {
                        $gperm_groupid = (int) $groupid;
                        $sql = 'insert into `' . $xoopsDB->prefix('group_permission') . "`  (`gperm_groupid`,`gperm_itemid`,`gperm_modid`,`gperm_name`) values('{$gperm_groupid}', '{$save_files_sn}', '{$mod_id}', 'dl_group')";
                        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    }
                }
            }
        }

        //刪除勾選檔案
        $del_file = Request::getArray('del_file');

        if (!empty($del_file)) {
            foreach ($del_file as $del_files_sn) {
                $this->del_files($del_files_sn);
            }
        }

        $files = [];
        foreach ($_FILES[$upname] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files)) {
                    $files[$i] = [];
                }
                $files[$i][$k] = $v;
            }
        }

        // die(var_dump($files));
        $all_files_sn = [];
        foreach ($files as $file) {
            if (function_exists('exif_read_data')) {
                $exif = exif_read_data($file['tmp_name'], null, true);
                $creat_date = $exif['IFD0']['DateTime'];
                $Model360 = ['LG-R105', 'RICOH THETA S'];
                if (in_array($exif['IFD0']['Model'], $Model360)) {
                    $this->tag = '360';
                    $thumb_width = $thumb_width * 2;
                    $main_width = 0;
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
            $file_handle = new \Verot\Upload\Upload($file, 'zh_TW');

            if ($file_handle->uploaded) {
                //取得副檔名
                $file_ext = $file_handle->file_src_name_ext;
                $ext = mb_strtolower($file_ext);

                //判斷檔案種類
                if ($ext === 'jpg' or $ext === 'jpeg' or $ext === 'png' or $ext === 'gif') {
                    $kind = 'img';
                } else {
                    $kind = 'file';
                }

                $file_handle->file_safe_name = false;
                $file_handle->mime_check = ($allow == '' and $deny == '') ? false : true;
                $file_handle->file_overwrite = true;
                $file_handle->no_script = false;
                $file_handle->file_new_name_ext = $ext;
                $hash_name = md5(mt_rand(0, 1000) . $file['name']);
                if ($this->hash) {
                    $new_filename = $hash_name;
                } else {
                    $new_filename = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
                }

                if ($this->filename != '') {
                    $new_filename = $this->filename . '-' . $this->sort;
                }

                //die($new_filename);
                $os_charset = (PATH_SEPARATOR === ':') ? 'UTF-8' : 'Big5';

                if ($os_charset != _CHARSET) {
                    $new_filename = iconv(_CHARSET, $os_charset, $new_filename);
                }
                $file_handle->file_new_name_body = $new_filename;

                //若是圖片才縮圖
                if ($kind === 'img' and !empty($main_width)) {
                    if ($file_handle->image_src_x > $main_width) {
                        $file_handle->image_resize = true;
                        $file_handle->image_x = $main_width;
                        $file_handle->image_ratio_y = true;
                    }
                }
                $path = ($kind === 'img') ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;
                $readme = ($this->hash) ? "{$path}/{$hash_name}_info.txt" : '';

                //die($path);
                //新增限制檔案類型
                if (!empty($allow)) {
                    $file_handle->allowed = $allow_arr;
                }
                if (!empty($deny)) {
                    $file_handle->forbidden = $deny_arr;
                }
                $file_handle->process($path);
                $file_handle->auto_create_dir = true;

                $upload_date = date('Y-m-d H:i:s');
                $uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

                //若是圖片才製作小縮圖
                if ($kind === 'img') {
                    $file_handle->file_safe_name = false;
                    $file_handle->mime_check = ($allow == '' and $deny == '') ? false : true;
                    $file_handle->file_overwrite = true;
                    $file_handle->file_new_name_ext = $ext;
                    $file_handle->file_new_name_body = $new_filename;

                    if ($file_handle->image_src_x > $thumb_width) {
                        $file_handle->image_resize = true;
                        $file_handle->image_x = $thumb_width;
                        $file_handle->image_ratio_y = true;
                    }
                    //新增限制檔案類型
                    if (!empty($allow)) {
                        $file_handle->allowed = $allow_arr;
                    }
                    if (!empty($deny)) {
                        $file_handle->forbidden = $deny_arr;
                    }
                    $file_handle->process($this->TadUpFilesThumbDir);
                    $file_handle->auto_create_dir = true;
                }

                //上傳檔案
                if ($file_handle->processed) {
                    $file_handle->clean();

                    if ($this->hash) {
                        $fp = fopen($readme, 'wb');
                        fwrite($fp, $file['name']);
                        fclose($fp);
                    }

                    $file_name = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $file['name'];

                    if ($this->filename != '') {
                        $file_name = $this->filename . '-' . $this->sort . ".{$ext}";
                    }

                    $description = $desc === null ? $file['name'] : $desc;

                    chmod("{$path}/{$file_name}", 0755);
                    if ($kind === 'img') {
                        chmod("{$this->TadUpFilesThumbDir}/{$file_name}", 0755);
                    }

                    $hash_name = ($this->hash) ? "{$hash_name}.{$ext}" : '';

                    if (empty($files_sn)) {
                        $sql = "replace into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}',0,'{$file['name']}','{$this->subdir}','{$hash_name}','{$upload_date}','{$uid}','{$this->tag}')";

                        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                        //取得最後新增資料的流水編號
                        $insert_files_sn = $xoopsDB->getInsertId();

                        // 加入權限
                        if ($this->permission) {
                            $dl_group = Request::getArray('dl_group');
                            foreach ($dl_group['new'] as $groupid) {
                                $gperm_groupid = (int) $groupid;
                                $sql = 'insert into `' . $xoopsDB->prefix('group_permission') . "`  (`gperm_groupid`,`gperm_itemid`,`gperm_modid`,`gperm_name`) values('{$gperm_groupid}', '{$insert_files_sn}', '{$mod_id}', 'dl_group')";
                                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                            }
                        }
                    } else {
                        $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}','{$upload_date}','{$uid}','{$this->tag}')";

                        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    }

                    $all_files_sn[] = $insert_files_sn;
                } else {
                    // if (!empty($_SERVER['HTTPS'])) {
                    //     $http = ($_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
                    // }
                    // redirect_header("{$http}{$_SERVER["HTTP_HOST"]}{$_SERVER['REQUEST_URI']}", 3, 'Error:' . $file_handle->error);
                    redirect_header($_SERVER["HTTP_REFERER"], 3, 'Error:' . $file_handle->error);
                }
            }
            $this->sort = '';
        }

        // die(var_dump($all_files_sn));
        if ($return_col === 'files_sn') {
            return $all_files_sn;
        }

        return $file_name;
    }

    //複製、匯入單一檔案，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function import_one_file($from = '', $filename_new = '', $main_width = '1920', $thumb_width = '240', $files_sn = '', $desc = '', $safe_name = false, $hash = false, $link = false, $only_import2db = false)
    {
        global $xoopsDB, $xoopsUser;

        //取消上傳時間限制
        set_time_limit(0);
        //設置上傳大小
        ini_set('memory_limit', '1024M');

        //自動排序
        if (empty($this->sort)) {
            $this->sort = $this->auto_sort();
        }

        $filename = empty($filename_new) ? Utility::get_basename($from) : $filename_new;
        $type = $this->mime_content_type($filename);
        $size = filesize($from);

        //取得副檔名
        $extarr = explode('.', $filename);
        foreach ($extarr as $val) {
            $ext = mb_strtolower($val);
        }

        //判斷檔案種類
        if ($ext === 'jpg' or $ext === 'jpeg' or $ext === 'png' or $ext === 'gif') {
            $kind = 'img';
        } else {
            $kind = 'file';
        }

        if (empty($main_width)) {
            $main_width = '1920';
        }

        if (empty($thumb_width)) {
            $thumb_width = '240';
        }

        if ($hash) {
            $this->set_hash($hash);
        }

        if (!$only_import2db) {
            //先刪除舊檔
            if (!empty($files_sn)) {
                $this->del_files($files_sn);
            }
        }

        $path = ($kind === 'img') ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;
        $new_filename = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $filename;

        $readme = '';
        $hash_name = md5(mt_rand(0, 1000) . $filename);
        if ($this->hash) {
            $hash_filename = $hash_name . '.' . $ext;
            $readme = "{$path}/{$hash_name}_info.txt";
            $fp = fopen($readme, 'wb');
            fwrite($fp, $filename);
            fclose($fp);
        } else {
            $hash_filename = $new_filename;
        }

        $upload_date = date('Y-m-d H:i:s');
        $uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

        //若是圖片才縮圖
        if ($kind === 'img' and !empty($main_width)) {
            $filename = Utility::auto_charset($filename);
            $new_thumb = $this->TadUpFilesThumbDir . '/' . $hash_filename;

            if (!$only_import2db) {
                if (file_exists($path . '/' . $hash_filename)) {
                    unlink($path . '/' . $hash_filename);
                }
            }

            if (function_exists('exif_read_data')) {
                $exif = exif_read_data($filename, null, true);
                $creat_date = $exif['IFD0']['DateTime'];
                $Model360 = ['LG-R105', 'RICOH THETA S'];
                if (in_array($exif['IFD0']['Model'], $Model360)) {
                    $this->tag = '360';
                }
            }

            //複製檔案
            $this->thumbnail($from, $new_thumb, $type, $thumb_width);

            $copy_or_link = true;
            if (!$only_import2db) {
                if ($link) {
                    $copy_or_link = symlink($from, $path . '/' . $hash_filename);
                } else {
                    $copy_or_link = copy($from, $path . '/' . $hash_filename);
                }
            }

            if ($copy_or_link or $only_import2db) {
                if ($desc === false) {
                    $description = '';
                } else {
                    $description = (empty($files_sn) and empty($desc)) ? $filename : $desc;
                }
                $this->col_sn = (int) $this->col_sn;
                if (empty($files_sn)) {
                    $sql = "replace into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}',0 ,'{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$this->tag}')";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}',0,'{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$this->tag}')";
                    // die("2-{$sql}");
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                }
                $this->sort = '';
            }

        } else {
            $copy_or_link = true;
            if (!$only_import2db) {
                if ($link) {
                    $copy_or_link = symlink($from, $path . '/' . $hash_filename);
                } else {
                    $copy_or_link = copy($from, $path . '/' . $hash_filename);
                }
            }
            if ($copy_or_link or $only_import2db) {
                $filename = Utility::auto_charset($filename);
                // die($filename);
                $description = (empty($files_sn) or empty($desc)) ? $filename : $desc;

                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$this->tag}')";
                    // die("3-{$sql}");
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}','{$upload_date}','{$uid}','{$this->tag}')";
                    // die("4-{$sql}");
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                }

                $this->sort = '';
            }
        }

        //die('new_thumb:'.$new_thumb);

        return $files_sn;
    }

    //檔案格式
    protected function mime_content_type($filename)
    {
        $mime_types = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'csv' => 'text/comma-separated-values',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        $ext = mb_strtolower(array_pop(explode('.', $filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);

            return $mimetype;
        }

        return 'application/octet-stream';
    }

    //做縮圖
    public function thumbnail($filename = '', $thumb_name = '', $type = 'image/jpeg', $width = '120')
    {
        // die("{$filename}, {$thumb_name}, {$filename}, {$filename}, ");

        if (empty($type)) {
            $type = $this->mime_content_type($filename);
        }

        // Get new sizes
        list($old_width, $old_height) = getimagesize($filename);
        if ($old_width > $width) {
            $percent = ($old_width > $old_height) ? round($width / $old_width, 2) : round($width / $old_height, 2);

            $newwidth = ($old_width > $old_height) ? $width : $old_width * $percent;
            $newheight = ($old_width > $old_height) ? $old_height * $percent : $width;

            // Load
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            if ($type === 'image/jpeg' or $type === 'image/jpg' or $type === 'image/pjpg' or $type === 'image/pjpeg') {
                $source = imagecreatefromjpeg($filename);
                $type = 'image/jpeg';
            } elseif ($type === 'image/png') {
                $source = imagecreatefrompng($filename);
                imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                $type = 'image/png';
            } elseif ($type === 'image/gif') {
                $source = imagecreatefromgif($filename);
                imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                $type = 'image/gif';
            }

            // Resize
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);
            //ob_start();
            //header("Content-type: $type");
            if ($type === 'image/jpeg') {
                imagejpeg($thumb, $thumb_name);
            } elseif ($type === 'image/png') {
                imagepng($thumb, $thumb_name);
            } elseif ($type === 'image/gif') {
                imagegif($thumb, $thumb_name);
            }
            imagedestroy($thumb);

            //ob_end_clean();
            return;
            exit;
        } else {
            copy($filename, $thumb_name);
        }
        return;
        exit;

    }

    //上傳單一檔案，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_one_file($name = '', $tmp_name = '', $type = '', $size = '', $main_width = '1280', $thumb_width = '120', $files_sn = '', $desc = '', $safe_name = false, $hash = false, $allow = '', $deny = '')
    {
        global $xoopsDB, $xoopsUser;

        if (empty($main_width)) {
            $main_width = '1280';
        }

        if (empty($thumb_width)) {
            $thumb_width = '120';
        }

        if ($hash) {
            $this->set_hash($hash);
        }

        //die(var_dump($_FILES[$upname]));
        //引入上傳物件
        include_once XOOPS_ROOT_PATH . '/modules/tadtools/upload/class.upload.php';

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

        $file['name'] = $name;
        $file['tmp_name'] = $tmp_name;
        $file['type'] = $type;
        $file['size'] = $size;

        //取得檔案
        $file_handle = new \Verot\Upload\Upload($file, 'zh_TW');

        if ($file_handle->uploaded) {
            //取得副檔名
            $ext = mb_strtolower($file_handle->file_src_name_ext);
            //判斷檔案種類
            if ($ext === 'jpg' or $ext === 'jpeg' or $ext === 'png' or $ext === 'gif') {
                $kind = 'img';
            } else {
                $kind = 'file';
            }

            $hash_name = md5(mt_rand(0, 1000) . $name);

            $file_handle->file_safe_name = false;
            $file_handle->mime_check = ($allow == '' and $deny == '') ? false : true;
            $file_handle->file_overwrite = true;
            $file_handle->file_new_name_ext = $ext;
            if ($this->hash) {
                $file_handle->file_new_name_body = $hash_name;
            } else {
                $file_handle->file_new_name_body = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
            }

            //若是圖片才縮圖
            if ($kind === 'img' and !empty($main_width)) {
                if ($file_handle->image_src_x > $main_width) {
                    $file_handle->image_resize = true;
                    $file_handle->image_x = $main_width;
                    $file_handle->image_ratio_y = true;
                }
            }
            $path = ($kind === 'img') ? $this->TadUpFilesImgDir : $this->TadUpFilesDir;

            $readme = ($this->hash) ? "{$path}/{$hash_name}_info.txt" : '';

            //die($path);
            $file_handle->process($path);
            $file_handle->auto_create_dir = true;

            $upload_date = date('Y-m-d H:i:s');
            $uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

            //若是圖片才製作小縮圖
            if ($kind === 'img') {
                $file_handle->file_safe_name = false;
                $file_handle->mime_check = ($allow == '' and $deny == '') ? false : true;
                $file_handle->file_overwrite = true;
                $file_handle->file_new_name_ext = $ext;
                if ($this->hash) {
                    $file_handle->file_new_name_body = $hash_name;
                } else {
                    $file_handle->file_new_name_body = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}" : $file_handle->file_src_name_body;
                }
                if ($file_handle->image_src_x > $thumb_width) {
                    $file_handle->image_resize = true;
                    $file_handle->image_x = $thumb_width;
                    $file_handle->image_ratio_y = true;
                }
                $file_handle->process($this->TadUpFilesThumbDir);
                $file_handle->auto_create_dir = true;

                if (function_exists('exif_read_data')) {
                    $exif = exif_read_data($file['tmp_name'], null, true);
                    $creat_date = $exif['IFD0']['DateTime'];
                    $Model360 = ['LG-R105', 'RICOH THETA S'];
                    if (in_array($exif['IFD0']['Model'], $Model360)) {
                        $this->tag = '360';
                    }
                }
            }

            //上傳檔案
            if ($file_handle->processed) {
                $file_handle->clean();

                if ($this->hash) {
                    $fp = fopen($readme, 'wb');
                    fwrite($fp, $name);
                    fclose($fp);
                }

                $file_name = ($safe_name) ? "{$this->col_name}_{$this->col_sn}_{$this->sort}.{$ext}" : $name;

                chmod("{$path}/{$file_name}", 0755);
                if ($kind === 'img') {
                    chmod("{$this->TadUpFilesThumbDir}/{$file_name}", 0755);
                }

                $description = (empty($files_sn) or empty($desc)) ? $file['name'] : $desc;
                if ($this->hash) {
                    $db_hash_name = "{$hash_name}.{$ext}";
                } else {
                    $db_hash_name = '';
                }
                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$db_hash_name}','{$upload_date}','{$uid}','{$this->tag}')";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`,`upload_date`,`uid`,`tag`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$db_hash_name}','{$upload_date}','{$uid}','{$this->tag}')";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                }
                //die($sql);
            } else {
                redirect_header($_SERVER['PHP_SELF'], 3, 'Error:' . $file_handle->error);
            }
        }
        $this->sort = '';

        if ($desc !== null) {
            $this->update_col_val($files_sn, 'description', $desc);
        }

        return $files_sn;
    }

    //自動編號
    public function auto_sort()
    {
        global $xoopsDB, $xoopsUser;

        $sql = "select max(sort) from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";

        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($max) = $xoopsDB->fetchRow($result);

        return ++$max;
    }

    //更新某個欄位值
    public function update_col_val($files_sn = '', $col = '', $val = '')
    {
        global $xoopsDB, $xoopsUser;

        $myts = \MyTextSanitizer::getInstance();
        $col = $myts->addSlashes($col);
        $val = $myts->addSlashes($val);

        $sql = "update `{$this->TadUpFilesTblName}`  set `$col`='{$val}' where `files_sn`='{$files_sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        return true;
    }

    //刪除實體檔案
    public function del_files($files_sn = '')
    {
        global $xoopsDB, $xoopsUser;

        $modhandler = xoops_getHandler('module');
        $theModule = $modhandler->getByDirname($this->dir);
        $mod_id = $theModule->mid();
        $isAdmin = is_object($xoopsUser) ? $xoopsUser->isAdmin($mod_id) : false;
        $my_uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

        if (!empty($files_sn)) {
            $del_what = "`files_sn`='{$files_sn}'";
        } elseif (!empty($this->col_name) and !empty($this->col_sn)) {
            $and_sort = (empty($this->sort)) ? '' : "and `sort`='{$this->sort}'";
            $del_what = "`col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort";
        }

        if (empty($del_what)) {
            return false;
        }

        $sql = "select * from `{$this->TadUpFilesTblName}`  where $del_what";
        $result = $xoopsDB->query($sql) or die($sql);

        while ($all = $xoopsDB->fetchArray($result)) {
            foreach ($all as $k => $v) {
                $$k = $v;
            }
            if ($isAdmin or $uid == $my_uid or empty($uid)) {
                $this->set_col($col_name, $col_sn, $sort);
                $del_sql = "delete  from `{$this->TadUpFilesTblName}`  where files_sn='{$files_sn}'";
                $xoopsDB->queryF($del_sql) or Utility::web_error($del_sql, __FILE__, __LINE__);

                if ($kind === 'img') {
                    // die(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->image_dir}/{$file_name}");
                    unlink(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->image_dir}/{$file_name}");
                    unlink(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->thumbs_dir}/{$file_name}");
                    if (!empty($hash_filename)) {
                        unlink(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->image_dir}/{$hash_filename}");
                        unlink(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->thumbs_dir}/{$hash_filename}");
                    }
                } else {
                    unlink(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->file_dir}/{$file_name}");
                    if (!empty($hash_filename)) {
                        unlink(XOOPS_ROOT_PATH . "/uploads/{$this->dir}{$sub_dir}{$this->file_dir}/{$hash_filename}");
                    }
                }

                $f = explode('.', $hash_filename);
                if (file_exists("{$this->TadUpFilesDir}/{$f[0]}_info.txt")) {
                    unlink("{$this->TadUpFilesDir}/{$f[0]}_info.txt");
                }

                $tmp_dir = XOOPS_ROOT_PATH . "/uploads/{$this->dir}/tmp/{$files_sn}";
                Utility::delete_directory($tmp_dir);
            }
        }

        return true;
    }

    //改檔名
    public function rename_file($files_sn = '', $new_name = '')
    {
        if (empty($files_sn)) {
            return;
        }

        $file = $this->get_file($files_sn);

        if ($file[$files_sn]['kind'] === 'img') {
            //die('asss');
            $file = $this->get_pic_file('images', 'dir', $files_sn);

            rename($file, $this->TadUpFilesImgDir . "/{$new_name}");

            $file = $this->get_pic_file('thumb', 'dir', $files_sn);
            rename($file, $this->TadUpFilesThumbDir . "/{$new_name}");
        } else {
            $file = $this->get_pic_file('file', 'dir', $files_sn);
            rename($file, $this->TadUpFilesDir . "/{$new_name}");
        }
        $this->update_col_val($files_sn, 'file_name', $new_name);
    }

    //取得檔案
    public function get_file($files_sn = '', $limit = null, $path = null, $hash = false, $desc_as_name = false, $keyword = '', $only_keyword = false, $target = '_self', $my_where = '', $file_sn_key = true)
    {
        global $xoopsDB, $xoopsUser;
        $files = [];
        $os_charset = (PATH_SEPARATOR === ':') ? 'UTF-8' : 'Big5';

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : '';

        $andLimit = (!empty($limit)) ? "limit 0 , {$limit}" : '';

        $link_path = $path === null ? $_SERVER['PHP_SELF'] : $path;

        if ($hash) {
            $this->set_hash($hash);
        }

        if (empty($files_sn) and !empty($this->files_sn)) {
            $files_sn = $this->files_sn;
        }

        if ($my_where) {
            $where = "where $my_where";
        } elseif (is_array($files_sn)) {
            $where = "where `files_sn` in('" . implode("','", $files_sn) . "')";
        } else {
            $and_tag = $this->tag ? "and `tag`='{$this->tag}'" : '';
            $where = ($files_sn) ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort $and_tag order by sort $andLimit";
        }

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $i = 0;
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
                if (mb_strrpos($show_file_name, $keyword) !== false) {
                    $show_file_name = str_replace($keyword, "<span class='keyword'>{$keyword}</span>", $show_file_name);
                } elseif ($only_keyword) {
                    continue;
                }
            }

            $key = $file_sn_key ? $files_sn : $i;
            $files[$key]['show_file_name'] = $show_file_name;

            $files[$key]['kind'] = $kind;
            $files[$key]['sort'] = $sort;
            $files[$key]['file_name'] = $file_name;
            $files[$key]['file_type'] = $file_type;
            $files[$key]['file_size'] = $file_size;
            $files[$key]['counter'] = $counter;
            $files[$key]['description'] = $description;
            $files[$key]['original_filename'] = $original_filename;
            $files[$key]['hash_filename'] = $hash_filename;
            $files[$key]['upload_date'] = $upload_date;
            $files[$key]['uid'] = $uid;
            $files[$key]['tag'] = $tag;

            $mark = strpos($link_path, '?') !== false ? '&' : '?';

            $dl_url = empty($this->download_url) ? "{$link_path}{$mark}op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";
            $http = 'http://';
            if (!empty($_SERVER['HTTPS'])) {
                $http = ($_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
            }
            $full_dl_url = empty($this->download_url) ? "{$link_path}{$mark}op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";

            if ($kind === 'img') {
                $fancyboxset = "fancybox_{$this->col_name}";
                $rel = "rel='f{$this->col_name}'";

                $file_name = $this->hash ? $hash_filename : $file_name;
                $pic_name = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                if ($tag == '360') {
                    $fancyboxset = "fancybox_{$this->col_name} $tag";
                    $rel = "data-fancybox-type='iframe'";
                } else {
                    $fancyboxset = "fancybox_{$this->col_name} $tag";
                    $rel = "rel='f{$this->col_name}'";
                }

                $files[$key]['link'] = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'><img src='{$pic_name}' alt='{$description}' title='{$description}'></a>";
                $files[$key]['path'] = $pic_name;
                $files[$key]['url'] = "<a href='{$pic_name}' title='{$description}' {$rel} class='{$fancyboxset}'>{$show_file_name}</a>";

                $files[$key]['tb_link'] = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$key]['tb_path'] = $thumb_pic;
                $files[$key]['tb_url'] = "<a href='{$dl_url}' title='{$description}' {$rel} class='{$fancyboxset}'>{$description}</a>";
                $files[$key]['original_file_path'] = $this->TadUpFilesImgUrl . "/{$file_name}";
                $files[$key]['physical_file_path'] = $this->TadUpFilesImgDir . "/{$file_name}";

                //將附檔強制轉小寫
                $thumb_pic_ext = mb_strtolower(mb_substr($thumb_pic, -3));
                $files[$key]['thumb_pic'] = mb_substr($thumb_pic, 0, -3) . $thumb_pic_ext;
            } else {
                $fext = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
                $files[$key]['thumb_pic'] = XOOPS_URL . "/modules/tadtools/images/mimetype/{$fext}.png";
                $file_name = $this->hash ? $hash_filename : $file_name;

                $files[$key]['link'] = "<a href='{$dl_url}#{$original_filename}' target='{$target}'>{$show_file_name}</a>";
                $files[$key]['path'] = "{$dl_url}#{$original_filename}";
                $files[$key]['original_file_path'] = $this->TadUpFilesUrl . "/{$file_name}";
                $files[$key]['physical_file_path'] = $this->TadUpFilesDir . "/{$file_name}";
            }
            $files[$key]['original_filename'] = $original_filename;
            $files[$key]['full_dl_url'] = $full_dl_url;
            $files[$key]['show_file_name'] = $show_file_name;
            $files[$key]['text_link'] = "{$show_file_name} : {$full_dl_url}";
            $files[$key]['html_link'] = "{$show_file_name} : <a href='{$full_dl_url}'>{$full_dl_url}</a>";
            $i++;
        }

        return $files;
    }

    //取得smarty用的檔案陣列
    public function get_file_for_smarty($files_sn = '', $limit = null, $path = null,$remove_blank=false)
    {
        global $xoopsDB, $xoopsUser;

        $os_charset = (PATH_SEPARATOR === ':') ? 'UTF-8' : 'Big5';

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : '';

        $andLimit = (!empty($limit)) ? "limit 0 , {$limit}" : '';

        $link_path = $path === null ? $_SERVER['PHP_SELF'] : $path;

        if (empty($files_sn) and !empty($this->files_sn)) {
            $files_sn = $this->files_sn;
        }
        if (is_array($files_sn)) {
            $where = "where `files_sn` in('" . implode("','", $files_sn) . "')";
        } else {
            $where = ($files_sn) ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort $andLimit";
        }

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";
        // echo "$sql<br>";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $i = 0;
        $files = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            if ($os_charset != _CHARSET) {
                $file_name = iconv($os_charset, _CHARSET, $file_name);
            }
            // 移除實體檔案不存在的紀錄
            $check_dir=($kind === 'img')?$this->TadUpFilesImgDir:$this->TadUpFilesDir;
            if($remove_blank and !file_exists("{$check_dir}/{$file_name}")){
                $sql = "delete from `{$this->TadUpFilesTblName}` where files_sn='$files_sn'";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                continue;
            }
            $files[$i]['files_sn'] = $files_sn;
            $files[$i]['kind'] = $kind;
            $files[$i]['sort'] = $sort;
            $files[$i]['file_name'] = $file_name;
            $files[$i]['file_type'] = $file_type;
            $files[$i]['file_size'] = $file_size;
            $files[$i]['counter'] = $counter;
            $files[$i]['description'] = $description;
            $files[$i]['original_filename'] = $original_filename;

            $dl_url = empty($this->download_url) ? "{$link_path}?op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";

            if ($kind === 'img') {
                $pic_name = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                $files[$i]['link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='{$pic_name}' alt='{$description}' title='{$description}' rel='lytebox'></a>";
                $files[$i]['path'] = $pic_name;
                $files[$i]['url'] = "<a href='{$dl_url}' title='{$description}' target='_blank'>{$description}</a>";

                $files[$i]['tb_link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$i]['tb_path'] = $thumb_pic;
                $files[$i]['tb_url'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'>{$description}</a>";
            } elseif (mb_strtolower(mb_substr($file_name, -3)) === 'swf') {
                $pic_name = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                $files[$i]['link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='{$pic_name}' alt='{$description}' title='{$description}' rel='lytebox'></a>";
                $files[$i]['path'] = $pic_name;
                $files[$i]['url'] = "<a href='{$dl_url}' title='{$description}' target='_blank'>{$description}</a>";

                $files[$i]['tb_link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$i]['tb_path'] = $thumb_pic;
                $files[$i]['tb_url'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'>{$description}</a>";
            } else {
                $files[$i]['link'] = "<a href='{$dl_url}#{$original_filename}'>{$original_filename}</a>";
                $files[$i]['path'] = "{$dl_url}#{$original_filename}";
            }
            $i++;
        }

        return $files;
    }

    //取得單一圖片 $kind=images（大圖）,thumb（小圖）,file（檔案）$kind="url","dir"
    public function get_pic_file($showkind = 'images', $show_kind = 'url', $files_sn = '', $hash = false)
    {
        global $xoopsDB, $xoopsUser;
        if ((empty($this->col_sn) or empty($this->col_name)) and empty($files_sn)) {
            return;
        }
        if ($hash) {
            $this->set_hash($hash);
        }

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : '';

        $where = $files_sn ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort limit 0,1";

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";
        // die($sql);
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $files = '';
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }
            $file_name = $this->hash ? $hash_filename : $file_name;
            if ($showkind === 'thumb') {
                $path = ($show_kind === 'dir') ? $this->TadUpFilesThumbDir : $this->TadUpFilesThumbUrl;
                $files = (file_exists("{$this->TadUpFilesThumbDir}/{$file_name}")) ? "{$path}/{$file_name}" : '';
            } elseif ($showkind === 'file') {
                $path = ($show_kind === 'dir') ? $this->TadUpFilesDir : $this->TadUpFilesUrl;
                $files = (file_exists("{$this->TadUpFilesDir}/{$file_name}")) ? "{$path}/{$file_name}" : '';
            } else {
                $path = ($show_kind === 'dir') ? $this->TadUpFilesImgDir : $this->TadUpFilesImgUrl;
                $files = (file_exists("{$this->TadUpFilesImgDir}/{$file_name}")) ? "{$path}/{$file_name}" : '';
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

        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($amount) = $xoopsDB->fetchRow($result);

        return $amount;
    }

    //取得附檔或附圖 $show_mode=filename , small,playSpeed=3000 or 0
    public function show_files($upname = '', $thumb = true, $show_mode = '', $show_description = false, $show_dl = false, $limit = null, $path = null, $hash = false, $playSpeed = 0, $desc_as_name = false, $keyword = '', $only_keyword = false, $target = '_self')
    {
        global $xoTheme;

        $all_files = '';
        if ($xoTheme) {
            if ($show_mode === 'small') {
                $xoTheme->addStylesheet('modules/tadtools/css/iconize.css');
            } elseif ($show_mode === 'filename') {
                $xoTheme->addStylesheet('modules/tadtools/css/rounded-list.css');
            }
        } else {
            if ($show_mode === 'small') {
                $all_files = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/iconize.css">';
            } elseif ($show_mode === 'filename') {
                $all_files = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/rounded-list.css">';
            }
        }

        if ($hash) {
            $this->set_hash($hash);
        }
        $playSpeed = empty($playSpeed) ? 0 : $playSpeed;
        $autoPlay = empty($playSpeed) ? false : true;

        if ($this->showFancyBox) {
            $fancybox = new FancyBox(".fancybox_{$this->col_name}", 640, 480);
            $all_files .= ($show_mode === 'file_text_url' or $show_mode === 'file_url') ? '' : $fancybox->render(false, null, $autoPlay, $playSpeed);
        }

        $file_arr = [];
        $file_arr = $this->get_file(null, $limit, $path, $hash, $desc_as_name, $keyword, $only_keyword, $target);

        if (empty($file_arr)) {
            return;
        }

        // if ($show_mode === 'app') {
        //     return $file_arr;
        // }

        if ($file_arr) {
            $i = 1;

            if ($show_mode === 'file_url') {
                $all_files .= '<ul>';
            } elseif ($show_mode === 'app') {
                $all_files = array();
            } elseif ($show_mode === 'file_text_url' or $show_mode === 'small') {
                $all_files .= '';
            } elseif ($show_mode === 'filename') {
                $all_files .= "<ol class='rectangle-list' style=\"counter-reset: li; list-style: none; *list-style: decimal; font: " . $this->filename_size . " 'trebuchet MS', 'lucida sans'; padding: 0; text-shadow: 0 1px 0 rgba(255,255,255,.5);\">";
            } else {
                $all_files .= '<ul>';
            }

            foreach ($file_arr as $files_sn => $file_info) {
                if ($show_mode === 'filename') {
                    if ($file_info['kind'] === 'file') {
                        $all_files .= "<li><span>{$file_info['link']}</span></li>";
                    } else {
                        if ($file_info['tag'] == '360') {
                            $linkto = XOOPS_URL . "/modules/tadtools/360.php?photo={$file_info['path']}";
                            $all_files .= "<li><span><a href='{$linkto}' class='fancybox_{$this->col_name}' data-fancybox-type='iframe'>{$file_info['original_filename']}</a></span></li>";
                        } else {
                            $all_files .= "<li><span>{$file_info['url']}</span></li>";
                        }
                    }
                } elseif ($show_mode === 'app') {
                    $all_files[] = array('url' => $file_info['original_file_path'], 'file_name' => $file_info['show_file_name'], 'dl_url' => $file_info['full_dl_url']);
                } elseif ($show_mode === 'file_url') {
                    $all_files .= "<li>{$file_info['html_link']}</li>";
                } elseif ($show_mode === 'file_text_url') {
                    $all_files .= "{$file_info['text_link']},";
                } else {
                    $linkto = $file_info['path'];
                    $description = empty($file_info['description']) ? $file_info['original_filename'] : $file_info['description'];
                    if ($file_info['kind'] === 'file') {
                        $fext = strtolower(pathinfo($file_info['path'], PATHINFO_EXTENSION));
                        $thumb_pic = XOOPS_URL . "/modules/tadtools/images/mimetype/{$fext}.png";
                        //$fext=strtolower(substr($file_info['path'], -3));
                        if ($fext === 'mp4' or $fext === 'flv' or $fext === '3gp' or $fext === 'mp3') {
                            // $thumb_pic = XOOPS_URL . "/modules/tadtools/images/video.png";
                            if ($this->showFancyBox) {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel = "data-fancybox-type='iframe'";
                            } else {
                                $fancyboxset = $rel = '';
                            }
                            $linkto = XOOPS_URL . "/modules/tadtools/video.php?file_name={$file_info['original_file_path']}";
                        } elseif ($fext === 'jpg' or $fext === 'gif' or $fext === 'png' or $fext === 'jpeg') {
                            if ($file_info['tag'] == '360') {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel = "data-fancybox-type='iframe'";
                                $linkto = XOOPS_URL . "/modules/tadtools/360.php?photo={$file_info['path']}";
                            } else {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel = "rel='f{$this->col_name}'";
                            }
                        } else {
                            // $thumb_pic   = XOOPS_URL . "/modules/tadtools/multiple-file-upload/downloads.png";
                            $fancyboxset = $rel = '';
                        }
                        $thumb_css = $this->thumb_css == '' ? 'background-color: tranparent;' : $this->thumb_css;
                    } else {
                        $thumb_pic = ($thumb) ? $file_info['tb_path'] : $file_info['path'];
                        if ($this->showFancyBox) {
                            if ($file_info['tag'] == '360') {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel = "data-fancybox-type='iframe'";
                                $linkto = XOOPS_URL . "/modules/tadtools/360.php?photo={$file_info['path']}";
                            } else {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel = "rel='f{$this->col_name}'";
                            }
                        } else {
                            $fancyboxset = $rel = '';
                        }
                        //將附檔強制轉小寫
                        $thumb_pic_ext = mb_strtolower(mb_substr($thumb_pic, -3));
                        $thumb_pic = mb_substr($thumb_pic, 0, -3) . $thumb_pic_ext;
                        $linkto_ext = mb_strtolower(mb_substr($linkto, -3));
                        $linkto = mb_substr($linkto, 0, -3) . $linkto_ext;
                        $thumb_css = $this->thumb_css == '' ? 'background-color: #cfcfcf; background-size: contain;border-radius: 5px;' : $this->thumb_css;
                    }

                    //下載次數顯示
                    $show_dl_txt = ($show_dl) ? "<span class='label label-info'>{$file_info['counter']}</span>" : '';

                    //描述顯示
                    $show_description_txt = ($show_description) ? "<div style='font-weight: normal; font-size: 0.8em; word-break: break-all; line-height: 1.2; margin: 4px auto 4px 0px; text-align: left;'>{$i}) {$description} {$show_dl_txt}</div>" : (string) ($show_dl_txt);

                    $w = $this->show_width;
                    $h = $this->show_height;
                    $bgs = $this->background_size;

                    $all_files .= ($show_mode === 'small') ? "<a href='{$linkto}' data-toggle='tooltip' data-placement='top' title='{$description}' class='iconize {$fancyboxset}' {$rel}>&nbsp;</a> " : "
                    <li style='width:120px;height:180px;float:left;list-style:none;{$this->other_css}'>
                    <a href='{$linkto}' class='thumbnail {$fancyboxset}' {$rel} style=\"display:inline-block; width: $w; height: $h; overflow: hidden; {$thumb_css} background-image: url('{$thumb_pic}'); background-size: {$bgs}; background-repeat: no-repeat; background-position: center center; margin-bottom: 4px;\">&nbsp;</a>{$show_description_txt}
                    </li>";
                }

                $i++;
            }

            if ($show_mode === 'file_url') {
                $all_files .= '</ul>';
            } elseif ($show_mode === 'app') {
            } elseif ($show_mode === 'file_text_url' or $show_mode === 'small') {
                $all_files .= '';
            } elseif ($show_mode === 'filename') {
                $all_files .= "</ol><div style='clear:both;'></div>";
            } else {
                $all_files .= "</ul><div style='clear:both;'></div>";
            }
        } else {
            $all_files = '';
        }

        return $all_files;
    }

    //下載並新增計數器
    public function add_file_counter($files_sn = '', $hash = false, $force = false, $path = '')
    {
        global $xoopsDB, $xoopsUser;

        // 權限設定
        if ($this->permission) {
            $sql = 'select gperm_groupid from `' . $xoopsDB->prefix('group_permission') . "` where gperm_name='dl_group' and gperm_itemid='{$files_sn}' order by gperm_groupid";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $gperm_groupid_arr = [];
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

        $file_type = $file['file_type'];
        $file_size = $file['file_size'];
        $real_filename = $file['original_filename'];
        $dl_name = ($this->hash) ? $file['hash_filename'] : $file['file_name'];
        // die($dl_name);
        $sql = "update `{$this->TadUpFilesTblName}` set `counter`=`counter`+1 where `files_sn`='{$files_sn}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        if ($file['kind'] === 'img') {
            $file_saved = "{$this->TadUpFilesImgUrl}/{$dl_name}";
            $file_hd_saved = "{$this->TadUpFilesImgDir}/{$dl_name}";
        } else {
            $file_saved = "{$this->TadUpFilesUrl}/{$dl_name}";
            $file_hd_saved = "{$this->TadUpFilesDir}/{$dl_name}";
        }
        // die($file_hd_saved);

        $os_charset = (PATH_SEPARATOR === ':') ? 'UTF-8' : 'Big5';

        $mimetype = $file_type;
        if (function_exists('mb_http_output')) {
            mb_http_output('pass');
        }

        if ($force) {
            if ($os_charset != _CHARSET) {
                $file_display = iconv($os_charset, _CHARSET, $real_filename);
                $file_hd_saved = iconv($os_charset, _CHARSET, $file_hd_saved);
            } else {
                $file_display = $real_filename;
            }

            header('Expires: 0');
            header('Content-Type: ' . $mimetype);
            //header('Content-Type: application/octet-stream');
            if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT'])) {
                header('Content-Disposition: inline; filename="' . $file_display . '"');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
            } else {
                header('Content-Disposition: attachment; filename="' . $file_display . '"');
                header('Pragma: no-cache');
            }
            //header("Content-Type: application/force-download");
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($file_hd_saved));

            ob_clean();
            $handle = fopen($file_hd_saved, 'rb');

            set_time_limit(0);
            while (!feof($handle)) {
                echo fread($handle, 4096);
                flush();
            }
            fclose($handle);

            die;
        }

        if ($os_charset != _CHARSET) {
            //若網站和主機編碼不同，則將 $file_display (真實檔名) 轉為主機編碼，以便等一下建立檔案
            $file_display = iconv(_CHARSET, $os_charset, $real_filename);
            $file_hd_saved = iconv(_CHARSET, $os_charset, $file_hd_saved);
        } else {
            $file_display = $real_filename;
        }
        // $file_display = \str_replace(' ', '', $file_display);

        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/{$this->dir}");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/{$this->dir}/tmp");
        $tmp_dir = XOOPS_ROOT_PATH . "/uploads/{$this->dir}/tmp/{$file['files_sn']}";
        $tmp_url = XOOPS_URL . "/uploads/{$this->dir}/tmp/{$file['files_sn']}";
        Utility::mk_dir($tmp_dir);
        $tmp_file = $tmp_dir . '/' . $file_display;
        $tmp_file_url = $tmp_url . '/' . $file_display;
        // Utility::dd($force);
        // die("cp $file_hd_saved $tmp_file");
        if (!file_exists($tmp_file)) {
            if (!copy($file_hd_saved, $tmp_file)) {
                $errors = error_get_last();
                echo "COPY ERROR: " . $errors['type'];
                echo "<br />\n" . $errors['message'];
                exit;
            }
        }

        if ($this->auto_charset != 0) {
            $tmp_file_url = Utility::auto_charset($tmp_file_url);
        }

        if (!empty($path)) {
            if (mb_substr($path, -1) === '/') {
                $path = mb_substr($path, 0, -1);
            }
            if (!is_dir($path)) {
                Utility::mk_dir($path);
            }
            rename($tmp_file, $path . '/' . $file_display);
        } else {
            header('Content-Type: application/octet-stream');
            header("location:{$tmp_file_url}");
            exit;
        }
        exit;
    }

    //取得單一檔案資料
    public function get_one_file($files_sn = '')
    {
        global $xoopsDB, $xoopsUser;

        $sql = "select * from `{$this->TadUpFilesTblName}`  where `files_sn`='{$files_sn}'";

        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $xoopsDB->fetchArray($result);
        // die(var_export($all));
        return $all;
    }

    protected function filesize2bytes($str)
    {
        $bytes = 0;

        $bytes_array = [
            'B' => 1,
            'K' => 1024,
            'M' => 1024 * 1024,
            'G' => 1024 * 1024 * 1024,
            'T' => 1024 * 1024 * 1024 * 1024,
            'P' => 1024 * 1024 * 1024 * 1024 * 1024,
        ];

        $bytes = (float) $str;

        if (preg_match('#([KMGTP]?)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) {
            $bytes *= $bytes_array[$matches[1]];
        }

        $bytes = (int) round($bytes, 2);

        return $bytes;
    }

    protected function ext2mime($ext)
    {
        // I made this array by joining all the following lists + .php extension which is missing in all of them.
        // please contribute to this list to make it as accurate and complete as possible.
        // https://gist.github.com/plasticbrain/3887245
        // http://pastie.org/5668002
        // http://pastebin.com/iuTy6K6d
        // total: 1223 extensions as of 16 November 2015
        $all_mimes = [
            '3dm' => ['x-world/x-3dmf'],
            '3dmf' => ['x-world/x-3dmf'],
            '3dml' => ['text/vnd.in3d.3dml'],
            '3ds' => ['image/x-3ds'],
            '3g2' => ['video/3gpp2'],
            '3gp' => ['video/3gpp'],
            '7z' => ['application/x-7z-compressed'],
            'a' => ['application/octet-stream'],
            'aab' => ['application/x-authorware-bin'],
            'aac' => ['audio/x-aac'],
            'aam' => ['application/x-authorware-map'],
            'aas' => ['application/x-authorware-seg'],
            'abc' => ['text/vnd.abc'],
            'abw' => ['application/x-abiword'],
            'ac' => ['application/pkix-attr-cert'],
            'acc' => ['application/vnd.americandynamics.acc'],
            'ace' => ['application/x-ace-compressed'],
            'acgi' => ['text/html'],
            'acu' => ['application/vnd.acucobol'],
            'acutc' => ['application/vnd.acucorp'],
            'adp' => ['audio/adpcm'],
            'aep' => ['application/vnd.audiograph'],
            'afl' => ['video/animaflex'],
            'afm' => ['application/x-font-type1'],
            'afp' => ['application/vnd.ibm.modcap'],
            'ahead' => ['application/vnd.ahead.space'],
            'ai' => ['application/postscript'],
            'aif' => ['audio/aiff', 'audio/x-aiff'],
            'aifc' => ['audio/aiff', 'audio/x-aiff'],
            'aiff' => ['audio/aiff', 'audio/x-aiff'],
            'aim' => ['application/x-aim'],
            'aip' => ['text/x-audiosoft-intra'],
            'air' => ['application/vnd.adobe.air-application-installer-package+zip'],
            'ait' => ['application/vnd.dvb.ait'],
            'ami' => ['application/vnd.amiga.ami'],
            'ani' => ['application/x-navi-animation'],
            'aos' => ['application/x-nokia-9000-communicator-add-on-software'],
            'apk' => ['application/vnd.android.package-archive'],
            'appcache' => ['text/cache-manifest'],
            'application' => ['application/x-ms-application'],
            'apr' => ['application/vnd.lotus-approach'],
            'aps' => ['application/mime'],
            'arc' => ['application/x-freearc'],
            'arj' => ['application/arj', 'application/octet-stream'],
            'art' => ['image/x-jg'],
            'asc' => ['application/pgp-signature'],
            'asf' => ['video/x-ms-asf'],
            'asm' => ['text/x-asm'],
            'aso' => ['application/vnd.accpac.simply.aso'],
            'asp' => ['text/asp'],
            'asx' => ['application/x-mplayer2', 'video/x-ms-asf', 'video/x-ms-asf-plugin'],
            'atc' => ['application/vnd.acucorp'],
            'atom' => ['application/atom+xml'],
            'atomcat' => ['application/atomcat+xml'],
            'atomsvc' => ['application/atomsvc+xml'],
            'atx' => ['application/vnd.antix.game-component'],
            'au' => ['audio/basic'],
            'avi' => ['application/x-troff-msvideo', 'video/avi', 'video/msvideo', 'video/x-msvideo'],
            'avs' => ['video/avs-video'],
            'aw' => ['application/applixware'],
            'azf' => ['application/vnd.airzip.filesecure.azf'],
            'azs' => ['application/vnd.airzip.filesecure.azs'],
            'azw' => ['application/vnd.amazon.ebook'],
            'bat' => ['application/x-msdownload'],
            'bcpio' => ['application/x-bcpio'],
            'bdf' => ['application/x-font-bdf'],
            'bdm' => ['application/vnd.syncml.dm+wbxml'],
            'bed' => ['application/vnd.realvnc.bed'],
            'bh2' => ['application/vnd.fujitsu.oasysprs'],
            'bin' => ['application/mac-binary', 'application/macbinary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'],
            'blb' => ['application/x-blorb'],
            'blorb' => ['application/x-blorb'],
            'bm' => ['image/bmp'],
            'bmi' => ['application/vnd.bmi'],
            'bmp' => ['image/bmp', 'image/x-windows-bmp'],
            'boo' => ['application/book'],
            'book' => ['application/vnd.framemaker'],
            'box' => ['application/vnd.previewsystems.box'],
            'boz' => ['application/x-bzip2'],
            'bpk' => ['application/octet-stream'],
            'bsh' => ['application/x-bsh'],
            'btif' => ['image/prs.btif'],
            'buffer' => ['application/octet-stream'],
            'bz' => ['application/x-bzip'],
            'bz2' => ['application/x-bzip2'],
            'c' => ['text/x-c'],
            'c++' => ['text/plain'],
            'c11amc' => ['application/vnd.cluetrust.cartomobile-config'],
            'c11amz' => ['application/vnd.cluetrust.cartomobile-config-pkg'],
            'c4d' => ['application/vnd.clonk.c4group'],
            'c4f' => ['application/vnd.clonk.c4group'],
            'c4g' => ['application/vnd.clonk.c4group'],
            'c4p' => ['application/vnd.clonk.c4group'],
            'c4u' => ['application/vnd.clonk.c4group'],
            'cab' => ['application/vnd.ms-cab-compressed'],
            'caf' => ['audio/x-caf'],
            'cap' => ['application/vnd.tcpdump.pcap'],
            'car' => ['application/vnd.curl.car'],
            'cat' => ['application/vnd.ms-pki.seccat'],
            'cb7' => ['application/x-cbr'],
            'cba' => ['application/x-cbr'],
            'cbr' => ['application/x-cbr'],
            'cbt' => ['application/x-cbr'],
            'cbz' => ['application/x-cbr'],
            'cc' => ['text/plain', 'text/x-c'],
            'ccad' => ['application/clariscad'],
            'cco' => ['application/x-cocoa'],
            'cct' => ['application/x-director'],
            'ccxml' => ['application/ccxml+xml'],
            'cdbcmsg' => ['application/vnd.contact.cmsg'],
            'cdf' => ['application/cdf', 'application/x-cdf', 'application/x-netcdf'],
            'cdkey' => ['application/vnd.mediastation.cdkey'],
            'cdmia' => ['application/cdmi-capability'],
            'cdmic' => ['application/cdmi-container'],
            'cdmid' => ['application/cdmi-domain'],
            'cdmio' => ['application/cdmi-object'],
            'cdmiq' => ['application/cdmi-queue'],
            'cdx' => ['chemical/x-cdx'],
            'cdxml' => ['application/vnd.chemdraw+xml'],
            'cdy' => ['application/vnd.cinderella'],
            'cer' => ['application/pkix-cert', 'application/x-x509-ca-cert'],
            'cfs' => ['application/x-cfs-compressed'],
            'cgm' => ['image/cgm'],
            'cha' => ['application/x-chat'],
            'chat' => ['application/x-chat'],
            'chm' => ['application/vnd.ms-htmlhelp'],
            'chrt' => ['application/vnd.kde.kchart'],
            'cif' => ['chemical/x-cif'],
            'cii' => ['application/vnd.anser-web-certificate-issue-initiation'],
            'cil' => ['application/vnd.ms-artgalry'],
            'cla' => ['application/vnd.claymore'],
            'class' => ['application/java', 'application/java-byte-code', 'application/x-java-class'],
            'clkk' => ['application/vnd.crick.clicker.keyboard'],
            'clkp' => ['application/vnd.crick.clicker.palette'],
            'clkt' => ['application/vnd.crick.clicker.template'],
            'clkw' => ['application/vnd.crick.clicker.wordbank'],
            'clkx' => ['application/vnd.crick.clicker'],
            'clp' => ['application/x-msclip'],
            'cmc' => ['application/vnd.cosmocaller'],
            'cmdf' => ['chemical/x-cmdf'],
            'cml' => ['chemical/x-cml'],
            'cmp' => ['application/vnd.yellowriver-custom-menu'],
            'cmx' => ['image/x-cmx'],
            'cod' => ['application/vnd.rim.cod'],
            'com' => ['application/octet-stream', 'text/plain'],
            'conf' => ['text/plain'],
            'cpio' => ['application/x-cpio'],
            'cpp' => ['text/x-c'],
            'cpt' => ['application/x-compactpro', 'application/x-cpt'],
            'crd' => ['application/x-mscardfile'],
            'crl' => ['application/pkcs-crl', 'application/pkix-crl'],
            'crt' => ['application/pkix-cert', 'application/x-x509-ca-cert', 'application/x-x509-user-cert'],
            'crx' => ['application/x-chrome-extension'],
            'cryptonote' => ['application/vnd.rig.cryptonote'],
            'csh' => ['application/x-csh', 'text/x-script.csh'],
            'csml' => ['chemical/x-csml'],
            'csp' => ['application/vnd.commonspace'],
            'css' => ['application/x-pointplus', 'text/css'],
            'cst' => ['application/x-director'],
            'csv' => ['text/csv'],
            'cu' => ['application/cu-seeme'],
            'curl' => ['text/vnd.curl'],
            'cww' => ['application/prs.cww'],
            'cxt' => ['application/x-director'],
            'cxx' => ['text/x-c'],
            'dae' => ['model/vnd.collada+xml'],
            'daf' => ['application/vnd.mobius.daf'],
            'dart' => ['application/vnd.dart'],
            'dataless' => ['application/vnd.fdsn.seed'],
            'davmount' => ['application/davmount+xml'],
            'dbk' => ['application/docbook+xml'],
            'dcr' => ['application/x-director'],
            'dcurl' => ['text/vnd.curl.dcurl'],
            'dd2' => ['application/vnd.oma.dd2+xml'],
            'ddd' => ['application/vnd.fujixerox.ddd'],
            'deb' => ['application/x-debian-package'],
            'deepv' => ['application/x-deepv'],
            'def' => ['text/plain'],
            'deploy' => ['application/octet-stream'],
            'der' => ['application/x-x509-ca-cert'],
            'dfac' => ['application/vnd.dreamfactory'],
            'dgc' => ['application/x-dgc-compressed'],
            'dic' => ['text/x-c'],
            'dif' => ['video/x-dv'],
            'diff' => ['text/plain'],
            'dir' => ['application/x-director'],
            'dis' => ['application/vnd.mobius.dis'],
            'dist' => ['application/octet-stream'],
            'distz' => ['application/octet-stream'],
            'djv' => ['image/vnd.djvu'],
            'djvu' => ['image/vnd.djvu'],
            'dl' => ['video/dl', 'video/x-dl'],
            'dll' => ['application/x-msdownload'],
            'dmg' => ['application/x-apple-diskimage'],
            'dmp' => ['application/vnd.tcpdump.pcap'],
            'dms' => ['application/octet-stream'],
            'dna' => ['application/vnd.dna'],
            'doc' => ['application/msword'],
            'docm' => ['application/vnd.ms-word.document.macroenabled.12'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'dot' => ['application/msword'],
            'dotm' => ['application/vnd.ms-word.template.macroenabled.12'],
            'dotx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.template'],
            'dp' => ['application/vnd.osgi.dp'],
            'dpg' => ['application/vnd.dpgraph'],
            'dra' => ['audio/vnd.dra'],
            'drw' => ['application/drafting'],
            'dsc' => ['text/prs.lines.tag'],
            'dssc' => ['application/dssc+der'],
            'dtb' => ['application/x-dtbook+xml'],
            'dtd' => ['application/xml-dtd'],
            'dts' => ['audio/vnd.dts'],
            'dtshd' => ['audio/vnd.dts.hd'],
            'dump' => ['application/octet-stream'],
            'dv' => ['video/x-dv'],
            'dvb' => ['video/vnd.dvb.file'],
            'dvi' => ['application/x-dvi'],
            'dwf' => ['drawing/x-dwf (old)', 'model/vnd.dwf'],
            'dwg' => ['application/acad', 'image/vnd.dwg', 'image/x-dwg'],
            'dxf' => ['image/vnd.dxf'],
            'dxp' => ['application/vnd.spotfire.dxp'],
            'dxr' => ['application/x-director'],
            'ecelp4800' => ['audio/vnd.nuera.ecelp4800'],
            'ecelp7470' => ['audio/vnd.nuera.ecelp7470'],
            'ecelp9600' => ['audio/vnd.nuera.ecelp9600'],
            'ecma' => ['application/ecmascript'],
            'edm' => ['application/vnd.novadigm.edm'],
            'edx' => ['application/vnd.novadigm.edx'],
            'efif' => ['application/vnd.picsel'],
            'ei6' => ['application/vnd.pg.osasli'],
            'el' => ['text/x-script.elisp'],
            'elc' => ['application/x-bytecode.elisp (compiled elisp)', 'application/x-elc'],
            'emf' => ['application/x-msmetafile'],
            'eml' => ['message/rfc822'],
            'emma' => ['application/emma+xml'],
            'emz' => ['application/x-msmetafile'],
            'env' => ['application/x-envoy'],
            'eol' => ['audio/vnd.digital-winds'],
            'eot' => ['application/vnd.ms-fontobject'],
            'eps' => ['application/postscript'],
            'epub' => ['application/epub+zip'],
            'es' => ['application/x-esrehber'],
            'es3' => ['application/vnd.eszigno3+xml'],
            'esa' => ['application/vnd.osgi.subsystem'],
            'esf' => ['application/vnd.epson.esf'],
            'et3' => ['application/vnd.eszigno3+xml'],
            'etx' => ['text/x-setext'],
            'eva' => ['application/x-eva'],
            'event-stream' => ['text/event-stream'],
            'evy' => ['application/envoy', 'application/x-envoy'],
            'exe' => ['application/x-msdownload'],
            'exi' => ['application/exi'],
            'ext' => ['application/vnd.novadigm.ext'],
            'ez' => ['application/andrew-inset'],
            'ez2' => ['application/vnd.ezpix-album'],
            'ez3' => ['application/vnd.ezpix-package'],
            'f' => ['text/plain', 'text/x-fortran'],
            'f4v' => ['video/x-f4v'],
            'f77' => ['text/x-fortran'],
            'f90' => ['text/plain', 'text/x-fortran'],
            'fbs' => ['image/vnd.fastbidsheet'],
            'fcdt' => ['application/vnd.adobe.formscentral.fcdt'],
            'fcs' => ['application/vnd.isac.fcs'],
            'fdf' => ['application/vnd.fdf'],
            'fe_launch' => ['application/vnd.denovo.fcselayout-link'],
            'fg5' => ['application/vnd.fujitsu.oasysgp'],
            'fgd' => ['application/x-director'],
            'fh' => ['image/x-freehand'],
            'fh4' => ['image/x-freehand'],
            'fh5' => ['image/x-freehand'],
            'fh7' => ['image/x-freehand'],
            'fhc' => ['image/x-freehand'],
            'fif' => ['application/fractals', 'image/fif'],
            'fig' => ['application/x-xfig'],
            'flac' => ['audio/flac'],
            'fli' => ['video/fli', 'video/x-fli'],
            'flo' => ['application/vnd.micrografx.flo'],
            'flv' => ['video/x-flv'],
            'flw' => ['application/vnd.kde.kivio'],
            'flx' => ['text/vnd.fmi.flexstor'],
            'fly' => ['text/vnd.fly'],
            'fm' => ['application/vnd.framemaker'],
            'fmf' => ['video/x-atomic3d-feature'],
            'fnc' => ['application/vnd.frogans.fnc'],
            'for' => ['text/plain', 'text/x-fortran'],
            'fpx' => ['image/vnd.fpx', 'image/vnd.net-fpx'],
            'frame' => ['application/vnd.framemaker'],
            'frl' => ['application/freeloader'],
            'fsc' => ['application/vnd.fsc.weblaunch'],
            'fst' => ['image/vnd.fst'],
            'ftc' => ['application/vnd.fluxtime.clip'],
            'fti' => ['application/vnd.anser-web-funds-transfer-initiation'],
            'funk' => ['audio/make'],
            'fvt' => ['video/vnd.fvt'],
            'fxp' => ['application/vnd.adobe.fxp'],
            'fxpl' => ['application/vnd.adobe.fxp'],
            'fzs' => ['application/vnd.fuzzysheet'],
            'g' => ['text/plain'],
            'g2w' => ['application/vnd.geoplan'],
            'g3' => ['image/g3fax'],
            'g3w' => ['application/vnd.geospace'],
            'gac' => ['application/vnd.groove-account'],
            'gam' => ['application/x-tads'],
            'gbr' => ['application/rpki-ghostbusters'],
            'gca' => ['application/x-gca-compressed'],
            'gdl' => ['model/vnd.gdl'],
            'geo' => ['application/vnd.dynageo'],
            'gex' => ['application/vnd.geometry-explorer'],
            'ggb' => ['application/vnd.geogebra.file'],
            'ggt' => ['application/vnd.geogebra.tool'],
            'ghf' => ['application/vnd.groove-help'],
            'gif' => ['image/gif'],
            'gim' => ['application/vnd.groove-identity-message'],
            'gl' => ['video/gl', 'video/x-gl'],
            'gml' => ['application/gml+xml'],
            'gmx' => ['application/vnd.gmx'],
            'gnumeric' => ['application/x-gnumeric'],
            'gph' => ['application/vnd.flographit'],
            'gpx' => ['application/gpx+xml'],
            'gqf' => ['application/vnd.grafeq'],
            'gqs' => ['application/vnd.grafeq'],
            'gram' => ['application/srgs'],
            'gramps' => ['application/x-gramps-xml'],
            'gre' => ['application/vnd.geometry-explorer'],
            'grv' => ['application/vnd.groove-injector'],
            'grxml' => ['application/srgs+xml'],
            'gsd' => ['audio/x-gsm'],
            'gsf' => ['application/x-font-ghostscript'],
            'gsm' => ['audio/x-gsm'],
            'gsp' => ['application/x-gsp'],
            'gss' => ['application/x-gss'],
            'gtar' => ['application/x-gtar'],
            'gtm' => ['application/vnd.groove-tool-message'],
            'gtw' => ['model/vnd.gtw'],
            'gv' => ['text/vnd.graphviz'],
            'gxf' => ['application/gxf'],
            'gxt' => ['application/vnd.geonext'],
            'gz' => ['application/x-compressed', 'application/x-gzip'],
            'gzip' => ['application/x-gzip', 'multipart/x-gzip'],
            'h' => ['text/plain', 'text/x-h'],
            'h261' => ['video/h261'],
            'h263' => ['video/h263'],
            'h264' => ['video/h264'],
            'hal' => ['application/vnd.hal+xml'],
            'hbci' => ['application/vnd.hbci'],
            'hdf' => ['application/x-hdf'],
            'help' => ['application/x-helpfile'],
            'hgl' => ['application/vnd.hp-hpgl'],
            'hh' => ['text/plain', 'text/x-h'],
            'hlb' => ['text/x-script'],
            'hlp' => ['application/hlp', 'application/x-helpfile', 'application/x-winhelp'],
            'hpg' => ['application/vnd.hp-hpgl'],
            'hpgl' => ['application/vnd.hp-hpgl'],
            'hpid' => ['application/vnd.hp-hpid'],
            'hps' => ['application/vnd.hp-hps'],
            'hqx' => ['application/binhex', 'application/binhex4', 'application/mac-binhex', 'application/mac-binhex40', 'application/x-binhex40', 'application/x-mac-binhex40'],
            'hta' => ['application/hta'],
            'htc' => ['text/x-component'],
            'htke' => ['application/vnd.kenameaapp'],
            'htm' => ['text/html'],
            'html' => ['text/html'],
            'htmls' => ['text/html'],
            'htt' => ['text/webviewhtml'],
            'htx' => ['text/html'],
            'hvd' => ['application/vnd.yamaha.hv-dic'],
            'hvp' => ['application/vnd.yamaha.hv-voice'],
            'hvs' => ['application/vnd.yamaha.hv-script'],
            'i2g' => ['application/vnd.intergeo'],
            'icc' => ['application/vnd.iccprofile'],
            'ice' => ['x-conference/x-cooltalk'],
            'icm' => ['application/vnd.iccprofile'],
            'ico' => ['image/x-icon'],
            'ics' => ['text/calendar'],
            'idc' => ['text/plain'],
            'ief' => ['image/ief'],
            'iefs' => ['image/ief'],
            'ifb' => ['text/calendar'],
            'ifm' => ['application/vnd.shana.informed.formdata'],
            'iges' => ['application/iges', 'model/iges'],
            'igl' => ['application/vnd.igloader'],
            'igm' => ['application/vnd.insors.igm'],
            'igs' => ['application/iges', 'model/iges'],
            'igx' => ['application/vnd.micrografx.igx'],
            'iif' => ['application/vnd.shana.informed.interchange'],
            'ima' => ['application/x-ima'],
            'imap' => ['application/x-httpd-imap'],
            'imp' => ['application/vnd.accpac.simply.imp'],
            'ims' => ['application/vnd.ms-ims'],
            'in' => ['text/plain'],
            'inf' => ['application/inf'],
            'ink' => ['application/inkml+xml'],
            'inkml' => ['application/inkml+xml'],
            'ins' => ['application/x-internett-signup'],
            'install' => ['application/x-install-instructions'],
            'iota' => ['application/vnd.astraea-software.iota'],
            'ip' => ['application/x-ip2'],
            'ipfix' => ['application/ipfix'],
            'ipk' => ['application/vnd.shana.informed.package'],
            'irm' => ['application/vnd.ibm.rights-management'],
            'irp' => ['application/vnd.irepository.package+xml'],
            'iso' => ['application/x-iso9660-image'],
            'isu' => ['video/x-isvideo'],
            'it' => ['audio/it'],
            'itp' => ['application/vnd.shana.informed.formtemplate'],
            'iv' => ['application/x-inventor'],
            'ivp' => ['application/vnd.immervision-ivp'],
            'ivr' => ['i-world/i-vrml'],
            'ivu' => ['application/vnd.immervision-ivu'],
            'ivy' => ['application/x-livescreen'],
            'jad' => ['text/vnd.sun.j2me.app-descriptor'],
            'jam' => ['application/vnd.jam'],
            'jar' => ['application/java-archive'],
            'jav' => ['text/plain', 'text/x-java-source'],
            'java' => ['text/plain', 'text/x-java-source'],
            'jcm' => ['application/x-java-commerce'],
            'jfif' => ['image/jpeg', 'image/pjpeg'],
            'jfif-tbnl' => ['image/jpeg'],
            'jisp' => ['application/vnd.jisp'],
            'jlt' => ['application/vnd.hp-jlyt'],
            'jnlp' => ['application/x-java-jnlp-file'],
            'joda' => ['application/vnd.joost.joda-archive'],
            'jpe' => ['image/jpeg', 'image/pjpeg'],
            'jpeg' => ['image/jpeg', 'image/pjpeg'],
            'jpg' => ['image/jpeg', 'image/pjpeg'],
            'jpgm' => ['video/jpm'],
            'jpgv' => ['video/jpeg'],
            'jpm' => ['video/jpm'],
            'jps' => ['image/x-jps'],
            'js' => ['application/javascript'],
            'json' => ['application/json', 'text/plain'],
            'jsonml' => ['application/jsonml+json'],
            'jut' => ['image/jutvision'],
            'kar' => ['audio/midi', 'music/x-karaoke'],
            'karbon' => ['application/vnd.kde.karbon'],
            'kfo' => ['application/vnd.kde.kformula'],
            'kia' => ['application/vnd.kidspiration'],
            'kil' => ['application/x-killustrator'],
            'kml' => ['application/vnd.google-earth.kml+xml'],
            'kmz' => ['application/vnd.google-earth.kmz'],
            'kne' => ['application/vnd.kinar'],
            'knp' => ['application/vnd.kinar'],
            'kon' => ['application/vnd.kde.kontour'],
            'kpr' => ['application/vnd.kde.kpresenter'],
            'kpt' => ['application/vnd.kde.kpresenter'],
            'kpxx' => ['application/vnd.ds-keypoint'],
            'ksh' => ['application/x-ksh', 'text/x-script.ksh'],
            'ksp' => ['application/vnd.kde.kspread'],
            'ktr' => ['application/vnd.kahootz'],
            'ktx' => ['image/ktx'],
            'ktz' => ['application/vnd.kahootz'],
            'kwd' => ['application/vnd.kde.kword'],
            'kwt' => ['application/vnd.kde.kword'],
            'la' => ['audio/nspaudio', 'audio/x-nspaudio'],
            'lam' => ['audio/x-liveaudio'],
            'lasxml' => ['application/vnd.las.las+xml'],
            'latex' => ['application/x-latex'],
            'lbd' => ['application/vnd.llamagraphics.life-balance.desktop'],
            'lbe' => ['application/vnd.llamagraphics.life-balance.exchange+xml'],
            'les' => ['application/vnd.hhe.lesson-player'],
            'lha' => ['application/lha', 'application/octet-stream', 'application/x-lha'],
            'lhx' => ['application/octet-stream'],
            'link66' => ['application/vnd.route66.link66+xml'],
            'list' => ['text/plain'],
            'list3820' => ['application/vnd.ibm.modcap'],
            'listafp' => ['application/vnd.ibm.modcap'],
            'lma' => ['audio/nspaudio', 'audio/x-nspaudio'],
            'lnk' => ['application/x-ms-shortcut'],
            'log' => ['text/plain'],
            'lostxml' => ['application/lost+xml'],
            'lrf' => ['application/octet-stream'],
            'lrm' => ['application/vnd.ms-lrm'],
            'lsp' => ['application/x-lisp', 'text/x-script.lisp'],
            'lst' => ['text/plain'],
            'lsx' => ['text/x-la-asf'],
            'ltf' => ['application/vnd.frogans.ltf'],
            'ltx' => ['application/x-latex'],
            'lua' => ['text/x-lua'],
            'luac' => ['application/x-lua-bytecode'],
            'lvp' => ['audio/vnd.lucent.voice'],
            'lwp' => ['application/vnd.lotus-wordpro'],
            'lzh' => ['application/octet-stream', 'application/x-lzh'],
            'lzx' => ['application/lzx', 'application/octet-stream', 'application/x-lzx'],
            'm' => ['text/plain', 'text/x-m'],
            'm13' => ['application/x-msmediaview'],
            'm14' => ['application/x-msmediaview'],
            'm1v' => ['video/mpeg'],
            'm21' => ['application/mp21'],
            'm2a' => ['audio/mpeg'],
            'm2v' => ['video/mpeg'],
            'm3a' => ['audio/mpeg'],
            'm3u' => ['audio/x-mpegurl'],
            'm3u8' => ['application/x-mpegURL'],
            'm4a' => ['audio/mp4'],
            'm4p' => ['application/mp4'],
            'm4u' => ['video/vnd.mpegurl'],
            'm4v' => ['video/x-m4v'],
            'ma' => ['application/mathematica'],
            'mads' => ['application/mads+xml'],
            'mag' => ['application/vnd.ecowin.chart'],
            'maker' => ['application/vnd.framemaker'],
            'man' => ['text/troff'],
            'manifest' => ['text/cache-manifest'],
            'map' => ['application/x-navimap'],
            'mar' => ['application/octet-stream'],
            'markdown' => ['text/x-markdown'],
            'mathml' => ['application/mathml+xml'],
            'mb' => ['application/mathematica'],
            'mbd' => ['application/mbedlet'],
            'mbk' => ['application/vnd.mobius.mbk'],
            'mbox' => ['application/mbox'],
            'mc' => ['application/x-magic-cap-package-1.0'],
            'mc1' => ['application/vnd.medcalcdata'],
            'mcd' => ['application/mcad', 'application/x-mathcad'],
            'mcf' => ['image/vasa', 'text/mcf'],
            'mcp' => ['application/netmc'],
            'mcurl' => ['text/vnd.curl.mcurl'],
            'md' => ['text/x-markdown'],
            'mdb' => ['application/x-msaccess'],
            'mdi' => ['image/vnd.ms-modi'],
            'me' => ['text/troff'],
            'mesh' => ['model/mesh'],
            'meta4' => ['application/metalink4+xml'],
            'metalink' => ['application/metalink+xml'],
            'mets' => ['application/mets+xml'],
            'mfm' => ['application/vnd.mfmp'],
            'mft' => ['application/rpki-manifest'],
            'mgp' => ['application/vnd.osgeo.mapguide.package'],
            'mgz' => ['application/vnd.proteus.magazine'],
            'mht' => ['message/rfc822'],
            'mhtml' => ['message/rfc822'],
            'mid' => ['application/x-midi', 'audio/midi', 'audio/x-mid', 'audio/x-midi', 'music/crescendo', 'x-music/x-midi'],
            'midi' => ['application/x-midi', 'audio/midi', 'audio/x-mid', 'audio/x-midi', 'music/crescendo', 'x-music/x-midi'],
            'mie' => ['application/x-mie'],
            'mif' => ['application/x-frame', 'application/x-mif'],
            'mime' => ['message/rfc822', 'www/mime'],
            'mj2' => ['video/mj2'],
            'mjf' => ['audio/x-vnd.audioexplosion.mjuicemediafile'],
            'mjp2' => ['video/mj2'],
            'mjpg' => ['video/x-motion-jpeg'],
            'mk3d' => ['video/x-matroska'],
            'mka' => ['audio/x-matroska'],
            'mkd' => ['text/x-markdown'],
            'mks' => ['video/x-matroska'],
            'mkv' => ['video/x-matroska'],
            'mlp' => ['application/vnd.dolby.mlp'],
            'mm' => ['application/base64', 'application/x-meme'],
            'mmd' => ['application/vnd.chipnuts.karaoke-mmd'],
            'mme' => ['application/base64'],
            'mmf' => ['application/vnd.smaf'],
            'mmr' => ['image/vnd.fujixerox.edmics-mmr'],
            'mng' => ['video/x-mng'],
            'mny' => ['application/x-msmoney'],
            'mobi' => ['application/x-mobipocket-ebook'],
            'mod' => ['audio/mod', 'audio/x-mod'],
            'mods' => ['application/mods+xml'],
            'moov' => ['video/quicktime'],
            'mov' => ['video/quicktime'],
            'movie' => ['video/x-sgi-movie'],
            'mp2' => ['audio/mpeg', 'audio/x-mpeg', 'video/mpeg', 'video/x-mpeg', 'video/x-mpeq2a'],
            'mp21' => ['application/mp21'],
            'mp2a' => ['audio/mpeg'],
            'mp3' => ['audio/mpeg3', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg'],
            'mp4' => ['video/mp4'],
            'mp4a' => ['audio/mp4'],
            'mp4s' => ['application/mp4'],
            'mp4v' => ['video/mp4'],
            'mpa' => ['audio/mpeg', 'video/mpeg'],
            'mpc' => ['application/vnd.mophun.certificate'],
            'mpe' => ['video/mpeg'],
            'mpeg' => ['video/mpeg'],
            'mpg' => ['audio/mpeg', 'video/mpeg'],
            'mpg4' => ['video/mp4'],
            'mpga' => ['audio/mpeg'],
            'mpkg' => ['application/vnd.apple.installer+xml'],
            'mpm' => ['application/vnd.blueice.multipass'],
            'mpn' => ['application/vnd.mophun.application'],
            'mpp' => ['application/vnd.ms-project'],
            'mpt' => ['application/vnd.ms-project'],
            'mpv' => ['application/x-project'],
            'mpx' => ['application/x-project'],
            'mpy' => ['application/vnd.ibm.minipay'],
            'mqy' => ['application/vnd.mobius.mqy'],
            'mrc' => ['application/marc'],
            'mrcx' => ['application/marcxml+xml'],
            'ms' => ['text/troff'],
            'mscml' => ['application/mediaservercontrol+xml'],
            'mseed' => ['application/vnd.fdsn.mseed'],
            'mseq' => ['application/vnd.mseq'],
            'msf' => ['application/vnd.epson.msf'],
            'msh' => ['model/mesh'],
            'msi' => ['application/x-msdownload'],
            'msl' => ['application/vnd.mobius.msl'],
            'msty' => ['application/vnd.muvee.style'],
            'mts' => ['model/vnd.mts'],
            'mus' => ['application/vnd.musician'],
            'musicxml' => ['application/vnd.recordare.musicxml+xml'],
            'mv' => ['video/x-sgi-movie'],
            'mvb' => ['application/x-msmediaview'],
            'mwf' => ['application/vnd.mfer'],
            'mxf' => ['application/mxf'],
            'mxl' => ['application/vnd.recordare.musicxml'],
            'mxml' => ['application/xv+xml'],
            'mxs' => ['application/vnd.triscape.mxs'],
            'mxu' => ['video/vnd.mpegurl'],
            'my' => ['audio/make'],
            'mzz' => ['application/x-vnd.audioexplosion.mzz'],
            'n-gage' => ['application/vnd.nokia.n-gage.symbian.install'],
            'n3' => ['text/n3'],
            'nap' => ['image/naplps'],
            'naplps' => ['image/naplps'],
            'nb' => ['application/mathematica'],
            'nbp' => ['application/vnd.wolfram.player'],
            'nc' => ['application/x-netcdf'],
            'ncm' => ['application/vnd.nokia.configuration-message'],
            'ncx' => ['application/x-dtbncx+xml'],
            'nfo' => ['text/x-nfo'],
            'ngdat' => ['application/vnd.nokia.n-gage.data'],
            'nif' => ['image/x-niff'],
            'niff' => ['image/x-niff'],
            'nitf' => ['application/vnd.nitf'],
            'nix' => ['application/x-mix-transfer'],
            'nlu' => ['application/vnd.neurolanguage.nlu'],
            'nml' => ['application/vnd.enliven'],
            'nnd' => ['application/vnd.noblenet-directory'],
            'nns' => ['application/vnd.noblenet-sealer'],
            'nnw' => ['application/vnd.noblenet-web'],
            'npx' => ['image/vnd.net-fpx'],
            'nsc' => ['application/x-conference'],
            'nsf' => ['application/vnd.lotus-notes'],
            'ntf' => ['application/vnd.nitf'],
            'nvd' => ['application/x-navidoc'],
            'nws' => ['message/rfc822'],
            'nzb' => ['application/x-nzb'],
            'o' => ['application/octet-stream'],
            'oa2' => ['application/vnd.fujitsu.oasys2'],
            'oa3' => ['application/vnd.fujitsu.oasys3'],
            'oas' => ['application/vnd.fujitsu.oasys'],
            'obd' => ['application/x-msbinder'],
            'obj' => ['application/x-tgif'],
            'oda' => ['application/oda'],
            'odb' => ['application/vnd.oasis.opendocument.database'],
            'odc' => ['application/vnd.oasis.opendocument.chart'],
            'odf' => ['application/vnd.oasis.opendocument.formula'],
            'odft' => ['application/vnd.oasis.opendocument.formula-template'],
            'odg' => ['application/vnd.oasis.opendocument.graphics'],
            'odi' => ['application/vnd.oasis.opendocument.image'],
            'odm' => ['application/vnd.oasis.opendocument.text-master'],
            'odp' => ['application/vnd.oasis.opendocument.presentation'],
            'ods' => ['application/vnd.oasis.opendocument.spreadsheet'],
            'odt' => ['application/vnd.oasis.opendocument.text'],
            'oga' => ['audio/ogg'],
            'ogg' => ['audio/ogg'],
            'ogv' => ['video/ogg'],
            'ogx' => ['application/ogg'],
            'omc' => ['application/x-omc'],
            'omcd' => ['application/x-omcdatamaker'],
            'omcr' => ['application/x-omcregerator'],
            'omdoc' => ['application/omdoc+xml'],
            'onepkg' => ['application/onenote'],
            'onetmp' => ['application/onenote'],
            'onetoc' => ['application/onenote'],
            'onetoc2' => ['application/onenote'],
            'opf' => ['application/oebps-package+xml'],
            'opml' => ['text/x-opml'],
            'oprc' => ['application/vnd.palm'],
            'org' => ['application/vnd.lotus-organizer'],
            'osf' => ['application/vnd.yamaha.openscoreformat'],
            'osfpvg' => ['application/vnd.yamaha.openscoreformat.osfpvg+xml'],
            'otc' => ['application/vnd.oasis.opendocument.chart-template'],
            'otf' => ['font/opentype'],
            'otg' => ['application/vnd.oasis.opendocument.graphics-template'],
            'oth' => ['application/vnd.oasis.opendocument.text-web'],
            'oti' => ['application/vnd.oasis.opendocument.image-template'],
            'otm' => ['application/vnd.oasis.opendocument.text-master'],
            'otp' => ['application/vnd.oasis.opendocument.presentation-template'],
            'ots' => ['application/vnd.oasis.opendocument.spreadsheet-template'],
            'ott' => ['application/vnd.oasis.opendocument.text-template'],
            'oxps' => ['application/oxps'],
            'oxt' => ['application/vnd.openofficeorg.extension'],
            'p' => ['text/x-pascal'],
            'p10' => ['application/pkcs10', 'application/x-pkcs10'],
            'p12' => ['application/pkcs-12', 'application/x-pkcs12'],
            'p7a' => ['application/x-pkcs7-signature'],
            'p7b' => ['application/x-pkcs7-certificates'],
            'p7c' => ['application/pkcs7-mime', 'application/x-pkcs7-mime'],
            'p7m' => ['application/pkcs7-mime', 'application/x-pkcs7-mime'],
            'p7r' => ['application/x-pkcs7-certreqresp'],
            'p7s' => ['application/pkcs7-signature'],
            'p8' => ['application/pkcs8'],
            'part' => ['application/pro_eng'],
            'pas' => ['text/x-pascal'],
            'paw' => ['application/vnd.pawaafile'],
            'pbd' => ['application/vnd.powerbuilder6'],
            'pbm' => ['image/x-portable-bitmap'],
            'pcap' => ['application/vnd.tcpdump.pcap'],
            'pcf' => ['application/x-font-pcf'],
            'pcl' => ['application/vnd.hp-pcl', 'application/x-pcl'],
            'pclxl' => ['application/vnd.hp-pclxl'],
            'pct' => ['image/x-pict'],
            'pcurl' => ['application/vnd.curl.pcurl'],
            'pcx' => ['image/x-pcx'],
            'pdb' => ['application/vnd.palm'],
            'pdf' => ['application/pdf'],
            'pfa' => ['application/x-font-type1'],
            'pfb' => ['application/x-font-type1'],
            'pfm' => ['application/x-font-type1'],
            'pfr' => ['application/font-tdpfr'],
            'pfunk' => ['audio/make'],
            'pfx' => ['application/x-pkcs12'],
            'pgm' => ['image/x-portable-graymap'],
            'pgn' => ['application/x-chess-pgn'],
            'pgp' => ['application/pgp-encrypted'],
            'php' => ['text/x-php'],
            'pic' => ['image/x-pict'],
            'pict' => ['image/pict'],
            'pkg' => ['application/octet-stream'],
            'pki' => ['application/pkixcmp'],
            'pkipath' => ['application/pkix-pkipath'],
            'pko' => ['application/vnd.ms-pki.pko'],
            'pl' => ['text/plain', 'text/x-script.perl'],
            'plb' => ['application/vnd.3gpp.pic-bw-large'],
            'plc' => ['application/vnd.mobius.plc'],
            'plf' => ['application/vnd.pocketlearn'],
            'pls' => ['application/pls+xml'],
            'plx' => ['application/x-pixclscript'],
            'pm' => ['image/x-xpixmap', 'text/x-script.perl-module'],
            'pm4' => ['application/x-pagemaker'],
            'pm5' => ['application/x-pagemaker'],
            'pml' => ['application/vnd.ctc-posml'],
            'png' => ['image/png'],
            'pnm' => ['application/x-portable-anymap', 'image/x-portable-anymap'],
            'portpkg' => ['application/vnd.macports.portpkg'],
            'pot' => ['application/mspowerpoint', 'application/vnd.ms-powerpoint'],
            'potm' => ['application/vnd.ms-powerpoint.template.macroenabled.12'],
            'potx' => ['application/vnd.openxmlformats-officedocument.presentationml.template'],
            'pov' => ['model/x-pov'],
            'ppa' => ['application/vnd.ms-powerpoint'],
            'ppam' => ['application/vnd.ms-powerpoint.addin.macroenabled.12'],
            'ppd' => ['application/vnd.cups-ppd'],
            'ppm' => ['image/x-portable-pixmap'],
            'pps' => ['application/mspowerpoint', 'application/vnd.ms-powerpoint'],
            'ppsm' => ['application/vnd.ms-powerpoint.slideshow.macroenabled.12'],
            'ppsx' => ['application/vnd.openxmlformats-officedocument.presentationml.slideshow'],
            'ppt' => ['application/mspowerpoint', 'application/powerpoint', 'application/vnd.ms-powerpoint', 'application/x-mspowerpoint'],
            'pptm' => ['application/vnd.ms-powerpoint.presentation.macroenabled.12'],
            'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
            'ppz' => ['application/mspowerpoint'],
            'pqa' => ['application/vnd.palm'],
            'prc' => ['application/x-mobipocket-ebook'],
            'pre' => ['application/vnd.lotus-freelance'],
            'prf' => ['application/pics-rules'],
            'prt' => ['application/pro_eng'],
            'ps' => ['application/postscript'],
            'psb' => ['application/vnd.3gpp.pic-bw-small'],
            'psd' => ['image/vnd.adobe.photoshop'],
            'psf' => ['application/x-font-linux-psf'],
            'pskcxml' => ['application/pskc+xml'],
            'ptid' => ['application/vnd.pvi.ptid1'],
            'pub' => ['application/x-mspublisher'],
            'pvb' => ['application/vnd.3gpp.pic-bw-var'],
            'pvu' => ['paleovu/x-pv'],
            'pwn' => ['application/vnd.3m.post-it-notes'],
            'pwz' => ['application/vnd.ms-powerpoint'],
            'py' => ['text/x-script.phyton'],
            'pya' => ['audio/vnd.ms-playready.media.pya'],
            'pyc' => ['applicaiton/x-bytecode.python'],
            'pyo' => ['application/x-python-code'],
            'pyv' => ['video/vnd.ms-playready.media.pyv'],
            'qam' => ['application/vnd.epson.quickanime'],
            'qbo' => ['application/vnd.intu.qbo'],
            'qcp' => ['audio/vnd.qcelp'],
            'qd3' => ['x-world/x-3dmf'],
            'qd3d' => ['x-world/x-3dmf'],
            'qfx' => ['application/vnd.intu.qfx'],
            'qif' => ['image/x-quicktime'],
            'qps' => ['application/vnd.publishare-delta-tree'],
            'qt' => ['video/quicktime'],
            'qtc' => ['video/x-qtc'],
            'qti' => ['image/x-quicktime'],
            'qtif' => ['image/x-quicktime'],
            'qwd' => ['application/vnd.quark.quarkxpress'],
            'qwt' => ['application/vnd.quark.quarkxpress'],
            'qxb' => ['application/vnd.quark.quarkxpress'],
            'qxd' => ['application/vnd.quark.quarkxpress'],
            'qxl' => ['application/vnd.quark.quarkxpress'],
            'qxt' => ['application/vnd.quark.quarkxpress'],
            'ra' => ['audio/x-pn-realaudio', 'audio/x-pn-realaudio-plugin', 'audio/x-realaudio'],
            'ram' => ['audio/x-pn-realaudio'],
            'rar' => ['application/x-rar-compressed'],
            'ras' => ['application/x-cmu-raster', 'image/cmu-raster', 'image/x-cmu-raster'],
            'rast' => ['image/cmu-raster'],
            'rcprofile' => ['application/vnd.ipunplugged.rcprofile'],
            'rdf' => ['application/rdf+xml'],
            'rdz' => ['application/vnd.data-vision.rdz'],
            'rep' => ['application/vnd.businessobjects'],
            'res' => ['application/x-dtbresource+xml'],
            'rexx' => ['text/x-script.rexx'],
            'rf' => ['image/vnd.rn-realflash'],
            'rgb' => ['image/x-rgb'],
            'rif' => ['application/reginfo+xml'],
            'rip' => ['audio/vnd.rip'],
            'ris' => ['application/x-research-info-systems'],
            'rl' => ['application/resource-lists+xml'],
            'rlc' => ['image/vnd.fujixerox.edmics-rlc'],
            'rld' => ['application/resource-lists-diff+xml'],
            'rm' => ['application/vnd.rn-realmedia', 'audio/x-pn-realaudio'],
            'rmi' => ['audio/midi'],
            'rmm' => ['audio/x-pn-realaudio'],
            'rmp' => ['audio/x-pn-realaudio', 'audio/x-pn-realaudio-plugin'],
            'rms' => ['application/vnd.jcp.javame.midlet-rms'],
            'rmvb' => ['application/vnd.rn-realmedia-vbr'],
            'rnc' => ['application/relax-ng-compact-syntax'],
            'rng' => ['application/ringing-tones', 'application/vnd.nokia.ringing-tone'],
            'rnx' => ['application/vnd.rn-realplayer'],
            'roa' => ['application/rpki-roa'],
            'roff' => ['text/troff'],
            'rp' => ['image/vnd.rn-realpix'],
            'rp9' => ['application/vnd.cloanto.rp9'],
            'rpm' => ['audio/x-pn-realaudio-plugin'],
            'rpss' => ['application/vnd.nokia.radio-presets'],
            'rpst' => ['application/vnd.nokia.radio-preset'],
            'rq' => ['application/sparql-query'],
            'rs' => ['application/rls-services+xml'],
            'rsd' => ['application/rsd+xml'],
            'rss' => ['application/rss+xml'],
            'rt' => ['text/richtext', 'text/vnd.rn-realtext'],
            'rtf' => ['application/rtf', 'application/x-rtf', 'text/richtext'],
            'rtx' => ['application/rtf', 'text/richtext'],
            'rv' => ['video/vnd.rn-realvideo'],
            's' => ['text/x-asm'],
            's3m' => ['audio/s3m'],
            'saf' => ['application/vnd.yamaha.smaf-audio'],
            'saveme' => ['aapplication/octet-stream'],
            'sbk' => ['application/x-tbook'],
            'sbml' => ['application/sbml+xml'],
            'sc' => ['application/vnd.ibm.secure-container'],
            'scd' => ['application/x-msschedule'],
            'scm' => ['application/x-lotusscreencam', 'text/x-script.guile', 'text/x-script.scheme', 'video/x-scm'],
            'scq' => ['application/scvp-cv-request'],
            'scs' => ['application/scvp-cv-response'],
            'scurl' => ['text/vnd.curl.scurl'],
            'sda' => ['application/vnd.stardivision.draw'],
            'sdc' => ['application/vnd.stardivision.calc'],
            'sdd' => ['application/vnd.stardivision.impress'],
            'sdkd' => ['application/vnd.solent.sdkm+xml'],
            'sdkm' => ['application/vnd.solent.sdkm+xml'],
            'sdml' => ['text/plain'],
            'sdp' => ['application/sdp', 'application/x-sdp'],
            'sdr' => ['application/sounder'],
            'sdw' => ['application/vnd.stardivision.writer'],
            'sea' => ['application/sea', 'application/x-sea'],
            'see' => ['application/vnd.seemail'],
            'seed' => ['application/vnd.fdsn.seed'],
            'sema' => ['application/vnd.sema'],
            'semd' => ['application/vnd.semd'],
            'semf' => ['application/vnd.semf'],
            'ser' => ['application/java-serialized-object'],
            'set' => ['application/set'],
            'setpay' => ['application/set-payment-initiation'],
            'setreg' => ['application/set-registration-initiation'],
            'sfd-hdstx' => ['application/vnd.hydrostatix.sof-data'],
            'sfs' => ['application/vnd.spotfire.sfs'],
            'sfv' => ['text/x-sfv'],
            'sgi' => ['image/sgi'],
            'sgl' => ['application/vnd.stardivision.writer-global'],
            'sgm' => ['text/sgml', 'text/x-sgml'],
            'sgml' => ['text/sgml', 'text/x-sgml'],
            'sh' => ['application/x-bsh', 'application/x-sh', 'application/x-shar', 'text/x-script.sh'],
            'shar' => ['application/x-bsh', 'application/x-shar'],
            'shf' => ['application/shf+xml'],
            'shtml' => ['text/html', 'text/x-server-parsed-html'],
            'si' => ['text/vnd.wap.si'],
            'sic' => ['application/vnd.wap.sic'],
            'sid' => ['image/x-mrsid-image'],
            'sig' => ['application/pgp-signature'],
            'sil' => ['audio/silk'],
            'silo' => ['model/mesh'],
            'sis' => ['application/vnd.symbian.install'],
            'sisx' => ['application/vnd.symbian.install'],
            'sit' => ['application/x-sit', 'application/x-stuffit'],
            'sitx' => ['application/x-stuffitx'],
            'skd' => ['application/vnd.koan'],
            'skm' => ['application/vnd.koan'],
            'skp' => ['application/vnd.koan'],
            'skt' => ['application/vnd.koan'],
            'sl' => ['application/x-seelogo'],
            'slc' => ['application/vnd.wap.slc'],
            'sldm' => ['application/vnd.ms-powerpoint.slide.macroenabled.12'],
            'sldx' => ['application/vnd.openxmlformats-officedocument.presentationml.slide'],
            'slt' => ['application/vnd.epson.salt'],
            'sm' => ['application/vnd.stepmania.stepchart'],
            'smf' => ['application/vnd.stardivision.math'],
            'smi' => ['application/smil+xml'],
            'smil' => ['application/smil+xml'],
            'smv' => ['video/x-smv'],
            'smzip' => ['application/vnd.stepmania.package'],
            'snd' => ['audio/basic', 'audio/x-adpcm'],
            'snf' => ['application/x-font-snf'],
            'so' => ['application/octet-stream'],
            'sol' => ['application/solids'],
            'spc' => ['application/x-pkcs7-certificates', 'text/x-speech'],
            'spf' => ['application/vnd.yamaha.smaf-phrase'],
            'spl' => ['application/x-futuresplash'],
            'spot' => ['text/vnd.in3d.spot'],
            'spp' => ['application/scvp-vp-response'],
            'spq' => ['application/scvp-vp-request'],
            'spr' => ['application/x-sprite'],
            'sprite' => ['application/x-sprite'],
            'spx' => ['audio/ogg'],
            'sql' => ['application/x-sql'],
            'src' => ['application/x-wais-source'],
            'srt' => ['application/x-subrip'],
            'sru' => ['application/sru+xml'],
            'srx' => ['application/sparql-results+xml'],
            'ssdl' => ['application/ssdl+xml'],
            'sse' => ['application/vnd.kodak-descriptor'],
            'ssf' => ['application/vnd.epson.ssf'],
            'ssi' => ['text/x-server-parsed-html'],
            'ssm' => ['application/streamingmedia'],
            'ssml' => ['application/ssml+xml'],
            'sst' => ['application/vnd.ms-pki.certstore'],
            'st' => ['application/vnd.sailingtracker.track'],
            'stc' => ['application/vnd.sun.xml.calc.template'],
            'std' => ['application/vnd.sun.xml.draw.template'],
            'step' => ['application/step'],
            'stf' => ['application/vnd.wt.stf'],
            'sti' => ['application/vnd.sun.xml.impress.template'],
            'stk' => ['application/hyperstudio'],
            'stl' => ['application/sla', 'application/vnd.ms-pki.stl', 'application/x-navistyle'],
            'stp' => ['application/step'],
            'str' => ['application/vnd.pg.format'],
            'stw' => ['application/vnd.sun.xml.writer.template'],
            'sub' => ['text/vnd.dvb.subtitle'],
            'sus' => ['application/vnd.sus-calendar'],
            'susp' => ['application/vnd.sus-calendar'],
            'sv4cpio' => ['application/x-sv4cpio'],
            'sv4crc' => ['application/x-sv4crc'],
            'svc' => ['application/vnd.dvb.service'],
            'svd' => ['application/vnd.svd'],
            'svf' => ['image/vnd.dwg', 'image/x-dwg'],
            'svg' => ['image/svg+xml'],
            'svgz' => ['image/svg+xml'],
            'svr' => ['application/x-world', 'x-world/x-svr'],
            'swa' => ['application/x-director'],
            'swf' => ['application/x-shockwave-flash'],
            'swi' => ['application/vnd.aristanetworks.swi'],
            'sxc' => ['application/vnd.sun.xml.calc'],
            'sxd' => ['application/vnd.sun.xml.draw'],
            'sxg' => ['application/vnd.sun.xml.writer.global'],
            'sxi' => ['application/vnd.sun.xml.impress'],
            'sxm' => ['application/vnd.sun.xml.math'],
            'sxw' => ['application/vnd.sun.xml.writer'],
            't' => ['text/troff'],
            't3' => ['application/x-t3vm-image'],
            'taglet' => ['application/vnd.mynfc'],
            'talk' => ['text/x-speech'],
            'tao' => ['application/vnd.tao.intent-module-archive'],
            'tar' => ['application/x-tar'],
            'tbk' => ['application/toolbook', 'application/x-tbook'],
            'tcap' => ['application/vnd.3gpp2.tcap'],
            'tcl' => ['application/x-tcl', 'text/x-script.tcl'],
            'tcsh' => ['text/x-script.tcsh'],
            'teacher' => ['application/vnd.smart.teacher'],
            'tei' => ['application/tei+xml'],
            'teicorpus' => ['application/tei+xml'],
            'tex' => ['application/x-tex'],
            'texi' => ['application/x-texinfo'],
            'texinfo' => ['application/x-texinfo'],
            'text' => ['application/plain', 'text/plain'],
            'tfi' => ['application/thraud+xml'],
            'tfm' => ['application/x-tex-tfm'],
            'tga' => ['image/x-tga'],
            'tgz' => ['application/gnutar', 'application/x-compressed'],
            'thmx' => ['application/vnd.ms-officetheme'],
            'tif' => ['image/tiff', 'image/x-tiff'],
            'tiff' => ['image/tiff', 'image/x-tiff'],
            'tmo' => ['application/vnd.tmobile-livetv'],
            'torrent' => ['application/x-bittorrent'],
            'tpl' => ['application/vnd.groove-tool-template'],
            'tpt' => ['application/vnd.trid.tpt'],
            'tr' => ['text/troff'],
            'tra' => ['application/vnd.trueapp'],
            'trm' => ['application/x-msterminal'],
            'ts' => ['video/MP2T'],
            'tsd' => ['application/timestamped-data'],
            'tsi' => ['audio/tsp-audio'],
            'tsp' => ['application/dsptype', 'audio/tsplayer'],
            'tsv' => ['text/tab-separated-values'],
            'ttc' => ['application/x-font-ttf'],
            'ttf' => ['application/x-font-ttf'],
            'ttl' => ['text/turtle'],
            'turbot' => ['image/florian'],
            'twd' => ['application/vnd.simtech-mindmapper'],
            'twds' => ['application/vnd.simtech-mindmapper'],
            'txd' => ['application/vnd.genomatix.tuxedo'],
            'txf' => ['application/vnd.mobius.txf'],
            'txt' => ['text/plain'],
            'u32' => ['application/x-authorware-bin'],
            'udeb' => ['application/x-debian-package'],
            'ufd' => ['application/vnd.ufdl'],
            'ufdl' => ['application/vnd.ufdl'],
            'uil' => ['text/x-uil'],
            'ulx' => ['application/x-glulx'],
            'umj' => ['application/vnd.umajin'],
            'uni' => ['text/uri-list'],
            'unis' => ['text/uri-list'],
            'unityweb' => ['application/vnd.unity'],
            'unv' => ['application/i-deas'],
            'uoml' => ['application/vnd.uoml+xml'],
            'uri' => ['text/uri-list'],
            'uris' => ['text/uri-list'],
            'urls' => ['text/uri-list'],
            'ustar' => ['application/x-ustar', 'multipart/x-ustar'],
            'utz' => ['application/vnd.uiq.theme'],
            'uu' => ['application/octet-stream', 'text/x-uuencode'],
            'uue' => ['text/x-uuencode'],
            'uva' => ['audio/vnd.dece.audio'],
            'uvd' => ['application/vnd.dece.data'],
            'uvf' => ['application/vnd.dece.data'],
            'uvg' => ['image/vnd.dece.graphic'],
            'uvh' => ['video/vnd.dece.hd'],
            'uvi' => ['image/vnd.dece.graphic'],
            'uvm' => ['video/vnd.dece.mobile'],
            'uvp' => ['video/vnd.dece.pd'],
            'uvs' => ['video/vnd.dece.sd'],
            'uvt' => ['application/vnd.dece.ttml+xml'],
            'uvu' => ['video/vnd.uvvu.mp4'],
            'uvv' => ['video/vnd.dece.video'],
            'uvva' => ['audio/vnd.dece.audio'],
            'uvvd' => ['application/vnd.dece.data'],
            'uvvf' => ['application/vnd.dece.data'],
            'uvvg' => ['image/vnd.dece.graphic'],
            'uvvh' => ['video/vnd.dece.hd'],
            'uvvi' => ['image/vnd.dece.graphic'],
            'uvvm' => ['video/vnd.dece.mobile'],
            'uvvp' => ['video/vnd.dece.pd'],
            'uvvs' => ['video/vnd.dece.sd'],
            'uvvt' => ['application/vnd.dece.ttml+xml'],
            'uvvu' => ['video/vnd.uvvu.mp4'],
            'uvvv' => ['video/vnd.dece.video'],
            'uvvx' => ['application/vnd.dece.unspecified'],
            'uvvz' => ['application/vnd.dece.zip'],
            'uvx' => ['application/vnd.dece.unspecified'],
            'uvz' => ['application/vnd.dece.zip'],
            'vcard' => ['text/vcard'],
            'vcd' => ['application/x-cdlink'],
            'vcf' => ['text/x-vcard'],
            'vcg' => ['application/vnd.groove-vcard'],
            'vcs' => ['text/x-vcalendar'],
            'vcx' => ['application/vnd.vcx'],
            'vda' => ['application/vda'],
            'vdo' => ['video/vdo'],
            'vew' => ['application/groupwise'],
            'vis' => ['application/vnd.visionary'],
            'viv' => ['video/vivo', 'video/vnd.vivo'],
            'vivo' => ['video/vivo', 'video/vnd.vivo'],
            'vmd' => ['application/vocaltec-media-desc'],
            'vmf' => ['application/vocaltec-media-file'],
            'vob' => ['video/x-ms-vob'],
            'voc' => ['audio/voc', 'audio/x-voc'],
            'vor' => ['application/vnd.stardivision.writer'],
            'vos' => ['video/vosaic'],
            'vox' => ['application/x-authorware-bin'],
            'vqe' => ['audio/x-twinvq-plugin'],
            'vqf' => ['audio/x-twinvq'],
            'vql' => ['audio/x-twinvq-plugin'],
            'vrml' => ['application/x-vrml', 'model/vrml', 'x-world/x-vrml'],
            'vrt' => ['x-world/x-vrt'],
            'vsd' => ['application/vnd.visio'],
            'vsf' => ['application/vnd.vsf'],
            'vss' => ['application/vnd.visio'],
            'vst' => ['application/vnd.visio'],
            'vsw' => ['application/vnd.visio'],
            'vtt' => ['text/vtt'],
            'vtu' => ['model/vnd.vtu'],
            'vxml' => ['application/voicexml+xml'],
            'w3d' => ['application/x-director'],
            'w60' => ['application/wordperfect6.0'],
            'w61' => ['application/wordperfect6.1'],
            'w6w' => ['application/msword'],
            'wad' => ['application/x-doom'],
            'wav' => ['audio/wav', 'audio/x-wav'],
            'wax' => ['audio/x-ms-wax'],
            'wb1' => ['application/x-qpro'],
            'wbmp' => ['image/vnd.wap.wbmp'],
            'wbs' => ['application/vnd.criticaltools.wbs+xml'],
            'wbxml' => ['application/vnd.wap.wbxml'],
            'wcm' => ['application/vnd.ms-works'],
            'wdb' => ['application/vnd.ms-works'],
            'wdp' => ['image/vnd.ms-photo'],
            'web' => ['application/vnd.xara'],
            'weba' => ['audio/webm'],
            'webapp' => ['application/x-web-app-manifest+json'],
            'webm' => ['video/webm'],
            'webp' => ['image/webp'],
            'wg' => ['application/vnd.pmi.widget'],
            'wgt' => ['application/widget'],
            'wiz' => ['application/msword'],
            'wk1' => ['application/x-123'],
            'wks' => ['application/vnd.ms-works'],
            'wm' => ['video/x-ms-wm'],
            'wma' => ['audio/x-ms-wma'],
            'wmd' => ['application/x-ms-wmd'],
            'wmf' => ['application/x-msmetafile'],
            'wml' => ['text/vnd.wap.wml'],
            'wmlc' => ['application/vnd.wap.wmlc'],
            'wmls' => ['text/vnd.wap.wmlscript'],
            'wmlsc' => ['application/vnd.wap.wmlscriptc'],
            'wmv' => ['video/x-ms-wmv'],
            'wmx' => ['video/x-ms-wmx'],
            'wmz' => ['application/x-msmetafile'],
            'woff' => ['application/x-font-woff'],
            'word' => ['application/msword'],
            'wp' => ['application/wordperfect'],
            'wp5' => ['application/wordperfect', 'application/wordperfect6.0'],
            'wp6' => ['application/wordperfect'],
            'wpd' => ['application/wordperfect', 'application/x-wpwin'],
            'wpl' => ['application/vnd.ms-wpl'],
            'wps' => ['application/vnd.ms-works'],
            'wq1' => ['application/x-lotus'],
            'wqd' => ['application/vnd.wqd'],
            'wri' => ['application/mswrite', 'application/x-wri'],
            'wrl' => ['application/x-world', 'model/vrml', 'x-world/x-vrml'],
            'wrz' => ['model/vrml', 'x-world/x-vrml'],
            'wsc' => ['text/scriplet'],
            'wsdl' => ['application/wsdl+xml'],
            'wspolicy' => ['application/wspolicy+xml'],
            'wsrc' => ['application/x-wais-source'],
            'wtb' => ['application/vnd.webturbo'],
            'wtk' => ['application/x-wintalk'],
            'wvx' => ['video/x-ms-wvx'],
            'x-png' => ['image/png'],
            'x32' => ['application/x-authorware-bin'],
            'x3d' => ['model/x3d+xml'],
            'x3db' => ['model/x3d+binary'],
            'x3dbz' => ['model/x3d+binary'],
            'x3dv' => ['model/x3d+vrml'],
            'x3dvz' => ['model/x3d+vrml'],
            'x3dz' => ['model/x3d+xml'],
            'xaml' => ['application/xaml+xml'],
            'xap' => ['application/x-silverlight-app'],
            'xar' => ['application/vnd.xara'],
            'xbap' => ['application/x-ms-xbap'],
            'xbd' => ['application/vnd.fujixerox.docuworks.binder'],
            'xbm' => ['image/x-xbitmap', 'image/x-xbm', 'image/xbm'],
            'xdf' => ['application/xcap-diff+xml'],
            'xdm' => ['application/vnd.syncml.dm+xml'],
            'xdp' => ['application/vnd.adobe.xdp+xml'],
            'xdr' => ['video/x-amt-demorun'],
            'xdssc' => ['application/dssc+xml'],
            'xdw' => ['application/vnd.fujixerox.docuworks'],
            'xenc' => ['application/xenc+xml'],
            'xer' => ['application/patch-ops-error+xml'],
            'xfdf' => ['application/vnd.adobe.xfdf'],
            'xfdl' => ['application/vnd.xfdl'],
            'xgz' => ['xgl/drawing'],
            'xht' => ['application/xhtml+xml'],
            'xhtml' => ['application/xhtml+xml'],
            'xhvml' => ['application/xv+xml'],
            'xif' => ['image/vnd.xiff'],
            'xl' => ['application/excel'],
            'xla' => ['application/excel', 'application/x-excel', 'application/x-msexcel'],
            'xlam' => ['application/vnd.ms-excel.addin.macroenabled.12'],
            'xlb' => ['application/excel', 'application/vnd.ms-excel', 'application/x-excel'],
            'xlc' => ['application/excel', 'application/vnd.ms-excel', 'application/x-excel'],
            'xld' => ['application/excel', 'application/x-excel'],
            'xlf' => ['application/x-xliff+xml'],
            'xlk' => ['application/excel', 'application/x-excel'],
            'xll' => ['application/excel', 'application/vnd.ms-excel', 'application/x-excel'],
            'xlm' => ['application/excel', 'application/vnd.ms-excel', 'application/x-excel'],
            'xls' => ['application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel'],
            'xlsb' => ['application/vnd.ms-excel.sheet.binary.macroenabled.12'],
            'xlsm' => ['application/vnd.ms-excel.sheet.macroenabled.12'],
            'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            'xlt' => ['application/excel', 'application/x-excel'],
            'xltm' => ['application/vnd.ms-excel.template.macroenabled.12'],
            'xltx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.template'],
            'xlv' => ['application/excel', 'application/x-excel'],
            'xlw' => ['application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel'],
            'xm' => ['audio/xm'],
            'xml' => ['application/xml', 'text/xml'],
            'xmz' => ['xgl/movie'],
            'xo' => ['application/vnd.olpc-sugar'],
            'xop' => ['application/xop+xml'],
            'xpdl' => ['application/xml'],
            'xpi' => ['application/x-xpinstall'],
            'xpix' => ['application/x-vnd.ls-xpix'],
            'xpl' => ['application/xproc+xml'],
            'xpm' => ['image/x-xpixmap', 'image/xpm'],
            'xpr' => ['application/vnd.is-xpr'],
            'xps' => ['application/vnd.ms-xpsdocument'],
            'xpw' => ['application/vnd.intercon.formnet'],
            'xpx' => ['application/vnd.intercon.formnet'],
            'xsl' => ['application/xml'],
            'xslt' => ['application/xslt+xml'],
            'xsm' => ['application/vnd.syncml+xml'],
            'xspf' => ['application/xspf+xml'],
            'xsr' => ['video/x-amt-showrun'],
            'xul' => ['application/vnd.mozilla.xul+xml'],
            'xvm' => ['application/xv+xml'],
            'xvml' => ['application/xv+xml'],
            'xwd' => ['image/x-xwd', 'image/x-xwindowdump'],
            'xyz' => ['chemical/x-xyz'],
            'xz' => ['application/x-xz'],
            'yang' => ['application/yang'],
            'yin' => ['application/yin+xml'],
            'z' => ['application/x-compress', 'application/x-compressed'],
            'z1' => ['application/x-zmachine'],
            'z2' => ['application/x-zmachine'],
            'z3' => ['application/x-zmachine'],
            'z4' => ['application/x-zmachine'],
            'z5' => ['application/x-zmachine'],
            'z6' => ['application/x-zmachine'],
            'z7' => ['application/x-zmachine'],
            'z8' => ['application/x-zmachine'],
            'zaz' => ['application/vnd.zzazz.deck+xml'],
            'zip' => ['application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'],
            'zir' => ['application/vnd.zul'],
            'zirz' => ['application/vnd.zul'],
            'zmm' => ['application/vnd.handheld-entertainment+xml'],
            'zoo' => ['application/octet-stream'],
            'zsh' => ['text/x-script.zsh'],
            '123' => ['application/vnd.lotus-1-2-3'],
        ];

        foreach ($all_mimes as $key => $value) {
            if ($ext == $key) {
                return $value; //array
            }
        }
        return [];
    }

    public function files_count($where = '')
    {
        global $xoopsDB;

        if (!empty($where)) {
            $sql = "select count(*) from `{$this->TadUpFilesTblName}`  where $where";
        } else {
            $sql = "select count(*) from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";
        }
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($count) = $xoopsDB->fetchRow($result);

        return $count;
    }
}
