<?php
namespace XoopsModules\Tadtools;

use Xmf\Request;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\My97DatePicker;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

/*

///單一表單
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$form=$TadDataCenter->getForm($mode, $form_tag, $name, $type, $value, $options, $attr, $sort);

///批次表單
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->assignBatchForm($form_tag, $data_arr = array(), $type = '', $attr=[])

///儲存資料：
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveData();
或
$data_arr=[
$data_name => [0 => $data_value],
$data_name => [0 => $data_value],
];

$TadDataCenter->saveCustomData($data_arr = array());

///取得資料陣列：
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$data=$TadDataCenter->getData($name,$sort=0);
$xoopsTpl->assign('TDC', $data);
<{$TDC.data_name.0}>

///刪除資料：
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->delData($name,$sort);

///-------------------------------------------------------------------------

///後台自訂問卷界面
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$xoopsTpl->assign('CustomSetupForm', $TadDataCenter->getCustomSetupForm($action));
<{$CustomSetupForm|default:''}>

///顯示問卷
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$xoopsTpl->assign('CustomForm', $TadDataCenter->getCustomForm($use_form = true, $use_submit = false, $action = '', $lw = 3, $rw = 9));
<{$CustomForm|default:''}>

///後台自訂問卷設定儲存
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveCustomSetupForm();

///前台自訂問卷答案儲存
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$TadDataCenter->saveData();

///自訂表單填答列表（表格）
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$getCustomAns=$TadDataCenter->getCustomAns();

///自訂表單題目
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$CustomSetup      = $TadDataCenter->getCustomSetup();

///自訂表單填答陣列
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$TadDataCenter->set_col($col_name,$col_sn);
$getCustomAnsArr=$TadDataCenter->getCustomAnsArr();

///文字轉表單
use XoopsModules\Tadtools\TadDataCenter;
$TadDataCenter=new TadDataCenter($module_dirname);
$Form = $TadDataCenter->strToForm($str);

資料表：
CREATE TABLE `模組名稱_data_center` (
`mid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '模組編號',
`col_name` varchar(100) NOT NULL DEFAULT '' COMMENT '欄位名稱',
`col_sn` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '欄位編號',
`data_name` varchar(100) NOT NULL DEFAULT '' COMMENT '資料名稱',
`data_value` text NOT NULL COMMENT '儲存值',
`data_sort` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
`col_id` varchar(100) NOT NULL COMMENT '辨識字串',
`sort` mediumint(9) unsigned COMMENT '顯示順序',
`update_time` datetime NOT NULL COMMENT '更新時間',
PRIMARY KEY (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
    public $col_id;
    public $attr_merge = true;
    public $col_kind = [
        'radio' => ['form_tag' => 'input', 'type' => 'radio'],
        'checkbox' => ['form_tag' => 'input', 'type' => 'checkbox'],
        'select' => ['form_tag' => 'select', 'type' => 'select'],
        'textarea' => ['form_tag' => 'textarea', 'type' => 'textarea'],
        'hidden' => ['form_tag' => 'input', 'type' => 'hidden'],
        'const' => ['form_tag' => 'input', 'type' => 'hidden'],
        'text' => ['form_tag' => 'input', 'type' => 'text'],
    ];

    public function __construct($module_dirname = '')
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
        if ('' != $this->module_dirname) {
            $sql = 'SELECT `mid` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `dirname` = ?';
            $result = Utility::query($sql, 's', [$this->module_dirname]) or Utility::web_error($sql, __FILE__, __LINE__);
            list($this->mid) = $xoopsDB->fetchRow($result);
        } elseif ($xoopsModule) {
            $this->mid = $xoopsModule->mid();
        }

        return $this->mid;
    }

    public function set_col($col_name = '', $col_sn = '')
    {
        $this->col_name = $col_name;
        $this->col_sn = $col_sn;
    }

    public function set_var($name = '', $val = '')
    {
        $this->$name = $val;
    }

    public function set_ans_col($ans_col_name = '', $ans_col_sn = '')
    {
        $this->ans_col_name = $ans_col_name;
        $this->ans_col_sn = $ans_col_sn;
    }

    //取得表單
    public function getForm($mode, $form_tag, $name, $type = '', $def_value = '', $options = [], $attr = [], $sort = null, $ans_col_name = '', $ans_col_sn = '')
    {
        global $xoopsTpl, $xoopsUser;

        $myts = \MyTextSanitizer::getInstance();
        if ('checkbox' === $type) {
            $dbv = $this->getData($name, null, $ans_col_name, $ans_col_sn);
            $value = isset($dbv[$name]) ? $dbv[$name] : $def_value;

        } elseif ($sort > 0) {
            $dbv = $this->getData($name, $sort, $ans_col_name, $ans_col_sn);
            if (is_array($dbv)) {
                $value = isset($dbv[$name]) ? $dbv[$name] : $def_value;
            } else {
                $value = isset($dbv) ? $dbv : $def_value;
            }

        } else {
            $dbv = $this->getData($name, null, $ans_col_name, $ans_col_sn);
            $value = isset($dbv[$name]) ? $dbv[$name][0] : $def_value;
        }

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $myts->htmlSpecialChars($v);
            }
        } else {
            $value = $myts->htmlSpecialChars($value);

        }

        if (in_array($type, ['radio', 'checkbox', 'checkbox-radio'])) {
            $defalut_attr = ['class' => 'form-check-input'];
        } elseif (in_array($form_tag, ['user_name', 'user_email'])) {
            $defalut_attr = ['class' => "my-text"];
        } elseif (in_array($form_tag, ['SchoolCode'])) {
            $defalut_attr = ['class' => "my-input"];
        } elseif (in_array($type, ['file'])) {
            if (empty($dbv[$name][0]) || $dbv[$name][0] == 'files=') {
                $require = $attr['require'];
            }
            $attr = [];
            $defalut_attr = ['class' => 'form-check-input'];
        } else {
            $defalut_attr = ['class' => ['my-input', 'my-100'], 'id' => $name . $sort];
        }

        if ($this->attr_merge) {
            $attr = array_merge_recursive($attr, $defalut_attr);
        }

        $attr_str = '';
        foreach ($attr as $k => $v) {
            $attr_str .= is_array($v) ? " {$k}=\"" . implode(' ', $v) . "\"" : " {$k}=\"{$v}\"";
        }

        $arr = !is_null($sort) ? "[$sort]" : '';
        switch ($form_tag) {
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

            case 'ckeditor':
                $ck = new CkEditor($this->module_dirname, "TDC[{$name}]{$arr}", $value);
                $ck->setHeight(120);
                $ck->setToolbarSet('tadSimple');
                $form = $ck->render();

                break;

            case 'note':
                $options_str = implode('', $options);
                $form = "<div class='form-control-static'><b>{$options_str}</b></div>";
                break;
            case 'user_name':
                $user_name = $xoopsUser ? $xoopsUser->name() : '';
                $value = empty($value) ? $user_name : $value;
                $form = "<input type=\"text\" name=\"TDC[{$name}]{$arr}\" readonly value=\"{$value}\" {$attr_str}>";
                break;
            case 'user_email':
                $email = $xoopsUser ? $xoopsUser->email() : '';
                $value = empty($value) ? $email : $value;
                $form = "<input type=\"text\" name=\"TDC[{$name}]{$arr}\" readonly value=\"{$value}\" {$attr_str}>";
                break;

            case 'SchoolCode':
                $SchoolCode = $xoopsUser ? $xoopsUser->user_intrest() : '';
                $value = empty($value) ? $SchoolCode : $value;
                if (!empty($value)) {
                    // $handle = fopen("https://campus-xoops.tn.edu.tw/get_schools.php?SchoolCode=$value&mode=andCounty", "rb");
                    // $school_name = stream_get_contents($handle);
                    // $school_name = file_get_contents("https://campus-xoops.tn.edu.tw/get_schools.php?SchoolCode=$value&mode=andCounty");
                    $school_name = Utility::vita_get_url_content("https://campus-xoops.tn.edu.tw/get_schools.php?SchoolCode=$value&mode=andCounty");
                    // die($school_name);
                }

                if (empty($SchoolCode)) {
                    $form = "
                    <script type=\"text/javascript\">
                        $(document).ready(function(){
                            $('#school_code').autocomplete({
                                source: \"https://campus-xoops.tn.edu.tw/get_schools.php\",
                                select: function( event, ui ) {
                                    console.log(ui.item.label);
                                    $('#school_name').val(ui.item.label);
                                }
                            });
                        });

                    </script>
                    <input type=\"text\" name=\"TDC[{$name}]{$arr}\" id='school_code' value=\"{$value}\" {$attr_str}>
                    <input type=\"text\" name=\"TDC[school_name]{$arr}\" id='school_name' readonly class=\"my-text\">";
                } else {
                    $form = "
                    <input type=\"text\" name=\"TDC[school_name]{$arr}\" readonly class=\"my-text\" value=\"{$school_name}\" {$attr_str}>
                    <input type=\"text\" name=\"TDC[{$name}]{$arr}\" readonly class=\"my-text\" value=\"{$value}\" {$attr_str}> ";
                }
                break;

            case 'input':
            default:
                if ('radio' === $type) {
                    $form = '';
                    $tmp_id = $this->rand_str();
                    $idi = 0;
                    foreach ($options as $k => $v) {
                        $checked = $v == $value ? 'checked' : '';
                        $form .= "<div class=\"form-check-inline radio-inline\">
                            <label class=\"form-check-label\" for=\"{$tmp_id}{$idi}\" >
                                <input {$attr_str} type=\"{$type}\" name=\"TDC[{$name}]{$arr}\" id=\"{$tmp_id}{$idi}\" value=\"{$v}\" {$checked}>
                                {$k}
                            </label>
                        </div>\n";
                        $idi++;
                    }
                } elseif ('checkbox' === $type) {
                    $form = '';
                    $tmp_id = $this->rand_str();
                    $idi = 0;

                    foreach ($options as $k => $v) {
                        $checked = is_array($value) && in_array($v, $value) ? 'checked' : '';
                        $form .= "<div class=\"form-check-inline checkbox-inline\">
                            <label class=\"form-check-label\" for=\"{$tmp_id}{$idi}\">
                                <input {$attr_str} type=\"{$type}\" name=\"TDC[{$name}]{$arr}[]\" id=\"{$tmp_id}{$idi}\" value=\"{$v}\" {$checked}>
                                {$k}
                            </label>
                        </div>\n";
                        $idi++;
                    }
                } elseif ('checkbox-radio' === $type) {
                    $form = '';
                    $tmp_id = $this->rand_str();
                    $idi = 0;
                    foreach ($options as $k => $v) {
                        $checked = in_array($v, $value) ? 'checked' : '';
                        $form .= "<div class=\"form-check-inline checkbox-inline\">
                            <label class=\"form-check-label\" for=\"{$tmp_id}{$idi}\">
                                <input {$attr_str} type=\"checkbox\" name=\"TDC[{$name}]{$arr}\" id=\"{$tmp_id}{$idi}\" value=\"{$v}\" {$checked}>
                                {$k}
                            </label>
                        </div>\n";
                        $idi++;
                    }
                } elseif ('date' === $type) {
                    $cal = new My97DatePicker();
                    $cal::render();
                    $form = "<input type=\"text\" name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str} onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})\">";
                } elseif ('file' === $type) {
                    $file_name = $name;
                    $TadUpFiles = new TadUpFiles($this->module_dirname, '/' . $file_name);
                    if ($require) {
                        $TadUpFiles->set_var('require', true);
                    }
                    //必填
                    $TadUpFiles->set_var("show_tip", false); //不顯示提示
                    $TadUpFiles->set_col($this->ans_col_name, $this->ans_col_sn);
                    $form = $TadUpFiles->upform('list', $file_name, $maxlength, true, implode(',', $options), true, '', true);
                    $form .= "<input type='hidden' name='uploads[{$name}]' value='{$file_name}'>
                    <input type='hidden' name=\"TDC[{$name}][0]\" value=\"{$value}\">";
                } elseif ('datetime' === $type) {
                    $cal = new My97DatePicker();
                    $cal::render();
                    $form = "<input type=\"text\" name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str} onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', startDate:'%y-%M-%d %H:%m:%s'})\">";
                } elseif ('' == $type) {
                    $form = "<input type=\"text\" name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str}>";
                } else {
                    $form = "<input type=\"{$type}\" name=\"TDC[{$name}]{$arr}\" value=\"{$value}\" {$attr_str}>";
                }
                break;

        }

        if ($xoopsTpl and 'assign' === $mode) {
            $xoopsTpl->assign($name, $form);
        } elseif (isset($form)) {
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

    //儲存資料 $data[]=['name'=>$name, 'value'=>$value, 'sort'=>$sort] 需修改
    public function saveData()
    {
        global $xoopsDB;
        $myts = \MyTextSanitizer::getInstance();

        $TDC = $_POST['TDC'];

        $dc_op = Request::getString('dc_op');
        $sort = 0;

        foreach ($TDC as $name => $value) {
            $name = $myts->addSlashes($name);
            $values = [];

            if (!is_array($value)) {
                $values[0] = $value;
            } else {
                $values = $value;
            }

            $this->delData($name, '', $this->col_name, $this->col_sn, __FILE__, __LINE__);
            foreach ($values as $data_sort => $val) {
                if ('saveCustomSetupForm' === $dc_op and empty($val)) {
                    continue;
                }
                $val = $myts->addSlashes($val);

                $col_id = $this->col_id ? $this->col_id : "{$this->mid}-{$this->col_name}-{$this->col_sn}-{$name}-{$data_sort}";

                $sql = 'REPLACE INTO `' . $this->TadDataCenterTblName . '`
                (`mid`, `col_name`, `col_sn`, `data_name`, `data_value`, `data_sort`, `col_id`, `sort`, `update_time`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())';

                Utility::query($sql, 'isissisi', [$this->mid, $this->col_name, $this->col_sn, $name, $val, $data_sort, $col_id, $sort]) or die($xoopsDB->error());
            }
            $sort++;
        }

        if ($_POST['uploads']) {
            foreach ($_POST['uploads'] as $name => $file_name) {
                $TadUpFiles = new TadUpFiles($this->module_dirname, '/' . $file_name);
                $TadUpFiles->set_col($this->col_name, $this->col_sn);
                if (!empty($_FILES[$file_name]['name'][0])) {
                    $TadUpFiles->upload_file($file_name, 1920, 640, '', '', true, false, 'files_sn');
                }

                $files = $TadUpFiles->get_file();
                $files_sn_arr = array_keys($files);

                $data_sort = 0;
                $col_id = $this->col_id ? $this->col_id : "{$this->mid}-{$this->col_name}-{$this->col_sn}-{$name}-{$data_sort}";

                $sql = 'REPLACE INTO `' . $this->TadDataCenterTblName . '`
                (`mid`, `col_name`, `col_sn`, `data_name`, `data_value`, `data_sort`, `col_id`, `sort`, `update_time`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())';

                Utility::query($sql, 'isissisis',
                    [$this->mid, $this->col_name, $this->col_sn, $name, "files=" . implode(',', $files_sn_arr), $data_sort, $col_id, $sort]) or Utility::web_error($sql, __FILE__, __LINE__, true);
                $sort++;
            }
        }
    }

    //儲存資料 $data_arr=[$name=>array($sort=>$value)]
    public function saveCustomData($data_arr = [], $mode = '')
    {
        global $xoopsDB;
        $myts = \MyTextSanitizer::getInstance();
        $sort = $old_data_sort = 0;
        foreach ($data_arr as $name => $value) {
            $name = $myts->addSlashes($name);

            // 若為接續模式，取出目前最大 data_sort
            if ($mode == 'append') {
                $sql = 'SELECT MAX(`data_sort`) FROM `' . $this->TadDataCenterTblName . '` WHERE `mid` = ? AND `col_name` = ? AND `col_sn` = ? AND `data_name` = ?';

                $result = Utility::query($sql, 'isis', [$this->mid, $this->col_name, $this->col_sn, $name]) or Utility::web_error($sql, __FILE__, __LINE__);

                list($old_data_sort) = $xoopsDB->fetchRow($result);
                $old_data_sort++;
            }
            $values = [];
            if (!is_array($value)) {
                $values[0] = $value;
            } else {
                $values = $value;
            }

            foreach ($values as $data_sort => $val) {
                if ($mode == 'append') {
                    $data_sort += $old_data_sort;
                }
                $v = json_decode($val, true);
                // $val = $myts->addSlashes($val);

                $this->delData($name, $data_sort, $this->col_name, $this->col_sn, __FILE__, __LINE__);

                $col_id = isset($v['col_id']) ? $v['col_id'] : '';
                if (!empty($this->col_id)) {
                    $col_id = $this->col_id;
                }

                if (\is_null($val)) {
                    $val = '';
                }

                $sql = 'REPLACE INTO `' . $this->TadDataCenterTblName . '`
                (`mid`, `col_name`, `col_sn`, `data_name`, `data_value`, `data_sort`, `col_id`, `sort`, `update_time`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())';
                Utility::query($sql, 'isissisi', [$this->mid, $this->col_name, $this->col_sn, $name, $val, $data_sort, $col_id, $sort]) or Utility::web_error($sql, __FILE__, __LINE__);

            }
            $sort++;
        }
    }

    //取得資料
    public function getData($name = '', $data_sort = null, $ans_col_name = '', $ans_col_sn = '', $data_value = '')
    {
        global $xoopsDB;
        $myts = \MyTextSanitizer::getInstance();
        $and_name = ('' != $name) ? "and `data_name`='{$name}'" : '';
        $and_sort = ('' != $data_sort) ? "and `data_sort`='{$data_sort}'" : '';
        $and_value = ('' != $data_value) ? "and `data_value`='{$data_value}'" : '';

        $def_col_name = !empty($ans_col_name) ? $ans_col_name : $this->col_name;
        $def_col_sn = !empty($ans_col_name) ? $ans_col_sn : $this->col_sn;

        $and_col_name = ('' != $def_col_name) ? "and `col_name`='{$def_col_name}'" : '';
        $and_col_sn = ('' != $def_col_sn) ? "and `col_sn`='{$def_col_sn}'" : '';

        $sql = "desc `{$this->TadDataCenterTblName}` `sort`";
        $result = $xoopsDB->queryF($sql);
        $orderby = $xoopsDB->getRowsNum($result) ? "order by `sort` , `data_sort`" : "order by `data_sort`";

        $sql = "select `col_sn`,`data_name`,`data_sort`, `data_value` from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' {$and_col_name} {$and_col_sn} {$and_name} {$and_value} {$and_sort} {$orderby}";

        $result = $xoopsDB->queryF($sql);
        if (isset($data_sort)) {
            list($col_sn, $data_name, $data_sort, $data_value) = $xoopsDB->fetchRow($result);
            return $data_value;
        }
        $values = [];
        while (list($col_sn, $data_name, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {

            if (empty($def_col_sn) and ('' != $name)) {
                $values[$col_sn][$data_sort] = $data_value;
            } elseif (strpos($data_value, 'files=') !== false) {
                $files_sn = str_replace('files=', '', $data_value);
                $TadUpFiles = new TadUpFiles($this->module_dirname, '/' . $data_name);
                $TadUpFiles->set_col($this->col_name, $this->col_sn);
                $values[$data_name][$data_sort] = $TadUpFiles->get_file($files_sn);
            } else {
                $values[$data_name][$data_sort] = $data_value;
            }

        }

        return $values;
    }

    //取得問卷題目資料
    public function getDcqData($sort = '')
    {
        global $xoopsDB;
        $myts = \MyTextSanitizer::getInstance();
        $and_sort = ('' != $sort) ? "and `data_sort`='{$sort}'" : '';

        $sql = "desc `{$this->TadDataCenterTblName}` `sort`";
        $result = $xoopsDB->queryF($sql);
        $orderby = $xoopsDB->getRowsNum($result) ? "order by `sort` , `data_sort`" : "order by `data_sort`";

        $sql = "select * from `{$this->TadDataCenterTblName}`
                where `mid`= '{$this->mid}' and `col_name`='{$this->col_name}' and `col_sn`='{$this->col_sn}' and `data_name`='dcq' {$and_sort} {$orderby}";

        $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        if ($sort) {
            $all = $xoopsDB->fetchArray($result);

            return $all;
        }
        $values = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            $data_sort = $all['data_sort'];
            $all['name'] = "{$all['col_name']}_{$all['col_sn']}_dcq_{$all['col_id']}";
            $all['data_json'] = json_decode($all['data_value'], true);
            $values[$data_sort] = $all;
        }

        return $values;
    }

    //取得問卷題目簡易資料
    public function getDcqSimpleData($key = 'name', $val = 'title')
    {
        $col_arr = [];
        $dcq = $this->getDcqData();
        foreach ($dcq as $col) {
            $json = json_decode($col['data_value'], true);
            $col_arr[$col[$key]] = $json[$val];
        }

        return $col_arr;
    }

    //刪除資料
    public function delData($name = '', $data_sort = '', $col_name = null, $col_sn = null, $file = '', $line = '', $trash_can_table = '')
    {
        global $xoopsDB;
        $and_name = ('' != $name) ? "and `data_name`='{$name}'" : '';
        $and_sort = ('' != $data_sort) ? "and `data_sort`='{$data_sort}'" : '';
        $col_name = !is_null($col_name) ? $col_name : $this->col_name;
        $col_sn = !is_null($col_sn) ? $col_sn : $this->col_sn;
        if (!empty($trash_can_table)) {
            $sql = "REPLACE INTO " . $xoopsDB->prefix($trash_can_table) . " SELECT *
            FROM `{$this->TadDataCenterTblName}` WHERE `mid`= '{$this->mid}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}' {$and_name} {$and_sort}";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, $file, $line);
        }
        $sql = "delete from `{$this->TadDataCenterTblName}`
            where `mid`= '{$this->mid}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}' {$and_name} {$and_sort}";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, $file, $line);
    }

    public function mk_form_group($left_width, $right_width, $label, $form, $input_group = false, $help = '', $require = '')
    {
        $help_text = $help ? '<div><small class="text-muted">' . $help . '</small></div>' : '';
        $ig_tag_start = $input_group ? '<div class="input-group">' : '';
        $ig_tag_body = $input_group ? '<span class="input-group-btn">' . $input_group . '</span>' : '';
        $ig_tag_end = $input_group ? '</div>' : '';
        $require_mark = 1 == $require ? '<span style="display:inline-block; margin-right:4px; color:red;">*</span>' : '';
        $padding_top = '';
        if (strpos($form, 'form-check-inline') !== false) {
            $padding_top = ' style="padding-top: 8px;"';
        }
        $main = '
        <div class="form-group row mb-3">
            <label class="col-sm-' . $left_width . ' control-label col-form-label text-md-right text-md-end">' . $require_mark . $label . '</label>
            <div class="col-sm-' . $right_width . '" ' . $padding_top . '>
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

    //$form_arr[]=array('0'=>4,'1'=>'xxx','2'='<input>');
    public function mk_form_group_arr($form_arr, $id_content = '', $theme = '')
    {
        $main = $theme == 'vtable' ? "<ul $id_content>" : "<tr $id_content>";
        foreach ($form_arr as $k => $form) {
            if ($theme == 'vtable') {
                $main .= '
                <li class="vcell">' . $form[1] . '</li>
                <li class="vm w' . $form[0] . '">' . $form[2] . '</li>
                ';
            } else {
                $main .= '
                <td class="' . $form[0] . '" ' . $form[3] . '>' . $form[2] . '</td>
                ';
            }
        }
        $main .= $theme == 'vtable' ? '</ul>' : '</tr>';

        return $main;
    }

    //從界面取得自訂表單
    public function getCustomSetupForm($action = "", $use_form = true, $id = "dcq_sort", $theme = 'vtable')
    {
        global $xoTheme;
        $action = empty($action) ? $_SERVER['PHP_SELF'] : $action;
        $DcqData = $this->getDcqData();
        $sort = 0;

        // Utility::dd(count($DcqData));
        $item_count = count($DcqData);
        if ($item_count > 0) {
            $form_count = "var {$id}_count={$item_count};";
        } else {
            $form_count = "var {$id}_count=0;
            {$id}_count = clone_{$id}({$id}_count);";
        }

        $document_ready = '
        $(document).ready(function(){
            $("#' . $id . '").sortable({ opacity: 0.6, cursor: "move", update: function() {
                var order = $(".' . $id . '_arr").serialize();
                // console.log(order);
                $.post("' . XOOPS_URL . '/modules/tadtools/ajax_file.php?dcq_op=save_dcq_sort&col_sn=' . $this->col_sn . '&col_name=' . $this->col_name . '&dirname=' . $this->module_dirname . '", order, function(theResponse){
                    $("#save_msg").html(theResponse);
                    location.reload();
                });
            }
            });

            ' . $form_count . '

            $("#add_' . $id . '").click(function(){
                ' . $id . '_count = clone_' . $id . '(' . $id . '_count);
            });

            $(".remove_' . $id . '").click(function(){
                console.log($(this).prop("id"));
                $(this).closest("#form_data_' . $id . '" + $(this).prop("id")).remove();
            });

        });

        function clone_' . $id . '(' . $id . '_count){
            //複製一份表單
            $("#' . $id . '").append($("#form_data_' . $id . '").clone().prop("id","form_data_' . $id . '" + ' . $id . '_count));

            $("#form_data_' . $id . '" + ' . $id . '_count + " input").each(function(){
                $(this).prop("name", $(this).prop("id") + "[" + ' . $id . '_count+"][" + $(this).data("col-name")+"]");
                $(this).prop("id",$(this).prop("id").replace("][","_").replace("[","_").replace("]","_") + ' . $id . '_count);
            });

            $("#form_data_' . $id . '" + ' . $id . '_count + " select").each(function(){
                $(this).prop("name",$(this).prop("id") + "[" + ' . $id . '_count+"][" + $(this).data("col-name")+"]");
                $(this).prop("id",$(this).prop("id").replace("][","_").replace("[","_").replace("]","_") + ' . $id . '_count);
            });

            $("#form_data_' . $id . '" + ' . $id . '_count + " a.remove_' . $id . '").each(function(){
                $(this).prop("id", ' . $id . '_count);
            });

            var new_num=' . $id . '_count+1;
            $("#form_data_' . $id . '" + ' . $id . '_count + " span.num").each(function(){
                $(this).prop("id", "' . $id . '-num-"+' . $id . '_count).text("#" + new_num);
            });


            $(".remove_' . $id . '").click(function(){
                console.log($(this).prop("id"));
                $(this).closest("#form_data_' . $id . '" + $(this).prop("id")).remove();
            });

            // $("#remove_' . $id . '" + ' . $id . '_count).click(function(){
            //     $(this).closest("#form_data_' . $id . '" + $(this).prop("name")).remove();
            // });
            ' . $id . '_count++;
            return ' . $id . '_count;
        }
        ';

        if ($theme == 'vtable') {
            if ($xoTheme) {
                $main = '';
                $xoTheme->addStylesheet('modules/tadtools/css/my-input.css');
                $xoTheme->addStylesheet('modules/tadtools/css/vtable.css');
                $xoTheme->addScript('', null, $document_ready);
            } else {
                $main = '
                <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/my-input.css">
                <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/vtable.css">
                <script type="text/javascript">
                ' . $document_ready . '
                </script>';
            }
        } else {
            if ($xoTheme) {
                $main = '';
                $xoTheme->addScript('', null, $document_ready);
            } else {
                $main = '
                <script type="text/javascript">
                ' . $document_ready . '
                </script>';
            }
        }

        $main .= $use_form ? '<form action="' . $action . '" method="post" class="form-horizontal" id="' . $id . '">' : '';
        $id_col = $use_form ? '' : 'id="' . $id . '"';

        if ($theme == 'vtable') {
            $main .= '
            <div id="save_msg"></div>
            <div class="vtable" ' . $id_col . '>
            <ul class="vhead">
                <li class="w1">題號</li>
                <li class="w1">欄位名稱</li>
                <li class="w2">提示或說明</li>
                <li class="w1">欄位類型</li>
                <li class="w2">選項（用 ; 隔開）</li>
                <li class="w1">必填</li>
                <li class="w1"><span data-toggle="tooltip" data-placement="top" data-bs-toggle="tooltip" data-bs-placement="top" title="給程式讀取用，無須修改，若要修改，影確保其為唯一值">隨機唯一碼</span></li>
            </ul>';
        } else {
            $main .= '
            <div id="save_msg"></div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm" >
                <tr class="bg-light">
                    <td class="c nw">題號</td>
                    <td class="c nw">欄位名稱</td>
                    <td class="c nw">提示或說明</td>
                    <td class="c nw">欄位類型</td>
                    <td class="c nw">選項（用 ; 隔開）</td>
                    <td class="c nw">必填</td>
                    <td class="c nw"><span data-toggle="tooltip" data-placement="top" data-bs-toggle="tooltip" data-bs-placement="top" title="給程式讀取用，無須修改，若要修改，影確保其為唯一值">隨機唯一碼</span></td>
                </tr>
                <tbody ' . $id_col . '>
                ';
        }

        foreach ($DcqData as $sort => $data) {
            $main .= $this->getCustomSetupCol($sort, $data['data_value'], $data['col_id'], $id, $theme);
            $sort++;
        }

        // 樣板
        $main .= $theme == 'vtable' ? "\n<span style='display:none;'>\n" : "\n</tbody>\n<tbody style='display:none;'>\n";
        $main .= $this->getCustomSetupCol($sort, 'template', '', $id, $theme);
        $sort++;
        $main .= $theme == 'vtable' ? "\n</span>\n" : "\n</tbody>\n";

        $main .= "\n</table>\n</div>\n";
        $main .= '<input type="hidden" name="dc_op" value="saveCustomSetupForm">';
        $main .= '<input type="hidden" name="' . $this->col_name . '" value="' . $this->col_sn . '">';
        $main .= $use_form ? '<div class="text-center" style="margin:10px auto;"><button type="submit" class="btn btn-primary">儲存</button></div>' : '';
        $main .= $use_form ? '</form>' : '';
        $main .= '<div class="text-right text-end">
            <a href="#' . $id . '" id="add_' . $id . '" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> 新增一列</a>
        </div>';

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('del_' . $this->col_name . '_dcq_col', XOOPS_URL . "/modules/tadtools/ajax_file.php?dcq_op=del_dcq_col&col_name={$this->col_name}&col_sn={$this->col_sn}&dirname={$this->module_dirname}&col_id=", 'col_id');

        return $main;
    }

    //取得設定界面的單一欄位
    private function getCustomSetupCol($sort, $json = '', $col_id = '', $id = '', $theme = '')
    {
        $val = $json != 'template' ? json_decode($json, true) : [];
        $id_content = $json != 'template' ? '' : 'id="form_data_' . $id . '"';

        $myts = \MyTextSanitizer::getInstance();

        $col_type_arr['input=text'] = _TDC_INPUT;
        $col_type_arr['input=radio'] = _TDC_RADIO;
        $col_type_arr['input=checkbox'] = _TDC_CHECKBOX;
        $col_type_arr['input=date'] = _TDC_DATE;
        $col_type_arr['input=file'] = _TDC_FILE;
        $col_type_arr['select'] = _TDC_SELECT;
        $col_type_arr['textarea'] = _TDC_TEXTAREA;
        $col_type_arr['ckeditor'] = _TDC_CKEDITOR;
        $col_type_arr['note'] = _TDC_NOTE;
        $col_type_arr['user_name'] = _TDC_USER_NAME;
        $col_type_arr['user_email'] = _TDC_USER_EMAIL;
        $col_type_arr['SchoolCode'] = _TDC_SCHOOL_CODE;
        $option = '';
        foreach ($col_type_arr as $type => $text) {
            $selected = $val['type'] == $type ? 'selected' : '';
            $option .= '<option value="' . $type . '" ' . $selected . '>' . $text . '</option>';
        }

        if ($json != 'template') {
            $del = ($col_id) ? "<a href=\"javascript:del_{$this->col_name}_dcq_col('{$col_id}')\" style='color:red;'><i class='fa fa-trash-o' title='" . _TAD_DEL . "'></i></a>
            <input type='hidden' class='{$id}_arr' name='col_ids[]' value='{$col_id}'> " : '';
        } else {
            $del = '<a href="#' . $id . '" id="remove_' . $id . '" style="color:red;" class="remove_' . $id . '"><i class="fa fa-trash-o" title="' . _TAD_DEL . '"></i></a> ';
        }

        $i = $sort + 1;
        $class = $theme == 'vtable' ? '1' : 'px-2 nw';
        $form_arr[] = [$class, '', $del . "<span id='{$id}-num-{$i}' class='num'>#{$i}</span>"];

        $col_name_sn = 'dcq[' . $this->col_name . '][' . $this->col_sn . ']';
        $name_id = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][title]"' : 'id="' . $col_name_sn . '" data-col-name="title"';
        $class = $theme == 'vtable' ? '2' : 'c';
        $form_arr[] = [$class, '#' . $i, '<input type="text" ' . $name_id . ' class="my-input my-100" placeholder="' . _TDC_INPUT_TITLE . '" value="' . $myts->htmlSpecialChars($val['title']) . '">'];

        $name_id = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][placeholder]"' : 'id="' . $col_name_sn . '" data-col-name="placeholder"';
        $class = $theme == 'vtable' ? '1' : 'c';
        $form_arr[] = [$class, _TDC_DESCRIPTION, '<input type="text" ' . $name_id . ' class="my-input my-100" placeholder="' . _TDC_INPUT_DESCRIPTION . '" value="' . $myts->htmlSpecialChars($val['placeholder']) . '">'];

        $name_id = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][type]"' : 'id="' . $col_name_sn . '" data-col-name="type"';
        $class = $theme == 'vtable' ? '1' : 'c';
        $form_arr[] = [$class, _TDC_TYPE, '<select ' . $name_id . ' class="my-input my-100">' . $option . '</select>'];

        $name_id = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][opt]"' : 'id="' . $col_name_sn . '" data-col-name="opt"';
        $class = $theme == 'vtable' ? '2' : 'c';
        $form_arr[] = [$class, _TDC_OPTIONS, '<input type="text" ' . $name_id . ' class="my-input my-100" placeholder="' . _TDC_OPTIONS_NOTE . '" value="' . $myts->htmlSpecialChars($val['opt']) . '">'];

        $name_id = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][require]"' : 'id="' . $col_name_sn . '" data-col-name="require"';
        $checked = 1 == $val['require'] ? 'checked' : '';
        $class = $theme == 'vtable' ? '1' : 'px-2 nw';
        $form_arr[] = [$class, _TDC_REQUIRE . $i, '<label class="checkbox-inline"><input type="checkbox" ' . $name_id . ' value="1" ' . $checked . '>' . _TDC_REQUIRE . '</label>'];

        $name_id1 = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][old_col_id]"' : 'id="' . $col_name_sn . '" data-col-name="old_col_id"';
        $name_id2 = $json != 'template' ? 'name="' . $col_name_sn . '[' . $sort . '][col_id]"' : 'id="' . $col_name_sn . '" data-col-name="col_id"';
        $class = $theme == 'vtable' ? '1' : 'c';
        $form_arr[] = [$class, _TDC_COL_ID, '<input type="hidden" ' . $name_id1 . ' value="' . $col_id . '"><input type="text" ' . $name_id2 . ' class="my-input my-100" placeholder="' . _TDC_INPUT_COL_ID . '" value="' . $col_id . '" title="' . _TDC_INPUT_COL_ID . '">'];

        $main = $this->mk_form_group_arr($form_arr, $id_content, $theme);

        return $main;
    }

    //儲存自訂表單設定
    public function saveCustomSetupForm($redirict = true, $new_col_sn = '')
    {
        $dc_op = Request::getString('dc_op');
        if ('saveCustomSetupForm' === $dc_op) {
            $this->saveDcqData($new_col_sn);
            if ($redirict) {
                header("location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
        }
    }

    //儲存自訂問卷資料資料
    private function saveDcqData($new_col_sn = '')
    {
        global $xoopsDB;
        $myts = \MyTextSanitizer::getInstance();

        $dcq = Request::getArray('dcq');
        $dc_op = Request::getString('dc_op');

        foreach ($dcq as $col_name => $dcq_items) {
            foreach ($dcq_items as $col_sn => $dcq_item) {
                if (!empty($new_col_sn)) {
                    $col_sn = $new_col_sn;
                }
                foreach ($dcq_item as $data_sort => $item) {
                    if ('saveCustomSetupForm' === $dc_op and empty($item['title'])) {
                        continue;
                    }

                    $json_val = json_encode($item, JSON_UNESCAPED_UNICODE);
                    $json_val = $myts->addSlashes($json_val);

                    $this->delData('dcq', $data_sort, $col_name, $col_sn, __FILE__, __LINE__);
                    if (!empty($item['col_id'])) {
                        $col_id = $item['col_id'];
                    } else {
                        if ($item['type'] == "SchoolCode") {
                            $col_id = 'schoolcode';
                        } elseif ($item['type'] == "user_name") {
                            $col_id = 'username';
                        } elseif ($item['type'] == "user_email") {
                            $col_id = 'useremail';
                        } else {
                            $col_id = $this->rand_str();
                        }
                    }
                    $sql = "replace into `{$this->TadDataCenterTblName}`
                            (`mid` , `col_name` , `col_sn` , `data_name` , `data_value` , `data_sort`, `col_id` , `sort`, `update_time`)
                            values('{$this->mid}' , '{$col_name}' , '{$col_sn}' , 'dcq' , '{$json_val}' , '{$data_sort}' , '{$col_id}' , '{$sort}' , now())";
                    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    if ($item['col_id'] != $item['old_col_id']) {
                        $this->update_col_id($item['old_col_id'], $item['col_id']);
                    }
                }
            }
        }
    }

    //更新辨識碼
    private function update_col_id($old_col_id, $new_col_id)
    {
        global $xoopsDB;
        $sql = 'UPDATE `' . $this->TadDataCenterTblName . '` SET `data_name`=? WHERE `data_name`=?';
        $params = [$this->col_name . '_' . $this->col_sn . '_dcq_' . $new_col_id, $this->col_name . '_' . $this->col_sn . '_dcq_' . $old_col_id];
        Utility::query($sql, 'ss', $params) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    //取得自訂表單題目設定
    public function getCustomSetup()
    {
        $DcqData = $this->getDcqData();
        $dcq_arr = [];
        foreach ($DcqData as $sort => $data) {
            $dcq = json_decode($data['data_value'], true);

            list($dcq['form_tag'], $dcq['type']) = explode('=', $dcq['type']);

            $dcq['name'] = "{$this->col_name}_{$this->col_sn}_dcq_{$data['col_id']}";

            $options = explode(';', $dcq['opt']);
            $option_arr = [];
            foreach ($options as $opt) {
                if (false !== mb_strpos($opt, '=')) {
                    list($key, $val) = explode('=', $opt);
                } else {
                    $key = $val = $opt;
                }
                $option_arr[$key] = $val;
            }
            $dcq['option_arr'] = $option_arr;
            $dcq_arr[$sort] = $dcq;
        }

        return $dcq_arr;
    }

    //取得自訂表單
    public function getCustomForm($use_form = true, $use_submit = false, $action = '', $lw = 3, $rw = 9, $muti_sort = null)
    {
        global $xoTheme;
        $action = empty($action) ? $_SERVER['PHP_SELF'] : $action;
        $DcqData = $this->getDcqData();

        $form_col = '';

        foreach ($DcqData as $data) {
            // 該欄位的細項設定
            $dcq = json_decode($data['data_value'], true);

            list($form_tag, $type) = explode('=', $dcq['type']);

            $name = "{$this->col_name}_{$this->col_sn}_dcq_{$data['col_id']}";
            $options = explode(';', $dcq['opt']);
            $option_arr = [];
            foreach ($options as $opt) {
                if (false !== mb_strpos($opt, '=')) {
                    list($key, $val) = explode('=', $opt);
                } else {
                    $key = $val = $opt;
                }
                $option_arr[$key] = $val;
            }

            $require = 1 == $dcq['require'] ? ' validate[required]' : '';
            if (in_array($type, ['radio', 'checkbox', 'checkbox-radio'])) {
                $attr_arr = ['class' => $require];
            } elseif (in_array($form_tag, ['user_name', 'user_email', 'SchoolCode'])) {
                $attr_arr = ['class' => $require];
            } elseif (in_array($type, ['file'])) {
                $attr_arr = ['require' => $dcq['require']];
            } else {
                $attr_arr = ['class' => "my-input my-100 $require"];
            }

            $muti_sort = $muti_sort ? $muti_sort : null;
            $col = $this->getForm('return', $form_tag, $name, $type, null, $option_arr, $attr_arr, $muti_sort, $this->ans_col_name, $this->ans_col_sn);
            $form_col .= $this->mk_form_group($lw, $rw, $dcq['title'], $col, false, $dcq['placeholder'], $dcq['require']);
        }

        if ($form_col) {
            if ($xoTheme) {
                $form = '';
                $xoTheme->addStylesheet('modules/tadtools/css/my-input.css');
            } else {
                $form = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/my-input.css">';
            }

            if ($use_form) {
                $FormValidator = new FormValidator('#myForm', false);
                $FormValidator->render('topLeft');
                $form .= '<form action="' . $action . '" id="myForm" method="post" class="form-horizontal"  enctype="multipart/form-data">';
            }
            $form .= $form_col;
            $form .= '
            <input type="hidden" name="' . $this->ans_col_name . '" value="' . $this->ans_col_sn . '">
            <input type="hidden" name="dirname" value="' . $this->module_dirname . '">
            <input type="hidden" name="col_name" value="' . $this->ans_col_name . '">
            <input type="hidden" name="col_sn" value="' . $this->ans_col_sn . '">';
            $form .= $use_submit ? $this->mk_form_group($lw, $rw, '', '<button type="submit" class="btn btn-primary">' . _TAD_SAVE . '</button>') : '';
            $form .= '<input type="hidden" name="dcq_op" value="saveCustomSetupFormVal">';
            $form .= $use_form ? '</form>' : '';

            return $form;
        }
    }

    //已填答案列表： $del_col_name= 'uid'(顯示刪除，並以 uid 為參數) ，$display_mode=vertical
    public function getCustomAns($call_back_func = '', $del_col_name = false, $display_mode = '')
    {
        global $xoTheme;
        $DcqData = $this->getDcqData();
        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/css/vtable.css');
            $main = '';
        } else {
            $main = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/vtable.css">';
        }

        $col_type = [];
        if ('vertical' === $display_mode) {
            $main .= "<div class='vtable'>";

            foreach ($DcqData as $sort => $data) {
                $dcq = json_decode($data['data_value'], true);
                list($form_tag, $type) = explode('=', $dcq['type']);
                if ('note' === $form_tag) {
                    continue;
                }

                $dcq_title = $dcq['title'];
                $data_name = "{$this->col_name}_{$this->col_sn}_dcq_{$data['col_id']}";
                $ans = $this->getDcqDataArr($data_name);
                $col_type[$data_name] = $dcq['type'];
                $answer = [];
                foreach ($ans as $a) {
                    $answer[] = nl2br(implode('、', $a[$data_name]));
                }
                $dcq_answer = implode(';', $answer);
                $main .= "<ul>
                <li class='w2 vtitle'>$dcq_title</li>
                <li class='w8'>$dcq_answer</li>
                </ul>";
            }

            if ($del_col_name) {
                $main .= "<ul>
                <li class='w2 vtitle'>" . _TAD_FUNCTION . "</li>
                <li class='w8'><li style='text-align: center;'><a href='javascript:del_dcq_ans({$this->col_sn})' style='color:red;'><li class='fa fa-trash-o' title='" . _TAD_DEL . "'></li></li>
                </ul>";
            }
            $main .= '</div>';
        } else {
            $main .= "
            <div class='vtable'>
            <ul class='vhead'>
            <li>" . _TDC_FILL_PEOPLE . '</li>
            ';

            foreach ($DcqData as $sort => $data) {
                $dcq = json_decode($data['data_value'], true);
                list($form_tag, $type) = explode('=', $dcq['type']);
                if ('note' === $form_tag) {
                    continue;
                }
                $dcq_title = $dcq['title'];
                $name[$dcq_title] = $data_name = "{$this->col_name}_{$this->col_sn}_dcq_{$data['col_id']}";
                $col_type[$data_name] = $dcq['type'];
                $main .= "<li style='text-align: center;'>{$dcq_title}</li>";
            }

            if ($del_col_name) {
                $main .= '<li>' . _TAD_FUNCTION . '</li>';
            }
            $main .= '</ul>';

            $data_name_arr = [];
            $ans = $this->getDcqDataArr($name);
            foreach ($ans as $col_sn => $ans_arr) {
                $title = ($call_back_func) ? call_user_func($call_back_func, $col_sn, $this->col_name, $this->col_sn) : $col_sn;
                $main .= "<ul>
                <li class='vcell'>" . _TDC_FILL_PEOPLE . "</li>
                <li style='text-align: center;'>{$title}</li>";

                foreach ($name as $dcq_title => $data_name) {
                    $css = $col_type[$data_name] == 'textarea' ? '' : "class='text-center'";
                    $main .= "<li class='vcell'>{$dcq_title}</li>
                    <li $css>";
                    if ($col_type[$data_name] == 'input=file') {
                        $TadUpFiles = new TadUpFiles($this->module_dirname, '/' . $data_name);
                        $TadUpFiles->set_col($this->ans_col_name, $col_sn);
                        $main .= $TadUpFiles->show_files('', true, 'filename', false, false, null, null, false);
                    } else {
                        $main .= nl2br(implode('、', $ans_arr[$data_name]));
                    }
                    $main .= '</li>';

                    $data_name_arr[$data_name] = $data_name;
                }

                if ($del_col_name) {
                    $main .= "<li style='text-align: center;'><a href='javascript:del_dcq_ans({$col_sn})' style='color:red;'><i class='fa fa-trash-o' title='" . _TAD_DEL . "'></i>
                    </a></li>";
                }
                $main .= '</ul>';
            }
            $main .= '</div>';
        }

        if ($del_col_name) {
            $data_name = implode('|', $data_name_arr);
            $SweetAlert = new SweetAlert();
            $SweetAlert->render('del_dcq_ans', XOOPS_URL . "/modules/tadtools/ajax_file.php?dcq_op=del_dcq_ans&data_name={$data_name}&dirname={$this->module_dirname}&col_name={$del_col_name}&col_sn=", 'col_ans_sn');
        }

        return $main;
    }

    //已填答案陣列
    public function getCustomAnsArr()
    {
        $DcqData = $this->getDcqData();
        foreach ($DcqData as $sort => $data) {
            $dcq = json_decode($data['data_value'], true);
            list($form_tag, $type) = explode('=', $dcq['type']);
            if ('note' === $form_tag) {
                continue;
            }
            $name[] = "{$this->col_name}_{$this->col_sn}_dcq_{$data['col_id']}";
        }
        $ans = $this->getDcqDataArr($name);

        return $ans;
    }

    //取得填答資料陣列
    public function getDcqDataArr($data_name = '')
    {
        global $xoopsDB;
        $and_col_name = $this->ans_col_name ? "AND `col_name`=?" : '';
        $and_col_sn = $this->ans_col_sn ? "AND `col_sn`=?" : '';
        $values = [];
        $params = [];

        if (is_array($data_name)) {
            foreach ($data_name as $name) {
                $params[] = $this->mid;
                $params[] = $name;
                if ($this->ans_col_name) {
                    $params[] = $this->ans_col_name;
                }

                if ($this->ans_col_sn) {
                    $params[] = $this->ans_col_sn;
                }

                $sql = 'SELECT `col_sn`, `data_sort`, `data_value` FROM `' . $this->TadDataCenterTblName . '`
                    WHERE `mid`= ? AND `data_name`=? ' . $and_col_name . ' ' . $and_col_sn . ' ORDER BY `col_sn`';
                $result = Utility::query($sql, str_repeat('s', count($params)), $params) or Utility::web_error($sql, __FILE__, __LINE__);

                while (list($col_sn, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
                    $values[$col_sn][$name][$data_sort] = $data_value;
                }
                $params = []; // Reset params for the next iteration
            }
        } else {
            $params[] = $this->mid;
            $params[] = $data_name;
            if ($this->ans_col_name) {
                $params[] = $this->ans_col_name;
            }

            if ($this->ans_col_sn) {
                $params[] = $this->ans_col_sn;
            }

            $sql = 'SELECT `col_sn`, `data_sort`, `data_value` FROM `' . $this->TadDataCenterTblName . '`
                WHERE `mid`= ? AND `data_name`=? ' . $and_col_name . ' ' . $and_col_sn . ' ORDER BY `col_sn`';
            $result = Utility::query($sql, str_repeat('s', count($params)), $params) or Utility::web_error($sql, __FILE__, __LINE__);

            while (list($col_sn, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
                $values[$col_sn][$data_name][$data_sort] = $data_value;
            }
        }

        return $values;
    }

    // public function getDcqDataArr($data_name = '')
    // {
    //     global $xoopsDB;
    //     $and_col_name = $this->ans_col_name ? "and `col_name`='{$this->ans_col_name}'" : '';
    //     $and_col_sn = $this->ans_col_sn ? "and `col_sn`='{$this->ans_col_sn}'" : '';
    //     $values = [];
    //     if (is_array($data_name)) {
    //         foreach ($data_name as $name) {
    //             $sql = "select col_sn, data_sort ,data_value from `{$this->TadDataCenterTblName}`
    //                 where `mid`= '{$this->mid}' and `data_name`='{$name}' $and_col_name $and_col_sn order by col_sn";
    //             $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //             while (list($col_sn, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
    //                 $values[$col_sn][$name][$data_sort] = $data_value;
    //             }
    //         }
    //     } else {
    //         $sql = "select col_sn, data_sort ,data_value from `{$this->TadDataCenterTblName}`
    //         where `mid`= '{$this->mid}' and `data_name`='{$data_name}' $and_col_name $and_col_sn order by col_sn";
    //         $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //         while (list($col_sn, $data_sort, $data_value) = $xoopsDB->fetchRow($result)) {
    //             $values[$col_sn][$data_name][$data_sort] = $data_value;
    //         }
    //     }

    //     return $values;
    // }

    // 文字轉表單
    public function strToForm($setup = '')
    {
        global $xoTheme;
        if ($xoTheme) {
            $main = '';
            $xoTheme->addStylesheet('modules/tadtools/css/my-input.css');
        } else {
            $main = '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/my-input.css">';
        }

        $cols = $this->getAllCols($setup);
        $sort = 0;
        foreach ($cols as $col) {
            $sort++;
            $form = $this->getForm('return', $col['form_tag'], $col['label'], $col['type'], $col['value'], $col['options'], $col['attrs']) . $col['other'];
            $main .= $this->mk_form_group(2, 10, $col['label'], $form, false, $col['help'], $col['require']);
        }
        return $main;
    }

    // 取得所有的欄位設定
    public function getAllCols($setup)
    {
        $setups = \explode("\n", $setup);
        $cols = [];
        foreach ($setups as $setup) {
            $cols[] = $this->getColSetup($setup);
        }
        return $cols;
    }

    // 取得所有欄位的某個項目值
    public function getAllColItems($setup, $item = 'label')
    {
        $setups = \explode("\n", $setup);
        $items = [];
        foreach ($setups as $setup) {
            $col = $this->getColSetup($setup);
            $label = $col['label'];
            // $items[$label] = $col[$item];
            $items[] = $col[$item];
        }
        return $items;
    }

    // 取得欄位設定
    public function getColSetup($setup)
    {
        $setup = \trim($setup);
        $cols = \explode(",", $setup);
        if (!isset($cols[1])) {
            $cols[1] = '';
        }
        $options = $attrs = [];
        unset($value);
        $type = $help = $other = $form_tag = $value = $col_kind = $require = '';

        foreach ($cols as $i => $col) {
            if (\strpos($col, '#') !== false) {
                $help = \str_replace('#', '', $col);
            } elseif ($i == 0) {
                $label = $col;
                if (\strpos($label, '*') !== false) {
                    $require = 1;
                    $attrs['class'][] = 'validate[required]';
                    $label = \str_replace('*', '', $label);
                }
            } elseif ($i == 1) {
                if (strpos($cols[1], '=') === false) {
                    $col_kind = $cols[1];
                    if (!empty($col_kind) && isset($this->col_kind[$col_kind])) {
                        $form_tag = $this->col_kind[$col_kind]['form_tag'];
                        $type = $this->col_kind[$col_kind]['type'];
                    } else {
                        $form_tag = 'input';
                        $type = 'text';
                    }
                } else {
                    list($k, $v) = explode('=', $cols[1]);
                    $attrs[$k] = $v;
                    $form_tag = 'input';
                    $col_kind = $type = 'text';
                }
            } else {
                if (\strpos($col, '+') !== false) {
                    $col = \str_replace('+', '', $col);

                    if ($type == 'checkbox') {
                        $value[] = $col;
                    } else {
                        $value = $col;
                    }
                } elseif ($cols[1] == 'const') {
                    $other = $value = $col;
                } elseif ($cols[1] == 'hidden') {
                    $value = $col;
                }

                if (\in_array($type, ['select', 'radio', 'checkbox'])) {
                    $options[$col] = $col;
                } elseif (strpos($col, '=') !== false) {
                    list($k, $v) = explode('=', $col);
                    $attrs[$k] = $v;
                }
            }
        }

        $col_setup['form_tag'] = $form_tag;
        $col_setup['label'] = $label;
        $col_setup['type'] = $type;
        $col_setup['value'] = $value;
        $col_setup['options'] = $options;
        $col_setup['attrs'] = $attrs;
        $col_setup['other'] = $other;
        $col_setup['help'] = $help;
        $col_setup['require'] = $require;
        $col_setup['kind'] = $col_kind;

        return $col_setup;
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
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand(intval($seed));
        $password = '';
        while (mb_strlen($password) < $len) {
            $password .= mb_substr($chars, (mt_rand() % mb_strlen($chars)), 1);
        }

        return $password;
    }
}
