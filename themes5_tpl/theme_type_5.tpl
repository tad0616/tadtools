<div id="xoops_theme_content_zone" class="row g-0">
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <!-- 若是有左、右區塊 -->
        <div id="xoops_theme_left_zone" class="<{if $lb_width=="auto"}>col-lg<{else}>col-xl-<{$lb_width|default:''}><{/if}> order-3 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$cb_width|default:''}> order-1 order-xl-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="<{if $rb_width=="auto"}>col-lg<{else}>col-xl-<{$rb_width|default:''}><{/if}> order-2 order-xl-3">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <!-- 若是只有左區塊 -->
        <{if $rb_width=="auto" and $lb_width=="auto"}>
            <{assign var="center_width" value=9}>
        <{elseif $rb_width!="auto" and $cb_width!="auto"}>
            <{assign var="center_width" value=$cb_width+$rb_width}>
        <{elseif $lb_width!="auto"}>
            <{assign var="center_width" value=12-$lb_width}>
        <{else}>
            <{assign var="center_width" value=$cb_width|default:''}>
        <{/if}>

        <div id="xoops_theme_left_zone" class="<{if $lb_width=="auto"}>col-lg<{else}>col-xl-<{$lb_width|default:''}><{/if}> order-2 order-xl-1">
            <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
                <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/leftBlock.tpl"}>
            </div>
        </div>

        <div id="xoops_theme_center_zone" class="col-xl-<{$center_width|default:''}> order-1 order-xl-2" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <!-- 若是只有右區塊 -->
        <{if $rb_width=="auto" and $lb_width=="auto"}>
            <{assign var="center_width" value=9}>
        <{elseif $lb_width!="auto" and $cb_width!="auto"}>
            <{assign var="center_width" value=$cb_width+$lb_width}>
        <{elseif $rb_width!="auto"}>
            <{assign var="center_width" value=12-$rb_width}>
        <{else}>
            <{assign var="center_width" value=$cb_width|default:''}>
        <{/if}>
        <div id="xoops_theme_center_zone" class="col-xl-<{$center_width|default:''}> order-1 order-xl-1" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" class="<{if $rb_width=="auto"}>col-lg<{else}>col-xl-<{$rb_width|default:''}><{/if}> order-2 order-xl-2">
            <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
                <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/rightBlock.tpl"}>
            </div>
        </div>
    <{else}>
        <div class="col-xl-12" style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes5_tpl/centerZone.tpl"}>
        </div>
    <{/if}>
    <div style="clear: both;"></div>
</div>