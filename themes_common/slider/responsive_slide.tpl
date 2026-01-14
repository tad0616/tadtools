
<{if $slider_var|default:false}>
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/reset.css" >
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/responsiveslides.css" >
<script language="javascript" type="text/javascript" src="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/responsiveslides.js"></script>

<!-- $slide_nav=<{$slide_nav|default:''}> -->
<script type="text/javascript">
    $(document).ready( function(){
        jQuery("#ThemeResponsiveSlides").responsiveSlides({
            auto: true,
            pager: false,
            <{if $slide_nav==null || $slide_nav}>
            nav: true,
            <{else}>
            nav: false,
            <{/if}>
            timeout: <{if $slide_timeout|default:false}><{$slide_timeout|default:''}><{else}>5000<{/if}>,
            pause: true,
            pauseControls: true,
            namespace: 'callbacks'
        });
    });
</script>

<!-- 滑動圖片 -->
<div class="callbacks">
    <ul class="rslides" id="ThemeResponsiveSlides" style="margin-top: 0px;">
        <{foreach from=$slider_var key=i item=slide}>
        <li>
            <{if $slide.slide_url|default:false}>
            <a href="<{$slide.slide_url}>" <{$slide.slide_target}>><img src="<{$slide.file_url}>" alt="<{$smarty.const.TADTOOLS_SLIDE_IMG}> (<{$slide.original_filename}>)" title="<{$slide.description}>"></a>
            <{else}>
                <img src="<{$slide.file_url}>" alt="<{$smarty.const.TADTOOLS_SLIDE_IMG}>(<{$slide.original_filename}>)" title="<{$slide.description}>">
            <{/if}>
            <{if $slide.description|default:false}>
                <div class="caption">
                    <a href="<{$slide.slide_url}>" <{$slide.slide_target}>>
                        <div class="caption">
                            <div style="font-size:1rem;"><{$slide.description}></div>
                        </div>
                        <div class="caption_txt">
                            <div style="font-size:1rem;"><{$slide.description}></div>
                        </div>
                    </a>
                </div>
            <{/if}>
        </li>
        <{/foreach}>
    </ul>
</div>
<div class="clearfix"></div>
<{/if}>
