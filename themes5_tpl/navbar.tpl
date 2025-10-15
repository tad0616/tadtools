<script type="title/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/jquery.smartmenus.min.js"></script>

<script>
    function tad_themes_popup(URL) {
        $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
    }
</script>

<!-- <{$navbar_pos|default:''}> -->
<nav role="navigation" id="main-nav">

    <!-- Mobile menu toggle button (hamburger/x icon) -->
    <input id="main-menu-state" type="checkbox" />
    <label class="main-menu-btn" for="main-menu-state">
    <span class="main-menu-btn-icon"></span> Toggle main menu visibility
    </label>


    <{if $show_sitename !='2' }>
        <{if $navlogo_img|default:false}>
            <h2 class="nav-brand">
                <a href="<{$xoops_url}>/index.php"><img src="<{$navlogo_img|default:''}>" alt="<{$xoops_sitename|default:''}>" class="img-fluid"></a>
            </h2>
        <{elseif $show_sitename=='1'}>
            <h2 class="nav-brand">
                <a class="navbar-brand" href="<{$xoops_url}>/index.php" style="color:<{$navbar_color|default:''}>"><{$xoops_sitename|default:''}></a>
            </h2>
        <{/if}>
    <{/if}>


    <ul id="main-menu" class="sm sm-mint d-md-flex flex-md-wrap">
        <{if $show_sitename==0 or $show_sitename==''}>
            <li>
                <a href="<{$xoops_url}>/index.php"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_HOME}></a>
            </li>
        <{/if}>
        <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_main.tpl"}>
        <{if "$xoops_rootpath/uploads/docs_top_menu_b4.tpl"|file_exists}>
            <{include file="$xoops_rootpath/uploads/docs_top_menu_b4.tpl"}>
        <{/if}>
        <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_my.tpl"}>
        <li class="flex-grow-1 hide-in-phone">
            <a accesskey="U" href="#xoops_theme_nav_key" title="<{$smarty.const._TAD_ZAV_ZONE}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.625rem;" class="disabled">:::</a>
        </li>

        <{if $xoops_isadmin|default:false}>
            <li>
                <a href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle"></i><span class="sr-only visually-hidden"><{$smarty.const._TAD_MENU_CONFIG}></span></a>
            </li>
            <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                <li>
                    <a href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                </li>
            <{else}>
                <li>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench"></span></a>
                </li>
            <{/if}>
        <{/if}>

        <{if $xoops_isuser|default:false}>
            <li>
                <a title="<{$smarty.const.TF_USER_WELCOME}>">
                    <{$smarty.const.TF_USER_WELCOME}><{$xoops_name|default:''}>
                </a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_user.tpl"}>
            </li>
        <{elseif $openid_login!="3"}>
            <li>
                <a href="#">
                <{if $login_text|default:false}><{$login_text|default:''}><{else}>
                <{$smarty.const.TF_USER_ENTER}><{/if}>
                </a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_login.tpl"}>
            </li>
        <{/if}>
    </ul>
</nav>

<{if $use_pin=="1"}>
    <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jquery.sticky/jquery.sticky.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#nav-wrapper").sticky({topSpacing:0 , zIndex: 100});
    });
    </script>
<{/if}>

<script type="text/javascript">
    document.addEventListener('click',function(e){
        // Hamburger menu
        if(e.target.classList.contains('hamburger-toggle')){
            e.target.children[0].classList.toggle('active');
        }
    });

    $(document).ready(function(){
        if($( window ).width() > 768){
            $('li.hide-in-phone').show();
        }else{
            $('li.hide-in-phone').hide();
        }
    });

    $( window ).resize(function() {
        if($( window ).width() > 768){
            $('li.hide-in-phone').show();
        }else{
            $('li.hide-in-phone').hide();
        }
    });
</script>