<!DOCTYPE html>
<html lang="<{$xoops_langcode}>">
  <head>
    <meta http-equiv="Refresh" content="<{$time}>; url=<{$url}>"/>
    <!--目前$_SESSION['bootstrap']="<{php}>echo $_SESSION['bootstrap'];<{/php}>"; -->
    <!--將目前的資料夾名稱，設定為樣板標籤變數 theme_name-->
    <{assign var=theme_name value=$xoTheme->folderName}>

    <!--載入由使用者設定的各項佈景變數-->
    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/get_var.html"}>

    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/meta.html"}>
    <!-- 網站的標題及標語 -->
    <title><{$xoops_sitename}> - <{$xoops_pagetitle}></title>

    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/link_css.html"}>

    <link href="<{xoImgUrl styles/custom.css}>" rel="stylesheet" type="text/css" />

    <!-- 給模組套用的樣板標籤 -->
    <{$xoops_module_header}>
    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/xoops_module_header.tpl"}>

    <!-- 局部套用的樣式，如果有載入完整樣式 theme_css.html 那就不需要這一部份 -->
    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/theme_css.html"}>

    <style type="text/css">
        body{
            font-family:<{$font_family}>;
        }
        html,body {
            height: 100%; margin: 0px;
            padding: 0px;
        }
        #full {
            height: 100%
        }
    </style>
  </head>

  <body>
    <!-- 頁面容器 -->
    <div class="container-fluid" id="full">

        <div class="row" style="margin-top: 10%;">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading"><{$message}></div>
                  <div class="panel-body">
                    <p><{$lang_ifnotreload}></p>
                  </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

    </div>

  </body>
</html>

