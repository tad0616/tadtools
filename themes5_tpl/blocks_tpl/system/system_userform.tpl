<{if $page_header|default:true}>
  <div class="page-header">
    <h1 class="text-center"><{$lang_login|default:''}></h1>
  </div>
<{/if}>

<fieldset class="border border-info rounded px-3 pt-1 pb-3 bg-info-subtle text-center my-3 mx-auto" style="max-width: 400px;">
    <legend class="float-none w-auto border border-info py-1 px-3 bg-light-subtle fs-6 rounded">
        <{$lang_login|default:''}>
    </legend>

    <form action="<{$xoops_url}>/user.php" method="post" role="form">
      <div class="form-group row mb-3">
        <div class="col-sm-12">
          <div class="input-group">
              <span class="input-group-text"><{$lang_username|default:''}></span>
              <input type="text" name="uname" id="uname" title="uname" class="form-control" maxlength="25" value="">
          </div>
        </div>
      </div>

      <div class="form-group row mb-3">
        <div class="col-sm-12">
          <div class="input-group">
            <span class="input-group-text"><{$lang_password|default:''}></span>
            <input type="password" name="pass" id="pass" title="pass" class="form-control" maxlength="32">
          </div>
        </div>
      </div>

      <{if isset($lang_rememberme)}>
        <div class="form-check mb-3 mx-auto">
          <label class="form-check-label" for="rememberme">
            <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme" title="rememberme" value="On" >
            <{$lang_rememberme|default:''}>
          </label>
        </div>
      <{/if}>

      <input type="hidden" name="op" value="login">
      <input type="hidden" name="xoops_redirect" value="<{$redirect_page|default:''}>">
      <div class="text-center">
      <button type="submit" id="submit" title="login" class="btn btn-primary btn-lg"><i class="fa-solid fa-user-lock"></i> <{$lang_login|default:''}></button>
      </div>
  </form>
</fieldset>





<{*
    <div class="form-group row mb-3">
      <label class="col-sm-2 col-form-label text-sm-end sr-only visually-hidden" for="submit">
      </label>
      <div class="col-sm-7 col-sm-offset-2">
        <span id="lost"></span>
        <{$lang_notregister|default:''}>
      </div>
      <div class="col-sm-3 text-end">
        <input type="hidden" name="op" value="login">
        <input type="hidden" name="xoops_redirect" value="<{$redirect_page|default:''}>">
        <button type="submit" id="submit" title="login" class="btn btn-primary"><{$lang_login|default:''}></button>
      </div>
    </div>

<div class="page-header">
  <h2><{$lang_lostpassword|default:''}></h2>
</div>

<div class="alert alert-info"><{$lang_noproblem|default:''}></div>
<form action="lostpass.php" method="post" role="form">
    <div class="form-group row mb-3">
      <label class="col-sm-2 col-form-label text-sm-end" for="email">
        <{$lang_youremail|default:''}>
      </label>
      <div class="col-sm-8">
        <input type="text" name="email" id="email" title="email" class="form-control" maxlength="60">
      </div>
      <div class="col-sm-2">
        <input type="hidden" name="op" value="mailpasswd">
        <button type="submit" class="btn btn-primary"><{$lang_sendpassword|default:''}></button>
      </div>
    </div>
</form>
*}>