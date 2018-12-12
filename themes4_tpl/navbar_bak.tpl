<{if $xoops_isadmin}>
    <{php}>
        if(file_exists(XOOPS_VAR_PATH."/data/install_chk.php")){
            global $xoopsConfig;
            include_once XOOPS_ROOT_PATH."/modules/tadtools/language/{$xoopsConfig['language']}/main.php";
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

    <nav class="navbar navbar-expand-md navbar-default rounded <{$navbar_pos}>" role="navigation" style="background-color:<{$navbar_bg_top}>;<{if $navbar_img}>background-image: url(<{$navbar_img}>);<{/if}>">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" style="width:100%;">
            <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 10px;">:::</a>
            <ul class="navbar-nav mr-auto">
                <{if $show_sitename==0}>
                    <li class="nav-item">
                        <a href="<{$xoops_url}>/index.php" class="nav-link" style="color:<{$navbar_color}>"><{$smarty.const._TAD_HOME}></a>
                    </li>
                <{/if}>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_main.tpl"}>
                <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                    <{includeq file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
                <{/if}>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_my.tpl"}>
            </ul>


            <ul class="navbar-nav ml-auto">
                <{if $xoops_isuser}>
                    <{if $xoops_isadmin}>
                        <li class="nav-item">
                            <a rel="tooltip" class="nav-link" href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i></a>
                        </li>

                        <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                            <li class="nav-item">
                                <a rel="tooltip" class="nav-link" href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                            </li>
                        <{else}>
                            <li class="nav-item">
                                <a rel="tooltip" class="nav-link" href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                            </li>
                        <{/if}>
                    <{/if}>

                    <li class="nav-item" id="preview-menu">
                        <a class="dropdown-toggle nav-link" rel="tooltip" title="<{$smarty.const.TF_USER_WELCOME}>" data-toggle="dropdown" href="#">
                            <{$smarty.const.TF_USER_WELCOME}><{$xoops_name}> <span class="caret"></span>
                        </a>
                        <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_user.tpl"}>
                    </li>
                <{elseif $openid_login!="3"}>
                    <li class="nav-item" id="preview-menu">
                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">
                            <{$smarty.const.TF_USER_ENTER}> <span class="caret"></span>
                        </a>
                        <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_login.tpl"}>
                    </li>
                <{/if}>
            </ul>
        </div>
    </nav>


    <{if $use_pin=="1"}>
        <script type="text/javascript" src="<{xoAppUrl modules/tadtools/jquery.pin/jquery.pin.js}>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#navbar-wrapper").pin({
                minWidth: 940
                });
            });
        </script>
    <{/if}>
<{/if}>