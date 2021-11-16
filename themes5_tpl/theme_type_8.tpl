<div id="xoops_theme_content_zone" class="row">
    <{if $xoBlocks.canvas_left}>
        <div class="col-xl-12" id="xoops_theme_left_zone" style="background-color:<{$lb_color}>;">
            <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem;">:::</a>
            <div  style="background-color:<{$lb_color}>;">
                <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBottom.tpl"}>
            </div>
        </div>
    <{/if}>

    <div class="col-xl-12" id="xoops_theme_center_zone" style="background-color:<{$cb_color}>;">
        <div style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    </div>

    <{if $xoBlocks.canvas_right}>
        <div class="col-xl-12" id="xoops_theme_right_zone" style="background-color:<{$rb_color}>;">
            <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem;">:::</a>
            <div style="background-color:<{$rb_color}>;">
                <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBottom.tpl"}>
            </div>
        </div>
    <{/if}>

    <div style="clear: both;"></div>
</div>