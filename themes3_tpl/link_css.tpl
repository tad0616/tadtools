
        <!-- Rss -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<{$xoops_url}>/backend.php">
        <!-- icon -->
        <link href="<{$xoops_url}>/favicon.ico" rel="SHORTCUT ICON">
        <!-- Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/xoops.css">
        <!-- XOOPS theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/themes/<{$theme_name|default:''}>/css/xoops.css">
        <!-- 33-1 <{$theme_color|default:''}> -->
<{if $theme_color and $theme_color!="bootstrap3"}>
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap3/css/bootstrap.css" rel="stylesheet" media="all">
        <{if $theme_color|default:false}>
        <!-- 33-2 <{$theme_color|default:''}> -->
        <link href="<{$xoops_url}>/modules/tadtools/<{$theme_color|default:''}>/bootstrap.min.css" rel="stylesheet" media="all">
        <{/if}>
<{else}>
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap3/css/bootstrap.css" rel="stylesheet" media="all">
<{/if}>
        <!-- SmartMenus jQuery Bootstrap Addon CSS -->
        <link href="<{$xoops_url}>/modules/tadtools/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css" media="all" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- font-awesome -->
<{if $xoops_themecss|default:false}>
        <!-- Theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss|default:''}>">
<{/if}>