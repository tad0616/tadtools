<div id="xoops_theme_content_zone" class="row" style="<{$content_zone|default:''}>">
    <{if $xoBlocks.canvas_left|default:null}>
        <div id="xoops_theme_center_zone" class="col-lg-<{$cb_width|default:''}>" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_left_zone" class="col-lg-<{$lb_width|default:''}>" style="background-color:<{$lb_color|default:''}>;">
            <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
            <div id="xoops_theme_right"  style="<{$leftBlocks|default:''}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-lg-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_left|default:null}>
    <div id="xoops_theme_right_zone" class="row" style="background-color:<{$rb_color|default:''}>;">
        <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
        <div class="col-lg-<{$rb_width|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBottom.tpl"}>
        </div>
        <div style="clear: both;"></div>
    </div>
<{/if}>