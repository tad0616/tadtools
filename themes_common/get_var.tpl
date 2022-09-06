<{php}>
global $xoopsDB, $xoopsConfig, $aggreg;

/**** 取得左右區塊數 ****/
$left_count = $aggreg ? count($aggreg->blocks['canvas_left']) : 0;
$right_count = $aggreg ? count($aggreg->blocks['canvas_right']) : 0;
$xoops_showlblock = empty($left_count) ? false : true;
$xoops_showrblock = empty($right_count) ? false : true;

$this->assign('left_count', $left_count);
$this->assign('right_count', $right_count);

/**** 取得 Tad Themes 偏好設定****/
$moduleHandler = xoops_getHandler('module');
$TadThemesModule = $moduleHandler->getByDirname("tad_themes");
$TadThemesMid = ($TadThemesModule) ? $TadThemesModule->getVar('mid') : 0;
$configHandler = xoops_getHandler('config');
$TadThemesConfig = $configHandler->getConfigsByCat(0, $TadThemesMid);
$this->assign('TadThemesMid', $TadThemesMid);
$this->assign('use_pin', $TadThemesConfig['use_pin']);
$this->assign('login_text', $TadThemesConfig['login_text']);
$this->assign('login_description', $TadThemesConfig['login_description']);
$use_default_config = false;

/**** 取得佈景設定的各個預設值 ****/
$theme_name = $xoopsConfig['theme_set'];
require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
require_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/main.php";

$this->assign('config_tabs', $config_tabs);
foreach ($config_enable as $k => $v) {
    $$k = $v['default'];
    $this->assign($k, $v['default']);
}

/**** 模擬偏好設定預設值（避免沒裝 tad_theme 無法取得資料庫資料） ****/
$default['auto_mainmenu'] = '1';
$default['show_sitename'] = '1';
$default['openid_login'] = '0';
$default['openid_logo'] = '1';

$sql = "select `tt_bootstrap_color` from " . $xoopsDB->prefix("tadtools_setup") . " where `tt_theme`='{$theme_name}'";
$result = $xoopsDB->query($sql);
list($theme_color) = $xoopsDB->fetchRow($result);

//模擬Tad Themes的設定值
$default['theme_id'] = '0';
$default['theme_kind'] = $theme_kind;
$default['theme_change'] = $theme_change;
$default['theme_color'] = $theme_color;
$default['menu_var_kind'] = empty($menu_var_kind) ? 'my_menu' : $menu_var_kind;

$_SESSION['menu_var_kind'] = $default['menu_var_kind'];

$default['bg_img'] = !empty($bg_img) ? XOOPS_URL . "/themes/{$theme_name}/images/bg/{$bg_img}" : "";
$default['logo_img'] = !empty($logo_img) ? XOOPS_URL . "/themes/{$theme_name}/images/logo/{$logo_img}" : "";
$default['navlogo_img'] = !empty($navlogo_img) ? XOOPS_URL . "/themes/{$theme_name}/images/navlogo/{$navlogo_img}" : "";
$default['navbar_img'] = !empty($navbar_img) ? XOOPS_URL . "/themes/{$theme_name}/images/nav_bg/{$navbar_img}" : "";
$default['bt_bg_img'] = !empty($bt_bg_img) ? XOOPS_URL . "/themes/{$theme_name}/images/bt_bg/{$bt_bg_img}" : "";

foreach ($default as $k => $v) {
    $$k = $v;
    $this->assign($k, $$k);
}

/**** 產生 Smarty 的設定檔（以取得 bootstrap 版本） ****/
if (!file_exists(XOOPS_ROOT_PATH . "/uploads/bootstrap.conf")) {
    $bootstrap = (strpos($theme_kind, 'bootstrap') !== false) ? substr($theme_kind, -1) : '4';
    file_put_contents(XOOPS_ROOT_PATH . "/uploads/bootstrap.conf", "bootstrap = {$bootstrap}");
    $_SESSION['bootstrap'] = $bootstrap;
}

/**** 有裝 tad_theme 取得資料庫資料 ****/
if ($TadThemesMid) {

    $TadThemesModuleConfig = $configHandler->getConfigsByCat(0, $TadThemesMid);

    if (!isset($TadThemesModuleConfig['openid_login'])) {
        $TadThemesModuleConfig['openid_login'] = $default['openid_login'];
    }
    if (!isset($TadThemesModuleConfig['openid_logo'])) {
        $TadThemesModuleConfig['openid_logo'] = $default['openid_logo'];
    }

    $this->assign('auto_mainmenu', $TadThemesModuleConfig['auto_mainmenu']);
    $this->assign('show_sitename', $TadThemesModuleConfig['show_sitename']);
    $this->assign('openid_login', $TadThemesModuleConfig['openid_login']);
    $this->assign('openid_logo', $TadThemesModuleConfig['openid_logo']);

    /**** Tad Themes 的設定值****/
    if (file_exists(XOOPS_ROOT_PATH . "/modules/tad_themes/xoops_version.php")) {
        $file_col = ['bg_img' => 'bg', 'logo_img' => 'logo', 'navlogo_img' => 'navlogo', 'navbar_img' => 'nav_bg'];
        $file_cols = array_keys($file_col);
        $sql = "select * from " . $xoopsDB->prefix("tad_themes") . " where `theme_name`='{$theme_name}'";
        $result = $xoopsDB->query($sql);
        $data = $xoopsDB->fetchArray($result);

        if (!empty($data) and !empty($data['theme_width'])) {
            foreach ($data as $k => $v) {
                $$k = $v;
                if (in_array($k, $file_cols) and $v != '') {
                    $v = XOOPS_URL . "/uploads/tad_themes/{$theme_name}/{$file_col[$k]}/{$v}";
                }
                $this->assign($k, $v);
            }

            $use_slide = $slide_width > 0 ? 1 : 0;
            $this->assign('use_slide', $use_slide);
        } elseif (file_exists(XOOPS_ROOT_PATH . "/modules/tad_themes/auto_import_theme.php")) {
            require_once XOOPS_ROOT_PATH . "/modules/tad_themes/auto_import_theme.php";
            auto_import_theme();
            $sql = "select * from " . $xoopsDB->prefix("tad_themes") . " where `theme_name`='{$theme_name}'";
            $result = $xoopsDB->queryF($sql);
            $data = $xoopsDB->fetchArray($result);
        }

        if (empty($data['theme_id'])) {
            $use_default_config = true;
        }

    } else {
        $use_default_config = true;
    }
} else {
    $use_default_config = true;
}

/****設定各個區域的底色****/
$left_block = $left_block2 = "";
$center_block = "background-color: {$cb_color};";
$right_block = $right_block2 = "";

/****設定各個區域的寬度****/

if ($theme_kind == 'mix') {
    $theme_width = 12;
}

//TYPE1:二欄式（左右區域皆在左邊）
if ($theme_type == 'theme_type_1') {
    if ($theme_kind == "html") {
        if (!$xoops_showlblock and !$xoops_showrblock) {
            $center_width = $theme_width;
        } else {
            $center_width = $theme_width - $lb_width - 50;
            $center_content_width = $center_width - 15;
        }

        $left_block .= "width:{$lb_width}px;";
        $center_block .= "float:right; width:{$center_width}px;";
        $center_block_content = "width:{$center_content_width}px;";
        $right_block .= " width:{$rb_width}px;";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
        if ($lb_width == 'auto') {
            $lb_width = 12 - $cb_width;
        }
    } else {
        $center_width = $theme_width - $lb_width;
    }

//TYPE2:二欄式（左右區域皆在右邊）
} elseif ($theme_type == 'theme_type_2') {
    if ($theme_kind == "html") {
        if (!$xoops_showlblock and !$xoops_showrblock) {
            $center_width = $theme_width;
        } else {
            $center_width = $theme_width - $rb_width - 50;
        }

        $left_block .= "width:{$lb_width}px;";
        $center_block .= "float:left;  width:{$center_width}px; padding-left: 15px;";
        $center_block_content = $center_block;
        $right_block .= "width:{$rb_width}px;";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
        if ($rb_width == 'auto') {
            $rb_width = 12 - $cb_width;
        }
    } else {
        $center_width = $theme_width - $rb_width;
    }

//TYPE3:二欄式（左區域在左邊，右區域在下方）
} elseif ($theme_type == 'theme_type_3') {
    if ($theme_kind == "html") {
        if (!$xoops_showlblock) {
            $center_width = $theme_width;
        } else {
            $center_width = $theme_width - $lb_width - 60;
            $center_content_width = $center_width - 15;
        }
        $left_block .= "float:left; width:{$lb_width}px;";
        $center_block .= "float:right;  width:{$center_width}px;";
        $center_block_content = "width:{$center_content_width}px;";
        $right_block .= "float:none;  width:{$theme_width}px; clear:both;";
        $left_block2 = "";
        $right_block2 .= "float:left; padding-left: 15px;";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
        if ($lb_width == 'auto') {
            $lb_width = 12 - $cb_width;
        }
        $rb_width = "12";
    } else {
        $rb_width = "12";
        $center_width = $theme_width - $lb_width;
    }

//TYPE4:二欄式（左區域在右邊，右區域在下方）
} elseif ($theme_type == 'theme_type_4') {
    if ($theme_kind == "html") {
        if (!$xoops_showrblock) {
            $center_width = $theme_width;
        } else {
            $center_width = $theme_width - $lb_width - 60;
        }
        $left_block .= "float:right; width: {$lb_width}px;";
        $center_block .= "float:left; width: {$center_width}px; padding-left: 10px;";
        $center_block_content = $center_block;
        $right_block .= "float:none; width:{$theme_width}px; clear:both;";
        $left_block2 = "";
        $right_block2 .= "float:left; padding-left: 15px;";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
        if ($lb_width == 'auto') {
            $lb_width = 12 - $cb_width;
        }
        $rb_width = "12";
    } else {
        $rb_width = "12";
        $center_width = $theme_width - $lb_width;
    }

//TYPE5:三欄式標準配置
} elseif ($theme_type == 'theme_type_5') {
    if ($theme_kind == "html") {
        if (!$xoops_showlblock and !$xoops_showrblock) {
            $center_width = $theme_width;
        } elseif (!$xoops_showlblock) {
            //$center_width=$theme_width - $rb_width - 20;
        } elseif (!$xoops_showrblock) {
            $center_width = $theme_width - $lb_width - 20;
        } else {
            $center_width = $theme_width - $lb_width - $rb_width - 50;
        }

        $left_block .= "float:left;  width:{$lb_width}px;";
        $center_block .= "float:left;  width:{$center_width}px;";
        $right_block .= "float:right;  width:{$rb_width}px;";
        $left_block2 = $right_block2 = $center_block_content = "";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
    } else {
        $center_width = $theme_width - $lb_width - $rb_width;
    }

//TYPE6:三欄式（左右區域皆在左邊）
} elseif ($theme_type == 'theme_type_6') {
    if ($theme_kind == "html") {
        if (!$xoops_showlblock and !$xoops_showrblock) {
            $center_width = $theme_width;
        } elseif (!$xoops_showlblock) {
            $center_width = $theme_width - $rb_width - 20;
        } elseif (!$xoops_showrblock) {
            $center_width = $theme_width - $lb_width - 20;
        } else {
            $center_width = $theme_width - $lb_width - $rb_width - 50;
        }
        $center_content_width = $center_width - 50;
        $left_block .= "float:left;  width:{$lb_width}px;";
        $center_block .= "float:right;  width:{$center_width}px;";
        $center_block_content = "width:{$center_content_width}px;";
        $right_block .= "float:left;  width:{$rb_width}px;";
        $left_block2 = $right_block2 = "";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
    } else {
        $center_width = $theme_width - $lb_width - $rb_width;
    }

//TYPE7:三欄式（左右區域皆在右邊）
} elseif ($theme_type == 'theme_type_7') {
    if ($theme_kind == "html") {
        if (!$xoops_showlblock and !$xoops_showrblock) {
            $center_width = $theme_width;
        } elseif (!$xoops_showlblock) {
            $center_width = $theme_width - $rb_width - 20;
        } elseif (!$xoops_showrblock) {
            $center_width = $theme_width - $lb_width - 20;
        } else {
            $center_width = $theme_width - $lb_width - $rb_width - 50;
        }
        $left_block .= "float:right;  width:{$lb_width}px;";
        $center_block .= "float:left;  width:{$center_width}px; padding-left: 15px;";
        $right_block .= "float:right;  width:{$rb_width}px;";
        $left_block2 = $right_block2 = $center_block_content = "";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $center_width = $cb_width;
    } else {
        $center_width = $theme_width - $lb_width - $rb_width;
    }

//TYPE8:單欄式（左區域在上方，右區域在下方）
} elseif ($theme_type == 'theme_type_8') {
    if ($theme_kind == "html") {
        $center_width = $lb_width = $rb_width = $theme_width - 30;
        $left_block .= "float:none;  width:{$lb_width}px; padding-left: 10px;";
        $center_block .= "float:none;  width:{$center_width}px; padding-left: 10px;";
        $right_block .= "float:none;  width:{$rb_width}px; padding-left: 10px;";
        $left_block2 .= "";
        $right_block2 .= "";
        $center_block_content = "";
    } elseif ($theme_kind == "bootstrap4" || $theme_kind == "bootstrap5") {
        $lb_width = $center_width = $rb_width = "12";
    } else {
        $lb_width = $center_width = $rb_width = "12";
    }
}

$this->assign('base_color', $base_color);
$this->assign('content_zone', "background-color:{$base_color};");
$this->assign('leftBlocks', $left_block);
$this->assign('centerBlocks', $center_block);
$this->assign('centerBlocksContent', $center_block_content);
$this->assign('rightBlocks', $right_block);
$this->assign('leftBlocks2', $left_block2);
$this->assign('rightBlocks2', $right_block2);

$this->assign('lb_width', $lb_width);
$this->assign('cb_width', $cb_width);
$this->assign('rb_width', $rb_width);
$this->assign('center_width', $center_width);

/****設定Logo圖位置****/
$logo_place = "";
if (!empty($logo_top)) {
    $logo_place .= "top:{$logo_top}%;";
}

if (!empty($logo_bottom)) {
    $logo_place .= "bottom:{$logo_bottom}%;";
}

if ($logo_center == '1') {
    $logo_place .= "margin-left: auto; margin-right: auto; left: 0; right: 0;";
} else {
    if (!empty($logo_right)) {
        $logo_place .= "right:{$logo_right}%;";
    }

    if (!empty($logo_left)) {
        $logo_place .= "left:{$logo_left}%;";
    }

}
$this->assign('logo_place', $logo_place);

/****檢查除錯模式****/
$sql = "select conf_value from " . $xoopsDB->prefix("config") . " where conf_title ='_MD_AM_DEBUGMODE'";
$result = $xoopsDB->query($sql);
list($debug) = $xoopsDB->fetchRow($result);
if ($debug == 0) {
    $debug = 1;
} else {
    $debug = 0;
}
$this->assign('debug', $debug);

/****是否使用搜尋****/
$this->assign('use_search', 1);

/****導覽工具列、區塊標題CSS設定****/
$this->assign('navbar_pos', $navbar_pos);
$this->assign('navbar_bg_top', $navbar_bg_top);
$this->assign('navbar_bg_bottom', $navbar_bg_bottom);
$this->assign('navbar_hover', $navbar_hover);

list($navbar_bg_top_rgb['r'], $navbar_bg_top_rgb['g'], $navbar_bg_top_rgb['b']) = sscanf($navbar_bg_top, "#%02x%02x%02x");
$this->assign('navbar_bg_top_rgb', $navbar_bg_top_rgb);
list($navbar_bg_bottom_rgb['r'], $navbar_bg_bottom_rgb['g'], $navbar_bg_bottom_rgb['b']) = sscanf($navbar_bg_bottom, "#%02x%02x%02x");
$this->assign('navbar_bg_bottom_rgb', $navbar_bg_bottom_rgb);

/****若有logo.png或logo.gif時導覽工具列以圖替代網站標題文字****/
//if ($navlogo_img) {
//    $this->assign('navbar_logo_img', $navlogo_img);
//}

/****區塊標題設定****/
if ($TadThemesMid) {
    $sql = "select * from " . $xoopsDB->prefix("tad_themes_blocks") . " where `theme_id`='{$theme_id}'";
    $result = $xoopsDB->query($sql);
    //`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $block_position = $all['block_position'];
        $all['bt_bg_img'] = $all['bt_bg_img'] ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$all['bt_bg_img']}" : '';
        $db[$block_position] = $all;
    }

}

$block_position = array("leftBlock", "rightBlock", "centerBlock", "centerLeftBlock", "centerRightBlock", "centerBottomBlock", "centerBottomLeftBlock", "centerBottomRightBlock", "footerCenterBlock", "footerLeftBlock", "footerRightBlock");
$this->assign('block_position', $block_position);
$i = 0;
$positions = array();
foreach ($block_position as $position) {
    $positions[$i]['block_position'] = $position;
    $positions[$i]['block_config'] = $use_default_config ? $block_config : $db[$position]['block_config'];
    $positions[$i]['bt_text'] = $use_default_config ? $bt_text : $db[$position]['bt_text'];
    $positions[$i]['bt_text_padding'] = $use_default_config ? $bt_text_padding : $db[$position]['bt_text_padding'];
    $positions[$i]['bt_text_size'] = $use_default_config ? $bt_text_size : $db[$position]['bt_text_size'];
    $positions[$i]['bt_bg_color'] = $use_default_config ? $bt_bg_color : $db[$position]['bt_bg_color'];
    $positions[$i]['bt_bg_img'] = $use_default_config ? $bt_bg_img : $db[$position]['bt_bg_img'];
    $positions[$i]['bt_bg_repeat'] = $use_default_config ? $bt_bg_repeat : $db[$position]['bt_bg_repeat'];
    $positions[$i]['bt_radius'] = $use_default_config ? $bt_radius : $db[$position]['bt_radius'];
    $positions[$i]['block_style'] = $use_default_config ? $block_style : $db[$position]['block_style'];
    $positions[$i]['block_title_style'] = $use_default_config ? $block_title_style : $db[$position]['block_title_style'];
    $positions[$i]['block_content_style'] = $use_default_config ? $block_content_style : $db[$position]['block_content_style'];

    $this->assign($position, $positions[$i]);
    $i++;
}
$this->assign('positions', $positions);

/**** 佈景額外設定 ****/

//額外佈景設定
$config2 = [];
$config2_files = ['config2_base', 'config2_bg', 'config2_top', 'config2_logo', 'config2_nav', 'config2_slide', 'config2_middle', 'config2_content', 'config2_block', 'config2_footer', 'config2_bottom', 'config2'];

if ($TadThemesMid) {
    $config2_json_file = XOOPS_VAR_PATH . "/data/tad_themes_config2_{$theme_id}.json";
    if (file_exists($config2_json_file)) {
        $json_content = file_get_contents($config2_json_file);
        $config2 = json_decode($json_content, true);
    } else {
        $sql = "select `name`, `type`, `value` from " . $xoopsDB->prefix("tad_themes_config2") . " where `theme_id`='{$theme_id}'";
        $result = $xoopsDB->query($sql);
        while (list($name, $type, $value) = $xoopsDB->fetchRow($result)) {
            $config2[$name] = $value;
        }

        $json_content = json_encode($config2, 256);
        file_put_contents($config2_json_file, $json_content);
    }
}

/**** 依序讀取佈景額外設定檔 ****/
/**** $config 是來自 config2_xxx.php 中的設定（一律先讀取佈景檔，非風格檔，這樣才能讀到最新架構） ****/
/**** $config2 是來自 tad_themes_config2_xxx.json （或資料庫中） 中的設定 ****/

$bids = [];
foreach ($config2_files as $config2_file) {
    $theme_config = [];
    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
        require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";

        foreach ($theme_config as $k => $config) {
            $name = $config['name'];
            $value = is_null($config2[$name]) ? $config['default'] : $config2[$name];

            if ($config['type'] == "array") {
                $value = str_replace("{XOOPS_URL}", XOOPS_URL, $value);
                $value = json_decode($value, true);
            } elseif ($config['type'] == "checkbox" or $config['type'] == "custom_zone") {
                $value = json_decode($value, true);
            } elseif ($config['type'] == "file" or $config['type'] == "bg_file") {
                $value = !empty($value) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/config2/{$value}" : '';
            }
            $this->assign($name, $value);

            if ($config['type'] == "bg_file") {
                $value_repeat = is_null($config2[$name . '_repeat']) ? $config[$k]['repeat'] : $config2[$name . '_repeat'];
                $this->assign($name . '_repeat', $value_repeat);

                $value_position = is_null($config2[$name . '_position']) ? $config[$k]['position'] : $config2[$name . '_position'];
                $this->assign($name . '_position', $value_position);

                $value_size = is_null($config2[$name . '_size']) ? $config[$k]['size'] : $config2[$name . '_size'];
                $this->assign($name . '_size', $value_size);

            } elseif ($config['type'] == 'custom_zone') {
                $block_json = is_null($config2[$name . '_block']) ? $config[$k]['block'] : $config2[$name . '_block'];
                $b = json_decode($block_json, true);
                $this->assign($name . '_block', $b);
                $this->assign($name . '_bid', $b['bid']);

                // 舊版相容性設定
                $old_content = $config2[$name . '_content'];

                $value_html_content = $value_fa_content = $value_menu_content = '';
                if (in_array('html', $value)) {
                    if (!empty($config2[$name . '_html_content'])) {
                        $value_html_content = $config2[$name . '_html_content'];
                    } else {
                        $value_html_content = !empty($old_content) ? $old_content : '';
                    }
                }
                $this->assign($name . '_html_content', $value_html_content);

                if (in_array('fa-icon', $value)) {
                    if (!empty($config2[$name . '_fa_content'])) {
                        $value_fa_content = $config2[$name . '_fa_content'];
                    } else {
                        $value_fa_content = !empty($old_content) ? $old_content : '';
                    }
                }
                $this->assign($name . '_fa_content', $value_fa_content);

                if (in_array('menu', $value) and !empty($old_content)) {
                    if (!empty($config2[$name . '_menu_content'])) {
                        $value_menu_content = $config2[$name . '_menu_content'];
                    } else {
                        $value_menu_content = !empty($old_content) ? $old_content : '';
                    }
                }
                $this->assign($name . '_menu_content', $value_menu_content);

            } elseif ($config['type'] == "padding_margin") {
                $value_mt = is_null($config2[$name . '_mt']) ? $config[$k]['mt'] : $config2[$name . '_mt'];
                $this->assign($name . '_mt', $value_mt);

                $value_mb = is_null($config2[$name . '_mb']) ? $config[$k]['mb'] : $config2[$name . '_mb'];
                $this->assign($name . '_mb', $value_mb);
            }
        }
    }
}

$this->assign('bids', $bids);

/****佈景 TadDataCenter 設定****/
if (file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/TadDataCenter.php")) {
    require XOOPS_ROOT_PATH . "/modules/tadtools/TadDataCenter.php";
    $TadDataCenter = new TadDataCenter('tad_themes');
    $TadDataCenter->set_col('theme_id', $theme_id);
    $data = $TadDataCenter->getData();
    foreach ($data as $var_name => $var_val) {
        if ($var_name == 'navbar_font_size' and $var_val[0] > 10) {
            $var_val[0] = round($var_val[0] / 100, 2);
        }

        $this->assign($var_name, $var_val[0]);
    }
}

/****檢查是否開放註冊****/
$sql = "select conf_value from " . $xoopsDB->prefix("config") . " where conf_name ='allow_register'";
$result = $xoopsDB->query($sql);
list($allow_register) = $xoopsDB->fetchRow($result);
$this->assign('allow_register', $allow_register);

<{/php}>
<{includeq file="$xoops_rootpath/modules/tadtools/themes_common/get_main_var.tpl"}>
<{includeq file="$xoops_rootpath/modules/tadtools/themes_common/get_menu_var.tpl"}>
<{includeq file="$xoops_rootpath/modules/tadtools/themes_common/get_slider_var.tpl"}>
<{config_load file="$xoops_rootpath/uploads/bootstrap.conf"}>
<{assign var="bootstrap" value=$smarty.config.bootstrap}>