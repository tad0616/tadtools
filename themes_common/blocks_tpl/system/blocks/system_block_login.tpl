<div class="loginform">
  <form action="<{xoAppUrl user.php}>" method="post" class="form-horizontal" role="form">
    <div class="form-group">
      <label class="col-md-4 control-label">
        <{$smarty.const.TF_USER_S_ID}>
      </label>
      <div class="col-md-8">
        <input type="text" name="uname"  id="uname" placeholder="<{$smarty.const.TF_USER_ID}>"  class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label">
        <{$smarty.const.TF_USER_S_PASS}>
      </label>
      <div class="col-md-8">
      <input type="password" name="pass" id="pass" placeholder="<{$smarty.const.TF_USER_PASS}>" class="form-control" />
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-4 control-label checkbox">
        <{if isset($block.lang_rememberme)}>
            <input type="checkbox" name="rememberme" value="On" class="formButton">
            <{$block.lang_rememberme}>
        <{/if}>
      </label>
      <div class="col-md-8">
        <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />
        <input type="hidden" name="rememberme" value="On" />
        <input type="hidden" name="op" value="login" />
        <input type="hidden" name="xoops_login" value="1"/>
        <{$block.sslloginlink}>
        <button type="submit" class="btn btn-primary btn-block"><{$smarty.const.TF_USER_ENTER}></button>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-5">
        <a href="<{$xoops_url}>/register.php" class="btn btn-xs btn-link" style="background: transparent; width: auto; color: #303030; font-size: 12px;">
          <span class="fa fa-pencil"></span>
          <{$smarty.const.TF_USER_REGIST}>
        </a>
      </div>
      <div class="col-md-7">
        <a href="<{$xoops_url}>/user.php#lost" class="btn btn-xs btn-link" style="background: transparent; width: auto; color: #303030; font-size: 12px;">
          <span class="fa fa-search"></span>
          <{$smarty.const.TF_USER_FORGET_PASS}>
        </a>
      </div>
    </div>
  </form>
</div>
