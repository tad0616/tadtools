<{if $xoBlocks.canvas_left}>
  <{foreach item=block from=$xoBlocks.canvas_left}>
    <{if $block.content}>
      <div class="leftBlock">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>