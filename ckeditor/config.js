/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    config.pasteFromWordRemoveFontStyles = false;
    config.toolbar = 'my';
    config.toolbar_my =
        [
            { name: 'bar1', items: ['Source'] },
            { name: 'bar2', items: ['Cut', 'Copy', 'Undo', 'Redo'] },
            { name: 'bar3', items: ['Image', 'EqnEditor', 'Table', 'HorizontalRule', 'Smiley', 'Link', 'Unlink'] },
            { name: 'bar4', items: ['NumberedList', 'BulletedList', 'RemoveFormat', 'Syntaxhighlight', 'CodeSnippet'] },
            { name: 'bar5', items: ['Blockquote', 'CreateDiv'] },
            { name: 'bar6', items: ['PageBreak', 'WidgetTemplateMenu', 'Uploadcare'] },
            { name: 'bar7', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'bar7-1', items: ['TextColor', 'BGColor', 'Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'bar8', items: ['Outdent', 'Indent'] },
            { name: 'bar9', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'bar10', items: ['Find', 'Replace', 'SelectAll', 'ckeditorfa'] }
        ];

    //CKEDITOR.config.autoGrow_maxHeight = 450;
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    CKEDITOR.config.entities = false;
    CKEDITOR.config.htmlEncodeOutput = false;
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.baseFloatZIndex = 100001;

    CKEDITOR.config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';

    CKEDITOR.config.syntaxhighlight_hideGutter = [true | false];

    CKEDITOR.config.syntaxhighlight_hideControls = true;
    CKEDITOR.config.syntaxhighlight_collapse = true;
    CKEDITOR.config.syntaxhighlight_showColumns = true;
    CKEDITOR.config.syntaxhighlight_noWrap = false;
    CKEDITOR.config.syntaxhighlight_firstLine = 0;
    CKEDITOR.config.syntaxhighlight_lang = 'PHP';
    CKEDITOR.config.font_names = '851電機文字/851DianJiWenZiTi;莫大毛筆字體/Bakudai;波塔/BoTa;源流注音明體-粗體/BpmfGenRyuMin-B;源流注音明體/BpmfGenRyuMin-R;源石注音黑體-粗體/BpmfGenSekiGothic-B;源石注音黑體/BpmfGenSekiGothic-R;源泉注音圓體-粗體/BpmfGenSenRounded-B;源泉注音圓體/BpmfGenSenRounded-R;源雲注音明體/BpmfGenWanMin-R;源樣注音黑體-粗體/BpmfGenYoGothic-B;源樣注音黑體/BpmfGenYoGothic-R;源樣注音明體-粗體/BpmfGenYoMin-B;源樣注音明體/BpmfGenYoMin-R;字嗨注音標楷/BpmfZihiKaiStd-Regular;字嗨注音黑體-粗體/BpmfZihiSans-Bold;字嗨注音黑體/BpmfZihiSans-Regular;字嗨注音宋體-粗體/BpmfZihiSerif-Bold;字嗨注音宋體/BpmfZihiSerif-Regular;粉筆體/Chalk;超級細ゴシック體/ChaoJiXi;公司LOGO圓體/CorpRound;黑板粉筆體/Crayon;俐方體11號/Cubic;豆豆體/Doudouziti;王漢宗中仿宋/HanWangFangSongMedium;王漢宗特黑體/HanWangHeiHeavy;王漢宗細黑體/HanWangHeiLight;王漢宗中楷注音/HanWangKaiMediumChuIn;王漢宗勘亭流/HanWangKanTan;王漢宗中隸書/HanWangLiSuMedium;王漢宗超明體/HanWangMingBlack;王漢宗魏碑體/HanWangWeBe;王漢宗特圓體/HanWangYenHeavy;王漢宗細圓體/HanWangYenLight;王漢宗綜藝體/HanWangZonYi;漢字筆順體原版/HanZiBiShunZiTi;衡山毛筆草書/HengShanMaoBiCaoShu;刻石錄顏體/I-Ngaan;刻石錄鋼筆鶴體/I-PenCrane-B;芫荽體/Iansui;清松手寫體1/JasonHandwriting1;清松手寫體2/JasonHandwriting2;清松手寫體3/JasonHandwriting3;清松手寫體4/JasonHandwriting4;jf open 粉圓體/JfOpenhuninn;解星 B/KaiseiTokumin;荊南麥圓體/KingnamMaiyuan;苦累蛙圓體/Kurewa;Mamelon字體/Mamelon;Mamelon新版字體/MamelonHi;正風毛筆字體（衡山毛筆行書）/MasaFont;內海字體/NaikaiFont;馬克筆手寫/NishikiTeki;胖胖豬肉體/PangPangZhuRouTi;破碎零號字/PoSuiLingHaoZi;大波浪圓體/PopGothicCjkJp;千圖馬克手寫體/QianTuMaKeShouXieTi;黒薔薇/Qiang;青柳隷書/QingLiuShu;隨峰體/SuiFengTi;獅尾詠腿黑體/SweiFistLegCJKjp;獅尾四季春/SweiSpringSugarCJKtc;獅尾牙膏圓體/SweiToothpasteCJKtc;糖果手寫粗體/TanugoTangGuoShouXieTiBold;糖果手寫體/TanugoTangGuoShouXieTiRegular;たぬき油性マジック/Tanukimagic;鵪鶉字體/UzuraZiTi;無心手寫體/WuXinShouXieTi;賢二體/XianErTi;字體圈欣意冠黑體/XinYiGuanHeiTi;YOz手寫體/YOzShouXieTi;英椎行書/YingZhuiXingShu;佑字/YouZi;源影黑體/YuanYingHeiTi;宅在家粉條甜/ZhaiZaiJiaFenTiaoTian;宅在家麥克筆/ZhaiZaiJiaMaiKeBi;宅在家自動筆/ZhaiZaiJiaZiDongBi;佐佐木字體/ZuoZuoMuZiTi;';

    // config.pasteFromWordRemoveFontStyles = false;
    config.toolbar = 'myBasic';
    config.toolbar_myBasic =
        [
            ['Source', 'Styles', 'Format', 'FontSize', 'TextColor', 'BGColor', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', '-', 'Link', 'Unlink', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Table']
        ];

    config.toolbar = 'tadBasic';
    config.tadBasic =
    [
        ['Source', 'Format', 'FontSize', 'TextColor', 'BGColor', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', '-', 'Link', 'Unlink', '-', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Table', 'Undo', 'Redo']
    ];

    config.toolbar = 'mySimple';
    config.toolbar_mySimple =
        [
            { name: 'bar1', items: ['Source'] },
            { name: 'bar1_1', items: ['Cut', 'Copy', 'Undo', 'Redo'] },
            { name: 'bar1_2', items: ['Image', 'Table', 'HorizontalRule', 'Link', 'Unlink'] },
            { name: 'bar1_3', items: ['NumberedList', 'BulletedList', 'RemoveFormat', '-', 'Outdent', 'Indent'] },
            '/',
            { name: 'bar2', items: ['Styles', 'Format', 'FontSize', 'TextColor', 'BGColor', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] }
        ];

    config.toolbar = 'tadSimple';
    config.toolbar_tadSimple =
        [
            { name: 'bar1', items: ['Image', 'Table', 'EqnEditor', 'Link', 'Unlink'] },
            { name: 'bar2', items: ['FontSize', 'TextColor', 'BGColor', 'Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'bar3', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight'] },
            { name: 'bar4', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', '-', 'RemoveFormat'] },
        ];

    config.codemirror = {

        // Set this to the theme you wish to use (codemirror themes)
        theme: 'default',

        // Whether or not you want to show line numbers
        lineNumbers: true,

        // Whether or not you want to use line wrapping
        lineWrapping: true,

        // Whether or not you want to highlight matching braces
        matchBrackets: true,

        // Whether or not you want to highlight matching tags
        matchTags: true,

        // Whether or not you want tags to automatically close themselves
        autoCloseTags: true,

        // Whether or not you want Brackets to automatically close themselves
        autoCloseBrackets: true,

        // Whether or not to enable search tools, CTRL+F (Find), CTRL+SHIFT+F (Replace), CTRL+SHIFT+R (Replace All), CTRL+G (Find Next), CTRL+SHIFT+G (Find Previous)
        enableSearchTools: true,

        // Whether or not you wish to enable code folding (requires 'lineNumbers' to be set to 'true')
        enableCodeFolding: true,

        // Whether or not to enable code formatting
        enableCodeFormatting: true,

        // Whether or not to automatically format code should be done when the editor is loaded
        autoFormatOnStart: true,

        // Whether or not to automatically format code which has just been uncommented
        autoFormatOnUncomment: true,

        // Whether or not to highlight the currently active line
        highlightActiveLine: true,

        // Whether or not to highlight all matches of current word/selection
        highlightMatches: true,

        // Define the language specific mode 'htmlmixed' for html  including (css, xml, javascript), 'application/x-httpd-php' for php mode including html, or 'text/javascript' for using java script only
        mode: 'htmlmixed',

        // Whether or not to show the search Code button on the toolbar
        showSearchButton: true,

        // Whether or not to show Trailing Spaces
        showTrailingSpace: true,

        // Whether or not to show the format button on the toolbar
        showFormatButton: true,

        // Whether or not to show the comment button on the toolbar
        showCommentButton: true,

        // Whether or not to show the uncomment button on the toolbar
        showUncommentButton: true,

        // Whether or not to show the showAutoCompleteButton button on the toolbar
        showAutoCompleteButton: true
    };
};

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}