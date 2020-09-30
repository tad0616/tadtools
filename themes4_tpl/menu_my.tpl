<{foreach from=$menu_var item=m1}>
    <li class="nav-item <{if $m1.submenu}>dropdown<{/if}>">
        <a class="nav-link <{if $m1.submenu}>dropdown-toggle<{/if}>" <{if $m1.url!=''}>href="<{if $m1.target=="popup"}>javascript:tad_themes_popup('<{$m1.url}>');<{else}><{$m1.url}><{/if}>" <{if $m1.target!="popup"}>target="<{$m1.target}>"<{/if}><{/if}> title="<{$m1.title}>"><{if $m1.img}><img src="<{$m1.img}>" alt="<{$m1.title}> icon"><{else if $m1.icon}><i class="fa <{$m1.icon}>"></i><{/if}> <{$m1.title}></a>
        <{if $m1.submenu}>
            <{assign var=submenu value=$m1.submenu}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/menu_sub.tpl"}>
        <{/if}>
    </li>
<{/foreach}>