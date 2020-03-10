<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class FlexSlider
{
    public $show_jquery;
    public $word_num;
    public $item = [];

    //建構函數
    public function __construct($word_num = 60, $show_jquery = true)
    {
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

        $jquery = $this->show_jquery ? Utility::get_jquery() : '';
        $js = '';
        // if ($xoTheme) {
        //     $xoTheme->addStylesheet('modules/tadtools/flexslider2/reset.css');
        //     $xoTheme->addStylesheet('modules/tadtools/flexslider2/flexslider.css');
        //     $xoTheme->addScript('modules/tadtools/flexslider2/jquery.flexslider.js');
        //     $xoTheme->addScript('', null, "
        //         \$(document).ready(function(){
        //             \$('.flexslider').flexslider({
        //                 animation: 'slide'
        //             });
        //         });
        //     ");
        // } else {
        $js = "
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/flexslider2/reset.css' />
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/flexslider2/flexslider.css' />
            $jquery
            <script language='javascript' type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/flexslider2/jquery.flexslider.js'></script>


            <script type='text/javascript'>
                $(document).ready( function(){
                    $('.flexslider').flexslider({
                        animation: 'slide'
                    });
                });
            </script>";
        // }

        $utf8_word_num = $this->word_num * 3;
        if (empty($utf8_word_num)) {
            $utf8_word_num = 90;
        }

        $all = $nav = '';
        $i = 1;
        foreach ($this->item as $sn => $item_content) {
            //避免截掉半個中文字
            $title = xoops_substr(strip_tags($item_content['title']), 0, 45);
            $content = xoops_substr(strip_tags($item_content['content']), 0, $utf8_word_num);

            $pi = ($i % 2) ? '1' : '2';
            $image = empty($item_content['image']) ? XOOPS_URL . "/modules/tadtools/flexslider2/images/demo{$pi}.jpg" : $item_content['image'];

            $title_caption = !empty($title) ? "<span style='font-size: 0.92em;background-color:#404040;color:#33CCFF;font-weight:bold;'>$title</span>" : '';
            $content_caption = !empty($content) ? "<span style='font-size: 0.6875em;'>$content</span>" : '';
            $caption = (empty($title_caption) and empty($content_caption)) ? '' : "<p class='flex-caption'>{$title_caption}.{$content_caption}</p>";

            $all .= "
                <li>
                    <a href='{$item_content['url']}'><img src='$image' alt='{$title}' title='{$title}'></a>
                    $caption
                </li>
            ";

            $nav .= "<li><span>{$i}</span></li>";
            $i++;
        }

        $main = "
        $js
        <!-- Place somewhere in the <body> of your page -->
        <div class='flexslider'>
            <ul class='slides'>
                $all
            </ul>
        </div>
        ";
        return $main;
    }
}
/*
use XoopsModules\Tadtools\FlexSlider;

$FlexSlider = new FlexSlider($word_num = 60, $show_jquery = true);
foreach ($all as $data) {
$FlexSlider->add_content($data['nsn'], $data['news_title'], $data['content'], $data['image'], $data['post_date'], $data['link']);
}
$SliderNews = $FlexSlider->render();

 */
