<script src="<{xoAppUrl modules/tadtools/themes_common/slider/sliderman/js/sliderman.1.3.8.js}>"></script>
<link rel="stylesheet" type="text/css" href="<{xoAppUrl modules/tadtools/themes_common/slider/sliderman/css/sliderman.css}>" />

<div style="padding:0px;margin:0px;">
    <div id="SliderName_3" class="SliderName_3" style="padding:0px;margin:0px; width: 100%;">
        <{foreach from=$slider_var item=slide}>
            <a href="<{$slide.slide_url}>" <{$slide.slide_target}>><img src="<{$slide.file_url}>" alt="<{$slide.text_description}>" title="<{$slide.text_description}>"></a>
            <div class="SliderName_3Description"><{$slide.description}></div>
        <{/foreach}>
    </div>
    <div class="c"></div>

    <script type="text/javascript">
        demo3Effect1 = {name: 'myEffect31', top: true, move: true, duration: 400};
        demo3Effect2 = {name: 'myEffect32', right: true, move: true, duration: 400};
        demo3Effect3 = {name: 'myEffect33', bottom: true, move: true, duration: 400};
        demo3Effect4 = {name: 'myEffect34', left: true, move: true, duration: 400};
        demo3Effect5 = {name: 'myEffect35', rows: 3, cols: 9, delay: 50, duration: 100, order: 'random', fade: true};
        demo3Effect6 = {name: 'myEffect36', rows: 2, cols: 4, delay: 100, duration: 400, order: 'random', fade: true, chess: true};

        effectsDemo3 = [demo3Effect1,demo3Effect2,demo3Effect3,demo3Effect4,demo3Effect5,demo3Effect6,'blinds'];

        var demoSlider_3 = Sliderman.slider({
            container: 'SliderName_3',
            width: <{$theme_width}>,
            height: 200,
            effects: effectsDemo3,
            display: {
                autoplay: 3000,
                buttons: { hide: true, opacity: 1, prev: {className: 'SliderNamePrev_3', label: ''}, next: {className: 'SliderNameNext_3', label: ''} },
                description: {background: '#000000', opacity: 0.4, height: 30, position: 'bottom'},
            }
        });
    </script>

    <div class="c"></div>
</div>