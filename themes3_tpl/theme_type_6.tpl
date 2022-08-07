<div id="xoops_theme_content_zone" <{if $theme_kind!="html"}>class="row row-sm-eq"<{/if}> style="<{$content_zone}>">
  <!-- 若是有左、右區塊 -->
  <{if $xoBlocks.canvas_left and $xoBlocks.canvas_right}>
    <!-- 若模式是HTML -->
    <{if $theme_kind=="html"}>
      <div id="xoops_theme_left_zone" style="float:left; background-color:<{$lb_color}>;">
        <div id="xoops_theme_left" style="<{$leftBlocks}>">
          <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
        </div>
      </div>

      <div id="xoops_theme_right_zone" style=float:left; background-color:<{$rb_color}>;">
        <div id="xoops_theme_right"  style="<{$rightBlocks}>">
          <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
        </div>
      </div>

      <div id="xoops_theme_center_zone" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>
    <!-- 若模式是 BootStrap -->
    <{else}>
      <{assign var=push_width value=$lb_width+$rb_width}>
      <div id="xoops_theme_center_zone" class="col-sm-<{$center_width}> col-sm-push-<{$push_width}>" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>

      <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$lb_color}>;">
        <div id="xoops_theme_left" style="<{$leftBlocks}>">
          <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
        </div>
      </div>

      <div id="xoops_theme_right_zone" class="col-sm-<{$rb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$rb_color}>;">
        <div id="xoops_theme_right"  style="<{$rightBlocks}>">
          <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
        </div>
      </div>
    <{/if}>

  <{elseif $xoBlocks.canvas_left and !$xoBlocks.canvas_right}>

    <!-- 若模式是HTML -->
    <{if $theme_kind=="html"}>
      <div id="xoops_theme_left_zone" style="float:left; background-color:<{$lb_color}>;">

        <div id="xoops_theme_left" style="<{$leftBlocks}>">
          <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
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
    <!-- 若模式是 BootStrap -->
    <{else}>

      <div id="xoops_theme_center_zone" class="col-sm-<{$center_width}> col-sm-push-<{$lb_width}>" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>

      <div id="xoops_theme_left_zone" class="col-sm-<{$lb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$lb_color}>;">
        <div id="xoops_theme_left" style="<{$leftBlocks}>">
          <a accesskey="L" href="#xoops_theme_left_zone_key" title="<{$smarty.const._TAD_LEFT_ZONE}>" id="xoops_theme_left_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{if $xoBlocks.canvas_left}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/leftBlock.tpl"}>
          <{/if}>

          <{if $xoBlocks.canvas_right}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
          <{/if}>
        </div>
      </div>
    <{/if}>

  <{elseif !$xoBlocks.canvas_left and $xoBlocks.canvas_right}>
    <!-- 若模式是HTML -->
    <{if $theme_kind=="html"}>
      <div id="xoops_theme_right_zone" style="float:left; background-color:<{$rb_color}>;">

        <div id="xoops_theme_right" style="<{$rightBlocks}>">
          <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
        </div>
      </div>

      <div id="xoops_theme_center_zone" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>
    <!-- 若模式是 BootStrap -->
    <{else}>

      <div id="xoops_theme_center_zone" class="col-sm-<{$center_width}> col-sm-push-<{$lb_width}>" style="<{$centerBlocks}>">
        <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/centerZone.tpl"}>
      </div>

      <div id="xoops_theme_right_zone" class="col-sm-<{$lb_width}> col-sm-pull-<{$center_width}>" style="background-color:<{$rb_color}>;">
        <div id="xoops_theme_right" style="<{$rightBlocks}>">
          <a accesskey="R" href="#xoops_theme_right_zone_key" title="<{$smarty.const._TAD_RIGHT_ZONE}>" id="xoops_theme_right_zone_key" style="color: transparent; font-size: 0.625rem; position: absolute;">:::</a>
          <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/rightBlock.tpl"}>
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
