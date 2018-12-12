<ul class="sub-menu">
  <{if $xoops_isadmin}>
    <li>
      <a href="<{$xoops_url}>/admin.php">
        <span class="fa fa-lock"></span>
        <{$smarty.const.TF_USER_ADMIN}>
      </a>
    </li>

    <li>
      <a href="<{$xoops_url}>/modules/system/admin.php?fct=preferences&op=show&confcat_id=1" title="<{$smarty.const.TF_SYSTEM_CONFIG}>">
        <span class="fa fa-cog"></span>
        <{$smarty.const.TF_SYSTEM_CONFIG}>
      </a>
    </li>

    <li>
      <a href="<{$xoops_url}>/modules/tad_adm/admin/main.php" title="<{$smarty.const.TF_SYSTEM_MODADM}>">
        <span class="fa fa-wrench"></span>
        <{$smarty.const.TF_SYSTEM_MODADM}>
      </a>
    </li>

    <li>
      <a href="<{$xoops_url}>/modules/tad_adm/pma.php" title="<{$smarty.const.TF_SYSTEM_DBADM}>" target="_blank">
        <span class="fa fa-database"></span>
        <{$smarty.const._TAD_TF_SYSTEM_DBADM}>
      </a>
    </li>

    <{if $mid}>
      <li>
        <a href="<{$xoops_url}>/modules/tad_themes/admin/main.php">
          <span class="fa fa-list-alt"></span>
          <{$smarty.const.TF_THEME_ADMIN}>
        </a>
      </li>
    <{/if}>

    <li>
      <a href="<{$xoops_url}>/modules/tadtools/themes_common/tools/debug.php?op=debug&v=<{$debug}>">
        <span class="fa fa-warning"></span>
        <{if $debug=='1'}>
          <{$smarty.const.TF_THEME_DEBUG}>
        <{else}>
          <{$smarty.const.TF_THEME_UNDEBUG}>
        <{/if}>
      </a>
    </li>

    <li>
      <a href="<{$xoops_url}>/modules/system/admin.php?fct=blocksadmin&op=list&filter=1&selgen=-1&selmod=-2&selgrp=-1&selvis=1">
        <span class="fa fa-th"></span>
        <{$smarty.const.TF_USER_BLOCK}>
      </a>
    </li>
    <li class="divider"></li>
  <{/if}>

  <li>
    <{xoInboxCount assign=pmcount}>
    <a href="<{$xoops_url}>/viewpmsg.php">
      <span class="fa fa-envelope"></span>
      <{if $pmcount}>
        <{$smarty.const.TF_USER_NEWMSG}>
      <{else}>
        <{$smarty.const.TF_USER_MSG}>
      <{/if}>
    </a>
  </li>

  <li>
    <a href="<{$xoops_url}>/notifications.php">
      <span class="fa fa-bell"></span>
      <{$smarty.const.TF_USER_NOTICE}>
    </a>
  </li>
  <li>
    <a href="<{$xoops_url}>/user.php">
      <span class="fa fa-user"></span>
      <{$smarty.const.TF_USER_PROFILE}>
    </a>
  </li>
  <li>
    <a href="<{$xoops_url}>/user.php?op=logout">
      <span class="fa fa-share"></span>
      <{$smarty.const.TF_USER_EXIT}>
    </a>
  </li>
</ul>