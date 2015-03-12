<?php
include_once "tadtools_header.php";

class JwPlayer{
  var $image;
  var $file;
  var $skin;
  var $width;
  var $height;
  var $mode;
  var $display;
  var $backcolor;
  var $frontcolor;
  var $lightcolor;
  var $screencolor;
  var $id;
  var $play_list_height;

  //建構函數
  function JwPlayer($id="",$file="",$image="",$width="",$height="",$skin="",$mode="",$display="",$backcolor="",$frontcolor="",$lightcolor="",$screencolor="",$other_code=""){
    $this->width=(empty($width))?"":$width;
    $this->play_list_height=($mode=="playlist" and $display=="bottom")?$height:0;
    $this->height=(substr($height,-1)=="%")?$height:0.6;
    $this->file=$file;
    $this->image=$image;
    $this->skin=(empty($skin))?TADTOOLS_URL."/mediaplayer/skin/glow.zip":$skin;
    //$this->skin=(empty($skin))?TADTOOLS_URL."/mediaplayer/skin/beelden.zip":$skin;
    $this->mode=$mode;
    $this->display=$display;
    $this->backcolor=$backcolor;
    $this->frontcolor=$frontcolor;
    $this->lightcolor=$lightcolor;
    $this->screencolor=$screencolor;
    $this->id=$id;
    $this->other_code=$other_code;
  }

  //設定自定義設寬度
  function setWidth($width=""){
    $this->width=$width;
  }

  //設定自定義設高度
  function setHeight($height=""){
    $this->height=$height;
  }

  //設定自定義影片檔
  function setFile($file=""){
    $this->file=$file;
  }

  //設定自定義縮圖
  function setImage($image=""){
    $this->image=$image;
  }

  //設定自定佈景
  function setSkin($skin=""){
    $this->skin=$skin;
  }

  //產生播放器
  function render(){
    global $xoTheme;
    $playlistfile=$playlist_setup="";
    if($this->mode=="playlist"){
      $file="
      playlistfile:'{$this->file}',
      repeat:'list',";

      if($this->display=="bottom"){
        $playlist_size=$this->play_list_height;
      }else{
        $playlist_size="playlist_size";
        $this->play_list_height=0;
        $this->height=0.5;
      }

      $playlist_setup = "
      'playlist.position': '{$this->display}',
      'playlist.size': {$playlist_size},
      ";

    }else{
      $file="file:'{$this->file}',";
    }

    $backcolor=$frontcolor=$lightcolor=$screencolor="";
    if($this->backcolor)  $backcolor="backcolor:'{$this->backcolor}',";
    if($this->frontcolor)  $frontcolor="frontcolor:'{$this->frontcolor}',";
    if($this->lightcolor)  $lightcolor="lightcolor:'{$this->lightcolor}',";
    if($this->screencolor)  $screencolor="screencolor: '{$this->screencolor}',";

    $screen_width=empty($this->width)?"screen_width":"'{$this->width}'";
    $rate_height=substr($this->height,-1)=="%"?"'{$this->height}'":"rate_height";

    if($xoTheme){
      $xoTheme->addScript('modules/tadtools/mediaplayer/jwplayer.js');

      $player="";
    }else{

      $player="<script type='text/javascript' src='".TADTOOLS_URL."/mediaplayer/jwplayer.js'></script>";
    }

    $player.="
    <div id='mediaspace{$this->id}'>Loading the player ...</div>
    <script type='text/javascript'>
      var screen_width= $('#mediaspace{$this->id}').width();
      var rate_height= screen_width * {$this->height} + {$this->play_list_height} ;

      var playlist_size=screen_width * 0.25;

      jwplayer('mediaspace{$this->id}').setup({
        'modes': [
          { type: 'html5' } ,
          { type: 'flash', src: '".TADTOOLS_URL."/mediaplayer/player.swf' }
        ],
        $file
        $playlist_setup
        image:'{$this->image}',
        width: $screen_width,
        height: $rate_height,
        skin: '{$this->skin}',
        $backcolor
        $frontcolor
        $lightcolor
        $screencolor
        plugins: {
          viral: { onpause: 'false' ,oncomplete:'false', functions:'embed' },
          'hd-2': {state : true}
        },
        $this->other_code
        stretching: 'uniform',
        autostart: 'false'
      });
    </script>
    ";

    return $player;
  }
}
?>
