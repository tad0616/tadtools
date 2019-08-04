<div class="row">
    <div <{if $block.direction=='h'}>class="col-sm-6"<{/if}>>
        <a href="<{$block.url1}>" target="_blank"><img src="<{$xoops_url}>/modules/tadtools/images/app_qrcode.png" alt="<{$smarty.const._MB_TT_APP_DOWNLOAD}>" class="img-responsive " style="width:<{$block.width}>px;float:left;margin:0px 6px 6px 0px;"></a>
        <{$smarty.const._MB_TT_APP_DOWNLOAD}>
    </div>
    <div <{if $block.direction=='h'}>class="col-sm-6"<{/if}>>
        <img src="https://chart.apis.google.com/chart?cht=qr&chs=<{$block.width}>x<{$block.width}>&chl=<{$block.url2}>|<{$block.title}>&chld=H|0" alt="<{$smarty.const._MB_TT_APP_SETUP}>"  class="img-fluid" style="float:left;margin:0px 6px 6px 0px;">
        <{$smarty.const._MB_TT_APP_SETUP}>
    </div>
</div>