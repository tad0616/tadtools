<?php
/**
 * ****************************************************************************
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  XOOPS Project
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package
 * @author
 *
 * Version : $Id:
 * ****************************************************************************
 */

require_once '../../../include/cp_header.php';
include 'header.php';


include_once XOOPS_ROOT_PATH."/modules/" . $xoopsModule->getVar("dirname") . "/class/admin.php";

$index_admin = new ModuleAdmin();

$index_admin->addConfigLabel(_AM_XDIR_CONFIG_CHECK) ;
$index_admin->addLineConfigLabel(_AM_XDIR_CONFIG_PHP, $xoopsModule->getInfo("min_php"), 'php') ;
$index_admin->addLineConfigLabel(_AM_XDIR_CONFIG_XOOPS, $xoopsModule->getInfo("min_xoops"), 'xoops') ;

echo $index_admin->addNavigation('index.php') ;
echo $index_admin->renderIndex();


include "footer.php";
xoops_cp_footer();
