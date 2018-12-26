<?php

$modversion                   = array();
$modversion['name']           = _MI_TADTOOLS_NAME;
$modversion['version']        = 3.21;
$modversion['description']    = _MI_TADTOOLS_DESC;
$modversion['author']         = 'Tad (tad0616@gmail.com)';
$modversion['credits']        = '';
$modversion['help']           = 'page=help';
$modversion['license']        = 'GNU GPL 2.0 or later';
$modversion['license_url']    = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image']          = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname']        = basename(__DIR__);
$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons16']        = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32']        = '../../Frameworks/moduleclasses/icons/32';

//about
$modversion['module_status']       = 'Final';
$modversion['release_date']        = '2019/01/01';
$modversion['module_website_url']  = 'http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1';
$modversion['module_website_name'] = 'XOOPS EZGO';
$modversion['author_website_url']  = 'https://tad0616.net';
$modversion['author_website_name'] = 'Tad';
$modversion['min_php']             = '5.4';
$modversion['min_xoops']           = '2.5.7';
$modversion['min_admin']           = '1.1';
$modversion['min_db']              = array(
    'mysql'  => '5.0.7',
    'mysqli' => '5.0.7');

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'tad0616@gmail.com';
$modversion['paypal']['item_name']     = 'Donation : ' . _MI_TADTOOLS_DESC;
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'TWD';

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1]        = "tadtools_setup";

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---安裝設定---//
$modversion['onInstall']   = "include/onInstall.php";
$modversion['onUpdate']    = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---樣板設定---//
$i                                          = 1;
$modversion['templates'][$i]['file']        = 'tadtools_adm_index.tpl';
$modversion['templates'][$i]['description'] = 'tadtools_adm_index.tpl';

//---偏好設定---//
$i = 1;

$modversion['config'][$i]['name']        = 'use_pin';
$modversion['config'][$i]['title']       = '_MI_TADTOOLS_TITLE4';
$modversion['config'][$i]['description'] = '_MI_TADTOOLS_DESC4';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';

$i++;
$modversion['config'][$i]['name']        = 'auto_charset';
$modversion['config'][$i]['title']       = '_MI_TADTOOLS_TITLE5';
$modversion['config'][$i]['description'] = '_MI_TADTOOLS_DESC5';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';

$i++;
$modversion['config'][$i]['name']        = 'syntaxhighlighter_themes';
$modversion['config'][$i]['title']       = '_MI_TADTOOLS_TITLE6';
$modversion['config'][$i]['description'] = '_MI_TADTOOLS_DESC6';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'shThemeMonokai';
$modversion['config'][$i]['options']     = array('shThemeDefault' => 'shThemeDefault', 'shThemeDjango' => 'shThemeDjango', 'shThemeEclipse' => 'shThemeEclipse', 'shThemeEmacs' => 'shThemeEmacs', 'shThemeFadeToGrey' => 'shThemeFadeToGrey', 'shThemeMDUltra' => 'shThemeMDUltra', 'shThemeMidnight' => 'shThemeMidnight', 'shThemeRDark' => 'shThemeRDark', 'shThemeMonokai' => 'shThemeMonokai');

$i++;
$modversion['config'][$i]['name']        = 'syntaxhighlighter_version';
$modversion['config'][$i]['title']       = '_MI_TADTOOLS_TITLE7';
$modversion['config'][$i]['description'] = '_MI_TADTOOLS_DESC7';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'syntaxhighlighter';
$modversion['config'][$i]['options']     = array('syntaxhighlighter 2' => 'syntaxhighlighter_2', 'syntaxhighlighter 3' => 'syntaxhighlighter');

$i++;
$modversion['config'][$i]['name']        = 'uploadcare_publickey';
$modversion['config'][$i]['title']       = '_MI_TADTOOLS_TITLE8';
$modversion['config'][$i]['description'] = '_MI_TADTOOLS_DESC8';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '';

$i++;
$modversion['config'][$i]['name']        = 'use_codemirror';
$modversion['config'][$i]['title']       = '_MI_TADTOOLS_USE_CODEMIRROR';
$modversion['config'][$i]['description'] = '_MI_TADTOOLS_USE_CODEMIRROR_DESC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = '1';

$i                                       = 0;
$modversion['blocks'][$i]['file']        = 'tadtools_qrcode.php';
$modversion['blocks'][$i]['name']        = _MI_TADTOOLS_QRCODE_BLOCK_NAME;
$modversion['blocks'][$i]['description'] = _MI_TADTOOLS_QRCODE_BLOCK_DESC;
$modversion['blocks'][$i]['show_func']   = 'tadtools_qrcode';
$modversion['blocks'][$i]['template']    = 'tadtools_qrcode_block.tpl';
$modversion['blocks'][$i]['edit_func']   = "tadtools_qrcode_edit";
$modversion['blocks'][$i]['options']     = "120";
