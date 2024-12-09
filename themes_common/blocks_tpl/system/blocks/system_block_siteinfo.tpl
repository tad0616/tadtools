<{assign var="this_file" value=$smarty.template|basename|replace:'db:':''}>
<{assign var="bootstrap" value=$smarty.session.bootstrap|default:$session.bootstrap}>
<{include file="$xoops_rootpath/modules/tadtools/themes`$bootstrap`_tpl/blocks_tpl/system/blocks/`$this_file`"}>