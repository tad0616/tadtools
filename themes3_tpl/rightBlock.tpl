<{if $xoBlocks.canvas_right|default:null}>
	<{foreach item=block from=$xoBlocks.canvas_right|default:null}>
    <{if $block.content}>
      <div class="rightBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>