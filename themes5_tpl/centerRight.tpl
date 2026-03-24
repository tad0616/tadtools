<{if $xoBlocks.page_topright|default:false}>
  <h2 class="sr-only visually-hidden">上中右區域內容</h2>
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