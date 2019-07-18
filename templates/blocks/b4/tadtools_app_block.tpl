<{if $block.url1}>
    <{$smarty.const._MB_TT_APP_DOWNLOAD}>
    <div class="text-center">
        <a href="<{$block.url1}>" target="_blank"><img src="https://chart.apis.google.com/chart?cht=qr&chs=<{$block.width}>x<{$block.width}>&chl=<{$block.url1}>&chld=H|0" alt="<{$smarty.const._MB_TT_APP_DOWNLOAD}>" style="max-width:100%;"></a>
    </div>
<{/if}>
<{if $block.url2}>
    <{$smarty.const._MB_TT_APP_SETUP}>
    <div class="text-center">
        <img src="https://chart.apis.google.com/chart?cht=qr&chs=<{$block.width}>x<{$block.width}>&chl=<{$block.url2}>|<{$block.title}>&chld=H|0" alt="<{$smarty.const._MB_TT_APP_SETUP}>" style="max-width:100%;">
    </div>
<!--
    <div class="text-center">
        json:
        <img src="https://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<{$block.json}>&chld=H|0" alt="<{$smarty.const._MB_TT_APP_SETUP}>" style="max-width:100%;">
        <{$block.json}>
    </div> -->
<{/if}>