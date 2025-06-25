<?php
$modversion = [];
global $xoopsConfig;

$modversion['name']           = _MI_TADTOOLS_NAME;
$modversion['version']        = $_SESSION['xoops_version'] >= 20511 ? '4.0.1-Stable' : '4.01';
$modversion['description']    = _MI_TADTOOLS_DESC;
$modversion['author']         = 'Tad (tad0616@gmail.com)';
$modversion['credits']        = '';
$modversion['help']           = 'page=help';
$modversion['license']        = 'GNU GPL 2.0 or later';
$modversion['license_url']    = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image']          = $xoopsConfig['language'] == 'tchinese_utf8' ? 'images/logo_tw.png' : 'images/logo.png';
$modversion['dirname']        = basename(__DIR__);
$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons16']        = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32']        = '../../Frameworks/moduleclasses/icons/32';

//about
$modversion['module_status']       = 'Final';
$modversion['release_date']        = '2025-06-25';
$modversion['module_website_url']  = 'https://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1';
$modversion['module_website_name'] = 'XOOPS EZGO';
$modversion['author_website_url']  = 'https://www.tad0616.net';
$modversion['author_website_name'] = 'Tad';
$modversion['min_php']             = '5.4';
$modversion['min_xoops']           = '2.5.10';
$modversion['min_db']              = [
    'mysql' => '5.0.7',
    'mysqli' => '5.0.7',
];

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables']           = ['tadtools_setup'];

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---安裝設定---//
$modversion['onInstall']   = 'include/onInstall.php';
$modversion['onUpdate']    = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---樣板設定---//
$i                                          = 1;
$modversion['templates'][$i]['file']        = 'tadtools_adm_index.tpl';
$modversion['templates'][$i]['description'] = 'tadtools_adm_index.tpl';
$modversion['config']                       = [
    ['name' => 'auto_charset', 'title' => '_MI_TADTOOLS_TITLE5', 'description' => '_MI_TADTOOLS_DESC5', 'formtype' => 'yesno', 'valuetype' => 'int', 'default' => 1],
    ['name' => 'uploadcare_publickey', 'title' => '_MI_TADTOOLS_TITLE8', 'description' => '_MI_TADTOOLS_DESC8', 'formtype' => 'textbox', 'valuetype' => 'text', 'default' => ''],
    ['name' => 'use_codemirror', 'title' => '_MI_TADTOOLS_USE_CODEMIRROR', 'description' => '_MI_TADTOOLS_USE_CODEMIRROR_DESC', 'formtype' => 'yesno', 'valuetype' => 'int', 'default' => 1],
    ['name' => 'image_max_width', 'title' => '_MI_TADTOOLS_IMAGE_MAX_WIDTH', 'description' => '_MI_TADTOOLS_IMAGE_MAX_WIDTH_DESC', 'formtype' => 'textbox', 'valuetype' => 'int', 'default' => 1920],
    ['name' => 'image_max_height', 'title' => '_MI_TADTOOLS_IMAGE_MAX_HEIGHT', 'description' => '_MI_TADTOOLS_IMAGE_MAX_HEIGHT_DESC', 'formtype' => 'textbox', 'valuetype' => 'int', 'default' => 1920],
    ['name' => 'insert_spacing', 'title' => '_MI_TADTOOLS_INSERT_SPACING', 'description' => '_MI_TADTOOLS_INSERT_SPACING_DESC', 'formtype' => 'yesno', 'valuetype' => 'int', 'default' => 0],
    ['name' => 'linkify', 'title' => '_MI_TADTOOLS_LINKIFY', 'description' => '_MI_TADTOOLS__MI_TADTOOLS_LINKIFY_DESC', 'formtype' => 'yesno', 'valuetype' => 'int', 'default' => 1],
    ['name' => 'pdf_force_dl', 'title' => '_MI_TADTOOLS_PDF_FORCE_DL', 'description' => '_MI_TADTOOLS__MI_TADTOOLS_PDF_FORCE_DL_DESC', 'formtype' => 'yesno', 'valuetype' => 'int', 'default' => 0],
    ['name' => 'test_mode', 'title' => '_MI_TADTOOLS_TEST_MODE', 'description' => '_MI_TADTOOLS_TEST_MODE_DESC', 'formtype' => 'yesno', 'valuetype' => 'int', 'default' => 1],
    ['name' => 'facebook_app_id', 'title' => '_MI_TADTOOLS_FACEBOOK_APP_ID', 'description' => '_MI_TADTOOLS_FACEBOOK_APP_ID_DESC', 'formtype' => 'textbox', 'valuetype' => 'text', 'default' => ''],
];

//---區塊設定 (索引為固定值，若欲刪除區塊記得補上索引，避免區塊重複)---//
$modversion['blocks'] = [
    0 => ['file' => 'tadtools_qrcode.php', 'name' => _MI_TADTOOLS_QRCODE_BLOCK_NAME, 'description' => _MI_TADTOOLS_QRCODE_BLOCK_DESC, 'show_func' => 'tadtools_qrcode', 'template' => 'tadtools_qrcode_block.tpl', 'edit_func' => 'tadtools_qrcode_edit', 'options' => '120'],
    1 => ['file' => 'tadtools_app.php', 'name' => _MI_TADTOOLS_APP_BLOCK_NAME, 'description' => _MI_TADTOOLS_APP_BLOCK_DESC, 'show_func' => 'tadtools_app', 'template' => 'tadtools_app_block.tpl', 'edit_func' => 'tadtools_app_edit', 'options' => '120|v'],
];
