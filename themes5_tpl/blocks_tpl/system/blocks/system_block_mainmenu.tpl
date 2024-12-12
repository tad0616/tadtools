<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/modules/tadtools/css/vertical_menu.css">
<ul class="vertical_menu">
    <li <{if $block.nothome|default:false}>class="selected"<{/if}>>
        <a href="<{$xoops_url}>/" title="<{$block.lang_home}>">
            <i class="fa fa-home" aria-hidden="true"></i> <{$block.lang_home}>
        </a>
    </li>
    <{if $block.modules|default:false}>
        <{foreach from=$block.modules item=module}>
            <{if $module.name|default:false}>
                <li <{if isset($module.highlight) && $module.highlight}>class="selected"<{/if}>>
                    <a href="<{$xoops_url}>/modules/<{$module.directory}>/" title="<{$module.name}>">
                    <i class="fa fa-circle-right" aria-hidden="true"></i>
                    <{$module.name}>
                    </a>
                </li>
            <{/if}>
            <{if $module.sublinks|default:false}>
                <{foreach from=$module.sublinks item=sublink}>
                    <li style="padding-left: 2em; font-size: 0.925rem;">
                        <a href="<{if $sublink.url|default:false}><{$sublink.url}><{else}>#<{/if}>" title="<{$sublink.name}>">
                        <{$sublink.name}>
                        <i class="fa fa-circle-right" aria-hidden="true"></i>
                        </a>
                    </li>
                <{/foreach}>
            <{/if}>
        <{/foreach}>
    <{/if}>
</ul>
