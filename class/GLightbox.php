<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class GLightbox
{
    public $name;
    public $width;
    public $height;
    public $autoSize;
    public $type;
    public $show_jquery;
    public $show_js;
    public $skin = 'fancybox2';
    public $speech = true;

    // 建構函數（參數與 FancyBox 保持一致，方便日後模組轉移）
    public function __construct($name = '', $width = '90%', $height = null, $show_jquery = false, $show_js = true)
    {
        $this->name  = $name;
        $this->width = $width;

        if (null === $height) {
            $this->autoSize = true;
            $this->height   = '90%';
        } else {
            $this->autoSize = false;
            $this->height   = $height;
        }

        $this->show_jquery = $show_jquery;
        $this->show_js     = $show_js;
    }

    public function set_type($value = '')
    {
        $this->type = $value;
    }

    // 設定外觀風格：預設 'fancybox2'（仿 FancyBox 2 外觀），亦可設為 'clean' 使用 GLightbox 原生樣式
    public function set_skin($skin = 'fancybox2')
    {
        $this->skin = $skin ?: 'fancybox2';
    }

    // 設定是否啟用圖片無障礙中文朗讀
    public function set_speech($enable = true)
    {
        $this->speech = (bool) $enable;
    }

    // 產生語法（參數與 FancyBox::render() 一致）
    public function render($reload = true, $prevent_closed_outside = false, $auto_play = false, $playSpeed = 0, $return = false)
    {
        global $xoTheme;

        $config = [
            'type'                 => (string) $this->type,
            'width'                => $this->width,
            'height'               => $this->height,
            'autoSize'             => (bool) $this->autoSize,
            'reload'               => (bool) $reload,
            'preventClosedOutside' => (bool) $prevent_closed_outside,
            'autoPlay'             => (bool) $auto_play,
            'playSpeed'            => (int) $playSpeed,
            'skin'                 => (string) $this->skin,
            'speech'               => (bool) $this->speech,
        ];

        $selector_json = json_encode((string) $this->name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $config_json   = json_encode($config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $init_script   = "window.TadGLightbox && window.TadGLightbox.bind({$selector_json}, {$config_json});";

        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme && !$return) {
            $this->addAssetsToTheme($xoTheme);
            $xoTheme->addScript('', null, $init_script);
        } else {
            $assets = $this->show_js ? $this->getAssetsHtml() : '';

            return "
            {$jquery}
            {$assets}
            <script type='text/javascript'>
            {$init_script}
            </script>
            ";
        }
    }

    // 產生表單語法（參數與 FancyBox::renderForm() 一致）
    public function renderForm($url = '', $reload = true, $prevent_closed_outside = false, $autoPlay = false, $playSpeed = 0)
    {
        global $xoTheme;

        $config = [
            'width'                => $this->width,
            'height'               => $this->height,
            'autoSize'             => (bool) $this->autoSize,
            'reload'               => (bool) $reload,
            'preventClosedOutside' => (bool) $prevent_closed_outside,
            'autoPlay'             => (bool) $autoPlay,
            'playSpeed'            => (int) $playSpeed,
            'skin'                 => (string) $this->skin,
            'speech'               => false,
        ];

        $selector_json = json_encode((string) $this->name, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $url_json      = json_encode((string) $url, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $config_json   = json_encode($config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $init_script   = "window.TadGLightbox && window.TadGLightbox.bindForm({$selector_json}, {$url_json}, {$config_json});";

        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $this->addAssetsToTheme($xoTheme);
            $xoTheme->addScript('', null, $init_script);
        } else {
            $assets = $this->show_js ? $this->getAssetsHtml() : '';

            return "
            {$jquery}
            {$assets}
            <script type='text/javascript'>
            {$init_script}
            </script>
            ";
        }
    }

    private function addAssetsToTheme($xoTheme)
    {
        $xoTheme->addStylesheet('modules/tadtools/glightbox/css/glightbox.min.css?v=3.3.1');
        $xoTheme->addStylesheet('modules/tadtools/glightbox/css/glightbox-fancybox.css?v=1.0.3');
        $xoTheme->addScript('modules/tadtools/glightbox/js/glightbox.min.js?v=3.3.1');
        $xoTheme->addScript('modules/tadtools/glightbox/js/glightbox-adapter.js?v=1.0.3');
    }

    private function getAssetsHtml()
    {
        $base = XOOPS_URL . '/modules/tadtools/glightbox';

        return "<link rel='stylesheet' href='{$base}/css/glightbox.min.css?v=3.3.1' type='text/css' media='screen' />
        <link rel='stylesheet' href='{$base}/css/glightbox-fancybox.css?v=1.0.3' type='text/css' media='screen' />
        <script type='text/javascript' src='{$base}/js/glightbox.min.js?v=3.3.1'></script>
        <script type='text/javascript' src='{$base}/js/glightbox-adapter.js?v=1.0.3'></script>";
    }
}

/*
use XoopsModules\Tadtools\GLightbox;
$glightbox = new GLightbox('.edit_dropdown');
$glightbox->render();

相容舊版連結寫法：class="edit_dropdown" rel="group"（圖） data-fancybox-type="iframe"（HTML）
或使用 GLightbox 現代寫法：class="edit_dropdown" data-gallery="group" data-type="external"
 */
