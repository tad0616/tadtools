<{if $xoBlocks.page_topcenter|default:false}>
    <h2 class="sr-only visually-hidden">上中區域內容</h2>
    <{foreach item=block from=$xoBlocks.page_topcenter}>
        <{if $block.content|default:false}>
            <div class="centerBlock dont-print">
                <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                <div class="blockContent" style="clear:both;">
                    <{$block.content}>
                </div>
            </div>
        <{/if}>
    <{/foreach}>
<{/if}>