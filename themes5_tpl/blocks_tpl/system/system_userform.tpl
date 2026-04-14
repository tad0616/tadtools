<{if $page_header|default:true}>
  <div class="page-header">
    <h1 class="text-center"><{$lang_login|default:''}></h1>
  </div>
<{/if}>

<fieldset class="border border-info rounded px-3 pt-1 pb-3 bg-info-subtle text-center my-3 mx-auto" style="max-width: 25rem;">
    <legend class="float-none w-auto border border-info py-1 px-3 bg-light-subtle fs-6 rounded">
        <{$lang_login|default:''}>
    </legend>

    <!-- 無障礙提示區 -->
    <div id="loginMsg" class="bg-danger text-white mb-2" aria-live="assertive"></div>

    <form id="loginForm" action="<{$xoops_url}>/user.php" method="post" role="form">
      <div class="form-group row mb-3">
        <div class="col-sm-12">
          <div class="input-group">
              <label for="uname" class="input-group-text"><{$lang_username|default:''}></label>
              <input type="text" name="uname" id="uname" class="form-control" maxlength="25" value="" aria-required="true">
          </div>
        </div>
      </div>

      <div class="form-group row mb-3">
        <div class="col-sm-12">
          <div class="input-group">
            <label for="pass" class="input-group-text"><{$lang_password|default:''}></label>
            <input type="password" name="pass" id="pass" class="form-control" maxlength="32" aria-required="true">
          </div>
        </div>
      </div>

      <{if isset($lang_rememberme)}>
        <div class="form-check mb-3 mx-auto">
          <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme" value="On">
          <label class="form-check-label" for="rememberme">
            <{$lang_rememberme|default:''}>
          </label>
        </div>
      <{/if}>

      <input type="hidden" name="op" value="login">
      <input type="hidden" name="xoops_redirect" value="<{$redirect_page|default:''}>">

      <div class="text-center">
        <button type="submit" id="submit" class="btn btn-primary btn-lg">
          <i class="fa-solid fa-user-lock" aria-hidden="true"></i> <{$lang_login|default:''}>
        </button>
      </div>
  </form>
</fieldset>

<script>
document.addEventListener("DOMContentLoaded", function() {

  const uname = document.getElementById("uname");
  const pass = document.getElementById("pass");
  const form = document.getElementById("loginForm");
  const msg  = document.getElementById("loginMsg");

  form.addEventListener("submit", function(e){

    msg.textContent = "";

    if(uname.value.trim() === ""){
        e.preventDefault();
        msg.textContent = "請輸入帳號";
        uname.focus();
        return false;
    }

    if(pass.value.trim() === ""){
        e.preventDefault();
        msg.textContent = "請輸入密碼";
        pass.focus();
        return false;
    }

  });

  // 若頁面重新載入且帳密被清空，視為登入失敗
  if(uname.value === "" && pass.value === "" && document.referrer.includes("user.php")){
      msg.textContent = "帳號或密碼錯誤，請重新輸入";
      uname.focus();
  }

});
</script>