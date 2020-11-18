<{if $xoBlocks.canvas_right}>
    <div class="rightBlock" style="<{if $rightBlocks2}><{$rightBlocks2}>;<{/if}>width:100%;">
        <div class="row">
        <{foreach item=block from=$xoBlocks.canvas_right}>
            <{if $block.content}>
                <div class="col-sm-3">
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent" style="clear:both;">
                        <{$block.content}>
                    </div>
                </div>
            <{/if}>
        <{/foreach}>
        </div>
    </div>
<{/if}>