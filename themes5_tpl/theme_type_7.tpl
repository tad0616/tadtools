<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width}>" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width}>">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$rb_width}>">
            <div id="xoops_theme_right" style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-9" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-3">
            <div id="xoops_theme_left" style="<{$leftBlocks}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-9" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-3">
            <div id="xoops_theme_right" style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks}>">
        <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>
