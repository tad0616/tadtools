<?php

class rating extends \XoopsModules\Tadtools\StarRating
{
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
$StarRating->add_rating("psn",$get_psn);
$StarRating->render();
$all['star_rating']="<div id='rating_psn_{$get_psn}'></div>";

use XoopsModules\Tadtools\StarRating;
//顯示
$StarRating=new StarRating("tad_player","10",'show','simple');
while(){
$StarRating->add_rating("psn",$psn);
<div id='rating_psn_{$psn}'></div>
<div id='rating_result_{$col_name}_{$col_sn}'></div>
}
$StarRating->render();

use XoopsModules\Tadtools\StarRating;
case 'save_rating':
StarRating::save_rating($_POST['mod_name'], $_POST['col_name'], $_POST['col_sn'], $_POST['rank']);
break;

 */
