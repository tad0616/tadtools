<{if $openid_login!="3"}>
    <ul class="dropdown-menu">

    <{if $openid_login=="0" or $openid_login=="1"}>
        <li class="nav-item">
            <form action="<{$xoops_url}>/user.php" method="post">
                <fieldset style="min-width: 200px; margin: 10px;">
                    <legend>
                    <{if $login_text}><{$login_text}><{else}>
                    <{$smarty.const.TF_USER_ENTER}><{/if}>
                    </legend>
                    <{if $login_description}><div class="alert alert-warning" style="font-size: 0.825rem;"><{$login_description}></div><{/if}>
                    <div class="form-group row row">
                    <label class="col-md-4 col-form-label text-sm-right" for="uname">
                        <{$smarty.const.TF_USER_S_ID}>
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="uname"  id="uname" placeholder="<{$smarty.const.TF_USER_ID}>"  class="form-control">
                    </div>
                    </div>

                    <div class="form-group row row">
                    <label class="col-md-4 col-form-label text-sm-right" for="pass">
                        <{$smarty.const.TF_USER_S_PASS}>
                    </label>
                    <div class="col-md-8">
                    <input type="password" name="pass" id="pass" placeholder="<{$smarty.const.TF_USER_PASS}>" class="form-control">
                    </div>
                    </div>

                    <div class="form-group row row">
                    <label class="col-md-4 col-form-label text-sm-right">
                    </label>
                    <div class="col-md-8">
                        <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>">
                        <input type="hidden" name="rememberme" value="On">
                        <input type="hidden" name="op" value="login">
                        <input type="hidden" name="xoops_login" value="1">
                        <button type="submit" class="btn btn-primary btn-block"><{$smarty.const.TF_USER_ENTER}></button>
                    </div>
                    </div>

                    <{if $allow_register=='1'}>
                    <div class="form-group row row">
                        <div class="col-md-5">
                        <a href="<{$xoops_url}>/register.php" class="btn btn-sm btn-link">
                            <span class="fa fa-pencil"></span>
                            <{$smarty.const.TF_USER_REGIST}>
                        </a>
                        </div>
                        <div class="col-md-7">
                        <a href="<{$xoops_url}>/user.php#lost" class="btn btn-sm btn-link">
                            <span class="fa fa-search"></span>
                            <{$smarty.const.TF_USER_FORGET_PASS}>
                        </a>
                        </div>
                    </div>
                    <{/if}>
                </fieldset>
            </form>
        </li>

    <{/if}>

        <li class="nav-item">
            <{foreach from=$tlogin item=login}>
                <a href="<{$login.link}>" class="btn" <{if $openid_logo!=1}>style="display:inline-block; width:32px; height:32px;padding:3px; margin:3px; background-color:transparent;"<{/if}>>
                    <img src="<{$login.img}>" alt="<{$login.text}>" title="<{$login.text}>" <{if $openid_logo!=1}>style="width:32px;height:32px;"<{/if}>>
                    <{if $openid_logo==1}><{$login.text}><{/if}>
                </a>
            <{/foreach}>
        </li>
    <{/if}>
    </ul>
<{/if}>
