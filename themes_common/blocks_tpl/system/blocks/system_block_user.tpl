<{assign var=this_file value=$smarty.template|basename|replace:'db:':''}>
<{includeq file="$xoops_rootpath/modules/tadtools/themes`$smarty.session.bootstrap`_tpl/blocks_tpl/system/blocks/`$this_file`"}>
