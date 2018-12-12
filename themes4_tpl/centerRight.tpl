<{if $xoBlocks.page_topright}>
  <{foreach item=block from=$xoBlocks.page_topright}>
     <{if $block.content}>
      <div class="centerRightBlock">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>