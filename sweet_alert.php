<?php

require_once __DIR__ . '/tadtools_header.php';
require_once __DIR__ . '/jquery.php';

class sweet_alert
{
    public $show_jquery;

    //建構函數
    public function __construct($show_jquery = true)
    {
        $this->show_jquery = $show_jquery;
    }

    //產生語法 $type=error,warning,info,success
    public function render($func_name = '', $url = '', $var = '', $title = _TAD_DEL_CONFIRM_TITLE, $text = _TAD_DEL_CONFIRM_TEXT, $confirmButtonText = _TAD_DEL_CONFIRM_BTN, $type = 'warning', $showCancelButton = true)
    {
        global $xoTheme;
        $jquery = $this->show_jquery ? get_jquery() : '';

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/sweet-alert/sweet-alert.css');
            $xoTheme->addScript('modules/tadtools/sweet-alert/sweet-alert.js');

            $xoTheme->addScript('', null, "
            function {$func_name}($var){
              swal({
                title: '$title',
                text: '$text',
                type: '$type',
                showCancelButton: $showCancelButton,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '$confirmButtonText',
                closeOnConfirm: false ,
                allowOutsideClick: true
              },
              function(){
                location.href='$url' + $var;
              });
            }
          ");
        } else {
            $main = "
            {$jquery}
            <link rel='stylesheet' type='text/css' href='" . TADTOOLS_URL . "/sweet-alert/sweet-alert.css'>
            <script type='text/javascript' src='" . TADTOOLS_URL . "/sweet-alert/sweet-alert.js'></script>
            <script type='text/javascript'>
              function {$func_name}($var){
                swal({
                  title: '$title',
                  text: '$text',
                  type: '$type',
                  showCancelButton: $showCancelButton,
                  confirmButtonColor: '#DD6B55',
                  confirmButtonText: '$confirmButtonText',
                  closeOnConfirm: false ,
                  allowOutsideClick: true
                },
                function(){
                  location.href='$url' + $var;
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

if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/sweet_alert.php")){
redirect_header("index.php",3, _TAD_NEED_TADTOOLS);
}
require_once XOOPS_ROOT_PATH."/modules/tadtools/sweet_alert.php";
$sweet_alert=new sweet_alert();
$sweet_alert->render("del_table","ajax_mk_tbl.php?op=del&modsn=$modsn&mssn=",'mssn');

 */
