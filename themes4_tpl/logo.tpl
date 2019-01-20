<{if $logo_img}>
  <a href="<{$xoops_url}>/index.php"><img id="website_logo" src="<{$logo_img}>" style="max-width: 100%;<{if $logo_position=="slide"}>position: absolute; z-index: 500; <{$logo_place}><{else}>position: relative; z-index:10;<{/if}>" alt="<{$xoops_sitename}>" title="<{$xoops_sitename}>" class="img-fluid"></a>
<{else}>
  <a href="<{$xoops_url}>/index.php"><{$xoops_sitename}></a>
<{/if}>
