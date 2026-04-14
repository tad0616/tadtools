<{foreach from=$menu_var item=m1}>
    <li role="none">
        <{if $m1.submenu|default:false}>
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tad_menu_sub.tpl" icon=$m1.icon img=$m1.img sub_title=$m1.title submenu=$m1.submenu}>
        <{else}>
            <a href="<{if $m1.url!=''}><{if $m1.target=='popup'}>javascript:tad_themes_popup('<{$m1.url}>');<{else}><{$m1.url}><{/if}><{else}>#<{/if}>" role="menuitem" <{if $m1.url!='' && $m1.target!='popup'}>target="<{$m1.target}>" <{if $m1.target=='_blank'}>title="另開新視窗<{if $m1.url|substr:-4=='.pdf'}>(PDF格式)<{/if}>"<{/if}><{/if}>>
                <{if $m1.img|default:false}><img src="<{$m1.img}>" alt=""><{elseif $m1.icon}><i class="<{if $m1.icon|substr:0:3=='fa-'}>fa <{/if}><{$m1.icon}>" aria-hidden="true"></i><{/if}> <{$m1.title}>
            </a>
        <{/if}>
    </li>
<{/foreach}>