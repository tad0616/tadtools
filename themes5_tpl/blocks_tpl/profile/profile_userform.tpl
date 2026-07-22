<{if $page_header|default:true}>
  <div class="page-header">
    <h2 class="text-center"><{$lang_login|default:''}></h2>
  </div>
<{/if}>

<fieldset class="border border-info rounded px-3 pt-1 pb-3 bg-info-subtle text-center my-3 mx-auto" style="max-width: 25rem;">
    <legend class="float-none w-auto border border-info py-1 px-3 bg-light-subtle fs-6 rounded">
        <{$lang_login|default:''}>
    </legend>

    <!-- 無障礙提示區 -->
    <div id="loginMsg" class="text-white mb-2 p-2" role="alert" aria-live="assertive" style="background-color:#910613;"></div>

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
      <{assign var="safe_redirect" value=$xoops_requesturi|default:''}>
      <{if $safe_redirect|strstr:'//'}>
        <{assign var="safe_redirect" value=""}>
      <{/if}>
      <input type="hidden" name="xoops_redirect" value="<{$safe_redirect}>">

      <div class="text-center">
        <button type="submit" id="submit" class="btn btn-primary btn-lg" style="background-color: #03347c;">
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

    // 確保沒有舊的錯誤訊息
    msg.classList.remove("active");

    if(uname.value.trim() === ""){
        e.preventDefault();
        msg.textContent = "請輸入帳號";
        // 添加active類以確保讀屏軟體識別變化
        msg.classList.add("active");
        // 短暫延遲以確保讀屏軟體能識別到內容變化
        setTimeout(() => {
            uname.focus();
        }, 100);
        return false;
    }

    if(pass.value.trim() === ""){
        e.preventDefault();
        msg.textContent = "請輸入密碼";
        // 添加active類以確保讀屏軟體識別變化
        msg.classList.add("active");
        // 短暫延遲以確保讀屏軟體能識別到內容變化
        setTimeout(() => {
            pass.focus();
        }, 100);
        return false;
    }

  });

  // 伺服器端登入失敗（redirect_header → SweetAlert2 顯示訊息後重導回此頁）
  // 帳密欄位被清空且 referrer 為 user.php，代表剛完成一次失敗的登入
  // 或者是當來源網址包含「user.php?xoops_redirect=」時
  if(
    (uname.value === "" && pass.value === "" && document.referrer.includes("user.php")) ||
    window.location.href.includes("user.php?xoops_redirect=") ||
    document.referrer.includes("user.php?xoops_redirect=")
  ){
    console.log('此處僅需移動焦點');
      // 錯誤訊息已由 system_redirect.tpl 的 SweetAlert2 顯示，此處僅需移動焦點
      // 延遲執行 focus()，確保 display:none → block 轉換完成後再移動焦點
      // https://accessibility.moda.gov.tw/Applications/DetectLog/190750
      setTimeout(function() {
          uname.focus();
      }, 100);

      // 監聽 jGrowl 關閉事件，確保使用者按下關閉按鈕時，焦點回到帳號欄位
      if (typeof $ !== "undefined") {
          $(document).on('jGrowl.close', function() {
              setTimeout(function() {
                  if (uname) uname.focus();
              }, 50);
          });
      }
  }

});
</script>

<style>
/* 確保錯誤提示區即使為空也有最小高度，保持佈局穩定 */
#loginMsg {
  min-height: 1.5rem;
  border-radius: 4px;
  display: none;
}

/* 當有錯誤訊息時顯示 */
#loginMsg.active {
  display: block;
}
</style>