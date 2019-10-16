<?php

namespace XoopsModules\Tadtools;

class VideoJs
{
    public $image;
    public $file;
    public $mode;
    public $display;
    public $id;
    public $autostart;
    public $repeat;

    //建構函數
    public function __construct($id = '', $file = '', $image = '', $mode = '', $display = '', $autostart = false, $repeat = false, $other_code = '')
    {
        $this->file = ('playlist' === $mode) ? $file : strip_tags($file);
        $this->youtube_id = $this->getYTid($file);
        $this->image = empty($image) ? "https://i3.ytimg.com/vi/{$this->youtube_id}/0.jpg" : strip_tags($image);
        $this->mode = $mode;
        $this->display = $display;
        $this->id = $id;
        $this->autostart = $autostart;
        $this->repeat = $repeat;
        $this->other_code = $other_code;
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

    //產生播放器
    public function render()
    {
        global $xoTheme;
        $player = '
        <video
            id="' . $this->id . '"
            class="video-js vjs-fluid vjs-big-play-centered vjs-theme-fantasy">
        </video>
        ';

        if ('playlist' === $this->mode) {
            $player .= '<div class="vjs-playlist"></div>';
        }

        $playlist = $source = '';

        if ('playlist' === $this->mode) {
            $playlist = "
            var samplePlaylist ={$this->file};
            player.playlist(samplePlaylist);
            player.playlist.autoadvance(0);
            player.playlistUi();
            ";
        } elseif ($this->youtube_id) {
            $source = "
            techOrder: ['youtube'],
            sources: [
                {
                    'type': 'video/youtube',
                    'src': 'https://www.youtube.com/watch?v=" . $this->youtube_id . "'
                }
            ],";
        } else {
            $ext = substr($this->file, -3);
            if ('mp4' === $ext) {
                $type = 'video/mp4';
            } elseif ('ebm' === $ext) {
                $type = 'video/webm';
            } elseif ('mp3' === $ext) {
                $type = 'audio/mp3';
            } elseif ('ogg' === $ext) {
                $type = 'video/ogg';
            } elseif ('flv' === $ext) {
                $type = 'video/flv';
            }

            $source = "
            poster: '{$this->image}',
            sources: [
                {
                    'type': '$type',
                    'src': '{$this->file}'
                }
            ],";
        }

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/video-js/video.js');
            $xoTheme->addScript('modules/tadtools/video-js/lang/zh-TW.js');
            $xoTheme->addScript('modules/tadtools/video-js/Youtube.js');
            $xoTheme->addStylesheet('modules/tadtools/video-js/video-js.css');
            $xoTheme->addStylesheet('modules/tadtools/video-js/themes/fantasy/index.css');
            if ('playlist' === $this->mode) {
                $xoTheme->addScript('modules/tadtools/video-js/videojs-playlist.js');
                $xoTheme->addScript('modules/tadtools/video-js/videojs-playlist-ui.js');
                $xoTheme->addStylesheet('modules/tadtools/video-js/videojs-playlist-ui.vertical.css');
            }
        } else {
            $playlist_js = '';
            if ('playlist' === $this->mode) {
                $playlist_js = "
                <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-playlist-ui.vertical.css'>
                <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-playlist.js'></script><script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-playlist-ui.js'></script>";
            }
            $player .= "
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/video.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/lang/zh-TW.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/Youtube.js'></script>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/video-js.css'>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/themes/fantasy/index.css'>
            $playlist_js
            ";
        }

        $player .= "
        <script>
            var options = {
                $source
                responsive: true,
                controls:true,
                fill:true,
                liveui: true
            };
            var player = videojs('#{$this->id}', options);
            $playlist
        </script>";
        return $player;
    }

    //抓取 Youtube ID
    public function getYTid($ytURL = '')
    {
        if ('https://youtu.be/' === mb_substr($ytURL, 0, 17)) {
            return mb_substr($ytURL, 16);
        }
        if ('http://youtu.be/' === mb_substr($ytURL, 0, 16)) {
            return mb_substr($ytURL, 16);
        }
        parse_str(parse_url($ytURL, PHP_URL_QUERY), $params);

        return $params['v'];
    }
}

/*
use XoopsModules\Tadtools\JwPlayer;
$jw = new JwPlayer($id = "", $file = "", $image = "", $width = "", $height = "", $skin = "", $mode = "", $display = "", $autostart = false, $repeat = false, $other_code = "");
$player = $jw->render();
 */
