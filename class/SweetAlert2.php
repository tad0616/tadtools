<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class SweetAlert2
{
    private $show_jquery;
    private $showConfirmButton = 'true';
    private $timer = 0;
    private $html = '';
    private $showCancelButton = 'true';
    private $confirmButtonColor = '#DD6B55';
    private $cancelButtonColor = '#8c8c8c';
    private $closeOnConfirm = 'false';
    private $allowOutsideClick = 'true';
    private $complete = _TAD_DEL_CONFIRM_COMPLETE;
    private $complete_txt = _TAD_DEL_CONFIRM_COMPLETE_TXT;
    private $confirmButtonText = _TAD_DEL_CONFIRM_BTN;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //設定變數
    public function setVar($var = '', $val = '')
    {
        $this->$var = $val;
    }

    //產生語法
    public function render($func_name = '', $url = '', $var = null, $title = _TAD_DEL_CONFIRM_TITLE, $text = _TAD_DEL_CONFIRM_TEXT)
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? Utility::get_jquery() : '';
        if (is_array($var)) {
            $parm_var = [];
            $href = [];
            foreach ($var as $key => $value) {
                if (is_string($key)) {
                    $href[] = "{$key}={$value}";
                } else {
                    $href[] = "{$value}=' + $value + '";
                    $parm_var[] = $value;
                }
            }
            $href = "'{$url}" . implode('&', $href) . "'";
            $parm_var = implode(', ', $parm_var);
        } else {
            $href = empty($var) ? "'$url'" : "'$url' + $var";
            $parm_var = $var;
        }

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/sweet-alert/sweetalert2.min.css');
            $xoTheme->addScript('modules/tadtools/sweet-alert/sweetalert2.all.min.js');

            $xoTheme->addScript('', null, "
            function {$func_name}($parm_var){
                swal.fire({
                    title: '$title',
                    text: '$text',
                    html: '{$this->html}',
                    timer: $this->timer,
                    showConfirmButton: $this->showConfirmButton,
                    showCancelButton: $this->showCancelButton,
                    confirmButtonColor: '{$this->confirmButtonColor}',
                    confirmButtonText: '{$this->confirmButtonText}',
                    cancelButtonColor: '{$this->cancelButtonColor}',
                    closeOnConfirm: $this->closeOnConfirm,
                    allowOutsideClick: $this->allowOutsideClick
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: '{$this->complete}',
                            text: '{$this->complete_txt}',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href=$href;
                            }
                        });
                    }
                });
            }
            ");
        } else {
            $main = "
            {$jquery}
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/sweet-alert/sweetalert2.min.css' />
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/sweet-alert/sweetalert2.all.min.js'></script>
            <script type='text/javascript'>
            function {$func_name}($parm_var){
                swal.fire({
                    title: '$title',
                    text: '$text',
                    html: '{$this->html}',
                    timer: $this->timer,
                    showConfirmButton: $this->showConfirmButton,
                    showCancelButton: $this->showCancelButton,
                    confirmButtonColor: '{$this->confirmButtonColor}',
                    confirmButtonText: '{$this->confirmButtonText}',
                    cancelButtonColor: '{$this->cancelButtonColor}',
                    closeOnConfirm: $this->closeOnConfirm,
                    allowOutsideClick: $this->allowOutsideClick
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: '{$this->complete}',
                            text: '{$this->complete_txt}',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href=$href;
                            }
                        });
                    }
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

use XoopsModules\Tadtools\SweetAlert2;

$SweetAlert2=new SweetAlert2();
$SweetAlert2->render("del_table","ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=",'mssn');

 */
