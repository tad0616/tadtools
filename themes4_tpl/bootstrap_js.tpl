
        <!--Bootstrap js-->
        <script src="<{$xoops_url}>/modules/tadtools/bootstrap4/js/bootstrap.bundle.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/jquery.smartmenus.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.js"></script>

        <{*
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
            });
        </script>
        *}>