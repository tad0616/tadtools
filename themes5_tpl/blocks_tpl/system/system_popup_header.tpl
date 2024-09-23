<!doctype html>
<html lang="<{$xoops_langcode|default:''}>">
<head>
    <meta charset="<{$xoops_charset|default:''}>">
    <meta name="robots" content="noindex, nofollow" />
    <title><{$xoops_sitename|escape:'html':'UTF-8'}></title>
    <{section name=item loop=$headItems}>
    <{$headItems[item]}>
    <{/section}>
    <link rel="stylesheet" type="text/css" href="<{$themeUrl|default:''}>css/reset.css">
    <link rel="stylesheet" type="text/css" href="<{$themeUrl|default:''}>css/xoops.css">
    <link rel="stylesheet" type="text/css" href="<{$themeUrl|default:''}>css/bootstrap.min.css">
    <script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>
    <script src="<{$themeUrl|default:''}>js/bootstrap.min.js"></script>

    <{if $closeHead|default:false}>
</head>
<body id="xswatch-popup-body">
<{/if}>
