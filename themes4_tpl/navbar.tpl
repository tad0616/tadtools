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
            unurl(XOOPS_VAR_PATH."/data/install_chk.php");
        }
    <{/php}>
<{/if}>



<{if $navbar_pos!="not-use"}>
    <!-- SmartMenus jQuery Bootstrap 4 Addon CSS -->
    <link href="<{xoAppUrl modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css}>" rel="stylesheet">

    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/jquery.smartmenus.min.js}>"></script>
    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.min.js}>"></script>

    <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/colorbox/colorbox.css}>">
    <script type="text/javascript" src="<{xoAppUrl modules/tadtools/colorbox/jquery.colorbox.js}>"></script>

    <script>
        function tad_themes_popup(URL) {
            $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
        }
    </script>

    <!-- Navbar -->
    <nav id="main-nav" class="navbar navbar-expand-lg navbar-custom <{$navbar_pos}>">
        <{if $navbar_logo_img}>
            <a class="navbar-brand" href="<{$xoops_url}>/index.php"><img src="<{$navbar_logo_img}>" alt="<{$xoops_sitename}>"></a>
        <{elseif $show_sitename==0}>
            <a class="navbar-brand" href="<{$xoops_url}>/index.php"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a>
        <{else}>
            <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$xoops_sitename}></a>
        <{/if}>

        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 10px;">:::</a>

            <!-- Left nav -->
            <ul id="main-menu" class="nav navbar-nav mr-auto">
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_main.tpl"}>
                <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                    <{includeq file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
                <{/if}>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_my.tpl"}>
            </ul>

            <!-- Right nav -->
            <ul class="nav navbar-nav">
                <{if $xoops_isadmin}>
                    <li class="nav-item">
                        <a class="nav-link" href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i></a>
                    </li>
                    <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                        <li class="nav-item">
                            <a class="nav-link" href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                        </li>
                    <{else}>
                        <li class="nav-item">
                            <a class="nav-link" href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                        </li>
                    <{/if}>
                <{/if}>

                <{if $xoops_isuser}>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" title="<{$smarty.const.TF_USER_WELCOME}>" href="index.php">
                            <{$smarty.const.TF_USER_WELCOME}><{$xoops_name}>
                        </a>
                        <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_user.tpl"}>
                    </li>
                <{elseif $openid_login!="3"}>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="index.php">
                            <{$smarty.const.TF_USER_ENTER}>
                        </a>
                        <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_login.tpl"}>
                    </li>
                <{/if}>
            </ul>
        </div>
    </nav>
<{/if}>
