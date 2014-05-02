<?php
//---基本設定---//
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADTOOLS_NAME;
$modversion['version']	= '2.3';
$modversion['description'] = _MI_TADTOOLS_DESC;
$modversion['author'] = 'Tad (tad0616@gmail.com)';
$modversion['credits']	= "Tad (http://tad0616.net)";
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));


//---模組狀態資訊---//
$modversion['release_date'] = '2014/04/09';
$modversion['module_website_url'] = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']='5.2';
$modversion['min_xoops']='2.5';
$modversion['min_db'] = array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');

//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'tad0616@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TADTOOLS_DESC;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'TWD';


//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "tadtools_setup";

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 0;


//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";


//---樣板設定---//
$modversion['templates'][1]['file'] = 'tadtools_adm_index_tpl.html';
$modversion['templates'][1]['description'] = 'tadtools_adm_index_tpl.html';

//---偏好設定---//
$modversion['config'][1]['name'] = 'jquery_mode';
$modversion['config'][1]['title'] = '_MI_TADTOOLS_TITLE1';
$modversion['config'][1]['description'] = '_MI_TADTOOLS_DESC1';
$modversion['config'][1]['formtype'] = 'select';
$modversion['config'][1]['valuetype'] = 'text';
$modversion['config'][1]['default'] = 'local';
$modversion['config'][1]['options'] = array(_MI_TADTOOLS_TITLE1_OPT1=>'google' , _MI_TADTOOLS_TITLE1_OPT2=>'local' , _MI_TADTOOLS_TITLE1_OPT3=>'none');

$modversion['config'][2]['name'] = 'openid_login';
$modversion['config'][2]['title'] = '_MI_TADTOOLS_TITLE2';
$modversion['config'][2]['description'] = '_MI_TADTOOLS_DESC2';
$modversion['config'][2]['formtype'] = 'yesno';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = '1';


?>