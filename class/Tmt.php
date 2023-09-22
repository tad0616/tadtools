<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class Tmt
{
    //建構函數
    public function __construct()
    {
    }

    //產生語法 $type=error,warning,info,success
    public function render($id, $from_arr = [], $to_arr = [], $hidden_arr = ['op' => 'save_tmt'], $only_value = false, $submit = true, $size = '15rem', $from_name = 'repository', $to_name = 'destination', $sep = ',', $keyman_file = '', $keyman_var = [])
    {
        global $xoTheme;

        $id_value = implode($sep, array_keys($to_arr));
        $from_options = '';
        foreach ($from_arr as $key => $value) {
            if ($only_value) {
                $key = $value;
            }
            $from_options .= "<option value='{$key}'>{$value}</option>";

        }
        $to_options = '';
        foreach ($to_arr as $key => $value) {
            if ($only_value) {
                $key = $value;
            }
            $to_options .= "<option value='{$key}'>{$value}</option>";
        }
        $hidden = '';
        foreach ($hidden_arr as $key => $value) {
            if ($only_value) {
                $key = $value;
            }
            $hidden .= "<input type='hidden' name='{$key}' id='{$key}' value='{$value}'>";
        }

        $key_man_var = '';
        foreach ($keyman_var as $key => $value) {
            $key_man_var = ",{$key}: {$value}";
        }

        $jquery = Utility::get_jquery();

        if ($xoTheme) {
            $main = '';
            $xoTheme->addScript('modules/tadtools/tmt/tmt_core.js');
            $xoTheme->addScript('modules/tadtools/tmt/tmt_spry_linkedselect.js');

            $xoTheme->addScript('', null, "
            $(document).ready(function() {
                $('#keyman').change(function(event) {
                    $.post('{$keyman_file}', {op: 'keyman' , keyman: $('#keyman').val(){$key_man_var}}, function(theResponse){
                        $('#{$from_name}').html(theResponse);
                    });
                });
            });
            function getOptions({$to_name}, val_col)
            {
                var values = [];
                var sel = document.getElementById({$to_name});
                for (var i=0, n=sel.options.length;i<n;i++) {
                    if (sel.options[i].value) values.push(sel.options[i].value);
                }
                document.getElementById(val_col).value=values.join(',');
            }
            ");
        } else {
            $main = "
            {$jquery}
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/tmt/tmt_core.js'></script>
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/tmt/tmt_spry_linkedselect.js'></script>

            <script type='text/javascript'>
                $(document).ready(function() {
                    $('#keyman').change(function(event) {
                        $.post('{$keyman_file}', {op: 'keyman' , keyman: $('#keyman').val(){$key_man_var}}, function(theResponse){
                            $('#{$from_name}').html(theResponse);
                        });
                    });
                });

                function getOptions({$to_name},val_col)
                {
                    var values = [];
                    var sel = document.getElementById({$to_name});
                    for (var i=0, n=sel.options.length;i<n;i++) {
                        if (sel.options[i].value) values.push(sel.options[i].value);
                    }
                    document.getElementById(val_col).value=values.join(',');
                }
            </script>
            ";
        }

        $submit_btn = $submit ? "<button type='submit' class='btn btn-primary'>" . _TAD_SAVE . "</button>" : "";
        $key_man_col = $keyman_file ? "
        <div class='input-group'>
            <input type='text' name='keyman' id='keyman' placeholder='輸入關鍵字以篩選' class='form-control'>
            <div class='input-group-append input-group-btn'>
                <button type='button' class='btn btn-success'>篩選</button>
            </div>
        </div>" : '';
        $main .= "<div class='row'>
            <div class='col-md-5'>
                $key_man_col
                <select name='{$from_name}' id='{$from_name}' style='height: $size' multiple='multiple' tmt:linkedselect='true' class='form-control'>
                    {$from_options}
                </select>
            </div>
            <div class='col-md-2 text-center'>
                <img src='" . XOOPS_URL . "/modules/tadtools/tmt/right.png' onclick=\"tmt.spry.linkedselect.util.moveOptions('{$from_name}', '{$to_name}');getOptions('{$to_name}','{$id}');\"><br>
                <img src='" . XOOPS_URL . "/modules/tadtools/tmt/left.png' onclick=\"tmt.spry.linkedselect.util.moveOptions('{$to_name}' , '{$from_name}');getOptions('{$to_name}','{$id}');\"><br><br>

                <img src='" . XOOPS_URL . "/modules/tadtools/tmt/up.png' onclick=\"tmt.spry.linkedselect.util.moveOptionUp('{$to_name}');getOptions('{$to_name}','{$id}');\"><br>
                <img src='" . XOOPS_URL . "/modules/tadtools/tmt/down.png' onclick=\"tmt.spry.linkedselect.util.moveOptionDown('{$to_name}');getOptions('{$to_name}','{$id}');\">
                <div class='text-center' style='margin-top: 30px;'>
                    <input type='hidden' name='{$id}' id='{$id}' value='{$id_value}'>
                    {$hidden}
                    {$submit_btn}
                </div>
            </div>
            <div class='col-md-5'>
                <select id='{$to_name}' style='height: $size' multiple='multiple' tmt:linkedselect='true' class='form-control'>
                {$to_options}
                </select>
            </div>
        </div>
        ";

        return $main;
    }
}
/*

use XoopsModules\Tadtools\Tmt;

$Tmt=Tmt::render($id, $from_arr, $to_arr, $hidden_arr );

 */
