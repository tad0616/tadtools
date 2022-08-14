<link rel="stylesheet" type="text/css" media="all"  href="<{$xoops_url}>/modules/tadtools/themes_common/slider/CarouSlide/slider.css">
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/themes_common/slider/CarouSlide/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/themes_common/slider/CarouSlide/jquery.CarouSlide.js"></script>
<script type='text/javascript'>
$(function(){
    $(".s1").CarouSlide({
        animType:"slide-vertical",
        autoAnim:true,
        slideTime: <{$slide_timeout}>,
        animTime:1000,
        alwaysNext:true
    });
});
</script>

<{if $slider_var}>
    <!-- 滑動圖片 -->
    <div class="CarouSlide slider s1">
        <ul class="slider-holder">
            <{foreach from=$slider_var item=slide}>
                <li id="a<{$slide.sort}>">
                    <a href="<{$slide.slide_url}>" <{$slide.slide_target}>>
                        <img src="<{$slide.file_url}>" alt="<{$slide.text_description}>">
                    </a>
                </li>
            <{/foreach}>
        </ul>

        <ul class="slider-nav">
            <{foreach from=$slider_var item=slide}>
                <li>
                    <a href="#a<{$slide.sort}>">
                        <{$slide.text_description}><i class="fa fa-caret-left slider-arrow-left"></i>
                    </a>
                </li>
            <{/foreach}>
        </ul>
    </div>
    <!-- 滑動圖片區下方陰影 -->
    <{* <div class="slider_shadow"></div> *}>
<{/if}>