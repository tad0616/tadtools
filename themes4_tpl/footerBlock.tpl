
<{if $xoBlocks.footer_left || $xoBlocks.footer_right || $xoBlocks.footer_center}>
    <div class="row">
        <{if $xoBlocks.footer_left|default:false}>
            <div class="col-xl footerLeftBlock" id="footerLeftBlock">
                <{foreach from=$xoBlocks.footer_left item=block}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>


        <{if $xoBlocks.footer_center|default:false}>
            <div class="col-xl footerCenterBlock" id="footerCenterBlock">
                <{foreach from=$xoBlocks.footer_center item=block}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>

        <{if $xoBlocks.footer_right|default:false}>
            <div class="col-xl footerRightBlock" id="footerRightBlock">
                <{foreach from=$xoBlocks.footer_right item=block}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>
    </div>
<{/if}>