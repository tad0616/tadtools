<?php

use XoopsModules\Tadtools\Utility;

// include_once 'tadtools_header.php';
// include_once 'jquery.php';

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

//票選
include_once XOOPS_ROOT_PATH."/modules/tadtools/star_rating.php";
$rating=new rating("tad_player","10",'','simple');
$rating->add_rating("psn",$get_psn);
$all['star_rating']=$rating->render();
$all['star_rating'].="<div id='rating_psn_{$get_psn}'></div>";

//顯示
include_once XOOPS_ROOT_PATH."/modules/tadtools/star_rating.php";
$rating=new rating("tad_player","10",'show','simple');
while(){
$rating->add_rating("psn",$psn);
<div id='rating_psn_{$psn}'></div>
<div id='rating_result_{$col_name}_{$col_sn}'></div>
}
$rating_js=$rating->render();
 */

if (isset($_POST['op']) and 'save_rating' === $_POST['op']) {
    save_rating($_POST['mod_name'], $_POST['col_name'], $_POST['col_sn'], $_POST['rank']);
}

//儲存分數
function save_rating($mod_name = '', $col_name = '', $col_sn = '', $rank = '')
{
    global $xoopsDB, $xoopsUser;
    $now = date('Y-m-d H:i:s', xoops_getUserTimestamp(time()));

    if (!$xoopsUser) {
        return;
    }

    $uid = $xoopsUser->uid();
    $sql = 'replace into ' . $xoopsDB->prefix("{$mod_name}_rank") . " (`col_name`, `col_sn`, `rank`, `uid`, `rank_date`) values('{$col_name}' , '{$col_sn}' , '{$rank}', '{$uid}' , '{$now}')";
    $xoopsDB->queryF($sql) or die($xoopsDB->error());

    die(sprintf(_TAD_STAR_RATING_SAVE, $rank));
}

class rating
{
    public $code = [];
    public $rank_total;
    public $mode;
    public $show_mode;
    public $rate_mode;
    public $mod_name;

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
    public function add_rating($col_name = '', $col_sn = '')
    {
        global $xoopsUser;

        if ($xoopsUser and 'show' !== $this->mode) {
            $rate = $this->get_uid_rank($col_name, $col_sn);
            $score = $rate['rank'];
            $msg = sprintf(_TAD_STAR_RATING_DATE_SAVE, $rate['rank_date'], $score);

            $save_js =
                "
                click: function(score, evt) {
                  score = score * 2;
                  $.post('" . XOOPS_URL . "/modules/tadtools/star_rating.php', {op:'save_rating',mod_name: '{$this->mod_name}', col_name: '$col_name', col_sn: '$col_sn',rank: score }, function(msg) {
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
            path  : '" . TADTOOLS_URL . "/jquery.raty/img'
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

        $sql = 'select rank,rank_date from ' . $xoopsDB->prefix("{$this->mod_name}_rank") . " where `col_name`='$col_name' and `col_sn`='$col_sn' and `uid`='$uid'";
        $result = $xoopsDB->queryF($sql) or die($xoopsDB->error());
        $main = $xoopsDB->fetchArray($result);

        return $main;
    }

    //取得平均分數
    public function get_avg_rank($col_name = '', $col_sn = '')
    {
        global $xoopsDB;

        $sql = 'select AVG(`rank`) from ' . $xoopsDB->prefix("{$this->mod_name}_rank") . " where `col_name`='$col_name' and `col_sn`='$col_sn'";
        $result = $xoopsDB->queryF($sql) or die($xoopsDB->error());
        list($main) = $xoopsDB->fetchRow($result);
        $main = round($main, 0);

        return $main;
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
            <script src='" . TADTOOLS_URL . "/jquery.raty/js/jquery.raty.js' type='text/javascript'></script>

            <script type='text/javascript'>
              $(document).ready(function()  {
                $all_code
              });
            </script>";

            return $main;
        }
    }
}
