<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class CodeMirror
{
    public $id;
    public $mode;
    public $theme;

    //建構函數
    public function __construct($id, $mode = 'htmlmixed', $theme = 'material')
    {
        $this->id = $id;
        $this->mode = $mode;
        $this->theme = $theme;
    }

    //產生語法
    public function render()
    {
        global $xoTheme;
        Utility::get_jquery();
        // $TadToolsModuleConfig = Utility::TadToolsXoopsModuleConfig();

        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/CodeMirror/lib/codemirror.css');
            $xoTheme->addStylesheet('modules/tadtools/CodeMirror/theme/material.css');
            $xoTheme->addStylesheet('modules/tadtools/CodeMirror/addon/display/fullscreen.css');

            $xoTheme->addScript('modules/tadtools/CodeMirror/lib/codemirror.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/mode/javascript/javascript.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/mode/xml/xml.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/mode/css/css.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/mode/htmlmixed/htmlmixed.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/mode/php/php.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/addon/selection/active-line.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/addon/edit/matchbrackets.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/addon/display/fullscreen.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/addon/hint/show-hint.js');
            $xoTheme->addScript('modules/tadtools/CodeMirror/addon/hint/css-hint.js');
            $xoTheme->addStylesheet('modules/tadtools/CodeMirror/addon/hint/show-hint.css');

            $xoTheme->addScript('', null, "
            \$(document).ready(function(){
                var editor = CodeMirror.fromTextArea(document.getElementById('{$this->id}'), {
                    lineNumbers: true,
                    indentUnit: 4,
                    styleActiveLine: true,
                    matchBrackets: true,
                    mode: '{$this->mode}',
                    lineWrapping: true,
                    theme: '{$this->theme}',
                    extraKeys: {
                        Tab: function(cm) {
                            var spaces = Array(cm.getOption('indentUnit') + 1).join(' ');
                            cm.replaceSelection(spaces);
                        },
                        'F11': function(cm) {
                            cm.setOption('fullScreen', !cm.getOption('fullScreen'));
                        },
                        'Esc': function(cm) {
                            if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);
                        },
                        'Ctrl-Space': 'autocomplete'
                    },
                    hintOptions: { hint: 'cssHint' }
                });
                // 啟用 CSS Autocompletion
                // CodeMirror.registerHelper('hint', 'css', CodeMirror.hint.css);
            });");
        } else {
            $CodeMirror = '
            <link href="' . XOOPS_URL . '/modules/tadtools/CodeMirror/lib/codemirror.css" rel="stylesheet" type="text/css">
            <link href="' . XOOPS_URL . '/modules/tadtools/CodeMirror/theme/material.css" rel="stylesheet" type="text/css">
            <link href="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/display/fullscreen.css" rel="stylesheet" type="text/css">
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/lib/codemirror.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/mode/javascript/javascript.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/mode/xml/xml.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/mode/css/css.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/selection/active-line.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/edit/matchbrackets.js"></script>
            <script type="text/javascript" src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/display/fullscreen.js"></script>
            <script src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/hint/show-hint.js" type="text/javascript"></script>
            <script src="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/hint/css-hint.js" type="text/javascript"></script>
            <link rel="stylesheet" href="' . XOOPS_URL . '/modules/tadtools/CodeMirror/addon/hint/show-hint.css">

            <script>
            $(document).ready(function(){
                var editor = CodeMirror.fromTextArea(document.getElementById("' . $this->id . '"), {
                    lineNumbers: true,
                    indentUnit: 4,
                    styleActiveLine: true,
                    matchBrackets: true,
                    mode: "' . $this->mode . '",
                    lineWrapping: true,
                    theme: "' . $this->theme . '",
                    extraKeys: {
                        Tab: function(cm) {
                            var spaces = Array(cm.getOption("indentUnit") + 1).join(" ");
                            cm.replaceSelection(spaces);
                        },
                        "F11": function(cm) {
                            cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                        },
                        "Esc": function(cm) {
                            if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                        },
                        "Ctrl-Space": "autocomplete"
                    },
                    hintOptions: { hint: "cssHint" }
                });
                // 啟用 CSS Autocompletion
                // CodeMirror.registerHelper("hint", "css", CodeMirror.hint.css);
            });
            </script>';
        }

        return $CodeMirror;
    }
}

/*
use XoopsModules\Tadtools\CodeMirror;

$CodeMirror = new CodeMirror('id','php');
$CodeMirror->render();

 */
