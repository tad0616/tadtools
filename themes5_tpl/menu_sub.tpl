<{if $submenu}>
    <ul class="dropdown-menu">
        <{foreach from=$submenu item=sub}>
            <li class="<{if $sub.submenu}>dropdown<{/if}>">
                <a class="dropdown-item <{if $sub.submenu}>dropdown-toggle<{/if}>"  data-bs-toggle="dropdown" data-bs-auto-close="outside" <{if $sub.url!=''}>href="<{if $sub.target=="popup"}>javascript:tad_themes_popup('<{$sub.url}>');<{else}><{$sub.url}><{/if}>" <{if $sub.target!="popup"}>target="<{$sub.target}>"<{/if}><{/if}> title="<{$sub.title}>"><{if $sub.img}><img src="<{$sub.img}>" alt="<{$sub.title}> icon"><{else if $sub.icon}><i class="fa <{$sub.icon}>"></i><{/if}> <{$sub.title}></a>
                <{if $sub.submenu}>
                    <{assign var=submenu value=$sub.submenu}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/menu_sub.tpl"}>
                <{/if}>
            </li>
        <{/foreach}>
    </ul>
<{/if}>