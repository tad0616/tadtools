<script type="text/javascript">
    $(document).ready(function(){
        $("#toggle_qrcode_btn").click(function () {
            $("#auto_login_qrcode").toggle();
        });
    });
</script>
<div class="row">
    <div <{if $block.direction=='h'}>class="col-sm-6"<{/if}>>
        <a href="<{$block.url1}>" target="_blank"><img src="<{$xoops_url}>/modules/tadtools/images/app_qrcode.png" alt="<{$smarty.const._MB_TT_APP_DOWNLOAD}>" class="img-fluid img-responsive" style="width:<{$block.width}>px;float:left;margin:0px 6px 6px 0px;"></a>
        <{$smarty.const._MB_TT_APP_DOWNLOAD}>
    </div>
    <div <{if $block.direction=='h'}>class="col-sm-6"<{/if}>>
        <img id="auto_login_qrcode" src="https://api.qrserver.com/v1/create-qr-code/?size=<{$block.width}>x<{$block.width}>&data=<{$block.url2}>|<{$block.title}>|<{$block.token}>" alt="uto login qrcode" class="img-fluid img-responsive" style="float:left;margin:0px 6px 6px 0px;display:none;">
        <{$smarty.const._MB_TT_APP_SETUP}>
    </div>
</div>