<?php
include_once "tadtools_header.php";

class qrcode{

  //建構函數
  function qrcode(){

  }

  //產生語法
  function render($url,$size=120){
    mk_qrcode($url);
    $imgurl=mk_qrcode_name($url);
    $url=chk_qrcode_url($url);
    $qrcode="
    <div style='text-align:center;'>
    <a href='http://{$_SERVER['HTTP_HOST']}{$url}'>
    <img src='".XOOPS_URL."/uploads/qrcode/{$imgurl}.gif' />
    </a>
    </div>
    ";

    return $qrcode;
  }
}
?>
