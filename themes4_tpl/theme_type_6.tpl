<div id="xoops_theme_content_zone" class="row" style="<{$content_zone|default:''}>">
    <!-- 若是有左、右區塊 -->
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <{assign var="push_width" value=$lb_width+$rb_width}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-lg-3" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-lg-1" style="background-color:<{$lb_color|default:''}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$rb_width|default:''}> order-lg-2" style="background-color:<{$rb_color|default:''}>;">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-lg-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-lg-1" style="background-color:<{$lb_color|default:''}>;">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
                <{/if}>

                <{if $xoBlocks.canvas_right|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
                <{/if}>
            </div>
        </div>
    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-lg-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$lb_width|default:''}> order-lg-1" style="background-color:<{$rb_color|default:''}>;">
            <div id="xoops_theme_right" style="<{$rightBlocks|default:''}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>
