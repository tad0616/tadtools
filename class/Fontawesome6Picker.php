<?php

namespace XoopsModules\Tadtools;

class Fontawesome6Picker
{
    //建構函數
    public function __construct()
    {}

    //產生月曆
    public static function render($selecteor = "", $path = XOOPS_URL . "/modules/tadtools/fontawesome6-picker/")
    {
        global $xoTheme;

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/fontawesome6-picker/fontawesome6-picker.js');
            if ($selecteor) {
                $xoTheme->addScript('', null, "
                \$(document).ready(function() {
                    \$('$selecteor').iconPicker('$path', {
                        showIconName: false  // 不顯示圖示名稱
                    });
                });
                ");
            }
        } else {
            $cal = "<script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/fontawesome6-picker/fontawesome6-picker.js'></script>";
            if ($selecteor) {
                $cal .= "<script type=\"text/javascript\">
                    $(document).ready(function() {
                        \$('$selecteor').iconPicker('$path', {
                            showIconName: false  // 不顯示圖示名稱
                        });
                    });
                </script>";
            }

            return $cal;
        }
    }
}

/*
use XoopsModules\Tadtools\Fontawesome6Picker;
Fontawesome6Picker::render();

$Fontawesome6Picker=new Fontawesome6Picker();
$Fontawesome6Picker->render();
or
Fontawesome6Picker::render();
or

$xoTheme->addScript('modules/tadtools/Fontawesome6Picker/WdatePicker.js');

onClick="WdatePicker({dateFmt:'yyyy-MM-dd', startDate:'%y-%M-%d'})"
 */
