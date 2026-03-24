<{if $auto_mainmenu|default:false}>
    <li role="none">
        <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tadnav-submenu.tpl" sub_title=$smarty.const.THEME_MODULE0}>
        <ul class="tadnav-submenu" role="menu" aria-label="<{$smarty.const.THEME_MODULE0}> 子選單">
            <{foreach from=$main_menu_var item=menu}>
                <li role="none"><a href="<{$menu.url}>" target="<{$menu.target}>" role="menuitem"><span class="<{if $menu.icon|substr:0:3=='fa-'}>fa <{/if}><{$menu.icon}>" aria-hidden="true"></span> <{$menu.title}></a></li>
            <{/foreach}>
        </ul>
    </li>
<{/if}>