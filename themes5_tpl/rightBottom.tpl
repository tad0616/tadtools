<{if $xoBlocks.canvas_right|default:null}>
    <div class="rightBlock" style="<{if $rightBlocks2|default:false}><{$rightBlocks2|default:''}>;<{/if}>width:100%;">
        <div class="row">
        <{foreach item=block from=$xoBlocks.canvas_right|default:null}>
            <{if $block.content|default:false}>
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent" style="clear:both;">
                        <{$block.content}>
                    </div>
                </div>
            <{/if}>
        <{/foreach}>
        </div>
    </div>
<{/if}>