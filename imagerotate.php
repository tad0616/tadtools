<?php
use Xmf\Request;

require_once __DIR__ . '/tadtools_header.php';
if (!function_exists('imagecreatetruecolor')) {
    die('imagecreatetruecolor functions are not available.');
}
if (!$xoopsUser) {
    exit;
}

$op         = Request::getString('op');
$subdir     = Request::getString('subdir');
$image_dir  = Request::getString('image_dir');
$thumbs_dir = Request::getString('thumbs_dir');
$filename   = basename(Request::getString('filename'));
$type       = Request::getString('type');

foreach ([$subdir, $image_dir, $thumbs_dir, $filename] as $part) {
    if (strpos($part, '..') !== false || strpos($part, "\0") !== false) {
        http_response_code(400);
        exit('Invalid path');
    }
}
if ($filename === '') {
    http_response_code(400);
    exit('Invalid filename');
}

$uploadsRoot = realpath(XOOPS_ROOT_PATH . '/uploads');
$pic         = XOOPS_ROOT_PATH . "/uploads/{$subdir}{$image_dir}/{$filename}";
$thumb       = XOOPS_ROOT_PATH . "/uploads/{$subdir}{$thumbs_dir}/{$filename}";
$realPic     = realpath($pic);
$realThumb   = realpath($thumb);
if ($uploadsRoot === false || $realPic === false || $realThumb === false
    || strpos($realPic, $uploadsRoot . DIRECTORY_SEPARATOR) !== 0
    || strpos($realThumb, $uploadsRoot . DIRECTORY_SEPARATOR) !== 0) {
    http_response_code(403);
    exit('Invalid target');
}
$pic   = $realPic;
$thumb = $realThumb;

// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;
if ('image/jpeg' === $type or 'image/jpg' === $type or 'image/pjpg' === $type or 'image/pjpeg' === $type) {
    $pic_im   = imagecreatefromjpeg($pic);
    $thumb_im = imagecreatefromjpeg($thumb);
    header('Content-type: image/jpg');
} elseif ('image/png' === $type) {
    $pic_im   = imagecreatefrompng($pic);
    $thumb_im = imagecreatefrompng($thumb);
    header('Content-type: image/png');
} elseif ('image/gif' === $type) {
    $pic_im   = imagecreatefromgif($pic);
    $thumb_im = imagecreatefromgif($thumb);
    header('Content-type: image/gif');
}

if ('right' === $op) {
    $pic_new_im   = rotate_right90($pic_im);
    $thumb_new_im = rotate_right90($thumb_im);
} elseif ('left' === $op) {
    $pic_new_im   = rotate_left90($pic_im);
    $thumb_new_im = rotate_left90($thumb_im);
}

if ('image/jpeg' === $type or 'image/jpg' === $type or 'image/pjpg' === $type or 'image/pjpeg' === $type) {
    imagejpeg($pic_new_im, $pic);
    imagejpeg($thumb_new_im, $thumb);
} elseif ('image/png' === $type) {
    imagepng($pic_new_im, $pic);
    imagepng($thumb_new_im, $thumb);
} elseif ('image/gif' === $type) {
    imagegif($pic_new_im, $pic);
    imagegif($thumb_new_im, $thumb);
}
imagedestroy($pic_new_im);
imagedestroy($thumb_new_im);

echo XOOPS_URL . "/uploads/{$subdir}{$thumbs_dir}/{$filename}";

function rotate_right90($im)
{
    $wid = imagesx($im);
    $hei = imagesy($im);
    $im2 = imagecreatetruecolor($hei, $wid);

    for ($i = 0; $i < $wid; $i++) {
        for ($j = 0; $j < $hei; $j++) {
            $ref = imagecolorat($im, $i, $j);
            imagesetpixel($im2, $hei - 1 - $j, $i, $ref);
        }
    }

    return $im2;
}

function rotate_left90($im)
{
    $wid = imagesx($im);
    $hei = imagesy($im);
    $im2 = imagecreatetruecolor($hei, $wid);

    for ($i = 0; $i < $wid; $i++) {
        for ($j = 0; $j < $hei; $j++) {
            $ref = imagecolorat($im, $i, $j);
            imagesetpixel($im2, $j, $wid - 1 - $i, $ref);
        }
    }

    return $im2;
}

function mirror($im)
{
    $wid = imagesx($im);
    $hei = imagesy($im);
    $im2 = imagecreatetruecolor($wid, $hei);

    for ($i = 0; $i < $wid; $i++) {
        for ($j = 0; $j < $hei; $j++) {
            $ref = imagecolorat($im, $i, $j);
            imagesetpixel($im2, $wid - 1 - $i, $j, $ref);
        }
    }

    return $im2;
}

function flip($im)
{
    $wid = imagesx($im);
    $hei = imagesy($im);
    $im2 = imagecreatetruecolor($wid, $hei);

    for ($i = 0; $i < $wid; $i++) {
        for ($j = 0; $j < $hei; $j++) {
            $ref = imagecolorat($im, $i, $j);
            imagesetpixel($im2, $i, $hei - $j, $ref);
        }
    }

    return $im2;
}
