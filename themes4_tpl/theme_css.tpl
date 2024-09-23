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
        <{if $font_family|default:false}>font-family: <{$font_family|default:''}>;<{/if}>
    }

    a {
        color:<{$link_color|default:''}>;
        font-family: <{if $font_family|default:false}><{$font_family|default:''}>, <{/if}>FontAwesome;
    }

    a:hover {
        color:<{$hover_color|default:''}>;
    }

    #logo-container{
        <{if $logo_display_type!='not_full'}>
        background-color: <{$logo_bgcolor|default:''}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }

    #logo-container-display{
        <{if $logo_display_type=='not_full'}>
        background-color: <{$logo_bgcolor|default:''}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }


    #slide-container{
        <{if $slide_display_type!='not_full'}>
        background-color: <{$slide_bgcolor|default:''}>;
        <{else}>
        background-color: transparent;
        <{/if}>
    }

    #slide-container-display{
        <{if $slide_display_type=='not_full'}>
        background-color: <{$slide_bgcolor|default:''}>;
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
            <{if $navbar_img|default:false}>
                background-color:tranparent;
                background-image: url(<{$navbar_img|default:''}>);
                background-size: cover;
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top|default:''}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top|default:''}>, <{$navbar_bg_bottom|default:''}>);
            <{/if}>
        <{/if}>
    }

    #nav-container-display{
        <{if $nav_display_type=='not_full'}>
            <{if $navbar_img|default:false}>
                background-color: tranparent;
                background-image: url(<{$navbar_img|default:''}>);
                background-size: cover;
            <{elseif $navbar_bg_top==$navbar_bg_bottom}>
                background: <{$navbar_bg_top|default:''}>;
            <{else}>
                background: linear-gradient(<{$navbar_bg_top|default:''}>, <{$navbar_bg_bottom|default:''}>);
            <{/if}>
        <{else}>
            background-color: tranparent;
        <{/if}>
    }

    #content-container{
        <{if $content_display_type=='not_full'}>
            background-color: tranparent;
        <{else}>
            background-color: <{$base_color|default:''}>;
        <{/if}>
    }

    #content-container-display{
        <{if $content_display_type=='not_full'}>
            background-color: <{$base_color|default:''}>;
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
            background-color: <{$footer_bgcolor|default:''}>;
            margin-bottom:<{$margin_bottom|default:''}>px;
            min-height:<{$footer_height|default:''}>;
            background:<{$footer_bgcolor|default:''}> <{if $footer_img|default:false}>url(<{$footer_img|default:''}>)<{/if}>;
            <{$foot_bg_css|default:''}>
        <{/if}>
    }

    #footer-container-display{
        padding:<{$footer_padding|default:''}>;
        color:<{$footer_color|default:''}>;
        <{$footer_style|default:''}>
        <{if $footer_display_type=='not_full'}>
            background-color: <{$footer_bgcolor|default:''}>;
            margin-bottom:<{$margin_bottom|default:''}>px;
            min-height:<{$footer_height|default:''}>;
            background:<{$footer_bgcolor|default:''}> <{if $footer_img|default:false}>url(<{$footer_img|default:''}>)<{/if}>;
            <{$foot_bg_css|default:''}>
        <{else}>
            background-color:tranparent;
        <{/if}>
    }

    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/theme_css_blocks.tpl"}>

    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/theme_css_navbar.tpl"}>

</style>
<!--導覽工具列、區塊標題CSS設定 by hc-->