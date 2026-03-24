<{if $openid_login!="3"}>
    <ul class="tadnav-submenu" role="menu" aria-label="登入選單">
    <{if $openid_login=="0" or $openid_login=="1"}>
        <li role="none">
            <form action="<{$xoops_url}>/user.php" method="post">
                <div style="margin: 10px; padding: 10px;">
                    <h2 class="h5 mb-3">
                        <{if $login_text|default:false}><{$login_text|default:''}><{else}>
                        <{$smarty.const.TF_USER_ENTER}><{/if}>
                    </h2>
                    <{if $login_description|default:false}>
                        <div class="alert alert-warning" role="alert" style="font-size: 0.825rem;">
                            <{$login_description|default:''}>
                        </div>
                    <{/if}>

                    <!-- 使用 Bootstrap 5 的 Floating labels -->
                    <div class="form-floating mb-3">
                        <input type="text" name="uname" id="menu_uname" class="form-control" placeholder="<{$smarty.const.TF_USER_ID}>" required aria-required="true">
                        <label for="menu_uname"><{$smarty.const.TF_USER_S_ID}></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="pass" id="menu_pass" class="form-control" placeholder="<{$smarty.const.TF_USER_PASS}>" required aria-required="true">
                        <label for="menu_pass"><{$smarty.const.TF_USER_S_PASS}></label>
                    </div>

                    <div class="mb-3">
                        <div class="d-grid gap-2">
                            <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi|default:''}>">
                            <input type="hidden" name="rememberme" value="On">
                            <input type="hidden" name="op" value="login">
                            <input type="hidden" name="xoops_login" value="1">
                            <button type="submit" class="btn btn-primary btn-block py-2 btn-lg" aria-label="<{$smarty.const.TF_USER_ENTER}>">
                                <{$smarty.const.TF_USER_ENTER}>
                            </button>
                        </div>
                    </div>
                </div>

                <{if $allow_register|default:false}>
                    <div class="row mb-3 px-3">
                        <div class="col-md-6 mb-2">
                            <a href="<{$xoops_url}>/register.php" class="d-inline-flex align-items-center">
                                <span class="fa fa-pencil me-1" aria-hidden="true"></span>
                                <{$smarty.const.TF_USER_REGIST}>
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="<{$xoops_url}>/user.php#lost" class="d-inline-flex align-items-center">
                                <span class="fa fa-magnifying-glass me-1" aria-hidden="true"></span>
                                <{$smarty.const.TF_USER_FORGET_PASS}>
                            </a>
                        </div>
                    </div>
                <{/if}>
            </form>
        </li>
    <{/if}>

    <{if $tlogin && ($openid_login==1 || $openid_login==2)}>
        <li role="none">
            <div class="social-login p-3">
                <p id="social-login-heading" class="mb-2 fw-bold"><{$smarty.const.TF_USER_ENTER|default:'使用社群帳號登入'}></p>

                <!-- 社群登入按鈕 -->
                <{if $tlogin|@count >= 4}>
                    <!-- 數量大於等於4個時，只顯示圖示 -->
                    <div class="d-flex flex-wrap" role="group" aria-labelledby="social-login-heading">
                        <{foreach from=$tlogin item=login}>
                            <a href="<{$login.link}>" class="btn social-btn d-flex justify-content-center align-items-center m-1"
                               style="min-width: 44px; min-height: 44px; width: auto; padding: 8px; background-color: #ffffff; color: #212529; border: 1px solid #dee2e6;"
                               title="<{$login.text}>" aria-label="<{$login.text}>">
                                <img src="<{$login.img}>" alt="" style="width: 24px; height: 24px; object-fit: contain;" aria-hidden="true">
                            </a>
                        <{/foreach}>
                    </div>
                <{else}>
                    <!-- 數量小於4個時，顯示圖示和文字 -->
                    <div class="d-flex flex-column" role="group" aria-labelledby="social-login-heading">
                        <{foreach from=$tlogin item=login}>
                            <a href="<{$login.link}>" class="btn social-btn d-flex align-items-center mb-2"
                               style="min-height: 44px; text-align: left; padding: 8px 16px; background-color: #ffffff; color: #212529; border: 1px solid #dee2e6;">
                                <div style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                    <img src="<{$login.img}>" alt="" style="max-width: 24px; max-height: 24px; object-fit: contain;" aria-hidden="true">
                                </div>
                                <span><{$login.text}></span>
                            </a>
                        <{/foreach}>
                    </div>
                <{/if}>
            </div>

            <!-- 添加社群按鈕的懸停效果的CSS -->
            <style>
                .social-btn:hover, .social-btn:focus {
                    background-color: #0d6efd !important; /* Bootstrap 主要藍色 */
                    color: #ffffff !important;
                    border-color: #0d6efd !important;
                    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); /* Bootstrap 藍色聚焦陰影 */
                }

                /* 高對比度模式支援 */
                @media (forced-colors: active) {
                    .social-btn:hover, .social-btn:focus {
                        forced-color-adjust: none;
                        background-color: Highlight !important;
                        color: HighlightText !important;
                        border-color: Highlight !important;
                    }
                }

                /* 確保按鈕有足夠的點擊區域 */
                .social-btn {
                    position: relative;
                    transition: all 0.2s ease-in-out;
                }

                /* 無障礙性焦點指示器 */
                .social-btn:focus-visible {
                    outline: 3px solid #80bdff;
                    outline-offset: 2px;
                }
            </style>
        </li>
    <{/if}>

        <li role="none">
            <a href="<{$xoops_url}>/modules/tadtools/ajax_file.php?op=remove_json" title="重整畫面圖示" role="menuitem" class="d-flex align-items-center px-3 py-2">
                <i class="fa fa-refresh me-2" aria-hidden="true"></i> <span>重取設定</span>
            </a>
        </li>
    </ul>
<{/if}>