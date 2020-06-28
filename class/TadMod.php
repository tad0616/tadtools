<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class TadMod
{
    private $dirname;
    private $name;
    private $version;
    private $release_date;
    private $email;
    private $author;
    private $hasMain;
    private $hasAdmin;
    private $min_php;
    private $min_xoops;
    private $description;
    private $credits;
    private $website_ur;
    private $website_name;
    private $config_arr = [];
    private $block_arr = [];
    private $lang = [];
    private $interface_menu = [];
    private $adm_menu = [];

    // TadMod 類
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1637
    public function __construct($dirname = '')
    {
        global $xoopsModule;
        if ($dirname) {
            $this->dirname = $dirname;
        } elseif ($xoopsModule) {
            $this->dirname = $xoopsModule->dirname();
        } else {
            die(_TM_FILE_NOT_DIR);
        }
        $this->add_adm_menu(_MI_TAD_ADMIN_HOME, 'admin/index.php', 'images/admin/home.png');
        $this->interface_menu[_TAD_TO_MOD] = "index.php";
    }

    //  模組基本設定
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1638
    public function setup($name, $version, $release_date, $email = '', $author = '', $hasMain = true, $hasAdmin = true, $min_php = '5.5', $min_xoops = '2.5', $description = '', $credits = '', $website_ur = '', $website_name = '')
    {
        $this->name = $name;
        $this->version = $version;
        $this->release_date = $release_date;
        $this->email = $email;
        $this->author = $author;
        $this->hasMain = $hasMain;
        $this->hasAdmin = $hasAdmin;
        $this->name = $name;
        $this->min_php = $min_php;
        $this->min_xoops = $min_xoops;
        $this->description = $description;
        $this->credits = $credits;
        $this->website_ur = $website_ur;
        $this->website_name = $website_name;
        return $this;
    }

    //  新增偏好設定
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1639
    public function add_config($name, $title = '', $desc = '', $formtype = 'textbox', $valuetype = 'text', $default = '', $options = [])
    {
        $config['name'] = $name;
        $config['formtype'] = $formtype;
        $config['valuetype'] = $valuetype;
        $config['default'] = $default;
        if ($options) {
            $config['options'] = $options;
        }

        $const['title'] = '_MI_' . \strtoupper($this->dirname) . '_C_' . \strtoupper($name);
        $const['desc'] = '_MI_' . \strtoupper($this->dirname) . '_C_' . \strtoupper($name) . '_DESC';
        $config['lang'] = $const;

        if (empty($desc)) {
            $desc = $title;
        }
        $this->lang['mi'][] = [$const['title'] => $title, $const['desc'] => $desc];
        $this->config_arr[] = $config;
        return $this;
    }

    //  新增區塊設定
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1640
    public function add_blocks($name, $title = '', $desc = '', $options_arr = [])
    {

        $block['name'] = $name;
        $options = [];
        foreach ($options_arr as $opt_title => $opt_val) {
            $options[] = $opt_val;
        }
        $block['options'] = implode('|', $options);
        $const['title'] = '_MI_' . \strtoupper($this->dirname) . '_B_' . \strtoupper($name);
        $const['desc'] = '_MI_' . \strtoupper($this->dirname) . '_B_' . \strtoupper($name) . '_DESC';
        $block['lang'] = $const;

        if (empty($desc)) {
            $desc = $title;
        }
        $this->lang['mi'][] = [$const['title'] => $title, $const['desc'] => $desc];
        $this->block_arr[] = $block;
        return $this;
    }

    //  新增前台選單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1641
    public function add_menu($title, $value, $only_adm = false)
    {
        if ($only_adm) {
            if ($this->is_admin()) {
                $this->interface_menu[$title] = $value;
            }
        } else {
            $this->interface_menu[$title] = $value;
        }
        return $this;
    }

    //  取得前台選單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1642
    public function get_menu($tag = 'toolbar')
    {
        global $xoopsTpl;
        $interface_menu = $this->interface_menu;
        if ($this->is_admin()) {
            $interface_menu[_TAD_TO_ADMIN] = "admin/main.php";
        }
        $menu = Utility::toolbar_bootstrap($interface_menu, true);
        $xoopsTpl->assign($tag, $menu);
        return $menu;
    }

    //  新增後台選單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1643
    public function add_adm_menu($title, $value, $icon = 'images/admin/button.png')
    {
        $this->adm_menu[$title]['url'] = $value;
        $this->adm_menu[$title]['icon'] = $icon;
        return $this;
    }

    //  取得後台選單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1644
    public function get_adm_menu()
    {
        global $xoopsTpl;

        $this->add_adm_menu(_MI_TAD_ADMIN_ABOUT, 'admin/about.php', 'images/admin/about.png');

        $i = 0;
        foreach ($this->adm_menu as $title => $adm_menu) {
            $adminmenu[$i]['title'] = $title;
            $adminmenu[$i]['link'] = $adm_menu['url'];
            $adminmenu[$i]['icon'] = $adm_menu['icon'];
            $i++;
        }

        return $adminmenu;
    }

    // 取得xoops_version設定陣列
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/post.php?op=tad_book3_docs_form&tbsn=48&tbdsn=1645
    public function xoops_version()
    {
        global $xoTheme;
        $modversion['name'] = $this->name;
        $modversion['version'] = $this->version;
        $modversion['description'] = $this->description;
        $modversion['author'] = $this->author;
        $modversion['credits'] = $this->credits;
        $modversion['help'] = 'page=help';
        $modversion['license'] = 'GNU GPL 2.0';
        $modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
        $modversion['image'] = 'images/logo.png';
        $modversion['dirname'] = $this->dirname;
        $modversion['release_date'] = $this->release_date;
        if ($this->website_url) {
            $modversion['module_website_url'] = $this->website_url;
            $modversion['module_website_name'] = $this->website_name;
            $modversion['author_website_url'] = $this->website_url;
            $modversion['author_website_name'] = $this->website_name;
        }
        $modversion['module_status'] = 'release';
        $modversion['min_php'] = $this->min_php;
        $modversion['min_xoops'] = $this->min_xoops;
        $modversion['system_menu'] = 1;

        if ($this->email) {
            $paypal['business'] = $this->email;
            $paypal['item_name'] = 'Donation : ' . $this->email;
            $paypal['amount'] = 0;
            $paypal['currency_code'] = 'USD';
            $modversion['paypal'] = $paypal;
        }

        if (\file_exists(XOOPS_ROOT_PATH . "/modules/{$this->dirname}/sql/mysql.sql")) {
            $modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
            $sql = \file_get_contents(XOOPS_ROOT_PATH . "/modules/{$this->dirname}/sql/mysql.sql");
            preg_match_all('/CREATE TABLE `([a-z_]*)`/i', $sql, $tables);
            $modversion['tables'] = $tables[1];
        }

        if ($this->hasMain) {
            $modversion['hasMain'] = 1;
            if (\is_array($this->hasMain)) {
                foreach ($this->hasMain as $i => $sub) {
                    $modversion['sub'][$i]['name'] = $sub['name'];
                    $modversion['sub'][$i]['url'] = $sub['name'];
                }
            }
        }

        if ($this->hasAdmin) {
            $modversion['hasAdmin'] = 1;
            $modversion['adminindex'] = 'admin/index.php';
            $modversion['adminmenu'] = 'admin/menu.php';
        }

        if (\file_exists(XOOPS_ROOT_PATH . "/modules/{$this->dirname}/include/onInstall.php")) {
            $modversion['onInstall'] = "include/onInstall.php";
        }
        if (\file_exists(XOOPS_ROOT_PATH . "/modules/{$this->dirname}/include/onUpdate.php")) {
            $modversion['onUpdate'] = "include/onUpdate.php";
        }
        if (\file_exists(XOOPS_ROOT_PATH . "/modules/{$this->dirname}/include/onUninstall.php")) {
            $modversion['onUninstall'] = "include/onUninstall.php";
        }
        if (\file_exists(XOOPS_ROOT_PATH . "/modules/{$this->dirname}/include/search.php")) {
            $modversion['hasSearch'] = 1;
            $modversion['search']['file'] = "include/search.php";
            $modversion['search']['func'] = "{$this->dirname}_search";
        }

        $modversion['templates'][0]['file'] = "{$this->dirname}_admin.tpl";
        $modversion['templates'][0]['description'] = 'Admin Template';
        $modversion['templates'][1]['file'] = "{$this->dirname}_index.tpl";
        $modversion['templates'][1]['description'] = 'Index Template';

        foreach ($this->config_arr as $i => $config) {
            $modversion['config'][$i]['name'] = $config['name'];
            $modversion['config'][$i]['title'] = $config['lang']['title'];
            $modversion['config'][$i]['description'] = $config['lang']['desc'];
            $modversion['config'][$i]['formtype'] = $config['formtype'];
            $modversion['config'][$i]['valuetype'] = $config['valuetype'];
            $modversion['config'][$i]['default'] = $config['default'];
        }

        foreach ($this->block_arr as $i => $block) {
            $modversion['blocks'][$i]['file'] = "{$block['name']}.php";
            $modversion['blocks'][$i]['name'] = constant($block['lang']['title']);
            $modversion['blocks'][$i]['description'] = constant($block['lang']['desc']);
            $modversion['blocks'][$i]['show_func'] = $block['name'];
            $modversion['blocks'][$i]['template'] = "{$block['name']}.tpl";
            if ($block['options']) {
                $modversion['blocks'][$i]['edit_func'] = "{$block['name']}_edit";
                $modversion['blocks'][$i]['options'] = $block['options'];
            }
        }

        //---評論---//
        //$modversion['hasComments'] = 1;
        //$modversion['comments']['pageName'] = '單一頁面.php';
        //$modversion['comments']['itemName'] = '主編號';

        //---通知---//
        //$modversion['hasNotification'] = 1;

        return $modversion;
    }

    //  取得語系
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1646
    public function get_lang($type)
    {
        return $this->lang[$type];
    }

    //  判斷是否有管理權限
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1647
    public function is_admin()
    {
        global $xoopsUser;
        $session_name = "{$this->dirname}_adm";
        if (!isset($_SESSION[$session_name])) {
            $modhandler = xoops_gethandler('module');
            $xoopsModule = $modhandler->getByDirname($this->dirname);
            $module_id = $xoopsModule->mid();
            $_SESSION[$session_name] = ($xoopsUser) ? $xoopsUser->isAdmin($module_id) : false;
        }
        return $_SESSION[$session_name];
    }

}
