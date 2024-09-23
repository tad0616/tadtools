<h2 style="display:none;">Login</h2>
<fieldset class="pad10">
    <legend class="bold"><{$lang_login|default:''}></legend>
    <form action="user.php" method="post">
        <label for="uname"><{$lang_username|default:''}></label> <input type="text" id="uname" title="uname" name="uname" size="26" maxlength="25" value=""/><br><br>
        <label for="pass"><{$lang_password|default:''}></label> <input type="password" id="pass" title="pass" name="pass" size="21" maxlength="32"/><br><br>
        <{if isset($lang_rememberme)}>
            <input type="checkbox" id="rememberme" title="rememberme" name="rememberme" value="On" checked/>
            <label for="rememberme"><{$lang_rememberme|default:''}></label>
            <br>
            <br>
        <{/if}>

        <input type="hidden" name="op" value="login"/>
        <input type="hidden" name="xoops_redirect" value="<{$redirect_page|default:''}>"/>
        <input type="submit" title="login" value="<{$lang_login|default:''}>"/>
    </form>
    <br>
    <a name="lost">&nbsp;</a>

    <div><{$lang_notregister|default:''}><br></div>
</fieldset>

<br>

<fieldset class="pad10">
    <legend class="bold"><{$lang_lostpassword|default:''}></legend>
    <div><br><{$lang_noproblem|default:''}></div>
    <form action="lostpass.php" method="post">
        <label for="email"><{$lang_youremail|default:''}></label> <input type="text" id="email" title="email" name="email" size="26" maxlength="60"/>&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd"/><input type="hidden" name="t" value="<{$mailpasswd_token|default:''}>"/><input type="submit" title="sendpassword" value="<{$lang_sendpassword|default:''}>"/>
    </form>
</fieldset>
