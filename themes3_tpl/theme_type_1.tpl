<div id="xoops_theme_content_zone" class="row row-sm-eq" style="<{$content_zone}>">
  <{if $xoBlocks.canvas_left or $xoBlocks.canvas_right}>
    <{if $theme_kind=="html"}>
      <div id="xoops_theme_left_zone" style="float:left; background-color:<{$lb_color}>;">

        <div id="xoops_theme_left" style="<{$leftBlocks}>; background-color:<{$lb_color}>;">
          <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625em;">:::</a>
          <{if $xoBlocks.canvas_left}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>

          <{if $xoBlocks.canvas_right}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
          <{/if}>
        </div>
      </div>

      <div id="xoops_theme_center_zone" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>
    <{else}>

      <div id="xoops_theme_center_zone" class="col-sm-<{$center_width}> col-sm-push-<{$lb_width}>" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>

      <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$lb_color}>;">
        <div id="xoops_theme_left" style="background-color:<{$lb_color}>;<{$leftBlocks}>">
          <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625em;">:::</a>
          <{if $xoBlocks.canvas_left}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>

          <{if $xoBlocks.canvas_right}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
          <{/if}>
        </div>
      </div>
    <{/if}>
  <{else}>
    <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>
  <{/if}>
  <div style="clear: both;"></div>
</div>