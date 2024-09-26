<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class StarRating
{
    public $code = [];
    public $rank_total;
    private $mode;
    private $show_mode;
    private $rate_mode;
    private $mod_name;

    //建構函數
    public function __construct($mod_name = '', $rank_total = '10', $mode = '', $show_mode = '', $rate_mode = '')
    {
        $this->rank_total = $rank_total;
        $this->mode = $mode;
        $this->show_mode = $show_mode;
        $this->rate_mode = $rate_mode;
        $this->mod_name = $mod_name;
    }

    //新增提示
    public function add_rating($save_url = '', $col_name = '', $col_sn = '')
    {
        global $xoopsUser;
        if ($xoopsUser and $this->mode != 'show') {
            $rate = $this->get_uid_rank($col_name, $col_sn);
            $score = isset($rate['rank']) ? $rate['rank'] : 0;
            $msg = isset($rate['rank_date']) ? sprintf(_TAD_STAR_RATING_DATE_SAVE, $rate['rank_date'], $score) : '';

            $save_js =
                "
                click: function(score, evt) {
                    score = score * 2;
                    $.post('$save_url', {op:'save_rating',mod_name: '{$this->mod_name}', col_name: '$col_name', col_sn: '$col_sn',rank: score }, function(msg) {
                        $('#rating_result_{$col_name}_{$col_sn}').html(msg);
                    });
                },
              ";

            $disabled = '';
        } else {
            $save_js = '';
            $disabled = 'readOnly: true,';
            $score = $this->get_avg_rank($col_name, $col_sn);
            $msg = ('simple' === $this->show_mode) ? '' : sprintf(_TAD_STAR_RATING_AVG, $score);
        }

        $msg_js = ('simple' === $this->show_mode) ? '' : "$('#rating_result_{$col_name}_{$col_sn}').html('$msg');";

        $score = $score / 2;

        $show_score = empty($score) ? '' : "score : $score,";
        $this->code[] = "
        //module:{$this->mod_name}
        $('#rating_{$col_name}_{$col_sn}').raty({
            $save_js
            $show_score
            $disabled
            hints   : ['2','4','6','8','10'],
            number: 5,
            half  : true,
            space : false,
            path  : '" . XOOPS_URL . "/modules/tadtools/jquery.raty/img'
        });
        $msg_js
        ";
    }

    //取得某人分數
    public function get_uid_rank($col_name = '', $col_sn = '')
    {
        global $xoopsDB, $xoopsUser;

        if (!$xoopsUser) {
            return;
        }

        if (empty($uid)) {
            $uid = $xoopsUser->uid();
        }
        $sql = 'SELECT `rank`, `rank_date` FROM `' . $xoopsDB->prefix("{$this->mod_name}_rank") . '` WHERE `col_name` = ? AND `col_sn` = ? AND `uid` = ?';
        $result = Utility::query($sql, 'sii', [$col_name, $col_sn, $uid]) or Utility::web_error($sql);

        $main = $xoopsDB->fetchArray($result);

        return $main;
    }

    //取得平均分數
    public function get_avg_rank($col_name = '', $col_sn = '')
    {
        global $xoopsDB;
        $sql = 'SELECT AVG(`rank`) FROM `' . $xoopsDB->prefix("{$this->mod_name}_rank") . '` WHERE `col_name` = ? AND `col_sn` = ?';
        $result = Utility::query($sql, 'si', [$col_name, $col_sn]) or Utility::web_error($sql);

        list($main) = $xoopsDB->fetchRow($result);
        $main = round($main, 0);

        return $main;
    }

    //儲存分數
    public static function save_rating($mod_name = '', $col_name = '', $col_sn = '', $rank = '', $uid = '', $mode = '')
    {
        global $xoopsDB, $xoopsUser;
        $now = date('Y-m-d H:i:s', xoops_getUserTimestamp(time()));

        if (!$xoopsUser && empty($uid)) {
            return;
        }

        $uid = $uid ? $uid : $xoopsUser->uid();
        $sql = 'REPLACE INTO `' . $xoopsDB->prefix("{$mod_name}_rank") . '` (`col_name`, `col_sn`, `rank`, `uid`, `rank_date`) VALUES (?, ?, ?, ?, ?)';
        Utility::query($sql, 'sisis', [$col_name, $col_sn, $rank, $uid, $now]) or Utility::web_error($sql);

        if ($mode != 'return') {
            die(sprintf(_TAD_STAR_RATING_SAVE, $rank));
        }
    }

    //產生路徑工具
    public function render($show_all = true)
    {
        global $xoTheme;
        $jquery = Utility::get_jquery();

        $all_code = implode("\n", $this->code);

        if (!$show_all) {
            return $all_code;
        }

        if ($xoTheme) {
            $xoTheme->addScript('modules/tadtools/jquery.raty/js/jquery.raty.js');

            $xoTheme->addScript('', null, "
            (function(\$){
                \$(document).ready(function(){
                    $all_code
                });
            })(jQuery);
          ");
        } else {
            $main = "
            $jquery
            <script src='" . XOOPS_URL . "/modules/tadtools/jquery.raty/js/jquery.raty.js' type='text/javascript'></script>

            <script type='text/javascript'>
                $(document).ready(function()  {
                    $all_code
                });
            </script>";

            return $main;
        }
    }
}

/*
建立

CREATE TABLE `xx_tad_player_rank` (
`col_name` varchar(255) NOT NULL,
`col_sn` smallint(5) unsigned NOT NULL,
`rank` tinyint(3) unsigned NOT NULL,
`uid` smallint(5) unsigned NOT NULL,
`rank_date` datetime NOT NULL,
PRIMARY KEY (`col_name`,`col_sn`,`uid`)
)

use XoopsModules\Tadtools\StarRating;

//票選
$StarRating=new StarRating("tad_player","10",'','simple');
$StarRating->add_rating('index.php',"psn",$get_psn);
$StarRating->render();
$all['star_rating']="<div id='rating_psn_{$get_psn}'></div>";

use XoopsModules\Tadtools\StarRating;
//顯示
$StarRating=new StarRating("tad_player","10",'show','simple');
while(){
$StarRating->add_rating('index.php',"psn",$psn);
<div id='rating_psn_{$psn}'></div>
<div id='rating_result_{$col_name}_{$col_sn}'></div>
}
$StarRating->render();

// index.php
use XoopsModules\Tadtools\StarRating;
case 'save_rating':
StarRating::save_rating($_POST['mod_name'], $_POST['col_name'], $_POST['col_sn'], $_POST['rank']);
break;

 */
