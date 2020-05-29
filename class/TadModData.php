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
    private $left = 2;
    private $right = 10;
    private $use_file;
    private $TadUpFiles;
    private $file_index_mode;
    private $file_show_mode;
    private $file_maxlength;
    private $file_only_type;
    private $replace_col = [];
    private $uid_col = [];
    private $hide_index_col = [];
    private $hide_show_col = [];
    private $hide_create_col = [];
    private $sort_col;

    // 建構函數
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
        // Utility::dd($this->schema);
    }

    // 過濾接收的變數
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

    // 取得指定之資料陣列
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

    /*********** 基本功能 ************/

    // 新增表單
    public function create($def_val = [], $action = '', $id_name = 'myForm')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        if (empty($action)) {
            $action = $_SERVER['PHP_SELF'];
        }

        $FormValidator = new FormValidator("#myForm", false);
        $FormValidator->render('topLeft');

        $elements = [];
        $i = 0;
        foreach ($this->schema as $col_name => $schema) {
            $elements[$i]['label'] = $schema['Comment'];
            $elements[$i]['show'] = true;

            if (!empty($this->my_elements[$col_name])) {
                $elements[$i]['form'] = $this->mk_elements($col_name, $def_val[$col_name]);
            } elseif ($schema['Field'] == 'uid') {
                $elements[$i]['show'] = false;
                $uid = $xoopsUser->uid();
                $elements[$i]['form'] = '<input type="hidden" name="' . $schema['Field'] . '" value="' . $uid . '">';
            } elseif ($schema['Key'] == 'PRI') {
                $elements[$i]['show'] = false;
                $elements[$i]['form'] = '<input type="hidden" name="' . $schema['Field'] . '" value="' . $def_val[$col_name] . '">';
            } elseif ($schema['Type'] == 'date') {
                My97DatePicker::render();
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control cal" onClick="WdatePicker({dateFmt:\'yyyy-MM-dd\', startDate:\'%y-%M-%d\'})" value="' . $def_val[$col_name] . '">';
            } elseif ($schema['Type'] == 'datetime') {
                My97DatePicker::render();
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control time" onClick="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\', startDate:\'%y-%M-%d %H:%m:%s\'})" value="' . $def_val[$col_name] . '">';
            } elseif (strpos($schema['Type'], 'text') !== false) {
                $elements[$i]['form'] = '<textarea name="' . $schema['Field'] . '" class="form-control">' . $def_val[$col_name] . '</textarea>';
            } elseif (strpos($schema['Type'], 'enum') !== false) {
                \preg_match_all("/'(\W|\d)'/", $schema['Type'], $opt);
                foreach ($opt[1] as $v) {
                    $checked = (isset($def_val[$col_name]) and $def_val[$col_name] == $v) ? 'checked' : '';
                    $elements[$i]['form'] .= '
                    <div class="form-check form-check-inline radio-inline">
                        <label class="form-check-label">
                            <input type="radio" name="' . $schema['Field'] . '"  value="' . $v . '" ' . $checked . ' class="form-check-input"> ' . $v . '
                        </label>
                    </div>
                    ';
                }
            } else {
                $value = ($col_name == $this->sort_col and !isset($def_val[$col_name])) ? $this->get_max_sort() : $def_val[$col_name];
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control" value="' . $value . '">';
            }
            $i++;
        }

        if ($this->use_file) {
            $i++;
            $elements[$i]['show'] = true;
            $elements[$i]['label'] = '附檔上傳';
            $this->TadUpFiles->set_col($this->use_file, $def_val[$this->use_file]);
            $this->TadUpFiles->set_var('show_tip', false);
            $elements[$i]['form'] = $this->TadUpFiles->upform(true, $this->table . '_file', $this->file_maxlength, true, $this->file_only_type);
        }

        $form = '<form action="' . $action . '" method="post" id="' . $id_name . '" class="form-horizontal" enctype="multipart/form-data">';
        foreach ($elements as $key => $ele) {
            if ($ele['show']) {
                $form .= '
                <div class="form-group row">
                    <label class="col-sm-' . $this->left . ' control-label col-form-label text-md-right">' . $ele['label'] . '</label>
                    <div class="col-sm-' . $this->right . '">
                        ' . $ele['form'] . '
                    </div>
                </div>
                ';
            } else {
                $form .= $ele['form'];
            }
        }
        $op = !empty($def_val) ? 'update' : 'store';
        $submit = !empty($def_val) ? '儲存更新' : '送出新增';
        $form .= '
            <div class="bar">
                <button type="submit" name="op" value="' . $op . '" class="btn btn-primary">' . $submit . '</button>
            </div>
        </form>';
        $xoopsTpl->assign($this->table . '_form', $form);
        return $form;
    }

    // 編輯表單
    public function edit($id, $action = '', $id_name = 'myForm')
    {
        global $xoopsDB;
        $values = $this->show($id, false);
        $this->create($values);
    }

    // 單一顯示
    public function show($id, $clean = true)
    {
        global $xoopsDB, $xoopsTpl;
        $myts = \MyTextSanitizer::getInstance();
        $sql = "select * from `" . $xoopsDB->prefix($this->table) . "` where `{$this->primary}`='$id'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $xoopsDB->fetchArray($result);

        if ($clean) {
            $uid_cols = array_keys($this->uid_col);
            foreach ($all as $k => $v) {
                if (!empty($uid_cols) and in_array($k, $uid_cols)) {
                    $all[$k] = (int) $v;
                    $all[$k . '_name'] = $uid_name = \XoopsUser::getUnameFromId($v, $this->uid_col[$k]);
                    $this->replace_col[$k][$v] = $uid_name;
                } elseif (strpos($this->var_type[$k], "text") !== false) {
                    $all[$k] = $myts->displayTarea($v, 1, 0, 0, 0, 0);
                } else {
                    $all[$k] = $myts->htmlSpecialChars($v);
                }
            }
        }

        if ($this->use_file) {
            $this->TadUpFiles->set_col($this->use_file, $id);
            $all['files'] = $this->TadUpFiles->show_files("{$this->table}_file", true, $this->file_show_mode, false, false, null, null, false);
        }

        // 顯示替換
        $need_replace = array_keys($this->replace_col);

        $show_content = '';
        foreach ($all as $col_name => $value) {
            $value = in_array($col_name, $need_replace) ? $this->replace_col[$col_name][$value] : $value;
            $show_content .= '
            <div class="row my-3">
                <div class="col-sm-2 text-right">' . $this->schema[$col_name]['Comment'] . '</div>
                <div class="col-sm-10">' . $value . '</div>
            </div>';
        }

        $xoopsTpl->assign($this->table, $all);
        $xoopsTpl->assign("{$this->table}_show", $show_content);
        return $all;

    }

    // 更新資料
    public function update($id)
    {
        global $xoopsDB;

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
            $this->TadUpFiles->upload_file($this->table . '_file');
        }
    }

    // 儲存資料
    public function store()
    {
        global $xoopsDB;

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
            $this->TadUpFiles->upload_file($this->table . '_file');
        }
        return $InsertId;
    }

    // 刪除資料
    public function destroy($id)
    {
        global $xoopsDB;
        $sql = "delete from `" . $xoopsDB->prefix($this->table) . "` where `{$this->primary}`='$id'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        if ($this->use_file) {
            $this->TadUpFiles->set_col($this->use_file, $id);
            $this->TadUpFiles->del_files();
        }
    }

    // 資料列表
    public function index()
    {
        global $xoopsDB, $xoopsTpl, $xoTheme;
        $myts = \MyTextSanitizer::getInstance();

        $session_name = "{$this->dirname}_adm";
        if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
            $SweetAlert = new SweetAlert();
            $SweetAlert->render("del_{$xoopsDB->prefix($this->table)}", "{$_SERVER['PHP_SELF']}?op=destroy&{$this->primary}=", $this->primary);
            $add_button = '<a href="' . $_SERVER['PHP_SELF'] . '?op=create" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> ' . _TAD_ADD . '</a>';
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

        $uid_cols = array_keys($this->uid_col);

        while ($all = $xoopsDB->fetchArray($result)) {
            if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
                $all['del'] = "javascript:del_{$xoopsDB->prefix($this->table)}('{$all[$this->primary]}')";
            }

            foreach ($all as $k => $v) {
                if (!empty($uid_cols) and in_array($k, $uid_cols)) {
                    $all[$k] = (int) $v;
                    $all[$k . '_name'] = $uid_name = \XoopsUser::getUnameFromId($v, $this->uid_col[$k]);
                    $this->replace_col[$k][$v] = $uid_name;
                } elseif (strpos($this->var_type[$k], "text") !== false) {
                    $all[$k] = $myts->displayTarea($v, 1, 0, 0, 0, 0);
                } else {
                    $all[$k] = $myts->htmlSpecialChars($v);
                }
            }

            if ($this->use_file) {
                $this->TadUpFiles->set_col($this->use_file, $all[$this->use_file]);
                $all['files'] = $this->TadUpFiles->show_files("{$this->table}_file", true, $this->file_index_mode, false, false, null, null, false);
            }

            $all_data[] = $all;
            $td .= '<tr id="sort_arr_' . $all[$this->primary] . '">';

            $need_replace = array_keys($this->replace_col);
            foreach ($this->schema as $col_name => $schema) {
                $td_val = in_array($col_name, $need_replace) ? $this->replace_col[$col_name][$all[$col_name]] : $all[$col_name];
                $td_class = $col_name == $this->sort_col ? 'class="show_sort"' : '';
                $td .= '
                <td ' . $td_class . '>' . $td_val . '</td>';
            }

            if ($this->use_file) {
                $td .= '
                <td ' . $td_class . '>' . $all['files'] . '</td>';
            }

            if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
                $td .= '
                <td class="c n">
                    <a href="' . $_SERVER['PHP_SELF'] . '?op=edit&' . $this->primary . '=' . $all[$this->primary] . '" class="btn btn-warning btn-sm">' . _TAD_EDIT . '</a>
                    <a href="' . $all['del'] . '" class="btn btn-danger btn-sm">' . _TAD_DEL . '</a>
                </td>';
            }

            $td .= '
            </tr>';

        }

        $th = '';
        foreach ($this->schema as $col_name => $schema) {
            $th .= '<th class="c n">' . $schema['Comment'] . '</th>';
        }

        if ($this->use_file) {
            $th .= '<th class="c n">相關附檔</th>';
        }

        if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
            $th .= '<th class="c n">' . _TAD_FUNCTION . '</th>';
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

        $index_table = '
        ' . $save_msg . '
        <table class="table table-hover table-responsive table-striped">
            <thead>
                <tr class="bg-info white">
                    ' . $th . '
                </tr>
            </thead>
            <tbody id="sort">
                ' . $td . '
            </tbody>
        </table>
        <div class="bar">
        ' . $add_button . '
        </div>
        ';
        $xoopsTpl->assign($this->table, $all_data);
        $xoopsTpl->assign("{$this->table}_index", $index_table);

        return $all_data;
    }

    /*********** 資料操控 ************/
    // 篩選
    public function where($where_item = [])
    {
        foreach ($where_item as $col => $val) {
            $where_sql[] = "`$col` = '{$val}'";
        }
        $this->where = "where " . implode(' and ', $where_sql);
    }

    // 排序
    public function order($order_item = [])
    {
        foreach ($order_item as $col => $sort) {
            $order_sql[] = "`$col` {$sort}";
        }
        $this->order = "order by " . implode(',', $order_sql);
    }

    /*********** 表單元件 ************/

    // 製作套用的表單元件
    public function mk_elements($col_name, $def_val = '')
    {
        $type = $this->my_elements[$col_name];
        $options = $this->my_elements_options[$col_name];
        $fnname = "use_{$type}";
        $element = $this->{$fnname}($col_name, $options, $def_val);
        return $element;
    }

    // 加入欲套用的元件
    public function my_elements($col_name, $type, $options = [])
    {
        $this->my_elements[$col_name] = $type;
        $this->my_elements_options[$col_name] = $options;
    }

    // 套用下拉選單
    public function use_select($col_name, $options = [], $def_val = null)
    {
        if (is_null($def_val)) {
            $this->my_elements($col_name, 'select', $options);
        } else {
            $select = '<select name="' . $col_name . '" class="form-control">';
            foreach ($options as $val => $label) {
                $selected = ($def_val == $val) ? 'selected' : '';
                $select .= '<option value="' . $val . '" ' . $selected . '>' . $label . '</option>';
            }
            $select .= "</select>";
            return $select;
        }
    }

    // 套用單選
    public function use_radio($col_name, $options = [], $def_val = null)
    {
        if (is_null($def_val)) {
            $this->my_elements($col_name, 'radio', $options);
        } else {

            $radio = '';
            foreach ($options as $val => $label) {
                $checked = ($def_val == $val) ? 'checked' : '';
                $radio .= '
                <div class="form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" name="' . $col_name . '"  value="' . $val . '" ' . $checked . ' class="form-check-input">' . $label . '
                    </label>
                </div>
                ';
            }
            return $radio;
        }
    }

    // 套用單選
    public function use_ckeditor($col_name, $options = [], $def_val = null)
    {
        if (is_null($def_val)) {
            $this->my_elements($col_name, 'ckeditor', $options);
        } else {
            $CkEditor = new CkEditor($this->dirname, $col_name, $def_val);
            foreach ($options as $key => $value) {
                $CkEditor->$key($value);
            }
            $ckeditor = $CkEditor->render();
            return $ckeditor;
        }
    }

    // 加入上傳工具
    public function set_file($col_name = '', $index_mode = 'small', $show_mode = '', $subdir = '', $maxlength = '', $only_type = '')
    {
        $this->TadUpFiles = new TadUpFiles($this->dirname, $subdir);
        $this->use_file = $col_name;
        $this->file_index_mode = $index_mode;
        $this->file_show_mode = $show_mode;
        $this->file_maxlength = $maxlength;
        $this->file_only_type = $only_type;
    }

    // 加入排序
    public function set_sort($col_name)
    {
        $this->sort_col = $col_name;
        $this->order([$col_name => '']);
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

    // 替換顯示
    public function replace($col_name, $arr = [])
    {
        $this->replace_col[$col_name] = $arr;
    }

    // 將uid使用者編號改用姓名呈現
    public function uid_name($col_name = 'uid', $type = 1)
    {
        $this->uid_col[$col_name] = $type;
    }

    // 隱藏欄位
    public function hide($col_name = 'uid', $where = ['index'])
    {
        if (in_array('index', $where)) {
            $this->hide_index_col[] = $col_name;
        }

        if (in_array('show', $where)) {
            $this->hide_show_col[] = $col_name;
        }

        if (in_array('create', $where)) {
            $this->hide_create_col[] = $col_name;
        }
    }

    // 分頁
    public function pagebar($num = 20)
    {
        $this->pagebar = $num;
    }

    // 設定bootstrap欄位寬度
    public function width($left = 2, $right = 10)
    {
        $this->left = $left;
        $this->right = $right;
    }
}
