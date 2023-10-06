<?php

namespace XoopsModules\Tadtools;

class FullCalendar6
{
    public $js_parameter = [];
    public $json_parameter = [];
    public $quotation = [];

    //建構函數
    public function __construct()
    {
    }

    public function add_js_parameter($key = '', $val = '', $quotation = true)
    {
        $this->js_parameter[$key] = $val;
        $this->quotation[$key] = $quotation;
    }

    public function add_json_parameter($key = '', $val = '')
    {
        $this->json_parameter[$key] = $val;
    }

    //產生月曆
    public function render($selector = '#calendar', $json_file = '', $mode = '')
    {
        global $xoTheme;

        if ($xoTheme and $mode == '') {
            $xoTheme->addScript('modules/tadtools/fullcalendar6/index.global.min.js');
            $fullcalendar = '';
        } else {
            $fullcalendar = "
            <script src='" . XOOPS_URL . "/modules/tadtools/fullcalendar6/index.global.min.js' type='text/javascript'></script>";
        }

        $js_parameter = '';
        if (!empty($this->js_parameter)) {
            foreach ($this->js_parameter as $key => $value) {
                $js_parameter .= $this->quotation[$key] ? "{$key}: '{$value}'," : "{$key}: {$value},";
            }
        }

        $get_event = '';
        if ($json_file) {
            // $json_parameter = "start: start.format(), end: end.format(), ";
            $json_parameter = '';

            if (!empty($this->json_parameter)) {
                foreach ($this->json_parameter as $key => $value) {
                    $json_parameter_arr[] = "{$key}: '{$value}'";
                }
                $json_parameter .= implode(',', $json_parameter_arr);
            }
            $get_event = "
                events: {
                    url: '$json_file',
                    type: 'POST',
                    data: {
                        {$json_parameter}
                    },
                    error: function() {
                        alert('there was an error while fetching events!');
                    }
                },

            ";
        }

        $fullcalendar .= "<script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('{$selector}');
            var calendar = new FullCalendar.Calendar(calendarEl, {
            {$js_parameter}
            {$get_event}
            locale: 'zh-tw',
            buttonText:{today: '今天'},
            initialView: 'dayGridMonth'
            });
            calendar.render();
        });
        </script>";

        return $fullcalendar;
    }
}

/*
use XoopsModules\Tadtools\FullCalendar6;
$FullCalendar=new FullCalendar6();
$FullCalendar->add_js_parameter('year', 1973);
$FullCalendar->add_js_parameter('month', 6);
$FullCalendar->add_js_parameter('date', 16);
$FullCalendar->add_json_parameter('WebID', $WebID);
$FullCalendar->add_json_parameter('CateID', $CateID);
$fullcalendar_code = $FullCalendar->render('calendar', 'get_event.php');
$xoopsTpl->assign('fullcalendar_code',$fullcalendar_code);
 */
