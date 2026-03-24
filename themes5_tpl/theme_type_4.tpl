<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null}>
        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width|default:''}>" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-lg-<{$lb_width|default:''}>">
            <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
            <div id="xoops_theme_right"  style="<{$leftBlocks|default:''}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-lg-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_left|default:null}>
    <div id="xoops_theme_right_zone" class="row g-0">
        <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
        <div class="col-lg-<{$rb_width|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBottom.tpl"}>
        </div>
        <div style="clear: both;"></div>
    </div>
<{/if}>