<{if $xoBlocks.page_bottomcenter}>
  <{foreach item=block from=$xoBlocks.page_bottomcenter}>
    <{if $block.content}>
      <div class="centerBottomBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>