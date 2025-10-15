<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row"<{/if}>>

  <{if $xoBlocks.canvas_left|default:null}>

    <div id="xoops_theme_left_zone" style="background-color:<{$lb_color|default:''}>;">
      <a accesskey="L" href="#xoops_theme_left_zone" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
      <div class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$lb_width|default:''}>"  style="background-color:<{$lb_color|default:''}>;">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBottom.tpl"}>
      </div>
    </div>

  <{/if}>

  <div id="xoops_theme_center_zone" style="background-color:<{$cb_color|default:''}>;">
    <div class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width|default:''}>" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>
  </div>

  <{if $xoBlocks.canvas_right|default:null}>

    <div id="xoops_theme_right_zone" style="background-color:<{$rb_color|default:''}>;">
      <a accesskey="R" href="#xoops_theme_right_zone" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
      <div class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width|default:''}>" style="background-color:<{$rb_color|default:''}>;">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBottom.tpl"}>
      </div>
    </div>

  <{/if}>

  <div style="clear: both;"></div>
</div>