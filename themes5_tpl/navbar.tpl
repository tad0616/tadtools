<script type="title/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/jquery.smartmenus.min.js"></script>

<script>
    function tad_themes_popup(URL) {
        $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
    }
</script>

<!-- <{$navbar_pos|default:''}> -->
<nav role="navigation" id="main-nav" tabindex="-1" aria-label="<{$smarty.const._TAD_O_NAV_ZONE|default:'主要導覽區'}>">
    <a accesskey="U" href="#main-nav" title="<{$smarty.const._TAD_ZAV_ZONE|default:'移至主要導覽區'}>" id="xoops_theme_nav_key" style="color: transparent; font-size: 0.1rem; position: absolute; top: 0; left: 0; width: 1px; height: 1px; overflow: hidden; display: block;">:::</a>


    <input id="main-menu-state" type="checkbox" style="display: none;" aria-hidden="true" />
    <label class="main-menu-btn" for="main-menu-state" tabindex="0" role="button" onkeypress="if(event.keyCode==13 || event.keyCode==32) {document.getElementById('main-menu-state').click(); return false;}">
        <span class="main-menu-btn-icon"></span>
        <span class="visually-hidden">切換選單顯示狀態</span>
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


    <ul id="main-menu" class="sm sm-mint d-md-flex flex-md-wrap" role="menubar">
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

        <!-- 讓選項靠右的填充項目 -->
        <li class="flex-grow-1 d-none d-md-block" aria-hidden="true"></li>



        <{if $xoops_isadmin|default:false}>
            <li>
                <a href="<{$xoops_url}>/modules/tad_themes/admin/dropdown.php" title="<{$smarty.const._TAD_MENU_CONFIG}>"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="sr-only visually-hidden"><{$smarty.const._TAD_MENU_CONFIG}></span></a>
            </li>
            <{if $xoops_dirname=="" || $xoops_dirname=="system"}>
                <li>
                    <a href="<{$xoops_url}>/admin.php" title="<{$smarty.const.TF_MODULE_CONFIG}>"><span class="fa fa-wrench" aria-hidden="true"></span><span class="visually-hidden"><{$smarty.const.TF_MODULE_CONFIG}></span></a>
                </li>
            <{else}>
                <li>
                    <a href="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/index.php" title="<{$smarty.const.TF_MODULE_CONFIG}>" role="menuitem"><span class="fa fa-wrench" aria-hidden="true"></span><span class="visually-hidden"><{$smarty.const.TF_MODULE_CONFIG}></span></a>
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
        <{else}>
            <li>
                <a href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" title="重取設定">
                    <i class="fa fa-refresh" aria-hidden="true"></i><span class="sr-only visually-hidden">重新取得佈景設定</span>
                </a>
            </li>
        <{/if}>
    </ul>
</nav>

<!-- $use_pin = <{$use_pin}> , $pin_zone = <{$pin_zone}> , $navbar_pos = <{$navbar_pos}> -->
<{if $use_pin|default:false || $navbar_pos|default:'' == "fixed-top"}>
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

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const mainMenuState = document.getElementById('main-menu-state');
            if (mainMenuState && mainMenuState.checked) {
                mainMenuState.checked = false;
                const menuBtn = document.querySelector('.main-menu-btn');
                if (menuBtn) menuBtn.focus();
            }
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

    // 鍵盤導覽邏輯
    $(function() {
        const $menu = $('#main-menu');

        // 為所有連結加上 role="menuitem"
        $menu.find('a').attr('role', 'menuitem');

        $menu.on('keydown', 'a', function(e) {
            const $this = $(this);
            const $li = $this.parent();
            const isVertical = $(window).width() <= 768;
            const $allVisibleLinks = $menu.find('a:visible');
            const currentIndex = $allVisibleLinks.index($this);

            let $nextFocus = null;

            switch(e.key) {
                case 'ArrowRight':
                    if (isVertical) {
                        // 垂直模式：右鍵展開子選單
                        if ($this.hasClass('has-submenu')) {
                            $menu.smartmenus('itemActivate', $this);
                            $nextFocus = $this.next('ul').find('a').first();
                        }
                    } else {
                        // 水平模式：右鍵下一個
                        $nextFocus = $allVisibleLinks.eq(currentIndex + 1);
                    }
                    break;
                case 'ArrowLeft':
                    if (isVertical) {
                        // 垂直模式：左鍵收合
                        if ($this.closest('ul').not('#main-menu')) {
                            $nextFocus = $this.closest('ul').prev('a');
                            $menu.smartmenus('menuHide', $this.closest('ul'));
                        }
                    } else {
                        // 水平模式：左鍵上一個
                        $nextFocus = $allVisibleLinks.eq(currentIndex - 1);
                    }
                    break;
                case 'ArrowDown':
                    if (isVertical) {
                        $nextFocus = $allVisibleLinks.eq(currentIndex + 1);
                    } else {
                        // 水平模式：下鍵展開或下一個
                        if ($this.hasClass('has-submenu')) {
                            $menu.smartmenus('itemActivate', $this);
                            $nextFocus = $this.next('ul').find('a').first();
                        } else {
                            $nextFocus = $allVisibleLinks.eq(currentIndex + 1);
                        }
                    }
                    break;
                case 'ArrowUp':
                    $nextFocus = $allVisibleLinks.eq(currentIndex - 1);
                    break;
                case 'Home':
                    $nextFocus = $allVisibleLinks.first();
                    break;
                case 'End':
                    $nextFocus = $allVisibleLinks.last();
                    break;
                case 'Escape':
                    $menu.smartmenus('menuHideAll');
                    break;
                default:
                    return; // 讓其他鍵正常運作
            }

            if ($nextFocus && $nextFocus.length) {
                e.preventDefault();
                $nextFocus.focus();
            }
        });
    });

</script>