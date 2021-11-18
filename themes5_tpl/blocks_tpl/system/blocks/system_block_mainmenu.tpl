<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/modules/tadtools/css/vertical_menu.css">
<ul class="vertical_menu">
    <li <{if !$block.nothome}>class="selected"<{/if}>>
        <a href="<{xoAppUrl }>">
        &#xf015;
        <{$block.lang_home}>
        </a>
    </li>
    <{foreach item=module from=$block.modules}>
        <li <{if $module.highlight}>class="selected"<{/if}>>
            <a href="<{$xoops_url}>/modules/<{$module.directory}>/" title="<{$module.name}>">
            <i class="fa fa-arrow-circle-end" aria-hidden="true"></i>
            <{$module.name}>
            </a>
        </li>
        <{if $module.sublinks}>
            <{foreach item=sublink from=$module.sublinks}>
                <li style="padding-left: 2em; font-size: 0.9em;">
                    <a href="<{$sublink.url}>" title="<{$sublink.name}>">
                    <{$sublink.name}>
                    <i class="fa fa-arrow-circle-o-end" aria-hidden="true"></i>
                    </a>
                </li>
            <{/foreach}>
        <{/if}>
    <{/foreach}>
</ul>
