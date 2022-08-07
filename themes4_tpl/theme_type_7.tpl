<div id="xoops_theme_content_zone" class="row" style="<{$content_zone}>">
    <{if $xoBlocks.canvas_left and $xoBlocks.canvas_right}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width}>" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width}>" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$rb_width}>" style="background-color:<{$rb_color}>;">
            <div id="xoops_theme_right" style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left and !$xoBlocks.canvas_right}>
        <div id="xoops_theme_center_zone" class="col-xl-9" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-3" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{elseif !$xoBlocks.canvas_left and $xoBlocks.canvas_right}>
        <div id="xoops_theme_center_zone" class="col-xl-9" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-3" style="background-color:<{$rb_color}>;">
            <div id="xoops_theme_right" style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>
