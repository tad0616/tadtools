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

<{if $navbar_pos!="not-use"}>
<{*
    <!-- SmartMenus jQuery Bootstrap 4 Addon CSS -->
    <link href="<{xoAppUrl modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css}>" rel="stylesheet">

    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/jquery.smartmenus.min.js}>"></script>
    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.min.js}>"></script>
*}>
    <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/colorbox/colorbox.css}>">
    <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/css/xoops.css}>">
    <script type="text/javascript" src="<{xoAppUrl modules/tadtools/colorbox/jquery.colorbox.js}>"></script>

    <script>
        function tad_themes_popup(URL) {
            $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
        }
    </script>

    <!-- Navbar -->
    <nav id="main-nav" class="navbar navbar-light navbar-expand-lg navbar-custom <{$navbar_pos}>">
        <div class="container-fluid">
            <{if $show_sitename !='2' }>
                <{if $navlogo_img}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php"><img src="<{$navlogo_img}>" alt="<{$xoops_sitename}>" class="img-fluid"></a>
                <{elseif $show_sitename=='1'}>
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$xoops_sitename}></a>
                <{/if}>
            <{/if}>

            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <div class="hamburger-toggle">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.625rem;">:::</a>

                <!-- Left nav -->
                <ul id="main-menu" class="nav navbar-nav me-auto">

                    <{if $show_sitename==0 or $show_sitename==''}>
                        <li><a class="nav-link" href="<{$xoops_url}>/index.php">&#xf015; <{$smarty.const._TAD_HOME}></a></li>
                    <{/if}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_main.tpl"}>
                    <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                        <{includeq file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
                    <{/if}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_my.tpl"}>
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
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" title="<{$smarty.const.TF_USER_WELCOME}>">
                                <{$smarty.const.TF_USER_WELCOME}><{$xoops_name}>
                            </a>
                            <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_user.tpl"}>
                        </li>
                    <{elseif $openid_login!="3"}>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <{$smarty.const.TF_USER_ENTER}>
                            </a>
                            <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_login.tpl"}>
                        </li>
                    <{/if}>
                </ul>
            </div>
        </div>
    </nav>

    <script type="text/javascript">
        document.addEventListener('click',function(e){
            // Hamburger menu
            if(e.target.classList.contains('hamburger-toggle')){
                e.target.children[0].classList.toggle('active');
            }
        });
    </script>

    <{if $use_pin=="1"}>
        <script type="text/javascript" src="<{xoAppUrl modules/tadtools/jquery.sticky/jquery.sticky.js}>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#nav-container").sticky({topSpacing:0 , zIndex: 100});
            });
        </script>
    <{/if}>
<{/if}>
