<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/modules/tadtools/css/vertical_menu.css">
<ul class="vertical_menu">
    <li <{if isset($block.nothome) && !$block.nothome}>class="selected"<{/if}>>
        <a href="<{$xoops_url}>/" title="<{$block.lang_home}>">
        <i class="fa fa-home" aria-hidden="true"></i>
        <{$block.lang_home}>
        </a>
    </li>
    <{if isset($block.modules)}>
        <{foreach from=$block.modules item=module}>
            <li <{if isset($module.highlight) && $module.highlight}>class="selected"<{/if}>>
                <a href="<{$xoops_url}>/modules/<{$module.directory}>/" title="<{$module.name}>">
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                <{$module.name}>
                </a>
            </li>
            <{if isset($module.sublinks)}>
                <{foreach from=$module.sublinks item=sublink}>
                    <li style="padding-left: 2em; font-size: 0.925rem;">
                        <a href="<{$sublink.url}>" title="<{$sublink.name}>">
                        <{$sublink.name}>
                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                        </a>
                    </li>
                <{/foreach}>
            <{/if}>
        <{/foreach}>
    <{/if}>
</ul>
