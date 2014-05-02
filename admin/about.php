<?php
/**
 * Marquee module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license             http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Marquee
 * @since        2.5.0
 * @author     Mage, Mamba
 * @version    $Id $
 **/

include '../../../include/cp_header.php';
include '../../../class/xoopsformloader.php';
xoops_cp_header();
include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/class/admin.php";

$module_info =& $module_handler->get($xoopsModule->getVar("mid"));

$module_info = '<div id="about">
				<label>' . _AM_XDIR_ABOUT_DESCRIPTION . '</label><text>' . $module_info->getInfo("description") . '</text><br />
				<label>' . _AM_XDIR_ABOUT_RELEASEDATE . '</label><text class="bold">' . $module_info->getInfo("release_date") . '</text><br />
				<label>' . _AM_XDIR_ABOUT_UPDATEDATE . '</label><text class="bold">' . formatTimestamp($xoopsModule->getVar("last_update"), "m") . '</text><br />
                <label>' . _AM_XDIR_ABOUT_MODULE_STATUS . '</label><text>' . $module_info->getInfo("module_status") . '</text><br />
                <label>' . _AM_XDIR_ABOUT_WEBSITE . '</label><text><a class="tooltip" href="' . $module_info->getInfo("module_website_url") . '" rel="external" title="' . $module_info->getInfo("module_website_name") . ' - ' . $module_info->getInfo("module_website_url") . '">
                ' . $module_info->getInfo("module_website_name") . '</a></text></div>';

$about_admin = new ModuleAdmin();
$about_admin->addLabel($xoopsModule->getVar("name"));
$about_admin->addLabel(_AM_XDIR_ABOUT_MODULE_INFO);
$about_admin->addLineLabel($xoopsModule->getVar("name"), '', '6KJ7RW5DR3VTJ', '', 'module');
$about_admin->addLineLabel(_AM_XDIR_ABOUT_MODULE_INFO, $module_info, '', '', 'information');
$about_admin->addChangelogLabel(_AM_XDIR_ABOUT_CHANGELOG);

echo $about_admin->addNavigation('about.php');
echo $about_admin->renderabout();
echo "<div class='center smallsmall italic pad5'><b>" . $xoopsModule->getVar("name") . "</b> is maintained by the <a class='tooltip' rel='external' href='http://www.xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a></div>";
xoops_cp_footer();

?>