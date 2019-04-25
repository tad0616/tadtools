<?php
/*
$home['sn']=$home_sn;
$home['title']=$home_title;
$home['url']=$home_url;

$sql = "select csn,of_csn,title from ".$xoopsDB->prefix("tad_gallery_cate")." order by sort";
$result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
while(list($csn,$of_csn,$title)=$xoopsDB->fetchRow($result)){
$title_arr[$csn]=$title;
$cate_arr[$csn]=$of_csn;
$url_arr[$csn]="cate.php?csn={$csn}";
}
if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/dtree.php")){
redirect_header("index.php",3, _MA_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH."/modules/tadtools/dtree.php";
$dtree=new dtree("album_tree","",$title_arr,$cate_arr,$url_arr);
$dtree_code=$dtree->render("11pt",true);
$xoopsTpl->assign('dtree_code',$dtree_code);

 */
// include_once 'tadtools_header.php';

class dtree
{
    public $name;
    public $title_arr;
    public $cate_arr;
    public $url_arr;
    public $home;

    //�غc���
    public function __construct($name = '', $home = '', $title_arr = '', $cate_arr = '', $url_arr = '')
    {
        $this->name = $name;
        $this->title_opt = $title_arr;
        $this->cate_opt = $cate_arr;
        $this->url_opt = $url_arr;
        $this->home = $home;
    }

    //���Ϳ��
    public function render($fontsize = '12px', $open = false, $useLines = true)
    {
        global $xoTheme;

        if ($xoTheme) {
            $dtree = '';
            $xoTheme->addStylesheet('modules/tadtools/dtree/dtree.css');
            $xoTheme->addScript('modules/tadtools/dtree/dtree.js');
        } else {
            $dtree = "
              <link rel='StyleSheet' href='" . TADTOOLS_URL . "/dtree/dtree.css' type='text/css' />
              <script type='text/javascript' src='" . TADTOOLS_URL . "/dtree/dtree.js'></script>";
        }

        if (empty($this->home)) {
            $opt = "{$this->name}.add(0,-1,'','javascript: void(0);');\n";
        } else {
            $opt = "{$this->name}.add({$this->home['sn']},-1,'{$this->home['title']}','{$this->home['url']}');\n";
        }

        if ('' == $open or null === $open) {
            $open = false;
        }

        foreach ($this->title_opt as $ncsn => $title) {
            $opt .= "{$this->name}.add($ncsn , {$this->cate_opt[$ncsn]} , '{$title}' , '{$this->url_opt[$ncsn]}', null, null, null, null, '$open');\n";
        }

        $dtree .= "
        <style>
          .dtree {
            font-size: {$fontsize};
          }
        </style>

        <div id='tree_{$this->name}'></div>
        <script type='text/javascript' defer='defer'>
          {$this->name} = new dTree('{$this->name}', '" . TADTOOLS_URL . "/dtree');
          {$this->name}.config.useCookies=true;
          {$this->name}.config.useLines=$useLines;

          {$opt}
          document.getElementById('tree_{$this->name}').innerHTML={$this->name};
        </script>

        <a href='javascript: {$this->name}.openAll();' style='font-size:11px;'>" . _TAD_EXPAND_ALL . "</a> | <a href='javascript: {$this->name}.closeAll();' style='font-size:11px;'>" . _TAD_CONTACT_ALL . '</a>
        ';

        return $dtree;
    }
}
