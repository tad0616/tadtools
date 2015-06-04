<?php
include_once "tadtools_header.php";

class FCKEditor264
{
    public $xoopsDirName;
    public $ColName;
    public $CustomConfigurationsPath;
    public $ToolbarSet = "my";
    public $Width      = '100%';
    public $Height     = 300;
    public $Value;

    //建構函數
    public function FCKEditor264($xoopsDirName = "", $ColName = "", $Value = "")
    {
        $this->xoopsDirName = $xoopsDirName;
        $this->ColName      = $ColName;
        $this->Value        = $Value;
    }

    //設定自定義設定檔
    public function setCustomConfigurationsPath($path = "")
    {
        $this->CustomConfigurationsPath = $path;
    }

    //設定自定義工具列
    public function setToolbarSet($ToolbarSet = "")
    {
        $this->ToolbarSet = $ToolbarSet;
    }

    //設定自定義設寬度
    public function setWidth($Width = "")
    {
        $this->Width = $Width;
    }

    //設定自定義設高度
    public function setHeight($Height = "")
    {
        $this->Height = $Height;
    }

    //產生編輯器
    public function render()
    {
        global $xoTheme;
        $_SESSION['xoops_mod_name'] = $this->xoopsDirName;

        // before being fed to the textarea of CKEditor
        $content = str_replace('&', '&amp;', $this->Value);
        $content = str_replace('[', '&#91;', $content);

        if ($xoTheme) {
            $editor = "";
            $xoTheme->addStylesheet('modules/tadtools/ckeditor/mathquill.css');
            $xoTheme->addScript('modules/tadtools/ckeditor/mathquill.js');
            $xoTheme->addScript('modules/tadtools/ckeditor/ckeditor.js');
        } else {
            $editor = "
      <link rel='stylesheet' type='text/css' href='" . TADTOOLS_URL . "/ckeditor/mathquill.css' />
      <script src='" . TADTOOLS_URL . "/ckeditor/mathquill.js'></script>
      <script type='text/javascript' src='" . TADTOOLS_URL . "/ckeditor/ckeditor.js'></script>";
        }

        $bootstrap = $_SESSION['bootstrap'] == 3 ? "bootstrap3" : "bootstrap";

        $editor .= "
      <textarea name='{$this->ColName}' style='width:{$this->Width};height:{$this->Height};' id='editor_{$this->ColName}' class='ckeditor_css'>{$content}</textarea>

      <script type='text/javascript'>
      CKEDITOR.replace('editor_{$this->ColName}' , {
        skin : 'moono' ,
        language : '" . _LANGCODE . "' ,
        toolbar : '{$this->ToolbarSet}' ,
        contentsCss : ['" . TADTOOLS_URL . "/{$bootstrap}/css/bootstrap.css'],
        extraPlugins: 'autogrow,syntaxhighlight,summary,oembed,mathedit',
        filebrowserBrowseUrl : '" . TADTOOLS_URL . "/elFinder/elfinder.php?type=file',
        filebrowserImageBrowseUrl : '" . TADTOOLS_URL . "/elFinder/elfinder.php?type=image',
        filebrowserFlashBrowseUrl : '" . TADTOOLS_URL . "/elFinder/elfinder.php?type=flash',
        filebrowserUploadUrl : '" . TADTOOLS_URL . "/upload.php?type=file',
        filebrowserImageUploadUrl : '" . TADTOOLS_URL . "/upload.php?type=image',
        filebrowserFlashUploadUrl : '" . TADTOOLS_URL . "/upload.php?type=flash'
      } );
      </script>
      ";
        return $editor;
    }

}
