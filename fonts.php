<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;

require_once __DIR__ . '/tadtools_header.php';
$demo = Request::getString('demo');
$size = Request::getFloat('size', '1.5');
$font = Request::getString('font');
$title_font = Request::getString('title_font', $font);
$demo_title = Request::getString('demo_title', '台式麵包熱量排行榜曝光 最肥不是奶酥麵包…');
$demo_content = Request::getString('demo_content', '台式麵包鬆軟好入口、組織細膩，內餡又豐富可口，讓不少人非常喜愛，不過營養師就公開了市面上常見販售的台式麵包熱量，第一名並非奶酥麵包或菠蘿麵包，而是由熱量高達565大卡的蔥花肉鬆捲奪得冠軍。');
$otf_arr = ['BoTa', 'Chalk', 'KingnamMaiyuan', 'Mamelon', 'MamelonHi', 'PangPangZhuRouTi', 'PoSuiLingHaoZi', 'TanugoTangGuoShouXieTiBold', 'TanugoTangGuoShouXieTiRegular', 'WuXinShouXieTi', 'YOzShouXieTi', 'YouZi'];
$fonts = [
    '851DianJiWenZiTi' => '851電機文字',
    'Bakudai' => '莫大毛筆字體',
    'BoTa' => '波塔',
    'BpmfGenRyuMin-B' => '源流注音明體-粗體',
    'BpmfGenRyuMin-R' => '源流注音明體',
    'BpmfGenSekiGothic-B' => '源石注音黑體-粗體',
    'BpmfGenSekiGothic-R' => '源石注音黑體',
    'BpmfGenSenRounded-B' => '源泉注音圓體-粗體',
    'BpmfGenSenRounded-R' => '源泉注音圓體',
    'BpmfGenWanMin-R' => '源雲注音明體',
    'BpmfGenYoGothic-B' => '源樣注音黑體-粗體',
    'BpmfGenYoGothic-R' => '源樣注音黑體',
    'BpmfGenYoMin-B' => '源樣注音明體-粗體',
    'BpmfGenYoMin-R' => '源樣注音明體',
    'BpmfZihiKaiStd-Regular' => '字嗨注音標楷',
    'BpmfZihiSans-Bold' => '字嗨注音黑體-粗體',
    'BpmfZihiSans-Regular' => '字嗨注音黑體',
    'BpmfZihiSerif-Bold' => '字嗨注音宋體-粗體',
    'BpmfZihiSerif-Regular' => '字嗨注音宋體',
    'Chalk' => '粉筆體',
    'ChaoJiXi' => '超級細ゴシック體',
    'CorpRound' => '公司LOGO圓體',
    'Crayon' => '黑板粉筆體',
    'Cubic' => '俐方體11號',
    'Doudouziti' => '豆豆體',
    'HanWangFangSongMedium' => '王漢宗中仿宋',
    'HanWangHeiHeavy' => '王漢宗特黑體',
    'HanWangHeiLight' => '王漢宗細黑體',
    'HanWangKaiMediumChuIn' => '王漢宗中楷注音',
    'HanWangKanTan' => '王漢宗勘亭流',
    'HanWangLiSuMedium' => '王漢宗中隸書',
    'HanWangMingBlack' => '王漢宗超明體',
    'HanWangWeBe' => '王漢宗魏碑體',
    'HanWangYenHeavy' => '王漢宗特圓體',
    'HanWangYenLight' => '王漢宗細圓體',
    'HanWangZonYi' => '王漢宗綜藝體',
    'HanZiBiShunZiTi' => '漢字筆順體原版',
    'HengShanMaoBiCaoShu' => '衡山毛筆草書',
    'I-Ngaan' => '刻石錄顏體',
    'I-PenCrane-B' => '刻石錄鋼筆鶴體',
    'Iansui' => '芫荽體',
    'JasonHandwriting1' => '清松手寫體1',
    'JasonHandwriting2' => '清松手寫體2',
    'JasonHandwriting3' => '清松手寫體3',
    'JasonHandwriting4' => '清松手寫體4',
    'JfOpenhuninn' => 'jf open 粉圓體',
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
    'SuiFengTi ' => '隨峰體',
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
];

// $bad_fonts = [
//     'ZhanKuQingKeHuangYouTi' => '站酷慶科黃油體',
// ];

// $fonts = $bad_fonts;

ksort($fonts);

if ($font) {

    $bpmfvs = strpos($font, 'Bpmf') !== false ? "| <a href='https://buttaiwan.github.io/bpmfvs/' target='_blank'>選破音字</a>" : '';

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
                    <input type="hidden" name="demo_title" value="' . $demo_title . '">
                    <input type="hidden" name="demo_content" value="' . $demo_content . '">
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>
            </div>
        </form>
    </div>
    <h2><a href="fonts.php">回線上字型一覽</a> ' . $bpmfvs . ' </h2>';
    $data .= "<div style=\"border:1px solid gray; padding: 3rem; font-family: '{$font}'; font-size: {$size}rem;\">
    <h1 style=\"margin-bottom:2rem; font-family: '{$title_font}'; font-size: {$title_size}rem;\">{$demo_title}</h1>
    " . nl2br($demo_content) . "
    </div>
    <form action='fonts.php' method='post' class='mt-3'>

    <input type='text' name='demo_title' value='{$demo_title}' class='form-control my-2'>
    <textarea name='demo_content'class='form-control my-2'>{$demo_content}</textarea>
    <div class='bar'>
        <input type='hidden' name='title_font' value='{$title_font}'>
        <input type='hidden' name='size' value='{$size}'>
        <input type='hidden' name='font' value='{$font}'>
        <button type='submit' class='btn btn-primary'>置換範例內容</button>
    </div>
    </form>
    ";

    echo Utility::html5($data, false, true, '4', true, 'container', $title = '線上字型大量文字預覽', '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/xoops.css">');

} else {

    $title_arr = [];
    if (empty($demo)) {
        $sql = "select `title` from " . $xoopsDB->prefix('newblocks') . "
        where `title` != '' and `visible` = 1";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($title) = $xoopsDB->fetchRow($result)) {
            $title_arr[] = $title;
        }
    }

    $data = "
    <link href='" . XOOPS_URL . "/modules/tadtools/ScrollTable/superTables.css' rel='stylesheet' type='text/css'>
    <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/ScrollTable/superTables.js'></script>
    <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/ScrollTable/jquery.superTable.js'></script>";

    $data .= '
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
    <table id="font_list" class="table table-bordered table-sm">
    <tr>
    <th class="align-middle text-center" nowrap>編號</th>
    <th class="align-middle text-center" nowrap>字型中文名稱</th>
    <th class="align-middle text-center" nowrap>字型英文名稱</th>';

    if (empty($demo)) {
        foreach ($title_arr as $title) {
            $data .= "
            <th class='align-middle text-center' nowrap>$title</th>
            ";
        }
    } else {
        $data .= "
        <th class='align-middle text-center'>語法</th>
        <th class='align-middle text-center'>實際範例</th>
        ";
    }
    $data .= "</tr>";

    $i = 1;
    $url = "https://cdn.jsdelivr.net/gh/tadlearn/webfonts/fonts";
    foreach ($fonts as $font_family => $font_title) {
        $file_name = in_array($font_family, $otf_arr) ? "{$url}/{$font_family}.otf" : "{$url}/{$font_family}.ttf";

        $bpmfvs = strpos($font_family, 'Bpmf') !== false ? "| <a href='https://buttaiwan.github.io/bpmfvs/' target='_blank'>選破音字</a>" : '';
        $data .= "
        <tr>
        <th class='align-middle text-center' nowrap>$i</th>
        <th class='align-middle text-center' nowrap>
        <a href='fonts.php?font={$font_family}'>{$font_title}</a>
        | <a href='{$file_name}'>下載</a>
        $bpmfvs
        </th>
        <td class='align-middle text-center' nowrap><a href='fonts.php?font={$font_family}'>$font_family</a></td>";

        if (empty($demo)) {
            foreach ($title_arr as $title) {
                $data .= "
                <td class='align-middle text-center' nowrap><div style=\"font-family: '{$font_family}'; font-size: {$size}rem;\">$title</div></td>
                ";
            }
        } else {
            $data .= "
            <td class='align-middle'><code>&lt;span style=\"font-family: '{$font_family}'; font-size: {$size}rem;\"&gt;{$demo}&lt;/span&gt;</code></td>
            <td class='align-middle'><div style=\"font-family: '{$font_family}'; font-size: {$size}rem;\">$demo</div></td>
            ";
        }
        $data .= "</tr>";
        $i++;
    }
    $data .= '</table>';

    $data .= "
    <script type='text/javascript'>
        $(document).ready(function(){
            var height = $('#font_list').height();
            if(height > 600){
                height = 600;
            }else{
                height=height+12;
            }
            $('#font_list').toSuperTable({ width: '100%', height: height+'px', fixedCols: 1, headerRows: 1 });
        });
    </script>";

    // $data .= '$fonts = [<br>';
    // foreach ($fonts as $font_family => $font_title) {
    //     $data .= "    '$font_family' => '$font_title',<br>";
    // }
    // $data .= '];';

    echo Utility::html5($data, false, true, '4', true, 'container-fluid', $title = '線上字型一覽', '<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="' . XOOPS_URL . '/modules/tadtools/css/xoops.css">');

}

function remoteFileExists($url)
{
    $curl = curl_init($url);

    //don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, true);

    //do request
    $result = curl_exec($curl);

    $ret = false;

    //if request did not fail
    if ($result !== false) {
        //if request was ok, check response code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($statusCode == 200) {
            $ret = true;
        }
    }

    curl_close($curl);

    return $ret;
}
