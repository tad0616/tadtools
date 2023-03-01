<{foreach from=$menu_var item=m}>
    <li>
        <a <{if $m.submenu}>class="dropdown-toggle" data-toggle="dropdown" <{/if}> <{if $m.url!=''}>href="<{if $m.target=="popup"}>javascript:tad_themes_popup('<{$m.url}>');<{else}><{$m.url}><{/if}>" <{if $m.target!="popup"}>target="<{$m.target}>"<{/if}><{/if}>>
        <{if $m.img}><img src="<{$m.img}>" alt="<{$m.title}> icon"><{elseif $m.icon}><i class="fa <{$m.icon}>"></i><{/if}> <{$m.title}> <{if $m.submenu}> <span class="caret"></span><{/if}>
        </a>
        <{if $m.submenu}>
            <{if $m.submenu=='1'}>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
            <{else}>
                <{if $m.submenu}>
                    <{assign var=submenu value=$m.submenu}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_sub.tpl"}>
                <{/if}>
            <{/if}>
        <{/if}>
    </li>
<{/foreach}>