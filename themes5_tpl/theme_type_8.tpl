<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null}>
        <div class="col-xl-12" id="xoops_theme_left_zone">
            <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBottom.tpl"}>
        </div>
    <{/if}>

    <div class="col-xl-12" id="xoops_theme_center_zone">
        <div style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    </div>

    <{if $xoBlocks.canvas_right|default:null}>
        <div class="col-xl-12" id="xoops_theme_right_zone">
            <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBottom.tpl"}>
        </div>
    <{/if}>

    <div style="clear: both;"></div>
</div>