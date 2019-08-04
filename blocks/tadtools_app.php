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
    $block['url1']  = "https://wst24365888.github.io/xoops-app/";
    $block['url2']  = XOOPS_URL;
    $block['width'] = $options[0] < 50 ? 120 : (int) $options[0];
    $block['title'] = $xoopsConfig['sitename'];
    $block['direction'] = $options[1];
    
    return $block;
}

function tadtools_app_edit($options)
{
    $options1_v = $options[1] == 'v' ? 'checked' : '';
    $options1_h = $options[1] != 'v' ? 'checked' : '';

    $form = "
    <div class='my-row'>
        <lable class='my-label'>" . _MB_TT_QRCODE_WIDTH . "</lable>
        <input type='text' name='options[0]' value='{$options[0]}' class='my-input' size=5>px
        <lable class='my-label'>" . _MB_TT_APP_SETUP_1 . "</lable>
        <input type='radio' name='options[1]' value='v' {$options1_v} class='my-input'>" . _MB_TT_APP_SETUP_1V . "
        <input type='radio' name='options[1]' value='h' {$options1_h} class='my-input'>" . _MB_TT_APP_SETUP_1H . "
    </div>
    ";

    return $form;
}
