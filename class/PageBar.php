<?php

namespace XoopsModules\Tadtools;

xoops_loadLanguage('main', 'tadtools');

/*
PageBar Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class PageBar
 */
class PageBar
{
    // 目前所在頁碼
    public $current;
    // 所有的資料數量 (rows)
    public $total;
    // 每頁顯示幾筆資料
    public $limit = 10;
    // 目前在第幾層的頁數選項？
    public $pCurrent;
    // 總共分成幾頁？
    public $pTotal;
    // 每一層最多有幾個頁數選項可供選擇，如：3 = {[1][2][3]}
    public $pLimit;
    public $prev;
    public $next;
    public $prev2;
    public $next2;
    public $prev_layer = ' ';
    public $next_layer = ' ';
    public $first;
    public $last;
    public $first2;
    public $last2;
    public $bottons = [];
    // 要使用的 URL 頁數參數名？
    public $url_page = 'g2p';
    // 會使用到的 URL 變數名，給 process_query() 過濾用的。
    public $used_query = [];
    // 目前頁數顏色
    public $act_color = '#990000';
    public $query_str; // 存放 URL 參數列
    //指定頁面
    public $to_page;
    //其他連結參數
    public $url_other;
    //在limit前額外加入排序
    public $order_sql;
    public $glue;
    public $buttons;

    public function __construct($total, $limit = '20', $page_limit = '10', $order_sql = '')
    {
        $limit = (int) $limit;
        $page_limit = (int) $page_limit;
        $this->prev = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/1leftarrow.png' alt='" . _TAD_BACK_PAGE . "' align='absmiddle' hspace=3>");
        $this->next = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/1rightarrow.png' alt='" . _TAD_NEXT_PAGE . "' align='absmiddle' hspace=3>");
        $this->first = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/2leftarrow.png' alt='" . _TAD_FIRST_PAGE . "' align='absmiddle' hspace=3>");
        $this->last = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/2rightarrow.png' alt='" . _TAD_LAST_PAGE . "' align='absmiddle' hspace=3>");
        $this->prev2 = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/1leftarrow_g.png' alt='" . _TAD_BACK_PAGE . "' align='absmiddle' hspace=3>");
        $this->next2 = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/1rightarrow_g.png' alt='" . _TAD_NEXT_PAGE . "' align='absmiddle' hspace=3>");
        $this->first2 = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/2leftarrow_g.png' alt='" . _TAD_FIRST_PAGE . "' align='absmiddle' hspace=3>");
        $this->last2 = $this->sanitizeHTML("<img src='" . XOOPS_URL . "/modules/tadtools/images/2rightarrow_g.png' alt='" . _TAD_LAST_PAGE . "' align='absmiddle' hspace=3>");
        $this->to_page = $this->sanitizeURL($_SERVER['PHP_SELF']);
        $this->limit = $limit;
        $this->total = (int) $total;
        $this->pLimit = $page_limit;
        $this->order_sql = $this->sanitizeSQL($order_sql);
    }

    public function init()
    {
        $this->used_query = [$this->url_page];
        $this->query_str = $this->processQuery($this->used_query);
        $this->glue = ('' == $this->query_str) ? '?' : '&';

        $this->current = (isset($_GET[$this->url_page])) ? (int) $_GET[$this->url_page] : 1;
        if ($this->current < 1) {
            $this->current = 1;
        }

        $this->pTotal = ceil($this->total / $this->limit);
        $this->pCurrent = ceil($this->current / $this->pLimit);
    }

    public function processQuery($used_query)
    {
        $QUERY_STRING = $this->sanitizeURL($_SERVER['QUERY_STRING']);
        $vars = explode('&', $QUERY_STRING);
        $len = mb_strlen('amp;' . $this->url_page);
        $var = [];

        foreach ($vars as $v) {
            if ('amp;' . $this->url_page === mb_substr($v, 0, $len)) {
                continue;
            }
            $var[] = explode('=', $v);
        }

        $var = array_filter($var, function ($v) use ($used_query) {
            return !in_array($v[0], $used_query);
        });

        $processed_query = '';
        foreach ($var as $v) {
            if (count($v) === 2) {
                $glue = ('' == $processed_query) ? '?' : '&';
                $processed_query .= $glue . $this->sanitizeURL($v[0]) . '=' . $this->sanitizeURL($v[1]);
            }
        }

        return $processed_query;
    }

    public function sqlQuery()
    {
        $row_start = ($this->current * $this->limit) - $this->limit;
        if ($this->order_sql != '') {
            $sql_query = " {$this->order_sql} LIMIT " . (int) $row_start . ", " . (int) $this->limit;
        } else {
            $sql_query = " LIMIT " . (int) $row_start . ", " . (int) $this->limit;
        }

        return $sql_query;
    }

    public function set_to_page($page = '')
    {
        $this->to_page = $page;
    }

    public function set_url_other($other = '')
    {
        $this->url_other = $other;
    }

    // 製作 bar
    public function makeBar($url_page = 'none')
    {
        if ('none' !== $url_page) {
            $this->url_page = $url_page;
        }
        $this->init();

        // 取得目前時間
        $loadtime = $this->url_other;

        // 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
        $i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

        $bar_center = '';
        while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)) {
            if ($i == $this->current) {
                $bar_center = "{$bar_center}<span color='{$this->act_color}' style='border:1px solid #660000;background-color:#660000;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>&nbsp;{$i}&nbsp;</span>";
            } else {
                $bar_center .= " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' style='border:1px solid silver;background-color:white;color:#666666;text-align:center;padding:3px;margin:1px;line-height:100%;'>&nbsp;{$i}&nbsp;</a> ";
            }
            $i++;
        }
        $bar_center = $bar_center . '';

        // 往前跳一頁
        if ($this->current <= 1) {
            //$bar_left=$bar_first="";
            $bar_left = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->prev2}</span>";
            $bar_first = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->first2}</span>";
        } else {
            $i = $this->current - 1;
            $bar_left = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_BACK_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->prev}</a> ";
            $bar_first = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='" . _TAD_FIRST_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->first}</a> ";
        }

        // 往後跳一頁
        if ($this->current >= $this->pTotal) {
            //$bar_right=$bar_last="";
            $bar_right = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->next2}</span>";
            $bar_last = "<span style='border:1px solid silver;background-color:white;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->last2}</span>";
        } else {
            $i = $this->current + 1;
            $bar_right = "<a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_NEXT_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->next}</a> ";
            $bar_last = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='" . _TAD_LAST_PAGE . "' style='border:1px solid gray;background-color:#FFFFCC;color:white;text-align:center;padding:3px;margin:1px;line-height:100%;'>{$this->last}</a> ";
        }

        // 往前跳一整個頁框(層)
        if (($this->current - $this->pLimit) < 1) {
            $bar_l = " {$this->prev_layer} ";
        } else {
            $i = $this->current - $this->pLimit;
            $bar_l = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . sprintf($this->pLimit, _TAD_GO_BACK_PAGE) . "' style=''>{$this->prev_layer}</a> ";
        }

        //往後跳一整個頁框(層)
        if (($this->current + $this->pLimit) > $this->pTotal) {
            $bar_r = " {$this->next_layer} ";
        } else {
            $i = $this->current + $this->pLimit;
            $bar_r = " <a href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . sprintf($this->pLimit, _TAD_GO_NEXT_PAGE) . "' style=''>{$this->next_layer}</a> ";
        }

        $page_bar['center'] = $this->sanitizeHTML($bar_center);
        $page_bar['left'] = $this->sanitizeHTML($bar_first . $bar_l . $bar_left);
        $page_bar['right'] = $this->sanitizeHTML($bar_right . $bar_r . $bar_last);
        $page_bar['current'] = (int) $this->current;
        $page_bar['total'] = (int) $this->pTotal;
        $page_bar['sql'] = $this->sqlQuery();

        return $page_bar;
    }

    // 製作 bar
    public function makeBootStrapBar($url_page = 'none')
    {
        if ('none' !== $url_page and '' != $url_page) {
            $this->url_page = $url_page;
        }
        $this->init();

        // 取得目前時間
        $loadtime = $this->url_other;

        // 取得目前頁框(層)的第一個頁數啟始值，如 6 7 8 9 10 = 6
        $i = ($this->pCurrent * $this->pLimit) - ($this->pLimit - 1);

        $bar_center = '';
        while ($i <= $this->pTotal && $i <= ($this->pCurrent * $this->pLimit)) {
            if ($i == $this->current) {
                $bar_center = "
                        {$bar_center}
                        <li class='page-item active'>
                            <a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='{$i}'>{$i}<span class='sr-only'>(current)</span></a>
                        </li>";
            } else {
                $bar_center .= "
                        <li class='page-item'>
                            <a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}'>{$i}</a>
                        </li>";
            }
            $i++;
        }
        $bar_center = $bar_center . '';

        // 往前跳一頁
        if ($this->current <= 1) {
            //$bar_left=$bar_first="";
            $bar_left = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&lsaquo;</a></li>";
            $bar_first = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&laquo;</a></li>";
        } else {
            $i = $this->current - 1;
            $bar_left = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_BACK_PAGE . "'>&lsaquo;</a></li>";
            $bar_first = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}=1{$loadtime}' title='" . _TAD_FIRST_PAGE . "' >&laquo;</a></li>";
        }

        // 往後跳一頁
        if ($this->current >= $this->pTotal) {
            //$bar_right=$bar_last="";
            $bar_right = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&rsaquo;</a></li>";
            $bar_last = "<li class='page-item disabled'><a class='page-link disabled' href='#'>&raquo;</a></li>";
        } else {
            $i = $this->current + 1;
            $bar_right = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$i}{$loadtime}' title='" . _TAD_NEXT_PAGE . "'>&rsaquo;</a></li>";
            $bar_last = "<li class='page-item'><a class='page-link' href='{$this->to_page}{$this->query_str}{$this->glue}{$this->url_page}={$this->pTotal}{$loadtime}' title='" . _TAD_LAST_PAGE . "' >&raquo;</a></li>";
        }

        // 往前跳一整個頁框(層)
        if (($this->current - $this->pLimit) < 1) {
            $bar_l = '';
        } else {
            $i = $this->current - $this->pLimit;
            $bar_l = '';
        }

        //往後跳一整個頁框(層)
        if (($this->current + $this->pLimit) > $this->pTotal) {
            $bar_r = '';
        } else {
            $i = $this->current + $this->pLimit;
            $bar_r = '';
        }

        $page_bar['center'] = $bar_center;
        $page_bar['left'] = $bar_first . $bar_l . $bar_left;
        $page_bar['right'] = $bar_right . $bar_r . $bar_last;
        $page_bar['current'] = $this->current;
        $page_bar['total'] = $this->pTotal;
        $page_bar['start'] = ($this->current * $this->limit) - $this->limit + 1;
        $page_bar['end'] = $this->current * $this->limit;
        $page_bar['bar_first'] = $bar_first;
        $page_bar['bar_left'] = $bar_left;
        $page_bar['bar_right'] = $bar_right;
        $page_bar['bar_last'] = $bar_last;
        $page_bar['sql'] = $this->sqlQuery();

        return $page_bar;
    }

    private function sanitizeHTML($input)
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    private function sanitizeURL($input)
    {
        return filter_var($input, FILTER_SANITIZE_URL);
    }

    private function sanitizeSQL($input)
    {
        // This is a basic example. In a real-world scenario, you should use prepared statements.
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $input);
    }
}
