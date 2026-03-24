<div class="row" id="xoops_theme_content_zone" style="<{$content_zone|default:''}>">
    <{if $xoBlocks.canvas_left|default:null or $xoBlocks.canvas_right|default:null}>
        <div class="col-xl-<{$cb_width|default:''}>" id="xoops_theme_center_zone" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>

        <div class="col-xl-<{$rb_width|default:''}>" id="xoops_theme_right_zone" style="background-color: <{$rb_color|default:''}>;">
            <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBlock.tpl"}>
                <{/if}>

                <{if $xoBlocks.canvas_right|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBlock.tpl"}>
                <{/if}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
</div>