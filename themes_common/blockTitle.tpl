<{if $block.title|regex_replace:"/.*\[hide\].*/":"hide" != "hide"}>

    <{if $block.title|regex_replace:"/.*\[img\].*/":"Picture True" == "Picture True"}>
        <div class="blockTitle">
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>
            <img src="<{if $block.title|regex_replace:"/.*http.*/":"url" != "url"}><{$xoops_imageurl|default:''}><{/if}><{$block.title|regex_replace:"/.*\[img\]/":""}>" alt="<{$block.title|regex_replace:"/\[img\].*/":""}>" title="<{$block.title|regex_replace:"/\[img\].*/":""}>" align="absmiddle" hspace=2 style="max-width: 100%;">
        </div>
    <{elseif $block.title|regex_replace:"/.*\[pic\].*/":"Picture True" == "Picture True"}>
        <div style="border:none;">
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>
            <img src="<{if $block.title|regex_replace:"/.*http.*/":"url" != "url"}><{$xoops_imageurl|default:''}><{/if}><{$block.title|regex_replace:"/.*\[pic\]/":""}>" alt="<{$block.title|regex_replace:"/\[pic\].*/":""}>" title="<{$block.title|regex_replace:"/\[pic\].*/":""}>" align="absmiddle" hspace=2 style="max-width: 100%;">
        </div>
    <{else}>
        <h3 class="blockTitle">
            <{include file="$xoops_rootpath/modules/tadtools/themes_common/block_config.tpl"}>

            <{if $block.title|regex_replace:"/.*\[icon\].*/":"Icon True" == "Icon True"}>
                <img src="<{if $block.title|regex_replace:"/.*http.*/":"url" != "url"}><{$xoops_imageurl|default:''}><{/if}><{$block.title|regex_replace:"/.*\[icon\]/":""}>" alt="<{$block.title|regex_replace:"/\[icon\].*/":""}>" title="<{$block.title|regex_replace:"/\[icon\].*/":""}>" align="absmiddle" hspace=2>
                <{$block.title|regex_replace:"/\[icon\].*/":""}>
            <{elseif $block.title|regex_replace:"/.*\[link\].*/":"Link True" == "Link True"}>
                <a href="<{$block.title|regex_replace:"/.*\[link\]/":""}>" alt="<{$block.title|regex_replace:"/\[link\].*/":""}>" title="<{$block.title|regex_replace:"/\[link\].*/":""}>"><{$block.title|regex_replace:"/\[link\].*/":""}></a>
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