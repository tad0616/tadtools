<script>
    function tad_themes_popup(URL) {
        $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
    }
</script>
<style>
    .navbar-default{
        border-color: transparent;
        border:none;
        border-radius:0px;
    }
</style>

<{$tad_themes_popup_code|default:''}>

<{if $navbar_pos!="not-use"}>
    <nav id="main-nav" class="navbar navbar-default <{if $navbar_pos=="fixed-top"}>navbar-fixed-top<{elseif $navbar_pos=="fixed-bottom"}>navbar-fixed-bottom<{else}>sticky-top<{/if}>" role="navigation" style="background-color:<{$navbar_bg_top|default:''}>;<{if $navbar_img|default:false}>background-image: url(<{$navbar_img|default:''}>);<{/if}>">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <{if $show_sitename !='2' }>
                <{if $navlogo_img|default:false}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="padding: 4px 20px 4px;"><img src="<{$navlogo_img|default:''}>" alt="<{$xoops_sitename|default:''}>" class="img-responsive"></a>
                <{elseif $show_sitename=='1'}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$xoops_sitename|default:''}></a>
                <{/if}>
            <{/if}>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <a accesskey="U" href="#main-nav" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
            <ul class="nav navbar-nav" id="main-menu-left">
            <{if $show_sitename==0 or $show_sitename==''}>
                <li><a href="<{$xoops_url}>/index.php"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a></li>
            <{/if}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_main.tpl"}>
            <{if "$xoops_rootpath/uploads/docs_top_menu_b3.tpl"|file_exists}>
                <{include file="$xoops_rootpath/uploads/docs_top_menu_b3.tpl"}>
            <{/if}>

        <li>
            <a href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" title="重取設定"><i class="fa fa-refresh" title="重整畫面圖示"></i><span class="sr-only visually-hidden">重新取得佈景設定</span>
            </a>
        </li>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_my.tpl"}>
            </ul>

            <ul class="nav navbar-nav navbar-right" id="main-menu-right">
            <{if $xoops_isuser|default:false}>
            <{if $xoops_isadmin|default:false}>

            <li><a rel="tooltip" href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i><span class="sr-only visually-hidden"><{$smarty.const._TAD_MENU_CONFIG}></span></a></li>

                <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                <li><a rel="tooltip" href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a></li>
                <{else}>
                <li><a rel="tooltip" href="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a></li>
                <{/if}>
            <{/if}>

            <li id="preview-menu">
                <a rel="tooltip" title="<{$smarty.const.TF_USER_WELCOME}>" class="dropdown-toggle" data-toggle="dropdown">
                <{$smarty.const.TF_USER_WELCOME}><{$xoops_name|default:''}> <span class="caret"></span>
                </a>

                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_user.tpl"}>

            </li>
            <{elseif $openid_login!="3"}>
            <li id="preview-menu">
                <a class="dropdown-toggle" data-toggle="dropdown">
                <{$smarty.const.TF_USER_ENTER}> <span class="caret"></span>
                </a>
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
            </li>
            <{/if}>
            </ul>
        </div>
        </div>
    </nav>

    <{if $use_pin|default:false}>
        <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jquery.sticky/jquery.sticky.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#nav-container").sticky({topSpacing:0 , zIndex: 100});
        });
        </script>
    <{/if}>

<{/if}>