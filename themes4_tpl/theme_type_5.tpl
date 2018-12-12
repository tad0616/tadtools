<div id="xoops_theme_content_zone" class="row" style="<{$content_zone}>">
    <{if $xoBlocks.canvas_left and $xoBlocks.canvas_right}>
        <!-- 若是有左、右區塊 -->

        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width}> order-lg-2" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="<{if $lb_width=="auto"}>col-lg<{else}>col-lg-<{$lb_width}><{/if}> order-lg-1" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 10px;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="<{if $rb_width=="auto"}>col-lg<{else}>col-lg-<{$rb_width}><{/if}> order-lg-3" style="background-color:<{$rb_color}>;">
            <div id="xoops_theme_right"  style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 10px;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left and !$xoBlocks.canvas_right}>
        <!-- 若是只有左區塊 -->
        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width}> order-lg-2" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="<{if $lb_width=="auto"}>col-lg<{else}>col-lg-<{$lb_width}><{/if}> order-lg-1" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 10px;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{elseif !$xoBlocks.canvas_left and $xoBlocks.canvas_right}>
        <!-- 若是只有右區塊 -->

        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width}> order-lg-1" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="<{if $rb_width=="auto"}>col-lg<{else}>col-lg-<{$rb_width}><{/if}> order-lg-2" style="background-color:<{$rb_color}>;">
            <div id="xoops_theme_right"  style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 10px;">:::</a>
                <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div class="col-lg-12" style="<{$centerBlocks}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>
