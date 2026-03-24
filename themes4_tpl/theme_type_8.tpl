<div id="xoops_theme_content_zone" class="row">
    <{if $xoBlocks.canvas_left|default:null}>
        <div class="col-xl-12" id="xoops_theme_left_zone" style="background-color:<{$lb_color|default:''}>;">
            <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
            <div  style="background-color:<{$lb_color|default:''}>;">
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/leftBottom.tpl"}>
            </div>
        </div>
    <{/if}>

    <div class="col-xl-12" id="xoops_theme_center_zone" style="background-color:<{$cb_color|default:''}>;">
        <div style="<{$centerBlocks|default:''}>">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/centerZone.tpl"}>
        </div>
    </div>

    <{if $xoBlocks.canvas_right|default:null}>
        <div class="col-xl-12" id="xoops_theme_right_zone" style="background-color:<{$rb_color|default:''}>;">
            <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
            <div style="background-color:<{$rb_color|default:''}>;">
                <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/rightBottom.tpl"}>
            </div>
        </div>
    <{/if}>

    <div style="clear: both;"></div>
</div>