<{assign var="this_file" value=$smarty.template|basename|replace:'db:':''}>

<{include file="$xoops_rootpath/modules/tadtools/themes`$smarty.session.bootstrap`_tpl/blocks_tpl/pm/`$this_file`"}>