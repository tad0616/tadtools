<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone|default:''}>">

  <{if $xoBlocks.canvas_left|default:null or $xoBlocks.canvas_right|default:null}>

    <div id="xoops_theme_center_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width|default:''}>" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_right_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width|default:''}>" style="background-color: <{$rb_color|default:''}>; <{if $theme_kind=="html"}>float:right;<{/if}>">
      <a accesskey="B"  tabindex="-1" href="#xoops_theme_right_zone" id="xoops_theme_right_zone_key" class="sr-only-focusable" aria-label="跳到右邊區域">:::</a>
      <div id="xoops_theme_right"  style="<{$rightBlocks|default:''}>">
        <{if $xoBlocks.canvas_left|default:null}>
          <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
        <{/if}>

        <{if $xoBlocks.canvas_right|default:null}>
          <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
        <{/if}>
      </div>
    </div>

  <{else}>

    <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

  <{/if}>

  <div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>