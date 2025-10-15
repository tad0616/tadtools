<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone|default:''}>">

  <{if $xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>

    <div id="xoops_theme_center_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width|default:''}>" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_left_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$lb_width|default:''}>" style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$lb_color|default:''}>;">
      <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
        <a accesskey="L" href="#xoops_theme_left_zone" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
      </div>
    </div>

    <div id="xoops_theme_right_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width|default:''}>" style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$rb_color|default:''}>;">
      <div id="xoops_theme_right" style="<{$rightBlocks|default:''}>">
        <a accesskey="R" href="#xoops_theme_right_zone" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
      </div>
    </div>

  <{elseif $xoBlocks.canvas_left|default:null and !$xoBlocks.canvas_right|default:null}>

    <div id="xoops_theme_center_zone" class="col-sm-9" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_left_zone" <{if $theme_kind!="html"}>class="col-sm-3"<{/if}> style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$lb_color|default:''}>;">
      <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>">
        <a accesskey="L" href="#xoops_theme_left_zone" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
      </div>
    </div>

  <{elseif !$xoBlocks.canvas_left|default:null and $xoBlocks.canvas_right|default:null}>

    <div id="xoops_theme_center_zone" <{if $theme_kind!="html"}>class="col-sm-9"<{/if}> style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_right_zone" <{if $theme_kind!="html"}>class="col-sm-3"<{/if}> style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$rb_color|default:''}>;">
      <div id="xoops_theme_right" style="<{$rightBlocks|default:''}>">
        <a accesskey="R" href="#xoops_theme_right_zone" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
      </div>
    </div>

   <{else}>

     <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks|default:''}>">
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

  <{/if}>
  <div style="clear: both;"></div>
</div>
