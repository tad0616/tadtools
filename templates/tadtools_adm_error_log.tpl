<h2><{$smarty.const._MA_TT_ERRLOG_TITLE}></h2>
<{if !$logger_patched}>
    <div class="alert alert-danger"><{$smarty.const._MA_TT_ERRLOG_NOT_PATCHED}></div>
<{/if}>
<form action="error_log.php" method="get" class="row g-2 mb-3">
    <div class="col-auto">
        <label for="error_id" class="visually-hidden"><{$smarty.const._MA_TT_ERRLOG_ID}></label>
        <input type="text" id="error_id" name="error_id" value="<{$error_id|escape}>" class="form-control" maxlength="16" placeholder="<{$smarty.const._MA_TT_ERRLOG_ID_PLACEHOLDER}>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TT_ERRLOG_SEARCH}></button>
        <{if $error_id}>
            <a href="error_log.php" class="btn btn-default btn-secondary"><{$smarty.const._MA_TT_ERRLOG_SHOW_LATEST}></a>
        <{/if}>
    </div>
</form>

<{if $invalid_id}>
    <div class="alert alert-danger"><{$smarty.const._MA_TT_ERRLOG_INVALID_ID}></div>
<{elseif $error_id}>
    <p><{$smarty.const._MA_TT_ERRLOG_RESULT_FOR}><code><{$error_id|escape}></code></p>
<{else}>
    <p><{$smarty.const._MA_TT_ERRLOG_LATEST_NOTE}></p>
<{/if}>

<{if $records}>
    <table class="table table-striped table-bordered">
        <tr>
            <th><{$smarty.const._MA_TT_ERRLOG_ID}></th>
            <th><{$smarty.const._MA_TT_ERRLOG_TIME}></th>
            <th><{$smarty.const._MA_TT_ERRLOG_DETAIL}></th>
        </tr>
        <{foreach item=record from=$records}>
            <tr>
                <td><code><{$record.id|escape}></code></td>
                <td><{$record.time|escape}></td>
                <td>
                    <div><strong><{$record.message|escape}></strong></div>
                    <div><{$smarty.const._MA_TT_ERRLOG_LOCATION}><{$record.file|escape}>:<{$record.line|escape}></div>
                    <div><{$smarty.const._MA_TT_ERRLOG_REQUEST}><{$record.method|escape}> <{$record.uri|escape}></div>
                    <{if $record.trace_text}>
                        <details>
                            <summary><{$smarty.const._MA_TT_ERRLOG_TRACE}></summary>
                            <pre><{$record.trace_text|escape}></pre>
                        </details>
                    <{/if}>
                </td>
            </tr>
        <{/foreach}>
    </table>
<{elseif !$invalid_id}>
    <div class="alert alert-info"><{$smarty.const._MA_TT_ERRLOG_EMPTY}></div>
<{/if}>

<p class="text-muted"><{$smarty.const._MA_TT_ERRLOG_FILE}><code><{$log_path|escape}></code></p>

<form action="error_log.php" method="post" onsubmit="return confirm('<{$smarty.const._MA_TT_ERRLOG_CLEAR_CONFIRM}>');">
    <{$token_html}>
    <input type="hidden" name="op" value="clear">
    <button type="submit" class="btn btn-danger"><{$smarty.const._MA_TT_ERRLOG_CLEAR}></button>
</form>
