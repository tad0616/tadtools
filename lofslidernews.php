<?php
include_once "tadtools_header.php";
include_once "jquery.php";

class lofslidernews{
  var $show_jquery;
  var $width;
  var $height;
  var $word_num;
  var $item=array();

	//建構函數
	function lofslidernews($width='725',$height='300',$word_num=60,$show_jquery=true){
    $this->width = $width;
    $this->height = $height;
    $this->word_num = $word_num;
    $this->show_jquery = $show_jquery;
	}

  function add_content($sn="",$title="",$content="",$image="",$date="",$url=""){
    $this->item[$sn]['title']=$title;
    $this->item[$sn]['content']=$content;
    $this->item[$sn]['image']=$image;
    $this->item[$sn]['date']=$date;
    $this->item[$sn]['url']=$url;
  }

	//產生語法
	function render(){
    $utf8_word_num = $this->word_num * 3;
    if(empty($utf8_word_num))$utf8_word_num=90;
    $jquery=($this->show_jquery)?get_jquery():"";
    
    $all=$nav="";
    $i=1;
    foreach($this->item as $sn => $item_content){
      //避免截掉半個中文字
      $title=xoops_substr(strip_tags($item_content['title']), 0, 45);
      $content=xoops_substr(strip_tags($item_content['content']), 0, $utf8_word_num);
      
      $pi=($i%2)?"1":"2";
      $image=empty($item_content['image'])?TADTOOLS_URL."/lofslidernews/images/demo{$pi}.jpg":$item_content['image'];
      
      $all.="
        <li>
            <div style='background:#000000 url($image) no-repeat scroll center top; width:{$this->width}px; height:{$this->height}px;'>
            <a href='{$item_content['url']}'><img src='".TADTOOLS_URL."/lofslidernews/images/blank.gif' title='{$item_content['title']}' style='width:{$this->width}px; height:{$this->height}px;'></a>
            </div>
            <div class='slider-description'>
              <div class='slider-meta'><a target='_parent' title='{$item_content['title']}' href='{$item_content['url']}'>{$title}</a></div>
              <div class='slider-content'>$content
              <a class='readmore' href='{$item_content['url']}'>more...</a>
              </div>
           </div>
        </li>
      ";
      
      $nav.="<li><span>{$i}</span></li>";
      $i++;
    }

    $main="
    <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/lofslidernews/css/reset.css' />
    <link rel='stylesheet' type='text/css' href='".TADTOOLS_URL."/lofslidernews/css/style.css' />
    $jquery
    <script language='javascript' type='text/javascript' src='".TADTOOLS_URL."/lofslidernews/js/jquery.easing.js'></script>
    <script language='javascript' type='text/javascript' src='".TADTOOLS_URL."/lofslidernews/js/script.js'></script>
    

    <script type='text/javascript'>
     $(document).ready( function(){
    		var buttons = { previous:$('#tadnews_jslidernews .button-previous') ,
    						next:$('#tadnews_jslidernews .button-next') };
    		 \$obj = \$('#tadnews_jslidernews').lofJSidernews( { interval : 6000,
    											 	easing			: 'easeInOutQuad',
    												duration		: 1600,
    												auto		 	: true,
    												maxItemDisplay  : 5,
    												startItem:$i,
    												navPosition     : 'horizontal', // horizontal
    												navigatorHeight : null,
    												navigatorWidth  : null,
													mainWidth:{$this->width},
    												buttons:buttons} );
    	});
    </script>

    <!------------------------------------- THE CONTENT ------------------------------------------------->
    <div id='tadnews_jslidernews' class='lof-slidecontent' style='width:{$this->width}px; height:{$this->height}px;'>
      <div class='preload'><div></div></div>
      <div  class='button-previous'>Previous</div>
      <div  class='button-next'>Next</div>
      <!-- MAIN CONTENT -->
        <div class='main-slider-content' style='width:{$this->width}px; height:{$this->height}px;'>
          <ul class='sliders-wrap-inner'>
          $all
          </ul>
        </div>
     	<!-- END MAIN CONTENT -->
      <!-- NAVIGATOR -->
       	<div class='navigator-content'>
          <div class='button-control'><span></span></div>
          <div class='navigator-wrapper'>
            <ul class='navigator-wrap-inner'>
            $nav
            </ul>
          </div>
         </div>
      <!----------------- END OF NAVIGATOR --------------------->
     </div>
     <!------------------------------------- END OF THE CONTENT ------------------------------------------------->
    ";
    return $main;
  }

}
?>
