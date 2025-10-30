
        <!--Bootstrap js-->
        <script src="<{$xoops_url}>/modules/tadtools/bootstrap5/js/bootstrap.bundle.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/jquery.smartmenus.js"></script>


        <script type="text/javascript">
            // SmartMenus init
            $(function() {
                $('#main-menu').smartmenus({
                    hideTimeout: 0,      // 滑鼠移開不延遲關閉
                    <{if $no_mouse_over|default:false}>
                        noMouseOver: true,
                        showOnClick: true, // 點擊才開啟
                    <{else}>
                        showOnClick: false,
                        noMouseOver: false,// 滑鼠移過開啟
                    <{/if}>
                    hideOnClick: true, // 點擊外部時關閉
                    <{if $navbar_pos=='fixed-bottom'}>
                    bottomToTopSubMenus: true
                    <{else}>
                    bottomToTopSubMenus: false
                    <{/if}>
                });

            // SmartMenus mob
                var $mainMenuState = $('#main-menu-state');
                if ($mainMenuState.length) {
                    // animate mobile menu
                    $mainMenuState.change(function(e) {
                        var $menu = $('#main-menu');
                        if (this.checked) {
                            $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
                        } else {
                            $menu.show().slideUp(250, function() { $menu.css('display', ''); });
                        }
                    });
                    // hide mobile menu beforeunload
                    $(window).bind('beforeunload unload', function() {
                        if ($mainMenuState[0].checked) {
                            $mainMenuState[0].click();
                        }
                    });
                }
            });
        </script>