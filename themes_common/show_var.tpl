<{if $xoops_isadmin}>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" style="background:white;">
                                <tr><th colspan=3><h2>基本設定</h2></th></tr>
                                <tr><th>佈景種類</th><th>$theme_kind</th><td><{$theme_kind}></td></tr>
                                <tr><th>佈景編號</th><th>$theme_id</th><td><{$theme_id}></td></tr>
                                <tr><th>佈景名稱</th><th>$theme_name</th><td><{$theme_name}></td></tr>
                                <tr><th>bootstrap顏色</th><th>$theme_color</th><td><{$theme_color}></td></tr>
                                <tr><th>載入選單種類</th><th>$menu_var_kind</th><td><{$menu_var_kind}></td></tr>
                                <tr><th>開除錯</th><th>$debug</th><td><{$debug}></td></tr>
                                <tr><th>顯示搜尋工具</th><th>$use_search</th><td><{$use_search}></td></tr>
                                <tr><th>內容區設定</th><th>$content_zone</th><td><{$content_zone}></td></tr>
                                <tr><th>左區域設定</th><th>$leftBlocks</th><td><{$leftBlocks}></td></tr>
                                <tr><th>中區域設定</th><th>$centerBlocks</th><td><{$centerBlocks}></td></tr>
                                <tr><th>右區域設定</th><th>$rightBlocks</th><td><{$rightBlocks}></td></tr>
                                <tr><th>第二左區域設定</th><th>$leftBlocks2</th><td><{$leftBlocks2}></td></tr>
                                <tr><th>第二右區域設定</th><th>$rightBlocks2</th><td><{$rightBlocks2}></td></tr>
                                <tr><th>樣板設定檔</th><th>$xoops_themecss</th><td><{$xoops_themecss}></td></tr>

                                <tr><th colspan=3><h2>Tad Themes 偏好設定</h2></th></tr>
                                <tr><th>是否在工具列顯示網站標題文字</th><th>$auto_mainmenu</th><td><{$auto_mainmenu}></td></tr>
                                <tr><th>顯示主選單下拉選單</th><th>$show_sitename</th><td><{$show_sitename}></td></tr>

                                <tr><th colspan=3><h2>Tad Tools 偏好設定</h2></th></tr>
                                <tr><th>導覽列的登入呈現方式</th><th>$openid_login</th><td><{$openid_login}></td></tr>
                                <tr><th>登入選單一排要呈現幾個OpenID圖示</th><th>$openid_logo</th><td><{$openid_logo}></td></tr>
                                <tr><th>是否釘選住導覽列？</th><th>$use_pin</th><td><{$use_pin}></td></tr>

                                <tr><th colspan=3><h2>其他設定</h2></th></tr>
                                <tr><th>左邊區塊數</th><th>$left_count</th><td><{$left_count}></td></tr>
                                <tr><th>右邊區塊數</th><th>$right_count</th><td><{$right_count}></td></tr>
                                <tr><th>選單是否有用到 popup 模式</th><th>$have_popup</th><td><{$have_popup}></td></tr>
                                <tr><th>popup 語法</th><th>$tad_themes_popup_code</th><td><{$tad_themes_popup_code}></td></tr>

                                <tr><th colspan=3><h2>網頁布局設定</h2></th></tr>
                                <tr><th>版面類型</th><th>$theme_type</th><td><{$theme_type}></td></tr>
                                <tr><th>版面寬度</th><th>$theme_width</th><td><{$theme_width}></td></tr>
                                <tr><th>文字大小</th><th>$font_size</th><td><{$font_size}></td></tr>
                                <tr><th>內容區顏色</th><th>$base_color</th><td><{$base_color}></td></tr>
                                <tr><th>左區塊顏色</th><th>$lb_color</th><td><{$lb_color}></td></tr>
                                <tr><th>中區塊顏色</th><th>$cb_color</th><td><{$cb_color}></td></tr>
                                <tr><th>右區塊顏色</th><th>$rb_color</th><td><{$rb_color}></td></tr>
                                <tr><th>左區塊寬度</th><th>$lb_width</th><td><{$lb_width}></td></tr>
                                <tr><th>中區塊寬度</th><th>$center_width</th><td><{$center_width}></td></tr>
                                <tr><th>右區塊寬度</th><th>$rb_width</th><td><{$rb_width}></td></tr>
                                <tr><th>中左區塊寬度</th><th>$clb_width</th><td><{$clb_width}></td></tr>
                                <tr><th>中右區塊寬度</th><th>$crb_width</th><td><{$crb_width}></td></tr>
                                <tr><th>上方邊界</th><th>$margin_top</th><td><{$margin_top}></td></tr>
                                <tr><th>下方邊界</th><th>$margin_bottom</th><td><{$margin_bottom}></td></tr>
                                <tr><th>文字顏色</th><th>$font_color</th><td><{$font_color}></td></tr>
                                <tr><th>連結顏色</th><th>$link_color</th><td><{$link_color}></td></tr>
                                <tr><th>滑鼠移到連結顏色</th><th>$hover_color</th><td><{$hover_color}></td></tr>

                                <tr><th colspan=3><h2>背景圖設定</h2></th></tr>
                                <tr><th>預設背景圖</th><th>$bg_img</th><td><{$bg_img}></td></tr>
                                <tr><th>背景顏色</th><th>$bg_color</th><td><{$bg_color}></td></tr>
                                <tr><th>背景重複</th><th>$bg_repeat</th><td><{$bg_repeat}></td></tr>
                                <tr><th>背景模式</th><th>$bg_attachment</th><td><{$bg_attachment}></td></tr>
                                <tr><th>背景位置</th><th>$bg_position</th><td><{$bg_position}></td></tr>

                                <tr><th colspan=3><h2>滑動圖片設定</h2></th></tr>
                                <tr><th>滑動圖片寬度</th><th>$slide_width</th><td><{$slide_width}></td></tr>
                                <tr><th>滑動圖片高度</th><th>$slide_height</th><td><{$slide_height}></td></tr>
                                <tr><th>是否可上傳滑動圖片</th><th>$use_slide</th><td><{$use_slide}></td></tr>

                                <tr><th colspan=3><h2>logo 圖設定</h2></th></tr>
                                <tr><th>logo 圖</th><th>$logo_img</th><td><{$logo_img}></td></tr>
                                <tr><th>logo 圖位置</th><th>$logo_position</th><td><{$logo_position}></td></tr>
                                <tr><th>logo 圖上方位置</th><th>$logo_top</th><td><{$logo_top}>%</td></tr>
                                <tr><th>logo 圖右方位置</th><th>$logo_right</th><td><{$auto_mainlogo_rightmenu}>%</td></tr>
                                <tr><th>logo 圖下方位置</th><th>$logo_bottom</th><td><{$logo_bottom}>%</td></tr>
                                <tr><th>logo 圖左方位置</th><th>$logo_left</th><td><{$logo_left}>%</td></tr>
                                <tr><th>logo 圖置中</th><th>$logo_center</th><td><{$logo_center}></td></tr>
                                <tr><th>Logo 圖位置</th><th>$logo_place</th><td><{$logo_place}></td></tr>

                            <{foreach from=$positions item=bt}>

                                <tr><th colspan=3><h2><{$bt.block_position}>區塊標題設定</h2></th></tr>
                                <tr><th>區塊標題列背景重複</th><th>$<{$bt.block_position}>.bt_bg_repeat</th><td><{$bt.bt_bg_repeat}></td></tr>
                                <tr><th>區塊標題列背景圖</th><th>$<{$bt.block_position}>.bt_bg_img</th><td><{$bt.bt_bg_img}></td></tr>
                                <tr><th>區塊標題文字縮排</th><th>$<{$bt.block_position}>.bt_text_padding</th><td><{$bt.bt_text_padding}></td></tr>
                                <tr><th>區塊標題文字大小</th><th>$<{$bt.block_position}>.bt_text_size</th><td><{$bt.bt_text_size}></td></tr>
                                <tr><th>區塊標題列文字顏色</th><th>$<{$bt.block_position}>.bt_text</th><td><{$bt.bt_text}></td></tr>
                                <tr><th>區塊標題列背景顏色</th><th>$<{$bt.block_position}>.bt_bg_color</th><td><{$bt.bt_bg_color}></td></tr>
                                <tr><th>區塊標題工具按鈕</th><th>$<{$bt.block_position}>.block_config</th><td><{$bt.block_config}></td></tr>
                                <tr><th>區塊標題圓角設定</th><th>$<{$bt.block_position}>.bt_radius</th><td><{$bt.bt_radius}></td></tr>
                                <tr><th>區塊整體樣式手動設定</th><th>$<{$bt.block_position}>.block_style</th><td><{$bt.block_style}></td></tr>
                                <tr><th>區塊標題區樣式手動設定</th><th>$<{$bt.block_position}>.block_title_style</th><td><{$bt.block_title_style}></td></tr>
                                <tr><th>區塊內容區樣式手動設定</th><th>$<{$bt.block_position}>.block_content_style</th><td><{$bt.block_content_style}></td></tr>
                            <{/foreach}>

                                <tr><th colspan=3><h2>導覽列設定</h2></th></tr>
                                <tr><th>導覽列位置</th><th>$navbar_pos</th><td><{$navbar_pos}></td></tr>
                                <tr><th>導覽列漸層顏色(top)</th><th>$navbar_bg_top</th><td><{$navbar_bg_top}></td></tr>
                                <tr><th>導覽列漸層顏色(bottom)</th><th>$navbar_bg_bottom</th><td><{$navbar_bg_bottom}></td></tr>
                                <tr><th>導覽列連結區塊底色</th><th>$navbar_hover</th><td><{$navbar_hover}></td></tr>
                                <tr><th>導覽列文字顏色</th><th>$navbar_color</th><td><{$navbar_color}></td></tr>
                                <tr><th>導覽列文字移過顏色</th><th>$navbar_color_hover</th><td><{$navbar_color_hover}></td></tr>
                                <tr><th>導覽列圖示顏色</th><th>$navbar_icon</th><td><{$navbar_icon}></td></tr>
                                <tr><th>導覽選項上下距離</th><th>$navbar_py</th><td><{$navbar_py}></td></tr>
                                <tr><th>導覽選項左右距離</th><th>$navbar_px</th><td><{$navbar_px}></td></tr>
                                <tr><th>導覽列背景圖</th><th>$navbar_img</th><td><{$navbar_img}></td></tr>

                                <tr><th colspan=3><h2>導覽列 logo 圖設定</h2></th></tr>
                                <tr><th>導覽列圖示(舊)</th><th>$navbar_logo_img</th><td><{$navbar_logo_img}></td></tr>
                                <tr><th>導覽列 logo 圖</th><th>$logo_img</th><td><{$logo_img}></td></tr>

                                <tr><th colspan=3><h2>自訂選單 $menu_var</h2></th></tr>

                        <{foreach from=$menu_var item=m}>

                                <tr>
                                    <th><{$m.title}></th>
                                    <th>$menu_var[<{$m.id}>]</th>
                                    <td>
                                        $menu_var[<{$m.id}>]['id'] = <{$m.id}>;<br>
                                        $menu_var[<{$m.id}>]['title'] = "<{$m.title}>";<br>
                                        $menu_var[<{$m.id}>]['url'] = "<{$m.url}>";<br>
                                        $menu_var[<{$m.id}>]['target'] = "<{$m.target}>";<br>
                                        $menu_var[<{$m.id}>]['icon'] = "<{$m.icon}>";<br>
                                        $menu_var[<{$m.id}>]['img'] = "<{$m.img}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'] = "<{$m.submenu}>";
                                    </td>
                                </tr>

                            <{if $m.submenu}>
                            <{foreach from=$m.submenu item=m2}>

                                <tr>
                                    <th><{$m2.title}></th>
                                    <th>$menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]</th>
                                    <td>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['id'] = <{$m2.id}>;<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['title'] = "<{$m2.title}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['url'] = "<{$m2.url}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['target'] = "<{$m2.target}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['icon'] = "<{$m2.icon}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['img'] = "<{$m2.img}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'] = "<{$m2.submenu}>";
                                    </td>
                                </tr>

                                <{if $m2.submenu}>
                                <{foreach from=$m2.submenu item=m3}>

                                <tr>
                                    <th><{$m3.title}></th>
                                    <th>$menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]</th>
                                    <td>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['id'] = <{$m3.id}>;<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['title'] = "<{$m3.title}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['url'] = "<{$m3.url}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['target'] = "<{$m3.target}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['icon'] = "<{$m3.icon}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['img'] = "<{$m3.img}>";<br>
                                        $menu_var[<{$m.id}>]['submenu'][<{$m2.id}>]['submenu'][<{$m3.id}>]['submenu'] = "<{$m3.submenu}>";
                                    </td>
                                </tr>
                                <{/foreach}><{/if}>
                            <{/foreach}><{/if}>
                        <{/foreach}>

                                <tr><th colspan=3><h2>滑動圖文 $slider_var</h2></th></tr>
                            <{foreach from=$slider_var item=slide}>

                                <tr>
                                    <th><img src="<{$slide.file_thumb_url}>" alt="<{$slide.file_name}>" title="<{$slide.file_name}>"></th>
                                    <th>$slider_var[<{$slide.files_sn}>]</th>
                                    <td>
                                        $slider_var[<{$slide.files_sn}>]['files_sn'] = <{$slide.files_sn}>;<br>
                                        $slider_var[<{$slide.files_sn}>]['sort'] = <{$slide.sort}>;<br>
                                        $slider_var[<{$slide.files_sn}>]['file_name'] = "<{$slide.file_name}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['description'] = "<{$slide.description}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['text_description'] = "<{$slide.text_description}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['original_filename'] = "<{$slide.original_filename}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['sub_dir'] = "<{$slide.sub_dir}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['file_url'] = "<{$slide.file_url}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['file_thumb_url'] = "<{$slide.file_thumb_url}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['slide_url'] = "<{$slide.slide_url}>";<br>
                                        $slider_var[<{$slide.files_sn}>]['slide_target'] = "<{$slide.slide_target}>";
                                    </td>
                                </tr>
                            <{/foreach}>
        <{php}>

        /****佈景額外設定****/
        global $xoopsConfig,$xoopsDB;
        include_once XOOPS_ROOT_PATH."/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
        $theme_name=$xoopsConfig['theme_set'];

        $sql="select `theme_id` from ".$xoopsDB->prefix("tad_themes")." where `theme_name`='{$theme_name}'";
        $result=$xoopsDB->query($sql) or wbe_error($sql);
        list($theme_id)=$xoopsDB->fetchRow($result);

        $sql="select `name`, `type`, `value` from ".$xoopsDB->prefix("tad_themes_config2")." where `theme_id`='{$theme_id}'";
        $config2="";
        $result=$xoopsDB->query($sql) or wbe_error($sql);
        while(list($name,$type,$value)=$xoopsDB->fetchRow($result)){
            $config2[$name]=$value;
        }


        //額外佈景設定
        $config2_files=array('config2_base','config2_bg','config2_slide','config2_logo','config2_block','config2_nav','config2');
        foreach($config2_files as $config2_file){

            if(file_exists(XOOPS_ROOT_PATH."/themes/{$theme_name}/{$config2_file}.php")){

                echo "                <tr><th colspan=3><h2>佈景額外{$config2_file}設定</h2></th></tr>\n";
                require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";
                foreach($theme_config as $k=>$config){
                    $name=$config['name'];
                    $value=is_null($config2[$name])?$config['default']:$config2[$name];
                    if($config['type']=="array"){
                    $value_arr=json_decode($value,true);
                    $value="";
                    foreach($value_arr as $i=>$items){
                        if(is_array($items)){
                        foreach($items as $key=>$val){
                            $val=str_replace("{XOOPS_URL}",XOOPS_URL,$val);
                            $value.="<div>\${$name}[$i]['$key'] = \"{$val}\";</div>";
                        }
                        }else{
                            $items=str_replace("{XOOPS_URL}",XOOPS_URL,$items);
                            $value.="<div>\${$name}[$i] = \"{$items}\";</div>";
                        }
                    }
                    }

                    echo "                        <tr><th>{$config['text']}</th><th>\${$name}</th><td>{$value}</td></tr>\n";
                }
            }
        }


        <{/php}>

                            </table>
                        </div>
                    </div>

<{/if}>
