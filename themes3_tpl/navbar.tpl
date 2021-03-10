<{if $xoops_isadmin}>
    <{php}>
        if(file_exists(XOOPS_VAR_PATH."/data/install_chk.php")){
            global $xoopsConfig;
            require_once XOOPS_ROOT_PATH."/modules/tadtools/language/{$xoopsConfig['language']}/main.php";
            echo "
            <div class='alert alert-danger'>
            "._TAD_DEL_INSTALL_CHK."
            </div>
            ";
            unlink(XOOPS_VAR_PATH."/data/install_chk.php");
        }
    <{/php}>
<{/if}>


<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/colorbox/colorbox.css}>">
<script type="text/javascript" src="<{xoAppUrl modules/tadtools/colorbox/jquery.colorbox.js}>"></script>
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

<{$tad_themes_popup_code}>

<{if $navbar_pos!="not-use"}>

    <nav id="main-nav" class="navbar navbar-default <{if $navbar_pos=="fixed-top"}>navbar-fixed-top<{elseif $navbar_pos=="fixed-bottom"}>navbar-fixed-bottom<{else}>sticky-top<{/if}>" role="navigation" style="background-color:<{$navbar_bg_top}>;<{if $navbar_img}>background-image: url(<{$navbar_img}>);<{/if}>">
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
                <{if $navlogo_img}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="padding: 4px 20px 4px;"><img src="<{$navlogo_img}>" alt="<{$xoops_sitename}>" class="img-responsive"></a>
                <{elseif $show_sitename=='1'}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$xoops_sitename}></a>
                <{/if}>
            <{/if}>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.625em;">:::</a>
            <ul class="nav navbar-nav" id="main-menu-left">
            <{if $show_sitename==0 or $show_sitename==''}>
                <li><a href="<{$xoops_url}>/index.php"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a></li>
            <{/if}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_main.tpl"}>
            <{if "$xoops_rootpath/uploads/docs_top_menu_b3.tpl"|file_exists}>
                <{includeq file="$xoops_rootpath/uploads/docs_top_menu_b3.tpl"}>
            <{/if}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_my.tpl"}>
            </ul>

            <ul class="nav navbar-nav navbar-right" id="main-menu-right">
            <{if $xoops_isuser}>
            <{if $xoops_isadmin}>

            <li><a rel="tooltip" href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i></a></li>

                <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                <li><a rel="tooltip" href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a></li>
                <{else}>
                <li><a rel="tooltip" href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a></li>
                <{/if}>
            <{/if}>

            <li id="preview-menu">
                <a rel="tooltip" title="<{$smarty.const.TF_USER_WELCOME}>" class="dropdown-toggle" data-toggle="dropdown">
                <{$smarty.const.TF_USER_WELCOME}><{$xoops_name}> <span class="caret"></span>
                </a>

                <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_user.tpl"}>

            </li>
            <{elseif $openid_login!="3"}>
            <li id="preview-menu">
                <a class="dropdown-toggle" data-toggle="dropdown">
                <{$smarty.const.TF_USER_ENTER}> <span class="caret"></span>
                </a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
            </li>
            <{/if}>
            </ul>
        </div>
        </div>
    </nav>


    <{if $use_pin=="1"}>
        <script type="text/javascript" src="<{xoAppUrl modules/tadtools/jquery.sticky/jquery.sticky.js}>"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("nav#main-nav").sticky({topSpacing:0 , zIndex: 100});
        });
        </script>
    <{/if}>
<{/if}>