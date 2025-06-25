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
    public $buttons = [];
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

    public function __construct($total, $limit = 20, $page_limit = 10, $order_sql = '')
    {
        $this->prev      = "<img src='" . XOOPS_URL . "/modules/tadtools/images/1leftarrow.png' alt='" . _TAD_BACK_PAGE . "' align='absmiddle' hspace=3>";
        $this->next      = "<img src='" . XOOPS_URL . "/modules/tadtools/images/1rightarrow.png' alt='" . _TAD_NEXT_PAGE . "' align='absmiddle' hspace=3>";
        $this->first     = "<img src='" . XOOPS_URL . "/modules/tadtools/images/2leftarrow.png' alt='" . _TAD_FIRST_PAGE . "' align='absmiddle' hspace=3>";
        $this->last      = "<img src='" . XOOPS_URL . "/modules/tadtools/images/2rightarrow.png' alt='" . _TAD_LAST_PAGE . "' align='absmiddle' hspace=3>";
        $this->prev2     = "<img src='" . XOOPS_URL . "/modules/tadtools/images/1leftarrow_g.png' alt='" . _TAD_BACK_PAGE . "' align='absmiddle' hspace=3>";
        $this->next2     = "<img src='" . XOOPS_URL . "/modules/tadtools/images/1rightarrow_g.png' alt='" . _TAD_NEXT_PAGE . "' align='absmiddle' hspace=3>";
        $this->first2    = "<img src='" . XOOPS_URL . "/modules/tadtools/images/2leftarrow_g.png' alt='" . _TAD_FIRST_PAGE . "' align='absmiddle' hspace=3>";
        $this->last2     = "<img src='" . XOOPS_URL . "/modules/tadtools/images/2rightarrow_g.png' alt='" . _TAD_LAST_PAGE . "' align='absmiddle' hspace=3>";
        $this->to_page   = $_SERVER['PHP_SELF'];
        $this->limit     = (int) $limit;
        $this->total     = $total;
        $this->pLimit    = $page_limit;
        $this->order_sql = $order_sql;
    }

    public function init()
    {
        $this->used_query = array($this->url_page);
        $this->query_str  = $this->processQuery($this->used_query);
        $this->glue       = ('' == $this->query_str) ? '?' : '&';
        $this->limit      = empty($this->limit) ? 10 : $this->limit;
        $this->current    = isset($_GET[$this->url_page]) ? max(1, (int) $_GET[$this->url_page]) : 1;
        $this->pTotal     = ceil($this->total / $this->limit);

        if ($this->current < 1) {
            $this->current = 1;
        } elseif ($this->current > $this->pTotal) {
            $this->current = $this->pTotal;
        }

        $this->pCurrent = ceil($this->current / $this->pLimit);
    }

    public function processQuery($used_query)
    {
        $QUERY_STRING = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        // 使用 parse_str() 來解析查詢字符串
        parse_str($QUERY_STRING, $query_vars);
        $filtered_vars = array();

        foreach ($query_vars as $key => $value) {
            // 檢查鍵是否在 used_query 中
            if (!in_array($key, $used_query)) {
                // 處理陣列值
                if (is_array($value)) {
                    foreach ($value as $array_key => $array_value) {
                        $safe_key         = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                        $safe_array_key   = htmlspecialchars($array_key, ENT_QUOTES, 'UTF-8');
                        $safe_array_value = htmlspecialchars($array_value, ENT_QUOTES, 'UTF-8');

                        // 構建陣列參數的格式：key[array_key]=array_value
                        if (is_numeric($array_key)) {
                            // 如果是數字索引陣列，使用 [] 格式
                            $filtered_vars[] = $safe_key . '[]=' . $safe_array_value;
                        } else {
                            // 如果是關聯陣列，使用 [key] 格式
                            $filtered_vars[] = $safe_key . '[' . $safe_array_key . ']=' . $safe_array_value;
                        }
                    }
                } else {
                    // 處理非陣列值
                    $safe_key        = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                    $safe_value      = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    $filtered_vars[] = $safe_key . '=' . $safe_value;
                }
            }
        }

        return empty($filtered_vars) ? '' : '?' . implode('&', $filtered_vars);
    }

    public function sqlQuery()
    {
        $row_start = ($this->current - 1) * $this->limit;
        if ($row_start < 0) {
            $row_start = 0;
        }
        return $this->order_sql ? " {$this->order_sql} LIMIT {$row_start}, {$this->limit}" : " LIMIT {$row_start}, {$this->limit}";
    }

    public function set_to_page($page = '')
    {
        $this->to_page = $page;
    }

    public function set_url_other($other = '')
    {
        $this->url_other = $other;
    }

    public function makeBootStrapBar($url_page = 'g2p')
    {

        if ('' !== $url_page) {
            $this->url_page = $url_page;
        }
        $this->init();

        $loadtime = $this->url_other;
        $start    = ($this->pCurrent - 1) * $this->pLimit + 1;
        $end      = min($this->pTotal, $this->pCurrent * $this->pLimit);

        $bar_center = '';
        for ($i = $start; $i <= $end; $i++) {
            $active  = $i == $this->current ? ' active' : '';
            $sr_only = $i == $this->current ? '<span class="sr-only">(current)</span>' : '';
            $bar_center .= sprintf(
                '<li class="page-item%s"><a class="page-link" href="%s%s%s%s=%d%s" title="%d">%d%s</a></li>',
                $active,
                $this->to_page,
                $this->query_str,
                $this->glue,
                $this->url_page,
                $i,
                $loadtime,
                $i,
                $i,
                $sr_only
            );
        }

        $bar_left = $this->current <= 1
        ? '<li class="page-item disabled"><a class="page-link disabled" href="#">&lsaquo;</a></li>'
        : sprintf(
            '<li class="page-item"><a class="page-link" href="%s%s%s%s=%d%s" title="%s">&lsaquo;</a></li>',
            $this->to_page,
            $this->query_str,
            $this->glue,
            $this->url_page,
            $this->current - 1,
            $loadtime,
            _TAD_BACK_PAGE
        );

        $bar_first = $this->current <= 1
        ? '<li class="page-item disabled"><a class="page-link disabled" href="#">&laquo;</a></li>'
        : sprintf(
            '<li class="page-item"><a class="page-link" href="%s%s%s%s=1%s" title="%s">&laquo;</a></li>',
            $this->to_page,
            $this->query_str,
            $this->glue,
            $this->url_page,
            $loadtime,
            _TAD_FIRST_PAGE
        );

        $bar_right = $this->current >= $this->pTotal
        ? '<li class="page-item disabled"><a class="page-link disabled" href="#">&rsaquo;</a></li>'
        : sprintf(
            '<li class="page-item"><a class="page-link" href="%s%s%s%s=%d%s" title="%s">&rsaquo;</a></li>',
            $this->to_page,
            $this->query_str,
            $this->glue,
            $this->url_page,
            $this->current + 1,
            $loadtime,
            _TAD_NEXT_PAGE
        );

        $bar_last = $this->current >= $this->pTotal
        ? '<li class="page-item disabled"><a class="page-link disabled" href="#">&raquo;</a></li>'
        : sprintf(
            '<li class="page-item"><a class="page-link" href="%s%s%s%s=%d%s" title="%s">&raquo;</a></li>',
            $this->to_page,
            $this->query_str,
            $this->glue,
            $this->url_page,
            $this->pTotal,
            $loadtime,
            _TAD_LAST_PAGE
        );

        return array(
            'center' => $bar_center,
            'left' => $bar_first . $bar_left,
            'right' => $bar_right . $bar_last,
            'current' => $this->current,
            'total' => $this->pTotal,
            'start' => ($this->current - 1) * $this->limit + 1,
            'end' => min($this->current * $this->limit, $this->total),
            'bar_first' => $bar_first,
            'bar_left' => $bar_left,
            'bar_right' => $bar_right,
            'bar_last' => $bar_last,
            'sql' => $this->sqlQuery(),
        );
    }
}
