<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

require_once __DIR__ . '/tadtools_header.php';
$demo = Request::getString('demo');
$size = Request::getFloat('size', '1.5');
$font = Request::getString('font');
$title_font = Request::getString('title_font', $font);

$fonts = [
    '851DianJiWenZiTi' => '851電機文字',
    'Bakudai' => '莫大毛筆字體',
    'BoTa' => '波塔',
    'Chalk' => '粉筆體',
    'ChaoJiXi' => '超級細ゴシック體',
    'CorpRound' => '公司LOGO圓體',
    'Crayon' => '黑板粉筆體',
    'Cubic' => '俐方體11號',
    'Doudouziti' => '豆豆體',
    'HanWangMingBlack' => '王漢宗超明體',
    'HanWangWeBe' => '王漢宗魏碑體',
    'HanZiBiShunZiTi' => '漢字筆順體原版',
    'HengShanMaoBiCaoShu' => '衡山毛筆草書',
    'I-Ngaan' => '刻石錄顏體',
    'I-PenCrane-B' => '刻石錄鋼筆鶴體',
    'Iansui' => '芫荽體',
    'JasonHandwriting1' => '清松手寫體1',
    'JasonHandwriting2' => '清松手寫體2',
    'JasonHandwriting3' => '清松手寫體3',
    'JasonHandwriting4' => '清松手寫體4',
    'KaiseiTokumin' => '解星 B',
    'KingnamMaiyuan' => '荊南麥圓體',
    'Kurewa' => '苦累蛙圓體',
    'Mamelon' => 'Mamelon字體',
    'MamelonHi' => 'Mamelon新版字體',
    'MasaFont' => '正風毛筆字體（衡山毛筆行書）',
    'NaikaiFont' => '內海字體',
    'NishikiTeki' => '馬克筆手寫',
    'PangPangZhuRouTi' => '胖胖豬肉體',
    'PoSuiLingHaoZi' => '破碎零號字',
    'PopGothicCjkJp' => '大波浪圓體',
    'QianTuMaKeShouXieTi' => '千圖馬克手寫體',
    'Qiang' => '黒薔薇',
    'QingLiuShu' => '青柳隷書',
    'SweiFistLegCJKjp' => '獅尾詠腿黑體',
    'SweiSpringSugarCJKtc' => '獅尾四季春',
    'SweiToothpasteCJKtc' => '獅尾牙膏圓體',
    'TanugoTangGuoShouXieTiBold' => '糖果手寫粗體',
    'TanugoTangGuoShouXieTiRegular' => '糖果手寫體',
    'Tanukimagic' => 'たぬき油性マジック',
    'UzuraZiTi' => '鵪鶉字體',
    'WuXinShouXieTi' => '無心手寫體',
    'XianErTi' => '賢二體',
    'XinYiGuanHeiTi' => '字體圈欣意冠黑體',
    'YOzShouXieTi' => 'YOz手寫體',
    'YingZhuiXingShu' => '英椎行書',
    'YouZi' => '佑字',
    'YuanYingHeiTi' => '源影黑體',
    'ZhaiZaiJiaFenTiaoTian' => '宅在家粉條甜',
    'ZhaiZaiJiaMaiKeBi' => '宅在家麥克筆',
    'ZhaiZaiJiaZiDongBi' => '宅在家自動筆',
    'ZuoZuoMuZiTi' => '佐佐木字體',
    'jf-openhuninn' => 'jf open 粉圓體',
];

// $bad_fonts = [
//     'ZhanKuQingKeHuangYouTi' => '站酷慶科黃油體',
// ];

// $fonts = $bad_fonts;

ksort($fonts);

if ($font) {
    $title_size = $size * 1.5;
    $title_font_select = '';
    foreach ($fonts as $font_family => $font_title) {
        $selected = $font_family == $title_font ? 'selected' : '';
        $title_font_select .= "<option value='$font_family' $selected>$font_title</option>";
    }

    $font_select = '';
    foreach ($fonts as $font_family => $font_title) {
        $selected = $font_family == $font ? 'selected' : '';
        $font_select .= "<option value='$font_family' $selected>$font_title</option>";
    }

    $data = '
    <div class="alert alert-info" role="alert">
        <form action="fonts.php">
            <div class="input-group">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">標題字型</span>
                </div>
                <select name="title_font" class="form-control">
                ' . $title_font_select . '
                </select>
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">內文字型</span>
                </div>
                <select name="font" class="form-control">
                ' . $font_select . '
                </select>
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">大小</span>
                </div>
                <input type="text" name="size" class="form-control" value="' . $size . '" placeholder="可以輸入整數或小數">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">rem</span>
                </div>
                <div class="input-group-append input-group-btn">
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>
            </div>
        </form>
    </div>
    <h2><a href="fonts.php">回線上字型一覽</a></h2>';
    $data .= "<div style=\"border:1px solid gray; padding: 3rem; font-family: '{$font}'; font-size: {$size}rem;\">

    <h1 style=\"margin-bottom:2rem; font-family: '{$title_font}'; font-size: {$title_size}rem;\">流氓App剋星！Android 13有警告功能　提醒用戶留意高耗電應用程式</h1>

    <p>電池續航力一直是現代手機用戶最關注的一點，無論手機中裝了多大的電池，有些應用程式依然會在短時間內大量消耗手機電量。最新版本的 Android系統 Android 13多了項新功能，就是能夠在應用程式後台電池使用量過大時，通知用戶。</p>
    <p>Google宣布針對 Pixel 4 以上機型提供 Android 13 開發人員預覽版第二版，使開發者能率先針對新版本帶來的變化進行先期開發與體驗，此次的 Android 13 開發人員預覽版第二版也將帶來多項新功能，其中包括更新了一個功能，只要應用程式在24 小時內消耗了過多的電量，系統就會發通知提醒用戶。</p>
    <p>谷歌指出，某一個應用程式的前台服務消耗大量電池時，警告不會顯示，只有在此後繼續在後台高耗電的情況下，才會顯示警告。發出首條警告通知之後，警告將不會再次顯示，直到至少24 小時之後。</p>
    <p>此外，如果Android 13 系統檢測到一個App 在24 小時內至少在前台運行了20 個小時，將顯示以下通知：「App 在後台運行了很長時間」。點擊這個通知將打開前台服務 (FGS) 任務管理器，供用戶採取行動。這個通知在30 天內只對一個應用顯示一次。</p>
    <p>近年來，Google一直在對安卓系統進行調整，這些都是為了確保用戶的手機能有更長久的續航力。</p>
    </div>";

    echo Utility::html5($data, false, true, '4', false, 'container', $title = '線上字型大量文字預覽', '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/xoops.css">');

} else {

    $data = '
    <div class="alert alert-info" role="alert">
        <form action="fonts.php">
            <div class="input-group">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">範例文字</span>
                </div>
                <input type="text" name="demo" class="form-control" value="' . $demo . '" placeholder="可以輸入任何文字">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">大小</span>
                </div>
                <input type="text" name="size" class="form-control" value="' . $size . '" placeholder="可以輸入整數或小數">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">rem</span>
                </div>
                <div class="input-group-append input-group-btn">
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>
            </div>
        </form>
    </div>

    <h2>線上字型一覽</h2>
    <div class="table-responsive" style="height: 600px; overflow: auto;">
    <table class="table table-bordered table-sm">';

    $title_arr = [];
    if (empty($demo)) {
        $sql = "select `title` from " . $xoopsDB->prefix('newblocks') . "
        where `title` != '' and `visible` = 1";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($title) = $xoopsDB->fetchRow($result)) {
            $title_arr[] = $title;
        }
    }

    foreach ($fonts as $font_family => $font_title) {
        $data .= "
        <tr>
        <th class='align-middle' nowrap><a href='fonts.php?font={$font_family}'>$font_title</a></th>
        <td class='align-middle' nowrap><a href='fonts.php?font={$font_family}'>$font_family</a></td>";

        if (empty($demo)) {
            foreach ($title_arr as $title) {
                $data .= "
                <td class='align-middle' nowrap><div style=\"font-family: '{$font_family}'; font-size: {$size}rem;\">$title</div></td>
                ";
            }
        } else {
            $data .= "
            <td class='align-middle'><code>&lt;span style=\"font-family: '{$font_family}'; font-size: {$size}rem;\"&gt;{$demo}&lt;/span&gt;</code></td>
            <td class='align-middle'><div style=\"font-family: '{$font_family}'; font-size: {$size}rem;\">$demo</div></td>
            ";
        }
        $data .= "
        </tr>
        ";
    }
    $data .= '</table>
    </div>';

    // $data .= '$fonts = [<br>';
    // foreach ($fonts as $font_family => $font_title) {
    //     $data .= "    '$font_family' => '$font_title',<br>";
    // }
    // $data .= '];';

    echo Utility::html5($data, false, true, '4', false, 'container-fluid', $title = '線上字型一覽', '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/xoops.css">');

}
