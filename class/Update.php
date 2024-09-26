<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{

    //刪除錯誤的重複欄位及樣板檔
    public static function chk_tadtools_block()
    {
        global $xoopsDB;
        //die(var_export($xoopsConfig));
        include XOOPS_ROOT_PATH . '/modules/tadtools/xoops_version.php';

        //先找出該有的區塊以及對應樣板
        foreach ($modversion['blocks'] as $i => $block) {
            $show_func = $block['show_func'];
            $tpl_file_arr[$show_func] = $block['template'];
            $tpl_desc_arr[$show_func] = $block['description'];
        }

        //找出目前所有的樣板檔
        $sql = 'SELECT `bid`, `name`, `visible`, `show_func`, `template` FROM `' . $xoopsDB->prefix('newblocks') . '`  WHERE `dirname` = "tadtools" ORDER BY `func_num`';
        $result = Utility::query($sql) or die($sql);
        while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
            //假如現有的區塊和樣板對不上就刪掉
            if ($template != $tpl_file_arr[$show_func]) {
                $sql = 'DELETE FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE bid=?';
                Utility::query($sql, 'i', [$bid]) or die($sql);

                //連同樣板以及樣板實體檔案也要刪掉
                $sql = 'DELETE FROM `' . $xoopsDB->prefix('tplfile') . '` AS a
                LEFT JOIN `' . $xoopsDB->prefix('tplsource') . "` AS b ON a.tpl_id=b.tpl_id
                WHERE a.tpl_refid=? AND a.tpl_module='tadtools' AND a.tpl_type='block'";
                Utility::query($sql, 'i', [$bid]) or die($sql);

            } else {
                $sql = 'UPDATE `' . $xoopsDB->prefix('tplfile') . '`
                SET `tpl_file`=?, `tpl_desc`=?
                WHERE `tpl_refid`=?';
                Utility::query($sql, 'ssi', [$template, $tpl_desc_arr[$show_func], $bid]);

            }
        }
    }

    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('tadtools_setup') . '`';
        $result = Utility::query($sql) or die($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update1()
    {
        global $xoopsDB;
        $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tadtools_setup') . "` (
            `tt_sn` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `tt_theme`  varchar(255) NOT NULL default '',
            `tt_use_bootstrap`  varchar(255) NOT NULL default '',
            PRIMARY KEY  (`tt_sn`),
            UNIQUE KEY `tt_theme` (`tt_theme`)
            ) ENGINE = MYISAM";

        Utility::queryF($sql) or die($sql);
    }

    //新增BootStrap顏色欄位
    public static function chk_chk2()
    {
        global $xoopsDB;
        $sql = 'SELECT count(`tt_bootstrap_color`) FROM ' . $xoopsDB->prefix('tadtools_setup');
        $result = Utility::query($sql) or die($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update2()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tadtools_setup') . "` ADD `tt_bootstrap_color` varchar(255) NOT NULL  default ''";
        Utility::queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }

    //新增使用權限
    public static function chk_chk3()
    {
        global $xoopsDB;
        $modhandler = xoops_getHandler('module');
        $TadToolsModule = $modhandler->getByDirname('tadtools');
        $mod_id = $TadToolsModule->getVar('mid');

        if ($mod_id) {
            $sql = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('group_permission') . "` WHERE `gperm_itemid`=? AND `gperm_modid`=1 AND gperm_name='module_read'";
            $result = Utility::query($sql, 'i', [$mod_id]) or die($sql);
            list($count) = $xoopsDB->fetchRow($result);
            if (empty($count)) {
                return true;
            }
        }

        return false;
    }

    public static function go_update3()
    {
        global $xoopsDB;
        $modhandler = xoops_getHandler('module');
        $TadToolsModule = $modhandler->getByDirname('tadtools');
        $mod_id = $TadToolsModule->getVar('mid');
        if ($mod_id) {
            $sql = 'INSERT INTO `' . $xoopsDB->prefix('group_permission') . "` (`gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES (1, ?, 1, 'module_read'), (2, ?, 1, 'module_read'), (3, ?, 1, 'module_read')";
            Utility::query($sql, 'iii', [$mod_id, $mod_id, $mod_id]) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());
            return true;
        }

        return false;
    }

    //刪除索引
    public static function chk_chk4()
    {
        global $xoopsDB;

        $sql = "SELECT COUNT(*) AS column_exists
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = '" . $xoopsDB->prefix('tadtools_setup') . "'
        AND COLUMN_NAME = 'tt_sn'";
        Utility::query($sql) or die($sql);
        list($have) = $xoopsDB->fetchRow($result);

        return $have;
    }

    public static function go_update4()
    {
        global $xoopsDB;

        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tadtools_setup') . '` DROP INDEX `tt_theme`';
        Utility::query($sql) or die($sql);
        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tadtools_setup') . '` DROP `tt_sn`';
        Utility::query($sql) or die($sql);
        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tadtools_setup') . '` ADD PRIMARY KEY ( `tt_theme` )';
        Utility::query($sql) or die($sql);
    }

    //新增佈景種類
    public static function chk_chk5()
    {
        global $xoopsDB;
        $sql = 'SELECT COUNT(`tt_theme_kind`) FROM `' . $xoopsDB->prefix('tadtools_setup') . '`';
        $result = Utility::query($sql) or die($sql);
        if (!empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update5()
    {
        global $xoopsDB;

        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tadtools_setup') . "` ADD `tt_theme_kind` VARCHAR(255) NOT NULL  DEFAULT ''";
        Utility::query($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());
        return true;
    }

    public static function go_update6()
    {
        global $xoopsDB;

        $sql = 'UPDATE `' . $xoopsDB->prefix('tadtools_setup') . '` SET `tt_bootstrap_color`=? WHERE `tt_bootstrap_color`=?';
        Utility::query($sql, 'ss', ['bootstrap', '']) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());
        return true;
    }

    public static function chk_chk7()
    {
        global $xoopsDB;
        $sql = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('tadtools_setup') . '` WHERE `tt_theme_kind`=?';
        $result = Utility::query($sql, 's', ['bootstrap']) or die($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update7()
    {
        global $xoopsDB;
        $sql = 'UPDATE `' . $xoopsDB->prefix('tadtools_setup') . '` SET `tt_bootstrap_color`=? WHERE `tt_theme_kind`=?';
        Utility::query($sql, 'ss', ['bootstrap3', 'bootstrap']) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }

    public static function chk_chk8()
    {
        global $xoopsDB;
        $sql = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('tad_uploader_files_center') . '` WHERE `hash_filename` LIKE ?';
        $result = Utility::query($sql, 's', ['%}.%']) or die($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update8()
    {
        global $xoopsDB;
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_uploader_files_center') . "` SET `hash_filename`=replace(`hash_filename` , '}.' , '.') WHERE `hash_filename` like '%}.%'";
        Utility::query($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }
}
