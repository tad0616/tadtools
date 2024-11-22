<{if $navbar_pos!="not-use"}>

    <script>
        function tad_themes_popup(URL) {
            $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
        }
    </script>

    <!-- Navbar -->
    <nav id="main-nav" class="navbar navbar-light navbar-expand-lg navbar-custom <{$navbar_pos|default:''}>">
        <{if $show_sitename !='2' }>
            <{if $navlogo_img|default:false}>
                <a class="navbar-brand" href="<{$xoops_url}>/index.php"><img src="<{$navlogo_img|default:''}>" alt="<{$xoops_sitename|default:''}>" class="img-fluid"></a>
            <{elseif $show_sitename=='1'}>
                <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$xoops_sitename|default:''}></a>
            <{/if}>
        <{/if}>

        <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>

            <!-- Left nav -->
            <ul id="main-menu" class="nav navbar-nav mr-auto">

                <{if $show_sitename==0 or $show_sitename==''}>
                    <li><a class="nav-link" href="<{$xoops_url}>/index.php"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a></li>
                <{/if}>
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_main.tpl"}>
                <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
                    <{include file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
                <{/if}>
                <li class="nav-item">
                    <a class="nav-link" href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" title="重整畫面"><i class="fa fa-refresh" aria-hidden="true"></i>
                    </a>
                </li>
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_my.tpl"}>
            </ul>

            <!-- Right nav -->
            <ul class="nav navbar-nav">
                <{if $xoops_isadmin|default:false}>
                    <li class="nav-item">
                        <a class="nav-link" href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i></a>
                    </li>
                    <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                        <li class="nav-item">
                            <a class="nav-link" href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                        </li>
                    <{else}>
                        <li class="nav-item">
                            <a class="nav-link" href="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                        </li>
                    <{/if}>
                <{/if}>

                <{if $xoops_isuser|default:false}>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" title="<{$smarty.const.TF_USER_WELCOME}>">
                            <{$smarty.const.TF_USER_WELCOME}><{$xoops_name|default:''}>
                        </a>
                        <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_user.tpl"}>
                    </li>
                <{elseif $openid_login!="3"}>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle">
                        <{if $login_text|default:false}><{$login_text|default:''}><{else}>
                        <{$smarty.const.TF_USER_ENTER}><{/if}>
                        </a>
                        <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_login.tpl"}>
                    </li>
                <{/if}>
            </ul>
        </div>
    </nav>

    <{if $use_pin=="1"}>
        <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jquery.sticky/jquery.sticky.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#nav-container").sticky({topSpacing:0 , zIndex: 100});
        });
        </script>
    <{/if}>
<{/if}>
