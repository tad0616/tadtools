<meta charset="<{$xoops_charset}>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<meta name="robots" content="<{$xoops_meta_robots}>" >
<meta name="keywords" content="<{$xoops_meta_keywords}>" >
<meta name="description" content="<{$xoops_meta_description}>" >
<meta name="rating" content="<{$xoops_meta_rating}>" >
<meta name="author" content="<{$xoops_meta_author}>" >
<meta name="copyright" content="<{$xoops_meta_copyright}>" >
<meta name="generator" content="XOOPS" >

<{if $fb_title}>
<meta property="og:title" content="<{$fb_title}>">
<{else}>
<meta property="og:title" content="<{$xoops_sitename}> - <{$xoops_pagetitle}>">
<{/if}>

<meta property="og:type" content="website">

<{php}>
global $xoopsTpl;
$url="http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'];
$xoopsTpl->assign('now_url',$url);
<{/php}>

<{if $now_url}>
<meta property="og:url" content="<{$now_url}>">
<{/if}>

<{if $fb_image}>
<meta property="og:image" content="<{$fb_image}>">
<{elseif $logo_img}>
<meta property="og:image" content="<{$logo_img}>">
<{/if}>


<{if $xoops_sitename}>
<meta property="og:site_name" content="<{$xoops_sitename}>">
<{/if}>

<{if $fb_description}>
<meta property="og:description" content="<{$fb_description}>">
<{/if}>

<{if $fb_id}>
<meta property="fb:app_id" content="<{$fb_id}>">
<{/if}>
