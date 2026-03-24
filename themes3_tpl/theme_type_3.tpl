<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone|default:''}>">
  <!-- 若是有左區塊 -->
  <{if $xoBlocks.canvas_left|default:null}>
    <!-- 若模式是HTML -->
    <{if $theme_kind=="html"}>
      <div id="xoops_theme_left_zone" style="float:left;background-color:<{$lb_color|default:''}>;">

        <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
          <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
          <{if $xoBlocks.canvas_left|default:null}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>
        </div>
      </div>

      <div id="xoops_theme_center_zone" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>
    <!-- 若模式是 BootStrap -->
    <{else}>

      <div id="xoops_theme_center_zone" class="col-sm-<{$center_width|default:''}> col-sm-push-<{$lb_width|default:''}>" style="<{$centerBlocks|default:''}>">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>

      <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width|default:''}> col-sm-pull-<{$center_width|default:''}>" style="background-color:<{$lb_color|default:''}>;">
        <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
          <a accesskey="L" href="#xoops_theme_left_zone"  id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
          <{if $xoBlocks.canvas_left|default:null}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>
        </div>
      </div>
    <{/if}>
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
