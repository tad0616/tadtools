<{if $submenu|default:false}>
    <ul class="dropdown-menu">
        <{foreach from=$submenu item=sub}>
            <li<{if $sub.submenu}> class="dropdown"<{/if}>>
                <a class="dropdown-item <{if $sub.submenu}>dropdown-toggle<{/if}>" <{if $sub.url!=''}>href="<{if $sub.target=="popup"}>javascript:tad_themes_popup('<{$sub.url}>');<{else}><{$sub.url}><{/if}>" <{if $sub.target!="popup"}>target="<{$sub.target}>"<{/if}><{/if}> title="<{$sub.title}>"><{if $sub.img|default:false}><img src="<{$sub.img}>" alt="<{$sub.title}> icon"><{elseif $sub.icon}><i class="fa <{$sub.icon}>"></i><{/if}> <{$sub.title}></a>
                <{if $sub.submenu|default:false}>
                    <{assign var="submenu" value=$sub.submenu}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_sub.tpl"}>
                <{/if}>
            </li>
        <{/foreach}>
    </ul>
<{/if}>