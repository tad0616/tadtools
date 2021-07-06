<div id="xoops_theme_content_zone" class="row" style="<{$content_zone}>">
    <{if $xoBlocks.canvas_left or $xoBlocks.canvas_right}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width}> order-lg-2" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width}> order-lg-1" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="background-color:<{$lb_color}>;<{$leftBlocks}>">
            <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem;">:::</a>
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
    <div style="clear: both;"></div>
</div>