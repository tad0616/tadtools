
        <!--Bootstrap js-->
        <script src="<{xoAppUrl modules/tadtools/bootstrap5/js/popper.min.js}>" crossorigin="anonymous"></script>
        <script src="<{xoAppUrl modules/tadtools/bootstrap5/js/bootstrap.js}>"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/jquery.smartmenus.js}>"></script>


        <script type="text/javascript">
            // SmartMenus init
            $(function() {
                $('#main-menu').smartmenus({
                    <{if $navbar_pos=='fixed-bottom'}>
                    bottomToTopSubMenus: true,
                    <{/if}>
                    subMenusSubOffsetX: 6,
                    subMenusSubOffsetY: -8
                });
            });

            // SmartMenus mobile menu toggle button
            $(function() {
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