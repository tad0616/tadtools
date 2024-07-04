<{if $xoBlocks.page_topleft}>
  <{foreach item=block from=$xoBlocks.page_topleft}>
    <{if $block.content}>
      <div class="centerLeftBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>
