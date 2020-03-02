<{if $slide_width > 0 }>
  <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="row"<{/if}>>
    <div <{if $theme_kind|substr:0:9=="bootstrap"}>class="col-sm-<{$slide_width}>"<{/if}> style="position:relative;<{if $slide_height}>height:<{$slide_height}>px;overflow:hidden;<{/if}><{if $theme_kind=="html"}>width:<{$slide_width}>px;<{/if}> ">

    <{if $logo_img and $logo_position=="slide"}>
      <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/logo.tpl"}>
    <{/if}>

    <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/slider/responsive_slide.tpl"}>
    </div>
  </div>
<{/if}>