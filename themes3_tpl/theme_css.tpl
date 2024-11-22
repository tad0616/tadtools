<!--導覽工具列、區塊標題CSS設定開始 by hc-->
<style type="text/css">
  body{
    color:<{$font_color|default:''}>;
    background-color: <{$bg_color|default:''}>;
    <{if $bg_img|default:false}>background-image: url('<{$bg_img|default:''}>');<{/if}>
    background-position:  <{$bg_position|default:''}>;
    background-repeat:  <{$bg_repeat|default:''}>;
    background-attachment:<{$bg_attachment|default:''}>;
    background-size: <{$bg_size|default:''}>;
    font-size:<{$font_size|default:''}>;
    <{if $font_family|default:false}>font-family: <{$font_family|default:''}>;<{/if}>
  }

  a{
    color:<{$link_color|default:''}>;
    <{if $font_family|default:false}>font-family: <{$font_family|default:''}>;<{/if}>
  }

  a:hover{
    color:<{$hover_color|default:''}>;
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