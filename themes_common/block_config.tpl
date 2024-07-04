<{if $xoops_isadmin|default:false}>
    <a href="<{$xoops_url}>/modules/system/admin.php?fct=blocksadmin&op=edit&bid=<{$block.id}>" class="block_config"></a>
    <{if $block.module==''}>
        <a href="<{$xoops_url}>/modules/tad_blocks/index.php?op=block_form&bid=<{$block.id}>" data-toggle="tooltip" title="<{$smarty.const.TF_EDIT_bY_TAD_BLOCKS}>" class="tad_block_config"></a>
    <{/if}>
<{/if}>