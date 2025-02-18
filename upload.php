<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

//此檔案是給 CkEditor.php 用的，勿刪
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
if (! $xoopsUser) {
    exit;
}
require_once __DIR__ . '/upload/class.upload.php';

$type    = Request::getString('type');
$mod_dir = Request::getString('mod_dir');
$subDir  = Request::getString('subDir');

$save_to = XOOPS_ROOT_PATH . "/uploads/{$mod_dir}/{$type}/";
$img_url = XOOPS_URL . "/uploads/{$mod_dir}/{$type}/";
if (! empty($subDir)) {
    $save_to .= "{$subDir}/";
    $img_url .= "{$subDir}/";
    Utility::mk_dir($save_to);
}
$type_arr         = ['image', 'file'];
$image_max_width  = $xoopsModuleConfig['image_max_width'] ? (int) $xoopsModuleConfig['image_max_width'] : 640;
$image_max_height = $xoopsModuleConfig['image_max_height'] ? (int) $xoopsModuleConfig['image_max_height'] : 640;

if (strpos($_SERVER['HTTP_REFERER'], XOOPS_URL) !== 0) {
    die("非法調用");
}

if (! in_array($type, $type_arr)) {
    die("不支援 {$type} 類型 ");
}

if (isset($_FILES['upload'])) {
    $foo = new \Verot\Upload\Upload($_FILES['upload'], 'zh_TW');
    if ($foo->uploaded) {
        $filename                = date('YmdHis_') . Utility::randStr(4);
        $path_parts              = pathinfo($_FILES['upload']['name']);
        $extension               = $path_parts['extension'];
        $foo->file_new_name_body = $filename;
        $foo->image_resize       = false;
        $foo->image_ratio        = true;
        $foo->image_x            = $image_max_width;
        $foo->image_y            = $image_max_height;

        // save uploaded image with no changes
        $foo->process($save_to);

        $data['filename'] = "{$filename}.$extension";
        $data['url']      = $img_url . $filename . '.' . $extension;

        if ($foo->processed) {
            chmod($save_to . $filename, 0777);
            $data['uploaded'] = 1;
        } else {
            $data['uploaded'] = 0;
        }
    }
} elseif (isset($_GET['url'])) {
    $image_url  = Request::getString('url');
    $image_name = basename($image_url);
    // 使用 file_get_contents() 函式讀取圖片檔案內容
    $image_data = Utility::vita_get_url_content($image_url);

    // 如果讀取成功，就寫入本地檔案
    if ($image_data !== false) {
        file_put_contents($save_to . $image_name, $image_data);
        $result = Utility::generateThumbnail($save_to . $image_name);
        if ($result !== true) {
            die($result);
        } else {
            chmod($save_to . $image_name, 0777);
            $data['filename'] = $image_name;
            $data['url']      = $img_url . $image_name;
            $data['uploaded'] = 1;
        }

    } else {
        $data['uploaded'] = 0;
    }
} else {
    $data['uploaded'] = 0;
}
Utility::dd($data);
