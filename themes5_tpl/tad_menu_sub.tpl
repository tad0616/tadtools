<{if $submenu|default:false}>
    <{if $img|default:false}>
        <{capture assign="sub_icon"}>
            <img src="<{$img}>" alt="<{$sub_title}>圖示" aria-hidden="true">
        <{/capture}>
    <{elseif $icon|default:false}>
        <{capture assign="sub_icon"}>
            <i class="<{if $icon|substr:0:3 == 'fa-'}>fa <{/if}><{$icon}>" aria-hidden="true"></i>
        <{/capture}>
    <{/if}>

    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tadnav-submenu.tpl"}>

    <ul class="tadnav-submenu" role="menu" aria-label="<{$sub_title}>子選單">
        <{foreach from=$submenu item=sub}>
            <li role="none">
                <{if $sub.submenu|default:false}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/tad_menu_sub.tpl" icon=$sub.icon img=$sub.img sub_title=$sub.title submenu=$sub.submenu}>
                <{else}>
                    <a href="<{if $sub.url != ''}><{if $sub.target == 'popup'}>javascript:tad_themes_popup('<{$sub.url}>');<{else}><{$sub.url}><{/if}><{else}>#<{/if}>"
                        role="menuitem"
                        <{if $sub.url != '' && $sub.target != 'popup'}>
                            target="<{$sub.target}>"
                            <{if $sub.target == '_blank'}>
                                title="另開新視窗<{if $sub.url|substr:-4 == '.pdf'}>(PDF格式)<{/if}>"
                            <{/if}>
                        <{/if}>>
                        <{if $sub.img|default:false}>
                            <img src="<{$sub.img}>" alt="">
                        <{elseif $sub.icon|default:false}>
                            <i class="<{if $sub.icon|substr:0:3 == 'fa-'}>fa <{/if}><{$sub.icon}>" aria-hidden="true"></i>
                        <{/if}>
                        <{$sub.title}>
                    </a>
                <{/if}>
            </li>
        <{/foreach}>
    </ul>
<{/if}>