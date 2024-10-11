<?php
namespace XoopsModules\Tadtools;

class My97DatePicker
{
    //建構函數
    public function __construct()
    {
    }

    //產生月曆
    public static function render()
    {
        global $xoTheme;

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/My97DatePicker/WdatePicker.js');
        } else {
            $cal = "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/My97DatePicker/WdatePicker.js'></script>";

            return $cal;
        }
    }
}

/*
use XoopsModules\Tadtools\My97DatePicker;
$My97DatePicker=new My97DatePicker();
$My97DatePicker->render();
or
My97DatePicker::render();
or

$xoTheme->addScript('modules/tadtools/My97DatePicker/WdatePicker.js');

onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})"
 */
