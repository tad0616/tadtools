<?php
use XoopsModules\Tadtools\Utility;

class qrcode
{
    //建構函數
    public function __construct()
    {
    }

    //產生語法
    public function render($url, $size = 120)
    {
        Utility::mk_qrcode($url);
        $imgurl = Utility::mk_qrcode_name($url);
        $url = Utility::chk_qrcode_url($url);

        $protocol = ($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $qrcode = "
        <div style='text-align:center;'>
        <a href='{$protocol}{$_SERVER['HTTP_HOST']}{$url}'>
        <img src='" . XOOPS_URL . "/uploads/qrcode/{$imgurl}.gif'>
        </a>
        </div>
        ";

        return $qrcode;
    }
}
