<{if $use_slide}>
  <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row"<{/if}>>
    <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="col-sm-12"<{/if}> style="position:relative;<{if $theme_kind=="html"}>width:100%px;<{/if}> ">

    <{if $logo_img and $logo_position=="slide"}>
      <{include file="$xoops_rootpath/modules/tadtools/themes3_tpl/logo.tpl"}>
    <{/if}>

    <!-- 滑動圖 -->
    <{include file="$xoops_rootpath/modules/tadtools/themes_common/slider/responsive_slide.tpl"}>
    </div>
  </div>
<{/if}>