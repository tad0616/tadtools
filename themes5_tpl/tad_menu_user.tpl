<{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tadnav-submenu.tpl" sub_title="歡迎：`$xoops_name`"}>
<ul class="tadnav-submenu" role="menu" aria-label="使用者選單">
    <{if $xoops_isadmin|default:false}>
        <{foreach from=$admin_menu_var item=admin_menu}>
            <li role="none">
                <a href="<{$admin_menu.url}>" target="<{$admin_menu.target}>" role="menuitem">
                    <span class="<{if $admin_menu.icon|substr:0:3=='fa-'}>fa <{/if}><{$admin_menu.icon}>" aria-hidden="true"></span>
                    <{$admin_menu.title}>
                </a>
            </li>
        <{/foreach}>
    <{/if}>
    <li role="none">
        <a href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" title="重整畫面圖示" role="menuitem">
            <i class="fa fa-refresh" aria-hidden="true"></i> 重取設定
        </a>
    </li>
    <{foreach from=$user_menu_var item=user_menu}>
        <li role="none">
            <a href="<{$user_menu.url}>" target="<{$user_menu.target}>" role="menuitem">
                <span class="<{if $user_menu.icon|substr:0:3=='fa-'}>fa <{/if}><{$user_menu.icon}>" aria-hidden="true"></span>
                <{$user_menu.title}>
            </a>
        </li>
    <{/foreach}>
</ul>