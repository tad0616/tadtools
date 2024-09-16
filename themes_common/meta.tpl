<meta charset="<{$xoops_charset}>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <{if $nocache|default:false}>
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <{/if}>

        <meta name="robots" content="<{$xoops_meta_robots}>">
        <meta name="keywords" content="<{$xoops_meta_keywords}>">
        <meta name="description" content="<{$xoops_meta_description}>">
        <meta name="rating" content="<{$xoops_meta_rating}>">
        <meta name="author" content="<{$xoops_meta_author}>">
        <meta name="copyright" content="<{$xoops_meta_copyright}>">
        <meta name="generator" content="XOOPS">
<{if $fb_title|default:false}>
        <meta property="og:title" content="<{$fb_title}>">
<{else}>
        <meta property="og:title" content="<{$xoops_sitename}><{if $xoops_pagetitle|default:false}> - <{$xoops_pagetitle}><{/if}>">
<{/if}>
        <meta property="og:type" content="website">

<{if $now_url|default:false}>
        <meta property="og:url" content="<{$now_url}>">
<{/if}>
<{if $fb_image|default:false}>
        <meta property="og:image" content="<{$fb_image}>">
<{elseif $og_image|default:false}>
        <meta property="og:image" content="<{$og_image}>">
<{elseif $logo_img|default:false}>
        <meta property="og:image" content="<{$logo_img}>">
<{/if}>
<{if $xoops_sitename|default:false}>
        <meta property="og:site_name" content="<{$xoops_sitename}>">
<{/if}>
<{if $fb_description|default:false}>
        <meta property="og:description" content="<{$fb_description}>">
<{/if}>
<{if $fb_id|default:false}>
        <meta property="fb:app_id" content="<{$fb_id}>">
<{/if}>
