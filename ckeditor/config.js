/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.pasteFromWordRemoveFontStyles = false;
    config.toolbar = 'my';
    config.toolbar_my =
    [
      { name: 'bar1', items : ['Source'] },
      { name: 'bar2', items : ['Cut','Copy','Paste','PasteFromWord','Undo','Redo'] },
      { name: 'bar3', items : ['Image','oembed','EqnEditor','jwplayer','Flash','Table','HorizontalRule','Smiley','Link','Unlink'] },
      { name: 'bar4', items : ['NumberedList','BulletedList','RemoveFormat','Syntaxhighlight'] },
      { name: 'bar5', items : ['Blockquote', 'CreateDiv'] },
      { name: 'bar6', items : ['PageBreak','WidgetTemplateMenu','Uploadcare'] },
      { name: 'bar7', items : ['Styles','Format','FontSize'] },
      { name: 'bar7-1', items : ['TextColor','BGColor','Bold','Italic','Underline','Strike'] },
      { name: 'bar8', items : ['Outdent','Indent'] },
      { name: 'bar9', items : ['JustifyLeft','JustifyCenter','JustifyRight', 'JustifyBlock'] },
      { name: 'bar10', items : ['Find', 'Replace',  'SelectAll','FontAwesome'] }
    ];

    //CKEDITOR.config.autoGrow_maxHeight = 450;
    CKEDITOR.config.entities = false;
    CKEDITOR.config.htmlEncodeOutput = false;
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.config.oembed_maxWidth = '560';
    CKEDITOR.config.oembed_maxHeight = '315';
    CKEDITOR.config.oembed_WrapperClass = 'embededContent';
    CKEDITOR.config.syntaxhighlight_hideGutter = [true|false];

    CKEDITOR.config.syntaxhighlight_hideControls = true;
    CKEDITOR.config.syntaxhighlight_collapse = true;
    CKEDITOR.config.syntaxhighlight_showColumns = true;
    CKEDITOR.config.syntaxhighlight_noWrap = false;
    CKEDITOR.config.syntaxhighlight_firstLine =0;
    CKEDITOR.config.syntaxhighlight_lang = 'PHP';


    // CKEDITOR.config.stylesSet = 'myStyles';
    config.stylesSet= [
        // Block-level styles
        { name: '陰影標題h2', element: 'h2', styles: { 'text-shadow': '1px 1px 1px #aaaaaa' } },
        { name: '陰影標題h3' , element: 'h3', styles: { 'text-shadow': '1px 1px 1px #aaaaaa' } },
        { name: 'well 圓角框', element: 'div', attributes: { 'class': 'well' } },
        { name: 'Info 提示框', element: 'div', attributes: { 'class': 'alert alert-info' } },
        { name: 'Success 提示框', element: 'div', attributes: { 'class': 'alert alert-success' } },
        { name: 'Warning 提示框', element: 'div', attributes: { 'class': 'alert alert-warning' } },
        { name: 'Danger 提示框', element: 'div', attributes: { 'class': 'alert alert-danger' } },

        // Inline styles
        { name: '自適應圖片', element: 'img', styles: {'height': 'auto'}, attributes: { 'class': 'img-responsive' } },
        { name: '自適應圖框', element: 'img', styles: {'height': 'auto'}, attributes: { 'class': 'img-responsive img-thumbnail' } },
        { name: '語法', element: 'code'},
        { name: '按鍵', element: 'kbd'},
        { name: 'Default 標籤', element: 'span', attributes: { 'class': 'label label-default' } },
        { name: 'Primary 標籤', element: 'span', attributes: { 'class': 'label label-primary' } },
        { name: 'Success 標籤', element: 'span', attributes: { 'class': 'label label-success' } },
        { name: 'Info 標籤', element: 'span', attributes: { 'class': 'label label-info' } },
        { name: 'Warning 標籤', element: 'span', attributes: { 'class': 'label label-warning' } },
        { name: 'Danger 標籤', element: 'span', attributes: { 'class': 'label label-danger' } }
    ] ;


    // config.pasteFromWordRemoveFontStyles = false;
    config.toolbar = 'myBasic';
    config.toolbar_myBasic =
    [
        ['Source','Format','FontSize','TextColor','BGColor','Bold', 'Italic', '-', 'NumberedList', 'BulletedList','Outdent','Indent', '-', 'Link', 'Unlink','-','PasteText','PasteFromWord', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-','Table','Undo','Redo']
    ];

    config.toolbar = 'mySimple';
    config.toolbar_mySimple =
    [
      { name: 'bar1', items : ['Source'] },
      { name: 'bar1_1', items : ['Cut','Copy','Paste','PasteFromWord','Undo','Redo'] },
      { name: 'bar1_2', items : ['Image','Table','HorizontalRule','Link','Unlink']},
      { name: 'bar1_3', items : ['NumberedList','BulletedList','RemoveFormat','-','Outdent','Indent'] },
      '/',
      { name: 'bar2', items : [ 'Styles','Format','FontSize','TextColor','BGColor','Bold','Italic','Underline','Strike','-','JustifyLeft','JustifyCenter','JustifyRight'] }
    ];



    config.toolbar = 'tadSimple';
    config.toolbar_tadSimple =
    [
      { name: 'bar1', items : ['Image','Table','oembed','EqnEditor','Link','Unlink']},
      { name: 'bar2', items : ['FontSize','TextColor','BGColor','Bold','Italic','Underline','Strike']},
      { name: 'bar3', items : ['JustifyLeft','JustifyCenter','JustifyRight']},
      { name: 'bar4', items : ['NumberedList','BulletedList'] },
      { name: 'bar5', items : ['Outdent','Indent']},
      { name: 'bar6', items : ['RemoveFormat']}
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