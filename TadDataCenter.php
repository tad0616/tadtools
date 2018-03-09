<?php
/*

//單一表單
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$form=$TadDataCenter->getForm($mode, $form_tag, $name, $type, $value, $options, $attr, $sort);

//批次表單
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->assignBatchForm($form_tag, $data_arr = array(), $type = '')

//儲存資料：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveData();
或
$TadDataCenter->saveCustomData($data_arr = array());

//取得資料陣列：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$data=$TadDataCenter->getData($name,$sort=0);
$xoopsTpl->assign('TDC', $data);
<{$TDC.data_name.0}>

//刪除資料：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->delData($name,$sort);

//-------------------------------------------------------------------------

//後台自訂問卷界面
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$xoopsTpl->assign('CustomSetupForm', $TadDataCenter->getCustomSetupForm(true, false));
<{$CustomSetupForm}>

//顯示問卷
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$xoopsTpl->assign('CustomForm', $TadDataCenter->getCustomForm());
<{$CustomForm}>

//後台自訂問卷設定儲存
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveCustomSetupForm();

//前台自訂問卷答案儲存
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveCustomSetupFormVal();

或
case "saveCustomSetupFormVal":
$user = get_integration_users();
$TadDataCenter->set_col('tea_uid', $user['iuId']);
$TadDataCenter->saveCustomSetupFormVal();
break;

//自訂表單填答列表（表格）
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$getCustomAns=$TadDataCenter->getCustomAns();

//自訂表單題目
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$CustomSetup      = $TadDataCenter->getCustomSetup();

//自訂表單填答陣列
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$getCustomAnsArr=$TadDataCenter->getCustomAnsArr();

資料表：
CREATE TABLE `模組名稱_data_center` (
`mid` mediumint(9) unsigned NOT NULL  COMMENT '模組編號',
`col_name` varchar(100) NOT NULL default '' COMMENT '欄位名稱',
`col_sn` mediumint(9) unsigned NOT NULL COMMENT '欄位編號',
`data_name` varchar(100) NOT NULL default '' COMMENT '資料名稱',
`data_value` text NOT NULL COMMENT '儲存值',
`data_sort` mediumint(9) unsigned NOT NULL  COMMENT '排序',
PRIMARY KEY  (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
) ENGINE=MyISAM;

 */

class TadDataCenter
{
    public $col_name;
    public $col_sn;
    public $ans_col_name;
    public $ans_col_sn;
    public $module_dirname;
    public $mid;
    public $TadDataCenterTblName;

    public function __construct($module_dirname = "")
    {
        global $xoopsDB;
        if (!empty($module_dirname)) {
            $this->set_module_dirname($module_dirname);
        }

        $this->TadDataCenterTblName = $xoopsDB->prefix("{$this->module_dirname}_data_center");

    }

    //設定模組名稱
    public function set_module_dirname($module_dirname = '')
    {
        $this->module_dirname = $module_dirname;
        $this->set_mid();
    }

    //設定模組編號
    public function set_mid()
    {
        global $xoopsDB, $xoopsModule;
        if ($this->module_dirname != '') {
            $sql             = "select mid from " . $xoopsDB->prefix("modules") . " where dirname='{$this->module_dirname}'";
            $result          = $xoopsDB->queryF($sql) or web_error($sql);
            list($this->mid) = $xoopsDB->fetchRow($result);
        } elseif ($xoopsModule) {
            $this->mid = $xoopsModule->mid();
        }
        return $this->mid;
    }

    public function set_col($col_name = "", $col_sn = "")
    {
        $this->col_name = $col_name;
        $this->col_sn   = $col_sn;
    }

    public function set_ans_col($ans_col_name = "", $ans_col_sn = "")
    {
        $this->ans_col_name = $ans_col_name;
        $this->ans_col_sn   = $ans_col_sn;
    }
    //取得表單
    public function getForm($mode = 'return', $form_tag, $name, $type = '', $def_value = '', $options = array(), $attr = array(), $sort = '', $ans_col_name = '', $ans_col_sn = '')
    {
        global $xoopsTpl;

        if ($type == 'checkbox') {
            $dbv   = $this->getData($name, null, $ans_col_name, $ans_col_sn);
            $value = isset($dbv[$name]) ? $dbv[$name] : $def_value;
        } elseif ($sort > 0) {
            $dbv   = $this->getData($name, $sort, $ans_col_name, $ans_col_sn);
            $value = isset($dbv[$name]) ? $dbv[$name] : $def_value;

        } else {
            $dbv   = $this->getData($name, null, $ans_col_name, $ans_col_sn);
            $value = isset($dbv[$name]) ? $dbv[$name][0] : $def_value;
        }

        if (empty($attr)) {
            if (in_array($type, array('radio', 'checkbox', 'checkbox-radio'))) {
                $attr = array('id' => $name);
            } else {
                $attr = array('class' => 'form-control', 'id' => $name);
            }
        }

        $attr_str = '';
        foreach ($attr as $k => $v) {
            $attr_str .= " {$k}=\"{$v}\"";
        }

        $arr = $sort > 0 ? "[$sort]" : '';
        switch ($form_tag) {
            case 'input':
                if ($type == "radio") {
                    $form = '';
                    foreach ($options as $k => $v) {
                        $checked = $v == $value ? 'checked' : '';
                        $form .= "<label class=\"radio-inline\"><input type=\"{$type}\" name=\"TDC[{$name}]{$arr}\" value=\"{$v}\" {$checked} {$attr_str}>{$k}</label>\n";
                    }
                } elseif ($type == "checkbox") {
                    $form = '';
                    foreach ($options as $k => $v) {
                        $checked = in_array($v, $value) ? 'checked' : '';
                        $form .= "<label class=\"checkbox-inline\"><input type=\"{$type}\" name=\"TDC[{$name}]{$arr}[]\" value=\"{$v}\" {$checked} {$attr_str}>{$k}</label>\n";
                    }

                } elseif ($type == "checkbox-radio") {
                    $form = '';
                    foreach ($options as $k => $v) {
                        $checked = in_array($v, $value) ? 'checked' : '';
                        $form .= "<label class=\"checkbox\"><input type=\"checkbox\" name=\"TDC[{$name}]{$arr}\" value=\"{$v}\" {$checked} {$attr_str}>{$k}</label>\n";
                    }
                } elseif ($type == "") {
                    $form = "<input type=\"text\" name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str}>";
                } else {
                    $form = "<input type=\"{$type}\" name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str}>";
                }
                break;
            case 'select':
                $options_str = '';
                foreach ($options as $k => $v) {
                    $selected = $k == $value ? 'selected' : '';
                    $options_str .= "<option value=\"{$k}\" {$selected}>{$v}</option>\n";
                }
                $form = "<select name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str}>
                {$options_str}
                </select>";
                break;
            case 'textarea':
                $form = "<textarea name=\"TDC[{$name}]{$arr}\" {$attr_str}>{$value}</textarea>";
                break;
                $options_str = '';
                foreach ($options as $k => $v) {
                    $selected = $k == $value ? 'selected' : '';
                    $options_str .= "<option value=\"{$k}\" {$selected}>{$v}</option>\n";
                }
                $form = "<select name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str}>
                {$options_str}
                </select>";
                break;
            case 'note':
                $options_str = implode('', $options);
                $form        = "<div class='form-control-static'><b>{$options_str}</b></div>";
                break;
        }

        if ($xoopsTpl and $mode == 'assign') {
            $xoopsTpl->assign($name, $form);
        } else {
            return $form;
        }

    }

    //套用文字框到Smarty
    public function assignBatchForm($form_tag, $data_arr = array(), $type = '', $attr = array())
    {
        foreach ($data_arr as $col_name) {
            $this->getForm('assign', $form_tag, $col_name, $type, '', '', $attr);
        }
    }

    //儲存資料 $data[]=['name'=>$name, 'value'=>$value, 'sort'=>$sort]
    public function saveData()
    {
        global $xoopsDB;
        $myts = MyTextSanitizer::getInstance();
        // die(var_export($_REQUEST['TDC']));
        // die('$this->col_sn=' . $this->col_sn);
        foreach ($_REQUEST['TDC'] as $name => $value) {

            $name   = $myts->addSlashes($name);
            $values = array();
            if (!is_array($value)) {
                $values[0] = $value;
            } else {
                $values = $value;
            }

            foreach ($values as $sort => $val) {
                if ($_REQUEST['dc_op'] == "saveCustomSetupForm" and empty($val)) {
                    continue;
                }
                $val = $myts->addSlashes($val);
                // die("$name, $sort");
                $this->delData($name, $sort);

                $sql = "insert into `{$this->TadDataCenterTblName}`
                (`mid` , `col_name` , `col_sn` , `data_name` , `data_value` , `data_sort`)
                values('{$this->mid}' , '{$this->col_name}' , '{$this->col_sn}' , '{$name}' , '{$val}' , '{$sort}')";
                $xoopsDB->queryF($sql) or web_error($sql);
            }
        }
    }

    //儲存資料 $data[]=['name'=>$name, 'value'=>$value, 'sort'=>$sort]
    public function saveCustomData($data_arr = array())
    {
        global $xoopsDB;
        $myts = MyTextSanitizer::getInstance();
        foreach ($data_arr as $name => $value) {
            $name   = $myts->addSlashes($name);
            $values = array();
            if (!is_array($value)) {
                $values[0] = $value;
            } else {
                $values = $value;
            }

            foreach ($values as $sort => $val) {
                $val = $myts->addSlashes($val);
                $this->delData($name, $sort);

                $sql = "insert into `{$this->TadDataCenterTblName}`
                (`mid` , `col_name` , `col_sn` , `data_name` , `data_value` , `data_sort`)
                values('{$this->mid}' , '{$this->col_name}' , '{$this->col_sn}' , '{$name}' , '{$val}' , '{$sort}')";
                $xoopsDB->queryF($sql) or web_error($sql);
            }
        }
    }

    //取得資料
    public function getData($name = '', $data_sort = null, $ans_col_name = '', $ans_col_sn = '')
    {
        global $xoopsDB;
        $myts     = MyTextSanitizer::getInstance();
        $and_name = ($name != '') ? "and `data_name`='{$name}'" : "";
        $and_sort = ($sort != '') ? "and `data_sort`='{$sort}'" : "";

        $col_name = !empty($ans_col_name) ? $ans_col_name : $this->col_name;
        $col_sn   = !empty($ans_col_name) ? $ans_col_sn : $this->col_sn;

        $sql = "select `data_name`,`data_sort`, `data_value` from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}' {$and_name} {$and_sort}";
        // echo $sql."<br>";
        $result = $xoopsDB->queryF($sql) or web_error($sql);
        if (isset($data_sort)) {
            list($data_name, $data_sort, $data_value) = $xoopsDB->fetchRow($result);
            return $data_value;
        } else {
            $values = array();
            while (list($data_name, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
                $values[$data_name][$data_sort] = $data_value;
            }
            return $values;
        }

    }

    //刪除資料
    public function delData($name = '', $data_sort = '')
    {
        global $xoopsDB;
        $myts     = MyTextSanitizer::getInstance();
        $and_name = ($name != '') ? "and `data_name`='{$name}'" : "";
        $and_sort = ($data_sort != '') ? "and `data_sort`='{$data_sort}'" : "";
        $sql      = "delete from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' and `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' {$and_name} {$and_sort}";
        // die($sql);
        $xoopsDB->queryF($sql) or web_error($sql);
    }

    public function mk_form_group($left_width, $right_width, $label, $form, $input_group = false, $help = '', $require = '')
    {
        $help_text    = $help ? '<div><small class="text-muted">' . $help . '</small></div>' : "";
        $ig_tag_start = $input_group ? '<div class="input-group">' : '';
        $ig_tag_body  = $input_group ? '<span class="input-group-btn">' . $input_group . '</span>' : '';
        $ig_tag_end   = $input_group ? '</div>' : '';
        $require_mark = $require == 1 ? ' <span style="color:red;">*</span>' : '';
        $main         = '
        <div class="form-group">
            <label class="col-sm-' . $left_width . ' control-label">' . $label . $require_mark . '</label>
            <div class="col-sm-' . $right_width . '">
            ' . $ig_tag_start . '
            ' . $form . '
            ' . $ig_tag_body . '
            ' . $ig_tag_end . '
            ' . $help_text . '
            </div>
        </div>
        ';
        return $main;
    }

    //$form_arr[]=array('0'=>3,'1'=>4,'2'=>'xxx','3'='<input>');
    public function mk_form_group_arr($form_arr)
    {
        $main = '<div class="form-group">';
        foreach ($form_arr as $k => $form) {
            $sronly = empty($form[0]) ? 'sr-only' : '';
            $main .= '
                <label class="col-sm-' . $form[0] . ' control-label ' . $sronly . '">' . $form[2] . '</label>
                <div class="col-sm-' . $form[1] . '">
                ' . $form[3] . '
                </div>
            ';
        }
        $main .= '</div>';

        return $main;
    }
    //從界面取得自訂表單
    public function getCustomSetupForm($action)
    {
        $action = empty($action) ? $_SERVER['PHP_SELF'] : $action;
        $data   = $this->getData('dcq');
        $sort   = 0;
        $main   = '<form action="' . $action . '" method="post" class="form-horizontal">';
        foreach ($data['dcq'] as $sort => $json) {
            $main .= $this->getCustomSetupCol($sort, $json);
            $sort++;
        }
        $main .= $this->getCustomSetupCol($sort);
        $main .= '<input type="hidden" name="dc_op" value="saveCustomSetupForm">';
        $main .= '<input type="hidden" name="' . $this->col_name . '" value="' . $this->col_sn . '">';
        $main .= '<div class="text-center"><button type="submit" class="btn btn-primary">儲存</button></div>';
        $main .= '</form>';

        return $main;
    }

    //取得設定界面的單一欄位
    private function getCustomSetupCol($sort, $json)
    {

        $val = json_decode($json, true);

        $col_type_arr['input=text']     = _TDC_INPUT;
        $col_type_arr['input=radio']    = _TDC_RADIO;
        $col_type_arr['input=checkbox'] = _TDC_CHECKBOX;
        $col_type_arr['select']   = _TDC_SELECT;
        $col_type_arr['textarea'] = _TDC_TEXTAREA;
        $col_type_arr['note']     = _TDC_NOTE;
        $option                   = '';
        foreach ($col_type_arr as $type => $text) {
            $selected = $val['type'] == $type ? "selected" : '';
            $option .= '<option value="' . $type . '" ' . $selected . '>' . $text . '</option>';
        }

        $i          = $sort + 1;
        $form_arr   = array();
        $form_arr[] = array(1, 2, _TDC_TITLE . $i, '<input type="text" name="dcq[' . $sort . '][title]" class="form-control" placeholder="'._TDC_INPUT_TITLE.'" value="' . $val['title'] . '">');

        $form_arr[] = array(0, 3, _TDC_DESCRIPTION, '<input type="text" name="dcq[' . $sort . '][placeholder]" class="form-control" placeholder="'._TDC_INPUT_DESCRIPTION.'" value="' . $val['placeholder'] . '">');

        $form_arr[] = array(0, 1, _TDC_TYPE, '<select name="dcq[' . $sort . '][type]" class="form-control">' . $option . '</select>');
        $form_arr[] = array(0, 4, _TDC_OPTIONS, '<input type="text" name="dcq[' . $sort . '][opt]" class="form-control" placeholder="'._TDC_OPTIONS_NOTE.'" value="' . $val['opt'] . '">');

        $checked    = $val['require'] == 1 ? 'checked' : '';
        $form_arr[] = array(0, 1, _TDC_REQUIRE . $i, '<label class="checkbox-inline"><input type="checkbox" name="dcq[' . $sort . '][require]" value="1" ' . $checked . '>'._TDC_REQUIRE.'</label>');
        $main .= $this->mk_form_group_arr($form_arr);
        return $main;
    }

    //儲存自訂表單設定
    public function saveCustomSetupForm()
    {
        if ($_REQUEST['dc_op'] == "saveCustomSetupForm") {
            $this->saveDcqData();
            header("location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    //儲存自訂問卷資料資料
    private function saveDcqData()
    {
        global $xoopsDB;
        $myts = MyTextSanitizer::getInstance();
        // die(var_export($_REQUEST['dcq']));
        // die('$this->col_sn=' . $this->col_sn);
        foreach ($_REQUEST['dcq'] as $sort => $dcq) {
            if ($_REQUEST['dc_op'] == "saveCustomSetupForm" and empty($dcq['title'])) {
                continue;
            }

            $json_val = json_encode($dcq, JSON_UNESCAPED_UNICODE);
            $json_val = $myts->addSlashes($json_val);

            $this->delData('dcq', $sort);

            $sql = "insert into `{$this->TadDataCenterTblName}`
                    (`mid` , `col_name` , `col_sn` , `data_name` , `data_value` , `data_sort`)
                    values('{$this->mid}' , '{$this->col_name}' , '{$this->col_sn}' , 'dcq' , '{$json_val}' , '{$sort}')";
            $xoopsDB->queryF($sql) or web_error($sql);

        }
    }

    //取得自訂表單題目設定
    public function getCustomSetup()
    {
        $data    = $this->getData('dcq');
        $dcq_arr = array();
        foreach ($data['dcq'] as $sort => $json) {
            $dcq                                 = json_decode($json, true);
            list($dcq['form_tag'], $dcq['type']) = explode('=', $dcq['type']);

            $dcq['name'] = "{$this->col_name}_{$this->col_sn}_dcq_{$sort}";

            $options    = explode(';', $dcq['opt']);
            $option_arr = array();
            foreach ($options as $opt) {
                if (strpos($opt, '=') !== false) {
                    list($key, $val) = explode('=', $opt);
                } else {
                    $key = $val = $opt;
                }
                $option_arr[$key] = $val;
            }
            $dcq['option_arr'] = $option_arr;
            $dcq_arr[$sort]    = $dcq;
        }
        return $dcq_arr;
    }

    //取得自訂表單
    public function getCustomForm($use_form = true, $use_submit = false, $action = '', $lw = 3, $rw = 9)
    {

        $action   = empty($action) ? $_SERVER['PHP_SELF'] : $action;
        $data     = $this->getData('dcq');
        $sort     = 0;
        $form_col = '';
        foreach ($data['dcq'] as $sort => $json) {
            $dcq                   = json_decode($json, true);
            list($form_tag, $type) = explode('=', $dcq['type']);

            $name       = "{$this->col_name}_{$this->col_sn}_dcq_{$sort}";
            $options    = explode(';', $dcq['opt']);
            $option_arr = array();
            foreach ($options as $opt) {
                if (strpos($opt, '=') !== false) {
                    list($key, $val) = explode('=', $opt);
                } else {
                    $key = $val = $opt;
                }
                $option_arr[$key] = $val;
            }

            $require = $dcq['require'] == 1 ? " validate[required]" : "";
            if (in_array($type, array('radio', 'checkbox', 'checkbox-radio'))) {
                $attr_arr = array('class' => $require, 'id' => $name);
            } else {
                $attr_arr = array('class' => "form-control $require", 'id' => $name, 'placeholder' => $dcq['placeholder']);
            }
            $col = $this->getForm('return', $form_tag, $name, $type, null, $option_arr, $attr_arr, null, $this->ans_col_name, $this->ans_col_sn);
            $form_col .= $this->mk_form_group($lw, $rw, $dcq['title'], $col, false, $dcq['placeholder'], $dcq['require']);
        }

        if ($form_col) {
            $form = '';
            if ($use_form) {
                include_once XOOPS_ROOT_PATH . "/modules/tadtools/formValidator.php";
                $formValidator      = new formValidator("#myForm", false);
                $formValidator_code = $formValidator->render('topLeft');
                $form               = '<form action="' . $action . '" id="myForm" method="post" class="form-horizontal">';
            }
            $form .= $form_col;
            $form .= $use_submit ? $this->mk_form_group($lw, $rw, '', '<input type="hidden" name="op" value="saveCustomSetupFormVal"><input type="hidden" name="dc_op" value="saveCustomSetupFormVal"><input type="hidden" name="' . $this->ans_col_name . '" value="' . $this->ans_col_sn . '"><button type="submit" class="btn btn-primary">'._TAD_SAVE.'</button>') : '';
            $form .= $use_form ? "</form>" : '';
            return $form;
        }
    }

    //儲存自訂表單值
    public function saveCustomSetupFormVal()
    {
        // die(var_dump($_REQUEST));
        if ($_REQUEST['dc_op'] == "saveCustomSetupFormVal") {
            $this->saveData();
            header("location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    //已填答案列表
    public function getCustomAns($call_back_func = "")
    {

        $data = $this->getData('dcq');
        $main = "<table class='table table-bordered table-striped table-hover'>
        <tr><th>填寫人</th>";
        foreach ($data['dcq'] as $sort => $json) {
            $dcq                   = json_decode($json, true);
            list($form_tag, $type) = explode('=', $dcq['type']);
            if ($form_tag == "note") {
                continue;
            }
            $name[] = "{$this->col_name}_{$this->col_sn}_dcq_{$sort}";
            $main .= "<th>{$dcq['title']}</th>";

        }
        // die(var_dump($ans));
        $main .= "</tr>";

        $ans = $this->getDcqDataArr($name);

        foreach ($ans as $col_sn => $ans_arr) {
            $title = ($call_back_func) ? call_user_func($call_back_func, $col_sn) : $col_sn;

            $main .= "<tr><td>{$title}</td>";

            // foreach ($ans_arr as $data_name => $value) {
            foreach ($name as $data_name) {
                $main .= "<td>";
                $main .= nl2br(implode("、", $ans_arr[$data_name]));
                $main .= "</td>";
            }

            $main .= "</tr>";
        }
        $main .= "</table>";
        return $main;
    }

    //已填答案陣列
    public function getCustomAnsArr()
    {

        $data = $this->getData('dcq');
        foreach ($data['dcq'] as $sort => $json) {
            $dcq                   = json_decode($json, true);
            list($form_tag, $type) = explode('=', $dcq['type']);
            if ($form_tag == "note") {
                continue;
            }
            $name[] = "{$this->col_name}_{$this->col_sn}_dcq_{$sort}";
        }

        $ans = $this->getDcqDataArr($name);
        return $ans;
    }

    //取得填答資料陣列
    public function getDcqDataArr($data_name = '')
    {
        global $xoopsDB;
        if (is_array($data_name)) {
            foreach ($data_name as $name) {
                $sql = "select col_sn, data_sort ,data_value from `{$this->TadDataCenterTblName}`
                    where `mid`= '{$this->mid}' and `data_name`='{$name}' order by col_sn";
                $result = $xoopsDB->queryF($sql) or web_error($sql);

                while (list($col_sn, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
                    $values[$col_sn][$name][$data_sort] = $data_value;
                }
            }
        } else {
            $sql = "select col_sn, data_sort ,data_value from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' and `data_name`='{$data_name}' order by col_sn";
            $result = $xoopsDB->queryF($sql) or web_error($sql);

            while (list($col_sn, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
                $values[$col_sn][$data_name][$data_sort] = $data_value;
            }
        }
        return $values;

    }

    private function rand_str($len = 6, $format = 'ALL')
    {
        switch ($format) {
            case 'ALL':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
            case 'CHAR':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'NUMBER':
                $chars = '0123456789';
                break;
            default:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        list($usec, $sec) = explode(' ', microtime());
        $seed             = (float) $sec + ((float) $usec * 100000);
        // die('seed=' . $seed);
        mt_srand($seed);
        $password = "";
        while (strlen($password) < $len) {
            $password .= substr($chars, (mt_rand() % strlen($chars)), 1);
        }

        return $password;
    }
}
