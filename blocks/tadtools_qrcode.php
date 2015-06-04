<?php
//區塊主函式 (tadtools_qrcode)
function tadtools_qrcode($options)
{
    global $xoopsDB;
    $block['url']               = urlencode("http://" . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']);
    $block['bootstrap_version'] = $_SESSION['bootstrap'];
    return $block;
}
