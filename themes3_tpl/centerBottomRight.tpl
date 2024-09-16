<{if $xoBlocks.page_bottomright|default:false}>
  <{foreach item=block from=$xoBlocks.page_bottomright}>
     <{if $block.content|default:false}>
      <div class="centerBottomRightBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>