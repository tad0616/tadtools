<{if $xoBlocks.canvas_right|default:null}>
    <h2 class="sr-only visually-hidden">右邊區域內容</h2>
	<{foreach item=block from=$xoBlocks.canvas_right|default:null}>
        <{if $block.content|default:false}>
            <div class="rightBlock dont-print">
                <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                <div class="blockContent">
                    <{$block.content}>
                </div>
            </div>
        <{/if}>
  <{/foreach}>
<{/if}>