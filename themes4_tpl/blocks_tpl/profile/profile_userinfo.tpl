<{include file="db:profile_breadcrumbs.tpl"}>
<div class="row">
<div class="col-sm-6 col-md-6 aligncenter">
<{if $avatar|default:false}>
        <img src="<{$avatar|default:''}>" alt="<{$uname|default:''}>" class="img-fluid rounded img-thumbnail">
<{/if}>
    <div class="aligncenter">
    <ul class="list-unstyled">
        <li><span class="badge badge-info"><{$uname|default:''}></span></li>
        <{if $email|default:false}>
            <li><span class="badge badge-info"><{$email|default:''}></span></li>
        <{/if}>
	</ul>
    </div><!-- .aligncenter -->
</div><!-- .col-md-6 .aligncenter -->

<div class="col-sm-6 col-md-6">
<{if !$user_ownpage && $xoops_isuser == true}>
    <form name="usernav" action="user.php" method="post">
        <input class="btn btn-success" type="button" value="<{$smarty.const._PROFILE_MA_SENDPM}>" onclick="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$user_uid|default:''}>', 'pmlite', 450, 380);">
    </form>
<{/if}>

<{if $user_ownpage == true}>

    <form name="usernav" action="user.php" method="post">
        <input class="btn btn-success btn-sm btn-block" type="button" value="<{$lang_editprofile|default:''}>" onclick="location='<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/edituser.php'">
        <input class="btn btn-success btn-sm btn-block" type="button" value="<{$lang_changepassword|default:''}>" onclick="location='<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/changepass.php'">
        <{if $user_changeemail|default:false}>
		<input class="btn btn-success btn-sm btn-block" type="button" value="<{$smarty.const._PROFILE_MA_CHANGEMAIL}>" onclick="location='<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/changemail.php'">
        <{/if}>

        <{if $user_candelete == true}>
        <form method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/user.php">
            <input  type="hidden" name="op" value="delete">
            <input type="hidden" name="uid" value="<{$user_uid|default:''}>">
            <input class="btn btn-success btn-sm btn-block" type="button" value="<{$lang_deleteaccount|default:''}>" onclick="submit();">
        </form>
        <{/if}>

        <input class="btn btn-success btn-sm btn-block" type="button" value="<{$lang_avatar|default:''}>" onclick="location='edituser.php?op=avatarform'">
        <input class="btn btn-success btn-sm btn-block" type="button" value="<{$lang_inbox|default:''}>" onclick="location='<{$xoops_url}>/viewpmsg.php'">
        <input class="btn btn-success btn-sm btn-block" type="button" value="<{$lang_logout|default:''}>" onclick="location='<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/user.php?op=logout'">
    </form>

<{elseif $xoops_isadmin != false}>
    <form method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/deactivate.php">
        <input class="btn btn-info btn-sm btn-block" type="button" value="<{$lang_editprofile|default:''}>" onclick="location='<{$xoops_url}>/modules/<{$xoops_dirname|default:''}>/admin/user.php?op=edit&amp;id=<{$user_uid|default:''}>'">
        <input type="hidden" name="uid" value="<{$user_uid|default:''}>">
        <{if $userlevel == 1}>
            <input type="hidden" name="level" value="0">
            <input class="btn btn-info btn-sm btn-block" type="button" value="<{$smarty.const._PROFILE_MA_DEACTIVATE}>" onclick="submit();">
        <{else}>
            <input type="hidden" name="level" value="1">
            <input class="btn btn-info btn-sm btn-block" type="button" value="<{$smarty.const._PROFILE_MA_ACTIVATE}>" onclick="submit();">
    <{/if}>
    </form>
<{/if}>
</div><!-- .col-md-6 -->
</div><!-- .row -->

<{foreach item=category from=$categories}>
    <{if isset($category.fields)}>
    <div class="panel panel-primary">
        <div class="panel-heading"><{$category.cat_title}></div>
        <table class="table" id="profile-category-<{$category.cat_id}>">
            <tbody>
                <{foreach item=field from=$category.fields}>
                    <tr>
                        <th><{$field.title}></th>
                        <td><{$field.value}></td>
                    </tr>
                <{/foreach}>
            </tbody>
        </table>
    </div>
    <{/if}>
<{/foreach}>

<{if $modules|default:false}>
    <h3><{$recent_activity|default:''}></h3>
    <{foreach item=module from=$modules}>
        <div class="panel">
            <div class="panel-heading"><{$module.name}> (<{$module.showall_link}>)</div>
            <ul class="list-group">
            <{foreach item=result from=$module.results}>
                <li class="list-group-item"><img src="<{$result.image}>" alt="<{$module.name}>"> <a href="<{$result.link}>"><{$result.title}></a> (<{$result.time}>)</li>
            <{/foreach}>
            </ul>
        </div>
    <{/foreach}>

<{/if}>