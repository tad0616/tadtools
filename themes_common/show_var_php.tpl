<{php}>
/****佈景額外設定****/
global $xoopsConfig, $xoopsDB;
$theme_name = $xoopsConfig['theme_set'];
require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";

$sql = "select `theme_id` from " . $xoopsDB->prefix("tad_themes") . " where `theme_name`='{$theme_name}'";
$result = $xoopsDB->query($sql) or wbe_error($sql);
list($theme_id) = $xoopsDB->fetchRow($result);

$config2 = [];
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

$tab = "                ";
$tab2 = "                        ";

//額外佈景設定
$config2_files = ['config2_base', 'config2_bg', 'config2_top', 'config2_logo', 'config2_nav', 'config2_slide', 'config2_middle', 'config2_content', 'config2_block', 'config2_footer', 'config2_bottom', 'config2'];

foreach ($config2_files as $config2_file) {
    $theme_config = [];

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {

        echo "{$tab}<tr><th colspan=3><h2>佈景額外{$config2_file}設定</h2></th></tr>\n";

        require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";

        foreach ($theme_config as $k => $config) {
            $name = $config['name'];

            $value = is_null($config2[$name]) ? $config['default'] : $config2[$name];

            if ($config['type'] == "array") {
                $value_arr = str_replace("{XOOPS_URL}", XOOPS_URL, $value);
                $value_arr = json_decode($value, value_arr);
                $value = "";
                foreach ($value_arr as $i => $items) {
                    if (is_array($items)) {
                        foreach ($items as $key => $val) {
                            $val = str_replace("{XOOPS_URL}", XOOPS_URL, $val);
                            $value .= "<div>\${$name}[$i]['$key'] = \"{$val}\";</div>";
                        }
                    } else {
                        $items = str_replace("{XOOPS_URL}", XOOPS_URL, $items);
                        $value .= "<div>\${$name}[$i] = \"{$items}\";</div>";
                    }
                }

            } elseif ($config['type'] == "checkbox" or $config['type'] == "custom_zone") {
                $real_value = json_decode($value, true);
            } elseif ($config['type'] == "file" or $config['type'] == "bg_file") {
                $value = !empty($value) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/config2/{$value}" : '';
            }

            $value = htmlspecialchars($value);

            echo "{$tab2}<tr><th>{$config['text']}</th><th>\${$name}</th><td>{$value}</td></tr>\n";

            if ($config['type'] == "bg_file") {
                $value_repeat = is_null($config2[$name . '_repeat']) ? $config[$k]['repeat'] : $config2[$name . '_repeat'];
                echo "{$tab2}<tr><th>{$config['text']} repeat</th><th>\${$name}_repeat</th><td>{$value_repeat}</td></tr>\n";
                $value_position = is_null($config2[$name . '_position']) ? $config[$k]['position'] : $config2[$name . '_position'];
                echo "{$tab2}<tr><th>{$config['text']} position</th><th>\${$name}_position</th><td>{$value_position}</td></tr>\n";
                $value_size = is_null($config2[$name . '_size']) ? $config[$k]['size'] : $config2[$name . '_size'];
                echo "{$tab2}<tr><th>{$config['text']} size</th><th>\${$name}_size</th><td>{$value_size}</td></tr>\n";
            } elseif ($config['type'] == "custom_zone") {

                $block_json = is_null($config2[$name . '_block']) ? $config[$k]['block'] : $config2[$name . '_block'];
                $b = json_decode(str_replace(["\r", "\n"], "", $block_json), true);

                echo "{$tab2}<tr><th>{$config['text']} bid</th><th>\${$name}_bid</th><td>{$b['bid']}</td></tr>\n";

                // 舊版相容性設定
                $old_content = htmlspecialchars($config2[$name . '_content']);
                echo "{$tab2}<tr><th>{$config['text']} content</th><th>\${$name}_content</th><td>{$old_content}</td></tr>\n";

                // 舊版相容性設定
                $old_content =  htmlspecialchars($config2[$name . '_content']);

                $value_html_content = $value_fa_content = $value_menu_content = '';
                if (in_array('html', $real_value)) {
                    if (!empty($config2[$name . '_html_content'])) {
                        $value_html_content = $config2[$name . '_html_content'];
                    } else {
                        $value_html_content = !empty($old_content) ? $old_content : '';
                    }
                }
                echo "{$tab2}<tr><th>{$config['text']} html_content</th><th>\${$name}_html_content</th><td>{$value_html_content}</td></tr>\n";

                $html_content_desc = isset($config['html_content_desc']) ? $config['html_content_desc'] : '';
                echo "{$tab2}<tr><th>{$config['text']} html_content_desc</th><th>\${$name}_html_content_desc</th><td>{$html_content_desc}</td></tr>\n";

                if (in_array('fa-icon', $real_value)) {
                    if (!empty($config2[$name . '_fa_content'])) {
                        $value_fa_content = $config2[$name . '_fa_content'];
                    } else {
                        $value_fa_content = !empty($old_content) ? $old_content : '';
                    }
                }
                echo "{$tab2}<tr><th>{$config['text']} fa_content</th><th>\${$name}_fa_content</th><td>{$value_fa_content}</td></tr>\n";

                $fa_content_desc = isset($config['fa_content_desc']) ? $config['fa_content_desc'] : '';
                echo "{$tab2}<tr><th>{$config['text']} fa_content_desc</th><th>\${$name}_fa_content_desc</th><td>{$fa_content_desc}</td></tr>\n";

                if (in_array('menu', $real_value) and !empty($old_content)) {
                    if (!empty($config2[$name . '_menu_content'])) {
                        $value_menu_content = $config2[$name . '_menu_content'];
                    } else {
                        $value_menu_content = !empty($old_content) ? $old_content : '';
                    }
                }
                echo "{$tab2}<tr><th>{$config['text']} menu_content</th><th>\${$name}_menu_content</th><td>{$value_menu_content}</td></tr>\n";

                $menu_content_desc = isset($config['menu_content_desc']) ? $config['menu_content_desc'] : '';
                echo "{$tab2}<tr><th>{$config['text']} menu_content_desc</th><th>\${$name}_menu_content_desc</th><td>{$menu_content_desc}</td></tr>\n";
            } elseif ($config['type'] == "padding_margin") {
                $value_mt = is_null($config2[$name . '_mt']) ? $config[$k]['mt'] : $config2[$name . '_mt'];
                echo "{$tab2}<tr><th>{$config['text']} margin-top</th><th>\${$name}_mt</th><td>{$value_mt}</td></tr>\n";
                $value_mb = is_null($config2[$name . '_mb']) ? $config[$k]['mb'] : $config2[$name . '_mb'];
                echo "{$tab2}<tr><th>{$config['text']} margin-bottom</th><th>\${$name}_mb</th><td>{$value_mb}</td></tr>\n";

            }
        }
    }
}
<{/php}>