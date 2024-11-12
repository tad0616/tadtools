<{assign var="this_file" value=$smarty.template|basename|replace:'db:':''}>
<{assign var="bootstrap" value=$smarty.session.bootstrap|default:5}>
<{assign var="themes_tpl" value="themes`$bootstrap`_tpl"}>
<{include file="$xoops_rootpath/modules/tadtools/$themes_tpl/blocks_tpl/profile/`$this_file`"}>