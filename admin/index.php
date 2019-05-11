<?php
/**
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package
 * @since        2.5.0
 * @author
 * @version      $Id $
 **/

require __DIR__ . '/header.php';

$adminObject = \Xmf\Module\Admin::getInstance();

$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

require __DIR__ . '/footer.php';
xoops_cp_footer();
