<{php}>
global $xoopsDB, $xoopsConfig, $xoopsModule;
if (file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/ResponsiveSlides.php")) {
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/ResponsiveSlides.php";
    $ResponsiveSlides     = new slider(120, false);
    $no_item_slide_images = true;

    //假如有專屬圖文
    $http = 'http://';
    if (!empty($_SERVER['HTTPS'])) {
        $http = ($_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
    }
    $now_url = $http . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
    if ($xoopsModule) {
        $sql    = "select `menuid`,`itemname`,`itemurl` from " . $xoopsDB->prefix("tad_themes_menu") . "";
        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());

        while (list($menuid, $itemname, $itemurl) = $xoopsDB->fetchRow($result)) {

            $patten_arr = explode("?", $itemurl);
            if (empty($patten_arr[0])) {
                continue;
            }

            if (strpos($now_url, $patten_arr[0]) !== false and (preg_match("/{$patten_arr[1]}&/", $now_url) or preg_match("/{$patten_arr[1]}$/", $now_url))) {
                if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/menu_banner/{$menuid}.png")) {
                    $ResponsiveSlides->add_content(1, '', "", XOOPS_URL . "/uploads/tad_themes/menu_banner/{$menuid}.png", "", $itemurl);
                    $no_item_slide_images = false;
                }
            }
        }

    }


    if ($no_item_slide_images) {
        $sql = "select a.* from " . $xoopsDB->prefix("tad_themes_files_center") . " as a left join " . $xoopsDB->prefix("tad_themes") . " as b on a.col_sn=b.theme_id  where a.`col_name`='slide' and b.`theme_name`='{$xoopsConfig['theme_set']}'";

        $result = $xoopsDB->query($sql);

        $slide_images = 0;
        while ($data = $xoopsDB->fetchArray($result)) {
            foreach ($data as $k => $v) {
                $$k = $v;
                //$this->assign($k,$$k);
            }
            $slide_images++;

            preg_match_all("/\](.*)\[/", $description, $matches);
            $url = $matches[1][0];
            if (empty($url)) {
                $url = XOOPS_URL;
            }

            if (strpos($description, 'url_blank') !== false) {
                $description  = str_replace("[url_blank]{$url}[/url_blank]", "", $description);
                $slide_target = "target='_blank'";
            } else {
                $description  = str_replace("[url]{$url}[/url]", "", $description);
                $slide_target = "";
            }

            $ResponsiveSlides->add_content($files_sn, $title, $description, XOOPS_URL . "/uploads/tad_themes/{$xoopsConfig['theme_set']}/slide/{$file_name}", $date, $url, '100%', '', $slide_target);
        }

        if (empty($slide_images)) {
            $title   = $xoopsConfig['sitename'];
            $content = $xoopsConfig['meta_description'];
            $ResponsiveSlides->add_content(1, $title, $content, XOOPS_URL . "/themes/{$xoopsConfig['theme_set']}/images/slide/default.png", $date, XOOPS_URL);
            $ResponsiveSlides->add_content(2, $title, $content, XOOPS_URL . "/themes/{$xoopsConfig['theme_set']}/images/slide/default2.png", $date, XOOPS_URL);
            $ResponsiveSlides->add_content(3, $title, $content, XOOPS_URL . "/themes/{$xoopsConfig['theme_set']}/images/slide/default3.png", $date, XOOPS_URL);
        }
    }

    $sql = "select a.`value` from " . $xoopsDB->prefix("tad_themes_config2") . " as a left join " . $xoopsDB->prefix("tad_themes") . " as b on a.theme_id=b.theme_id where a.`name`='slide_timeout' and b.`theme_name`='{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql);
    list($slide_timeout) = $xoopsDB->fetchRow($result);

    $sql = "select a.`value` from " . $xoopsDB->prefix("tad_themes_config2") . " as a left join " . $xoopsDB->prefix("tad_themes") . " as b on a.theme_id=b.theme_id where a.`name`='slide_nav' and b.`theme_name`='{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql);
    list($slide_nav) = $xoopsDB->fetchRow($result);

    $slide_images = $ResponsiveSlides->render(null, null, $slide_timeout, $slide_nav);
    echo $slide_images;
}

<{/php}>