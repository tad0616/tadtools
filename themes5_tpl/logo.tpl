<{if $logo_img|default:false}>
    <{if $logo_zindex <= $slide_zindex}>
        <{assign var="logo_zindex" value=$slide_zindex+1}>
    <{/if}>

    <a href="<{$xoops_url}>/index.php"
       class="logo-link"
       style="<{if $logo_position=="slide"}>position: absolute; z-index: <{$logo_zindex|default:''}>; <{$logo_place|default:''}><{else}>position: relative; z-index: 10;<{/if}>"
    ><img id="website_logo"
          src="<{$logo_img|default:''}>"
          style="<{if $logo_full!='1'}>max-<{/if}>width: 100%; display: block;"
          alt="<{$xoops_sitename|default:''}>"
          title="點擊可回首頁"
          class="img-fluid"></a>
<{else}>
    <a href="<{$xoops_url}>/index.php"
       class="logo-link"
       title="點擊可回首頁"><{$xoops_sitename|default:''}></a>
<{/if}>

<style>
/* 讓 logo 連結本身具備可見的焦點框，避免只在左側顯示 */
.logo-link {
    display: inline-block;
    max-width: 100%;
    vertical-align: middle;
    text-decoration: none;
}

.logo-link img {
    display: block;
    max-width: 100%;
    height: auto;
}

/* 鍵盤使用者可清楚看見目前焦點落在 logo 區塊 */
.logo-link:focus,
.logo-link:focus-visible {
    outline: 3px solid #005FCC !important;
    outline-offset: 3px;
    box-shadow: 0 0 0 3px #ffffff, 0 0 0 6px #005FCC !important;
    border-radius: 4px;
}

/* 滑鼠點擊時不顯示焦點框 */
.logo-link:focus:not(:focus-visible) {
    outline: none !important;
    box-shadow: none !important;
}
</style>