<?php

require_once __DIR__ . '/modinfo_common.php';

define('_MI_TADTOOLS_ADMENU1', '初始設定');
define('_MI_TADTOOLS_ADMENU1_DESC', '佈景是否引入bootstrap的設定');

define('_MI_TADTOOLS_NAME', 'Tad Tools 工具包');
define('_MI_TADTOOLS_DESC', 'Tad Tools 工具包只是一個常用工具的集合，可以讓其他的模組引用相同工具');

define('_MI_TADTOOLS_TITLE5', '下載檔案的路徑是否根據主機環境自動轉碼');
define('_MI_TADTOOLS_DESC5', '若是中文檔名無法下載的時候，試試改變此設定值。');

define('_MI_TADTOOLS_TITLE8', 'uploadcare 的 public key');
define('_MI_TADTOOLS_DESC8', '請至 <a href="https://uploadcare.com/" target="_blank">https://uploadcare.com/</a> 註冊，並建立任一個專案，取得其 public key 後填入此處，CK編輯器便能使用外部儲存空間功能。');

define('_MI_TADTOOLS_QRCODE_BLOCK_NAME', '本頁面行動條碼');
define('_MI_TADTOOLS_QRCODE_BLOCK_DESC', '本頁面行動條碼區塊 (tadtools_qrcode)');
define('_MI_TADTOOLS_APP_BLOCK_NAME', '本站App下載設定');
define('_MI_TADTOOLS_APP_BLOCK_DESC', '本站App下載設定區塊 (tadtools_app)');

define('_MI_TADTOOLS_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADTOOLS_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADTOOLS_BACK_2_ADMIN', '管理 ');

//help
define('_MI_TADTOOLS_HELP_OVERVIEW', '概要');

define('_MI_TADTOOLS_USE_CODEMIRROR', '是否使用 codemirror 外掛？');
define('_MI_TADTOOLS_USE_CODEMIRROR_DESC', 'codemirror 可美化編輯器的原始碼模式');

define('_MI_TADTOOLS_IMAGE_MAX_WIDTH', 'CK編輯器上傳圖片的最大寬度');
define('_MI_TADTOOLS_IMAGE_MAX_WIDTH_DESC', '請填數字，單位為px');
define('_MI_TADTOOLS_IMAGE_MAX_HEIGHT', 'CK編輯器上傳圖片的最大高度');
define('_MI_TADTOOLS_IMAGE_MAX_HEIGHT_DESC', '請填數字，單位為px');

define('_MI_TADTOOLS_MIME_TYPE_CHECK', '上傳檔案時需要進行檔案的 MIME TYPE 檢查');
define('_MI_TADTOOLS_MIME_TYPE_CHECK_DESC', '此檢查是避免有檔案掛羊頭賣狗肉，若檔案無法上傳，可以取消此檢查試試');

define('_MI_TADTOOLS_INSERT_SPACING', '自動在中文和英文之間自動加入空格');
define('_MI_TADTOOLS_INSERT_SPACING_DESC', '顯示文章時會自動在中文和英文之間自動加入空格，避免將網址轉為連結時轉換錯誤（但若網址中有中英文混雜狀況時，可能會導致無法下載）');
define('_MI_TADTOOLS_LINKIFY', '將網址轉為連結');
define('_MI_TADTOOLS_LINKIFY_DESC', '自動將內文的網址轉換成連結');
define('_MI_TADTOOLS_PDF_FORCE_DL', 'PDF 檔是否強制下載？');
define('_MI_TADTOOLS_PDF_FORCE_DL_DESC', '若要符合無障礙 2.1，請選「是」，若想直接線上預覽請選「否」');

define('_MI_TADTOOLS_TEST_MODE', '開發測試模式是否僅開放給管理者');
define('_MI_TADTOOLS_TEST_MODE_DESC', '建議選「是」，此選項一般使用者用不到，僅開發者會使用');

define('_MI_TADTOOLS_FACEBOOK_APP_ID', 'FaceBook 的 App ID（推文工具會用到）');
define('_MI_TADTOOLS_FACEBOOK_APP_ID_DESC', '可至 https://developers.facebook.com/apps 申請並取得 App ID');

define('_MI_TADTOOLS_CK_WCAG', 'CK編輯器貼上時符合無障礙規範');
define('_MI_TADTOOLS_CK_WCAG_DESC', '建議選「是」，貼上時，會以純文字貼上，避免違反無障礙規範');
