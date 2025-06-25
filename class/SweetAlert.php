<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class SweetAlert
{
    public $show_jquery;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法 $type=error,warning,info,success
    public function render($func_name = '', $url = '', $var = '', $title = '', $text = '', $confirmButtonText = '', $type = 'warning', $showCancelButton = 'true', $html = '')
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';
        if (is_array($var)) {
            $parm_var = [];
            $href     = [];
            foreach ($var as $key => $value) {
                if (is_string($key)) {
                    $href[] = "{$key}={$value}";
                } else {
                    $href[]     = "{$value}=' + $value + '";
                    $parm_var[] = $value;
                }
            }
            $href     = "'{$url}" . implode('&', $href) . "'";
            $parm_var = implode(', ', $parm_var);
        } else {
            $href     = empty($var) ? "'$url'" : "'$url' + $var";
            $parm_var = $var;
        }

        xoops_loadLanguage('main', 'tadtools');
        if (empty($title)) {
            $title = _TAD_DEL_CONFIRM_TITLE;
        }
        if (empty($text)) {
            $text = _TAD_DEL_CONFIRM_TEXT;
        }
        if (empty($confirmButtonText)) {
            $confirmButtonText = _TAD_DEL_CONFIRM_BTN;
        }

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/sweet-alert/sweet-alert.css');
            $xoTheme->addScript('modules/tadtools/sweet-alert/sweet-alert.js');

            $xoTheme->addScript('', null, "
            function {$func_name}($parm_var){
                swal({
                    title: '$title',
                    text: '$text',
                    type: '$type',
                    html: '$html',
                    showCancelButton: $showCancelButton,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '$confirmButtonText',
                    closeOnConfirm: false ,
                    allowOutsideClick: true
                },
                function(){
                    location.href=$href;
                });
            }
            ");
        } else {
            $main = "
            {$jquery}
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/sweet-alert/sweet-alert.css' />
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/sweet-alert/sweet-alert.js'></script>
            <script type='text/javascript'>
                function {$func_name}($var){
                    swal({
                        title: '$title',
                        text: '$text',
                        type: '$type',
                        html: '$html',
                        showCancelButton: $showCancelButton,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: '$confirmButtonText',
                        closeOnConfirm: false ,
                        allowOutsideClick: true
                    },
                    function(){
                        location.href=$href;
                        //swal('Deleted!', 'Your imaginary file has been deleted.', 'success');
                    });
                }
            </script>

            ";

            return $main;
        }
    }
}
/*

function del_table(mssn){
var sure = window.confirm('"._TAD_DEL_CONFIRM."');
if (!sure)  return;
location.href="ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=" + mssn;
}

轉換為

use XoopsModules\Tadtools\SweetAlert;

$SweetAlert=new SweetAlert();
$SweetAlert->render("del_table","ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=",'mssn');

$SweetAlert=new SweetAlert();
$SweetAlert->render("函數名稱","刪除連結",'參數');
 */
