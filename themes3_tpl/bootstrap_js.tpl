<!--Bootstrap js-->
<script src="<{$xoops_url}>/modules/tadtools/bootstrap3/js/bootstrap.js"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/jquery.smartmenus.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js"></script>

<script type="text/javascript">
// SmartMenus init
$(function() {
    $('#main-menu').smartmenus({
        showOnClick: true, // 改為點擊才開啟
        hideOnClick: false, // 點擊外部時不要立即關閉
        hideTimeout: 0,      // 滑鼠移開不延遲關閉
        noMouseOver: true,
        <{if $navbar_pos=='fixed-bottom'}>
        bottomToTopSubMenus: true
        <{else}>
        bottomToTopSubMenus: false
        <{/if}>
    });
});
</script>