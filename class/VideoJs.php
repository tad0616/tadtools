<?php

namespace XoopsModules\Tadtools;

class VideoJs
{
    public $image;
    public $file;
    public $mode;
    public $id;
    public $autoplay;
    public $loop;
    public $position;
    public $start;
    public $vtt;
    public $youtube_id;
    public $player;

    //建構函數
    public function __construct($id = '', $file = '', $image = '', $mode = '', $autoplay = 'false', $loop = 'false', $position = 'bottom')
    {
        $this->file       = ('playlist' === $mode) ? $file : strip_tags($file);
        $this->youtube_id = $this->getYTid($file);
        $this->image      = empty($image) ? "https://i3.ytimg.com/vi/{$this->youtube_id}/0.jpg" : strip_tags($image);
        $this->mode       = $mode;
        $this->id         = \str_replace('#', '', $id);
        $this->player     = 'player_' . $this->id;
        $this->autoplay   = $autoplay !== 'true' ? 'false' : 'true';
        $this->loop       = $loop !== 'true' ? 'false' : 'true';
        $this->position   = $position !== 'right' ? 'bottom' : 'right';
    }

    //設定變數
    public function set_var($name = '', $val = '')
    {
        $this->$name = $val;
    }

    //取得變數
    public function get_var($name = '')
    {
        return $this->$name;
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
    // $length['col_name'] = $tbsn;
    // $length['col_sn'] = $tbdsn;
    // $log['col_name'] = $xoopsUser ? $xoopsUser->uid : 0;
    // $log['col_sn'] = $tbdsn;
    public function render($module_dirname = '', $ajax_file = '', $length = [], $log = [])
    {
        global $xoTheme;

        $vtt = !empty($this->vtt) ? '<track kind="captions" src="' . $this->vtt . '" srclang="zh-TW" label="正體中文" default>' : '';

        $poster = '';
        if (empty($this->start)) {
            $poster = 'poster="' . $this->image . '"';
        }

        $player = '
        <video
            id="' . $this->id . '"  ' . $poster . '
            class="video-js vjs-fluid vjs-big-play-centered vjs-theme-fantasy" controls>
            ' . $vtt . '
        </video>
        <div id="' . $this->id . 'timer" style="color: transparent"></div>
        ';

        if ('playlist' === $this->mode) {
            if ($this->position == 'right') {
                $player = '
                <div class="row">
                    <div class="col-sm-8">
                        ' . $player . '
                    </div>
                    <div class="col-sm-4 ' . $this->id . '">
                        <div class="vjs-playlist"></div>
                    </div>
                </div>
                ';
            } else {
                $player .= '<div class="vjs-playlist"></div>';
            }
        }

        $playlist = $source = '';

        if ('playlist' === $this->mode) {
            $playlist = "
            var samplePlaylist ={$this->file};
            " . $this->player . ".playlist(samplePlaylist);
            " . $this->player . ".playlist.autoadvance(0);
            " . $this->player . ".playlistUi();
            ";

            if ($this->position == 'right') {
                $playlist .= "
                $(document).ready(function(){
                    var h=$('" . $this->id . ">.vjs-poster').height();
                    console.log('h:'+h);
                    $('." . $this->id . ">.vjs-playlist').css('max-height', h).css('overflow', 'auto');
                });
                ";
            }
        } elseif ($this->youtube_id) {
            $source = "techOrder: ['youtube'],
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
                $type = 'video/x-flv';
            }

            $source = "
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
            $xoTheme->addScript('modules/tadtools/video-js/videojs-flash.min.js');
            // $xoTheme->addScript('modules/tadtools/video-js/flv.js');
            // $xoTheme->addScript('modules/tadtools/video-js/videojs-flvjs.min.js');
            $xoTheme->addStylesheet('modules/tadtools/video-js/video-js.css?v=' . time());
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
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-flash.min.js'></script>
            // <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/flv.js'></script>
            // <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/video-js/videojs-flvjs.min.js'></script>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/video-js.css'>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/video-js/themes/fantasy/index.css'>
            $playlist_js
            ";
        }

        $video_log = '';
        if ($module_dirname) {
            $video_log = "
            " . $this->player . ".on('loadedmetadata',function(){
                console.log('影片長度'+ " . $this->player . ".duration());
                $.post('$ajax_file', { op:'video_length', mod: '$module_dirname', col_name: '{$length['col_name']}', col_sn: '{$length['col_sn']}', length: " . $this->player . ".duration()} );
            });

            " . $this->player . ".on('pause',()=>{
                console.log('暫停影片'+ " . $this->player . ".currentTime());
                $.post('$ajax_file', { op:'video_log', mod: '$module_dirname', col_name: '{$log['col_name']}', col_sn: '{$log['col_sn']}', time: " . $this->player . ".currentTime()} );
            });

            " . $this->player . ".on('ended',()=>{
                console.log('影片結束'+ " . $this->player . ".currentTime());
                $.post('$ajax_file', { op:'video_log', mod: '$module_dirname', col_name: '{$log['col_name']}', col_sn: '{$log['col_sn']}', time: " . $this->player . ".currentTime()} );
            });
            ";
        }

        $start_form = '';
        if ($this->start > 0) {
            $start_form = "
            console.log('從這裡開始播放'+ $this->start);
            " . $this->player . ".currentTime($this->start);
            ";
        }

        $player .= "
        <script>
            const {$this->id}_options = {
                preload: 'auto',
                $source
                controls: true,
                fluid: true,
                fill: true,
                responsive: true,
                loop: {$this->loop},
                autoplay: {$this->autoplay},
                language: 'zh-TW',
                controlBar:{
                    children: [
                        {name: 'PlayToggle'},
                        {name: 'progressControl'},
                        {name: 'SubsCapsButton'},
                        {
                            name: 'playbackRateMenuButton',
                            'playbackRates': [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2]
                        },
                        {
                            name: 'volumePanel',
                            inline: false,
                        },
                        {name: 'FullscreenToggle'}
                    ]
                },
                liveui: true
            };

            const  " . $this->player . " = videojs('{$this->id}', {$this->id}_options);

            " . $this->player . ".ready(function () {
                " . $this->player . ".on('timeupdate', function() {
                    const current = " . $this->player . ".currentTime();
                    document.getElementById('" . $this->id . "timer').textContent = current.toFixed(1);
                });
            });
            $start_form
            $playlist
            $video_log
        </script>
        ";
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
        if (isset($params['v'])) {
            return $params['v'];
        }
    }
}

/*
use XoopsModules\Tadtools\VideoJs;
$VideoJs = new VideoJs($id_name, $media, $image, $mode, $autoplay, $loop, $other_code);
$player = $VideoJs->render();
 */
