<{if $user_ownpage == true}>

    <button type="button" class="btn btn-primary" onclick="location='edituser.php'"><{$lang_editprofile}></button>
    <button type="button" class="btn btn-success" onclick="location='edituser.php?op=avatarform'"><{$lang_avatar}></button>
    <button type="button" class="btn btn-info" onclick="location='viewpmsg.php'"><{$lang_inbox}></button>

    <{if $user_candelete == true}>
        <button type="button" class="btn btn-warning" onclick="location='user.php?op=delete'"><{$lang_deleteaccount}></button>
    <{/if}>

    <button type="button" class="btn btn-danger" onclick="location='user.php?op=logout'"><{$lang_logout}></button>


<{elseif $xoops_isadmin != false}>
    <button type="button" class="btn btn-default"
    onclick="location='<{$xoops_url}>/modules/system/admin.php?fct=users&amp;uid=<{$user_uid}>&amp;op=modifyUser'"><{$lang_editprofile}></button>
    <button type="button" class="btn btn-default"
    onclick="location='<{$xoops_url}>/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=<{$user_uid}>'"><{$lang_deleteaccount}></button>
<{/if}>

<{if $user_avatarurl|default:false}>
    <div class="text-center"><img src="<{$user_avatarurl}>" alt="Avatar" class="img-circle"></div>
<{/if}>

<{if $user_realname|default:false}>
    <h2 class="text-center"><{$user_realname}></h2>
<{/if}>

<h3><{$lang_allaboutuser}></h3>

<div class="list-group">
    <{if $user_websiteurl|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_website}></h4>
        <p class="list-group-item-text"><{$user_websiteurl}></p>
      </div>
    <{/if}>

    <{if $user_email|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_email}></h4>
        <p class="list-group-item-text"><{$user_email}></p>
      </div>
    <{/if}>

    <{if !$user_ownpage == true}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_privmsg}></h4>
        <p class="list-group-item-text"><{$user_pmlink}></p>
      </div>
    <{/if}>

    <{if $user_icq|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_icq}></h4>
        <p class="list-group-item-text"><{$user_icq}></p>
      </div>
    <{/if}>

    <{if $user_aim|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_aim}></h4>
        <p class="list-group-item-text"><{$user_aim}></p>
      </div>
    <{/if}>

    <{if $user_yim|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_yim}></h4>
        <p class="list-group-item-text"><{$user_yim}></p>
      </div>
    <{/if}>

    <{if $user_msnm|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_msnm}></h4>
        <p class="list-group-item-text"><{$user_msnm}></p>
      </div>
    <{/if}>

    <{if $user_location|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_location}></h4>
        <p class="list-group-item-text"><{$user_location}></p>
      </div>
    <{/if}>

    <{if $user_occupation|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_occupation}></h4>
        <p class="list-group-item-text"><{$user_occupation}></p>
      </div>
    <{/if}>

    <{if $user_interest|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_interest}></h4>
        <p class="list-group-item-text"><{$user_interest}></p>
      </div>
    <{/if}>

    <{if $user_extrainfo|default:false}>
      <div class="list-group-item">
        <h4 class="list-group-item-heading"><{$lang_extrainfo}></h4>
        <p class="list-group-item-text"><{$user_extrainfo}></p>
      </div>
    <{/if}>
</div>

<h2><{$lang_statistics}></h2>

<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_membersince}></h4>
    <p class="list-group-item-text"><{$user_joindate}></p>
  </div>
</div>

<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_rank}></h4>
    <p class="list-group-item-text"><{$user_rankimage}> <{$user_ranktitle}></p>
  </div>
</div>


<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_posts}></h4>
    <p class="list-group-item-text"><{$user_posts}></p>
  </div>
</div>



<div class="list-group">
  <div class="list-group-item">
    <h4 class="list-group-item-heading"><{$lang_lastlogin}></h4>
    <p class="list-group-item-text"><{$user_lastlogin}></p>
  </div>
</div>


<{if $user_signature|default:false}>
    <h2><{$lang_signature}></h2>
    <div class="alert alert-info"><{$user_signature}></div>
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
