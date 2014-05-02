<?php
/**
 * Class for admin V1.02 (20.03.2011)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   Gregory Mage (Aka Mage)
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Gregory Mage (Aka Mage)
 */

class ModuleAdmin
{

    var $_itemButton = array();
    var $_itemLabel = array();
    var $_itemLineLabel = array();
    var $_itemConfigLabel = '';
    var $_itemLineConfigLabel = array();
    var $_itemChangelogLabel = '';
    var $_obj = array();

    /**
     * Constructor
     */
    function __construct()
    {
        global $xoopsModule;
        $this->_obj =& $xoopsModule;
        echo "<style type=\"text/css\" media=\"screen\">@import \"" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname', 'e') . "/css/admin.css\";</style>";

    }

    function addItemButton($title, $link, $icon = 'add', $extra = '')
    {
        $ret['title'] = $title;
        $ret['link'] = $link;
        $ret['icon'] = $icon . '.png';
        $ret['extra'] = $extra;
        $this -> _itemButton[] = $ret;
        return true;

    }

    function renderButton($position = "right", $delimeter = "&nbsp;")
    {
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/images/admin/";
        switch ($position)
        {
            default:
            case "right":
                $ret = "<div class=\"floatright\">\n";
                break;

            case "left":
                $ret = "<div class=\"floatleft\">\n";
                break;

            case "center":
                $ret = "<div class=\"aligncenter\">\n";
        }
        $ret .= "<div class=\"xo-buttons\">\n";
        foreach (array_keys( $this -> _itemButton) as $i) {
            $ret .= "<a class='ui-corner-all tooltip' href='" . $this -> _itemButton[$i]['link'] . "' title='" . $this -> _itemButton[$i]['title'] . "'>";
            $ret .= "<img src='" . $path . $this -> _itemButton[$i]['icon'] . "' title='" . $this -> _itemButton[$i]['title'] . "' />" . $this -> _itemButton[$i]['title'] . $this -> _itemButton[$i]['extra'];
            $ret .= "</a>\n";
            $ret .= $delimeter;
        }
        $ret .= "</div>\n</div>\n";
        $ret .= "<br />&nbsp;<br /><br />";
        return $ret;
    }

    function addLabel($title)
    {
        $ret['title'] = $title;
        $this -> _itemLabel[] = $ret;
        return true;
    }

    function addLineLabel($label, $text, $value = '', $color = 'none', $type = 'default')
    {
        $ret['label'] = $label;
        $line = "";
        switch ($type)
        {
            default:
            case "default":
                $line .= sprintf($text, "<span style='color : " . $color . "; font-weight : bold;'>" . $value . "</span>");
            break;

            case "module":
                $date = explode('/',$this->_obj->getInfo('release_date'));
                $release_date = formatTimestamp(mktime(0, 0, 0, $date[1], $date[2], $date[0]), 's');
                $line .= "<table>\n<tr>\n<td width=\"100px\">\n";
                $line .= "<img src='" . XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/" . $this->_obj->getInfo('image') . "' alt='" . $this->_obj->getVar('name') . "' style='float: left; margin-right: 10px;' />\n";
                $line .= "</td><td>\n";
                $line .= "<div style='margin-top: 1px; margin-bottom: 4px; font-size: 18px; line-height: 18px; color: #2F5376; font-weight: bold;'>\n";
                $line .= $this->_obj->getInfo('name') . " " . $this->_obj->getInfo('version') . " " . $this->_obj->getInfo('status_version') ;
                $line .= "<br />\n";
                $line .= "</div>\n";
                $line .= "<div style='line-height: 16px; font-weight: bold;'>\n";
                $line .= "by " . $this->_obj->getInfo('author') ;
                if ($this->_obj->getInfo('pseudo') != ''){
				$line .=  " (" . $this->_obj->getInfo('pseudo') . ")\n";
				}
                $line .= "</div>\n";
                $line .= "<div style='line-height: 16px;'>\n";

                if ($this->_obj->getInfo('credits') != ''){
                    $line .= "Credits: " . $this->_obj->getInfo('credits') ;
                }
                $line .= "<br />\n";

                $line .= "<a href=\"http://" . $this->_obj->getInfo('license_url') . "\" target=\"_blank\" >" . $this->_obj->getInfo('license') . "</a>\n";
                $line .= "<br />\n";

                $line .= "<a href=\"http://" . $this->_obj->getInfo('website') . "\" target=\"_blank\" >" . $this->_obj->getInfo('website') . "</a>\n";
                $line .= "<br />\n";
                if ($value != ''){
                    $line .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                              <input type="hidden" name="cmd" value="_s-xclick">
                              <input type="hidden" name="hosted_button_id" value="' . $value . '">
                              <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                              <img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
                              </form>';
                }
                $line .= "</div>\n";
                $line .= "</td>\n</tr>\n</table>\n";
                break;

            case "information":
                $line .= $text;
                break;
        }
        $ret['line'] = $line;
        $this -> _itemLineLabel[] = $ret;
        return true;
    }

    function renderLabel()
    {
        $ret = "";
        foreach (array_keys( $this -> _itemLabel) as $i) {
            $ret .= "<fieldset><legend class=\"label\">";
            $ret .= $this -> _itemLabel[$i]['title'];
            $ret .= "</legend>\n";
            foreach (array_keys( $this -> _itemLineLabel) as $k) {
                if ($this -> _itemLineLabel[$k]['label'] == $this -> _itemLabel[$i]['title']){
                    $ret .= $this -> _itemLineLabel[$k]['line'];
                    $ret .= "<br />";
                }
            }
            $ret .= "</fieldset>\n";
            $ret .= "<br/>\n";
        }
        return $ret;
    }

    function addConfigLabel($title)
    {
        $this -> _itemConfigLabel = $title;
        return true;
    }

    function addLineConfigLabel($text, $value = '', $type = 'default')
    {
        $line = "";
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/images/icons/";
        switch ($type)
        {
            default:
            case "default":
                $line .= sprintf($text, "<span>" . $value . "</span>");
            break;

            case "php":
                if (phpversion() < $value){
                    $line .= "<span style='color : red; font-weight : bold;'><img src='" . $path . "off.png' >" . sprintf($text, $value, phpversion()) . "</span>\n";
                }else{
                    $line .= "<span style='color : green;'><img src='" . $path . "on.png' >" . sprintf($text, $value, phpversion()) . "</span>\n";
                }
                break;

            case "xoops":
                if (substr(XOOPS_VERSION, 0, 9) < $value){
                    $line .= "<span style='color : red; font-weight : bold;'><img src='" . $path . "off.png' >" . sprintf($text, $value, substr(XOOPS_VERSION, 0, 9)) . "</span>\n";
                }else{
                    $line .= "<span style='color : green;'><img src='" . $path . "on.png' >" . sprintf($text, $value, substr(XOOPS_VERSION, 0, 9)) . "</span>\n";
                }
                break;

            case "folder":
                if (!is_dir($value)){
                    $line .= "<span style='color : red; font-weight : bold;'><img src='" . $path . "off.png' >" . sprintf($text[1], $value) . "</span>\n";
                }else{
                    $line .= "<span style='color : green;'><img src='" . $path . "on.png' >" . sprintf($text[0], $value) . "</span>\n";
                }
                break;

            case "chmod":
                if (is_dir($value[0])){
                    if (substr(decoct(fileperms($value[0])),2) != $value[1]) {
                        $line .= "<span style='color : red; font-weight : bold;'><img src='" . $path . "off.png' >" . sprintf($text, $value[0], $value[1], substr(decoct(fileperms($value[0])),2)) . "</span>\n";
                    }else{
                        $line .= "<span style='color : green;'><img src='" . $path . "on.png' >" . sprintf($text, $value[0], $value[1], substr(decoct(fileperms($value[0])),2)) . "</span>\n";
                    }
                }
                break;
        }
        $this -> _itemLineConfigLabel[] = $line;
        return true;
    }

    function addChangelogLabel($title)
    {
        $line = "<fieldset><legend class=\"label\">\n";
        $line .= $title;
        $line .= "</legend><br/>\n";
        $line .= "<div class=\"txtchangelog\">\n";
        $language = $GLOBALS['xoopsConfig']['language'];
        if ( !is_file( XOOPS_ROOT_PATH . "/modules/" . $this->_obj->getVar("dirname") . "/language/" . $language . "/changelog.txt" ) ){
            $language = 'english';
        }
        $language = empty($language) ? $GLOBALS['xoopsConfig']['language'] : $language;
        $file = XOOPS_ROOT_PATH. "/modules/" . $this->_obj->getVar("dirname") . "/language/" . $language . "/changelog.txt";
        if ( is_readable( $file ) ){
            $line .= implode("<br />", file( $file )) . "\n";
        }
        $line .= "</div>\n";
        $line .= "</fieldset>\n";
        $this -> _itemChangelogLabel = $line;
        return true;
    }

    function addNavigation($menu = '')
    {
        $ret = "";
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/";
        $this->_obj->loadAdminMenu();
        foreach (array_keys( $this->_obj->adminmenu) as $i) {
            if ($this->_obj->adminmenu[$i]['link'] == "admin/" . $menu){
                $ret = "<div class=\"CPbigTitle\" style=\"background-image: url(" . $path . $this->_obj->adminmenu[$i]['icon'] . "); background-repeat: no-repeat; background-position: left; padding-left: 50px;\">
                        <strong>" . $this->_obj->adminmenu[$i]['title'] . "</strong></div><br />";
            }
        }
        return $ret;
    }

    function renderMenuIndex()
    {
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/";
        $pathsystem = XOOPS_URL . "/modules/system/";
        $this->_obj->loadAdminMenu();
        $ret = "<div class=\"rmmenuicon\">\n";
        foreach (array_keys( $this->_obj->adminmenu) as $i) {
            if ($this->_obj->adminmenu[$i]['link'] != 'admin/index.php'){
                if (isset($this->_obj->adminmenu[$i]['menu'])){
                    $ret .= "<a href=\"../" . $this->_obj->adminmenu[$i]['link'] . "\" title=\"" . $this->_obj->adminmenu[$i]['title'] . "\">" .
                            "<img src=\"" . $path . $this->_obj->adminmenu[$i]['menu'] . "\" alt=\"" . $this->_obj->adminmenu[$i]['title'] . "\" />";
                }else{
                    $ret .= "<a href=\"../" . $this->_obj->adminmenu[$i]['link'] . "\" title=\"" . $this->_obj->adminmenu[$i]['title'] . "\">" .
                            "<img src=\"" . $path . $this->_obj->adminmenu[$i]['icon'] . "\" alt=\"" . $this->_obj->adminmenu[$i]['title'] . "\" />";
                }
                $ret .= "<span>" . $this->_obj->adminmenu[$i]['title'] . "</span>";
                $ret .= "</a>";
            }
        }
        if ($this->_obj->getInfo('help')) {
            $ret .= "<a href=\"" . $pathsystem . "help.php?mid=" . $this->_obj->getVar('mid', 's') . "&amp;" . $this->_obj->getInfo('help') . "\" title=\"" . _AM_SYSTEM_HELP . "\">" .
                    "<img width=\"32px\" src=\"" . $path . "images/admin/help.png\" alt=\"" . _AM_SYSTEM_HELP . "\" /> ";
            $ret .= "<span>" . _AM_SYSTEM_HELP . "</span>";
            $ret .= "</a>";
        }
        $ret .= "</div>\n<div style=\"clear: both;\"></div>\n";
        return $ret;
    }

    function renderIndex()
    {
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/images/admin/";
        $ret = "<table>\n<tr>\n";
        $ret .= "<td width=\"40%\">\n";
        $ret .= $this -> renderMenuIndex();
        $ret .= "</td>\n";
        $ret .= "<td width=\"60%\">\n";
        $ret .= $this -> renderLabel();
        $ret .= "</td>\n";
        $ret .= "</tr>\n";
        // If you use a config label
        if ($this -> _itemConfigLabel != ''){
            $ret .= "<tr>\n";
            $ret .= "<td colspan=\"2\">\n";
            $ret .= "<fieldset><legend class=\"label\">";
            $ret .= $this -> _itemConfigLabel;
            $ret .= "</legend><br/>\n";
            foreach (array_keys( $this -> _itemLineConfigLabel) as $i) {
                $ret .= $this -> _itemLineConfigLabel[$i];
                $ret .= "<br />";
            }
            $ret .= "</fieldset>\n";
            $ret .= "</td>\n";
            $ret .= "</tr>\n";
        }
        $ret .= "</table>\n";

//        $ret .= "<div align=\"center\">";
//        $ret .= "<a href=\"http://www.xoops.org\" target=\"_blank\"><img src=\"" . $path . "xoopsmicrobutton.gif\" alt=\"XOOPS\" title=\"XOOPS\"></a>";
//        $ret .= "</div>";

        return $ret;
    }

    function renderAbout($type = 'default')
    {
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/images/admin/";
        $ret = "<table>\n<tr>\n";
        $ret .= "<td width=\"50%\">\n";
        $ret .= $this -> renderLabel();
        if ($type == 'line'){
            $ret .= $this -> _itemChangelogLabel;
        }else{
            $ret .= "</td>\n";
            $ret .= "<td width=\"50%\">\n";
            $ret .= $this -> _itemChangelogLabel;
        }
        $ret .= "</td>\n";
        $ret .= "</tr>\n";
        $ret .= "</table>\n";
        $ret .= "<div align=\"center\">";
//        $ret .= "<a href=\"http://www.xoops.org\" target=\"_blank\"><img src=\"" . $path . "xoopsmicrobutton.gif\" alt=\"XOOPS\" title=\"XOOPS\"></a>";
        $ret .= "</div>";
        return $ret;
    }
}
?>