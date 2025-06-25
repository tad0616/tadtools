<{*
<{if isset($ng_web) && !empty($ng_web)}>
    <link rel="stylesheet" href="https://campus-xoops.tn.edu.tw/modules/tad_modules/class/jquery.toast/jquery.toast.min.css">
    <script src="https://campus-xoops.tn.edu.tw/modules/tad_modules/class/jquery.toast/jquery.toast.min.js"></script>
    <style>
        .jq-toast-wrap{
            width: 300px;
        }
        .jq-toast-single{
            font-size: 1.1rem;
            line-height: 1.5;
        }
    </style>
    <script>
        $(document).ready(function(){
        $.toast({
            text: "<a href='https://schoolweb.tn.edu.tw/modules/tn_xoops/old.php' target='_blank' style='font-family: unset; color:#ffffff; font-size:1em; font-weight: normal; text-decoration: none;'>貴校尚有 <{$ng_web|@count}> 個網站未完成升級，請於2025/04/27(一)前完成升級。詳情請參閱：未完成升級名單</a>",
            icon: 'warning',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 50000,
            stack: 5,
            position: 'bottom-center',
            textAlign: 'left',
            loader: true,
            loaderBg: '#7f0303',
            bgColor: '#511111',
            textColor: '#ffffff',
        });
    });
    </script>
<{/if}>
*}>

<{*
    移除本檔，以及以下檔案
    themes3_tpl\my_js.tpl
    themes4_tpl\my_js.tpl
    themes5_tpl\my_js.tpl
    preloads\core.php 41~45
    \themes\school2022\tpl\my_js.tpl
*}>