<ul class="dropdown-menu">
    <{if $xoops_isadmin}>
        <{foreach from=$admin_menu_var item=admin_menu}>
            <li>
                <a href="<{$admin_menu.url}>" target="<{$admin_menu.target}>">
                    <span class="fa <{$admin_menu.icon}>"></span>
                    <{$admin_menu.title}>
                </a>
            </li>
        <{/foreach}>
        <li><hr></li>
    <{/if}>

    <{foreach from=$user_menu_var item=user_menu}>
        <li>
            <a href="<{$user_menu.url}>" target="<{$user_menu.target}>">
                <span class="fa <{$user_menu.icon}>"></span>
                <{$user_menu.title}>
            </a>
        </li>
    <{/foreach}>
</ul>