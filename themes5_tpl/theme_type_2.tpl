<div class="row g-0" id="xoops_theme_content_zone">
    <{if $xoBlocks.canvas_left|default:null or $xoBlocks.canvas_right|default:null}>
        <div class="col-xl-<{$cb_width}>" id="xoops_theme_center_zone" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div class="col-xl-<{$rb_width}>" id="xoops_theme_right_zone">
            <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
            <div id="xoops_theme_right" style="<{$rightBlocks}>">
                <{if $xoBlocks.canvas_left|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
                <{/if}>

                <{if $xoBlocks.canvas_right|default:null}>
                    <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
                <{/if}>
            </div>
        </div>
    <{else}>
        <div id="xoops_theme_center_zone" class="col-xl-12" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
</div>