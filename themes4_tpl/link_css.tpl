
        <!-- Rss -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<{$xoops_url}>/backend.php">
        <!-- icon -->
        <link href="<{$xoops_url}>/favicon.ico" rel="SHORTCUT ICON">
        <!-- Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/xoops.css">
        <!-- XOOPS theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/themes/<{$theme_name|default:''}>/css/xoops.css">
        <!-- 44-1 <{$theme_color|default:''}> -->
<{if $theme_color and $theme_color!="bootstrap4"}>
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap4/css/bootstrap.css" rel="stylesheet" media="all">
        <{if $theme_color|default:false}>
        <!-- 44-2 <{$theme_color|default:''}> -->
        <link href="<{$xoops_url}>/modules/tadtools/<{$theme_color|default:''}>/bootstrap.min.css" rel="stylesheet" media="all">
        <{/if}>
<{else}>
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap4/css/bootstrap.css" rel="stylesheet" media="all">
<{/if}>

        <!-- SmartMenus jQuery Bootstrap Addon CSS -->
        <link href="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css" media="all" rel="stylesheet">
<{if $xoops_themecss|default:false}>
        <!-- Theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss|default:''}>">
<{/if}>