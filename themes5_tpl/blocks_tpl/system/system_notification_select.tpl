<{if $xoops_notification.show|default:false}>
    <form name="notification_select" action="<{$xoops_notification.target_page}>" method="post">
        <h4 class="txtcenter"><{$lang_activenotifications|default:''}></h4>
        <input type="hidden" name="not_redirect" value="<{$xoops_notification.redirect_script}>"/>
        <{securityToken}>
        <table class="table table-sm">
            <tr>
                <th colspan="3"><{$lang_notificationoptions|default:''}></th>
            </tr>
            <tr>
                <th class="head"><{$lang_category|default:''}></th>
                <td class="head"><input name="allbox" id="allbox" onclick="xoopsCheckAll('notification_select','allbox');" type="checkbox"
                                        value="<{$lang_checkall|default:''}>"/></td>
                <th class="head"><{$lang_events|default:''}></th>
            </tr>
            <{foreach name=outer item=category from=$xoops_notification.categories}>
                <{foreach name=inner item=event from=$category.events}>
                    <tr>
                        <{if $smarty.foreach.inner.first|default:false}>
                            <td class="even" rowspan="<{$smarty.foreach.inner.total}>"><{$category.title}></td>
                        <{/if}>
                        <td class="odd">
                            <{counter assign=index}>
                            <input type="hidden" name="not_list[<{$index|default:''}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>"/>
                            <input type="checkbox" id="not_list[]" name="not_list[<{$index|default:''}>][status]" value="1" <{if $event.subscribed|default:false}>checked<{/if}>
                            />
                        </td>
                        <td class="odd"><{$event.caption}></td>
                    </tr>
                <{/foreach}>
            <{/foreach}>
            <tr>
                <td class="foot txtcenter" colspan="3"><button class="btn btn-primary" type="submit" name="not_submit"><span class="glyphicon glyphicon-save"></span> <{$lang_updatenow|default:''}></button></td>
            </tr>
        </table>
        <div class="txtcenter">
            <{$lang_notificationmethodis|default:''}>:&nbsp;<{$user_method|default:''}>&nbsp;&nbsp;[<a href="<{$editprofile_url|default:''}>" title="<{$lang_change|default:''}>"><{$lang_change|default:''}></a>]
        </div>
    </form>
<{/if}>
