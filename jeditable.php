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
  function setTextAreaCol($selector,$file,$width='100%',$height='12px',$submitdata="",$tooltip=""){
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
    if(is_array($this->cols)){
      $all_col=implode("\n",$this->cols);
    }
    $jquery=($this->show_jquery)?get_jquery():"";

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
?>
