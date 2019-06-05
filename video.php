<?php
use XoopsModules\Tadtools\JwPlayer;
use XoopsModules\Tadtools\Utility;

//給 TadUpFiles.php 用的，讓它可以直接播放影片
require_once 'tadtools_header.php';
require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$media = system_CleanVars($_REQUEST, 'file_name', '', 'string');
$image = XOOPS_URL . '/modules/tadtools/images/video.png';

$jw = new JwPlayer('video', $media, $image, '100%', null, null, null, null, true);
$video = $jw->render();
echo Utility::html5($video);
