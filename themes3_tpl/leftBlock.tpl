<{if $all_broadcast}>
  <{foreach from=$all_broadcast key=k item=block name=all_broadcast}>
      <{if $block.content}>
        <div class="leftBlock">
          <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
          <div class="blockContent" style="clear:both;">
            <{$block.content}>
          </div>
        </div>
      <{/if}>
  <{/foreach}>
<{/if}>

<{if $xoBlocks.canvas_left|default:null}>
  <{foreach item=block from=$xoBlocks.canvas_left|default:null}>
    <{if $block.content}>
      <div class="leftBlock">
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
        <div class="blockContent" style="clear:both;">
          <{$block.content}>
        </div>
      </div>
    <{/if}>
  <{/foreach}>
<{/if}>
