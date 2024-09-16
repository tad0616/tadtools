<{if $xoBlocks.page_topright|default:false}>
  <{foreach item=block from=$xoBlocks.page_topright}>
     <{if $block.content|default:false}>
      <div class="centerRightBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>