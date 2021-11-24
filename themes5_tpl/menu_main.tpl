<{if $auto_mainmenu}>
    <li>
        <a href="#">
            <{$smarty.const.THEME_MODULE0}>
        </a>
        <ul>
            <{foreach from=$main_menu_var item=menu}>
                <li><a href="<{$menu.url}>"><span class="fa <{$menu.icon}>" target="<{$menu.target}>"></span> <{$menu.title}></a></li>
            <{/foreach}>
        </ul>
    </li>
<{/if}>