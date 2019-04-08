<{if $xoBlocks.canvas_right}>
	<{foreach item=block from=$xoBlocks.canvas_right}>
        <{if $block.content}>
            <div class="rightBlock">
                <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                <div class="blockContent">
                    <{$block.content}>
                </div>
            </div>
        <{/if}>
  <{/foreach}>
<{/if}>