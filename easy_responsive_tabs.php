<?php
/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/easy_responsive_tabs.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/easy_responsive_tabs.php";
$responsive_tabs = new easy_responsive_tabs('#demoTab', $type = 'default, vertical, accordion', $activetab_bg = '#B5AC5F', $inactive_bg = '#E0D78C', $active_border_color = '#9C905C', $active_content_border_color = '#9C905C');
$responsive_tabs_code=$responsive_tabs->rander();
$xoopsTpl->assign('responsive_tabs_code',$responsive_tabs_code);

<div id="demoTab">
<ul class="resp-tabs-list vert">
<li> .... </li>
<li> .... </li>
<li> .... </li>
</ul>

<div class="resp-tabs-container vert">
<div> ....... </div>
<div> ....... </div>
<div> ....... </div>
</div>
</div>

 */
include_once "tadtools_header.php";
include_once "jquery.php";

class easy_responsive_tabs
{
    public $name;
    public $type                        = 'default';
    public $activetab_bg                = '#FFFFFF';
    public $inactive_bg                 = '#E0D9D9';
    public $active_border_color         = '#9C905C';
    public $active_content_border_color = '#9C905C';

    public function __construct($name = "#demoTab", $type = 'default', $activetab_bg = '#FFFFFF', $inactive_bg = '#E0D9D9', $active_border_color = '#9C905C', $active_content_border_color = '#9C905C')
    {
        $this->name                        = $name;
        $this->type                        = $type;
        $this->activetab_bg                = $activetab_bg;
        $this->inactive_bg                 = $inactive_bg;
        $this->active_border_color         = $active_border_color;
        $this->active_content_border_color = $active_content_border_color;

    }

    public function rander()
    {
        global $xoTheme;
        $jquery          = get_jquery();
        $responsive_tabs = '';
        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/Easy-Responsive-Tabs/js/easyResponsiveTabs.js');
            $xoTheme->addStylesheet('modules/tadtools/Easy-Responsive-Tabs/css/easy-responsive-tabs.css');

            $xoTheme->addScript('', null, "
                \$(document).ready(function(){
                  \$('" . $this->name . "').easyResponsiveTabs({
                        tabidentify: 'vert',
                        type: '{$this->type}', //Types: default, vertical, accordion
                        width: 'auto',
                        fit: true,
                        closed: false,
                        activate: function() {},
                        activetab_bg: '{$this->activetab_bg}',
                        inactive_bg: '{$this->inactive_bg}',
                        active_border_color: '{$this->active_border_color}',
                        active_content_border_color: '{$this->active_content_border_color}'
                    });
                });
            ");

        } else {
            $responsive_tabs = "
              {$jquery}
              <script type='text/javascript' src='" . TADTOOLS_URL . "/Easy-Responsive-Tabs/js/easyResponsiveTabs.js'></script>
              <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . TADTOOLS_URL . "/Easy-Responsive-Tabs/css/easy-responsive-tabs.css' />
              ";

            $responsive_tabs .= "
            <script>
              $(document).ready(function(){
                $('" . $this->name . "').easyResponsiveTabs({
                    tabidentify: 'vert',
                    type: '{$this->type}', //Types: default, vertical, accordion
                    width: 'auto',
                    fit: true,
                    closed: false,
                    activate: function() {},
                    activetab_bg: '{$this->activetab_bg}',
                    inactive_bg: '{$this->inactive_bg}',
                    active_border_color: '{$this->active_border_color}',
                    active_content_border_color: '{$this->active_content_border_color}'
                });
              });
            </script>
            ";
        }
        return $responsive_tabs;

    }
}
