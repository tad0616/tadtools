<{foreach from=$menu_var item=m}>
    <li>
        <a <{if $m.submenu|default:false}>class="dropdown-toggle" data-toggle="dropdown" <{/if}> <{if $m.url!=''}>href="<{if $m.target=="popup"}>javascript:tad_themes_popup('<{$m.url}>');<{else}><{$m.url}><{/if}>" <{if $m.target!="popup"}>target="<{$m.target}>"<{/if}><{/if}>>
        <{if $m.img|default:false}><img src="<{$m.img}>" alt="<{$m.title}> icon"><{elseif $m.icon}><i class="<{if $m.icon|substr:0:3=='fa-'}>fa <{/if}><{$m.icon}>"></i><{/if}> <{$m.title}> <{if $m.submenu|default:false}> <span class="caret"></span><{/if}>
        </a>
        <{if $m.submenu|default:false}>
            <{if $m.submenu=='1'}>
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_login.tpl"}>
            <{else}>
                <{if $m.submenu|default:false}>
                    <{assign var="submenu" value=$m.submenu}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/menu_sub.tpl"}>
                <{/if}>
            <{/if}>
        <{/if}>
    </li>
<{/foreach}>