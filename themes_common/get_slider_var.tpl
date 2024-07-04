<{*
<{php}>
global $xoopsDB, $xoopsTpl, $xoopsConfig;

function get_theme_slide_items()
{
    global $xoopsDB, $xoopsConfig;
    $sql = "select a.* from " . $xoopsDB->prefix("tad_themes_files_center") . " as a left join " . $xoopsDB->prefix("tad_themes") . " as b on a.col_sn=b.theme_id  where a.`col_name`='slide' and b.`theme_name`='{$xoopsConfig['theme_set']}'";

    $result = $xoopsDB->query($sql);

    if ($result) {
        $i = 0;
        while (false !== ($data = $xoopsDB->fetchArray($result))) {
            foreach ($data as $k => $v) {
                $$k = $v;
            }
            //`files_sn`, `col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir`

            preg_match_all("/\](.*)\[/", $description, $matches);
            $url = isset($matches[1][0])?$matches[1][0]:'';
            if (empty($url)) {
                $url = XOOPS_URL;
            }

            if (strpos($description, 'url_blank') !== false) {
                $description = str_replace("[url_blank]{$url}[/url_blank]", "", $description);
                $target      = "target='_blank'";
            } else {
                $description = str_replace("[url]{$url}[/url]", "", $description);
                $target      = "";
            }

            $slider_var[$i]['files_sn']          = $files_sn;
            $slider_var[$i]['sort']              = $sort;
            $slider_var[$i]['file_name']         = $file_name;
            $slider_var[$i]['description']       = $description;
            $slider_var[$i]['text_description']  = strip_tags($description);
            $slider_var[$i]['original_filename'] = $original_filename;
            $slider_var[$i]['sub_dir']           = $sub_dir;
            $slider_var[$i]['file_url']          = XOOPS_URL . "/uploads/tad_themes{$sub_dir}/{$file_name}";
            $slider_var[$i]['file_thumb_url']    = XOOPS_URL . "/uploads/tad_themes{$sub_dir}/thumbs/{$file_name}";
            $slider_var[$i]['slide_url']         = $url;
            $slider_var[$i]['slide_target']      = $target;
            $i++;
        }
    }
    return $slider_var;

}
$slider_var = get_theme_slide_items();
$xoopsTpl->assign('slider_var', $slider_var);

<{/php}>
*}>