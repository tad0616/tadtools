<{if $xoBlocks.page_bottomleft|default:false}>
  <h2 class="sr-only visually-hidden">下中左區域內容</h2>
  <{foreach item=block from=$xoBlocks.page_bottomleft}>
    <{if $block.content|default:false}>
      <div class="centerBottomLeftBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>
