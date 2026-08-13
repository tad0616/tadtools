<{if $slider_var|default:false}>
    <link rel="stylesheet" type="text/css" href="<{$xoops_url}>/modules/tadtools/tad_slide/tad-slide.css?t=20260813" >
    <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/tad_slide/tad-slide.js?t=20260813"></script>

    <div id="my-slider" class="tad-slide" <{if $slider_var|@count >1}>aria-label="圖片輪播"<{/if}>>
        <ul class="tad-slide__list">
            <{foreach from=$slider_var key=i item=slide}>
                <li class="tad-slide__item">
                     <a href="<{$slide.slide_url}>" <{$slide.slide_target}> rel="noopener noreferrer" <{if $slide.slide_title}>title="<{$slide.slide_title}>"<{/if}>>
                        <img src="<{$slide.file_url}>" alt="<{$slide.description|default:''}>" />
                    </a>
                </li>
            <{/foreach}>
        </ul>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        tadSlide('#my-slider', {
        <{if $slide_nav==null || $slide_nav}>
            navMode : 'sides',
        <{else}>
            navMode : 'none',
        <{/if}>
        navMode : 'sides',
        effect  : 'fade',
        timeout : <{if $slide_timeout|default:false}><{$slide_timeout|default:''}><{else}>5000<{/if}>,
        speed   : 600,
        });
    });
    </script>
<{/if}>