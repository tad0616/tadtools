<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class FancyBox
{
    public $name;
    public $width;
    public $height;
    public $autoSize;

    //建構函數
    public function __construct($name = '', $width = '90%', $height = null, $show_jquery = true, $show_js = true)
    {
        $this->name = $name;
        $this->width = $width;

        if (null === $height) {
            $this->autoSize = 'true';
            $this->height = '90%';
        } else {
            $this->autoSize = 'false';
            $this->height = $height;
        }

        $this->show_jquery = $show_jquery;
        $this->show_js = $show_js;
    }

    //產生語法
    public function render($reload = true, $prevent_closed_outside = false, $auto_play = false, $playSpeed = 0)
    {
        global $xoTheme;

        $reload_code = $reload ? ',
        afterClose  :function () {
            window.location.reload();
        }' : '';

        $prevent_closed_outside_code = $prevent_closed_outside ? ',
        helpers   : {
            overlay : {closeClick: false}
        }' : '';

        $autoPlay = $auto_play ? 'autoPlay: true,' : '';
        $playSpeed = $playSpeed ? "playSpeed: {$playSpeed}," : '';

        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/fancyBox/lib/jquery.mousewheel.pack.js');
            $xoTheme->addScript('modules/tadtools/fancyBox/source/jquery.fancybox.js');
            $xoTheme->addStylesheet('modules/tadtools/fancyBox/source/jquery.fancybox.css');

            $xoTheme->addScript('', null, "
                jQuery(document).ready(function(){
                    \$('{$this->name}').fancybox({
                    fitToView : true,
                    width   : '{$this->width}',
                    height    : '{$this->height}',
                    {$autoPlay}
                    {$playSpeed}
                    autoSize  : {$this->autoSize},
                    closeClick  : false,
                    openEffect  : 'none',
                    closeEffect : 'none'
                    {$reload_code}
                    {$prevent_closed_outside_code}
                    });
                });
            ");
        } else {
            $js = $this->show_js ? "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/lib/jquery.mousewheel.pack.js'></script>
            <script type='text/javascript' language='javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/jquery.fancybox.js'></script>
            <link rel='stylesheet' href='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/jquery.fancybox.css' type='text/css' media='screen' />" : '';

            $fancybox = "
            {$jquery}
            {$js}
            <script type='text/javascript'>
            $(document).ready(function(){
                $('{$this->name}').fancybox({
                    fitToView : true,
                    width   : '{$this->width}',
                    height    : '{$this->height}',
                    {$autoPlay}
                    {$playSpeed}
                    autoSize  : {$this->autoSize},
                    closeClick  : false,
                    openEffect  : 'none',
                    closeEffect : 'none'
                    {$reload_code}
                    {$prevent_closed_outside_code}
                });
            });
            </script>
            ";

            return $fancybox;
        }
    }

    //產生表單語法
    public function renderForm($url = '', $reload = true, $prevent_closed_outside = false, $autoPlay = false, $playSpeed = 0)
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        $reload_code = $reload ? ',
        afterClose  :function () {
            window.location.reload();
        }' : '';

        $prevent_closed_outside_code = $prevent_closed_outside ? ',
        helpers   : {
            overlay : {closeClick: false}
        }' : '';

        $autoPlay = $autoPlay ? 'autoPlay: true,' : '';
        $playSpeed = $playSpeed ? "playSpeed: {$playSpeed}," : '';

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js');
            $xoTheme->addScript('modules/tadtools/fancyBox/source/jquery.fancybox.js?v=2.1.4');
            $xoTheme->addStylesheet('modules/tadtools/fancyBox/source/jquery.fancybox.css?v=2.1.4');
            $xoTheme->addStylesheet('modules/tadtools/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5');
            $xoTheme->addScript('modules/tadtools/fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5');
            $xoTheme->addStylesheet('modules/tadtools/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');
            $xoTheme->addScript('modules/tadtools/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7');
            $xoTheme->addScript('modules/tadtools/fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.5');

            $xoTheme->addScript('', null, "
                (function(\$){
                \$(document).ready(function(){
                    \$('{$this->name}').bind('submit', function() {
                    \$.ajax({
                        type        : 'POST',
                        cache       : false,
                        url         : '{$url}',
                        data        : \$(this).serializeArray(),
                        success: function(data) {
                        \$.fancybox({
                            fitToView : true,
                            width   : '{$this->width}',
                            height    : '{$this->height}',
                            {$autoPlay}
                            {$playSpeed}
                            autoSize  : {$this->autoSize},
                            closeClick  : false,
                            openEffect  : 'none',
                            closeEffect : 'none',
                            content : data
                            {$reload_code}
                            {$prevent_closed_outside_code}
                        });
                        }
                    });

                    return false;
                    });
                });
                })(jQuery);
            ");
        } else {
            $js = $this->show_js ? "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
            <script type='text/javascript' language='javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/jquery.fancybox.js?v=2.1.4'></script>
            <link rel='stylesheet' href='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/jquery.fancybox.css?v=2.1.4' type='text/css' media='screen' />
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5' />
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7' />
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.5'></script>" : '';

            $fancybox = "
            {$jquery}
            {$js}
            <script type='text/javascript'>
            $(document).ready(function(){
                $('{$this->name}').bind('submit', function() {
                    $.ajax({
                    type        : 'POST',
                    cache       : false,
                    url         : '{$url}',
                    data        : $(this).serializeArray(),
                    success: function(data) {
                        $.fancybox({
                        fitToView : true,
                        width   : '{$this->width}',
                        height    : '{$this->height}',
                        {$autoPlay}
                        {$playSpeed}
                        autoSize  : {$this->autoSize},
                        closeClick  : false,
                        openEffect  : 'none',
                        closeEffect : 'none',
                        content : data
                        {$reload_code}
                        {$prevent_closed_outside_code}
                        });
                    }
                    });

                    return false;
                });
            });
            </script>
            ";

            return $fancybox;
        }
    }
}

/*
use XoopsModules\Tadtools\FancyBox;
$fancybox=new FancyBox('.edit_dropdown');
$fancybox->render();

加在連結中：class="edit_dropdown" rel="group"（圖） data-fancybox-type="iframe"（HTML）
 */
