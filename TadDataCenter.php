<?php
/*

//單一表單
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name);
$form=$TadDataCenter->getForm($form_tag, $name, $type, $value, $options, $attr, $other);

//批次表單
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name);
$TadDataCenter->assignBatchForm($form_tag, $data_arr = [], $type = '')

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
$data=$TadDataCenter->getData($name,$sort);
$xoopsTpl->assign('TDC', $data);
<{$TDC.data_name.0}>

//刪除資料：
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadDataCenter.php" ;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->delData($name,$sort);

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

    //取得表單
    public function getForm($mode = 'return', $form_tag, $name, $type = '', $def_value = '', $options = [], $attr = [], $other = '')
    {
        global $xoopsTpl;

        $dbv = $this->getData($name);

        if ($type == 'checkbox') {
            $value = isset($dbv[$name]) ? $dbv[$name] : $def_value;
        } else {
            $value = isset($dbv[$name]) ? $dbv[$name][0] : $def_value;
        }

        if (empty($attr)) {
            $attr = ['class' => 'form-control', 'id' => $name];
        }

        $attr_str = '';
        foreach ($attr as $k => $v) {
            $attr_str .= " {$k}=\"{$v}\"";
        }
        switch ($form_tag) {
            case 'input':
                if ($type == "radio") {
                    $form = '';
                    foreach ($options as $k => $v) {
                        $checked = $v == $value ? 'checked' : '';
                        $form .= "<div class=\"radio-inline\"><input type=\"{$type}\" name=\"TDC[{$name}]\" value=\"{$v}\" {$checked} {$attr_str}>{$k}</div>\n";
                    }
                } elseif ($type == "checkbox") {
                    $form = '';
                    foreach ($options as $k => $v) {
                        $checked = in_array($v, $value) ? 'checked' : '';
                        $form .= "<div class=\"checkbox-inline\"><input type=\"{$type}\" name=\"TDC[{$name}][]\" value=\"{$v}\" {$checked} {$attr_str}>{$k}</div>\n";
                    }
                } elseif ($type == "") {
                    $form = "<input type=\"text\" name=\"TDC[{$name}]\" value=\"{$value}\" {$attr_str}>";
                } else {
                    $form = "<input type=\"{$type}\" name=\"TDC[{$name}]\" value=\"{$value}\" {$attr_str}>";
                }
                break;
            case 'select':
                $options_str = '';
                foreach ($options as $k => $v) {
                    $selected = $k == $value ? 'selected' : '';
                    $options_str .= "<option value=\"{$k}\" {$selected}>{$v}</option>\n";
                }
                $form = "<select name=\"TDC[{$name}]\" value=\"{$value}\" {$attr_str}>
                {$options_str}
                </select>";
                break;
            case 'textarea':
                $form = "<textarea name=\"TDC[{$name}]\" {$attr_str}>{$value}</textarea>";
                break;
        }
        if ($mode == 'assign') {
            $xoopsTpl->assign($name, $form);
        } else {
            return $form;
        }

    }

    //套用文字框到Smarty
    public function assignBatchForm($form_tag, $data_arr = [], $type = '', $attr = [])
    {
        foreach ($data_arr as $col_name) {
            $this->getForm('assign', $form_tag, $col_name, $type, '', '', $attr);
        }
    }

    //儲存資料 $data[]=['name'=>$name, 'value'=>$value, 'sort'=>$sort]
    public function saveData()
    {
        global $xoopsDB;
        $myts = &MyTextSanitizer::getInstance();
        // die(var_export($_REQUEST['TDC']));
        // die('$this->col_sn=' . $this->col_sn);
        foreach ($_REQUEST['TDC'] as $name => $value) {
            $name   = $myts->addSlashes($name);
            $values = '';
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

    //儲存資料 $data[]=['name'=>$name, 'value'=>$value, 'sort'=>$sort]
    public function saveCustomData($data_arr = array())
    {
        global $xoopsDB;
        $myts = &MyTextSanitizer::getInstance();
        foreach ($data_arr as $name => $value) {
            $name   = $myts->addSlashes($name);
            $values = '';
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
    public function getData($name = '', $sort = '')
    {
        global $xoopsDB;
        $myts     = &MyTextSanitizer::getInstance();
        $and_name = ($name != '') ? "and `data_name`='{$name}'" : "";
        $and_sort = ($sort != '') ? "and `data_sort`='{$sort}'" : "";
        $sql      = "select `data_name`,`data_sort`, `data_value` from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' and `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' {$and_name} {$and_sort}";
        // die($sql);
        $result = $xoopsDB->queryF($sql) or web_error($sql);
        if (isset($data_sort)) {
            list($data_name, $data_sort, $data_value) = $xoopsDB->fetchRow($result);
            return $data_value;
        } else {
            $values = '';
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
        $myts     = &MyTextSanitizer::getInstance();
        $and_name = ($name != '') ? "and `data_name`='{$name}'" : "";
        $and_sort = ($data_sort != '') ? "and `data_sort`='{$data_sort}'" : "";
        $sql      = "delete from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' and `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' {$and_name} {$and_sort}";
        $xoopsDB->queryF($sql) or web_error($sql);
    }
}
