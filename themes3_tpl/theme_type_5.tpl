<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone}>">
    <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <!-- 若是有左、右區塊 -->
        <{if $theme_kind=="html"}>
            <!-- 若模式是HTML -->
            <div id="xoops_theme_left_zone" style="float:left; background-color:<{$lb_color}>;">

                <div id="xoops_theme_left" style="<{$leftBlocks}>">
                    <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
                </div>
            </div>

            <div id="xoops_theme_center_zone" style="<{$centerBlocks}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
            </div>

            <div id="xoops_theme_right_zone" style="float:right; background-color:<{$rb_color}>;">
                <div id="xoops_theme_right"  style="<{$rightBlocks}>">
                    <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
                </div>
            </div>
        <{else}>
            <!-- 若模式是 BootStrap -->

            <div id="xoops_theme_center_zone" class="col-sm-<{$center_width}> col-sm-push-<{$lb_width}>" style="<{$centerBlocks}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
            </div>

            <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$lb_color}>;">
                <div id="xoops_theme_left" style="<{$leftBlocks}>">
                    <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
                </div>
            </div>

            <div id="xoops_theme_right_zone" class="col-sm-<{$rb_width}>" style="background-color:<{$rb_color}>;">
                <div id="xoops_theme_right"  style="<{$rightBlocks}>">
                    <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
                </div>
            </div>
        <{/if}>

    <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>
        <!-- 若是只有左區塊 -->
        <{if $theme_kind=="html"}>
            <!-- 若模式是HTML -->
            <div id="xoops_theme_left_zone" style="float:left; background-color:<{$lb_color}>;">

                <div id="xoops_theme_left" style="<{$leftBlocks}>">
                    <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
                </div>
            </div>

            <div id="xoops_theme_center_zone" style="<{$centerBlocks}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
            </div>
        <{else}>
            <!-- 若模式是 BootStrap -->
            <{assign var="center_width" value=$center_width+$rb_width}>

            <div id="xoops_theme_center_zone" class="col-sm-<{$center_width}> col-sm-push-<{$lb_width}>" style="<{$centerBlocks}>">
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
            </div>

            <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$lb_color}>;">
                <div id="xoops_theme_left" style="<{$leftBlocks}>">
                    <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                    <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
                </div>
            </div>
        <{/if}>

    <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>
        <!-- 若是只有右區塊 -->
        <{assign var="center_width" value=$center_width+$lb_width}>

        <div id="xoops_theme_center_zone" <{if $theme_kind!="html"}>class="col-sm-<{$center_width}>"<{/if}> style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
        </div>

        <div id="xoops_theme_right_zone" <{if $theme_kind!="html"}>class="col-sm-<{$rb_width}>"<{/if}> style="<{if $theme_kind=="html"}>float:right;<{/if}>background-color:<{$rb_color}>;">
            <div id="xoops_theme_right"  style="<{$rightBlocks}>">
                <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
                <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
            </div>
        </div>

    <{else}>

        <div class="col-sm-12" style="<{$centerBlocks}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
        </div>

    <{/if}>

    <div style="clear: both;"></div>
</div>
