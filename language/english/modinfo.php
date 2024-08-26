<?php

require_once __DIR__ . '/modinfo_common.php';

define('_MI_TADTOOLS_ADMENU1', 'Bootstrap setup');
define('_MI_TADTOOLS_ADMENU1_DESC', 'Bootstrap setup');

define('_MI_TADTOOLS_NAME', 'Tad Tools Framework');
define('_MI_TADTOOLS_DESC', 'Tad Tools is a set of common code used by Tad Modules.');

define('_MI_TADTOOLS_TITLE4', 'Pin Navbar to top?');
define('_MI_TADTOOLS_DESC4', 'If "Yes", Navbar will stick on top.');
define('_MI_TADTOOLS_TITLE5', 'Auto change charset of download URL?');
define('_MI_TADTOOLS_DESC5', 'Only for Chinese file names.');

define('_MI_TADTOOLS_TITLE6', 'SyntaxHighlighter theme?');
define('_MI_TADTOOLS_DESC6', 'Setup SyntaxHighlighter theme.');

define('_MI_TADTOOLS_TITLE7', 'SyntaxHighlighter version');
define('_MI_TADTOOLS_DESC7', 'SyntaxHighlighter2.x or SyntaxHighlighter3.x');

define('_MI_TADTOOLS_TITLE8', 'uploadcare public key');
define('_MI_TADTOOLS_DESC8', 'Please login <a href="https://uploadcare.com/" target="_blank">https://uploadcare.com/</a> and create a project to get public key.');

define('_MI_TADTOOLS_QRCODE_BLOCK_NAME', 'This page QR Code');
define('_MI_TADTOOLS_QRCODE_BLOCK_DESC', 'This page QR Code block (tadtools_qrcode)');
define('_MI_TADTOOLS_APP_BLOCK_NAME', 'This site App download settings');
define('_MI_TADTOOLS_APP_BLOCK_DESC', 'This site App download settings block (tadtools_app)');

define('_MI_TADTOOLS_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADTOOLS_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADTOOLS_BACK_2_ADMIN', 'Back to Administration of ');

//help
define('_MI_TADTOOLS_HELP_OVERVIEW', 'Overview');

define('_MI_TADTOOLS_USE_CODEMIRROR', 'Do you use codemirror plugin?');
define('_MI_TADTOOLS_USE_CODEMIRROR_DESC', 'If you often use syntaxhighlighter paste the original code, it is recommended to close.');

define('_MI_TADTOOLS_IMAGE_MAX_WIDTH', 'The maximum width of the image uploaded by the CKeditor');
define('_MI_TADTOOLS_IMAGE_MAX_WIDTH_DESC', 'Please fill in the number, the unit is px');
define('_MI_TADTOOLS_IMAGE_MAX_HEIGHT', 'The maximum height of the image uploaded by the CKeditor');
define('_MI_TADTOOLS_IMAGE_MAX_HEIGHT_DESC', 'Please fill in the number, the unit is px');
define('_MI_TADTOOLS_MIME_TYPE_CHECK', 'Do you need to perform MIME TYPE check of the file when uploading the file');
define('_MI_TADTOOLS_MIME_TYPE_CHECK_DESC', 'This check is to avoid fake files. If the file cannot be uploaded, you can cancel this check and try');

define('_MI_TADTOOLS_INSERT_SPACING', 'Automatically add spaces between Chinese and English');
define('_MI_TADTOOLS_INSERT_SPACING_DESC', 'Automatically add spaces between Chinese and English when displaying articles to avoid conversion errors when converting URLs to links (but if there is a mix of Chinese and English in the URL, it may not be downloaded)');
define('_MI_TADTOOLS_LINKIFY', 'Convert URL to link');
define('_MI_TADTOOLS_LINKIFY_DESC', 'Automatically convert URLs from internal text to links');
define('_MI_TADTOOLS_PDF_FORCE_DL', 'Does PDF file force download?');
define('_MI_TADTOOLS_PDF_FORCE_DL_DESC', "To comply with Accessibility 2.1, please select 'Yes', if you want to preview directly online please select 'No'");

define('_MI_TADTOOLS_TEST_MODE', 'Is the development test mode open to administrators only?');
define('_MI_TADTOOLS_TEST_MODE_DESC', 'It is recommended to select "Yes", this option is not used by normal users, only developers will use it.');

define('_MI_TADTOOLS_FACEBOOK_APP_ID', 'Is the development test mode open to administrators only?');
define('_MI_TADTOOLS_FACEBOOK_APP_ID_DESC', 'Is the development test mode open to administrators only?');
