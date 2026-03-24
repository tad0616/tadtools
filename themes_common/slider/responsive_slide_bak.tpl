<{if $slider_var|default:false}>
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/reset.css" >
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/responsiveslides.css?t=20260115" >
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/responsiveslides.js"></script>
<script type="text/javascript" src="<{$xoops_url}>/themes_common/slider/responsive_slides_extension.js"></script>

<!-- $slide_nav=<{$slide_nav|default:''}> -->
<script type="text/javascript">
    $(document).ready(function(){
        // 全局變數存儲幻燈片狀態
        var slideshowInterval = <{if $slide_timeout|default:false}><{$slide_timeout|default:''}><{else}>5000<{/if}>;
        var isPaused = false;
        var currentSlide = 0;

        // 初始化幻燈片
        $("#ThemeResponsiveSlides").responsiveSlides({
            auto: true,
            pager: false,
            <{if $slide_nav==null || $slide_nav}>
            nav: true,
            <{else}>
            nav: false,
            <{/if}>
            timeout: slideshowInterval,
            pause: true,
            pauseControls: true,
            namespace: 'callbacks',
            before: function(idx) {
                // 追蹤當前幻燈片索引
                currentSlide = idx;
            }
        });

        // 暫停按鈕功能
        $('#pause-slideshow').on('click', function() {
            toggleSlideshow();
        });

        // 確保鍵盤可訪問性
        $('#pause-slideshow').on('keydown', function(e) {
            // 當按下 Enter 或空格鍵時觸發按鈕
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleSlideshow();
            }
        });

        // 暫停/播放功能
        function toggleSlideshow() {
            var $button = $('#pause-slideshow');

            if (isPaused) {
                // 恢復播放
                isPaused = false;
                $button.removeClass('paused')
                       .html('<i class="fa fa-pause" aria-hidden="true"></i><span class="sr-only visually-hidden">暫停輪播</span>')
                       .attr('aria-label', '暫停輪播');

                // 使用新的擴展方法恢復播放
                $("#ThemeResponsiveSlides").responsiveSlides('play');
            } else {
                // 暫停播放
                isPaused = true;
                $button.addClass('paused')
                       .html('<i class="fa fa-play" aria-hidden="true"></i><span class="sr-only visually-hidden">播放輪播</span>')
                       .attr('aria-label', '播放輪播');

                // 使用新的擴展方法暫停播放
                $("#ThemeResponsiveSlides").responsiveSlides('pause');
            }
        }
    });
</script>

<!-- 滑動圖片 -->
<div class="callbacks_container" style="position: relative;">
    <button id="pause-slideshow" class="btn btn-sm btn-light" style="position: absolute; bottom: 10px; right: 10px; z-index: 10;"
            aria-label="暫停輪播" tabindex="0" role="button">
        <i class="fa fa-pause" aria-hidden="true"></i>
        <span class="sr-only visually-hidden">暫停輪播</span>
    </button>
    <ul class="rslides" id="ThemeResponsiveSlides" style="margin-top: 0px;">
        <{foreach from=$slider_var key=i item=slide}>
        <li>
            <{if $slide.slide_url|default:false}>
                <a href="<{$slide.slide_url}>" <{$slide.slide_target}>><img src="<{$slide.file_url}>" alt="<{$slide.description|default:''}>"></a>
            <{else}>
                <img src="<{$slide.file_url}>" alt="<{$slide.description|default:''}>">
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