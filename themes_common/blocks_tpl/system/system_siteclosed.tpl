<!DOCTYPE html>
<html lang="<{$xoops_langcode}>">
  <head>
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

      #xoops_theme_left_zone{
        <{if $left_separate=='1'}>
          border-right:<{$separate_style}>;
        <{/if}>
      }

      #xoops_theme_right_zone{
        <{if $right_separate=='1'}>
          border-<{if $theme_type=="theme_type_3" or $theme_type=="theme_type_4" or $theme_type=="theme_type_8"}>top<{else}>left<{/if}>:<{$separate_style}>;
        <{/if}>
      }
    </style>
  </head>

  <body>
    <!-- 頁面容器 -->

    <{if $theme_kind=="bootstrap" or $theme_kind=="bootstrap3"}>
    <div class="<{if $use_container=='1'}>container<{else}>container-fluid<{/if}>" style="margin-top:<{$margin_top}>px;">
    <{else}>
    <div id="xoops_theme_container" style="position:relative;width:<{$theme_width}>px;margin:<{$margin_top}>px auto 0 auto;padding:0px;">
    <{/if}>

      <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row <{if $use_shadow=='1' and $shadow_include_logo=='1'}>xoops_content_shadow<{/if}>"<{/if}> id="xoops_theme_content" style="width:auto;">
        <!-- logo -->
        <{if $logo_img and $logo_position=="page"}>
          <div style="background-color:<{$logo_bgcolor}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/logo.html"}>
          </div>
        <{/if}>
      </div>


      <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row <{if $use_shadow=='1'}>xoops_content_shadow<{/if}>"<{/if}> id="xoops_theme_content" style="width:auto;">
        <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="col-md-12"<{/if}>>
          <div id="xoops_theme_content_display" style="<{$content_zone}>">

              <!-- 頁首 -->
              <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row"<{/if}> id="xoops_theme_header">

                  <!-- 導覽列 -->
                  <{if $navbar_pos!="navbar-static-bottom"}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/navbar.html"}>
                  <{/if}>

                  <!-- 滑動圖 -->
                  <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/slideshow_responsive.html"}>

                  <!-- 導覽列 -->
                  <{if $navbar_pos=="navbar-static-bottom"}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/navbar.html"}>
                  <{/if}>
              </div>

              <!-- 載入布局 -->
              <div class="row" style="background: white;">
                <div class="col-md-12">
                  <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/siteclosed_login.tpl"}>
                </div>
              </div>


              <!-- 頁尾 -->
              <{if $xoops_footer}>
                <style>
                #xoops_theme_footer a,#xoops_theme_footer a:hover,#xoops_theme_footer a:active ,#xoops_theme_footer a:visited {
                  color:<{$footer_color}>;
                }
                </style>
                <div id="xoops_theme_footer" <{if $theme_kind|substr:0:9=="bootstrap"}>class="row"<{/if}> style="clear:both;margin-bottom:<{$margin_bottom}>px;height:<{$footer_height}>;background:<{$footer_bgcolor}> <{if $footer_img}>url(<{$footer_img}>)<{/if}>;<{$foot_bg_css}>">
                  <{if $xoops_isadmin}>
                    <a href="<{$xoops_url}>/modules/system/admin.php?fct=preferences&op=show&confcat_id=3" class="block_config"></a>
                  <{/if}>
                  <div class="col-md-12" style="padding:<{$footer_padding}>;color:<{$footer_color}>;<{$footer_style}>">
                    <{$xoops_footer}>
                  </div>
                </div>
              <{/if}>
        </div>
      </div>
    </div>

    <!-- 載入bootstrap -->
    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/bootstrap_js.html"}>

    <!-- 載入自訂js -->
    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/my_js.html"}>


    <{$my_code}>
    <!-- 顯示參數，開發用，開發完可刪除 -->
    <{if $show_var=='1'}>
      <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/show_var.html"}>
    <{/if}>

  </body>
</html>

