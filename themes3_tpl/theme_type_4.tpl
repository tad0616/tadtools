<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone|default:''}>">

  <{if $xoBlocks.canvas_left|default:null}>

    <div id="xoops_theme_center_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width|default:''}>" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_left_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$lb_width|default:''}>" style="<{if $theme_kind=="html"}>float:right;;<{/if}>background-color:<{$lb_color|default:''}>;">
      <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
      <div id="xoops_theme_right"  style="<{$leftBlocks|default:''}>">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
      </div>
    </div>

  <{else}>

    <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

  <{/if}>

  <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_left|default:null}>
  <div id="xoops_theme_right_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="background-color:<{$rb_color|default:''}>;">
      <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
    <div class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBottom.tpl"}>
    </div>
    <div style="clear: both;"></div>
  </div>
<{/if}>