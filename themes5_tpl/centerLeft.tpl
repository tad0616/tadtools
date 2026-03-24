<{if $xoBlocks.page_topleft|default:false}>
  <h2 class="sr-only visually-hidden">上中左區域內容</h2>
  <{foreach item=block from=$xoBlocks.page_topleft}>
    <{if $block.content|default:false}>
      <div class="centerLeftBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>

        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>
