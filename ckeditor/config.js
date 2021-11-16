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
            { name: 'bar2', items: ['Cut', 'Copy', 'Paste', 'PasteFromWord', 'Undo', 'Redo'] },
            { name: 'bar3', items: ['Image', 'oembed', 'EqnEditor', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'Link', 'Unlink'] },
            { name: 'bar4', items: ['NumberedList', 'BulletedList', 'RemoveFormat', 'Syntaxhighlight', 'CodeSnippet'] },
            { name: 'bar5', items: ['Blockquote', 'CreateDiv'] },
            { name: 'bar6', items: ['PageBreak', 'WidgetTemplateMenu', 'Uploadcare'] },
            { name: 'bar7', items: ['Styles', 'Format', 'FontSize'] },
            { name: 'bar7-1', items: ['TextColor', 'BGColor', 'Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'bar8', items: ['Outdent', 'Indent'] },
            { name: 'bar9', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'bar10', items: ['Find', 'Replace', 'SelectAll', 'FontAwesome'] }
        ];

    //CKEDITOR.config.autoGrow_maxHeight = 450;
    CKEDITOR.config.entities = false;
    CKEDITOR.config.htmlEncodeOutput = false;
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.oembed_maxWidth = '560';
    CKEDITOR.config.oembed_maxHeight = '315';
    CKEDITOR.config.oembed_WrapperClass = 'embededContent';
    CKEDITOR.config.syntaxhighlight_hideGutter = [true | false];

    CKEDITOR.config.syntaxhighlight_hideControls = true;
    CKEDITOR.config.syntaxhighlight_collapse = true;
    CKEDITOR.config.syntaxhighlight_showColumns = true;
    CKEDITOR.config.syntaxhighlight_noWrap = false;
    CKEDITOR.config.syntaxhighlight_firstLine = 0;
    CKEDITOR.config.syntaxhighlight_lang = 'PHP';

    var bootstrap = getCookie('bootstrap')
    console.log('bootstrap',bootstrap);

    var shadow_h2={ name: '陰影標題h2', element: 'h2', styles: { 'text-shadow': '1px 1px 1px #aaaaaa' } };
    var shadow_h3={ name: '陰影標題h3', element: 'h3', styles: { 'text-shadow': '1px 1px 1px #aaaaaa' } };
    var alert_info = { name: 'Info 提示框', element: 'div', attributes: { 'class': 'alert alert-info' } };
    var alert_success = { name: 'Success 提示框', element: 'div', attributes: { 'class': 'alert alert-success' } };
    var alert_warning = { name: 'Warning 提示框', element: 'div', attributes: { 'class': 'alert alert-warning' } };
    var alert_danger = { name: 'Danger 提示框', element: 'div', attributes: { 'class': 'alert alert-danger' } };
    var img_responsive={ name: '自適應圖片', element: 'img', styles: { 'height': 'auto' }, attributes: { 'class': 'img-responsive img-fluid' } };
    var img_thumbnail={ name: '自適應圖框', element: 'img', styles: { 'height': 'auto' }, attributes: { 'class': 'img-responsive img-thumbnail img-fluid' } };
    var code ={ name: '語法', element: 'code' };
    var kbd ={ name: '按鍵', element: 'kbd' };

    // CKEDITOR.config.stylesSet = 'myStyles';
    if(bootstrap == 3){
        config.stylesSet = [
            // Block-level styles
            shadow_h2,
            shadow_h3,
            alert_info,
            alert_success,
            alert_warning,
            alert_danger,
            // Inline styles
            img_responsive,
            img_thumbnail,
            code,
            kbd,
            { name: 'default 標籤', element: 'span', attributes: { 'class': 'label label-default' } },
            { name: 'Primary 標籤', element: 'span', attributes: { 'class': 'label label-primary' } },
            { name: 'Success 標籤', element: 'span', attributes: { 'class': 'label label-success' } },
            { name: 'Info 標籤', element: 'span', attributes: { 'class': 'label label-info' } },
            { name: 'Warning 標籤', element: 'span', attributes: { 'class': 'label label-warning' } },
            { name: 'Danger 標籤', element: 'span', attributes: { 'class': 'label label-danger' } },
            { name: 'badge 徽章', element: 'span', attributes: { 'class': 'badge' } }
        ];
    } else if(bootstrap == 4){
        config.stylesSet = [
            // Block-level styles
            shadow_h2,
            shadow_h3,
            alert_info,
            alert_success,
            alert_warning,
            alert_danger,
            // Inline styles
            img_responsive,
            img_thumbnail,
            code,
            kbd,
            { name: 'Secondary 徽章', element: 'span', attributes: { 'class': 'badge badge-secondary' } },
            { name: 'Primary 徽章', element: 'span', attributes: { 'class': 'badge badge-primary' } },
            { name: 'Success 徽章', element: 'span', attributes: { 'class': 'badge badge-success' } },
            { name: 'Info 徽章', element: 'span', attributes: { 'class': 'badge badge-info' } },
            { name: 'Warning 徽章', element: 'span', attributes: { 'class': 'badge badge-warning' } },
            { name: 'Danger 徽章', element: 'span', attributes: { 'class': 'badge badge-danger' } },
            { name: 'Light 徽章', element: 'span', attributes: { 'class': 'badge badge-light' } },
            { name: 'Dark 徽章', element: 'span', attributes: { 'class': 'badge badge-dark' } }
        ];
    }else if(bootstrap == 5){
        config.stylesSet = [
            // Block-level styles
            shadow_h2,
            shadow_h3,
            alert_info,
            alert_success,
            alert_warning,
            alert_danger,

            // Inline styles
            img_responsive,
            img_thumbnail,
            code,
            kbd,
            { name: 'Secondary 徽章', element: 'span', attributes: { 'class': 'badge bg-secondary' } },
            { name: 'Primary 徽章', element: 'span', attributes: { 'class': 'badge bg-primary' } },
            { name: 'Success 徽章', element: 'span', attributes: { 'class': 'badge bg-success' } },
            { name: 'Info 徽章', element: 'span', attributes: { 'class': 'badge bg-info' } },
            { name: 'Warning 徽章', element: 'span', attributes: { 'class': 'badge bg-warning' } },
            { name: 'Danger 徽章', element: 'span', attributes: { 'class': 'badge bg-danger' } },
            { name: 'Light 徽章', element: 'span', attributes: { 'class': 'badge bg-light' } },
            { name: 'Dark 徽章', element: 'span', attributes: { 'class': 'badge bg-dark' } }
        ];
    }

    // config.pasteFromWordRemoveFontStyles = false;
    config.toolbar = 'myBasic';
    config.toolbar_myBasic =
        [
            ['Source', 'Format', 'FontSize', 'TextColor', 'BGColor', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', '-', 'Link', 'Unlink', '-', 'PasteText', 'PasteFromWord', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Table', 'Undo', 'Redo']
        ];

    config.toolbar = 'mySimple';
    config.toolbar_mySimple =
        [
            { name: 'bar1', items: ['Source'] },
            { name: 'bar1_1', items: ['Cut', 'Copy', 'Paste', 'PasteFromWord', 'Undo', 'Redo'] },
            { name: 'bar1_2', items: ['Image', 'Table', 'HorizontalRule', 'Link', 'Unlink'] },
            { name: 'bar1_3', items: ['NumberedList', 'BulletedList', 'RemoveFormat', '-', 'Outdent', 'Indent'] },
            '/',
            { name: 'bar2', items: ['Styles', 'Format', 'FontSize', 'TextColor', 'BGColor', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight'] }
        ];

    config.toolbar = 'tadSimple';
    config.toolbar_tadSimple =
        [
            { name: 'bar1', items: ['Image', 'Table', 'oembed', 'EqnEditor', 'Link', 'Unlink'] },
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