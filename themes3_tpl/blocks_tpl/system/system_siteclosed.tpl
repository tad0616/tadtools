<!DOCTYPE html>
<html lang="<{$xoops_langcode|default:''}>">
  <head>
    <{assign var="bootstrap" value=$smarty.session.bootstrap|default:$session.bootstrap}>
    <!--目前$_SESSION['bootstrap']="<{$bootstrap|default:''}>"; -->
    <!--將目前的資料夾名稱，設定為樣板標籤變數 theme_name-->
    <{assign var="theme_name" value=$xoTheme->folderName}>


    <{include file="$xoops_rootpath/modules/tadtools/themes_common/meta.tpl"}>
    <!-- 網站的標題及標語 -->
    <title><{$xoops_sitename|default:''}> - <{$xoops_pagetitle|default:''}></title>

    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/link_css.tpl"}>


    <!-- 給模組套用的樣板標籤 -->
    <{$xoops_module_header|default:''}>
    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/xoops_module_header.tpl"}>

    <!-- 局部套用的樣式，如果有載入完整樣式 theme_css.html 那就不需要這一部份 -->
    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/theme_css.tpl"}>

    <style type="text/css">
      body{
        font-family:<{$font_family|default:''}>;
      }

      #xoops_theme_left_zone{
        <{if $left_separate=='1'}>
          border-right:<{$separate_style|default:''}>;
        <{/if}>
      }

      #xoops_theme_right_zone{
        <{if $right_separate=='1'}>
          border-<{if $theme_type=="theme_type_3" or $theme_type=="theme_type_4" or $theme_type=="theme_type_8"}>top<{else}>left<{/if}>:<{$separate_style|default:''}>;
        <{/if}>
      }
    </style>
  </head>

  <body>
    <!-- 頁面容器 -->

    <{if $theme_kind=="bootstrap" or $theme_kind=="bootstrap3"}>
    <div class="<{if $use_container=='1'}>container<{else}>container-fluid<{/if}>" style="margin-top:<{$margin_top|default:''}>px;">
    <{else}>
    <div id="xoops_theme_container" style="position:relative;width:<{$theme_width|default:''}>px;margin:<{$margin_top|default:''}>px auto 0 auto;padding:0px;">
    <{/if}>

      <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row <{if $use_shadow=='1' and $shadow_include_logo=='1'}>xoops_content_shadow<{/if}>"<{/if}> id="xoops_theme_content" style="width:auto;">
        <!-- logo -->
        <{if $logo_img and $logo_position=="page"}>
          <div style="background-color:<{$logo_bgcolor|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/logo.tpl"}>
          </div>
        <{/if}>
      </div>


      <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row <{if $use_shadow=='1'}>xoops_content_shadow<{/if}>"<{/if}> id="xoops_theme_content" style="width:auto;">
        <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="col-sm-12"<{/if}>>
          <div id="xoops_theme_content_display" style="<{$content_zone|default:''}>">

              <!-- 頁首 -->
              <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row"<{/if}> id="xoops_theme_header">

                  <!-- 導覽列 -->
                  <{if $navbar_pos!="navbar-static-bottom"}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/navbar.tpl"}>
                  <{/if}>

                  <!-- 滑動圖 -->
                  <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/slideshow_responsive.tpl"}>

                  <!-- 導覽列 -->
                  <{if $navbar_pos=="navbar-static-bottom"}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/navbar.tpl"}>
                  <{/if}>
              </div>

              <!-- 載入布局 -->
              <div class="row" style="background: white;">
                <div class="col-sm-12">
                  <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/siteclosed_login.tpl"}>
                </div>
              </div>


              <!-- 頁尾 -->
              <{if $xoops_footer|default:false}>
                <style>
                #xoops_theme_footer a,#xoops_theme_footer a:hover,#xoops_theme_footer a:active ,#xoops_theme_footer a:visited {
                  color:<{$footer_color|default:''}>;
                }
                </style>
                <div id="xoops_theme_footer" <{if $theme_kind|substr:0:9=="bootstrap"}>class="row"<{/if}> style="clear:both;margin-bottom:<{$margin_bottom|default:''}>px;height:<{$footer_height|default:''}>;background:<{$footer_bgcolor|default:''}> <{if $footer_img|default:false}>url(<{$footer_img|default:''}>)<{/if}>;<{$foot_bg_css|default:''}>">
                  <{if $xoops_isadmin|default:false}>
                    <a href="<{$xoops_url}>/modules/system/admin.php?fct=preferences&op=show&confcat_id=3" class="block_config"></a>
                  <{/if}>
                  <div class="col-sm-12" style="padding:<{$footer_padding|default:''}>;color:<{$footer_color|default:''}>;<{$footer_style|default:''}>">
                    <{$xoops_footer|default:''}>
                  </div>
                </div>
              <{/if}>
        </div>
      </div>
    </div>

    <!-- 載入bootstrap -->
    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/bootstrap_js.tpl"}>

    <!-- 載入自訂js -->
    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/my_js.tpl"}>


    <{$my_code|default:''}>
    <!-- 顯示參數，開發用，開發完可刪除 -->
    <{if $show_var=='1'}>
      <{include file="$xoops_rootpath/modules/tadtools/themes_common/show_var.tpl"}>
    <{/if}>

  </body>
</html>
