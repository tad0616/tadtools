<{if $submenu}>
    <ul>
        <{foreach from=$submenu item=sub}>
            <li>
                <a <{if $sub.url!=''}>href="<{if $sub.target=="popup"}>javascript:tad_themes_popup('<{$sub.url}>');<{else}><{$sub.url}><{/if}>" <{if $sub.target!="popup"}>target="<{$sub.target}>"<{/if}><{/if}> title="<{$sub.title}>"><{if $sub.img}><img src="<{$sub.img}>" alt="<{$sub.title}> icon"><{elseif $sub.icon}><i class="fa <{$sub.icon}>"></i><{/if}> <{$sub.title}></a>
                <{if $sub.submenu}>
                    <{assign var="submenu" value=$sub.submenu}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_sub.tpl"}>
                <{/if}>
            </li>
        <{/foreach}>
    </ul>
<{/if}>