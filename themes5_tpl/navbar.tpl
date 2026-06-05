<link rel="stylesheet" href="<{$xoops_url}>/modules/tadtools/tad_nav/tadnav.css?t=20260528">

<script>
    function tad_themes_popup(URL) {
        $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
    }
</script>
<!-- <{$navbar_pos|default:''}> -->
<nav class="tadnav-wrapper" role="navigation" id="main-nav" aria-label="<{$smarty.const._TAD_O_NAV_ZONE|default:'導覽工具列'}>">
    <{if !$hide_accesskey|default:false}>
    <a accesskey="U" href="#main-nav-skip" id="xoops_theme_nav_key" class="sr-only-focusable" aria-label="跳到<{$smarty.const._TAD_O_NAV_ZONE|default:'導覽工具列'}>">:::</a>
    <{/if}>
    <{* 便捷鍵定位點：tabindex="-1" 讓焦點可程式化移入，
        aria-label 提供簡短說明供螢幕報讀器播報，
        避免焦點落在 nav 容器而導致 AT 朗讀整個導覽列 *}>
    <span id="main-nav-skip" tabindex="-1" aria-label="<{$smarty.const._TAD_O_NAV_ZONE|default:'導覽工具列'}>" style="position:absolute;width:0;height:0;overflow:hidden;"></span>
    <div class="tadnav-inner">
        <{if $show_sitename !='2' }>
            <div class="tadnav-brand">
                <{if $navlogo_img|default:false}>
                    <a href="<{$xoops_url}>/index.php"><img src="<{$navlogo_img|default:''}>" alt="<{$xoops_sitename|default:''}>" class="img-fluid"></a>
                <{elseif $show_sitename=='1'}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$xoops_sitename|default:''}></a>
                <{/if}>
            </div>
        <{/if}>

        <!-- 漢堡按鈕（手機/放大時顯示）-->
        <button class="tadnav-toggle"
                aria-expanded="false"
                aria-controls="main-menu"
                aria-label="漢堡選單">
        <span class="bar" aria-hidden="true"></span>
        <span class="bar" aria-hidden="true"></span>
        <span class="bar" aria-hidden="true"></span>
        </button>


        <ul id="main-menu" class="tadnav-menu" role="menubar" aria-label="導覽列">
            <{if $show_sitename==0 or $show_sitename==''}>
                <li role="none">
                    <a href="<{$xoops_url}>/index.php" role="menuitem"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a>
                </li>
            <{/if}>

            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tad_menu_main.tpl"}>

            <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                <{include file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
            <{/if}>

            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tad_menu_my.tpl"}>

            <!-- 靠右填充 -->
            <li class="tadnav-spacer" role="none" aria-hidden="true"></li>

            <{if $xoops_isadmin|default:false}>
                <li role="none">
                    <a href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" role="menuitem" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="sr-only visually-hidden"><{$smarty.const._TAD_MENU_CONFIG}></span></a>
                </li>
                <{if $xoops_dirname=="" || $xoops_dirname=="system" || $xoops_dirname|substr:0:3=="kw_"}>
                    <li role="none">
                        <a href="<{$xoops_url}>/admin.php" role="menuitem" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench" aria-hidden="true"></span><span class="visually-hidden"><{$smarty.const.TF_MODULE_CONFIG}></span></a>
                    </li>
                <{else}>
                    <li role="none">
                        <a href="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/index.php" role="menuitem" title="<{$smarty.const.TF_MODULE_CONFIG}>" role="menuitem"><span class="fa fa-wrench" aria-hidden="true"></span><span class="visually-hidden"><{$smarty.const.TF_MODULE_CONFIG}></span></a>
                    </li>
                <{/if}>
            <{/if}>

            <{if $xoops_isuser|default:false}>
                <li role="none">
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tad_menu_user.tpl"}>
                </li>
            <{elseif $openid_login!="3"}>
                <li role="none">
                    <{if !$login_text|default:false}><{assign var="login_text" value=$smarty.const.TF_USER_ENTER}><{/if}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tadnav-submenu.tpl" sub_title=$login_text}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tad_menu_login.tpl"}>
                </li>
            <{else}>
                <li role="none">
                    <a href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" role="menuitem" title="重取佈景設定">
                        <i class="fa fa-refresh" aria-hidden="true"></i><span class="sr-only visually-hidden">重新取得佈景設定</span>
                    </a>
                </li>
            <{/if}>
        </ul>
    </div>
</nav>

<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/tad_nav/tadnav.js?t=20260528"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // 或指定 click 模式
        var nav = new TadNav('#main-menu', { trigger: 'hover', hoverClose: true, theme: {
        navBg:           'transparent',
        fontFamily:      '<{$font_family|default:''}>',
        navShadow:       'none',
        itemColor:       '<{$navbar_color|default:'#ffffff'}>',
        itemHoverBg:     '<{$navbar_hover|default:'rgba(255,255,255,0.15)'}>',
        itemHoverColor:  '<{$navbar_color_hover|default:'#ffffff'}>',
        itemFontSize:    '<{$navbar_font_size|default:1}>rem',
        itemPaddingX:    '<{$navbar_px|default:15}>px',
        itemPaddingY:    '<{$navbar_py|default:15}>px',
        subItemPaddingX: '<{$navbar_px|default:15}>px',
        subItemPaddingY: '<{$navbar_py|default:15}>px',
        subBg:           '<{$nav_sub_bg_color|default:'#ffffff'}>',
        subItemColor:    '<{$nav_sub_font_color|default:'#2c3e50'}>',
        subItemHoverBg:  '<{$navbar_hover|default:'rgba(255,255,255,0.15)'}>',
        subItemHoverColor:  '<{$navbar_color_hover|default:'#ffffff'}>',
        subItemFontSize: '<{$navbar_font_size|default:1}>rem',
        subDividerWidth: '<{$nav_line|default:0}>',
        subDividerWidth: '1px',
        subDivider:      '#00000011',
        subShadow:       '0 4px 16px rgba(0,0,0,0.12)',
        innerMaxWidth:   '1920px',
        subScrollMargin: 24,   // 距視窗底部保留 24px
        } });
    });
</script>

<!-- $use_pin = <{$use_pin}> , $pin_zone = <{$pin_zone}> , $navbar_pos = <{$navbar_pos}> -->
<{if $pin_zone|default:false == 'nav' }>
    <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jquery.sticky/jquery.sticky.js?t=202603051450"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#nav-wrapper").sticky({topSpacing:0 , zIndex: 100});
    });
    </script>
<{/if}>
