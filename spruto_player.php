<?php
// require_once __DIR__ . '/tadtools_header.php';

class spruto_player
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
    public function __construct($id = '', $file = '', $image = '', $width = '', $height = '', $skin = '', $mode = '', $display = '', $autostart = false, $repeat = false, $other_code = '')
    {
        $this->width = (empty($width)) ? '' : $width;
        $this->play_list_height = ('playlist' === $mode and 'bottom' === $display) ? $height : 0;
        $this->height = ('%' === mb_substr($height, -1)) ? $height : 0.6;
        $this->file = $file;
        $this->image = $image;
        $this->skin = (empty($skin)) ? '' : $skin;
        //$this->skin=(empty($skin))?TADTOOLS_URL."/jwplayer/skin/beelden.zip":$skin;
        $this->mode = $mode;
        $this->display = $display;
        $this->id = $id;
        $this->autostart = $autostart;
        $this->repeat = $repeat;
        $this->other_code = $other_code;
    }

    //設定自定義設寬度
    public function setWidth($width = '')
    {
        $this->width = $width;
    }

    //設定自定義設高度
    public function setHeight($height = '')
    {
        $this->height = $height;
    }

    //設定自定義影片檔
    public function setFile($file = '')
    {
        $this->file = $file;
    }

    //設定自定義縮圖
    public function setImage($image = '')
    {
        $this->image = $image;
    }

    //設定自定佈景
    public function setSkin($skin = '')
    {
        $this->skin = $skin;
    }

    //產生播放器
    public function render()
    {
        global $xoTheme;
        $playlistfile = $playlist_setup = '';

        if ('playlist' === $this->mode) {
            $file = "playlist:'{$this->file}',";
            $image = '';

            if ('bottom' === $this->display) {
                $playlist_size = $this->play_list_height;
            } else {
                $playlist_size = 'playlist_size';
                $this->play_list_height = 0;
                $this->height = 0.5;
            }

            $playlist_setup = "
              listbar: {
                position: '{$this->display}',
                size: {$playlist_size}
              },
              ";
        } elseif ('youtube' === $this->mode) {
            $file = "
                'UserID':'FqVJ7iYqUESxz-xTdKMihw2',
                'AlbumID':19209,
                'VideoID':185326,
                ";
            $image = "image:'{$this->image}',";

//             stdClass::__set_state(array(
            //    'author_url' => 'https://www.youtube.com/user/shakiraVEVO',
            //    'thumbnail_width' => 480,
            //    'author_name' => 'shakiraVEVO',
            //    'height' => 270,
            //    'title' => 'Shakira - Waka Waka (This Time for Africa) (The Official 2010 FIFA World Cup�� Song)',
            //    'width' => 480,
            //    'version' => '1.0',
            //    'provider_name' => 'YouTube',
            //    'html' => '<iframe width="480" height="270" src="https://www.youtube.com/embed/pRpeEdMmmQ0?feature=oembed" frameborder="0" allowfullscreen></iframe>',
            //    'provider_url' => 'https://www.youtube.com/',
            //    'thumbnail_url' => 'https://i.ytimg.com/vi/pRpeEdMmmQ0/hqdefault.jpg',
            //    'type' => 'video',
            //    'thumbnail_height' => 360,
            // ))
        } else {
            $file = "VideoURL:'{$this->file}',";
            $image = "image:'{$this->image}',";
        }

        $screen_width = empty($this->width) ? 'screen_width' : "'{$this->width}'";
        $rate_height = '%' === mb_substr($this->height, -1) ? "'{$this->height}'" : 'rate_height';

        $repeat = empty($this->repeat) ? '' : "repeat: $this->repeat,";
        $autostart = empty($this->autostart) ? '' : "autostart: $this->autostart,";

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/spruto_player/player.js');
            $player = '';
        } else {
            $player = "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/spruto_player/player.js'></script>
            ";
        }

        $player .= "
        <script class='splayer'>
        var params = {
            'Language': 'en',
            $file


            'Width': {$screen_width},
            'Height': {$rate_height},
            'ColorScheme': 'light',
            'Autoplay': false
        }; player.embed(params);
        </script>

        ";

        return $player;
    }
}
