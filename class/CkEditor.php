<?php
namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class CkEditor
{
    public $xoopsDirName;
    public $ColName;
    public $CustomConfigurationsPath;
    public $ToolbarSet = 'my';
    public $Width = '100%';
    public $Height = 300;
    public $Value;
    public $ContentsCss = [];
    public $demopublickey = '';
    public $subDir = '';
    public $Style = [];

    //建構函數
    public function __construct($xoopsDirName = '', $ColName = '', $Value = '', $subDir = '')
    {
        $TadToolsModuleConfig = Utility::TadToolsXoopsModuleConfig();
        $this->xoopsDirName = $xoopsDirName;
        $this->ColName = $ColName;
        $this->Value = $Value;
        $this->subDir = $subDir;
        if (!empty($TadToolsModuleConfig['uploadcare_publickey'])) {
            $this->set_demopublickey($TadToolsModuleConfig['uploadcare_publickey']);
        }
    }

    //設定自定義設定檔
    public function setCustomConfigurationsPath($path = '')
    {
        $this->CustomConfigurationsPath = $path;
    }

    //設定自定義工具列
    public function setToolbarSet($ToolbarSet = '')
    {
        $this->ToolbarSet = $ToolbarSet;
    }

    //設定自定義設寬度
    public function setWidth($Width = '')
    {
        $this->Width = $Width;
    }

    //設定自定義設高度
    public function setHeight($Height = '')
    {
        $this->Height = $Height;
    }

    //新增樣式
    public function setContentCss($ContentsCss = '')
    {
        $this->ContentsCss[] = $ContentsCss;
    }

    //新增樣式 stylesSet :
    public function setStyle($name, $element, $attributes = [], $styles = [])
    {
        $Style['name'] = $name;
        $Style['element'] = $element;
        if ($attributes) {
            $Style['attributes'] = $attributes;
        }
        if ($styles) {
            $Style['styles'] = $styles;
        }
        $this->Style[] = $Style;
    }

    private function getStyle()
    {
        $this->setStyle('陰影標題h2', 'h2', [], ['text-shadow' => '1px 1px 1px #aaaaaa']);
        $this->setStyle('陰影標題h3', 'h3', [], ['text-shadow' => '1px 1px 1px #aaaaaa']);
        $this->setStyle('Info 提示框', 'div', ['class' => 'alert alert-info']);
        $this->setStyle('Success 提示框', 'div', ['class' => 'alert alert-success']);
        $this->setStyle('Warning 提示框', 'div', ['class' => 'alert alert-warning']);
        $this->setStyle('Danger 提示框', 'div', ['class' => 'alert alert-danger']);
        $this->setStyle('自適應圖片', 'img', ['class' => 'img-responsive img-fluid'], ['height' => 'auto']);
        $this->setStyle('自適應圖框', 'img', ['class' => 'img-responsive img-thumbnail img-fluid'], ['height' => 'auto']);
        $this->setStyle('語法', 'code');
        $this->setStyle('按鍵', 'kbd');

        $this->setStyle('清單「壹、貳」', 'ol', ['class' => 'big-tw'], []);
        $this->setStyle('清單「一、二」', 'ol', ['class' => 'small-tw'], []);
        $this->setStyle('清單「(一)、(二)」', 'ol', ['class' => 'brackets-tw'], []);
        $this->setStyle('清單「(1)、(2)」', 'ol', ['class' => 'brackets-num'], []);

        $this->setStyle('Secondary 徽章', 'span', ['class' => 'label label-default badge badge-secondary bg-secondary']);
        $this->setStyle('Primary 徽章', 'span', ['class' => 'label label-primary badge badge-primary bg-primary']);
        $this->setStyle('Success 徽章', 'span', ['class' => 'label label-success badge badge-success bg-success']);
        $this->setStyle('Info 徽章', 'span', ['class' => 'label label-info badge badge-info bg-info']);
        $this->setStyle('Warning 徽章', 'span', ['class' => 'label label-warning badge badge-warning bg-warning']);
        $this->setStyle('Danger 徽章', 'span', ['class' => 'label label-danger badge badge-danger bg-danger']);
        $this->setStyle('Light 徽章', 'span', ['class' => 'label label-default badge badge-light bg-light']);
        $this->setStyle('Dark 徽章', 'span', ['class' => 'label label-default badge badge-dark bg-dark']);

        $defStyle = json_encode($this->Style, 256);
        return str_replace('"', "'", "stylesSet : {$defStyle},");
    }

    public function set_demopublickey($demopublickey = '')
    {
        $this->demopublickey = $demopublickey;
    }

    //產生編輯器
    public function render()
    {
        global $xoTheme, $TadToolsModuleConfig;

        Utility::get_jquery();
        $_SESSION['xoops_mod_name'] = $this->xoopsDirName;

        $stylesSet = $this->getStyle();
        // die($stylesSet);
        // before being fed to the textarea of CKEditor
        $content = str_replace('&', '&amp;', $this->Value);
        $content = str_replace('[', '&#91;', $content);

        if ($xoTheme) {
            $editor = '';
            $xoTheme->addScript('modules/tadtools/ckeditor/ckeditor.js');
        } else {
            $editor = "
            <script type='text/javascript' src='" . XOOPS_URL . "/modules/tadtools/ckeditor/ckeditor.js'></script>";
        }

        $other_css = '';
        if ($this->ContentsCss) {
            $other_css = ",'" . implode("','", $this->ContentsCss) . "'";
        }

        $demopublickey_js = $extra_uploadcare = $uploadcare_setup = '';
        if ($this->demopublickey) {
            $demopublickey_js = "UPLOADCARE_PUBLIC_KEY = '{$this->demopublickey}',";
            $extra_uploadcare = ',uploadcare';
            $uploadcare_setup = '
                uploadcare: {
                    multiple: true
                },';
        }

        $TadToolsModuleConfig = Utility::TadToolsXoopsModuleConfig();
        $codemirror = $TadToolsModuleConfig['use_codemirror'] ? ',codemirror' : '';

        $bs = $_SESSION['bootstrap'] ? $_SESSION['bootstrap'] : 4;
        $editor .= "
        <textarea name='{$this->ColName}' id='editor_{$this->ColName}' class='ckeditor_css'>{$content}</textarea>

        <script type='text/javascript'>
            {$demopublickey_js}
            CKEDITOR.replace('editor_{$this->ColName}' , {
            skin : 'moono' ,
            width : '{$this->Width}' ,
            height : '{$this->Height}' ,
            language : '" . _LANGCODE . "' ,
            toolbar : '{$this->ToolbarSet}' ,
            $stylesSet
            contentsCss : ['" . XOOPS_URL . "/modules/tadtools/bootstrap{$bs}/css/bootstrap.css', '" . XOOPS_URL . "/modules/tadtools/css/fonts.css', '" . XOOPS_URL . "/modules/tadtools/css/ckeditor.css', '" . XOOPS_URL . "/modules/tadtools/css/font-awesome/css/font-awesome.css'{$other_css}],
            extraPlugins: 'font,syntaxhighlight,dialog,oembed,eqneditor,quicktable,imagerotate,fakeobjects,widget,lineutils,widgetbootstrap,widgettemplatemenu,pagebreak,fontawesome,prism,codesnippet{$codemirror}{$extra_uploadcare}',
            {$uploadcare_setup}
            filebrowserBrowseUrl : '" . XOOPS_URL . '/modules/tadtools/elFinder/elfinder.php?type=file&subDir=' . $this->subDir . '&mod_dir=' . $this->xoopsDirName . "',
            filebrowserImageBrowseUrl : '" . XOOPS_URL . '/modules/tadtools/elFinder/elfinder.php?type=image&subDir=' . $this->subDir . '&mod_dir=' . $this->xoopsDirName . "',
            filebrowserFlashBrowseUrl : '" . XOOPS_URL . '/modules/tadtools/elFinder/elfinder.php?type=flash&subDir=' . $this->subDir . '&mod_dir=' . $this->xoopsDirName . "',
            qtRows: 10, // Count of rows
            qtColumns: 10, // Count of columns
            qtBorder: '1', // Border of inserted table
            qtWidth: '100%', // Width of inserted table
            qtStyle: { 'border-collapse' : 'collapse' },
            qtClass: 'table table-bordered table-hover table-condensed table-sm', // Class of table
            qtCellPadding: '0', // Cell padding table
            qtCellSpacing: '0', // Cell spacing table
            qtPreviewBorder: '1px double black', // preview table border
            qtPreviewSize: '15px', // Preview table cell size
            qtPreviewBackground: '#c8def4' // preview table background (hover)
            } );
        </script>
        <script>CKEDITOR.dtd.\$removeEmpty['span'] = false;</script>
            ";

        return $editor;
    }
}

/*
use XoopsModules\Tadtools\CkEditor;
$CkEditor=new CkEditor("tadnews","news_content",$news_content);
$CkEditor->setHeight(350);
$editor=$CkEditor->render();
 */
