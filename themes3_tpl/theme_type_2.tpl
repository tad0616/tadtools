<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row"<{/if}> style="<{$content_zone}>">

  <{if $xoBlocks.canvas_left or $xoBlocks.canvas_right}>

    <div id="xoops_theme_center_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$center_width}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

    <div id="xoops_theme_right_zone" class="<{if $theme_kind!="html"}>col-sm-<{/if}><{$rb_width}>" style="background-color: <{$rb_color}>; <{if $theme_kind=="html"}>float:right;<{/if}>">
      <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 10px;">:::</a>
      <div id="xoops_theme_right"  style="<{$rightBlocks}>">
        <{if $xoBlocks.canvas_left}>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
        <{/if}>

        <{if $xoBlocks.canvas_right}>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
        <{/if}>
      </div>
    </div>

  <{else}>

    <div id="xoops_theme_center_zone" class="col-sm-12" style="<{$centerBlocks}>">
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
    </div>

  <{/if}>

  <div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>