<div class="row">
    <{if $block.url1}>
        <div class="col-sm-6">
            <div>
                <{$smarty.const._MB_TT_APP_DOWNLOAD}>
            </div>
            <a href="<{$block.url1}>" target="_blank"><img src="https://chart.apis.google.com/chart?cht=qr&chs=<{$block.width}>x<{$block.width}>&chl=<{$block.url1}>&chld=H|0" alt="<{$smarty.const._MB_TT_APP_DOWNLOAD}>" style="max-width:100%;"></a>
        </div>
    <{/if}>
    <{if $block.url2}>
        <div class="col-sm-6">
            <div>
                <{$smarty.const._MB_TT_APP_SETUP}>
            </div>
            <img src="https://chart.apis.google.com/chart?cht=qr&chs=<{$block.width}>x<{$block.width}>&chl=<{$block.url2}>|<{$block.title}>&chld=H|0" alt="<{$smarty.const._MB_TT_APP_SETUP}>" style="max-width:100%;">
        </div>
    <{/if}>
</div>