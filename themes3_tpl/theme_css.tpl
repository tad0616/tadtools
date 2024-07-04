<!--導覽工具列、區塊標題CSS設定開始 by hc-->
<style type="text/css">
  body{
    color:<{$font_color}>;
    background-color: <{$bg_color}>;
    <{if $bg_img}>background-image: url('<{$bg_img}>');<{/if}>
    background-position:  <{$bg_position}>;
    background-repeat:  <{$bg_repeat}>;
    background-attachment:<{$bg_attachment}>;
    background-size: <{$bg_size}>;
    font-size:<{$font_size}>;
    font-family: <{$font_family}>;
  }

  a{
    color:<{$link_color}>;
    font-family: FontAwesome<{if $font_family}>, <{$font_family}><{/if}>;
  }

  a:hover{
    color:<{$hover_color}>;
  }


  <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/theme_css_blocks.tpl"}>

  <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/theme_css_navbar.tpl"}>

  <{if $theme_kind!="html"}>
    .row-sm-eq {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display:         flex;
        flex-direction: column;
    }
    @media (min-width:768px) {
        .row-sm-eq {
            flex-direction: row;
        }
    }
  <{/if}>
</style>
<!--導覽工具列、區塊標題CSS設定 by hc-->