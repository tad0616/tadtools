<?php

include_once 'modinfo_common.php';

define('_MI_TADTOOLS_ADMENU1', '初始設定');
define('_MI_TADTOOLS_ADMENU1_DESC', '佈景是否引入bootstrap的設定');

define('_MI_TADTOOLS_NAME', 'Tad Tools 工具包');
define('_MI_TADTOOLS_DESC', 'Tad Tools 工具包只是一個常用工具的集合，可以讓其他的模組引用相同工具');

define('_MI_TADTOOLS_TITLE1', 'jquery 的使用？');
define('_MI_TADTOOLS_DESC1', '請選擇 jquery 的來源');
define('_MI_TADTOOLS_TITLE1_OPT1', '使用 Google 的 jquery API（推薦，最能避免衝突）');
define('_MI_TADTOOLS_TITLE1_OPT2', '使用 TadTools 內建的 jquery（或許會和其他非Tad系列模組相衝突）');
define('_MI_TADTOOLS_TITLE1_OPT3', '關閉 jquery 功能（需自己手動加至佈景，記得也要加入 jquery ui）');

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
