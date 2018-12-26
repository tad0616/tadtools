<?php
//區塊主函式 (tadtools_qrcode)
function tadtools_qrcode($options)
{
    global $xoopsDB;

    include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    get_jquery();
    $block['url']   = urlencode($protocol . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI']);
    $block['width'] = (int) $options[0];
    return $block;
}

function tadtools_qrcode_edit($options)
{
    $form = "
    <div class='my-row'>
        <lable class='my-label'>" . _MB_TT_QRCODE_WIDTH . "</lable>
        <input type='text' name='options[0]' value='{$options[0]}' class='my-input' size=5>px
    </div>
    ";
    return $form;
}
