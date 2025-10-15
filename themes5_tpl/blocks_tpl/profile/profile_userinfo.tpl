<{include file="db:profile_breadcrumbs.tpl"}>
<div class="row">
    <div class="col-sm-4 col-md-4 text-center">
    <{if $avatar|default:false}>
        <img src="<{$avatar|default:''}>" alt="<{$uname|default:''}>" class="img-fluid rounded img-thumbnail">
    <{/if}>
    </div><!-- .col-md-6 .aligncenter -->

    <div class="col-sm-8 col-md-8">
        <{if !$user_ownpage && $xoops_isuser == true}>
            <form name="usernav" action="user.php" method="post">
                <input class="btn btn-success" type="button" value="<{$smarty.const._PROFILE_MA_SENDPM}>" onclick="javascript:openWithSelfMain('<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$user_uid|default:''}>', 'pmlite', 450, 380);">
            </form>
        <{/if}>

        <{if $user_ownpage == true}>

            <form name="usernav" action="user.php" method="post">
                <a class="btn btn-success me-2"  href="<{$xoops_url}>/modules/profile/edituser.php"><{$lang_editprofile|default:''}></a>
                <a class="btn btn-danger me-2"  href="<{$xoops_url}>/modules/profile/changepass.php"><{$lang_changepassword|default:''}></a>
                <{if $user_changeemail|default:false}>
                <a class="btn btn-warning me-2" value=""  href="<{$xoops_url}>/modules/profile/changemail.php"><{$smarty.const._PROFILE_MA_CHANGEMAIL}></a>
                <{/if}>

                <{if $user_candelete == true}>
                <form method="post" action="<{$xoops_url}>/modules/profile/user.php">
                    <input  type="hidden" name="op" value="delete">
                    <input type="hidden" name="uid" value="<{$user_uid|default:''}>">
                    <button class="btn btn-success" onclick="submit();"><{$lang_deleteaccount|default:''}></button>
                </form>
                <{/if}>

                <a class="btn btn-info me-2"  href="edituser.php?op=avatarform"><{$lang_avatar|default:''}></a>
                <{*<a class="btn btn-success me-2"  href="<{$xoops_url}>/viewpmsg.php"><{$lang_inbox|default:''}></button>*}>
                <a class="btn btn-secondary"  href="<{$xoops_url}>/modules/profile/user.php?op=logout"><{$lang_logout|default:''}></a>
            </form>

        <{elseif $xoops_isadmin != false}>
            <form method="post" action="<{$xoops_url}>/modules/profile/admin/deactivate.php">
                <input class="btn btn-info" type="button" value="<{$lang_editprofile|default:''}>"  href="<{$xoops_url}>/modules/profile/admin/user.php?op=edit&amp;id=<{$user_uid|default:''}>">
                <input type="hidden" name="uid" value="<{$user_uid|default:''}>">
                <{if $userlevel == 1}>
                    <input type="hidden" name="level" value="0">
                    <input class="btn btn-info" type="button" value="<{$smarty.const._PROFILE_MA_DEACTIVATE}>" onclick="submit();">
                <{else}>
                    <input type="hidden" name="level" value="1">
                    <input class="btn btn-info" type="button" value="<{$smarty.const._PROFILE_MA_ACTIVATE}>" onclick="submit();">
            <{/if}>
            </form>
        <{/if}>

        <{foreach item=category from=$categories}>
            <{if isset($category.fields) && $category.cat_title=='個人訊息'}>
                <table class="table table-striped mt-3" id="profile-category-<{$category.cat_id}>">
                    <tbody>
                        <tr>
                            <th><{$field.name|default:'姓名'}></th>
                            <td><{$name|default:''}>
                            </td>
                        </tr>
                        <tr>
                            <th><{$field.uname|default:'帳號'}></th>
                            <td><{$uname|default:''}>
                            </td>
                        </tr>
                        <tr>
                            <th><{$field.email|default:'信箱'}></th>
                            <td><{$email|default:''}>
                            </td>
                        </tr>
                        <{foreach from=$category.fields item=field}>
                            <{if $field.title=="註冊日期" || $field.title=="所在時區"}>
                                <tr>
                                    <th><{$field.title}></th>
                                    <td><{$field.value}>
                                    </td>
                                </tr>
                            <{/if}>
                        <{/foreach}>
                    </tbody>
                </table>
            <{/if}>
        <{/foreach}>

    </div><!-- .col-md-6 -->
</div><!-- .row -->


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