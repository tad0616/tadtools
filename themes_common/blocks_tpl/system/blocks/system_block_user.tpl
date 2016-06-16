<div class="panel panel-success">
  <div class="panel-heading"><{$smarty.const._TAD_TF_MYMENU}></div>

  <!-- List group -->
  <ul class="list-group">
    <{if $xoops_isadmin}>
        <li class="list-group-item">
            <a href="<{xoAppUrl admin.php}>" title="<{$block.lang_adminmenu}>">
                <span class="glyphicon glyphicon-wrench"></span>
                <{$block.lang_adminmenu}>
            </a>
        </li>

        <li class="list-group-item">
            <a href="<{xoAppUrl user.php}>" title="<{$block.lang_youraccount}>">
                <span class="glyphicon glyphicon-user"></span>
                <{$block.lang_youraccount}>
            </a>
        </li>
    <{else}>
        <li class="list-group-item">
            <a class="menuTop" href="<{xoAppUrl user.php}>" title="<{$block.lang_youraccount}>">
                <span class="glyphicon glyphicon-user"></span>
                <{$block.lang_youraccount}>
            </a>
        </li>
    <{/if}>

    <li class="list-group-item">
        <a href="<{xoAppUrl edituser.php}>" title="<{$block.lang_editaccount}>">
            <span class="glyphicon glyphicon-pencil"></span>
            <{$block.lang_editaccount}>
        </a>
    </li>

    <li class="list-group-item">
        <a href="<{xoAppUrl notifications.php}>" title="<{$block.lang_notifications}>">
            <span class="glyphicon glyphicon-info-sign"></span>
            <{$block.lang_notifications}>
        </a>
    </li>

    <{if $block.new_messages > 0}>
        <li class="list-group-item">
            <a class="info" href="<{xoAppUrl viewpmsg.php}>" title="<{$block.lang_inbox}>">
                <span class="glyphicon glyphicon-envelope"></span>
                <{$block.lang_inbox}>
                <span class="badge pull-right"><strong><{$block.new_messages}></strong></span>
            </a>
        </li>
    <{else}>
        <li class="list-group-item">
            <a href="<{xoAppUrl viewpmsg.php}>" title="<{$block.lang_inbox}>">
                <span class="glyphicon glyphicon-envelope"></span>
                <{$block.lang_inbox}>
            </a>
        </li>
    <{/if}>

    <li class="list-group-item">
        <a href="<{xoAppUrl user.php?op=logout}>" title="<{$block.lang_logout}>">
            <span class="glyphicon glyphicon-off"></span>
            <{$block.lang_logout}>
        </a>
    </li>
  </ul>
</div>




