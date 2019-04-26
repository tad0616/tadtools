<?php
use XoopsModules\Tadtools\Utility;

// include_once 'tadtools_header.php';
// include_once 'tad_function.php';
// include_once 'jquery.php';

class smoothslides
{
    public $show_captions;
    public $word_num;
    public $item = [];

    //建構函數
    public function __construct($word_num = 60, $show_captions = false)
    {
        $this->word_num = $word_num;
        $this->show_captions = $show_captions;
    }

    public function add_content($sn = '', $title = '', $content = '', $image = '', $date = '', $url = '', $width = '', $height = '')
    {
        $this->item[$sn]['title'] = $title;
        $this->item[$sn]['content'] = $content;
        $this->item[$sn]['image'] = $image;
        $this->item[$sn]['date'] = $date;
        $this->item[$sn]['url'] = $url;
        $this->item[$sn]['width'] = $width;
        $this->item[$sn]['height'] = $height;
    }

    //產生語法
    public function render($id = '', $margin_top = 0)
    {
        global $xoTheme;

        $randStr = Utility::randStr(6, 'CHAR');
        $id = "{$id}{$randStr}";

        $utf8_word_num = $this->word_num * 3;
        if (empty($utf8_word_num)) {
            $utf8_word_num = 90;
        }

        $show_captions = ($this->show_captions) ? 'captions:true,' : 'captions:false,';

        $all = '';
        $i = 1;
        foreach ($this->item as $sn => $item_content) {
            $title = xoops_substr(strip_tags($item_content['title']), 0, 180);
            $pi = ($i % 2) ? '1' : '2';
            $image = empty($item_content['image']) ? XOOPS_URL . "/modules/tadtools/ResponsiveSlides/images/demo{$pi}.jpg" : $item_content['image'];

            $alt = empty($title) ? 'slider image' : $title;
            $all .= "<img src='$image' alt='{$alt}' title='{$alt}'>
            ";

            $i++;
        }

        $main = "
        <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/smoothslides/css/smoothslides.theme.css' />
        <div class='smoothslides' id='myslideshow1'>
            $all
        </div>
        <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/smoothslides/js/smoothslides-2.2.1.min.js'></script>
        <script type='text/javascript'>
          $(window).load( function() {
            $('#myslideshow1').smoothSlides({
                order: 'random',
                transitionDuration:6000,
                effectDuration: 3000,
                effect: 'panUp,panDown',
                $show_captions
                navigation: false,
                matchImageSize:false
            });
          });

        </script>


        ";

        return $main;
    }
}
