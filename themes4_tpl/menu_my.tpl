<{foreach from=$menu_var item=m1}>
    <li class="nav-item <{if $m1.submenu|default:false}>dropdown<{/if}>">
        <a class="nav-link <{if $m1.submenu|default:false}>dropdown-toggle<{/if}>" <{if $m1.url!=''}>href="<{if $m1.target=="popup"}>javascript:tad_themes_popup('<{$m1.url}>');<{else}><{$m1.url}><{/if}>" <{if $m1.target!="popup"}>target="<{$m1.target}>"<{/if}><{/if}>><{if $m1.img|default:false}><img src="<{$m1.img}>" alt="<{$m1.title}> icon"><{elseif $m1.icon}><i class="<{if $m1.icon|substr:0:3=='fa-'}>fa <{/if}><{$m1.icon}>"></i><{/if}> <{$m1.title}></a>
        <{if $m1.submenu|default:false}>
            <{assign var="submenu" value=$m1.submenu}>
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_sub.tpl"}>
        <{/if}>
    </li>
<{/foreach}>