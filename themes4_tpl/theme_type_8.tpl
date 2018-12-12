<div id="xoops_theme_content_zone" class="row">
    <{if $xoBlocks.canvas_left}>
        <div id="xoops_theme_left_zone" style="background-color:<{$lb_color}>;">
            <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 10px;">:::</a>
            <div class="col-sm-<{$lb_width}>"  style="background-color:<{$lb_color}>;">
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBottom.tpl"}>
            </div>
        </div>
    <{/if}>

    <div id="xoops_theme_center_zone" style="background-color:<{$cb_color}>;">
        <div class="col-sm-<{$cb_width}>" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    </div>

    <{if $xoBlocks.canvas_right}>
        <div id="xoops_theme_right_zone" style="background-color:<{$rb_color}>;">
            <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 10px;">:::</a>
            <div class="col-sm-<{$rb_width}>" style="background-color:<{$rb_color}>;">
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBottom.tpl"}>
            </div>
        </div>
    <{/if}>

    <div style="clear: both;"></div>
</div>