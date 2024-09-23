<h2 style="display:none;">Login</h2>
<fieldset class="pad10">
    <legend class="bold"><{$lang_login|default:''}></legend>
    <form action="user.php" method="post">
        <{$lang_username|default:''}> <input type="text" name="uname" size="26" maxlength="25" value="" title="uname"/><br><br>
        <{$lang_password|default:''}> <input type="password" name="pass" size="21" maxlength="32" title="pass"/><br><br>
        <{if isset($lang_rememberme)}>
            <input type="checkbox" name="rememberme" value="On" checked title="rememberme"/>
            <{$lang_rememberme|default:''}>
            <br>
            <br>
        <{/if}>

        <input type="hidden" name="op" value="login"/>
        <input type="hidden" name="xoops_redirect" value="<{$redirect_page|default:''}>"/>
        <input type="submit" value="<{$lang_login|default:''}>"/>
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
        <{$lang_youremail|default:''}> <input type="text" name="email" size="26" maxlength="60" title="email"/>&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd"/><input type="hidden" name="t" value="<{$mailpasswd_token|default:''}>"/><input type="submit" value="<{$lang_sendpassword|default:''}>"/>
    </form>
</fieldset>
