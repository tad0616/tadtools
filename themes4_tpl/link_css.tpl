
        <!-- Rss -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<{xoAppUrl backend.php}>">
        <!-- icon -->
        <link href="<{$xoops_url}>/favicon.ico" rel="SHORTCUT ICON">
        <!-- Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoAppUrl xoops.css}>">
        <!-- XOOPS theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{xoImgUrl css/xoops.css}>">
        <!-- <{$theme_color}> -->
<{if $theme_color=="bootstrap4"}>
        <link href="<{xoAppUrl modules/tadtools/bootstrap4/css/bootstrap.css}>" rel="stylesheet" media="all">
<{else}>
        <link href="<{xoAppUrl modules/tadtools/bootstrap4/css/bootstrap.css}>" rel="stylesheet" media="all">
        <link href="<{$xoops_url}>/modules/tadtools/<{$theme_color}>/bootstrap.min.css" rel="stylesheet" media="all">
<{/if}>
        <!-- SmartMenus jQuery Bootstrap Addon CSS -->
        <link href="<{xoAppUrl modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css}>" media="all" rel="stylesheet">
        <!-- font-awesome -->
        <link href="<{xoAppUrl modules/tadtools/css/font-awesome/css/font-awesome.css}>" rel="stylesheet" media="all">
<{if $xoops_themecss}>
        <!-- Theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss}>">
<{/if}>