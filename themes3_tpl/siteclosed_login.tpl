<h1 class="text-center"><{$lang_siteclosemsg}></h1>
<div class="jumbotron">
  <form action="<{$xoops_url}>/user.php" method="post" class="form-horizontal" role="form">
    <div class="form-group">
      <label class="col-md-2 control-label">
        <{$smarty.const.TF_USER_S_ID}>
      </label>
      <div class="col-md-3">
        <input type="text" name="uname"  id="uname" placeholder="<{$smarty.const.TF_USER_ID}>"  class="form-control" />
      </div>
      <label class="col-md-2 control-label">
        <{$smarty.const.TF_USER_S_PASS}>
      </label>
      <div class="col-md-3">
      <input type="password" name="pass" id="pass" placeholder="<{$smarty.const.TF_USER_PASS}>" class="form-control" />
      </div>

      <div class="col-md-2">
        <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />
        <input type="hidden" name="rememberme" value="On" />
        <input type="hidden" name="op" value="login" />
        <input type="hidden" name="xoops_login" value="1"/>
        <button type="submit" class="btn btn-primary btn-block"><{$smarty.const.TF_USER_ENTER}></button>
      </div>
    </div>

  </form>
</div>