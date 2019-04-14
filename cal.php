<?php
require_once __DIR__ . '/tadtools_header.php';

class My97DatePicker
{
    //建構函數
    public function __construct()
    {
    }

    //產生月曆
    public function render()
    {
        global $xoTheme;

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/My97DatePicker/WdatePicker.js');
        } else {
            $cal = "<script type='text/javascript' src='" . TADTOOLS_URL . "/My97DatePicker/WdatePicker.js'></script>";

            return $cal;
        }
    }
}

/*
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/cal.php")){
redirect_header("http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1",3, _TAD_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH."/modules/tadtools/cal.php";
$cal=new My97DatePicker();
$cal->render();
 */
