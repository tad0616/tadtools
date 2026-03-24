<div id="xoops_theme_content_zone" class="row g-0">
    <!-- 若是有左、右區塊 -->
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-2 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$rb_width|default:''}> order-3 order-xl-2">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-1 order-xl-3" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-1 order-xl-2">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
                <{/if}>

                <{if $xoBlocks.canvas_right|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
                <{/if}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-2 order-xl-1" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}>" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$lb_width|default:''}>">
            <div id="xoops_theme_right" style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>
