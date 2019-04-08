<{if $xoBlocks.canvas_left}>

  <div class="leftBlock" style="<{if $leftBlocks2}><{$leftBlocks2}>;<{/if}>width:100%;">
    <{foreach item=block from=$xoBlocks.canvas_left}>
      <div class="row">
      <{if $block.content}>
        <div class="col-sm-3">
          <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/blockTitle.tpl"}>
          <div class="blockContent">
            <{$block.content}>
          </div>
        </div>
      <{/if}>
      </div>
    <{/foreach}>
  </div>
<{/if}>