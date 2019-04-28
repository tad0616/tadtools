<?php
<<<<<<< HEAD
require_once __DIR__ . '/tadtools_header.php';
require_once __DIR__ . '/jquery.php';
=======

use XoopsModules\Tadtools\Utility;

// include_once 'tadtools_header.php';
// include_once 'jquery.php';
>>>>>>> 4ddaa3b251df83da3ffbccbcc6ff13804520661b

class flexslider
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

        $utf8_word_num = $this->word_num * 3;
        if (empty($utf8_word_num)) {
            $utf8_word_num = 90;
        }

        $jquery = ($this->show_jquery) ? Utility::get_jquery() : '';

        $all = $nav = '';
        $i = 1;
        foreach ($this->item as $sn => $item_content) {
            //避免截掉半個中文字
            $title = xoops_substr(strip_tags($item_content['title']), 0, 45);
            $content = xoops_substr(strip_tags($item_content['content']), 0, $utf8_word_num);

            $pi = ($i % 2) ? '1' : '2';
            $image = empty($item_content['image']) ? XOOPS_URL . "/modules/tadtools/flexslider2/images/demo{$pi}.jpg" : $item_content['image'];

            $all .= "
        <li>
          <a href='{$item_content['url']}'><img src='$image' alt='{$title}' title='{$title}'></a>
          <div class='flex-caption'><div style='font-size:11pt;background-color:#404040;color:#33CCFF;font-weight:bold;'>$title</div><div style='font-size:11px;'>$content</div></div>
        </li>
      ";

            $nav .= "<li><span>{$i}</span></li>";
            $i++;
        }

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/flexslider2/reset.css');
            $xoTheme->addStylesheet('modules/tadtools/flexslider2/flexslider.css');
            $xoTheme->addScript('modules/tadtools/flexslider2/jquery.flexslider.js');

            $xoTheme->addScript('', null, "
        (function(\$){
          \$(document).ready(function(){
            \$('.flexslider').flexslider({
              animation: 'slide'
            });
          });
        })(jQuery);
      ");
            $main = '';
        } else {
            $main = "
<<<<<<< HEAD
      <link rel='stylesheet' type='text/css' href='" . TADTOOLS_URL . "/flexslider2/reset.css'>
      <link rel='stylesheet' type='text/css' href='" . TADTOOLS_URL . "/flexslider2/flexslider.css'>
=======
      <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/flexslider2/reset.css' />
      <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/flexslider2/flexslider.css' />
>>>>>>> 4ddaa3b251df83da3ffbccbcc6ff13804520661b
      $jquery
      <script language='javascript' type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/flexslider2/jquery.flexslider.js'></script>


      <script type='text/javascript'>
       $(document).ready( function(){
          $('.flexslider').flexslider({
            animation: 'slide'
          });
        });
      </script>";
        }

        $main .= "
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
