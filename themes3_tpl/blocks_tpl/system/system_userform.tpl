<div class="page-header">
  <h1><{$lang_login|default:''}></h1>
</div>
<form action="user.php" method="post" class="form-horizontal" role="form">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="uname">
        <{$lang_username|default:''}>
      </label>
      <div class="col-sm-10">
        <input type="text" name="uname" id="uname" class="form-control" maxlength="25" value="">
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label" for="pass">
        <{$lang_password|default:''}>
      </label>
      <div class="col-sm-10">
        <input type="password" name="pass" id="pass"  class="form-control" maxlength="32">
      </div>
    </div>


    <{if isset($lang_rememberme)}>
        <div class="form-group">
          <label class="col-sm-2 control-label sr-only" for="rememberme">
            <{$lang_rememberme|default:''}>
          </label>
          <div class="col-sm-10">
            <div class="checkbox-inline">
                <input type="checkbox" name="rememberme" id="rememberme" value="On" >
                <{$lang_rememberme|default:''}>
            </div>
          </div>
        </div>
    <{/if}>


    <div class="form-group">
      <label class="col-sm-2 control-label sr-only" for="submit">
      </label>
      <div class="col-sm-7 col-sm-offset-2">
        <span id="lost"></span>
        <{$lang_notregister|default:''}>
      </div>
      <div class="col-sm-3 text-right">
        <input type="hidden" name="op" value="login">
        <input type="hidden" name="xoops_redirect" value="<{$redirect_page|default:''}>">
        <button type="submit" id="submit" class="btn btn-primary"><{$lang_login|default:''}></button>
      </div>
    </div>
</form>


<div class="page-header">
  <h2><{$lang_lostpassword|default:''}></h2>
</div>

<div class="alert alert-info"><{$lang_noproblem|default:''}></div>
<form action="lostpass.php" method="post" class="form-horizontal" role="form">
    <div class="form-group">
      <label class="col-sm-2 control-label" for="email">
        <{$lang_youremail|default:''}>
      </label>
      <div class="col-sm-8">
        <input type="text" name="email" id="email" class="form-control" maxlength="60">
      </div>
      <div class="col-sm-2">
        <input type="hidden" name="op" value="mailpasswd">
        <button type="submit" class="btn btn-primary"><{$lang_sendpassword|default:''}></button>
      </div>
    </div>
</form>