<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone}>">

  <{if $xoBlocks.canvas_left|default:null}>

    <div id="xoops_theme_center_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width}>" style="<{$centerBlocks}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_left_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$lb_width}>" style="<{if $theme_kind=="html"}>float:right;;<{/if}>background-color:<{$lb_color}>;">
      <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
      <div id="xoops_theme_right"  style="<{$leftBlocks}>">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
      </div>
    </div>

  <{else}>

    <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

  <{/if}>

  <div style="clear: both;"></div>
</div>

<{if $xoBlocks.canvas_left|default:null}>
  <div id="xoops_theme_right_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="background-color:<{$rb_color}>;">
      <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
    <div class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBottom.tpl"}>
    </div>
    <div style="clear: both;"></div>
  </div>
<{/if}>