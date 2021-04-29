<h1><{$lang_login}></h1>

<form action="user.php" method="post" role="form">
    <div class="form-group row row">
      <label class="col-md-2 col-form-label text-sm-right" for="uname">
        <{$lang_username}>
      </label>
      <div class="col-md-10">
        <input type="text" name="uname" id="uname" class="form-control" maxlength="25" value="">
      </div>
    </div>

    <div class="form-group row row">
      <label class="col-md-2 col-form-label text-sm-right" for="pass">
        <{$lang_password}>
      </label>
      <div class="col-md-10">
        <input type="password" name="pass" id="pass"  class="form-control" maxlength="32">
      </div>
    </div>


    <{if isset($lang_rememberme)}>
        <div class="form-group row row">
          <label class="col-md-2 col-form-label text-sm-right sr-only" for="rememberme">
            <{$lang_rememberme}>
          </label>
          <div class="col-md-10">
            <div class="checkbox-inline">
                <input type="checkbox" name="rememberme" id="rememberme" value="On" >
                <{$lang_rememberme}>
            </div>
          </div>
        </div>
    <{/if}>


    <div class="form-group row row">
      <label class="col-md-2 col-form-label text-sm-right sr-only" for="submit">
      </label>
      <div class="col-md-7 offset-sm-2">
        <span id="lost"></span>
        <{$lang_notregister}>
      </div>
      <div class="col-md-3 text-right">
        <input type="hidden" name="op" value="login">
        <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>">
        <button type="submit" id="submit" class="btn btn-primary"><{$lang_login}></button>
      </div>
    </div>
</form>


<h2><{$lang_lostpassword}></h2>

<div class="alert alert-info"><{$lang_noproblem}></div>
<form action="lostpass.php" method="post" role="form">
    <div class="form-group row row">
      <label class="col-md-2 col-form-label text-sm-right" for="email">
        <{$lang_youremail}>
      </label>
      <div class="col-md-8">
        <input type="text" name="email" id="email" class="form-control" maxlength="60">
      </div>
      <div class="col-md-2">
        <input type="hidden" name="op" value="mailpasswd">
        <button type="submit" class="btn btn-primary"><{$lang_sendpassword}></button>
      </div>
    </div>
</form>