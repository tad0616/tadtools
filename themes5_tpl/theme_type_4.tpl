<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null}>
        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width}>" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-lg-<{$lb_width}>">
            <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
            <div id="xoops_theme_right"  style="<{$leftBlocks}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-lg-12" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_left|default:null}>
    <div id="xoops_theme_right_zone" class="row g-0">
        <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
        <div class="col-lg-<{$rb_width}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBottom.tpl"}>
        </div>
        <div style="clear: both;"></div>
    </div>
<{/if}>