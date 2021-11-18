<{if $auto_mainmenu}>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <{$smarty.const.THEME_MODULE0}>
        </a>
        <ul class="dropdown-menu">
            <{foreach from=$main_menu_var item=menu}>
                <li><a href="<{$menu.url}>" class="dropdown-item"><span class="fa <{$menu.icon}>" target="<{$menu.target}>"></span> <{$menu.title}></a></li>
            <{/foreach}>
        </ul>
    </li>
<{/if}>