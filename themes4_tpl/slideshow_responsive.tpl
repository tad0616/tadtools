<{if $use_slide|default:false}>
    <{if $logo_img and $logo_position=="slide"}>
        <div style="position:relative; width:100%;">
            <{include file="$xoops_rootpath/modules/tadtools/themes4_tpl/logo.tpl"}>
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/slider/responsive_slide.tpl"}>
        </div>
    <{else}>
        <{include file="$xoops_rootpath/modules/tadtools/themes_common/slider/responsive_slide.tpl"}>
    <{/if}>
<{/if}>