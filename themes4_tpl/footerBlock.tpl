
<{if $xoBlocks.footer_left || $xoBlocks.footer_right || $xoBlocks.footer_center}>
    <div class="row">
        <{if $xoBlocks.footer_left}>
            <div class="col footerLeftBlock" id="footerLeftBlock">
                <{foreach from=$xoBlocks.footer_left item=block}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>


        <{if $xoBlocks.footer_center}>
            <div class="col footerCenterBlock" id="footerCenterBlock">
                <{foreach from=$xoBlocks.footer_center item=block}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>

        <{if $xoBlocks.footer_right}>
            <div class="col footerRightBlock" id="footerRightBlock">
                <{foreach from=$xoBlocks.footer_right item=block}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>
    </div>
<{/if}>