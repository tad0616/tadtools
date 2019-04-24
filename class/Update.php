<?php

namespace XoopsModules\Tadtools;

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
        $sql = 'SELECT bid,name,visible,show_func,template FROM `' . $xoopsDB->prefix('newblocks') . '`  WHERE `dirname` = "tadtools" ORDER BY `func_num`';
        $result = $xoopsDB->query($sql);
        while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
            //假如現有的區塊和樣板對不上就刪掉
            if ($template != $tpl_file_arr[$show_func]) {
                $sql = 'delete from ' . $xoopsDB->prefix('newblocks') . " where bid='{$bid}'";
                $xoopsDB->queryF($sql);

                //連同樣板以及樣板實體檔案也要刪掉
                $sql = 'delete from ' . $xoopsDB->prefix('tplfile') . ' as a
                left join ' . $xoopsDB->prefix('tplsource') . "  as b on a.tpl_id=b.tpl_id
                where a.tpl_refid='$bid' and a.tpl_module='tadtools' and a.tpl_type='block'";
                $xoopsDB->queryF($sql);
            } else {
                $sql = 'update ' . $xoopsDB->prefix('tplfile') . "
                set tpl_file='{$template}' , tpl_desc='{$tpl_desc_arr[$show_func]}'
                where tpl_refid='{$bid}'";
                $xoopsDB->queryF($sql);
            }
        }
    }

    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tadtools_setup');
        $result = $xoopsDB->queryF($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update1()
    {
        global $xoopsDB;
        $sql = "CREATE TABLE `' . $xoopsDB->prefix('tadtools_setup') . '` (
            `tt_sn` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `tt_theme`  varchar(255) NOT NULL default '',
            `tt_use_bootstrap`  varchar(255) NOT NULL default '',
            PRIMARY KEY  (`tt_sn`),
            UNIQUE KEY `tt_theme` (`tt_theme`)
            ) ENGINE = MYISAM";

        $xoopsDB->queryF($sql);
    }

    //新增BootStrap顏色欄位
    public static function chk_chk2()
    {
        global $xoopsDB;
        $sql = 'select count(`tt_bootstrap_color`) from ' . $xoopsDB->prefix('tadtools_setup');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update2()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tadtools_setup') . " ADD `tt_bootstrap_color` varchar(255) NOT NULL  default ''";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

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
            $sql = 'select count(*) from ' . $xoopsDB->prefix('group_permission') . " where gperm_itemid='$mod_id' and `gperm_modid`='1' gperm_name='module_read'";
            $result = $xoopsDB->query($sql);
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
            $sql = 'insert into ' . $xoopsDB->prefix('group_permission') . " (`gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) values(1, '$mod_id' , 1 , 'module_read') , (2, '$mod_id' , 1 , 'module_read') ,(3, '$mod_id' , 1 , 'module_read')";
            $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

            return true;
        }

        return false;
    }

    //刪除索引
    public static function chk_chk4()
    {
        global $xoopsDB;
        $sql = 'select count(`tt_sn`) from ' . $xoopsDB->prefix('tadtools_setup');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update4()
    {
        global $xoopsDB;

        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tadtools_setup') . ' DROP INDEX `tt_theme`';
        $xoopsDB->queryF($sql);
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tadtools_setup') . ' DROP `tt_sn`';
        $xoopsDB->queryF($sql);
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tadtools_setup') . ' ADD PRIMARY KEY ( `tt_theme` )';
        $xoopsDB->queryF($sql);
    }

    //新增佈景種類
    public static function chk_chk5()
    {
        global $xoopsDB;
        $sql = 'select count(`tt_theme_kind`) from ' . $xoopsDB->prefix('tadtools_setup');
        $result = $xoopsDB->query($sql);
        if (!empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update5()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tadtools_setup') . " ADD `tt_theme_kind` varchar(255) NOT NULL  default ''";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }

    public static function go_update6()
    {
        global $xoopsDB;
        $sql = 'update ' . $xoopsDB->prefix('tadtools_setup') . " set `tt_bootstrap_color`='bootstrap' where `tt_bootstrap_color`=''";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }

    public static function chk_chk7()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tadtools_setup') . " where `tt_theme_kind`='bootstrap'";
        $result = $xoopsDB->queryF($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update7()
    {
        global $xoopsDB;
        $sql = 'update ' . $xoopsDB->prefix('tadtools_setup') . " set `tt_bootstrap_color`='bootstrap3' where `tt_theme_kind`='bootstrap'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }

    public static function chk_chk8()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_uploader_files_center') . " where `hash_filename` like '%}.%'";
        $result = $xoopsDB->queryF($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update8()
    {
        global $xoopsDB;
        $sql = 'update ' . $xoopsDB->prefix('tad_uploader_files_center') . " set `hash_filename`=replace(`hash_filename` , '}.' , '.') where `hash_filename` like '%}.%'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        return true;
    }
}
