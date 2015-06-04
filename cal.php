<?php
include_once "tadtools_header.php";

class My97DatePicker
{

    //建構函數
    public function My97DatePicker()
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
redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/cal.php";
$cal=new My97DatePicker();
 */
