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
      { name: 'bar1_2', items : ['Image','oembed','mathedit','jwplayer','Flash','Table','HorizontalRule','Smiley','Link','Unlink'] },
      { name: 'bar1_3', items : ['NumberedList','BulletedList','summary','RemoveFormat','Syntaxhighlight'] },
      '/',
      { name: 'bar2', items : [ 'Format','FontSize','TextColor','BGColor','Bold','Italic','Underline','Strike'] },
      { name: 'bar2_1', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','Outdent','Indent'] }
    ];
    CKEDITOR.config.autoGrow_maxHeight = 500;
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


    config.pasteFromWordRemoveFontStyles = false;
    config.toolbar = 'myBasic';
    config.toolbar_myBasic =
    [
        ['Source','Format','FontSize','TextColor','BGColor','Bold', 'Italic', '-', 'NumberedList', 'BulletedList','Outdent','Indent', '-', 'Link', 'Unlink','-','PasteText','PasteFromWord', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-','Table','Undo','Redo']
    ];
    CKEDITOR.config.autoGrow_maxHeight = 500;
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
};