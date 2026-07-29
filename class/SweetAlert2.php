<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class SweetAlert2
{
    private $show_jquery;
    private $showConfirmButton  = 'true';
    private $timer              = 0;
    private $html               = '';
    private $showCancelButton   = 'true';
    private $confirmButtonColor = '#DD6B55';
    private $cancelButtonColor  = '#8c8c8c';
    private $closeOnConfirm     = 'false';
    private $allowOutsideClick  = 'true';
    private $confirmButtonText  = '確定刪除！';
    private $method             = 'get'; // 新增：預設為 get

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
        xoops_loadLanguage('main', 'tadtools');
    }

    //設定變數
    public function setVar($var = '', $val = '')
    {
        $this->$var = $val;
    }

    //產生語法
    public function render($func_name = '', $url = '', $var = null, $title = _TAD_DEL_CONFIRM_TITLE, $text = _TAD_DEL_CONFIRM_TEXT)
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';

        if (is_array($var)) {
            $parm_var       = [];
            $href           = [];
            $post_fields    = []; // 新增：收集固定的 POST 欄位（key=value 形式）
            $dynamic_fields = []; // 新增：收集動態的 POST 欄位（變數形式）

            foreach ($var as $key => $value) {
                if (is_string($key)) {
                    $href[]        = "{$key}={$value}";
                    $post_fields[] = "'{$key}': '{$value}'"; // 靜態欄位
                } else {
                    $href[]           = "{$value}=' + $value + '";
                    $parm_var[]       = $value;
                    $dynamic_fields[] = "'{$value}': {$value}"; // 動態欄位（JS 變數）
                }
            }
            $href     = "'{$url}" . implode('&', $href) . "'";
            $parm_var = implode(', ', $parm_var);

            // 合併靜態與動態欄位，產生 JS 物件字串
            $all_post_fields = array_merge($post_fields, $dynamic_fields);
            $post_data_js    = '{' . implode(', ', $all_post_fields) . '}';

            // 解析 URL 中的固定參數（例如 url = "ajax.php?op=del&modsn=1"）
            $url_parts    = parse_url($url);
            $base_url     = ($url_parts['path'] ?? $url);
            $query_string = $url_parts['query'] ?? '';
            if ($query_string) {
                parse_str($query_string, $query_params);
                foreach ($query_params as $k => $v) {
                    // 若 post_fields 中尚未包含，則補入
                    $post_data_js = rtrim($post_data_js, '}') . ", '{$k}': '{$v}'}";
                }
            }
        } else {
            // 非陣列：解析 URL 與單一參數
            $url_parts    = parse_url($url);
            $base_url     = ($url_parts['path'] ?? $url);
            $query_string = $url_parts['query'] ?? '';
            $query_params = [];
            if ($query_string) {
                parse_str($query_string, $query_params);
            }

            $href     = empty($var) ? "'$url'" : "'$url' + $var";
            $parm_var = $var;

            // 將 URL query 參數轉為 JS 物件
            $post_fields = [];
            foreach ($query_params as $k => $v) {
                $post_fields[] = "'{$k}': '{$v}'";
            }
            // 加入動態變數參數
            if (!empty($var)) {
                // 嘗試從原始 URL 末尾取得參數名稱（例如 "ajax.php?op=del&mssn=" → 最後一個 key 為空值）
                // 若 URL 結尾是 "key=" 形式，取出 key 名
                if (preg_match('/[?&]([^=&]+)=$/', $url, $matches)) {
                    $dynamic_key = $matches[1];
                    // 從 base_url 移除結尾的 &key= 或 ?key=
                    $base_url      = preg_replace('/[?&]' . preg_quote($dynamic_key, '/') . '=$/', '', $url);
                    $url_parts2    = parse_url($base_url);
                    $base_url      = $url_parts2['path'] ?? $base_url;
                    $query_string2 = $url_parts2['query'] ?? '';
                    if ($query_string2) {
                        parse_str($query_string2, $query_params2);
                        $post_fields = [];
                        foreach ($query_params2 as $k => $v) {
                            $post_fields[] = "'{$k}': '{$v}'";
                        }
                    }
                    $post_fields[] = "'{$dynamic_key}': {$var}";
                } else {
                    $post_fields[] = "'value': {$var}";
                }
            }
            $post_data_js = '{' . implode(', ', $post_fields) . '}';
        }

        // 判斷是否使用 POST
        $is_post = (strtolower($this->method) === 'post');

        if ($is_post) {
            // POST 提交：動態建立 form 並送出
            $confirmed_action = "
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{$base_url}';
                    var data = {$post_data_js};
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            var input = document.createElement('input');
                            input.type  = 'hidden';
                            input.name  = key;
                            input.value = data[key];
                            form.appendChild(input);
                        }
                    }
                    document.body.appendChild(form);
                    form.submit();
            ";
        } else {
            // GET 提交（原本行為）
            $confirmed_action = "location.href={$href};";
        }

        if ($func_name) {
            $func = "
            function {$func_name}($parm_var){
                swal.fire({
                    title: '$title',
                    text: '$text',
                    html: '{$this->html}',
                    timer: $this->timer,
                    showConfirmButton: $this->showConfirmButton,
                    showCancelButton: $this->showCancelButton,
                    confirmButtonColor: '{$this->confirmButtonColor}',
                    confirmButtonText: '{$this->confirmButtonText}',
                    cancelButtonColor: '{$this->cancelButtonColor}',
                    closeOnConfirm: $this->closeOnConfirm,
                    allowOutsideClick: $this->allowOutsideClick
                }).then((result) => {
                    if (result.isConfirmed) {
                        $confirmed_action
                    }
                });
            }
            ";
        } else {
            $func = '';
        }

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/sweet-alert/sweetalert2.min.css');
            $xoTheme->addScript('modules/tadtools/sweet-alert/sweetalert2.all.min.js');
            $xoTheme->addScript('', null, $func);
        } else {
            $main = "
            {$jquery}
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/sweet-alert/sweetalert2.min.css' />
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/sweet-alert/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
            $func
            </script>";

            return $main;
        }
    }
}

/*
使用方式
原本 GET（不變）
$SweetAlert2 = new SweetAlert2();
$SweetAlert2->render("del_table", "ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=", 'mssn');
改用 POST
$SweetAlert2 = new SweetAlert2();
$SweetAlert2->setVar('method', 'post'); // ← 只需加這一行
$SweetAlert2->render("del_table", "ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=", 'mssn');
 */
