<{if $xoBlocks.page_topcenter|default:false}>
    <{foreach item=block from=$xoBlocks.page_topcenter}>
        <{if $block.content|default:false}>
            <div class="centerBlock">
                <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                <div class="blockContent" style="clear:both;">
                    <{$block.content}>
                </div>
            </div>
        <{/if}>
    <{/foreach}>
<{/if}>