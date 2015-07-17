<?php

include_once 'modinfo_common.php';

define('_MI_TADTOOLS_ADMENU1', '初始設定');
define('_MI_TADTOOLS_ADMENU1_DESC', '佈景是否引入bootstrap的設定');

define('_MI_TADTOOLS_NAME', 'Tad Tools 工具包');
define('_MI_TADTOOLS_DESC', 'Tad Tools 工具包只是一個常用工具的集合，可以讓其他的模組引用相同工具');

define('_MI_TADTOOLS_TITLE4', '是否使用導覽列的釘住功能');
define('_MI_TADTOOLS_DESC4', '選「是」時，在畫面往下移動時，導覽列會自動維持在最上方。');
define('_MI_TADTOOLS_TITLE5', '下載檔案的路徑是否根據主機環境自動轉碼');
define('_MI_TADTOOLS_DESC5', '若是中文檔名無法下載的時候，試試改變此設定值。');

define('_MI_TADTOOLS_TITLE6', '設定 SyntaxHighlighter 佈景');
define('_MI_TADTOOLS_DESC6', '請選擇想要的高亮度語法佈景');

define('_MI_TADTOOLS_TITLE7', '選擇 SyntaxHighlighter 版本');
define('_MI_TADTOOLS_DESC7', 'SyntaxHighlighter2 適用程式碼常會換行的情況，SyntaxHighlighter3則是可以直接選取複製');

define('_MI_TADTOOLS_QRCODE_BLOCK_NAME', 'QR Code 區塊');
define('_MI_TADTOOLS_QRCODE_BLOCK_DESC', 'QR Code 區塊區塊 (tadtools_qrcode)');

define('_MI_TADTOOLS_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADTOOLS_HELP_HEADER', __DIR__ . '/help/helpheader.html');
define('_MI_TADTOOLS_BACK_2_ADMIN', '管理 ');

//help
define('_MI_TADTOOLS_HELP_OVERVIEW', '概要');
