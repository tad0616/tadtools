<?php
namespace XoopsModules\Tadtools;

use Xmf\Request;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\My97DatePicker;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

class TadModData
{
    private $dirname;
    private $table;
    private $schema = [];
    private $var_type = [];
    private $pagebar;
    private $where;
    private $order;
    private $primary;
    private $my_elements = [];
    private $my_elements_options = [];
    private $my_elements_default = [];
    private $change_elements = [];
    private $show_left = 2;
    private $show_right = 10;
    private $form_left = 2;
    private $form_right = 10;
    private $use_file;
    private $TadUpFiles;
    private $file_index_mode;
    private $file_show_mode;
    private $file_maxlength;
    private $file_only_type;
    private $replace_col = [];
    private $need_replace = [];
    private $uid_col = [];
    private $uid_col_arr = [];
    private $disable_index_col = [];
    private $disable_show_col = [];
    private $disable_create_col = [];
    private $hide_create_col = [];
    private $set_link_col = [];
    private $need_link = [];
    private $add_index_btn = [];
    private $add_show_btn = [];
    private $add_create_btn = [];
    private $func = [];
    private $sort_col;
    private $submit = [];
    private $require_col = [];
    private $require_arr = [];
    private $allow_groups = [];
    private $attr = [];
    private $my_show_col = [];
    private $my_show_col_arr = [];
    private $index_callback = [];
    private $show_callback = [];
    private $replace_callback = [];

    // 建構函數
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1595
    public function __construct($table)
    {
        global $xoopsDB, $xoopsModule;
        if (!$xoopsModule) {
            preg_match('/\/modules\/(\w*)\//', $_SERVER['HTTP_REFERER'], $matches);
            $this->dirname = $matches[1];
        } else {
            $this->dirname = $xoopsModule->dirname();
        }
        $this->table = $table;

        $sql = "show full columns from `" . $xoopsDB->prefix($table) . "`";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // Field    Type    Null    Key    Default    Extra
        while ($all = $xoopsDB->fetchArray($result)) {
            foreach ($all as $k => $v) {
                $$k = $v;
            }
            $this->var_type[$Field] = $Type;
            $this->schema[$Field] = $all;
            if ($Key == "PRI") {
                $this->primary = $Field;
            }
        }

        $this->set_attr('table', ['class' => 'table table-hover table-striped'], 'default');
        $this->set_attr('tr1', ['class' => 'bg-info white'], 'default');
        $this->set_attr('th', ['class' => 'text-center'], 'default');
        $this->set_attr('td', ['class' => 'text-center'], 'default');

    }

    // 設定成員變數值
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1596
    public function set_var($name, $value)
    {
        $this->$name = $value;
    }

    // 過濾接收的變數
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1597
    public function clean()
    {
        $clean = [];
        foreach ($_REQUEST as $var => $val) {
            if (strpos($this->var_type[$var], 'int') !== false) {
                $clean[$var] = Request::getInt($var);
            } elseif (is_numeric($val)) {
                $clean[$var] = Request::getInt($var);
            } elseif (is_array($val)) {
                $clean[$var] = Request::getArray($var);
            } else {
                $clean[$var] = Request::getString($var);
            }
        }
        return $clean;
    }

    // 取得指定資料之陣列
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1598
    public function get_arr($table, $key, $value)
    {
        global $xoopsDB, $xoopsTpl;
        $sql = "select `$key`,`$value` from `" . $xoopsDB->prefix($table) . "` {$this->order}" . " order by $key";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $arr = [];
        while (list($k, $v) = $xoopsDB->fetchRow($result)) {
            $arr[$k] = $v;
        }

        $xoopsTpl->assign($key . "_arr", $arr);
        return $arr;
    }

    //指定哪些方法允許哪些群組操作
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1599
    public function allow($func_arr = [], $groups = [])
    {
        foreach ($func_arr as $func) {
            $this->allow_groups[$func] = $groups;
        }
        return $this;
    }

    // 檢查權限
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1600
    public function chk_allow($func, $redirect = '')
    {
        global $xoopsUser;
        $allow = true;
        if (isset($this->allow_groups[$func]) and !empty($this->allow_groups[$func])) {
            $user_groups = ($xoopsUser) ? $xoopsUser->groups() : [3];
            $in_allow_group = array_intersect($this->allow_groups[$func], $user_groups);
            $allow = sizeof($in_allow_group) ? true : false;
            if (!$allow) {
                $redirect = empty($redirect) ? $_SERVER['HTTP_REFERER'] : $redirect;
                redirect_header($redirect, 3, _TAD_PERMISSION_DENIED);
            }
        }
        return $allow;
    }

    // 設定屬性
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1601
    public function set_attr($kind, $attrs = [], $mode = '')
    {
        foreach ($attrs as $attr_name => $attr_value) {
            if ($mode == "default" and !isset($this->attr[$kind][$attr_name]) and empty($this->attr[$kind][$attr_name])) {
                $this->attr[$kind][$attr_name] = $attr_value;
            } elseif ($mode == "append" and isset($this->attr[$kind][$attr_name])) {
                $this->attr[$kind][$attr_name] .= ' ' . $attr_value;
            } elseif ($mode == "") {
                $this->attr[$kind][$attr_name] = $attr_value;
            }
        }
        return $this;
    }

    // 取得屬性字串
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1602
    private function get_attr($kind, $def_kind = '')
    {
        $attr = '';
        $attr_arr = [];
        if (is_array($kind)) {
            foreach ($kind as $k) {
                $k = isset($this->attr[$k]) ? $k : $def_kind;
                if (isset($this->attr[$k])) {
                    foreach ($this->attr[$k] as $attr_name => $attr_value) {
                        $attr_name_arr[$attr_name][] = $attr_value;
                    }
                }
            }

            foreach ($attr_name_arr as $attr_name => $attr_value_arr) {
                $attr_arr[] = $attr_name . ' = "' . implode(' ', $attr_value_arr) . '"';
            }
        } else {
            $k = isset($this->attr[$kind]) ? $kind : $def_kind;
            if (isset($this->attr[$k])) {
                foreach ($this->attr[$k] as $attr_name => $attr_value) {
                    $attr_arr[] = $attr_name . ' = "' . $attr_value . '"';
                }
            }
        }

        $attr = implode(' ', $attr_arr);
        return $attr;
    }

    /*********** 基本功能 ************/

    // 新增表單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1603
    public function create($def_val = [], $action = '', $id_name = 'myForm')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser, $xoTheme;

        $this->chk_allow(__FUNCTION__);

        require_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $XoopsFormHiddenToken = new \XoopsFormHiddenToken();
        $token = $XoopsFormHiddenToken->render();

        if (empty($action)) {
            $action = $_SERVER['PHP_SELF'];
        }

        $FormValidator = new FormValidator("#{$id_name}", false);
        $FormValidator->render('topLeft');

        $elements = [];
        $i = 0;
        foreach ($this->schema as $col_name => $schema) {
            if (!empty($this->disable_create_col) and in_array($col_name, $this->disable_create_col)) {
                continue;
            }
            $elements[$i]['col_name'] = $col_name;
            $elements[$i]['label'] = $schema['Comment'];
            $elements[$i]['show'] = in_array($col_name, $this->hide_create_col) ? false : true;

            $validate = $this->get_validate($col_name);

            if (!empty($this->my_elements[$col_name])) {
                $elements[$i]['form'] = $this->mk_elements($col_name, $def_val[$col_name], $validate);
            } elseif (!empty($this->change_elements[$col_name])) {
                $elements[$i]['form'] = $this->change_elements[$col_name];
            } elseif ($schema['Field'] == 'uid') {
                $elements[$i]['show'] = false;
                $uid = ($xoopsUser) ? $xoopsUser->uid() : 0;
                $elements[$i]['form'] = '<input type="hidden" name="' . $schema['Field'] . '" value="' . $uid . '">';
            } elseif ($schema['Key'] == 'PRI') {
                $elements[$i]['show'] = false;
                $elements[$i]['form'] = '<input type="hidden" name="' . $schema['Field'] . '" value="' . $def_val[$col_name] . '">';
            } elseif ($schema['Type'] == 'date') {
                My97DatePicker::render();
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control cal ' . $validate . '" onClick="WdatePicker({dateFmt:\'yyyy-MM-dd\', startDate:\'%y-%M-%d\'})" value="' . $def_val[$col_name] . '">';
            } elseif ($schema['Type'] == 'datetime') {
                My97DatePicker::render();
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control time ' . $validate . '" onClick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\', startDate:\'%y-%M-%d %H:%m:%s\'})" value="' . $def_val[$col_name] . '">';
            } elseif (strpos($schema['Type'], 'text') !== false) {
                $elements[$i]['form'] = '<textarea name="' . $schema['Field'] . '" class="form-control ' . $validate . '">' . $def_val[$col_name] . '</textarea>';
            } elseif (strpos($schema['Type'], 'enum') !== false) {
                \preg_match_all("/'(\W|\d)'/", $schema['Type'], $opt);
                foreach ($opt[1] as $v) {
                    $checked = (isset($def_val[$col_name]) and $def_val[$col_name] == $v) ? 'checked' : '';
                    $elements[$i]['form'] .= '
                    <div class="form-check form-check-inline radio-inline">
                        <label class="form-check-label">
                            <input type="radio" name="' . $schema['Field'] . '"  value="' . $v . '" ' . $checked . ' class="form-check-input ' . $validate . '"> ' . $v . '
                        </label>
                    </div>
                    ';
                }
            } else {
                $value = ($col_name == $this->sort_col and !isset($def_val[$col_name])) ? $this->get_max_sort() : $def_val[$col_name];
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control ' . $validate . '" value="' . $value . '">';
            }
            $i++;
        }

        if ($this->use_file) {
            $i++;

            $elements[$i]['col_name'] = $col_name . '_file';
            $elements[$i]['show'] = true;
            $elements[$i]['label'] = _TM_FILE_UPLOAD;
            $this->TadUpFiles->set_col($this->use_file, $def_val[$this->use_file]);
            $this->TadUpFiles->set_var('show_tip', false);
            $elements[$i]['form'] = $this->TadUpFiles->upform(true, $col_name . '_file', $this->file_maxlength, true, $this->file_only_type);
        }

        $this->set_attr('form', ['method' => 'post', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'], 'default');
        $form_attr = $this->get_attr('form');

        $form = '<form action="' . $action . '" id="' . $id_name . '" ' . $form_attr . '>';
        foreach ($elements as $key => $ele) {
            if ($ele['show']) {
                $requir_star = $this->get_validate($ele['col_name'], 'star');

                $this->set_attr($ele['col_name'] . '_form_label', ['class' => 'col-sm-' . $this->form_left . ' control-label col-form-label text-md-right'], 'default');
                $form_label_attr = $this->get_attr($ele['col_name'] . '_form_label');

                $this->set_attr($ele['col_name'] . '_form_content', ['class' => 'col-sm-' . $this->form_right], 'default');
                $form_content_attr = $this->get_attr($ele['col_name'] . '_form_content');

                $this->set_attr($ele['col_name'] . '_form_group', ['class' => 'form-group row'], 'default');
                $form_group_attr = $this->get_attr($ele['col_name'] . '_form_group');

                $form .= '
                <div ' . $form_group_attr . '>
                    <label ' . $form_label_attr . '>' . $requir_star . $ele['label'] . '</label>
                    <div ' . $form_content_attr . '>
                        ' . $ele['form'] . '
                    </div>
                </div>
                ';
            } else {
                $form .= $ele['form'];
            }
        }

        if (!empty($this->submit)) {
            $submit = implode("\n", $this->submit);
        } else {

            $op = !empty($def_val) ? 'update' : 'store';
            $this->set_attr('submit', ['name' => 'op', 'value' => $op, 'class' => 'btn btn-primary'], 'default');
            $submit_attr = $this->get_attr('submit');

            $label = !empty($def_val) ? _TM_SAVE : _TM_ADD;
            $submit = '<button type="submit" ' . $submit_attr . '>' . $label . '</button>';
        }

        $form .= '
            <div class="bar">
                ' . $token . '
                ' . $submit . '
            </div>
        </form>';

        $xoTheme->addScript('', null, "
            \$(document).ready(function(){
                \$('[data-toggle=\"tooltip\"]').tooltip();
            });
        ");

        $xoopsTpl->assign($this->table . '_form', $form);
        return $form;
    }

    // 編輯表單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1605
    public function edit($id, $action = '', $id_name = 'myForm')
    {
        global $xoopsDB;

        $this->chk_allow(__FUNCTION__);

        $values = $this->find([$this->primary => $id]);
        $this->create($values);
    }

    // 單一顯示
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1606
    public function show($id, $where = [])
    {
        global $xoopsDB, $xoopsTpl, $xoTheme;

        $this->chk_allow(__FUNCTION__);

        $myts = \MyTextSanitizer::getInstance();
        $where[$this->primary] = $id;
        $all = $this->find($where);

        $my_label = [];
        foreach ($all as $k => $v) {
            if (!empty($this->uid_col_arr) and in_array($k, $this->uid_col_arr)) {
                $all[$k] = (int) $v;
                $all[$k . '_name'] = $uid_name = \XoopsUser::getUnameFromId($v, $this->uid_col[$k]);
                $my_label[$k . '_name'] = $this->schema[$k]['Comment'];
                $this->replace($k, [$v => $uid_name]);
            } elseif (strpos($this->var_type[$k], "text") !== false) {
                $all[$k] = $myts->displayTarea($v, 1, 0, 0, 0, 0);
            } else {
                $all[$k] = $myts->htmlSpecialChars($v);
            }
        }

        if ($this->use_file) {
            $this->TadUpFiles->set_col($this->use_file, $id);
            $all["{$this->use_file}_file"] = $this->TadUpFiles->show_files("{$this->use_file}_file", true, $this->file_show_mode, false, false, null, null, false);
            $all["{$this->use_file}_var"] = $this->TadUpFiles->get_file(null, null, null, false, false, '', false, '_self', '', false);
            $my_label["{$this->use_file}_file"] = _TM_FILES;
        }

        $my_btn = '';
        if (!empty($this->add_show_btn)) {
            foreach ($this->add_show_btn as $btn) {

                if ($btn['parameter']) {
                    $para = [];
                    foreach ($btn['parameter'] as $pk => $pv) {
                        if (\is_int($pk)) {
                            $para[] = "{$pv}={$all[$pv]}";
                        } else {
                            $para[] = "{$pk}={$pv}";
                        }
                    }
                }
                $parameter = ($para) ? '?' . implode('&', $para) : '';

                if ($btn['attr']) {
                    $attr_arr = [];
                    foreach ($btn['attr'] as $ak => $av) {
                        $attr_arr[] = $ak . ' = "' . $av . '"';
                    }
                }
                $attr = implode(' ', $attr_arr);

                $my_btn .= '<a href="' . $btn['to'] . $parameter . '" ' . $attr . '>' . $btn['title'] . '</a>';
            }
        }

        $show_content = '';
        foreach ($all as $col_name => $value) {

            // 隱藏資料
            if (!empty($this->disable_show_col) and in_array($col_name, $this->disable_show_col)) {
                continue;
            }
            // 被替換的使用者編號也不用顯示
            if (!empty($this->uid_col_arr) and in_array($col_name, $this->uid_col_arr)) {
                continue;
            }

            if (in_array($col_name, $this->my_show_col_arr)) {
                // Utility::dd($this->my_show_col[$col_name]);
                $show_col = '';
                foreach ($this->my_show_col[$col_name] as $col_name => $width) {
                    // Utility::dd($col_name);
                    list($left_w, $right_w) = $width;
                    $value = $this->render_show_val($col_name, $value, $all);
                    $label = empty($this->schema[$col_name]['Comment']) ? $my_label[$col_name] : $this->schema[$col_name]['Comment'];

                    $this->set_attr($col_name . '_row', ['class' => 'row my-3'], 'default');
                    $row = $this->get_attr($col_name . '_row');
                    $this->set_attr($col_name . '_row_label', ['class' => 'col-sm-' . $left_w . ' text-right'], 'default');
                    $row_label = $this->get_attr($col_name . '_row_label');
                    $this->set_attr($col_name . '_row_content', ['class' => 'col-sm-' . $right_w], 'default');
                    $row_content = $this->get_attr($col_name . '_row_content');

                    if ($left_w > 0) {
                        $show_col .= '<div ' . $row_label . '>' . $label . '</div>';
                    }
                    $show_col .= '<div ' . $row_content . '>' . $value . '</div>';
                }
                $show_content .= '
                <div ' . $row . '>
                    ' . $show_col . '
                </div>';
            } else {
                $value = $this->render_show_val($col_name, $value, $all);
                $label = empty($this->schema[$col_name]['Comment']) ? $my_label[$col_name] : $this->schema[$col_name]['Comment'];

                $this->set_attr($col_name . '_row', ['class' => 'row my-3'], 'default');
                $row = $this->get_attr($col_name . '_row');
                $this->set_attr($col_name . '_row_label', ['class' => 'col-sm-' . $this->show_left . ' text-right'], 'default');
                $row_label = $this->get_attr($col_name . '_row_label');
                $this->set_attr($col_name . '_row_content', ['class' => 'col-sm-' . $this->show_right], 'default');
                $row_content = $this->get_attr($col_name . '_row_content');

                $show_content .= '
                <div ' . $row . '>
                    <div ' . $row_label . '>' . $label . '</div>
                    <div ' . $row_content . '>' . $value . '</div>
                </div>';
            }

        }
        if ($my_btn) {
            $show_content .= "<div class='bar'>$my_btn</div>";
        }

        $xoTheme->addScript('', null, "
            \$(document).ready(function(){
                \$('[data-toggle=\"tooltip\"]').tooltip();
            });
        ");

        $xoopsTpl->assign($this->table, $all);
        $xoopsTpl->assign("{$this->table}_show", $show_content);
        return $all;

    }

    // 產生欲顯示的資料
    private function render_show_val($col_name, $value, $all)
    {

        // 替換資料
        $value = in_array($col_name, $this->need_replace) ? $this->replace_col[$col_name][$value] : $value;

        if ($this->replace_callback[$col_name]) {
            foreach ($this->replace_callback[$col_name] as $func_name => $func_parameter_arr) {
                foreach ($func_parameter_arr as $parameter_key => $parameter_value) {
                    if ($parameter_value == 'this') {
                        $parameter_value = $value;
                    }
                    $parameter_arr[$parameter_key] = $parameter_value;
                }
                $value = call_user_func_array($func_name, $parameter_arr);
            }
        }

        // 加連結
        if (in_array($col_name, $this->need_link)) {
            if ($this->set_link_col[$col_name]['parameter']) {
                $para = [];
                foreach ($this->set_link_col[$col_name]['parameter'] as $pk => $pv) {
                    if (\is_int($pk)) {
                        $para[] = "{$pv}={$all[$pv]}";
                    } else {
                        $para[] = "{$pk}={$pv}";
                    }
                }
            }
            $parameter = ($para) ? '?' . implode('&', $para) : '';
            $value = '<a href="' . $this->set_link_col[$col_name]['to'] . $parameter . '" target="' . $this->set_link_col[$col_name]['target'] . '">' . $value . '</a>';
        }
        return $value;
    }

    // 更新資料
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1607
    public function update($id)
    {
        global $xoopsDB;
        $this->chk_allow(__FUNCTION__);

        //安全判斷
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header('index.php', 3, $_SERVER['HTTP_REFERER']);
        }

        $myts = \MyTextSanitizer::getInstance();
        $update_arr = [];
        foreach ($_POST as $col_name => $value) {
            if (isset($this->var_type[$col_name])) {
                if (\strpos($this->var_type[$col_name], 'int') !== false) {
                    $value = (int) $value;
                } else {
                    $value = $myts->addSlashes($value);
                }
                $update_arr[] = "`$col_name` = '{$value}'";
            }
        }

        $sql = "update `" . $xoopsDB->prefix($this->table) . "` set " . implode(', ', $update_arr) . " where `{$this->primary}`='{$id}'";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        if ($this->use_file) {
            $this->TadUpFiles->set_col($this->use_file, $id);
            $this->TadUpFiles->upload_file($col_name . '_file');
        }
        return true;
    }

    // 儲存資料
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1608
    public function store()
    {
        global $xoopsDB;

        $this->chk_allow(__FUNCTION__);

        //安全判斷
        if (!$GLOBALS['xoopsSecurity']->check()) {
            $error = implode("<br>", $GLOBALS['xoopsSecurity']->getErrors());
            redirect_header('index.php', 3, $_SERVER['HTTP_REFERER']);
        }

        $myts = \MyTextSanitizer::getInstance();
        $col_name_arr = $col_val_arr = [];
        foreach ($_POST as $col_name => $value) {
            if (isset($this->var_type[$col_name])) {
                $col_name_arr[] = $col_name;
                if (\strpos($this->var_type[$col_name], 'int') !== false) {
                    $col_val_arr[] = (int) $value;
                } else {
                    $col_val_arr[] = $myts->addSlashes($value);
                }
            }
        }

        $sql = "insert into `" . $xoopsDB->prefix($this->table) . "` (`" . implode('`, `', $col_name_arr) . "`) values('" . implode("', '", $col_val_arr) . "')";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $InsertId = $xoopsDB->getInsertId();
        if ($this->use_file) {
            $this->TadUpFiles->set_col($this->use_file, $InsertId);
            $this->TadUpFiles->upload_file($col_name . '_file');
        }
        return $InsertId;
    }

    // 刪除資料
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1609
    public function destroy($id)
    {
        global $xoopsDB;

        $this->chk_allow(__FUNCTION__);

        $sql = "delete from `" . $xoopsDB->prefix($this->table) . "` where `{$this->primary}`='$id'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        if ($this->use_file) {
            $this->TadUpFiles->set_col($this->use_file, $id);
            $this->TadUpFiles->del_files();
        }
        return true;
    }

    // 資料列表
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1610
    public function index($arr = [])
    {
        global $xoopsDB, $xoopsTpl, $xoTheme, $xoopsUser;

        $this->chk_allow(__FUNCTION__, XOOPS_URL);

        $my_uid = $xoopsUser ? $xoopsUser->uid() : 0;

        $myts = \MyTextSanitizer::getInstance();

        $session_name = "{$this->dirname}_adm";
        if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {

            if (!isset($this->func['destroy']) or $this->func['destroy'] !== false) {
                $to = $this->func['destroy'] == '' ? $_SERVER['PHP_SELF'] : $this->func['destroy'];
                $SweetAlert = new SweetAlert();
                $SweetAlert->render("del_{$xoopsDB->prefix($this->table)}", "{$to}?op=destroy&{$this->primary}=", $this->primary);
            }

            $create_button = '';
            if (!isset($this->func['create']) or $this->func['create'] !== false) {
                $to = $this->func['create'] == '' ? $_SERVER['PHP_SELF'] : $this->func['create'];
                $create_button = '<a href="' . $to . '?op=create" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> ' . _TAD_ADD . '</a>';
            }
        }

        $sql = "select * from `" . $xoopsDB->prefix($this->table) . "` {$this->where} {$this->order}";

        if ($this->pagebar) {
            $PageBar = Utility::getPageBar($sql, $this->pagebar, 10);
            $bar = $PageBar['bar'];
            $sql = $PageBar['sql'];
            $total = $PageBar['total'];
            $xoopsTpl->assign('bar', $bar);
            $xoopsTpl->assign('total', $total);
        }

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all_data = [];
        $td = '';

        while ($all = $xoopsDB->fetchArray($result)) {
            $primary = $all[$this->primary];
            if (isset($arr[$primary])) {
                $all = array_merge($all, $arr[$primary]);
            }

            $is_my = false;
            foreach ($all as $k => $v) {
                if (!empty($this->uid_col_arr) and in_array($k, $this->uid_col_arr)) {
                    $all[$k] = (int) $v;
                    $all[$k . '_name'] = $uid_name = \XoopsUser::getUnameFromId($v, $this->uid_col[$k]);
                    $this->replace($k, [$v => $uid_name]);
                    $is_my = $my_uid == $v ? true : false;
                } elseif (strpos($this->var_type[$k], "text") !== false) {
                    $all[$k] = $myts->displayTarea($v, 1, 0, 0, 0, 0);
                } else {
                    $all[$k] = $myts->htmlSpecialChars($v);
                }
            }

            if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false or $is_my) {
                $all['del'] = "javascript:del_{$xoopsDB->prefix($this->table)}({$primary})";
            }

            if ($this->use_file) {
                $this->TadUpFiles->set_col($this->use_file, $all[$this->use_file]);
                $all["{$this->use_file}_file"] = $this->TadUpFiles->show_files("{$this->use_file}_file", true, $this->file_index_mode, false, false, null, null, false);
                $all["{$this->use_file}_var"] = $this->TadUpFiles->get_file(null, null, null, false, false, '', false, '_self', '', false);
            }

            // 開始製作顯示內容
            $all_data[] = $all;

            $this->set_attr('tr', ['id' => "sort_arr_{$primary}"], 'default');
            $tr_attr = $this->get_attr('tr');

            $td .= '<tr ' . $tr_attr . '>';

            // 整理儲存格內容
            foreach ($this->schema as $col_name => $schema) {
                if (!empty($this->disable_index_col) and in_array($col_name, $this->disable_index_col)) {
                    continue;
                }

                // 替換內容
                $td_val = in_array($col_name, $this->need_replace) ? $this->replace_col[$col_name][$all[$col_name]] : $all[$col_name];

                if ($this->replace_callback[$col_name]) {
                    foreach ($this->replace_callback[$col_name] as $func_name => $func_parameter_arr) {
                        foreach ($func_parameter_arr as $parameter_key => $parameter_value) {
                            if ($parameter_value == 'this') {
                                $parameter_value = $td_val;
                            }
                            $parameter_arr[$parameter_key] = $parameter_value;
                        }
                        $td_val = call_user_func_array($func_name, $parameter_arr);
                    }
                }

                // 加連結
                if (in_array($col_name, $this->need_link)) {
                    if ($this->set_link_col[$col_name]['parameter']) {
                        $para = [];
                        foreach ($this->set_link_col[$col_name]['parameter'] as $pk => $pv) {
                            if (\is_int($pk)) {
                                $para[] = "{$pv}={$all[$pv]}";
                            } else {
                                $para[] = "{$pk}={$pv}";
                            }
                        }
                    }
                    $parameter = ($para) ? '?' . implode('&', $para) : '';
                    $td_val = '<a href="' . $this->set_link_col[$col_name]['to'] . $parameter . '" target="' . $this->set_link_col[$col_name]['target'] . '">' . $td_val . '</a>';
                }

                if ($col_name == $this->sort_col) {
                    $this->set_attr(['class' => "show_sort"], 'append');
                }

                $attr = $this->get_attr($col_name . '_td', 'td');
                $td .= '
                <td ' . $attr . '>' . $td_val . '</td>';
            }

            // 附檔
            $td_attr = $this->get_attr('td');
            if ($this->use_file) {
                $td .= '
                <td ' . $td_attr . '>' . $all["{$this->use_file}_file"] . '</td>';
            }

            $my_btn = '';

            if (!empty($this->add_index_btn)) {
                foreach ($this->add_index_btn as $btn) {

                    if ($btn['parameter']) {
                        $para = [];
                        foreach ($btn['parameter'] as $pk => $pv) {
                            if (\is_int($pk)) {
                                $para[] = "{$pv}={$all[$pv]}";
                            } else {
                                $para[] = "{$pk}={$pv}";
                            }
                        }
                    }
                    $parameter = ($para) ? '?' . implode('&', $para) : '';

                    if ($btn['attr']) {
                        $attr_arr = [];
                        foreach ($btn['attr'] as $ak => $av) {
                            $attr_arr[] = $ak . ' = "' . $av . '"';
                        }
                    }
                    $attr = implode(' ', $attr_arr);

                    $my_btn .= '<a href="' . $btn['to'] . $parameter . '" ' . $attr . '>' . $btn['title'] . '</a>';
                }
            }

            // 管理功能
            if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false or $is_my) {

                $edit_button = '';
                if (!isset($this->func['edit']) or $this->func['edit'] !== false) {
                    $to = $this->func['edit'] == '' ? $_SERVER['PHP_SELF'] : $this->func['edit'];
                    $edit_button = '<a href="' . $to . '?op=edit&' . $this->primary . '=' . $primary . '" class="btn btn-warning btn-sm">' . _TAD_EDIT . '</a>';
                }

                $destroy_button = '';
                if (!isset($this->func['destroy']) or $this->func['destroy'] !== false) {
                    $destroy_button = '<a href="' . $all['del'] . '" class="btn btn-danger btn-sm">' . _TAD_DEL . '</a>';
                }
            }

            $display_function_th = false;
            if ($edit_button or $destroy_button or $my_btn) {
                $td .= '
                <td ' . $td_attr . '>
                    ' . $edit_button . '
                    ' . $destroy_button . '
                    ' . $my_btn . '
                </td>';
                $display_function_th = true;
            }

            $td .= '
            </tr>';

        }

        // 表格標題
        $th = '';
        foreach ($this->schema as $col_name => $schema) {
            if (!empty($this->disable_index_col) and in_array($col_name, $this->disable_index_col)) {
                continue;
            }
            $attr = $this->get_attr($col_name . 'th', 'th');

            $th .= '<th ' . $attr . '>' . $schema['Comment'] . '</th>';
        }

        $th_attr = $this->get_attr('th');
        if ($this->use_file) {
            $th .= '<th ' . $th_attr . '>' . _TM_FILES . '</th>';
        }

        if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false or !empty($this->add_index_btn) or $display_function_th) {
            $th .= '<th ' . $th_attr . '>' . _TAD_FUNCTION . '</th>';
        }

        $save_msg == '';
        if (!empty($this->sort_col)) {
            Utility::get_jquery(true);
            $xoTheme->addScript('', null, "
                \$(document).ready(function(){
                    \$('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
                        var order = $(this).sortable('serialize');
                        \$.post('" . XOOPS_URL . "/modules/tadtools/ajax_file.php?op=save_sort&table={$this->table}&sort_col={$this->sort_col}&primary_key={$this->primary}', order, function(theResponse){
                            $('#save_msg').html(theResponse);
                            $('.show_sort').each(function( index ) {
                                var sort = index+1;
                                $(this).html(sort);
                            });
                        });
                    }
                    });
                });
            ");
            $save_msg = '<div id="save_msg">' . _TAD_SORTABLE . '</div>';
        }

        $table_attr = $this->get_attr('table');
        $tr1_attr = $this->get_attr('tr1');

        $index_table = '
        ' . $save_msg . '
        <div class="table-responsive">
            <table ' . $table_attr . '>
                <thead>
                    <tr ' . $tr1_attr . '>
                        ' . $th . '
                    </tr>
                </thead>
                <tbody id="sort">
                    ' . $td . '
                </tbody>
            </table>
        </div>
        ' . $bar . '
        <div class="bar">
        ' . $create_button . '
        </div>
        ';
        $xoTheme->addScript('', null, "
            \$(document).ready(function(){
                \$('[data-toggle=\"tooltip\"]').tooltip();
            });
        ");
        $xoopsTpl->assign($this->table, $all_data);
        $xoopsTpl->assign("{$this->table}_index", $index_table);

        return $all_data;
    }

    /*********** 資料操控 ************/
    // 取得資料
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1612
    public function find($where_item = [])
    {
        global $xoopsDB, $xoopsUser;

        if (empty($where_item)) {
            return;
        }

        foreach ($where_item as $col => $val) {
            if ($val == 'uid' and is_int($col)) {
                $col = 'uid';
                $val = $xoopsUser->uid();
            }
            $where_sql[] = "`$col` = '{$val}'";
        }
        $where = "where " . implode(' and ', $where_sql);

        $myts = \MyTextSanitizer::getInstance();
        $sql = "select * from `" . $xoopsDB->prefix($this->table) . "` $where";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $xoopsDB->fetchArray($result);
        return $all;
    }

    // 執行自訂查詢語法
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1659
    public function select($select_col = '*', $where_item = [], $single = false, $key = '', $tpl_tag = '')
    {
        global $xoopsDB, $xoopsUser, $xoopsTpl;
        if (is_array($select_col)) {
            $cols = [];
            foreach ($select_col as $func => $col) {
                if (is_int($func)) {
                    $cols[] = $col == '*' ? $col : "`{$col}`";
                } else {
                    $cols[] = "{$func}({$col})";
                }
            }
            $col_sql = implode(", ", $cols);
        } else {
            $col_sql = $select_col;
        }

        if (!is_array($where_item)) {
            $where = "$where_item";
        } else {
            $where_sql = [];
            foreach ($where_item as $col => $val) {
                if ($val == 'uid' and is_int($col)) {
                    $col = 'uid';
                    $val = $xoopsUser->uid();
                }
                $where_sql[] = "`$col` = '{$val}'";
            }
            $where = "where " . implode(' and ', $where_sql);
        }
        $myts = \MyTextSanitizer::getInstance();
        $sql = "select $col_sql from `" . $xoopsDB->prefix($this->table) . "` $where";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        if ($single) {
            $data = $xoopsDB->fetchArray($result);
        } else {
            $data = [];
            $k = 0;
            while ($all = $xoopsDB->fetchArray($result)) {
                $k = $key ? $all[$key] : $k++;
                $data[$k] = $all;
            }
        }
        if (!empty($tpl_tag)) {
            $xoopsTpl->assign($tpl_tag, $data);
        }
        return $data;
    }

    // 回呼
    // public function callback($col_name, $callback = [], $where = [])
    // {

    //     if (in_array('index', $where)) {
    //         $this->index_callback[$col_name] = $callback;
    //     }

    //     if (in_array('show', $where)) {
    //         $this->show_callback[$col_name] = $callback;}

    // }

    // 篩選
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1613
    public function where($where_item = [])
    {
        if (empty($where_item)) {
            return;
        }

        foreach ($where_item as $col => $val) {
            $where_sql[] = "`$col` = '{$val}'";
        }

        $this->where = "where " . implode(' and ', $where_sql);
        return $this;
    }

    // 排序
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1614
    public function order($order_item = [])
    {
        foreach ($order_item as $col => $sort) {
            $order_sql[] = "`$col` {$sort}";
        }
        $this->order = "order by " . implode(',', $order_sql);
        return $this;
    }

    /*********** 表單元件 ************/

    // 製作套用的表單元件
    private function mk_elements($col_name, $db_val = '', $validate = '')
    {
        $type = $this->my_elements[$col_name];
        $options = $this->my_elements_options[$col_name];
        $fnname = "use_{$type}";
        if (!is_null($db_val)) {
            $def_val = $db_val;
        } else {
            $def_val = $this->my_elements_default[$col_name];
        }

        $element = $this->{$fnname}($col_name, $options, $def_val, $validate, true);
        return $element;
    }

    // 加入欲套用的元件
    private function my_elements($col_name, $type, $options = [], $def_val = null)
    {
        $this->my_elements[$col_name] = $type;
        $this->my_elements_options[$col_name] = $options;
        $this->my_elements_default[$col_name] = $def_val;
        return $this;
    }

    // 取得驗證規則
    private function get_validate($col_name, $type = '')
    {
        if ($type == 'star') {
            $return = '<span class="text-danger" data-toggle="tooltip" title="此欄位必填">*</span> ';
        } else {
            $opt = $this->require_col[$col_name];
            $return = ($opt) ? 'validate[required, ' . $opt . ']' : 'validate[required]';
        }

        return in_array($col_name, $this->require_arr) ? $return : '';
    }

    // 套用下拉選單
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1617
    public function use_select($col_name, $options = [], $def_val = null, $validate = '', $from_lazy = false)
    {
        if (!$from_lazy) {
            $this->my_elements($col_name, 'select', $options, $def_val);
        } else {
            if ($validate === true) {
                $validate = "validate[required]";
            }
            $select = '<select name="' . $col_name . '" class="form-control ' . $validate . '">';
            foreach ($options as $val => $label) {
                $selected = ($def_val == $val) ? 'selected' : '';
                $select .= '<option value="' . $val . '" ' . $selected . '>' . $label . '</option>';
            }
            $select .= "</select>";
            return $select;
        }
    }

    // 套用單選
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1618
    public function use_radio($col_name, $options = [], $def_val = null, $validate = '', $from_lazy = false)
    {
        if (!$from_lazy) {
            $this->my_elements($col_name, 'radio', $options, $def_val);
        } else {
            if ($validate === true) {
                $validate = "validate[required]";
            }
            $radio = '';
            foreach ($options as $val => $label) {
                $checked = ($def_val == $val) ? 'checked' : '';
                $radio .= '
                <div class="form-check form-check-inline radio-inline">
                    <label class="form-check-label">
                        <input type="radio" name="' . $col_name . '"  value="' . $val . '" ' . $checked . ' class="form-check-input ' . $validate . '">' . $label . '
                    </label>
                </div>
                ';
            }
            return $radio;
        }
    }

    // 套用編輯器
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1619
    public function use_ckeditor($col_name, $options = [], $def_val = null, $validate = '', $from_lazy = false)
    {
        if (!$from_lazy) {
            $this->my_elements($col_name, 'ckeditor', $options, $def_val);
        } else {
            $CkEditor = new CkEditor($this->dirname, $col_name, $def_val);
            foreach ($options as $key => $value) {
                $CkEditor->$key($value);
            }
            $ckeditor = $CkEditor->render();
            return $ckeditor;
        }
    }

    // 套用隱藏欄位
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1620
    public function set_hidden($col_name, $def_val)
    {

        $this->hide_create_col[] = $col_name;
        $this->change_elements[$col_name] = '<input type="hidden" name="' . $col_name . '" value="' . $def_val . '">';
        return $this;
    }

    // 設定submit按鈕
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1621
    public function set_submit($name = 'op', $value = '', $label = '', $icon = '', $attr_arr = ['class' => 'btn btn-primary'])
    {
        foreach ($attr_arr as $attr => $attr_value) {
            $attrs[] = $attr . ' = "' . $attr_value . '"';
        }
        $attr = implode(' ', $attrs);
        $show_icon = $icon ? '<i class="fa ' . $icon . '" aria-hidden="true"></i> ' : '';
        $this->submit[] = '<button type="submit" name="' . $name . '" value="' . $value . '" ' . $attr . '>' . $show_icon . $label . '</button>';
        return $this;
    }

    // 加入上傳工具
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbdsn=1622
    public function set_file($col_name, $index_mode = 'small', $show_mode = '', $subdir = '', $maxlength = '', $only_type = '')
    {
        $this->TadUpFiles = new TadUpFiles($this->dirname, $subdir);
        $this->use_file = $col_name;
        $this->file_index_mode = $index_mode;
        $this->file_show_mode = $show_mode;
        $this->file_maxlength = $maxlength;
        $this->file_only_type = $only_type;
        return $this;
    }

    // 加入排序
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1623
    public function set_sort($col_name)
    {
        $this->sort_col = $col_name;
        $this->order([$col_name => '']);
        return $this;
    }

    // 加入必填
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1624
    public function set_require($col_name, $options = [])
    {
        $opt = [];
        foreach ($options as $key => $value) {
            $opt[] = "{$key}[{$value}]";
        }
        $option = implode(',', $opt);
        if (is_array($col_name)) {
            foreach ($col_name as $col) {
                $this->require_col[$col] = $option;
            }
        } else {
            $this->require_col[$col_name] = $option;
        }

        $this->require_arr = array_keys($this->require_col);
        return $this;
    }

    // 設定功能
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1625
    public function set_func($func_name, $to = false)
    {
        $this->func[$func_name] = $to;
        return $this;
    }

    // 設定表單欄位寬度
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1635
    public function form_width($left = 2, $right = 10)
    {
        $this->form_left = $left;
        $this->form_right = $right;
        return $this;
    }

    //自動取得新排序
    private function get_max_sort()
    {
        global $xoopsDB;
        $sql = "select max(`{$this->sort_col}`) from " . $xoopsDB->prefix($this->table) . "";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($sort) = $xoopsDB->fetchRow($result);

        return ++$sort;
    }

    /*********** 調整顯示 ************/

    // 分頁
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1633
    public function pagebar($num = 20)
    {
        $this->pagebar = $num;
        return $this;
    }

    // 設定bootstrap的row內容
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1634
    public function row($cols = [])
    {
        $key = count($cols) ? array_keys($cols)[0] : null;
        foreach ($cols as $col_name => $width_arr) {
            $this->my_show_col_arr[] = $col_name;
        }
        $this->my_show_col[$key] = $cols;
        return $this;
    }

    // 設定col欄位寬度
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1636
    public function show_width($left = 2, $right = 10)
    {
        $this->show_left = $left;
        $this->show_right = $right;
        return $this;
    }

    // 將uid使用者編號改用姓名呈現
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1628
    public function uid_name($col_name = 'uid', $type = 1)
    {
        $this->uid_col[$col_name] = $type;
        $this->uid_col_arr = array_keys($this->uid_col);
        return $this;
    }

    // 替換顯示
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1627
    public function replace($col_name, $arr = [], $callback = [], $exception_group = [])
    {
        global $xoopsUser;

        $user_groups = ($xoopsUser) ? $xoopsUser->groups() : [3];
        $work = true;
        if ($exception_group) {
            $exception = array_intersect($exception_group, $user_groups);
            $work = sizeof($exception) ? false : true;
        }

        if ($work) {
            $this->replace_col[$col_name] = $arr;
            if ($callback) {
                $this->replace_callback[$col_name] = $callback;
            }
        }
        // 需替換欄位陣列
        $this->need_replace = array_keys($this->replace_col);
        return $this;
    }

    // 不顯示的欄位
    // https://campus-xoops.tn.edu.tw/modules/tad_book3/page.php?tbsn=48&tbdsn=1629
    public function disable($col_name, $where = ['index'], $exception_group = [])
    {
        global $xoopsUser;

        $user_groups = ($xoopsUser) ? $xoopsUser->groups() : [3];
        $disable = true;
        if ($exception_group) {
            $exception = array_intersect($exception_group, $user_groups);
            $disable = sizeof($exception) ? false : true;
        }

        if (is_array($col_name)) {
            foreach ($col_name as $col) {
                if (in_array('index', $where) and $disable) {
                    $this->disable_index_col[] = $col;
                }

                if (in_array('show', $where) and $disable) {
                    $this->disable_show_col[] = $col;}

                if (in_array('create', $where) and $disable) {
                    $this->disable_create_col[] = $col;
                }
            }
        } else {
            if (in_array('index', $where) and $disable) {
                $this->disable_index_col[] = $col_name;
            }

            if (in_array('show', $where) and $disable) {
                $this->disable_show_col[] = $col_name;}

            if (in_array('create', $where) and $disable) {
                $this->disable_create_col[] = $col_name;
            }
        }
        return $this;
    }

    // 設置連結
    public function set_link($col_name, $to = '', $parameter = [], $target = '_self')
    {
        if (empty($to)) {
            $to = $_SERVER['PHP_SELF'];
        }

        $this->set_link_col[$col_name]['to'] = $to;
        $this->set_link_col[$col_name]['target'] = $target;
        $this->set_link_col[$col_name]['parameter'] = $parameter;

        $this->need_link = array_keys($this->set_link_col);
        return $this;
    }

    // 加入自訂按鈕
    public function add_button($title, $to = '', $parameter = [], $attr = [], $where = [], $allow = [], $deny = [])
    {
        global $xoopsUser;

        if (empty($to)) {
            $to = $_SERVER['PHP_SELF'];
        }

        $btn['title'] = $title;
        $btn['to'] = $to;
        $btn['parameter'] = $parameter;
        $btn['attr'] = $attr;

        $is_allow = true;
        if (!empty($allow)) {
            $user_groups = ($xoopsUser) ? $xoopsUser->groups() : [3];
            $in_allow_group = array_intersect($allow, $user_groups);
            $is_allow = sizeof($in_allow_group) ? true : false;
        }

        if (!empty($deny)) {
            $user_groups = ($xoopsUser) ? $xoopsUser->groups() : [3];
            $in_deny_group = array_intersect($deny, $user_groups);
            $is_allow = sizeof($in_deny_group) ? false : true;
        }

        if ($is_allow) {
            if (in_array('index', $where)) {
                $this->add_index_btn[] = $btn;
            }

            if (in_array('show', $where)) {
                $this->add_show_btn[] = $btn;
            }

            if (in_array('create', $where)) {
                $this->add_create_btn[] = $btn;
            }
        }
        return $this;
    }

}
