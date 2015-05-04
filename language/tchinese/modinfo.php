<?php

include_once "modinfo_common.php";


define("_MI_TADTOOLS_ADMENU1" , "初始設定");
define("_MI_TADTOOLS_ADMENU1_DESC" , "佈景是否引入bootstrap的設定");

define("_MI_TADTOOLS_NAME","Tad Tools 工具包");
define("_MI_TADTOOLS_DESC","Tad Tools 工具包只是一個常用工具的集合，可以讓其他的模組引用相同工具");

define("_MI_TADTOOLS_TITLE1","jquery 的使用？");
define("_MI_TADTOOLS_DESC1","請選擇 jquery 的來源");
define("_MI_TADTOOLS_TITLE1_OPT1","使用 Google 的 jquery API（推薦，最能避免衝突）");
define("_MI_TADTOOLS_TITLE1_OPT2","使用 TadTools 內建的 jquery（或許會和其他非Tad系列模組相衝突）");
define("_MI_TADTOOLS_TITLE1_OPT3","關閉 jquery 功能（需自己手動加至佈景，記得也要加入 jquery ui）");

define("_MI_TADTOOLS_TITLE2","導覽列的登入選項");
define("_MI_TADTOOLS_DESC2","請選擇預設導覽列中登入選項的呈現方式");
define('_MI_TADTOOLS_TITLE2_OPT0','僅顯示XOOPS的登入界面');
define('_MI_TADTOOLS_TITLE2_OPT1','同時顯示XOOPS的登入界面和OpenID的按鈕');
define('_MI_TADTOOLS_TITLE2_OPT2','僅顯示OpenID的按鈕');
define('_MI_TADTOOLS_TITLE2_OPT3','不顯示登入選項');



define("_MI_TADTOOLS_TITLE3","登入選單中的快速登入圖示一排幾個");
define("_MI_TADTOOLS_DESC3","若「是否崁入快速登入到登入選單中」為「是」時，選一個會出現圖示及文字，選兩個以上就只剩圖示。");
define("_MI_TADTOOLS_TITLE4","是否使用導覽列的釘住功能");
define("_MI_TADTOOLS_DESC4","選「是」時，在畫面往下移動時，導覽列會自動維持在最上方。");
define("_MI_TADTOOLS_TITLE5","下載檔案的路徑是否根據主機環境自動轉碼");
define("_MI_TADTOOLS_DESC5","若是中文檔名無法下載的時候，試試改變此設定值。");

define("_MI_TADTOOLS_TITLE6","設定 SyntaxHighlighter 佈景");
define("_MI_TADTOOLS_DESC6","請選擇想要的高亮度語法佈景");

define("_MI_TADTOOLS_TITLE7","選擇 SyntaxHighlighter 版本");
define("_MI_TADTOOLS_DESC7","SyntaxHighlighter2 適用程式碼常會換行的情況，SyntaxHighlighter3則是可以直接選取複製");

define('_MI_TADTOOLS_QRCODE_BLOCK_NAME' , 'QR Code 區塊');
define('_MI_TADTOOLS_QRCODE_BLOCK_DESC' , 'QR Code 區塊區塊 (tadtools_qrcode)');


?>