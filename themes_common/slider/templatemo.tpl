<link rel="stylesheet" type="text/css" media="all"  href="<{$xoops_url}>/modules/tadtools/themes_common/slider/templatemo/nivo-slider.css">
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/jquery/jquery-migrate-3.5.2.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/themes_common/slider/templatemo/jquery.nivo.slider.pack.js"></script>

<script type='text/javascript'>
$(function(){
    $('#nivoSlider').nivoSlider({
        pauseTime: <{$slide_timeout|default:''}>,
        <{if $slide_nav|default:false}>
        directionNav: true,
        controlNav: true,
        <{else}>
        directionNav: false,
        controlNav: false,
        <{/if}>
        boxCols: 16
    });
});
</script>

<{if $slider_var|default:false}>
    <!-- 滑動圖片 -->
    <div id="templatemo_slider">
        <div id="slider-wrapper">
            <div id="nivoSlider" class="nivoSlider">
                <{foreach from=$slider_var item=slide}>
                    <{if $slide.slide_url|default:false}>
                        <a href="<{$slide.slide_url}>" <{$slide.slide_target}>>
                            <img src="<{$slide.file_url}>" alt="Slider" title="<{$slide.description}>">
                        </a>
                    <{else}>
                        <img src="<{$slide.file_url}>" alt="Slider" title="<{$slide.description}>">
                    <{/if}>
                <{/foreach}>
            </div>
            <div id="htmlcaption" class="nivo-html-caption">
                <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.
            </div>
        </div>
    </div>
<{/if}>