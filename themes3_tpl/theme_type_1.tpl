<div id="xoops_theme_content_zone" class="row row-sm-eq" style="<{$content_zone|default:''}>">
  <{if $xoBlocks.canvas_left|default:null or $xoBlocks.canvas_right|default:null}>
    <{if $theme_kind=="html"}>
      <div id="xoops_theme_left_zone" style="float:left; background-color:<{$lb_color|default:''}>;">

        <div id="xoops_theme_left" style="<{$leftBlocks|default:''}>; background-color:<{$lb_color|default:''}>;">
          <a accesskey="L" href="#xoops_theme_left_zone" id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
          <{if $xoBlocks.canvas_left|default:null}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>

          <{if $xoBlocks.canvas_right|default:null}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
          <{/if}>
        </div>
      </div>

      <div id="xoops_theme_center_zone" style="<{$centerBlocks|default:''}>">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>
    <{else}>

      <div id="xoops_theme_center_zone" class="col-sm-<{$center_width|default:''}> col-sm-push-<{$lb_width|default:''}>" style="<{$centerBlocks|default:''}>">
        <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>

      <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width|default:''}> col-sm-pull-<{$center_width|default:''}>" style="background-color:<{$lb_color|default:''}>;">
        <div id="xoops_theme_left" style="background-color:<{$lb_color|default:''}>;<{$leftBlocks|default:''}>">
          <a accesskey="L" href="#xoops_theme_left_zone" id="xoops_theme_left_zone_key" class="sr-only-focusable" aria-label="跳到左邊區域">:::</a>
          <{if $xoBlocks.canvas_left|default:null}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>

          <{if $xoBlocks.canvas_right|default:null}>
            <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
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