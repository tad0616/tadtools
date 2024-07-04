<{if $logo_img}>
    <{if $logo_zindex <= $slide_zindex}>
        <{assign var="logo_zindex" value=$slide_zindex+1}>
    <{/if}>
    <a href="<{$xoops_url}>/index.php" style="padding: 0px;"><img id="website_logo" src="<{$logo_img}>" style="<{if $logo_full!='1'}>max-<{/if}>width: 100%;<{if $logo_position=="slide"}>position: absolute; z-index: <{$logo_zindex}>; <{$logo_place}><{else}>position: relative; z-index:10;<{/if}>" alt="<{$xoops_sitename}>" title="<{$xoops_sitename}>" class="img-fluid"></a>
<{else}>
    <a href="<{$xoops_url}>/index.php"><{$xoops_sitename}></a>
<{/if}>
