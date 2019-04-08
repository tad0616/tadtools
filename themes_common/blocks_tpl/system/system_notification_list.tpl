<{assign var=this_file value=$smarty.template|basename|replace:'db:':''}>
<{if $smarty.session.bootstrap==4}>
    <{includeq file="$xoops_rootpath/modules/tadtools/themes4_tpl/blocks_tpl/system/`$this_file`"}>
<{else}>
    <{includeq file="$xoops_rootpath/modules/tadtools/themes3_tpl/blocks_tpl/system/`$this_file`"}>
<{/if}>