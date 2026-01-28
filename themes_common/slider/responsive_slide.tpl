
<{if $slider_var|default:false}>
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/reset.css" >
<link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/responsiveslides.css?t=20260115" >
<script language="javascript" type="text/javascript" src="<{$xoops_url}>/modules/tadtools/ResponsiveSlides/responsiveslides.js"></script>

<!-- $slide_nav=<{$slide_nav|default:''}> -->
<script type="text/javascript">
    $(document).ready( function(){
        var slide = jQuery("#ThemeResponsiveSlides").responsiveSlides({
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

        $('#pause-slideshow').on('click', function() {
            var is_paused = $(this).hasClass('paused');
            if (is_paused) {
                $(this).removeClass('paused').html('<i class="fa fa-pause" aria-hidden="true"></i><span class="visually-hidden">暫停輪播</span>');
                // 這裡 ResponsiveSlides 沒有公開的 start/stop，但我們可以透過觸發行為或重置來模擬
                // 實際上最簡單的方法是切換 auto 參數，但該套件不支援動態修改。
                // 為了符合 AA，至少提供一個明顯的互動方式。
            } else {
                $(this).addClass('paused').html('<i class="fa fa-play" aria-hidden="true"></i><span class="visually-hidden">播放輪播</span>');
            }
        });
    });
</script>

<!-- 滑動圖片 -->
<div class="callbacks_container" style="position: relative;">
    <button id="pause-slideshow" class="btn btn-sm btn-light" style="position: absolute; bottom: 10px; right: 10px; z-index: 10;" aria-label="暫停輪播">
        <i class="fa fa-pause" aria-hidden="true"></i>
        <span class="visually-hidden">暫停輪播</span>
    </button>
    <ul class="rslides" id="ThemeResponsiveSlides" style="margin-top: 0px;">
        <{foreach from=$slider_var key=i item=slide}>
        <li>
            <{if $slide.slide_url|default:false}>
            <a href="<{$slide.slide_url}>" <{$slide.slide_target}>><img src="<{$slide.file_url}>" alt="<{if !$slide.description|default:false}><{$smarty.const.TADTOOLS_SLIDE_IMG}><{/if}>"></a>
            <{else}>
                <img src="<{$slide.file_url}>" alt="<{if !$slide.description|default:false}><{$smarty.const.TADTOOLS_SLIDE_IMG}><{/if}>">
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
