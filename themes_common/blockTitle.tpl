<{if $block.title|regex_replace:"/.*\[hide\].*/":"hide" != "hide"}>

    <{if $block.title|regex_replace:"/.*\[img\].*/":"Picture True" == "Picture True"}>
        <div class="blockTitle dont-print">
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>
            <img src="<{if $block.title|regex_replace:"/.*http.*/":"url" != "url"}><{$xoops_imageurl|default:''}><{/if}><{$block.title|regex_replace:"/.*\[img\]/":""}>" alt="<{$block.title|regex_replace:"/\[img\].*/":""}>" align="absmiddle" hspace=2 class="img-fluid img-responsive">
        </div>
    <{elseif $block.title|regex_replace:"/.*\[pic\].*/":"Picture True" == "Picture True"}>
        <div style="border:none;">
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>
            <img src="<{if $block.title|regex_replace:"/.*http.*/":"url" != "url"}><{$xoops_imageurl|default:''}><{/if}><{$block.title|regex_replace:"/.*\[pic\]/":""}>" alt="<{$block.title|regex_replace:"/\[pic\].*/":""}>" align="absmiddle" hspace=2 class="img-fluid img-responsive">
        </div>
    <{else}>
        <h3 class="blockTitle dont-print">
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>

            <{if $block.title|regex_replace:"/.*\[icon\].*/":"Icon True" == "Icon True"}>
                <img src="<{if $block.title|regex_replace:"/.*http.*/":"url" != "url"}><{$xoops_imageurl|default:''}><{/if}><{$block.title|regex_replace:"/.*\[icon\]/":""}>" alt="" align="absmiddle" hspace=2>
                <{$block.title|regex_replace:"/\[icon\].*/":""}>
            <{elseif $block.title|regex_replace:"/.*\[link\].*/":"Link True" == "Link True"}>
                <a href="<{$block.title|regex_replace:"/.*\[link\]/":""}>"><{$block.title|regex_replace:"/\[link\].*/":""}></a>
            <{else}>
                <{$block.title}>
            <{/if}>
        </h3>
    <{/if}>
<{else}>
    <div>
    <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>
    </div>
<{/if}>