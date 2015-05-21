<?php
include_once "tadtools_header.php";
include_once "jquery.php";


class jeditable{
  var $cols;
  var $show_jquery;

	//建構函數
	function jeditable($show_jquery=true){
    $this->show_jquery=$show_jquery;
	}

  //設定文字欄位 $submitdata="{'sn':$the_sn}
  function setTextCol($selector,$file,$width='100%',$height='12px',$submitdata="",$tooltip=""){
    $submitdata_set=(empty($submitdata))?"":"submitdata:$submitdata,";
    $this->cols[]="
    $('$selector').editable('$file', {
      type : 'text',
      indicator : 'Saving...',
      width: '$width',
      height: '$height',
      $submitdata_set
      onblur:'submit',
      event: 'click',
      placeholder : '{$tooltip}'
    });";
  }

  //設定大量文字欄位 $submitdata="{'sn':$the_sn}
  function setTextAreaCol($selector,$file,$width='100%',$height='50px',$submitdata="",$tooltip=""){
    $submitdata_set=(empty($submitdata))?"":"submitdata:$submitdata,";
    $this->cols[]="
    $('$selector').editable('$file', {
      type : 'textarea',
      indicator : 'Saving...',
      width: '$width',
      height: '$height',
      $submitdata_set
      onblur:'submit',
      event: 'click',
      placeholder : '{$tooltip}'
    });";
  }

  //設定下拉欄位 $submitdata="{'sn':$the_sn},$data="{'男生':'男生' , '女生':'女生'}";
  function setSelectCol($selector,$file,$data='',$submitdata="",$tooltip=""){
    $submitdata_set=(empty($submitdata))?"":"submitdata:$submitdata,";
    $this->cols[]="
    $('$selector').editable('$file', {
      type : 'select',
      indicator : 'Saving...',
      data   : \"{$data}\",
      $submitdata_set
      onblur:'submit',
      event: 'click',
      placeholder : '{$tooltip}'
    });";
  }


	//產生路徑工具
	function render(){
    global $xoTheme;

    if(is_array($this->cols)){
      $all_col=implode("\n",$this->cols);
    }
    $jquery=($this->show_jquery)?get_jquery():"";

    if($xoTheme){
      $xoTheme->addScript('modules/tadtools/jeditable/jquery.jeditable.mini.js');

      $xoTheme->addScript('', null, "
        (function(\$){
          \$(document).ready(function(){
            {$all_col}
          });
        })(jQuery);
      ");
    }else{

      $main="
      $jquery
      <script src='".TADTOOLS_URL."/jeditable/jquery.jeditable.mini.js' type='text/javascript' language='JavaScript'></script>
      <script type='text/javascript'>
       $(document).ready(function()
       {
         $all_col
       })
      </script>";
      return $main;
    }
  }
}



/*
include_once XOOPS_ROOT_PATH."/modules/tadtools/jeditable.php";
$file="save.php";
$jeditable = new jeditable();
$jeditable->setTextCol("#candidate_note",$file,'140px','12px',"{'vote_sn':$vote_sn,'candidate_id':'$candidate_id','op' : 'save'}","編輯備註");
$jeditable->setTextAreaCol("#id",$file,'140px','12px',"{'sn':$sn,'op' : 'save'}","點擊編輯");
$jeditable->setSelectCol("#id",$file,"{'boy':'男生' , 'girl':'女生' , 'selected':'girl'}","{'sn' : $sn , 'op' : 'save'}","點擊編輯");
$jeditable_set=$jeditable->render();

<?php
include "header.php";
$sql="update ".$xoopsDB->prefix("vote_candidate")." set `candidate_note`='{$_POST['value']}' where vote_sn='{$_POST['vote_sn']}' and candidate_id='{$_POST['candidate_id']}'";
$xoopsDB->queryF($sql);
echo $_POST['value'];
?>

 */
?>
