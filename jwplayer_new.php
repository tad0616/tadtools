<?php
include_once "tadtools_header.php";

class JwPlayer
{
    public $image;
    public $file;
    public $skin;
    public $width;
    public $height;
    public $mode;
    public $display;
    public $id;
    public $play_list_height;
    public $autostart;
    public $repeat;

    //建構函數
    public function __construct($id = "", $file = "", $image = "", $width = "", $height = "", $skin = "", $mode = "", $display = "", $autostart = false, $repeat = false, $other_code = "")
    {
        $this->width            = (empty($width)) ? "" : $width;
        $this->play_list_height = ($mode == "playlist" and $display == "bottom") ? $height : 0;
        $this->height           = (substr($height, -1) == "%") ? $height : 0.6;
        $this->file             = $file;
        $this->image            = $image;
        $this->skin             = (empty($skin)) ? "" : $skin;
        //$this->skin=(empty($skin))?TADTOOLS_URL."/jwplayer/skin/beelden.zip":$skin;
        $this->mode       = $mode;
        $this->display    = $display;
        $this->id         = $id;
        $this->autostart  = $autostart;
        $this->repeat     = $repeat;
        $this->other_code = $other_code;
    }

    //設定自定義設寬度
    public function setWidth($width = "")
    {
        $this->width = $width;
    }

    //設定自定義設高度
    public function setHeight($height = "")
    {
        $this->height = $height;
    }

    //設定自定義影片檔
    public function setFile($file = "")
    {
        $this->file = $file;
    }

    //設定自定義縮圖
    public function setImage($image = "")
    {
        $this->image = $image;
    }

    //設定自定佈景
    public function setSkin($skin = "")
    {
        $this->skin = $skin;
    }

    //產生播放器
    public function render()
    {
        global $xoTheme;
        $playlistfile = $playlist_setup = "";

        if ($this->mode == "playlist") {
            $file  = "playlist:'{$this->file}',";
            $image = "";

            if ($this->display == "bottom") {
                $playlist_size = $this->play_list_height;
            } else {
                $playlist_size          = "playlist_size";
                $this->play_list_height = 0;
                $this->height           = 0.5;
            }

            $playlist_setup = "
            var list = document.getElementById('jw_list');
            var html = list.innerHTML;

            playerInstance_{$this->id}.on('ready',function(){
            var playlist = playerInstance_{$this->id}.getPlaylist();
            for (var index=0;index<playlist.length;index++){
                var playindex = index +1;

                html += \"<li id='play-items-\"+index+\"' class='list-group-item' style='min-height: 70px; font-size: 11px; overflow: hidden;'><a href='javascript:playThis(\"+index+\")'><div style='width:80px;height:50px;margin-right:3px;float:left;background:url(\"+playlist[index] . image+\") center center no-repeat;background-size:cover;'></div>\"+playlist[index].title+\"</a></li>\"
                list.innerHTML = html;
            }

            });

            playerInstance_{$this->id}.on('playlistItem', function() {
                var playlist = playerInstance_{$this->id}.getPlaylist();
                var index = playerInstance_{$this->id}.getPlaylistIndex();
                var current_li = document.getElementById(\"play-items-\"+index);
                for(var i = 0; i < playlist.length; i++) {
                        $('li[id^=play-items-]').removeClass( \"active\" );
                }
                current_li.classList.add('active');
            });

            function playThis(index) {
                playerInstance_{$this->id}.playlistItem(index);
            }

            $(window).load(function() {
                $('#jw_playlist_zone_{$this->id}').css('height',$('#jw_{$this->id}').height()).css('overflow','auto');
            });

            ";
        } else {
            $file  = "file:'{$this->file}',";
            $image = "image:'{$this->image}',";
        }

        $screen_width = empty($this->width) ? "screen_width" : "'{$this->width}'";
        $rate_height  = substr($this->height, -1) == "%" ? "'{$this->height}'" : "rate_height";

        $repeat    = empty($this->repeat) ? "" : "repeat: $this->repeat,";
        $autostart = empty($this->autostart) ? "" : "autostart: $this->autostart,";

        $player = "
        <style>
        li.list-group-item >a {
            color: black;
        }
        li.active > a {
            color: white;
        }
        </style>";

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/jwplayer/jwplayer.js');
        } else {

            $player = "<script type='text/javascript' src='" . TADTOOLS_URL . "/jwplayer/jwplayer.js'></script>
            ";
        }
        $player .= "<script>jwplayer.key='oLChm0Lmsd2wPANnbFZEpiNs0zOdS8qmJNlfyA==';</script>";

        $player .= ($this->mode == "playlist") ? "
        <div id='playlist_zone_{$this->id}' class='row' style='min-height:320px;'>
            <div class='col-sm-8' id='jw_zone_{$this->id}'>
                <div id='jw_{$this->id}'>Loading the player ...</div>
            </div>
            <div class='col-sm-4' id='jw_playlist_zone_{$this->id}'>
                <ul class='list-group' id='jw_list'>

                </ul>
            </div>
        </div>
        " : "
        <div class='row' style='min-height:160px;'>
            <div class='col-sm-12'>
                <div id='jw_{$this->id}' class='embed-responsive embed-responsive-4by3'>Loading the player ...</div>
            </div>
        </div>";

        $player .= "
        <script type='text/javascript'>
            var playerInstance_{$this->id} = jwplayer('jw_{$this->id}');


            if($('#playlist_zone_{$this->id}').width() <= 640){
                $('#jw_zone_{$this->id}').removeClass('col-sm-8').addClass('col-sm-12');
                $('#jw_playlist_zone_{$this->id}').removeClass('col-sm-4').addClass('col-sm-12');
            }

            playerInstance_{$this->id}.setup({
              $file
              image:'{$this->image}',
              width: '100%',
              aspectratio: '4:3',
              $this->other_code
              $autostart
              $repeat
              skin: {
                name: 'bekle'
              }
            });

            $playlist_setup

        </script>
        ";
        return $player;

    }
}
