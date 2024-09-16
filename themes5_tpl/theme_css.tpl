<!--導覽工具列、區塊標題CSS設定開始-->
<style type="text/css">
    body {
        color: <{$font_color}>;
        background-color: <{$bg_color}>;
        <{if $bg_img|default:false}>background-image: url('<{$bg_img}>');<{/if}>
        background-position: <{$bg_position}>;
        background-repeat: <{$bg_repeat}>;
        background-attachment: <{$bg_attachment}>;
        background-size: <{$bg_size}>;
        font-size: <{$font_size}>;
        font-family: <{$font_family}>;
    }

    a {
        color:<{$link_color}>;
        font-family: <{if $font_family|default:false}><{$font_family}>, <{/if}>FontAwesome;
    }

    a:hover {
        color:<{$hover_color}>;
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
                background-image: url(<{$navbar_img}>);
                /* background-size: cover; */
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
            <{/if}>
        <{/if}>
    }

    #xoops_theme_nav {
        <{if $nav_display_type=='not_full'}>
            <{if $navbar_img|default:false}>
                background-color: tranparent;
                background-image: url(<{$navbar_img}>);
                /* background-size: cover; */
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
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