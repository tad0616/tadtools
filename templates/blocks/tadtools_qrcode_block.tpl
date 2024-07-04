<div class="text-center">
    <{*<img src="https://chart.apis.google.com/chart?cht=qr&chs=<{$block.width}>x<{$block.width}>&chl=<{$block.url}>&chld=H|0" alt="<{$block.url}>" style="max-width:100%;">*}>

    <img src="https://api.qrserver.com/v1/create-qr-code/?size=<{$block.width}>x<{$block.width}>&data=<{$block.url}>" alt="<{$block.url}>" style="max-width:100%;">
  </div>