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
            unurl(XOOPS_VAR_PATH."/data/install_chk.php");
        }
    <{/php}>
<{/if}>


<{if $navbar_pos!="not-use"}>
    <link href="<{$xoops_url}>/modules/tadtools/smartmenus/css/sm-core-css.css" rel="stylesheet">
    <!-- <link href="<{$xoops_url}>/modules/tadtools/smartmenus/css/sm-clean/sm-clean.css" rel="stylesheet"> -->

    <link href="<{$xoops_url}>/modules/tadtools/smartmenus/css/sm-responsive.css" rel="stylesheet">
    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/jquery.smartmenus.min.js}>"></script>
    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/sm-responsive.js}>"></script>


    <link href="<{$xoops_url}>/modules/tadtools/colorbox/colorbox.css" rel="stylesheet">
    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/colorbox/jquery.colorbox.js}>"></script>



    <script>
        function tad_themes_popup(URL) {
            $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
        }

        // SmartMenus init
        $(function() {
            $('#main-menu').smartmenus({
                mainMenuSubOffsetX: -1,
                subMenusSubOffsetX: 10,
                subMenusSubOffsetY: 0
            });

            if($(window).width() >= 768){
                $('#main-menu').css('width',$('.main-nav').width()-$('.nav-brand').width());
            }
        });

        $(window).resize(function() {
            if($(window).width() >= 768){
                var new_width=$('.main-nav').width()-$('.nav-brand').width();
                $('#main-menu').css('width',new_width);
            }
        });
    </script>

    <nav class="main-nav" role="navigation">
        <!-- Mobile menu toggle button (hamburger/x icon) -->
        <input id="main-menu-state" type="checkbox">
        <label class="main-menu-btn" for="main-menu-state">
            <span class="main-menu-btn-icon"></span> Toggle main menu visibility
        </label>

        <div class="nav-brand">
            <{if $navbar_logo_img}>
                <a href="<{$xoops_url}>/index.php"><img src="<{$navbar_logo_img}>" alt="<{$xoops_sitename}>"></a>
            <{elseif $show_sitename==0}>
                <a href="<{$xoops_url}>/index.php"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a>
            <{else}>
                <a href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$xoops_sitename}></a>
            <{/if}>
        </div>

        <!-- Sample menu definition -->
        <ul id="main-menu" class="sm sm-clean" style="background: transparent;">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_main.tpl"}>
            <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                <{includeq file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
            <{/if}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_my.tpl"}>
            <li>
                <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 10px;">:::</a>
            </li>
            <{if $xoops_isuser}>

                <li class="right-btn">
                    <a title="<{$smarty.const.TF_USER_WELCOME}>" href="index.php">
                        <{$smarty.const.TF_USER_WELCOME}><{$xoops_name}>
                    </a>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_user.tpl"}>
                </li>
                <{if $xoops_isadmin}>
                    <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                        <li class="right-btn">
                            <a href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                        </li>
                    <{else}>
                        <li class="right-btn">
                            <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                        </li>
                    <{/if}>
                    <li class="right-btn">
                        <a href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i></a>
                    </li>

                <{/if}>
            <{elseif $openid_login!="3"}>
                <li class="right-btn">
                    <a href="index.php">
                        <{$smarty.const.TF_USER_ENTER}>
                    </a>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_login.tpl"}>
                </li>
            <{/if}>
        </ul>
    </nav>
<{/if}>