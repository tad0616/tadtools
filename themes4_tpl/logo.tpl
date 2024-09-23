<{if $logo_img|substr:-3=="swf"}>
    <object
    type="application/x-shockwave-flash"
    data="<{$logo_img|default:''}>"
    width="400"
    height="100"
    wmode="transparent">
    <param name="movie"
    value="<{$logo_img|default:''}>" width="400" height="100" name="wmode" value="transparent">
    </object>
<{elseif $logo_img}>
    <a href="<{$xoops_url}>/index.php"><img id="website_logo" src="<{$logo_img|default:''}>" style="max-width: 100%;<{if $logo_position=="slide"}>position: absolute; z-index: 5; <{$logo_place|default:''}><{else}>position: relative; z-index:10;<{/if}>" alt="<{$xoops_sitename|default:''}>" title="<{$xoops_sitename|default:''}>" class="img-fluid"></a>
<{else}>
    <a href="<{$xoops_url}>/index.php"><{$xoops_sitename|default:''}></a>
<{/if}>
