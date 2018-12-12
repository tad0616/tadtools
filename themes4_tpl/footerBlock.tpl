
<{if $xoBlocks.footer_left || $xoBlocks.footer_right || $xoBlocks.footer_center}>
    <div class="row">
        <{if $xoBlocks.footer_left}>
            <div class="col" id="footerLeft">
                <{foreach from=$xoBlocks.footer_left item=block}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>


        <{if $xoBlocks.footer_center}>
            <div class="col" id="footerCenter">
                <{foreach from=$xoBlocks.footer_center item=block}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
                    <div class="blockContent">
                        <{$block.content}>
                    </div>
                <{/foreach}>
            </div>
        <{/if}>

        <{if $xoBlocks.footer_right}>
            <div class="col" id="footerRight">
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