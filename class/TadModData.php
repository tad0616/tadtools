<?php
namespace XoopsModules\Tadtools;

use Xmf\Request;
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
    private $left = 3;
    private $right = 9;
    private $use_file;
    private $TadUpFiles;
    private $file_index_mode;
    private $file_show_mode;
    private $file_maxlength;
    private $file_only_type;
    private $replace_col = [];

    public function __construct($dirname, $table)
    {
        global $xoopsDB;
        $this->dirname = $dirname;
        $this->table = $table;

        $sql = "show full columns from `" . $xoopsDB->prefix($table) . "`";
        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // Field    Type    Null    Key    Default    Extra
        while ($all = $xoopsDB->fetchArray($result)) {
            foreach ($all as $k => $v) {
                $$k = $v;
            }
            $this->var_type[$Field] = $Type;
            $this->schema[] = $all;
            if ($Key == "PRI") {
                $this->primary = $Field;
            }
        }
        // Utility::dd($this->schema);
    }

    public function clean()
    {
        $clean = [];
        foreach ($_REQUEST as $var => $val) {
            if (strpos($this->var_type[$var], 'int') !== false) {
                $clean[$var] = Request::getInt($var);
            } else {
                $clean[$var] = Request::getString($var);
            }
        }
        return $clean;
    }

    public function create($def_val = [], $action = '', $id_name = 'myForm')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;
        if (empty($action)) {
            $action = $_SERVER['PHP_SELF'];
        }

        $FormValidator = new FormValidator("#myForm", false);
        $FormValidator->render('topLeft');

        $elements = [];
        foreach ($this->schema as $i => $schema) {
            $elements[$i]['label'] = $schema['Comment'];
            $elements[$i]['show'] = true;
            $col_name = $schema['Field'];

            if (!empty($this->my_elements[$col_name])) {
                $elements[$i]['form'] = $this->my_elements[$col_name]['form'];
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
            } elseif (strpos($schema['Type'], 'enum') !== false) {
                \preg_match_all("/'(\W|\d)'/", $schema['Type'], $opt);
                foreach ($opt[1] as $v) {
                    $checked = (isset($def_val[$col_name]) and $def_val[$col_name] == $v) ? 'checked' : '';
                    $elements[$i]['form'] .= '
                    <div class="form-check-inline">
                        <label class="form-check-label">
                        <input type="radio" name="' . $schema['Field'] . '"  value="' . $v . '" ' . $checked . ' class="form-check-input">' . $v . '
                        </label>
                    </div>
                    ';
                }
            } else {
                $elements[$i]['form'] = '<input type="text" name="' . $schema['Field'] . '" class="form-control" value="' . $def_val[$col_name] . '">';
            }
        }

        if ($this->use_file) {
            $i++;
            $elements[$i]['show'] = true;
            $elements[$i]['label'] = '附檔上傳';
            $this->TadUpFiles->set_col($this->use_file, $def_val[$this->use_file]);
            $elements[$i]['form'] = $this->TadUpFiles->upform(true, $this->table . '_file', $this->file_maxlength, true, $this->file_only_type);
        }

        $form = '<form action="' . $action . '" method="post" id="' . $id_name . '" enctype="multipart/form-data">';
        foreach ($elements as $key => $ele) {
            if ($ele['show']) {
                $form .= '
                <div class="form-group row">
                    <label class="col-sm-' . $this->left . ' col-form-label text-right">' . $ele['label'] . '</label>
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

    public function edit($id, $action = '', $id_name = 'myForm')
    {
        global $xoopsDB;
        $values = $this->show($id, false);
        $this->create($values);
    }

    public function show($id, $clean = true)
    {
        global $xoopsDB, $xoopsTpl;
        $myts = \MyTextSanitizer::getInstance();
        $sql = "select * from `" . $xoopsDB->prefix($this->table) . "` where `{$this->primary}`='$id'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $all = $xoopsDB->fetchArray($result);

        if ($clean) {
            foreach ($all as $k => $v) {
                if (strpos($this->var_type[$k], "text") !== false) {
                    $all[$k] = $myts->displayTarea($v, 1, 0, 0, 0, 0);
                } else {
                    $all[$k] = $myts->htmlSpecialChars($v);
                }
            }
        }

        if (!empty($this->use_file)) {
            $this->TadUpFiles->set_col($this->use_file, $id);
            $all['files'] = $this->TadUpFiles->show_files("{$this->table}_file", true, $this->file_show_mode, false, false, null, null, false);
        }
        $xoopsTpl->assign($this->table, $all);
        return $all;

    }

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

    public function index()
    {
        global $xoopsDB, $xoopsTpl;
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
        while ($all = $xoopsDB->fetchArray($result)) {
            if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
                $all['del'] = "javascript:del_{$xoopsDB->prefix($this->table)}('{$all[$this->primary]}')";
            }

            foreach ($all as $k => $v) {
                if (strpos($this->var_type[$k], "text") !== false) {
                    $all[$k] = $myts->displayTarea($v, 1, 0, 0, 0, 0);
                } else {
                    $all[$k] = $myts->htmlSpecialChars($v);
                }
            }

            if (!empty($this->use_file)) {
                $this->TadUpFiles->set_col($this->use_file, $all[$this->use_file]);
                $all['files'] = $this->TadUpFiles->show_files("{$this->table}_file", true, $this->file_index_mode, false, false, null, null, false);
            }

            $all_data[] = $all;
            $td .= '<tr>';
            $need_replace = array_keys($this->replace_col);

            foreach ($this->schema as $i => $schema) {
                $col_name = $schema['Field'];
                $td_val = in_array($col_name, $need_replace) ? $this->replace_col[$col_name][$all[$col_name]] : $all[$col_name];
                $td .= '
                <td>' . $td_val . '</td>';
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
        foreach ($this->schema as $i => $schema) {
            $th .= '<th class="c n">' . $schema['Comment'] . '</th>';
        }
        if ($_SESSION[$session_name] or strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
            $th .= '<th class="c n">' . _TAD_FUNCTION . '</th>';
        }

        $index_table = '
        <table class="table table-bordered" style="width:auto; background:white;">
        <tr class="bg-info white">
            ' . $th . '
        </tr>
        ' . $td . '
        </table>
        <div class="bar">
        ' . $add_button . '
        </div>
        ';
        $xoopsTpl->assign($this->table, $all_data);
        $xoopsTpl->assign("{$this->table}_index", $index_table);

        return $all_data;
    }

    public function pagebar($num = 20)
    {
        $this->pagebar = $num;
    }

    public function where($where_item = [])
    {
        foreach ($where_item as $col => $val) {
            $where_sql[] = "`$col` = '{$val}'";
        }
        $this->where = "where " . implode(' and ', $where_sql);
    }

    public function order($order_item = [])
    {
        foreach ($order_item as $col => $sort) {
            $order_sql[] = "`$col` {$sort}";
        }
        $this->order = "order by " . implode(',', $order_sql);
    }

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

    public function use_select($col_name, $options = [], $id = '')
    {
        global $xoopsDB, $xoopsTpl;
        $def_val = $id ? $this->show($id, false) : [];
        $select = '<select name="' . $col_name . '" class="form-control">';
        foreach ($options as $val => $label) {
            $selected = (isset($def_val[$col_name]) and $def_val[$col_name] == $val) ? 'selected' : '';
            $select .= '<option value="' . $val . '" ' . $selected . '>' . $label . '</option>';
        }
        $select .= "</select>";
        $this->my_elements[$col_name]['form'] = $select;
        return $select;
    }

    public function use_radio($col_name, $options = [], $id = '')
    {
        global $xoopsDB, $xoopsTpl;
        $def_val = $id ? $this->show($id, false) : [];
        $radio = '';
        foreach ($options as $val => $label) {
            $checked = (isset($def_val[$col_name]) and $def_val[$col_name] == $val) ? 'checked' : '';
            $radio .= '
            <div class="form-check-inline">
                <label class="form-check-label">
                <input type="radio" name="' . $col_name . '"  value="' . $val . '" ' . $checked . ' class="form-check-input">' . $label . '
                </label>
            </div>
            ';
        }
        $this->my_elements[$col_name]['form'] = $radio;
        return $radio;
    }

    public function width($left = 3, $right = 9)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function use_file($col_name = '', $index_mode = 'small', $show_mode = '', $subdir = '', $maxlength = '', $only_type = '')
    {
        $this->TadUpFiles = new TadUpFiles($this->dirname, $subdir);
        $this->use_file = $col_name;
        $this->file_index_mode = $index_mode;
        $this->file_show_mode = $show_mode;
        $this->file_maxlength = $maxlength;
        $this->file_only_type = $only_type;
    }

    public function replace($col_name, $arr = [])
    {
        $this->replace_col[$col_name] = $arr;
    }
}
