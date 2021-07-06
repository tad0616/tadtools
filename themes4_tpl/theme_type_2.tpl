<div class="row" id="xoops_theme_content_zone" style="<{$content_zone}>">
    <{if $xoBlocks.canvas_left or $xoBlocks.canvas_right}>
        <div class="col-xl-<{$cb_width}>" id="xoops_theme_center_zone" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div class="col-xl-<{$rb_width}>" id="xoops_theme_right_zone" style="background-color: <{$rb_color}>;">
            <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem;">:::</a>
            <div id="xoops_theme_right"  style="<{$rightBlocks}>">
                <{if $xoBlocks.canvas_left or $need_left}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
                <{/if}>

                <{if $xoBlocks.canvas_left or $need_right}>
                    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
                <{/if}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
</div>