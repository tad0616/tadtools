<?php
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式 (tadtools_app)
function tadtools_app($options)
{
    global $xoopsDB, $xoopsConfig;

    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    Utility::get_jquery();
    $block['url1'] = "";
    $block['url2'] = XOOPS_URL;
    $block['width'] = $options[0] < 50 ? 120 : (int) $options[0];
    $block['title'] = $xoopsConfig['sitename'];
    // $j['url'] = XOOPS_URL;
    // $j['title'] = $xoopsConfig['sitename'];
    // $json = json_encode($j, 256);
    // $block['json'] = $json;
    return $block;
}

function tadtools_app_edit($options)
{
    $form = "
    <div class='my-row'>
        <lable class='my-label'>" . _MB_TT_QRCODE_WIDTH . "</lable>
        <input type='text' name='options[0]' value='{$options[0]}' class='my-input' size=5>px
    </div>
    ";

    return $form;
}
