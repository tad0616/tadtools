<{if $auto_mainmenu}>
    <li>
        <a href="#">
            <{if $auto_mainmenu_icon}><span class="fa <{$auto_mainmenu_icon}>"></span><{/if}>
            <{$smarty.const.THEME_MODULE0}>
        </a>
        <ul>
            <{foreach from=$main_menu_var item=menu}>
                <li><a href="<{$menu.url}>" target="<{$menu.target}>"><span class="fa <{$menu.icon}>"></span> <{$menu.title}></a></li>
            <{/foreach}>
        </ul>
    </li>
<{/if}>