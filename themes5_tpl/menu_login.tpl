<{if $openid_login!="3"}>
    <ul>

    <{if $openid_login=="0" or $openid_login=="1"}>
        <li>
            <form action="<{$xoops_url}>/user.php" method="post">
                <fieldset style="min-width: 200px; margin: 10px;">
                    <legend>
                        <{if $login_text|default:false}><{$login_text|default:''}><{else}>
                        <{$smarty.const.TF_USER_ENTER}><{/if}>
                    </legend>
                    <{if $login_description|default:false}><div class="alert alert-warning" style="font-size: 0.825rem;"><{$login_description|default:''}></div><{/if}>
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
                            <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi|default:''}>">
                            <input type="hidden" name="rememberme" value="On">
                            <input type="hidden" name="op" value="login">
                            <input type="hidden" name="xoops_login" value="1">
                            <button type="submit" class="btn btn-primary btn-block"><{$smarty.const.TF_USER_ENTER}></button>
                        </div>
                    </div>
                </fieldset>

                <{if $allow_register|default:false}>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <a href="<{$xoops_url}>/register.php">
                                <span class="fa fa-pencil"></span>
                                <{$smarty.const.TF_USER_REGIST}>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<{$xoops_url}>/user.php#lost">
                                <span class="fa fa-magnifying-glass"></span>
                                <{$smarty.const.TF_USER_FORGET_PASS}>
                            </a>
                        </div>
                    </div>
                <{/if}>
            </form>
        </li>
    <{/if}>

    <{if $tlogin && ($openid_login==1 || $openid_login==2)}>
        <li>
            <div class="row">
                <{foreach from=$tlogin item=login}>
                    <{if $tlogin && $tlogin|@count < 4}>
                        <div class="col-12">
                            <a href="<{$login.link}>" class="btn me-2" style="display: block; margin: 4px; border: none; ">
                                <img src="<{$login.img}>" alt="<{$login.text}>" title="<{$login.text}>" style="width: 32px;height: 32px;object-fit: contain;">
                                <{$login.text}>
                            </a>
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

        <li>
            <a href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" title="重整畫面">
                <i class="fa fa-refresh"></i> 重整畫面
            </a>
        </li>
    </ul>
<{/if}>
