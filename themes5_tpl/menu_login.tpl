<{if $openid_login!="3"}>
    <ul>

    <{if $openid_login=="0" or $openid_login=="1"}>
        <li>
            <form action="<{$xoops_url}>/user.php" method="post">
                <fieldset style="min-width: 200px; margin: 10px;">
                    <legend>
                    <{if $login_text}><{$login_text}><{else}>
                    <{$smarty.const.TF_USER_ENTER}><{/if}>
                    </legend>
                    <{if $login_description}><div class="alert alert-warning" style="font-size: 0.825rem;"><{$login_description}></div><{/if}>
                    <div class="form-group row mb-3">
                        <label class="col-md-4 col-form-label text-sm-end" for="uname">
                            <{$smarty.const.TF_USER_S_ID}>
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="uname"  id="uname" placeholder="<{$smarty.const.TF_USER_ID}>"  class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                    <label class="col-md-4 col-form-label text-sm-end" for="pass">
                        <{$smarty.const.TF_USER_S_PASS}>
                    </label>
                    <div class="col-md-8">
                    <input type="password" name="pass" id="pass" placeholder="<{$smarty.const.TF_USER_PASS}>" class="form-control">
                    </div>
                    </div>

                    <div class="form-group row mb-3">
                    <label class="col-md-4 col-form-label text-sm-end">
                    </label>
                    <div class="col-md-8 d-grid gap-2">
                        <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>">
                        <input type="hidden" name="rememberme" value="On">
                        <input type="hidden" name="op" value="login">
                        <input type="hidden" name="xoops_login" value="1">
                        <button type="submit" class="btn btn-primary btn-block"><{$smarty.const.TF_USER_ENTER}></button>
                    </div>
                    </div>

                    <{if $allow_register=='1'}>
                    <div class="form-group row mb-3">
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

    <{if $tlogin && ($openid_login==1 || $openid_login==2)}>
        <li>
            <div class="row">
                <{foreach from=$tlogin item=login}>
                    <{if $tlogin|@count < 4}>
                    <div class="col-12">
                        <div class="card my-0" style="background: #ffffff88;">
                            <div class="row g-0">
                                <div class="col-md-2" style="display: inline-flex;justify-content: center;align-items: center;">
                                    <img src="<{$login.img}>" class="img-fluid rounded-start" alt="<{$login.text}>" title="<{$login.text}>">
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                    <small class="card-text fs-7"><{$login.text}></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <{else}>
                        <div class="col-12">
                            <a href="<{$login.link}>" class="btn bg-white me-2" style="display: inline-flex;justify-content: center;align-items: center;width: 36px;height: 36px;padding: 0;margin: 3px;background-color: white;border: none;cursor: pointer;">
                                <img src="<{$login.img}>" alt="<{$login.text}>" title="<{$login.text}>" style="width: 32px;height: 32px;object-fit: contain;">
                            </a>
                        </div>
                    <{/if}>
                <{/foreach}>
            </div>
        </li>
    <{/if}>
    </ul>
<{/if}>
