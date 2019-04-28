<?php
// require_once __DIR__ . '/tadtools_header.php';

class summernote
{
    public $ColName;
    public $Value;
    public $Height = 300;

    //建構函數
    public function __construct($ColName = '', $Value = '')
    {
        $this->ColName = $ColName;
        $this->Value = $Value;
    }

    //設定自定義設高度
    public function setHeight($Height = '')
    {
        $this->Height = $Height;
    }

    //產生編輯器
    public function render()
    {
        global $xoTheme;
        $editor = '';
        if ($xoTheme) {
            $xoTheme->addStylesheet('modules/tadtools/summernote/summernote.css');
            $xoTheme->addScript('modules/tadtools/summernote/summernote.min.js');
            $xoTheme->addScript('modules/tadtools/summernote/summernote-"._LANGCODE.".js');
            $xoTheme->addScript('', null, "
        (function(\$){
          \$(document).ready(function(){
            \$('#editor_{$this->ColName}').summernote({
              height: '{$this->Height}' ,
              lang: '" . _LANGCODE . "'
            });
          });
        })(jQuery);
      ");
        } else {
            $editor = "
      <link href='" . XOOPS_URL . "/modules/tadtools/summernote/summernote.css' rel='stylesheet'>
      <script src='" . XOOPS_URL . "/modules/tadtools/summernote/summernote.min.js'></script>
      <script src='" . XOOPS_URL . '/modules/tadtools/summernote/summernote-' . _LANGCODE . ".js'></script>
      <script>
      $(document).ready(function() {
        $('#editor_{$this->ColName}').summernote({
          height: '{$this->Height}' ,
          lang: '" . _LANGCODE . "'
        });
      });
      </script>
      ";
        }

        $content = str_replace('&', '&amp;', $this->Value);
        $content = str_replace('[', '&#91;', $content);
        $editor .= "<textarea name='{$this->ColName}' id='editor_{$this->ColName}'>{$content}</textarea>";

        return $editor;
    }
}
