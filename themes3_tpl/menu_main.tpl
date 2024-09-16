<{if $auto_mainmenu|default:false}>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="index.php">
            <{if $auto_mainmenu_icon|default:false}><span class="fa <{$auto_mainmenu_icon}>"></span><{/if}>
            <{$smarty.const.THEME_MODULE0}>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <{foreach from=$main_menu_var item=menu}>
                <li><a href="<{$menu.url}>" target="<{$menu.target}>"><span class="fa <{$menu.icon}>"></span> <{$menu.title}></a></li>
            <{/foreach}>
        </ul>
    </li>
<{/if}>