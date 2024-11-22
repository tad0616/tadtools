
        <!-- Rss -->
        <link rel="alternate" type="application/rss+xml" title="RSS" href="<{$xoops_url}>/backend.php">
        <!-- icon -->
        <link href="<{$xoops_url}>/favicon.ico" rel="SHORTCUT ICON">
        <!-- Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/xoops.css">
        <!-- XOOPS theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/themes/<{$theme_name|default:''}>/css/xoops.css">
        <link href="<{$xoops_url}>/modules/tadtools/bootstrap5/css/bootstrap.css" rel="stylesheet" media="all">
        <!-- theme_color= <{$theme_color|default:''}> -->
<{if $theme_color|default:false and $theme_color!="bootstrap5"}>
        <link href="<{$xoops_url}>/modules/tadtools/<{$theme_color|default:''}>/bootstrap.min.css" rel="stylesheet" media="all">
<{/if}>

        <!-- SmartMenus core CSS (required) -->
        <link href="<{$xoops_url}>/modules/tadtools/smartmenus/css/sm-core-css.css" media="all" rel="stylesheet">
        <!-- "sm-blue" menu theme (optional, you can use your own CSS, too) -->
        <{* <link href='<{$xoops_url}>/modules/tadtools/smartmenus/css/sm-mint/sm-mint.css' rel='stylesheet' type='text/css' /> *}>
<{if $xoops_themecss!=''}>
        <!-- Theme Sheet Css -->
        <link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss|default:''}>">
<{/if}>
