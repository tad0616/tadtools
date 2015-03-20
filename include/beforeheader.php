<?php
//自動判斷該載入哪個樣板檔
function set_bootstrap($tpl="",$b3="_b3"){
  global $xoopsConfig,$xoopsDB,$xoTheme,$xoopsOption,$xoopsModule;

  $tpl=empty($tpl)?$xoopsOption['template_main']:$tpl;

  $new_tpl=str_replace(".html", "{$b3}.html", $tpl);
  if(file_exists(XOOPS_ROOT_PATH.'/modules/'.$xoopsModule->getVar("dirname") .'/templates/'.$new_tpl)){
    $sql="select `tt_use_bootstrap`,`tt_bootstrap_color`,`tt_theme_kind` from `".$xoopsDB->prefix("tadtools_setup")."`  where `tt_theme`='{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
    list($tt_use_bootstrap,$tt_bootstrap_color,$tt_theme_kind)=$xoopsDB->fetchRow($result);

    //$tt_use_bootstrap==1 表示該佈景沒有內建 bootstrap，需引入 bootstrap的意思
    if($tt_bootstrap_color=="bootstrap3"){
      $tpl=$new_tpl;
    }else{
      $c=explode('/',$tt_bootstrap_color);
      if($c[0]=="bootstrap3"){
        $tpl=$new_tpl;
      }
    }
  }
  return $tpl;
}
?>