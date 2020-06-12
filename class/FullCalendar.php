<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class FullCalendar
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
    public function render($selector = '#calendar', $json_file = '')
    {
        global $xoTheme;

        $jquery = Utility::get_jquery();

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/fullcalendar/fullcalendar.css');
            $xoTheme->addScript('modules/tadtools/fullcalendar/lib/moment.min.js');
            $xoTheme->addScript('modules/tadtools/fullcalendar/fullcalendar.js');
            $xoTheme->addScript('modules/tadtools/fullcalendar/locale-all.js');

            $fullcalendar = '';
        } else {
            $fullcalendar = "
            $jquery
            <link rel='stylesheet' type='text/css' href='" . XOOPS_URL . "/modules/tadtools/fullcalendar/fullcalendar.css'>
            <script src='" . XOOPS_URL . "/modules/tadtools/fullcalendar/lib/moment.min.js' type='text/javascript'></script>
            <script src='" . XOOPS_URL . "/modules/tadtools/fullcalendar/fullcalendar.js' type='text/javascript'></script>
            <script src='" . XOOPS_URL . "/modules/tadtools/fullcalendar/locale-all.js' type='text/javascript'></script>";
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
          \$(function() {
              \$('{$selector}').fullCalendar({
                editable: true,
                navLinks: true,
                eventLimit: true,
                locale: 'zh-tw',
                buttonText:{today: '今天'},
                // locale: window.navigator.userLanguage || window.navigator.language,
                {$js_parameter}
                {$get_event}
                header: {
                    left: 'prev,today,next',
                    right: 'title'
                    // left: 'prev,next today',
                    // center: 'title',
                    // right: 'month,agendaWeek,agendaDay,listWeek'
                }
              })
          });
        </script>";

        return $fullcalendar;
    }
}

/*
use XoopsModules\Tadtools\FullCalendar;
$FullCalendar=new FullCalendar();
$FullCalendar->add_js_parameter('year', 1973);
$FullCalendar->add_js_parameter('month', 6);
$FullCalendar->add_js_parameter('date', 16);
$FullCalendar->add_json_parameter('WebID', $WebID);
$FullCalendar->add_json_parameter('CateID', $CateID);
$fullcalendar_code = $FullCalendar->render('#calendar', 'get_event.php');
$xoopsTpl->assign('fullcalendar_code',$fullcalendar_code);
 */
