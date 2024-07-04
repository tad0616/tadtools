<link rel="stylesheet" type="text/css" media="all" title="Style sheet" href="<{$xoops_url}>/modules/tadtools/css/vertical_menu.css">
<ul class="vertical_menu">
    <{if $xoops_isadmin|default:false}>
        <li>
            <a href="<{$xoops_url}>/admin.php" title="<{$block.lang_adminmenu}>">
                <i class="fa fa-wrench"></i>
                <{$block.lang_adminmenu}>
            </a>
        </li>

        <li>
            <a href="<{$xoops_url}>/user.php" title="<{$block.lang_youraccount}>">
                <i class="fa fa-user"></i>
                <{$block.lang_youraccount}>
            </a>
        </li>
    <{else}>
        <li>
            <a class="menuTop" href="<{$xoops_url}>/user.php" title="<{$block.lang_youraccount}>">
                <i class="fa fa-user"></i>
                <{$block.lang_youraccount}>
            </a>
        </li>
    <{/if}>

    <li>
        <a href="<{$xoops_url}>/edituser.php" title="<{$block.lang_editaccount}>">
            <i class="fa fa-pencil"></i>
            <{$block.lang_editaccount}>
        </a>
    </li>

    <li>
        <a href="<{$xoops_url}>/notifications.php" title="<{$block.lang_notifications}>">
            <i class="fa fa-bell"></i>
            <{$block.lang_notifications}>
        </a>
    </li>

    <{if $block.new_messages > 0}>
        <li>
            <a class="selected" href="<{$xoops_url}>/viewpmsg.php" title="<{$block.lang_inbox}>">
                <i class="fa fa-envelope"></i>
                <{$block.lang_inbox}>
                <i class="badge pull-right"><strong><{$block.new_messages}></strong></i>
            </a>
        </li>
    <{else}>
        <li>
            <a href="<{$xoops_url}>/viewpmsg.php" title="<{$block.lang_inbox}>">
                <i class="fa fa-envelope"></i>
                <{$block.lang_inbox}>
            </a>
        </li>
    <{/if}>

    <li>
        <a href="<{$xoops_url}>/user.php?op=logout" title="<{$block.lang_logout}>">
            <i class="fa fa-sign-out"></i>
            <{$block.lang_logout}>
        </a>
    </li>
</ul>
