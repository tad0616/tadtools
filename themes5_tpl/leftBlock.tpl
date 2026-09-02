<h2 class="sr-only visually-hidden">左邊區域內容</h2>
<{if $all_broadcast|default:false}>
    <{foreach from=$all_broadcast key=k item=block name=all_broadcast}>
        <{if $block.content|default:false}>
            <div class="leftBlock dont-print">
                <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                <div class="blockContent">
                    <{$block.content}>
                </div>
            </div>
        <{/if}>
    <{/foreach}>
<{/if}>

<{if $xoBlocks.canvas_left|default:null}>
    <{foreach item=block from=$xoBlocks.canvas_left|default:null}>
        <{if $block.content|default:false}>
            <div class="leftBlock dont-print">
                <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                <div class="blockContent">
                    <{$block.content}>
                </div>
            </div>
        <{/if}>
    <{/foreach}>
<{/if}>