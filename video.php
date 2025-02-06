<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\VideoJs;

//給 TadUpFiles.php 用的，讓它可以直接播放影片
require_once 'tadtools_header.php';
$media = Request::getString('file_name');
$image = XOOPS_URL . '/modules/tadtools/images/video.png';

$VideoJs = new VideoJs('video', $media, $image);
$player = $VideoJs->render();
echo Utility::html5($player);
