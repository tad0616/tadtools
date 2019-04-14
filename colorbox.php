<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/colorbox.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH."/modules/tadtools/colorbox.php";
$colorbox=new colorbox('.iframe');
$colorbox_code=$colorbox->render();
$xoopsTpl->assign('colorbox_code',$colorbox_code);
 */
require_once __DIR__ . '/tadtools_header.php';
require_once __DIR__ . '/jquery.php';

class colorbox
{
    public $name;
    public $width;
    public $height;

    //$width='auto' ,,$height='auto'
    public function __construct($name = '.iframe', $width = '80%', $height = '90%', $show_jquery = true)
    {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->show_jquery = $show_jquery;
    }

    public function render($ready_config = true)
    {
        global $xoTheme;
        $jquery = get_jquery();
        $width_setup = ('auto' === $this->width) ? '' : ", width:'" . $this->width . "'";
        $height_setup = ('auto' === $this->height) ? '' : ", height:'" . $this->height . "'";

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/colorbox/colorbox.css');
            $xoTheme->addScript('modules/tadtools/colorbox/jquery.colorbox.js');

            if ($ready_config) {
                $xoTheme->addScript('', null, "
                  (function(\$){
                    \$(document).ready(function(){
                      \$('" . $this->name . "').colorbox({iframe:true {$width_setup} {$height_setup}});
                    });
                  })(jQuery);
                ");
            }
        } else {
            $colorbox = "
              <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . TADTOOLS_URL . "/colorbox/colorbox.css'>
              {$jquery}
              <script type='text/javascript' src='" . TADTOOLS_URL . "/colorbox/jquery.colorbox.js'></script>
              ";

            if ($ready_config) {
                $colorbox .= "
                <script>
                  $(document).ready(function(){
                    $('" . $this->name . "').colorbox({iframe:true {$width_setup} {$height_setup}});
                  });
                </script>
                ";
            }

            return $colorbox;
        }
    }
}

/*
$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
$('a.gallery').colorbox({rel:'gal'});
$('a#login').colorbox();
$.colorbox({href:"thankyou.html"});
$.colorbox({html:"<h1>Welcome</h1>"});
$("a.gallery").colorbox({rel: 'gal', title: function(){
var url = $(this).attr('href');
return '<a href="' + url + '" target="_blank">Open In New Window</a>';
}});
 */
