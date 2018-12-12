<{if $slide_width > 0 }>
    <{if $logo_img and $logo_position=="slide"}>
        <div style="position:relative; width:100%; <{if $slide_height}>height:<{$slide_height}>px; overflow:hidden;<{/if}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/logo.tpl"}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/menu/responsive_slide.tpl"}>
        </div>
    <{else}>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/menu/responsive_slide.tpl"}>
    <{/if}>
<{/if}>