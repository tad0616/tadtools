<?php
use XoopsModules\Tadtools\Utility;
include_once "../../mainfile.php";
if (!$xoopsUser) {
    redirect_header("index.php", 3, "請先登入。");
}

require_once XOOPS_ROOT_PATH . '/modules/tadtools/tcpdf/tcpdf.php';
$font = new TCPDF_FONTS();
$fontname = $font->addTTFfont(XOOPS_ROOT_PATH . '/modules/tadtools/twsung98_1.ttf');
