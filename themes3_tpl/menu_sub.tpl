<{if $submenu}>
    <ul class="dropdown-menu">
        <{foreach from=$submenu item=sub}>
            <li>
                <a <{if $sub.submenu}>tabindex="-1"<{/if}> <{if $sub.url!=''}>href="<{if $sub.target=="popup"}>javascript:tad_themes_popup('<{$sub.url}>');<{else}><{$sub.url}><{/if}>" <{if $sub.target!="popup"}>target="<{$sub.target}>"<{/if}><{/if}>>
                <{if $sub.img}><img src="<{$sub.img}>" alt="<{$sub.title}> icon"><{else if if $sub.icon}><i class="fa <{$sub.icon}>"></i><{/if}> <{$sub.title}>
                <{if $sub.submenu}><span class="caret"></span><{/if}>
                </a>
                <{if $sub.submenu}>
                    <{assign var=submenu value=$sub.submenu}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_sub.tpl"}>
                <{/if}>
            </li>
        <{/foreach}>
    </ul>
<{/if}>