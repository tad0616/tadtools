<?php

namespace XoopsModules\Tadtools;

class FullCalendar6
{
    public $js_parameter   = [];
    public $json_parameter = [];
    public $quotation      = [];

    //建構函數
    public function __construct()
    {
    }

    public function add_js_parameter($key = '', $val = '', $quotation = true)
    {
        $this->js_parameter[$key] = $val;
        $this->quotation[$key]    = $quotation;
    }

    public function add_json_parameter($key = '', $val = '')
    {
        $this->json_parameter[$key] = $val;
    }

    //產生月曆
    public function render($selector = 'calendar', $json_file = '', $mode = '')
    {
        global $xoTheme;

        if ($xoTheme and $mode == '') {
            $xoTheme->addScript('modules/tadtools/fullcalendar6/index.global.js');
            $fullcalendar = '';
        } else {
            $fullcalendar = "
            <script src='" . XOOPS_URL . "/modules/tadtools/fullcalendar6/index.global.js' type='text/javascript'></script>\n";
        }

        $js_parameter = '';
        if (!empty($this->js_parameter)) {
            foreach ($this->js_parameter as $key => $value) {
                $js_parameter .= $this->quotation[$key] ? "\n{$key}: '{$value}'," : "\n{$key}: {$value},";
            }
        }

        $get_event = '';
        if ($json_file) {
            // $json_parameter = "start: start.format(), end: end.format(), ";
            $json_parameter = '';

            if (!empty($this->json_parameter)) {
                foreach ($this->json_parameter as $key => $value) {
                    $json_parameter_arr[] = "\n{$key}: '{$value}'";
                }
                $json_parameter .= implode(',', $json_parameter_arr);
            }

            $events_data = $json_parameter ? "\ndata: {
                {$json_parameter}
            }," : '';

            $get_event = "
                events: {
                    url: '$json_file',
                    type: 'POST',{$events_data}
                    error: function() {
                        alert('在擷取事件資料時發生錯誤，若有開除錯，請關閉之後再試一次。')
                    }
                },
            ";
        }

        $fullcalendar .= "
        <script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('{$selector}');

            // 用於判斷是否為首次渲染，避免頁面載入時自動朗讀
            var isFirstRender = true;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'zh-tw',
                buttonText:{today: '今天',prev:'上個月',next:'下個月'},
                {$js_parameter}
                {$get_event}
                customButtons: {
                    myToday: {
                        text: '今天',
                        click: function() {
                        calendar.today();
                        }
                    }
                },
                headerToolbar: {
                    left: 'prev,myToday,next',
                    center: 'title',
                    right: ''
                },
                initialView: 'dayGridMonth',
                eventDisplay: 'block',

                // 每次月份切換後觸發，朗讀當前畫面之年月
                datesSet: function(dateInfo) {
                    // 跳過首次渲染，不在頁面載入時朗讀
                    if (isFirstRender) {
                        isFirstRender = false;
                        return;
                    }

                    // 取得當前顯示月份的年與月
                    var currentDate = calendar.getDate();
                    var year = currentDate.getFullYear();
                    var month = currentDate.getMonth() + 1;

                    // 組合朗讀文字（例：「2026年5月」）
                    var speakText = year + '年' + month + '月';

                    // 使用 Web Speech API 朗讀
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel(); // 取消前次語音避免重疊
                        var utterance = new SpeechSynthesisUtterance(speakText);
                        utterance.lang = 'zh-TW';
                        window.speechSynthesis.speak(utterance);
                    }
                }
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
//注意，不需要 #
$fullcalendar_code = $FullCalendar->render('calendar', 'get_event.php');
$xoopsTpl->assign('fullcalendar_code',$fullcalendar_code);
 */
