<ul>
    <{if $xoops_isadmin|default:false}>
        <{foreach from=$admin_menu_var item=admin_menu}>
            <li>
                <a href="<{$admin_menu.url}>" target="<{$admin_menu.target}>">
                    <span class="<{if $admin_menu.icon|substr:0:3=='fa-'}>fa <{/if}><{$admin_menu.icon}>"></span>
                    <{$admin_menu.title}>
                </a>
            </li>
        <{/foreach}>
        <li><hr></li>
    <{/if}>

    <{foreach from=$user_menu_var item=user_menu}>
        <li>
            <a href="<{$user_menu.url}>" target="<{$user_menu.target}>">
                <span class="<{if $user_menu.icon|substr:0:3=='fa-'}>fa <{/if}><{$user_menu.icon}>"></span>
                <{$user_menu.title}>
            </a>
        </li>
    <{/foreach}>
</ul>