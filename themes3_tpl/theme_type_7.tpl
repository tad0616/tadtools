<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone}>">

  <{if $xoBlocks.canvas_left and $xoBlocks.canvas_right}>

    <div id="xoops_theme_center_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width}>" style="<{$centerBlocks}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_left_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$lb_width}>" style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$lb_color}>;">
      <div id="xoops_theme_left" style="<{$leftBlocks}>">
        <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 10px;">:::</a>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
      </div>
    </div>

    <div id="xoops_theme_right_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width}>" style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$rb_color}>;">
      <div id="xoops_theme_right" style="<{$rightBlocks}>">
        <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 10px;">:::</a>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
      </div>
    </div>

  <{elseif $xoBlocks.canvas_left and !$xoBlocks.canvas_right}>

    <div id="xoops_theme_center_zone" class="col-sm-9" style="<{$centerBlocks}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_left_zone" <{if $theme_kind!="html"}>class="col-sm-3"<{/if}> style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$lb_color}>;">
      <div id="xoops_theme_left" style="<{$leftBlocks}>">
        <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 10px;">:::</a>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
      </div>
    </div>

  <{elseif !$xoBlocks.canvas_left and $xoBlocks.canvas_right}>

    <div id="xoops_theme_center_zone" <{if $theme_kind!="html"}>class="col-sm-9"<{/if}> style="<{$centerBlocks}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_right_zone" <{if $theme_kind!="html"}>class="col-sm-3"<{/if}> style="<{if $theme_kind=="html"}>float:left;<{/if}>background-color:<{$rb_color}>;">
      <div id="xoops_theme_right" style="<{$rightBlocks}>">
        <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 10px;">:::</a>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
      </div>
    </div>

   <{else}>

     <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

  <{/if}>
  <div style="clear: both;"></div>
</div>
