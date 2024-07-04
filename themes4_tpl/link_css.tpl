
        <!-- Rss -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<{$xoops_url}>/backend.php">
        <!-- icon -->
        <link href="<{$xoops_url}>/favicon.ico" rel="SHORTCUT ICON">
        <!-- Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/xoops.css">
        <!-- XOOPS theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/themes/<{$theme_name}>/css/xoops.css">
        <!-- 44-1 <{$theme_color}> -->
<{if $theme_color and $theme_color!="bootstrap4"}>
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap4/css/bootstrap.css" rel="stylesheet" media="all">
        <{if $theme_color}>
        <!-- 44-2 <{$theme_color}> -->
        <link href="<{$xoops_url}>/modules/tadtools/<{$theme_color}>/bootstrap.min.css" rel="stylesheet" media="all">
        <{/if}>
<{else}>
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap4/css/bootstrap.css" rel="stylesheet" media="all">
<{/if}>

        <!-- SmartMenus jQuery Bootstrap Addon CSS -->
        <link href="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css" media="all" rel="stylesheet">
        <!-- font-awesome -->
        <link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet" media="all">
<{if $xoops_themecss}>
        <!-- Theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss}>">
<{/if}>