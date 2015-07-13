<?php
/*

//上傳表單（enctype='multipart/form-data'）
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="file",$image="image",$thumbs="image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn); //若 $show_list_del_file ==true 時一定要有
$upform=$TadUpFiles->upform($show_edit,$upname,$maxlength,$show_list_del_file,$only_type,$thumb);


//儲存：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="file",$image="image",$thumbs="image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//儲存單一檔案：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="file",$image="image",$thumbs="image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->upload_one_file($_FILES['upfile']['name'],$_FILES['upfile']['tmp_name'],$_FILES['upfile']['type'],$_FILES['upfile']['size'],$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);

//複製匯入單一檔案：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="file",$image="image",$thumbs="image/.thumbs");
//$TadUpFiles->set_dir('subdir',"/{$xoopsConfig['theme_set']}/logo");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->import_one_file($from="",$new_filename="",$main_width="1280",$thumb_width="120",$files_sn="" ,$desc="" ,$safe_name=false ,$hash=false);

//顯示可刪除列表
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="file",$image="image",$thumbs="image/.thumbs");
$TadUpFiles->set_col($col_name,$col_sn,$sort);
$TadUpFiles->set_thumb($thumb_width="120px",$thumb_height="70px",$thumb_bg_color="#000");
$list_del_file=$TadUpFiles->list_del_file($show_edit=false,$mode);

//顯示：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFiles=new TadUpFiles("模組名稱",$subdir,$file="file",$image="image",$thumbs="image/.thumbs");
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
    public $file_dir   = "/file";
    public $image_dir  = "/image";
    public $thumbs_dir = "/image/.thumbs";

    public $thumb_width    = '120px';
    public $thumb_height   = '70px';
    public $thumb_bg_color = '#000000';
    public $thumb_position = 'center center';
    public $thumb_repeat   = 'no-repeat';
    public $thumb_size     = 'contain';
    public $showFancyBox   = true;
    public $download_url   = "";
    public $bootstrap;

    public function TadUpFiles($prefix = "", $subdir = "", $file = "/file", $image = "/image", $thumbs = "/image/.thumbs")
    {
        global $xoopsDB;
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
        $this->bootstrap         = $_SESSION['bootstrap'];
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

    public function set_col($col_name = "", $col_sn = "", $sort = "")
    {
        $this->col_name = $col_name;
        $this->col_sn   = $col_sn;
        $this->sort     = $sort;
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

    //上傳元件
    public function upform($show_edit = false, $upname = 'upfile', $maxlength = "", $show_list_del_file = true, $only_type = "", $thumb = true)
    {
        $maxlength     = empty($maxlength) ? "" : "maxlength='{$maxlength}'";
        $accept        = ($only_type) ? "accept='{$only_type}'" : "";
        $list_del_file = ($show_list_del_file) ? $this->list_del_file($show_edit, $thumb) : "";
        $jquery        = get_jquery(true);

        $col  = ($this->bootstrap == '3') ? "col-md-12" : "span12";
        $main = "
    $jquery
    <input type='file' name='{$upname}[]' id='{$upname}' $maxlength multiple='multiple' $accept class='{$col}'>
    {$list_del_file}
    ";

        return $main;
    }

    //列出可刪除檔案
    public function list_del_file($show_edit = false, $thumb = true)
    {
        global $xoopsDB, $xoopsUser;

        $all_file = "";

        $sql = "select * from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' order by sort";

        $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<p>$sql</p>");
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            $fileidname = str_replace('.', '', $file_name);

            if ($thumb) {
                if ($kind == "file") {
                    $thumb_pic = TADTOOLS_URL . "/multiple-file-upload/downloads.png";
                } else {
                    $thumb_pic = "{$this->TadUpFilesThumbUrl}/{$file_name}";
                }
                //$thumb_style="<a class='thumbnail' style='width:{$this->thumb_width};height:{$this->thumb_height};overflow:background-color:{$this->thumb_bg_color};hidden;background-image:url({$thumb_pic});background-position:{$this->thumb_position};background-repeat:{$this->thumb_repeat};background-size:{$this->thumb_size};display:block;' title='{$description}'></a>";

                $img_class   = ($this->bootstrap == '3') ? "img-thumbnail" : "img-polaroid";
                $thumb_style = "<img src='{$thumb_pic}' class='{$img_class}'>";

                $thumb_style2 = "<a class='thumbnail' style='width:{$this->thumb_width};height:{$this->thumb_height};overflow:hidden;background-color:{$this->thumb_bg_color};background-image:url({$thumb_pic});background-position:{$this->thumb_position};background-repeat:{$this->thumb_repeat};background-size:{$this->thumb_size};' title='{$description}'></a>";
                $w            = "width:130px;word-break:break-all;";
                $w2           = "width:{$this->thumb_width};float:left;";
            } else {
                $thumb_style  = "";
                $thumb_style2 = "";
                $thumb_pic    = "";
                $w            = "";
                $w2           = "list-style-position: outside;";
            }

            $col             = ($this->bootstrap == '3') ? "col-md-" : "span";
            $row             = ($this->bootstrap == '3') ? "row" : "row-fluid";
            $class           = ($this->bootstrap == '3') ? "form-control" : "span12";
            $checkbox_inline = ($this->bootstrap == '3') ? "checkbox-inline" : "checkbox inline";

            if ($show_edit) {
                $all_file .= "
        <tr id='fdtr_{$files_sn}'>
          <td style='{$w}'>
            <div class='{$row}'>
              <div class='{$col}1'>$thumb_style</div>
              <div class='{$col}11'>
                <label class='$checkbox_inline'>
                  <input type='checkbox' name='del_file[$files_sn]' value='{$files_sn}'>
                  {$original_filename}
                </label>
                <textarea name='save_description[$files_sn]' rows=1 class='{$class}'>$description</textarea>
              </div>
            </div>
          </td>
        </tr>";
            } else {
                $all_file .= "
        <li style='list-style-type:none;{$w2}'>
          <label class='$checkbox_inline '>
            $thumb_style2
            <input type='checkbox' name='del_file[]' value='{$files_sn}'>{$original_filename}
          </label>
        </li>
        ";
            }
        }

        if (empty($all_file)) {
            return;
        }

        if ($show_edit) {
            $files = "
      <script type='text/javascript'>
      $(document).ready(function(){
        $('#list_del_file_sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
          var order = $(this).sortable('serialize');
          $.post('" . XOOPS_URL . "/modules/tadtools/save_sort.php',order+'&col_name={$this->col_name}&col_sn={$this->col_sn}&tbl_name=" . $this->TadUpFilesTblName . "', function(theResponse){
            $('#df_save_msg').html(theResponse);
          });
        }
        });
      });
      </script>
      <div style='margin-bottom:7px;'>" . _TAD_SELECT_TO_DEL . "</div>
      <div class='{$row}'>
        <div id='df_save_msg'></div>
        <table class='table table-striped table-hover'>
        <tbody id='list_del_file_sort' >
        $all_file
        </tbody>
        </table>
        <div class='alert'>" . _TAD_SORTABLE . "</div>
      </div>";
        } else {
            $files = "<div style='margin-bottom:7px;'>" . _TAD_SELECT_TO_DEL . "</div>
      <div class='{$row}'><ul class='thumbnails'>$all_file</ul></div>";
        }

        return $files;
    }

    //上傳圖檔，$this->col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
    public function upload_file($upname = 'upfile', $main_width = "1280", $thumb_width = "120", $files_sn = "", $desc = null, $safe_name = false, $hash = false)
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

//die(var_dump($files));

        foreach ($files as $file) {
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
                        $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`counter`,`original_filename`,`sub_dir`,`hash_filename`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}',0,'{$file['name']}','{$this->subdir}','{$hash_name}')";

                        $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
                    } else {
                        $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}')";

                        $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
                    }
                    //die($sql);
                } else {
                    redirect_header($_SERVER['PHP_SELF'], 3, "Error:" . $file_handle->error);
                }
            }
            $this->sort = "";
        }

    }

    //解決 basename 抓不到中文檔名的問題
    private function get_basename($filename)
    {
        $filename = preg_replace('/^.+[\\\\\\/]/', '', $filename);
        $filename = rtrim($filename, '/');

        return $filename;
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

        //若是圖片才縮圖
        if ($kind == "img" and !empty($main_width)) {

            $filename  = auto_charset($filename);
            $new_thumb = $this->TadUpFilesThumbDir . "/" . $hash_filename;
            if (file_exists($path . "/" . $hash_filename)) {
                unlink($path . "/" . $hash_filename);
            }

            if (copy($from, $path . "/" . $hash_filename)) {
                $description = (empty($files_sn) and empty($desc)) ? $filename : $desc;

                if (empty($files_sn)) {
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}')";
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}')";
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
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
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}')";
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$$new_filename}','{$type}','{$size}','{$description}','{$filename}','{$this->subdir}','{$hash_name}.{$ext}')";
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
                }

                $this->sort = "";
            }
        }

        //die('new_thumb:'.$new_thumb);

        return $files_sn;
    }

    //檔案格式
    private function mime_content_type($filename)
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
    private function thumbnail($filename = "", $thumb_name = "", $type = "image/jpeg", $width = "120")
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
                    $sql = "insert into `{$this->TadUpFilesTblName}`  (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}.{$ext}')";
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
                    //取得最後新增資料的流水編號
                    $files_sn = $xoopsDB->getInsertId();
                } else {
                    $sql = "replace into `{$this->TadUpFilesTblName}` (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`,`sub_dir`,`hash_filename`) values('{$files_sn}','{$this->col_name}','{$this->col_sn}','{$this->sort}','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}','{$file['name']}','{$this->subdir}','{$hash_name}.{$ext}')";
                    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
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

        $result    = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
        list($max) = $xoopsDB->fetchRow($result);

        return ++$max;
    }

    //更新某個欄位值
    private function update_col_val($files_sn = "", $col = "", $val = "")
    {
        global $xoopsDB, $xoopsUser;

        $myts = &MyTextSanitizer::getInstance();
        $col  = $myts->addSlashes($col);
        $val  = $myts->addSlashes($val);

        $sql = "update `{$this->TadUpFilesTblName}`  set `$col`='{$val}' where `files_sn`='{$files_sn}'";
        $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    }

    //刪除實體檔案
    public function del_files($files_sn = "")
    {
        global $xoopsDB, $xoopsUser;

        if (!empty($files_sn)) {
            $del_what = "`files_sn`='{$files_sn}'";
        } elseif (!empty($this->col_name) and !empty($this->col_sn)) {
            $and_sort = (empty($this->sort)) ? "" : "and `sort`='{$this->sort}'";
            $del_what = "`col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort";
        }

        if (empty($del_what)) {
            return;
        }

        $sql = "select * from `{$this->TadUpFilesTblName}`  where $del_what";
        //die($sql);
        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);

        while (list($files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description, $counter, $original_filename, $hash_filename, $sub_dir) = $xoopsDB->fetchRow($result)) {
            $this->set_col($col_name, $col_sn, $sort);
            $del_sql = "delete  from `{$this->TadUpFilesTblName}`  where files_sn='{$files_sn}'";
            $xoopsDB->queryF($del_sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

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

            //die($file."-----".$this->TadUpFilesImgDir."/{$new_name}");

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
    public function get_file($files_sn = "", $limit = null, $path = null, $hash = false, $desc_as_name = false)
    {
        global $xoopsDB, $xoopsUser;
        $files      = "";
        $os_charset = (PATH_SEPARATOR == ':') ? "UTF-8" : "Big5";

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : "";

        $andLimit = (!empty($limit)) ? "limit 0 , {$limit}" : "";

        $link_path = is_null($path) ? $_SERVER['PHP_SELF'] : $path;

        $where = ($files_sn) ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort $andLimit";

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";

        $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

            if ($os_charset != _CHARSET) {
                $file_name = iconv($os_charset, _CHARSET, $file_name);
            }

            $files[$files_sn]['kind']              = $kind;
            $files[$files_sn]['sort']              = $sort;
            $files[$files_sn]['file_name']         = $file_name;
            $files[$files_sn]['file_type']         = $file_type;
            $files[$files_sn]['file_size']         = $file_size;
            $files[$files_sn]['counter']           = $counter;
            $files[$files_sn]['description']       = $description;
            $files[$files_sn]['original_filename'] = $original_filename;
            $files[$files_sn]['hash_filename']     = $hash_filename;

            $files[$files_sn]['show_file_name'] = $show_file_name = ($desc_as_name and !empty($description)) ? $description : $original_filename;

            $dl_url = empty($this->download_url) ? "{$link_path}?op=tufdl&files_sn=$files_sn" : $this->download_url . "&files_sn=$files_sn";

            if ($kind == "img") {
                $file_name = ($hash) ? $hash_filename : $file_name;
                $pic_name  = $this->TadUpFilesImgUrl . "/{$file_name}";
                $thumb_pic = $this->TadUpFilesThumbUrl . "/{$file_name}";

                $files[$files_sn]['link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='{$pic_name}' alt='{$description}' title='{$description}' rel='lytebox'></a>";
                $files[$files_sn]['path'] = $pic_name;
                $files[$files_sn]['url']  = "<a href='{$dl_url}' title='{$description}' target='_blank'>{$show_file_name}</a>";

                $files[$files_sn]['tb_link'] = "<a href='{$dl_url}' title='{$description}' rel='lytebox'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
                $files[$files_sn]['tb_path'] = $thumb_pic;
                $files[$files_sn]['tb_url']  = "<a href='{$dl_url}' title='{$description}' rel='lytebox'>{$description}</a>";
            } else {
                $files[$files_sn]['link']               = "<a href='{$dl_url}#{$original_filename}'>{$show_file_name}</a>";
                $files[$files_sn]['path']               = "{$dl_url}#{$original_filename}";
                $files[$files_sn]['original_file_path'] = $this->TadUpFilesUrl . "/{$file_name}";
                $files[$files_sn]['physical_file_path'] = $this->TadUpFilesDir . "/{$file_name}";
            }
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

        $where = ($files_sn) ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort $andLimit";

        $sql    = "select * from `{$this->TadUpFilesTblName}` $where";
        $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
        $i      = 0;
        $files  = '';
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
    public function get_pic_file($showkind = "images", $show_kind = "url", $files_sn = "")
    {
        global $xoopsDB, $xoopsUser;
        if ((empty($this->col_sn) or empty($this->col_name)) and empty($files_sn)) {
            return;
        }

        $and_sort = (!empty($this->sort)) ? " and `sort`='{$this->sort}'" : "";

        $where = $files_sn ? "where `files_sn`='{$files_sn}'" : "where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' $and_sort order by sort limit 0,1";

        $sql = "select * from `{$this->TadUpFilesTblName}` $where";

        $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
        $files  = "";
        while ($all = $xoopsDB->fetchArray($result)) {
            //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
            foreach ($all as $k => $v) {
                $$k = $v;
            }

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

        return $files;
    }

    //取得檔案數
    public function get_file_amount()
    {
        global $xoopsDB;

        $sql = "select count(*) from `{$this->TadUpFilesTblName}`  where `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}'";

        $result       = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
        list($amount) = $xoopsDB->fetchRow($result);

        return $amount;
    }

    //取得附檔或附圖 $show_mode=filename , small,playSpeed=3000 or 0
    public function show_files($upname = "", $thumb = true, $show_mode = "", $show_description = false, $show_dl = false, $limit = null, $path = null, $hash = false, $playSpeed = 5000, $desc_as_name = false)
    {

        if ($show_mode == "small") {
            $all_files = "<link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/css/iconize.css' />";
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
            $fancybox = new fancybox(".fancybox_{$this->col_name}", 640, 480);
            $all_files .= $fancybox->render(false, null, $autoPlay, $playSpeed);
        }

        $file_arr = "";
        $file_arr = $this->get_file(null, $limit, $path, $hash, $desc_as_name);

        if (empty($file_arr)) {
            return;
        }

        if ($file_arr) {
            $i = 1;
            if ($show_mode != "filename" and $show_mode != "small") {
                $all_files .= "<ul class='thumbnails'>";
            }

            foreach ($file_arr as $files_sn => $file_info) {

                if ($show_mode == "filename") {
                    if ($file_info['kind'] == "file") {
                        $all_files .= "<div>({$i}) {$file_info['link']}</div>";
                    } else {
                        $all_files .= "<div>({$i}) {$file_info['url']}</div>";
                    }
                } else {
                    $linkto      = $file_info['path'];
                    $description = empty($file_info['description']) ? $file_info['original_filename'] : $file_info['description'];
                    if ($file_info['kind'] == "file") {
                        $fext = pathinfo($file_info['path'], PATHINFO_EXTENSION);
                        //$fext=strtolower(substr($file_info['path'], -3));
                        if ($fext == "mp4" or $fext == "flv" or $fext == "3gp") {
                            $thumb_pic = TADTOOLS_URL . "/images/video.png";
                            if ($this->showFancyBox) {
                                $fancyboxset = "fancybox_{$this->col_name}";
                                $rel         = "data-fancybox-type='iframe'";
                            } else {
                                $fancyboxset = $rel = "";
                            }
                            $linkto = TADTOOLS_URL . "/video.php?file_name={$file_info['original_file_path']}";
                        } else {
                            $thumb_pic   = TADTOOLS_URL . "/multiple-file-upload/downloads.png";
                            $fancyboxset = $rel = "";
                        }
                    } else {
                        $thumb_pic = ($thumb) ? $file_info['tb_path'] : $file_info['path'];
                        if ($this->showFancyBox) {
                            $fancyboxset = "fancybox_{$this->col_name}";
                            $rel         = "rel='f{$this->col_name}'";
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
                    $show_description_txt = ($show_description) ? "<div style='font-weight:normal;font-size:11px;word-break:break-all;line-height:1.2;margin-top:4px;'>$i) {$description} {$show_dl_txt}</div>" : "{$show_dl_txt}";

                    $all_files .= ($show_mode == "small") ? "<a href='{$linkto}' class='iconize {$fancyboxset}' {$rel}  title='{$description}'></a> " : "
          <li style='width:120px;float:left;list-style:none;'>
            <a href='{$linkto}' class='thumbnail {$fancyboxset}' {$rel} style=\"width:110px;height:70px;overflow:hidden;background-image:url('{$thumb_pic}');background-repeat:no-repeat;background-position:center center;\" title='{$description}'></a>

            {$show_description_txt}
          </li>";
                }

                $i++;
            }
            if ($show_mode != "filename" and $show_mode != "small") {
                $all_files .= "</ul>";
            }

        } else {
            $all_files = "";
        }

        $all_files .= "<div style='clear:both;'></div>";

        return $all_files;
    }

    //下載並新增計數器
    public function add_file_counter($files_sn = "", $hash = false, $force = false)
    {
        global $xoopsDB;

        $file = $this->get_one_file($files_sn);
        $this->set_dir('subdir', $file['sub_dir']);

        $file_type     = $file['file_type'];
        $file_size     = $file['file_size'];
        $real_filename = $file['original_filename'];
        $dl_name       = ($hash) ? $file['hash_filename'] : $file['file_name'];

        $sql = "update `{$this->TadUpFilesTblName}` set `counter`=`counter`+1 where `files_sn`='{$files_sn}'";
        $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

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

            $modhandler        = &xoops_gethandler('module');
            $xoopsModule       = &$modhandler->getByDirname("tadtools");
            $config_handler    = &xoops_gethandler('config');
            $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

            if ($xoopsModuleConfig['auto_charset'] != 0) {
                $tmp_file_url = auto_charset($tmp_file_url);
            }

            //die($tmp_file_url);
            header("location:{$tmp_file_url}");
            exit;
        }
    }

    //取得單一檔案資料
    private function get_one_file($files_sn = "")
    {
        global $xoopsDB, $xoopsUser;

        $sql = "select * from `{$this->TadUpFilesTblName}`  where `files_sn`='{$files_sn}'";

        $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
        $all    = $xoopsDB->fetchArray($result);

        return $all;
    }

    private function filesize2bytes($str)
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

        $bytes = floatval($str);

        if (preg_match('#([KMGTP]?)$#si', $str, $matches) && !empty($bytes_array[$matches[1]])) {
            $bytes *= $bytes_array[$matches[1]];
        }

        $bytes = intval(round($bytes, 2));

        return $bytes;
    }

    private function delete_directory($dirname)
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

}
