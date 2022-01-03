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

    <script type="title/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/jquery.smartmenus.min.js}>"></script>

    <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/colorbox/colorbox.css}>">
    <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl modules/tadtools/css/xoops.css}>">
    <script type="text/javascript" src="<{xoAppUrl modules/tadtools/colorbox/jquery.colorbox.js}>"></script>

    <script>
        function tad_themes_popup(URL) {
            $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
        }
    </script>

    <!-- $navbar_pos -->
    <nav role="navigation" id="main-nav">

        <!-- Mobile menu toggle button (hamburger/x icon) -->
        <input id="main-menu-state" type="checkbox" />
        <label class="main-menu-btn" for="main-menu-state">
        <span class="main-menu-btn-icon"></span> Toggle main menu visibility
        </label>


        <{if $show_sitename !='2' }>
            <{if $navlogo_img}>
                <h2 class="nav-brand">
                    <a class="img-fluid" href="<{$xoops_url}>/index.php"><img src="<{$navlogo_img}>" alt="<{$xoops_sitename}>"></a>
                </h2>
            <{elseif $show_sitename=='1'}>
                <h2 class="nav-brand">
                    <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color}>"><{$xoops_sitename}></a>
                </h2>
            <{/if}>
        <{/if}>


        <ul id="main-menu" class="sm sm-mint d-md-flex">
            <{if $show_sitename==0 or $show_sitename==''}>
                <li>
                    <a href="<{$xoops_url}>/index.php">&#xf015; <{$smarty.const._TAD_HOME}></a>
                </li>
            <{/if}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_main.tpl"}>
            <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                <{includeq file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
            <{/if}>

            <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_my.tpl"}>
            <li class="flex-grow-1 hide-in-phone">
                <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.625rem;" class="disabled">:::</a>
            </li>

            <{if $xoops_isadmin}>
                <li>
                    <a href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i></a>
                </li>
                <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                    <li>
                        <a href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                    </li>
                <{else}>
                    <li>
                        <a href="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                    </li>
                <{/if}>
            <{/if}>

            <{if $xoops_isuser}>
                <li>
                    <a title="<{$smarty.const.TF_USER_WELCOME}>">
                        <{$smarty.const.TF_USER_WELCOME}><{$xoops_name}>
                    </a>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_user.tpl"}>
                </li>
            <{elseif $openid_login!="3"}>
                <li>
                    <a href="#">
                        <{$smarty.const.TF_USER_ENTER}>
                    </a>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_login.tpl"}>
                </li>
            <{/if}>
        </ul>
    </nav>

    <script type="text/javascript">
        document.addEventListener('click',function(e){
            // Hamburger menu
            if(e.target.classList.contains('hamburger-toggle')){
                e.target.children[0].classList.toggle('active');
            }
        });
    </script>

    <{if $use_pin=="1" or $navbar_pos=='fixed-top'}>
        <script type="text/javascript" src="<{xoAppUrl modules/tadtools/jquery.sticky/jquery.sticky.js}>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                if($( window ).width() > 768){
                    $("#nav-wrapper").sticky({topSpacing:0 , zIndex: 100});
                }else{
                    $('li.hide-in-phone').hide();
                }
            });

            $( window ).resize(function() {
                if($( window ).width() > 768){
                    $("#nav-wrapper").sticky({topSpacing:0 , zIndex: 100});
                    $('li.hide-in-phone').show();
                }else{
                    $("#nav-wrapper").unstick();
                    $('li.hide-in-phone').hide();
                }
            });
        </script>
    <{/if}>
<{/if}>
