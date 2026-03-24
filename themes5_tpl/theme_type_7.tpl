<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}>" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}>">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-<{$rb_width|default:''}>">
            <div id="xoops_theme_right" style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-9" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-xl-3">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_center_zone" class="col-xl-9" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="col-xl-3">
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
