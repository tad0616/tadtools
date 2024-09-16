<h2><{$version}></h2>
<div class="alert alert-warning"><{$smarty.const._MA_TT_THEMES_NOTE}></div>
<form action="main.php" method="post">
    <table class="table">
        <tr>
            <th><{$smarty.const._MA_TT_THEMES}></th>
            <th><{$smarty.const._MA_TT_THEMES_KIND}></th>
            <th><{$smarty.const._MA_TT_NEED_BOOTSTRAP}></th>
            <th><{$smarty.const._MA_TT_BOOTSTRAP_COLOR}></th>
        </tr>
        <{foreach item=theme from=$themes}>
            <tr>
                <td <{$theme.color}> class="col-sm-3">
                    <{$theme.theme_name}>
                </td>
                <td <{$theme.color}> class="col-sm-2">
                    <{$theme.theme_kind}>
                    <input type="hidden" name="tt_theme_kind[<{$theme.theme_name}>]" value="<{$theme.theme_kind}>">
                </td>
                <td <{$theme.color}> class="col-sm-3">
                    <{if $theme.tad_theme==1}>
                        <{$smarty.const._MA_TT_TAD_THEMES}>
                        <input type="hidden" name="tt_use_bootstrap[<{$theme.theme_name}>]" value="0">
                    <{else}>
                        <select name="tt_use_bootstrap[<{$theme.theme_name}>]" class="form-control">
                        <option value="" <{if $theme.use_bootstrap==""}>selected<{/if}>><{$smarty.const._MA_TT_EMPTY_CONFIG}></option>
                        <option value="1" <{if $theme.use_bootstrap=="1"}>selected<{/if}>><{$smarty.const._YES}></option>
                        <option value="0" <{if $theme.use_bootstrap=="0"}>selected<{/if}>><{$smarty.const._NO}></option>
                        </select>
                    <{/if}>
                </td>
                <td <{$theme.color}> class="col-sm-4">
                    <select name="tt_bootstrap_color[<{$theme.theme_name}>]" class="form-control">
                        <{foreach from=$theme.bootstrap_theme item=color}>
                            <option value="<{$color.theme_path}>" <{if $theme.bootstrap_color==$color.theme}>selected<{/if}>><{$color.theme}> (<{if $color.kind|default:false}><{$color.kind}>-<{/if}><{$color.color}>)</option>
                        <{/foreach}>
                    </select>
                </td>
            </tr>
        <{/foreach}>
    </table>
    <p class="text-center">
        <input type="hidden" name="op" value="save">
        <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TT_SAVE}></button>
    </p>
</form>