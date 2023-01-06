<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class EasyResponsiveTabs
{
    public $name;
    public $type = 'default';
    public $activetab_bg = '#FFFFFF';
    public $inactive_bg = '#E0D9D9';
    public $active_border_color = '#9C905C';
    public $active_content_border_color = '#9C905C';

    public function __construct($name = '#demoTab', $type = 'default', $activetab_bg = '#FFFFFF', $inactive_bg = '#E0D9D9', $active_border_color = '#9C905C', $active_content_border_color = '#9C905C')
    {
        $this->name = $name;
        $this->type = $type;
        $this->activetab_bg = $activetab_bg;
        $this->inactive_bg = $inactive_bg;
        $this->active_border_color = $active_border_color;
        $this->active_content_border_color = $active_content_border_color;
    }

    public function rander($tabidentify = 'vert', $function = '')
    {
        global $xoTheme;
        $jquery = Utility::get_jquery();
        $responsive_tabs = '';
        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/Easy-Responsive-Tabs/js/easyResponsiveTabs.js');
            $xoTheme->addScript('modules/tadtools/jqueryCookie/js.cookie.min.js');
            $xoTheme->addStylesheet('modules/tadtools/Easy-Responsive-Tabs/css/easy-responsive-tabs.css');
            $cookie_name = mb_substr($this->name, 1) . '_baseURI';
            $xoTheme->addScript('', null, "
                $(document).ready(function(){
                    $('" . $this->name . "').easyResponsiveTabs({
                        tabidentify: '$tabidentify',
                        type: '{$this->type}', //Types: default, vertical, accordion
                        width: 'auto',
                        fit: true,
                        closed: false,
                        activate: function(e) {
                            Cookies.remove('{$cookie_name}');
                            Cookies.set('{$cookie_name}', e.currentTarget.baseURI);
                        },
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
                <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/Easy-Responsive-Tabs/js/easyResponsiveTabs.js'></script>
                <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . XOOPS_URL . "/modules/tadtools/Easy-Responsive-Tabs/css/easy-responsive-tabs.css' >
                ";

            $responsive_tabs .= "
            <script>
                $(document).ready(function(){
                    $('" . $this->name . "').easyResponsiveTabs({
                        tabidentify: '$tabidentify',
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
    public function render($tabidentify = 'vert', $function = '')
    {
        global $xoTheme;
        $jquery = Utility::get_jquery();
        $responsive_tabs = '';
        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/Easy-Responsive-Tabs/js/easyResponsiveTabs.js');
            $xoTheme->addScript('modules/tadtools/jqueryCookie/js.cookie.min.js');
            $xoTheme->addStylesheet('modules/tadtools/Easy-Responsive-Tabs/css/easy-responsive-tabs.css');
            $cookie_name = mb_substr($this->name, 1) . '_baseURI';
            $xoTheme->addScript('', null, "
                $(document).ready(function(){
                    $('" . $this->name . "').easyResponsiveTabs({
                        tabidentify: '$tabidentify',
                        type: '{$this->type}', //Types: default, vertical, accordion
                        width: 'auto',
                        fit: true,
                        closed: false,
                        activate: function(e) {
                            Cookies.remove('{$cookie_name}');
                            Cookies.set('{$cookie_name}', e.currentTarget.baseURI);
                        },
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
                <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/Easy-Responsive-Tabs/js/easyResponsiveTabs.js'></script>
                <link rel='stylesheet' type='text/css' media='all' title='Style sheet' href='" . XOOPS_URL . "/modules/tadtools/Easy-Responsive-Tabs/css/easy-responsive-tabs.css' >
                ";

            $responsive_tabs .= "
            <script>
                $(document).ready(function(){
                    $('" . $this->name . "').easyResponsiveTabs({
                        tabidentify: '$tabidentify',
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

#若有更新，記得把 $currentTab.trigger('tabactivate', $currentTab); 移動到 if (historyApi) {} 之後
/*
use XoopsModules\Tadtools\EasyResponsiveTabs;

$EasyResponsiveTabs = new EasyResponsiveTabs('#demoTab', $type = 'default, vertical, accordion', $activetab_bg = '#B5AC5F', $inactive_bg = '#E0D78C', $active_border_color = '#9C905C', $active_content_border_color = '#9C905C');
$EasyResponsiveTabs->rander();

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
