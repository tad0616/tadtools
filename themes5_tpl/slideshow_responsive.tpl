<{if $use_slide}>
    <{if $logo_img and $logo_position=="slide"}>
        <div style="position:relative; width:100%; overflow:hidden;<{/if}>">
            <{includeq file="$xoops_rootpath/modules/tadtools/themes5_tpl/logo.tpl"}>
            <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/slider/responsive_slide.tpl"}>
        </div>
    <{else}>
        <{includeq file="$xoops_rootpath/modules/tadtools/themes_common/slider/responsive_slide.tpl"}>
    <{/if}>
<{/if}>