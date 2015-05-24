<?php
include_once "tadtools_header.php";
include_once "tad_function.php";
include_once "jquery.php";

class slider{
  var $show_jquery;
  var $word_num;
  var $item=array();

  //建構函數
  function slider($word_num=60,$show_jquery=true){
    $this->word_num = $word_num;
    $this->show_jquery = $show_jquery;
  }

  function add_content($sn="",$title="",$content="",$image="",$date="",$url="",$width="",$height=""){
    $this->item[$sn]['title']=$title;
    $this->item[$sn]['content']=$content;
    $this->item[$sn]['image']=$image;
    $this->item[$sn]['date']=$date;
    $this->item[$sn]['url']=$url;
    $this->item[$sn]['width']=$width;
    $this->item[$sn]['height']=$height;
  }

  //產生語法
  function render($id="",$margin_top=0){
    global $xoTheme;

    $randStr=randStr(6,'CHAR');
    $id="{$id}{$randStr}";

    $utf8_word_num = $this->word_num * 3;
    if(empty($utf8_word_num))$utf8_word_num=90;
    $jquery=($this->show_jquery)?get_jquery():"";

    $all=$nav="";
    $i=1;
    foreach($this->item as $sn => $item_content){
      $title=xoops_substr(strip_tags($item_content['title']), 0, 45);
      $content=xoops_substr(strip_tags($item_content['content']), 0, $utf8_word_num);

      $pi=($i%2)?"1":"2";
      $image=empty($item_content['image'])?TADTOOLS_URL."/ResponsiveSlides/images/demo{$pi}.jpg":$item_content['image'];

      $caption=($content)?"
      <div class='caption'>
        <div style='font-size:11pt;color:#33CCFF;font-weight:bold;'>{$title}</div>
          <div>{$content}</div>
      </div>
        <div class='caption_txt'>
        <div style='font-size:11pt;color:#33CCFF;font-weight:bold;'>{$title}</div>
          <div>{$content}</div>
        </div>

      ":"";

      if(strtolower(substr($image,-3))=="swf"){
        //exactfit,default
        $all.="
          <li>
          <object
          type='application/x-shockwave-flash'
          data='$image'
          width='100%'
          height='{$item_content['height']}'>
          <param name='scale' value='default'>
          <param name='movie'
          value='$image' width='100%' height='{$item_content['height']}' scale='default' />
          </object>
          $caption
          </li>
        ";
      }else{
        $alt=empty($title)?'slider image':$title;
        $show_title=empty($title)?"longdesc='{$image}'":"title='{$title}'";
        $all.="
          <li>
            <a href='{$item_content['url']}'><img src='$image' alt='{$alt}' {$show_title}></a>
            $caption
          </li>
        ";
      }

      $nav.="<li><span>{$i}</span></li>";
      $i++;
    }

    // $main="";
    // if($xoTheme){

    //   $xoTheme->addStylesheet('modules/tadtools/ResponsiveSlides/reset.css');
    //   $xoTheme->addStylesheet('modules/tadtools/ResponsiveSlides/responsiveslides.css');
    //   $xoTheme->addScript('modules/tadtools/ResponsiveSlides/responsiveslides.js');

    //   $xoTheme->addScript('', null, "
    //     (function(\$){
    //       \$(document).ready(function(){
    //         \$('#{$id}').responsiveSlides();
    //       });
    //     })(jQuery);
    //   ");

    // }else{

      $main="
      <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/ResponsiveSlides/reset.css' />
      <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/ResponsiveSlides/responsiveslides.css' />
      $jquery
      <script language='javascript' type='text/javascript' src='".TADTOOLS_URL."/ResponsiveSlides/responsiveslides.js'></script>

      <script type='text/javascript'>
       $(document).ready( function(){
          $('#{$id}').responsiveSlides({
            auto: true,
            pager: false,
            nav: true,
            speed: 800,
            pause: true,
            pauseControls: true,
            namespace: 'callbacks'
          });
        });
      </script>
      ";
    //}

    $main.="
    <div class='row callbacks'>
      <ul class='rslides' id='{$id}' style='margin-top:{$margin_top}px;'>
        $all
      </ul>
    </div>
    <div class=\"clearfix\"></div>
      ";

    return $main;
  }
}
