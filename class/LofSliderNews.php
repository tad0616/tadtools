<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class LofSliderNews
{
    public $show_jquery;
    public $width;
    public $height;
    public $word_num;
    public $item = [];

    //建構函數
    public function __construct($width = '725', $height = '300', $word_num = 60, $show_jquery = true)
    {
        $this->width = $width;
        $this->height = $height;
        $this->word_num = $word_num;
        $this->show_jquery = $show_jquery;
    }

    public function add_content($sn = '', $title = '', $content = '', $image = '', $date = '', $url = '')
    {
        $this->item[$sn]['title'] = $title;
        $this->item[$sn]['content'] = $content;
        $this->item[$sn]['image'] = $image;
        $this->item[$sn]['date'] = $date;
        $this->item[$sn]['url'] = $url;
    }

    //產生語法
    public function render()
    {
        global $xoTheme;

        $randStr = Utility::randStr();
        $utf8_word_num = $this->word_num * 3;
        if (empty($utf8_word_num)) {
            $utf8_word_num = 90;
        }

        $jquery = ($this->show_jquery) ? Utility::get_jquery() : '';

        $all = $nav = '';
        $i = 1;

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/lofslidernews/css/reset.css');
            $xoTheme->addStylesheet('modules/tadtools/lofslidernews/css/style.css');
            $xoTheme->addScript('modules/tadtools/lofslidernews/js/script.js');

            $xoTheme->addScript('', null, "
                (function(\$){
                \$(document).ready(function(){
                    var buttons = { previous:$('#jslidernews_{$randStr} .button-previous') ,
                    next:$('#jslidernews_{$randStr} .button-next') };
                    \$obj = \$('#jslidernews_{$randStr}').lofJSidernews( {
                        interval : 6000,
                        easing      : 'easeInOutQuad',
                        duration    : 1600,
                        auto      : true,
                        maxItemDisplay  : 5,
                        startItem:$i,
                        navPosition     : 'horizontal', // horizontal
                        navigatorHeight : null,
                        navigatorWidth  : null,
                        mainWidth:{$this->width},
                        buttons:buttons} );
                });
                })(jQuery);
            ");
            $main = '';
        } else {
            $main = "
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/lofslidernews/css/reset.css' >
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/lofslidernews/css/style.css' >
            $jquery
            <script language='javascript' type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/lofslidernews/js/script.js'></script>

            <script type='text/javascript'>
            $(document).ready( function(){
                var buttons = { previous:$('#jslidernews_{$randStr} .button-previous') ,
                    next:$('#jslidernews_{$randStr} .button-next') };
                    \$obj = \$('#jslidernews_{$randStr}').lofJSidernews( {
                    interval : 6000,
                    easing      : 'easeInOutQuad',
                    duration    : 1600,
                    auto      : true,
                    maxItemDisplay  : 5,
                    startItem:$i,
                    navPosition     : 'horizontal', // horizontal
                    navigatorHeight : null,
                    navigatorWidth  : null,
                    mainWidth:{$this->width},
                    buttons:buttons} );
                });
            </script>
            ";
        }

        foreach ($this->item as $sn => $item_content) {
            //避免截掉半個中文字
            $title = xoops_substr(strip_tags($item_content['title']), 0, 45);
            $content = xoops_substr(strip_tags($item_content['content']), 0, $utf8_word_num);

            $pi = ($i % 2) ? '1' : '2';
            $image = empty($item_content['image']) ? XOOPS_URL . "/modules/tadtools/lofslidernews/images/demo{$pi}.jpg" : $item_content['image'];

            $all .= "
            <li>
                <div style='background:#000000 url($image) no-repeat scroll center top; width:{$this->width}px; height:{$this->height}px;'>
                <a href='{$item_content['url']}'><img src='" . XOOPS_URL . "/modules/tadtools/lofslidernews/images/blank.gif' title='{$item_content['title']}' alt='{$item_content['title']}' style='width:{$this->width}px; height:{$this->height}px;'></a>
                </div>
                <div class='slider-description'>
                    <div class='slider-meta'><a target='_parent' title='{$item_content['title']}' href='{$item_content['url']}'>{$title}</a></div>
                    <div class='slider-content'>
                    $content
                    <a class='readmore' href='{$item_content['url']}'>more...</a>
                    </div>
                </div>
            </li>
        ";

            $nav .= "<li><span>{$i}</span></li>";
            $i++;
        }

        $main .= "
        <div id='jslidernews_{$randStr}' class='lof-slidecontent' style='width:{$this->width}px; height:{$this->height}px;'>
            <div class='preload'><div></div></div>
            <div class='button-previous'>Previous</div>
            <div class='button-next'>Next</div>
                <div class='main-slider-content' style='width:{$this->width}px; height:{$this->height}px;'>
                    <ul class='sliders-wrap-inner'>
                    $all
                    </ul>
                </div>
                <div class='navigator-content'>
                    <div class='button-control'><span></span></div>
                    <div class='navigator-wrapper'>
                        <ul class='navigator-wrap-inner'>
                        $nav
                        </ul>
                    </div>
                </div>
        </div>
        ";

        return $main;
    }
}
/*
use XoopsModules\Tadtools\LofSliderNews;

$LofSliderNews = new LofSliderNews($width = '725', $height = '300', $word_num = 60, $show_jquery = true);
foreach ($all as $data) {
$LofSliderNews->add_content($data['nsn'], $data['news_title'], $data['content'], $data['image'], $data['post_date'], $data['link']);
}
$SliderNews = $LofSliderNews->render();

 */
