<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null or $xoBlocks.canvas_right|default:null}>
        <div id="xoops_theme_left_zone" class="col-xl-<{$lb_width|default:''}> order-2 order-xl-1">
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

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-1 order-xl-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>