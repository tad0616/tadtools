<div id="xoops_theme_content_zone" class="row" style="<{$content_zone}>">
    <!-- 若是有左區塊 -->
    <{if $xoBlocks.canvas_left|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width}> order-lg-2" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width}> order-lg-1" style="background-color:<{$lb_color}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
                <{/if}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_left|default:null}>
    <div id="xoops_theme_right_zone" class="row" style="background-color:<{$rb_color}>;">
        <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
        <div class="col-xl-<{$rb_width}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBottom.tpl"}>
        </div>
        <div style="clear: both;"></div>
    </div>
<{/if}>
