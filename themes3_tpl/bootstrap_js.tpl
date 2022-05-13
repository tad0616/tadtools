<!--Bootstrap js-->
<script src="<{xoAppUrl modules/tadtools/bootstrap3/js/bootstrap.js}>"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/jquery.smartmenus.js}>"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="<{xoAppUrl modules/tadtools/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js}>"></script>
<{*
<script type="text/javascript">
// SmartMenus init
$(function() {
    $('#main-menu').smartmenus({
        <{if $noMouseOver}>
            noMouseOver: true,
        <{/if}>
        <{if $navbar_pos=='fixed-bottom'}>
        bottomToTopSubMenus: true
        <{else}>
        bottomToTopSubMenus: false
        <{/if}>
    });
});
</script> *}>