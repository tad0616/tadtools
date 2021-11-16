<h2 style="display:none;">Login</h2>
<fieldset class="pad10">
    <legend class="bold"><{$lang_login}></legend>
    <form action="user.php" method="post">
        <label for="uname"><{$lang_username}></label> <input type="text" id="uname" title="uname" name="uname" size="26" maxlength="25" value=""/><br><br>
        <label for="pass"><{$lang_password}></label> <input type="password" id="pass" title="pass" name="pass" size="21" maxlength="32"/><br><br>
        <{if isset($lang_rememberme)}>
            <input type="checkbox" id="rememberme" title="rememberme" name="rememberme" value="On" checked/>
            <label for="rememberme"><{$lang_rememberme}></label>
            <br>
            <br>
        <{/if}>

        <input type="hidden" name="op" value="login"/>
        <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>"/>
        <input type="submit" title="login" value="<{$lang_login}>"/>
    </form>
    <br>
    <a name="lost">&nbsp;</a>

    <div><{$lang_notregister}><br></div>
</fieldset>

<br>

<fieldset class="pad10">
    <legend class="bold"><{$lang_lostpassword}></legend>
    <div><br><{$lang_noproblem}></div>
    <form action="lostpass.php" method="post">
        <label for="email"><{$lang_youremail}></label> <input type="text" id="email" title="email" name="email" size="26" maxlength="60"/>&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd"/><input type="hidden" name="t" value="<{$mailpasswd_token}>"/><input type="submit" title="sendpassword" value="<{$lang_sendpassword}>"/>
    </form>
</fieldset>
