<{if $xoBlocks.page_bottomleft}>
  <{foreach item=block from=$xoBlocks.page_bottomleft}>
    <{if $block.content}>
      <div class="centerBottomLeftBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>
