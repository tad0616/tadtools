<?php
//區塊主函式 (tadtools_qrcode)
function tadtools_qrcode($options)
{
    global $xoopsDB;

    include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

    $protocol = ($_SERVER['HTTPS']) ? 'https://' : 'http://';
    get_jquery();
    $block['url'] = urlencode($protocol . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']);
    return $block;
}
