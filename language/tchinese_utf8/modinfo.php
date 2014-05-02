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

define("_MI_TADTOOLS_TITLE2","是否崁入快速登入到登入選單中");
define("_MI_TADTOOLS_DESC2","選「是」會將tad_login中可使用的OpenID登入方式整合至登入選單中。");
?>