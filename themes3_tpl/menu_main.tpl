<{if $auto_mainmenu|default:false}>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="index.php">
            <{if $auto_mainmenu_icon|default:false}><span class="<{if $auto_mainmenu_icon|substr:0:3=='fa-'}>fa <{/if}><{$auto_mainmenu_icon|default:''}>"></span><{/if}>
            <{$smarty.const.THEME_MODULE0}>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <{foreach from=$main_menu_var item=menu}>
                <li><a href="<{$menu.url}>" target="<{$menu.target}>"><span class="<{if $menu.icon|substr:0:3=='fa-'}>fa <{/if}><{$menu.icon}>"></span> <{$menu.title}></a></li>
            <{/foreach}>
        </ul>
    </li>
<{/if}>