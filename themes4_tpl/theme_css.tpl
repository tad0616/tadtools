<!--導覽工具列、區塊標題CSS設定開始-->
<style type="text/css">
    body {
        color: <{$font_color}>;
        background-color: <{$bg_color}>;
        <{if $bg_img}>background-image: url('<{$bg_img}>');<{/if}>
        background-position: <{$bg_position}>;
        background-repeat: <{$bg_repeat}>;
        background-attachment: <{$bg_attachment}>;
        background-size: <{$bg_size}>;
        font-size: <{$font_size}>;
        font-family: <{$font_family}>;
    }

    a {
        color:<{$link_color}>;
    }

    a:hover {
        color:<{$hover_color}>;
    }

    #logo-container{
        <{if $logo_display_type!='not_full'}>
        background-color: <{$logo_bgcolor}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }

    #logo-container-display{
        <{if $logo_display_type=='not_full'}>
        background-color: <{$logo_bgcolor}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }


    #slide-container{
        <{if $slide_display_type!='not_full'}>
        background-color: <{$slide_bgcolor}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }

    #slide-container-display{
        <{if $slide_display_type=='not_full'}>
        background-color: <{$slide_bgcolor}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }


    #nav-container{
        position: relative;
        z-index: 10;
        <{if $nav_display_type=='not_full'}>
            background-color:tranparent;
        <{else}>
            <{if $navbar_img}>
                background-color:tranparent;
                background-image: url(<{$navbar_img}>);
                background-size: cover;
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
            <{/if}>
        <{/if}>
    }

    #nav-container-display{
        <{if $nav_display_type=='not_full'}>
            <{if $navbar_img}>
                background-color: tranparent;
                background-image: url(<{$navbar_img}>);
                background-size: cover;
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top}>, <{$navbar_bg_bottom}>);
            <{/if}>
        <{else}>
            background-color: tranparent;
        <{/if}>
    }

    #content-container{
        <{if $content_display_type=='not_full'}>
            background-color: tranparent;
        <{else}>
            background-color: <{$base_color}>;
        <{/if}>
    }

    #content-container-display{
        <{if $content_display_type=='not_full'}>
            background-color: <{$base_color}>;
        <{else}>
            background-color:tranparent;
        <{/if}>
    }

    #footer-container{
        position: relative;
        z-index: 8;
        <{if $footer_display_type=='not_full'}>
            background-color:tranparent;
        <{else}>
            background-color: <{$footer_bgcolor}>;
            margin-bottom:<{$margin_bottom}>px;
            min-height:<{$footer_height}>;
            background:<{$footer_bgcolor}> <{if $footer_img}>url(<{$footer_img}>)<{/if}>;
            <{$foot_bg_css}>
        <{/if}>
    }

    #footer-container-display{
        padding:<{$footer_padding}>;
        color:<{$footer_color}>;
        <{$footer_style}>
        <{if $footer_display_type=='not_full'}>
            background-color: <{$footer_bgcolor}>;
            margin-bottom:<{$margin_bottom}>px;
            min-height:<{$footer_height}>;
            background:<{$footer_bgcolor}> <{if $footer_img}>url(<{$footer_img}>)<{/if}>;
            <{$foot_bg_css}>
        <{else}>
            background-color:tranparent;
        <{/if}>
    }

    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/theme_css_blocks.tpl"}>

    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/theme_css_navbar.tpl"}>

</style>
<!--導覽工具列、區塊標題CSS設定 by hc-->