<{if $user_ownpage == true}>

    <button type="button" class="btn btn-primary" onclick="location='edituser.php'"><{$lang_editprofile|default:''}></button>
    <button type="button" class="btn btn-success" onclick="location='edituser.php?op=avatarform'"><{$lang_avatar|default:''}></button>
    <button type="button" class="btn btn-info" onclick="location='viewpmsg.php'"><{$lang_inbox|default:''}></button>

    <{if $user_candelete == true}>
        <button type="button" class="btn btn-warning" onclick="location='user.php?op=delete'"><{$lang_deleteaccount|default:''}></button>
    <{/if}>

    <button type="button" class="btn btn-danger" onclick="location='user.php?op=logout'"><{$lang_logout|default:''}></button>


<{elseif $xoops_isadmin != false}>
    <button type="button" class="btn btn-default"
    onclick="location='<{$xoops_url}>/modules/system/admin.php?fct=users&amp;uid=<{$user_uid|default:''}>&amp;op=modifyUser'"><{$lang_editprofile|default:''}></button>
    <button type="button" class="btn btn-default"
    onclick="location='<{$xoops_url}>/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=<{$user_uid|default:''}>'"><{$lang_deleteaccount|default:''}></button>
<{/if}>

<{if $user_avatarurl|default:false}>
    <div class="text-center"><img src="<{$user_avatarurl|default:''}>" alt="Avatar" class="img-circle"></div>
<{/if}>

<{if $user_realname|default:false}>
    <h2 class="text-center"><{$user_realname|default:''}></h2>
<{/if}>

<h3><{$lang_allaboutuser|default:''}></h3>

<div class="list-group">
    <{if $user_websiteurl|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_website|default:''}></h4>
        <p class="list-group-item-text"><{$user_websiteurl|default:''}></p>
      </div>
    <{/if}>

    <{if $user_email|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_email|default:''}></h4>
        <p class="list-group-item-text"><{$user_email|default:''}></p>
      </div>
    <{/if}>

    <{if !$user_ownpage == true}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_privmsg|default:''}></h4>
        <p class="list-group-item-text"><{$user_pmlink|default:''}></p>
      </div>
    <{/if}>

    <{if $user_icq|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_icq|default:''}></h4>
        <p class="list-group-item-text"><{$user_icq|default:''}></p>
      </div>
    <{/if}>

    <{if $user_aim|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_aim|default:''}></h4>
        <p class="list-group-item-text"><{$user_aim|default:''}></p>
      </div>
    <{/if}>

    <{if $user_yim|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_yim|default:''}></h4>
        <p class="list-group-item-text"><{$user_yim|default:''}></p>
      </div>
    <{/if}>

    <{if $user_msnm|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_msnm|default:''}></h4>
        <p class="list-group-item-text"><{$user_msnm|default:''}></p>
      </div>
    <{/if}>

    <{if $user_location|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_location|default:''}></h4>
        <p class="list-group-item-text"><{$user_location|default:''}></p>
      </div>
    <{/if}>

    <{if $user_occupation|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_occupation|default:''}></h4>
        <p class="list-group-item-text"><{$user_occupation|default:''}></p>
      </div>
    <{/if}>

    <{if $user_interest|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_interest|default:''}></h4>
        <p class="list-group-item-text"><{$user_interest|default:''}></p>
      </div>
    <{/if}>

    <{if $user_extrainfo|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_extrainfo|default:''}></h4>
        <p class="list-group-item-text"><{$user_extrainfo|default:''}></p>
      </div>
    <{/if}>
</div>

<h2><{$lang_statistics|default:''}></h2>

<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_membersince|default:''}></h4>
    <p class="list-group-item-text"><{$user_joindate|default:''}></p>
  </div>
</div>

<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_rank|default:''}></h4>
    <p class="list-group-item-text"><{$user_rankimage|default:''}> <{$user_ranktitle|default:''}></p>
  </div>
</div>


<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_posts|default:''}></h4>
    <p class="list-group-item-text"><{$user_posts|default:''}></p>
  </div>
</div>



<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_lastlogin|default:''}></h4>
    <p class="list-group-item-text"><{$user_lastlogin|default:''}></p>
  </div>
</div>


<{if $user_signature|default:false}>
    <h2><{$lang_signature|default:''}></h2>
    <div class="alert alert-info"><{$user_signature|default:''}></div>
<{/if}>


<!-- start module search results loop -->
<{foreach item=module from=$modules}>
    <br class="clear">
    <h4><{$module.name}></h4>
    <!-- start results item loop -->
    <{foreach item=result from=$module.results}>
        <img src="<{$result.image}>" alt="<{$module.name}>">
        <strong><a href="<{$result.link}>" title="<{$result.title}>"><{$result.title}></a></strong>
        <br>
		<span class="x-small">(<{$result.time|default:''}>)</span>
		<br>
    <{/foreach}>
    <!-- end results item loop -->

    <{$module.showall_link}>


<{/foreach}>
<!-- end module search results loop -->
