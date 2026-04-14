<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null}>
        <div class="col-xl-12" id="xoops_theme_left_zone">
            <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到上方區域">:::</a>
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBottom.tpl"}>
        </div>
    <{/if}>

    <div class="col-xl-12" id="xoops_theme_center_zone">
        <div style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    </div>

    <{if $xoBlocks.canvas_right|default:null}>
        <div class="col-xl-12" id="xoops_theme_right_zone">
            <a accesskey="B"  href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到下方區域">:::</a>
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBottom.tpl"}>
        </div>
    <{/if}>

    <div style="clear: both;"></div>
</div>