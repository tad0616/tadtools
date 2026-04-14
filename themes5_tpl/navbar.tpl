<script type="title/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/jquery.smartmenus.min.js"></script>

<script>
    function tad_themes_popup(URL) {
        $.colorbox({iframe:true, width:"80%", height:"90%",href : URL});
    }
</script>

<!-- <{$navbar_pos|default:''}> -->
<nav role="navigation" id="main-nav" tabindex="-1" aria-label="<{$smarty.const._TAD_O_NAV_ZONE|default:'導覽工具列'}>">
    <a accesskey="U" href="#main-nav" id="xoops_theme_nav_key" class="sr-only-focusable" aria-label="跳到上方導覽工具列">:::</a>


    <input id="main-menu-state" type="checkbox" style="display: none;" aria-hidden="true" />
    <label class="main-menu-btn" for="main-menu-state" tabindex="0" role="button" onkeypress="if(event.keyCode==13 || event.keyCode==32) {document.getElementById('main-menu-state').click(); return false;}">
        <span class="main-menu-btn-icon"></span>
        <span class="visually-hidden">切換導覽列選單顯示狀態</span>
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
<{if $use_pin|default:false && $pin_zone|default:false=='nav'}>
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
        const $menuBtn = $('.main-menu-btn');
        const $menuState = $('#main-menu-state');

        // 儲存選單外的最後一個可聚焦元素
        let $lastFocusBeforeMenu;

        // 焦點陷阱相關變數
        let $focusableElements;
        let $firstFocusableElement;
        let $lastFocusableElement;

        // 為所有連結加上 role="menuitem"
        $menu.find('a').attr('role', 'menuitem');

        // 當選單狀態改變時
        $menuState.on('change', function() {
            if (this.checked) {
                // 選單開啟時
                $lastFocusBeforeMenu = $(document.activeElement);

                // 延遲一下確保選單完全展開後再設置焦點陷阱
                setTimeout(setupFocusTrap, 100);

                // 將焦點移到選單的第一個項目
                setTimeout(function() {
                    $menu.find('a:visible').first().focus();
                }, 150);
            } else {
                // 選單關閉時，將焦點返回到漢堡按鈕
                $menuBtn.focus();
            }
        });

        // 設置焦點陷阱
        function setupFocusTrap() {
            if (!$menuState.prop('checked')) return;

            // 獲取選單中所有可聚焦元素
            $focusableElements = $menu.find('a:visible, button:visible');

            if ($focusableElements.length === 0) return;

            $firstFocusableElement = $focusableElements.first();
            $lastFocusableElement = $focusableElements.last();

            // 添加文檔級別的事件處理器來捕獲Tab鍵
            $(document).on('keydown.menuFocusTrap', handleTabKey);
        }

        // 處理Tab鍵，確保焦點不會離開選單
        function handleTabKey(e) {
            // 如果選單未開啟，不處理
            if (!$menuState.prop('checked')) {
                $(document).off('keydown.menuFocusTrap');
                return;
            }

            // 檢查是否按下了Tab鍵
            if (e.key === 'Tab' || e.keyCode === 9) {
                // 如果按下Shift+Tab且焦點在第一個元素上
                if (e.shiftKey && document.activeElement === $firstFocusableElement[0]) {
                    e.preventDefault();
                    $lastFocusableElement.focus();
                }
                // 如果按下Tab且焦點在最後一個元素上
                else if (!e.shiftKey && document.activeElement === $lastFocusableElement[0]) {
                    e.preventDefault();
                    $firstFocusableElement.focus();
                }
            }
        }

        // 當選單關閉時，移除焦點陷阱
        function removeFocusTrap() {
            $(document).off('keydown.menuFocusTrap');
        }

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
                    // 如果在子選單中，先關閉子選單
                    if ($this.closest('ul').not('#main-menu').length) {
                        $nextFocus = $this.closest('ul').prev('a');
                        $menu.smartmenus('menuHide', $this.closest('ul'));
                    } else {
                        // 如果在主選單中，關閉整個選單
                        $menuState.prop('checked', false).trigger('change');
                        removeFocusTrap();
                    }
                    break;
                default:
                    return; // 讓其他鍵正常運作
            }

            if ($nextFocus && $nextFocus.length) {
                e.preventDefault();
                $nextFocus.focus();
            }
        });

        // 當視窗大小改變時，重新設置焦點陷阱
        $(window).on('resize', function() {
            if ($menuState.prop('checked')) {
                setTimeout(setupFocusTrap, 100);
            }
        });
    });
</script>