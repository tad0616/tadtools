<!--導覽工具列、區塊標題CSS設定開始-->
<style type="text/css">
    body {
        color: <{$font_color|default:''}>;
        background-color: <{$bg_color|default:''}>;
        <{if $bg_img|default:false}>background-image: url('<{$bg_img|default:''}>');<{/if}>
        background-position: <{$bg_position|default:''}>;
        background-repeat: <{$bg_repeat|default:''}>;
        background-attachment: <{$bg_attachment|default:''}>;
        background-size: <{$bg_size|default:''}>;
        font-size: <{$font_size|default:''}>;
        font-family: <{$font_family|default:''}>;
    }

    a {
        color:<{$link_color|default:''}>;
        font-family: <{if $font_family|default:false}><{$font_family|default:''}>, <{/if}>FontAwesome;
    }

    a:hover {
        color:<{$hover_color|default:''}>;
    }



    #nav-container {
        <{if $navbar_pos=='fixed-bottom'}>
            position: fixed;
            bottom: 0px;
        <{else}>
            /* position: relative; */
        <{/if}>
        z-index: 11;
        <{if $nav_display_type=='not_full'}>
            background-color:tranparent;
        <{else}>
            <{if $navbar_img|default:false}>
                background-color:tranparent;
                background-image: url(<{$navbar_img|default:''}>);
                /* background-size: cover; */
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top|default:''}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top|default:''}>, <{$navbar_bg_bottom|default:''}>);
            <{/if}>
        <{/if}>
    }

    #xoops_theme_nav {
        <{if $nav_display_type=='not_full'}>
            <{if $navbar_img|default:false}>
                background-color: tranparent;
                background-image: url(<{$navbar_img|default:''}>);
                /* background-size: cover; */
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top|default:''}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top|default:''}>, <{$navbar_bg_bottom|default:''}>);
            <{/if}>
        <{else}>
            background-color: tranparent;
        <{/if}>
    }

    /* theme_css_blocks.tpl */
    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/theme_css_blocks.tpl"}>

    /* theme_css_navbar.tpl */
    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/theme_css_navbar.tpl"}>

</style>
<!--導覽工具列、區塊標題CSS設定 by hc-->