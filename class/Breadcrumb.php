<?php
namespace XoopsModules\Tadtools;

class Breadcrumb
{
    /* Variables */
    public $_bread = array();

    /**
     * @param $directory
     */
    public function __construct()
    {
    }

    /**
     * Add link to breadcrumb
     * @param string $title
     * @param string $link
     * @param bool   $home
     */
    public function addLink($title = '', $link = '', $home = false)
    {
        $this->_bread[] = array(
            'link' => $link,
            'title' => $title,
            'home' => $home);
    }

    /**
     * Render System BreadCrumb
     *
     */
    public function render($only_home_hide = false)
    {
        global $xoTheme;

        if (count($this->_bread) <= 1 && $only_home_hide) {
            return;
        }

        $out = $menu = '';
        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/breadcrumb/breadcrumb.css');
        } else {
            $out .= "<link href='" . XOOPS_URL . "/modules/tadtools/breadcrumb/breadcrumb.css' rel='stylesheet' type='text/css'>";
        }
        $out .= '<ul id="my-breadcrumb">';
        foreach ($this->_bread as $menu) {
            if ($menu['home']) {
                $out .= '<li><a href="' . $menu['link'] . '" title="' . $menu['title'] . '"><i class="fa fa-home" aria-hidden="true"></i></a></li>';
            } else {
                if ($menu['link'] != '') {
                    $out .= '<li><a href="' . $menu['link'] . '" title="' . $menu['title'] . '">' . $menu['title'] . '</a></li>';
                } else {
                    $out .= '<li>' . $menu['title'] . '</li>';
                }
            }
        }
        $out .= '</ul>';
        return $out;
    }
}
