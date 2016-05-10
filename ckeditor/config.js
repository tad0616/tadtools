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
      { name: 'bar1_1', items : ['Cut','Copy','Paste','PasteFromWord','Undo','Redo'] },
      { name: 'bar1_2', items : ['Image','oembed','EqnEditor','jwplayer','Flash','Table','HorizontalRule','Smiley','Link','Unlink'] },
      { name: 'bar1_3', items : ['NumberedList','BulletedList','RemoveFormat','Syntaxhighlight','-', 'Blockquote', 'CreateDiv','-','PageBreak','WidgetTemplateMenu','Uploadcare'] },
      '/',
      { name: 'bar2', items : [ 'Styles','Format','FontSize','TextColor','BGColor','Bold','Italic','Underline','Strike'] },
      { name: 'bar2_1', items : [ 'JustifyLeft','JustifyCenter','JustifyRight', 'JustifyBlock','Outdent','Indent'] },
      { name: 'bar2_2', items : [ 'Find', 'Replace', '-', 'SelectAll','FontAwesome'] },
      { name: 'bar2_3', items : [ ] }
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
};