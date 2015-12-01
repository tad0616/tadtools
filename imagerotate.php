<?php
include_once "tadtools_header.php";

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op         = system_CleanVars($_REQUEST, 'op', '', 'string');
$subdir     = system_CleanVars($_REQUEST, 'subdir', '', 'string');
$image_dir  = system_CleanVars($_REQUEST, 'image_dir', '', 'string');
$thumbs_dir = system_CleanVars($_REQUEST, 'thumbs_dir', '', 'string');
$filename   = system_CleanVars($_REQUEST, 'filename', '', 'string');
$type       = system_CleanVars($_REQUEST, 'type', '', 'string');

$pic   = XOOPS_ROOT_PATH . "/uploads/{$subdir}{$image_dir}/{$filename}";
$thumb = XOOPS_ROOT_PATH . "/uploads/{$subdir}{$thumbs_dir}/{$filename}";

if ($type == "image/jpeg" or $type == "image/jpg" or $type == "image/pjpg" or $type == "image/pjpeg") {
    $pic_im   = imagecreatefromjpeg($pic);
    $thumb_im = imagecreatefromjpeg($thumb);
    header('Content-type: image/jpg');
} elseif ($type == "image/png") {
    $pic_im   = imagecreatefrompng($pic);
    $thumb_im = imagecreatefrompng($thumb);
    header('Content-type: image/png');
} elseif ($type == "image/gif") {
    $pic_im   = imagecreatefromgif($pic);
    $thumb_im = imagecreatefromgif($thumb);
    header('Content-type: image/gif');
}

if ($op == 'right') {
    $pic_new_im   = rotate_right90($pic_im);
    $thumb_new_im = rotate_right90($thumb_im);
} elseif ($op == 'left') {
    $pic_new_im   = rotate_left90($pic_im);
    $thumb_new_im = rotate_left90($thumb_im);
}

if ($type == "image/jpeg" or $type == "image/jpg" or $type == "image/pjpg" or $type == "image/pjpeg") {
    imagejpeg($pic_new_im, $pic);
    imagejpeg($thumb_new_im, $thumb);
} elseif ($type == "image/png") {
    imagepng($pic_new_im, $pic);
    imagepng($thumb_new_im, $thumb);
} elseif ($type == "image/gif") {
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
            imagesetpixel($im2, $hei - $j, $i, $ref);
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
            imagesetpixel($im2, $j, $wid - $i, $ref);
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
            imagesetpixel($im2, $wid - $i, $j, $ref);
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
